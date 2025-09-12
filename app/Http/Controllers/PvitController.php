<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // + validation API
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PvitSecret;

class PvitController extends Controller
{
    // === Paramètres vus sur tes captures ===
    private const PVIT_BASE        = 'https://api.mypvit.pro';
    private const RENEW_CODEURL    = 'UGCEAAFRYROGTXPH';   // /UGCEAAFRYROGTXPH/renew-secret
    private const ACCOUNT_CODE     = 'ACC_68B6AA786474B';
    private const RECEPTION_CODE   = 'GH8CQ';              // URL: /api/pvit/receive-secret

    // --- Écrire la clé en base (chiffrée) ---
    private function storeSecret(string $secret, ?int $expiresIn = null, ?string $sourceIp = null): void
    {
        $account = self::ACCOUNT_CODE;
        $now = now();

        \Log::info('storeSecret called', [
            'account' => $account,
            'secret_length' => strlen($secret),
            'expires_in' => $expiresIn,
            'source_ip' => $sourceIp
        ]);

        try {
            // récupère (ou crée) l’enregistrement pour ce compte
            $row = PvitSecret::firstOrNew(['account_code' => $account]);

            // incrémente la version
            $version = ($row->exists ? (int)$row->version + 1 : 1);

            \Log::info('Updating secret row', [
                'exists' => $row->exists,
                'current_version' => $row->version,
                'new_version' => $version
            ]);

            $row->version     = $version;
            $row->received_at = $now;
            $row->expires_in  = $expiresIn;
            $row->expires_at  = $expiresIn ? $now->copy()->addSeconds((int)$expiresIn) : null;
            $row->source_ip   = $sourceIp;

            // attribut virtuel : chiffre vers secret_encrypted
            $row->secret = $secret;

            $saved = $row->save();

            if ($saved) {
                \Log::info('Secret saved successfully', [
                    'id' => $row->id,
                    'version' => $version
                ]);
            } else {
                \Log::error('Failed to save secret');
            }

        } catch (\Exception $e) {
            \Log::error('Error in storeSecret', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    // --- lire juste la clé depuis la DB (décryptée) ---
    private function getSecret(): ?string
    {
        try {
            $row = PvitSecret::account(self::ACCOUNT_CODE)->first();
            return $row?->secret;
        } catch (\Throwable $e) {
            \Log::error('PVIT getSecret model error', ['err' => $e->getMessage()]);
            return null;
        }
    }

    // --- lire les métadonnées pour l’affichage ---
    private function getSecretMeta(): ?array
    {
        try {
            $row = PvitSecret::account(self::ACCOUNT_CODE)->first();
            if (!$row) {
                return null;
            }

            return [
                'received_at' => optional($row->received_at)->toDateTimeString(),
                'expires_in'  => $row->expires_in,
                'expires_at'  => optional($row->expires_at)->toDateTimeString(),
                'source_ip'   => $row->source_ip,
                'version'     => (int)$row->version,
            ];
        } catch (\Throwable $e) {
            \Log::error('PVIT getSecretMeta model error', ['err' => $e->getMessage()]);
            return null;
        }
    }



    /** PAGE : formulaire pour générer la clé + affichage de la clé courante */
    public function secretPage()
    {
        $secret = $this->getSecret();     // <- vient de la DB
        $meta   = $this->getSecretMeta(); // <- vient de la DB

        return view('admin.pvit.secret', [
            'secret' => $secret,
            'meta'   => $meta,
            'info'   => [
                'base'      => self::PVIT_BASE,
                'codeurl'   => self::RENEW_CODEURL,
                'account'   => self::ACCOUNT_CODE,
                'reception' => self::RECEPTION_CODE,
                'endpoint'  => self::PVIT_BASE.'/'.self::RENEW_CODEURL.'/renew-secret',
            ],
            'renew_ok'   => session('renew_ok'),
            'renew_resp' => session('renew_response'),
        ]);
    }


    /** ACTION : déclenche le renew-secret (x-www-form-urlencoded) */
    public function renewSecretProxy(Request $request)
    {
        $password = (string) $request->input('password');
        if ($password === '') {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['ok' => false, 'error' => 'PASSWORD_REQUIRED'], 422);
            }
            return back()->withErrors(['password' => 'Mot de passe requis'])->withInput();
        }

        $url = rtrim(self::PVIT_BASE, '/').'/'.self::RENEW_CODEURL.'/renew-secret';
        $payload = [
            'operationAccountCode' => self::ACCOUNT_CODE,
            'receptionUrlCode'     => self::RECEPTION_CODE,
            'password'             => $password,
        ];

        try {
            $resp = Http::asForm()->acceptJson()->timeout(20)->post($url, $payload);
        } catch (\Throwable $e) {
            Log::error('PVIT renew-secret HTTP error', ['err' => $e->getMessage()]);
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'ok' => false,
                    'error' => 'NETWORK_ERROR',
                    'message' => $e->getMessage(),
                ], 502);
            }
            return back()->withErrors(['global' => "Impossible de joindre MyPVit : ".$e->getMessage()])->withInput();
        }

        $json = $resp->json();
        if (!is_array($json)) {
            $json = ['raw' => $resp->body()];
        }

        // Si la requête attend du JSON (fetch/AJAX) -> on renvoie JSON
        if ($request->wantsJson() || $request->ajax()) {
            $msg = null;
            if ($resp->status() === 401) {
                $msg = "Authentification échouée (401). Vérifie le mot de passe marchand.";
            }
            if ($resp->status() === 415) {
                $msg = "Format invalide (415). L’API attend x-www-form-urlencoded.";
            }
            if ($resp->status() === 429) {
                $msg = "Trop de requêtes (429). Réessaye plus tard.";
            }

            return response()->json([
                'ok'       => $resp->successful(),
                'status'   => $resp->status(),
                'message'  => $msg,
                'response' => $json
            ], $resp->status());
        }

        // Fallback "classique" : redirect + flash (si submit non-AJAX)
        return redirect()
            ->route('pvit.secret')
            ->with('renew_ok', $resp->successful())
            ->with('renew_response', $json);
    }



    /** ENDPOINT : réception de la nouvelle clé (appel MyPVit) */
    public function receiveSecret(Request $request)
    {
        dd($request->json());
        // Debug: Log the request
        \Log::info('PVIT RECEIVE-SECRET Endpoint Hit', [
            'method' => $request->method(),
            'full_url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'content_type' => $request->header('Content-Type'),
            'all_headers' => $request->headers->all()
        ]);

        Log::info('PVIT RECEIVE-SECRET payload', $request->all());

        // Normaliser noms des champs (JSON ou form)
        $opCode    = $request->input('operation_account_code', $request->input('operationAccountCode'));
        $secretKey = $request->input('secret_key', $request->input('secretKey'));
        $expiresIn = $request->input('expires_in', $request->input('expiresIn'));

        // Validation minimale
        $errors = [];
        if (!$opCode || !is_string($opCode)) {
            $errors['operation_account_code'][] = 'required';
        }
        if (!$secretKey || !is_string($secretKey) || strlen($secretKey) < 10) {
            $errors['secret_key'][] = 'invalid';
        }
        if ($expiresIn !== null && (!is_numeric($expiresIn) || (int)$expiresIn < 60)) {
            $errors['expires_in'][] = 'min:60';
        }
        if ($errors) {
            return response()->json(['error' => 'INVALID_PAYLOAD', 'fields' => $errors], 422);
        }

        // Optionnel : allowlist IP via .env PVIT_CALLBACK_IPS="1.2.3.4,5.6.7.8"
        $allowIps = array_filter(array_map('trim', explode(',', (string) env('PVIT_CALLBACK_IPS'))));
        if (!empty($allowIps) && !in_array($request->ip(), $allowIps, true)) {
            Log::warning('PVIT RECEIVE-SECRET ip not allowed', ['ip' => $request->ip(), 'allow' => $allowIps]);
            return response()->json(['error' => 'IP_NOT_ALLOWED'], 403);
        }

        // Compte d'opération attendu
        if ($opCode !== self::ACCOUNT_CODE) {
            Log::warning('PVIT RECEIVE-SECRET account mismatch', [
                'expected' => self::ACCOUNT_CODE, 'got' => $opCode,
            ]);
            return response()->json(['error' => 'ACCOUNT_MISMATCH'], 400);
        }

        // Stockage DB (chiffré) + versioning
        try {
            // Debug: Vérifier si le modèle est valide
            $debugModel = new PvitSecret();
            $debugModel->account_code = self::ACCOUNT_CODE;
            $debugModel->secret = $secretKey;
            $debugModel->expires_in = $expiresIn;
            $debugModel->received_at = now();

            Log::info('Debug Model Validation', [
                'isValid' => $debugModel->isValid(),
                'attributes' => $debugModel->getAttributes(),
                'fillable' => $debugModel->getFillable(),
                'table' => $debugModel->getTable()
            ]);

            $this->storeSecret((string)$secretKey, $expiresIn !== null ? (int)$expiresIn : null, $request->ip());

            // Vérifier si la clé a été sauvegardée
            $savedSecret = PvitSecret::where('account_code', self::ACCOUNT_CODE)->first();
            Log::info('After storeSecret - Database Check', [
                'exists' => $savedSecret !== null,
                'id' => $savedSecret ? $savedSecret->id : null,
                'version' => $savedSecret ? $savedSecret->version : null
            ]);

            // Si la requête vient d'un navigateur, on redirige vers le formulaire
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'ok' => true,
                    'debug' => [
                        'saved' => $savedSecret !== null,
                        'version' => $savedSecret ? $savedSecret->version : null
                    ],
                    'redirect' => route('pvit.secret')
                ]);
            }

            return redirect()
                ->route('pvit.secret')
                ->with('success', 'La clé secrète a été mise à jour avec succès')
                ->with('debug', [
                    'saved' => $savedSecret !== null,
                    'version' => $savedSecret ? $savedSecret->version : null
                ]);

        } catch (\Throwable $e) {
            Log::error('PVIT store secret DB error', [
                'err' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'STORE_FAILED',
                    'message' => $e->getMessage(),
                    'trace' => config('app.debug') ? $e->getTraceAsString() : null
                ], 500);
            }

            return redirect()
                ->route('pvit.secret')
                ->with('error', 'Erreur lors de la mise à jour de la clé: ' . $e->getMessage())
                ->with('error_details', config('app.debug') ? $e->getMessage() : null);
        }
    }

}
