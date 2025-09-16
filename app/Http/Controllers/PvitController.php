<?php

namespace App\Http\Controllers;

use App\Models\PvitSetting;
use App\Models\PvitSecretEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PvitController extends Controller
{
    private string $baseUrl = 'https://api.mypvit.pro';

    /** ====== VUES ====== */

    // Page paramètres + actions
    public function settingsForm()
    {
        $s = PvitSetting::one();
        return view('pvit.settings', compact('s'));
    }

    public function settingsSave(Request $request)
    {
        $data = $request->validate([
            'merchant_slug' => 'nullable|string',
            'operation_account_code' => 'required|string',
            'renew_password' => 'required|string',
            'codeurl_renew' => 'required|string',
            'codeurl_rest' => 'nullable|string',
            'codeurl_link' => 'nullable|string',
            'codeurl_balance' => 'nullable|string',
            'codeurl_status' => 'nullable|string',
            'callback_url_code' => 'nullable|string',
            'success_redirect_code' => 'nullable|string',
            'failed_redirect_code' => 'nullable|string',
            'secret_reception_code' => 'required|string',
        ]);

        PvitSetting::one()->update($data);
        return back()->with('success', 'Paramètres PVit enregistrés.');
    }

    /** ====== RENEW SECRET ====== */

    public function renewSecret(Request $request)
    {
        $s = PvitSetting::one();

        // Construction endpoint & payload (form-urlencoded)
        $endpoint = "{$this->baseUrl}/{$s->codeurl_renew}/renew-secret";

        $payload = [
            'operationAccountCode' => $s->operation_account_code,
            'receptionUrlCode'     => $s->secret_reception_code,
            'password'             => $s->renew_password,
        ];

        $res = Http::asForm()
            ->acceptJson()
            ->post($endpoint, $payload);

        if ($res->successful()) {
            $json = $res->json();
            // Ex: { "status_code":"200", "message":"Secret key generated and sent successfully" }
            return back()->with('success', $json['message'] ?? 'Renouvellement demandé. La nouvelle clé sera envoyée à l’URL de réception.');
        }

        return back()->with('error', "Erreur Renew Secret ({$res->status()}): ".$res->body());
    }

    /** ====== WEBHOOK: RÉCEPTION DE LA NOUVELLE CLÉ ====== */
    public function receiveSecret(Request $request, ?string $code = null)
    {
        $s = \App\Models\PvitSetting::one();

        // Récup payload (JSON ou x-www-form-urlencoded)
        $payload = $request->json()->all();
        if (empty($payload)) {
            $payload = $request->all(); // fallback si PVit envoie du form
        }

        // Journalisation complète pour debug
        \Log::info('[PVit] receive-secret raw', [
            'route_code_param' => $code,
            'headers' => $request->headers->all(),
            'raw'     => $request->getContent(),
            'parsed'  => $payload,
            'ip'      => $request->ip(),
        ]);

        // Vérif souple du code (si tu en as configuré un dans PvitSetting)
        $configured = $s->secret_reception_code;
        $incoming   = $code
                   ?? $request->header('X-Url-Code')
                   ?? ($payload['reception_url_code'] ?? $payload['receptionUrlCode'] ?? null);

        if ($configured && $incoming && strcasecmp($incoming, $configured) !== 0) {
            \Log::warning('[PVit] Reception code mismatch', ['expected' => $configured, 'got' => $incoming]);
            return response()->json(['message' => 'Invalid reception code'], 403);
        }

        // Normalisation des champs
        $operationAccountCode = $payload['operation_account_code'] ?? $payload['operationAccountCode'] ?? null;
        $secretKey            = $payload['secret_key']            ?? $payload['secretKey']            ?? null;
        $expiresIn            = $payload['expires_in']            ?? $payload['expiresIn']            ?? null;

        // Sauvegarde event
        $evt = \App\Models\PvitSecretEvent::create([
            'operation_account_code' => $operationAccountCode,
            'secret_key'             => $secretKey,
            'expires_in'             => $expiresIn ? intval($expiresIn) : null,
            'raw_payload'            => $payload,
        ]);

        // Mise à jour du secret courant
        if (!empty($secretKey)) {
            $s->current_secret = $secretKey;
            if (!empty($expiresIn)) {
                $s->secret_expires_at = \Illuminate\Support\Carbon::now()->addSeconds((int)$expiresIn);
            }
            $s->save();
        } else {
            \Log::warning('[PVit] receive-secret without secret_key', ['event_id' => $evt->id]);
        }

        // Accusé de réception (200 requis)
        return response()->json([
            'responseCode'  => 200,
            'transactionId' => 'RENEW_SECRET',
            'event_id'      => $evt->id,
        ], 200);
    }


    /** ====== LISTE DES SECRETS REÇUS (vue simple) ====== */
    public function secretsLog()
    {
        $events = PvitSecretEvent::latest()->paginate(15);
        return view('pvit.secrets_log', compact('events'));
    }
}