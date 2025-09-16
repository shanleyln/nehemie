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
    public function receiveSecret(Request $request, string $code)
    {
        // Optionnel: vérifier que $code == $s->secret_reception_code
        $s = PvitSetting::one();
        if ($code !== $s->secret_reception_code) {
            return response()->json(['message' => 'Invalid reception code'], 403);
        }

        // Le fournisseur envoie un JSON de ce type:
        // { "operation_account_code": "...", "secret_key":"sk_live_xxx", "expires_in": 3600 }
        $payload = $request->json()->all();

        // Persistons l’événement complet
        $evt = PvitSecretEvent::create([
            'operation_account_code' => $payload['operation_account_code'] ?? null,
            'secret_key'             => $payload['secret_key'] ?? null,
            'expires_in'             => $payload['expires_in'] ?? null,
            'raw_payload'            => $payload,
        ]);

        // Mettre à jour le secret courant pour toutes les requêtes futures
        if (!empty($payload['secret_key'])) {
            $s->current_secret = $payload['secret_key'];
            // Calcul expiration si fournie (en secondes)
            if (!empty($payload['expires_in'])) {
                $s->secret_expires_at = Carbon::now()->addSeconds(intval($payload['expires_in']));
            }
            $s->save();
        }

        // Répondre 200 pour confirmer la réception (bonne pratique)
        return response()->json([
            'status' => 'OK',
            'event_id' => $evt->id,
        ], 200);
    }

    /** ====== LISTE DES SECRETS REÇUS (vue simple) ====== */
    public function secretsLog()
    {
        $events = PvitSecretEvent::latest()->paginate(15);
        return view('pvit.secrets_log', compact('events'));
    }
}