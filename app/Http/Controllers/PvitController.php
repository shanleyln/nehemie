<?php

namespace App\Http\Controllers;

use App\Models\PvitSetting;
use App\Models\PvitSecretEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PvitController extends Controller
{
    private string $baseUrl = 'https://api.mypvit.pro';

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
}
