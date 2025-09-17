<?php

namespace App\Http\Controllers;

use App\Models\PvitSetting;
use App\Models\PvitSecretEvent;
use App\Models\PvitTransaction;
use App\Models\PvitCallback;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PvitController extends Controller
{
    private string $baseUrl = 'https://api.mypvit.pro';

    // Génère une référence marchande unique (≤ 15 chars)
    private function generateMerchantReference(): string
    {
        // 1) Tentative: "REF" + ymdHis = 15 chars (ex: REF250917162530)
        $base = now()->format('ymdHis'); // 12
        $candidate = 'REF' . $base;      // 3 + 12 = 15
        if (! $this->referenceExists($candidate)) {
            return $candidate;
        }

        // 2) Tentative: "RE" + ymdHis + 1 hex = 15
        $candidate = 'RE' . $base . dechex(random_int(0, 15));
        if (! $this->referenceExists($candidate)) {
            return strtoupper($candidate);
        }

        // 3) Tentative: "R" + ymdHis + 2 hex = 15
        $candidate = 'R' . $base . dechex(random_int(0, 15)) . dechex(random_int(0, 15));
        if (! $this->referenceExists($candidate)) {
            return strtoupper($candidate);
        }

        // 4) Dernières tentatives (rare) : petite boucle avec jitter
        for ($i = 0; $i < 5; $i++) {
            usleep(200_000); // 200ms
            $base = now()->format('ymdHis');
            $candidate = 'R' . $base . dechex(random_int(0, 15)) . dechex(random_int(0, 15));
            if (! $this->referenceExists($candidate)) {
                return strtoupper($candidate);
            }
        }

        throw new \RuntimeException('Impossible de générer une référence unique (15 chars).');
    }

    private function referenceExists(string $ref): bool
    {
        return \App\Models\PvitTransaction::where('reference', $ref)->exists();
    }


    /** ==================== VUES ==================== */

    public function settingsForm()
    {
        $s = PvitSetting::one();
        return view('pvit.settings', compact('s'));
    }

    public function settingsSave(Request $request)
    {
        $data = $request->validate([
            'merchant_slug'            => 'nullable|string',
            'merchant_operation_account_code'   => 'required|string',
            'renew_password'           => 'required|string',
            'codeurl_renew'            => 'required|string',
            'codeurl_rest'             => 'nullable|string',
            'codeurl_link'             => 'nullable|string',
            'codeurl_balance'          => 'nullable|string',
            'codeurl_status'           => 'nullable|string',
            'callback_url_code'        => 'nullable|string',
            'success_redirect_code'    => 'nullable|string',
            'failed_redirect_code'     => 'nullable|string',
            'secret_reception_code'    => 'required|string',
        ]);

        PvitSetting::one()->update($data);

        return back()->with('success', 'Paramètres PVit enregistrés.');
    }

    /** ==================== RENEW SECRET (depuis UI) ==================== */

    public function renewSecret(Request $request)
    {
        $s = PvitSetting::one();

        // Garde-fous : éviter un renew sans infos minimales
        foreach (['merchant_operation_account_code','codeurl_renew','renew_password','secret_reception_code'] as $k) {
            if (empty($s->{$k})) {
                return back()->with('error', "Paramètre manquant: {$k}. Enregistre d'abord les paramètres.");
            }
        }

        Log::info('[PVit] renew-secret clicked from settings');

        $endpoint = "{$this->baseUrl}/{$s->codeurl_renew}/renew-secret";
        $payload = [
            'operationAccountCode' => $s->merchant_operation_account_code,
            'receptionUrlCode'     => $s->secret_reception_code,
            'password'             => $s->renew_password,
        ];

        $res = Http::asForm()->acceptJson()->post($endpoint, $payload);

        if ($res->successful()) {
            $json = $res->json();
            return back()->with('success', $json['message'] ?? 'Renouvellement demandé. La nouvelle clé sera envoyée à l’URL de réception.');
        }

        return back()->with('error', "Erreur Renew Secret ({$res->status()}): ".$res->body());
    }

    /** ==================== WEBHOOK: RÉCEPTION DE LA CLÉ ==================== */

    // $code est optionnel pour accepter .../receive-secret ET .../receive-secret/{code}
    public function receiveSecret(Request $request, string $code)
    {
        $s = \App\Models\PvitSetting::one();

        // 1) Vérifier que le code reçu dans l'URL correspond à celui stocké
        if (! $s->secret_reception_code) {
            \Log::warning('[PVit] secret_reception_code is not set in settings');
            return response()->json(['message' => 'Reception code not configured'], 500);
        }
        if (strcasecmp($code, $s->secret_reception_code) !== 0) {
            \Log::warning('[PVit] Reception code mismatch', ['expected' => $s->secret_reception_code, 'got' => $code]);
            return response()->json(['message' => 'Invalid reception code'], 403);
        }

        // 2) Récup payload (JSON prioritaire, fallback form-urlencoded)
        $payload = $request->json()->all();
        if (empty($payload)) {
            $payload = $request->all();
        }

        // 3) Log debug utile
        \Log::info('[PVit] receive-secret raw', [
            'url_code' => $code,
            'headers'  => $request->headers->all(),
            'raw'      => $request->getContent(),
            'parsed'   => $payload,
            'ip'       => $request->ip(),
        ]);

        // 4) Normalise les clés
        $operationAccountCode = $payload['merchant_operation_account_code'] ?? $payload['operationAccountCode'] ?? null;
        $secretKey            = $payload['secret_key']            ?? $payload['secretKey']            ?? null;
        $expiresIn            = $payload['expires_in']            ?? $payload['expiresIn']            ?? null;

        // 5) Trace en base
        $evt = \App\Models\PvitSecretEvent::create([
            'merchant_operation_account_code' => $operationAccountCode,
            'secret_key'             => $secretKey,
            'expires_in'             => $expiresIn ? (int) $expiresIn : null,
            'raw_payload'            => $payload,
        ]);

        // 6) Met à jour le secret courant
        if ($secretKey) {
            $s->current_secret = $secretKey;
            if ($expiresIn) {
                $s->secret_expires_at = \Illuminate\Support\Carbon::now()->addSeconds((int) $expiresIn);
            }
            $s->save();
        } else {
            \Log::warning('[PVit] receive-secret without secret_key', ['event_id' => $evt->id]);
        }

        // 7) Accusé de réception (obligatoire)
        return response()->json([
            'responseCode'  => 200,
            'transactionId' => 'RENEW_SECRET',
            'event_id'      => $evt->id,
        ], 200);
    }


    /** ==================== JOURNAL (vue) ==================== */

    public function secretsLog()
    {
        $events = PvitSecretEvent::latest()->paginate(15);
        return view('pvit.secrets_log', compact('events'));
    }


    //******************************************************************************************* */
    // ==== Helpers privés ====
    private function mustHaveSecret(): string
    {
        $s = PvitSetting::one();
        if (empty($s->current_secret)) {
            abort(400, "X-Secret absent : renouvelez d'abord la clé depuis /pvit/settings.");
        }
        return $s->current_secret;
    }

    /** ==================== UI : Formulaires ==================== */
    public function transactionsForm()
    {
        $s = PvitSetting::one();
        return view('pvit.transactions', compact('s'));
    }


    /** ==================== LINK API (WEB / VISA_MASTERCARD / RESTLINK) ==================== */
    public function linkInit(Request $request)
    {
        $s = PvitSetting::one();
        $secret = $this->mustHaveSecret();

        $data = $request->validate([
          'service'                    => 'required|in:WEB,VISA_MASTERCARD,RESTLINK',
          'amount'                     => 'required|numeric|min:150',
          'reference'                  => 'nullable|string|max:15',
          'customer_account_number'    => 'nullable|string|max:20', // requis pour VISA_MASTERCARD / RESTLINK
          'agent'                      => 'nullable|string|max:64',
          'product'                    => 'nullable|string|max:64',
          'owner_charge'               => 'required|in:MERCHANT,CUSTOMER',
          'operator_owner_charge'      => 'nullable|in:MERCHANT,CUSTOMER',
          'free_info'                  => 'nullable|string|max:255',
        ]);
        // Si pas de référence fournie, on en génère une
        $reference = $data['reference'] ?: $this->generateMerchantReference();

        // Forcer le numéro client si VISA_MASTERCARD ou RESTLINK
        if (in_array($data['service'], ['VISA_MASTERCARD','RESTLINK']) && empty($data['customer_account_number'])) {
            return back()->with('error', 'customer_account_number est requis pour VISA_MASTERCARD et RESTLINK.');
        }

        $payload = [
          'agent'                        => $data['agent'] ?? null,
          'amount'                       => (float)$data['amount'],
          'product'                      => $data['product'] ?? null,
          'reference'                    => $reference,
          'service'                      => $data['service'],
          'callback_url_code'            => $s->callback_url_code,
          'customer_account_number'      => $data['customer_account_number'] ?? null,
          'merchant_operation_account_code' => $s->merchant_operation_account_code,
          'transaction_type'             => 'PAYMENT',
          'owner_charge'                 => $data['owner_charge'],
          'operator_owner_charge'        => $data['operator_owner_charge'] ?? null,
          'free_info'                    => $data['free_info'] ?? null,
          'failed_redirection_url_code'  => $s->failed_redirect_code,
          'success_redirection_url_code' => $s->success_redirect_code,
        ];

        $endpoint = "{$this->baseUrl}/{$s->codeurl_link}/link";

        $res = Http::withHeaders([
                'X-Secret' => $secret,
                'X-Callback-MediaType' => 'application/json',
              ])->acceptJson()
              ->post($endpoint, $payload);

        PvitTransaction::create([
          'request_type'  => 'LINK',
          'service'       => $data['service'],
          'transaction_type' => 'PAYMENT',
          'reference'     => $reference,
          'amount'        => $data['amount'],
          'customer_account_number' => $data['customer_account_number'] ?? null,
          'owner_charge'  => $data['owner_charge'],
          'operator_owner_charge' => $data['operator_owner_charge'] ?? null,
          'merchant_operation_account_code' => $s->merchant_operation_account_code,
          'request_payload' => $payload,
          'response_payload' => $res->json(),
          'status'        => $res->json('status'),
          'reference_id'  => $res->json('merchant_reference_id'),
        ]);

        if ($res->status() === 401) {
            return back()->with('error', '401 Unauthorized — Clé expirée. Renouvelle la clé et réessaie.');
        }

        // On repasse la référence auto-générée à la vue pour faciliter le "STATUS"
        return back()->with('success', 'Lien de paiement généré.')
        ->with('pvit_link_response', ($res->json() ?? []) + ['_merchant_reference' => $reference]);

    }

    /** ==================== STATUS (GET) ==================== */
    public function statusCheck(Request $request)
    {
        $s = PvitSetting::one();
        $secret = $this->mustHaveSecret();

        $data = $request->validate([
          'transactionId'         => 'required|string|max:32', // ta référence (ex: REF13090141)
          'transactionOperation'  => 'required|in:PAYMENT,GIVE_CHANGE',
        ]);

        $endpoint = "{$this->baseUrl}/{$s->codeurl_status}/status";
        $query = [
          'transactionId'       => $data['transactionId'],
          'accountOperationCode' => $s->merchant_operation_account_code,
          'transactionOperation' => $data['transactionOperation'],
        ];

        $res = Http::withHeaders(['X-Secret' => $secret])->acceptJson()->get($endpoint, $query);

        if ($res->status() === 401) {
            return back()->with('error', '401 Unauthorized — Clé expirée. Renouvelle la clé et réessaie.');
        }

        return back()->with('success', 'Statut récupéré.')
                     ->with('pvit_status_response', $res->json());
    }

    /** ==================== BALANCE (GET) ==================== */
    public function balanceCheck(Request $request)
    {
        $s = \App\Models\PvitSetting::one();
        $secret = $this->mustHaveSecret();

        // Garde-fous : évite un appel incomplet
        if (empty($s->codeurl_balance)) {
            return back()->with('error', 'CodeURL Balance manquant. Renseigne-le dans /pvit/settings.');
        }
        if (empty($s->merchant_operation_account_code)) {
            return back()->with('error', 'Operation Account Code manquant. Renseigne ACC_xxx dans /pvit/settings.');
        }

        $query = ['accountOperationCode' => $s->merchant_operation_account_code];

        // Construit explicitement l’URL avec le query string
        $url = "{$this->baseUrl}/{$s->codeurl_balance}/balance?" . http_build_query($query);

        \Log::info('[PVit] BALANCE request', [
            'url'   => $url,
            'query' => $query,
            'secret_set' => !empty($secret),
        ]);

        // Envoie la requête GET sur l’URL finalisée
        $res = \Illuminate\Support\Facades\Http::withHeaders([
                'X-Secret' => $secret,
            ])->acceptJson()->get($url);

        if ($res->status() === 401) {
            return back()->with('error', '401 Unauthorized — Clé expirée. Renouvelle la clé puis réessaie.');
        }

        // Trace la réponse pour debug si besoin
        \Log::info('[PVit] BALANCE response', ['status' => $res->status(), 'body' => $res->json()]);

        return back()->with('success', 'Solde récupéré.')
                     ->with('pvit_balance_response', $res->json());
    }


    /** ==================== CALLBACK Paiement (obligatoire) ==================== */
    public function paymentCallback(Request $request)
    {
        // PVit envoie un JSON:
        // {
        //   "transactionId": "...",
        //   "merchantReferenceId": "REF123456",
        //   "status": "SUCCESS",
        //   "amount": 200.0,
        //   "customerID": "066820866",
        //   "fees": 5.0,
        //   "chargeOwner": "CUSTOMER",
        //   "transactionOperation": "PAYMENT",
        //   "operator": "MOOV_MONEY",
        //   "code": 200
        // }
        $payload = $request->json()->all() ?: $request->all();

        \Log::info('[PVit] payment-callback raw', [
          'headers' => $request->headers->all(),
          'raw'     => $request->getContent(),
          'parsed'  => $payload,
          'ip'      => $request->ip(),
        ]);

        PvitCallback::create([
          'transaction_id'         => $payload['transactionId'] ?? null,
          'merchant_reference_id'  => $payload['merchantReferenceId'] ?? null,
          'status'                 => $payload['status'] ?? null,
          'amount'                 => $payload['amount'] ?? null,
          'fees'                   => $payload['fees'] ?? null,
          'charge_owner'           => $payload['chargeOwner'] ?? null,
          'transaction_operation'  => $payload['transactionOperation'] ?? null,
          'operator'               => $payload['operator'] ?? null,
          'raw_payload'            => $payload,
        ]);

        // Accusé de réception requis
        return response()->json([
          'responseCode'  => (int)($payload['code'] ?? 200),
          'transactionId' => $payload['transactionId'] ?? null,
        ], 200);
    }
}