<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // + validation API
use Illuminate\Support\Facades\DB;

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

        // calcule version (n+1 si existe)
        $current = DB::table('pvit_secrets')->where('account_code', $account)->first();
        $version = ($current->version ?? 0) + 1;

        $payload = [
            'account_code'     => $account,
            'secret_encrypted' => encrypt(trim($secret)),
            'expires_in'       => $expiresIn,
            'expires_at'       => $expiresIn ? $now->copy()->addSeconds((int)$expiresIn) : null,
            'received_at'      => $now,
            'source_ip'        => $sourceIp,
            'version'          => $version,
            'updated_at'       => $now,
        ];

        if ($current) {
            DB::table('pvit_secrets')->where('account_code', $account)->update($payload);
        } else {
            $payload['created_at'] = $now;
            DB::table('pvit_secrets')->insert($payload);
        }
    }

    // --- Lire juste la clé (déchiffrée) ---
    private function getSecret(): string
    {
        try {
            $row = DB::table('pvit_secrets')->where('account_code', self::ACCOUNT_CODE)->first();
            return $row ? decrypt($row->secret_encrypted) : '';
        } catch (\Throwable $e) {
            Log::error('PVIT getSecret DB error', ['err' => $e->getMessage()]);
            return '';
        }
    }

    // --- Lire les métadonnées (pour la page) ---
    private function getSecretMeta(): ?array
    {
        try {
            $row = DB::table('pvit_secrets')->where('account_code', self::ACCOUNT_CODE)->first();
            if (!$row) {
                return null;
            }
            return [
                'received_at' => (string)$row->received_at,
                'expires_in'  => $row->expires_in,
                'expires_at'  => $row->expires_at ? (string)$row->expires_at : null,
                'source_ip'   => $row->source_ip,
                'version'     => $row->version,
            ];
        } catch (\Throwable $e) {
            Log::error('PVIT getSecretMeta DB error', ['err' => $e->getMessage()]);
            return null;
        }
    }

    /** PAGE : formulaire pour générer la clé + affichage de la clé courante */
    public function secretPage()
    {
        $secret = $this->getSecret();
        $meta = null;
        try {
            if (Storage::disk('local')->exists('pvit/secret.json')) {
                $meta = json_decode(Storage::disk('local')->get('pvit/secret.json'), true);
            }
        } catch (\Throwable $e) {
            // On remonte l’info à l’UI via la session
            return back()->withErrors(['global' => "Impossible de lire le fichier de clé: ".$e->getMessage()]);
        }

        return view('admin.pvit.secret', [
            'secret'      => $secret,
            'meta'        => $meta,
            'info'        => [
                'base'       => self::PVIT_BASE,
                'codeurl'    => self::RENEW_CODEURL,
                'account'    => self::ACCOUNT_CODE,
                'reception'  => self::RECEPTION_CODE,
                'endpoint'   => self::PVIT_BASE.'/'.self::RENEW_CODEURL.'/renew-secret',
            ],
            'renew_ok'    => session('renew_ok'),
            'renew_resp'  => session('renew_response'),
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
            $this->storeSecret((string)$secretKey, $expiresIn !== null ? (int)$expiresIn : null, $request->ip());
        } catch (\Throwable $e) {
            Log::error('PVIT store secret DB error', ['err' => $e->getMessage()]);
            return response()->json(['error' => 'STORE_FAILED', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['ok' => true]);
    }

}
