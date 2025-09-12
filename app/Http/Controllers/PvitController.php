<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // + validation API

class PvitController extends Controller
{
    // === Paramètres vus sur tes captures ===
    private const PVIT_BASE        = 'https://api.mypvit.pro';
    private const RENEW_CODEURL    = 'UGCEAAFRYROGTXPH';   // /UGCEAAFRYROGTXPH/renew-secret
    private const ACCOUNT_CODE     = 'ACC_68B6AA786474B';
    private const RECEPTION_CODE   = 'GH8CQ';              // URL: /api/pvit/receive-secret

    /** Stocke la clé côté serveur (pas dans .env) */
    // --- 1) CONFIG FICHIER ---
    private const SECRET_FILE = 'pvit/secret.v1.enc';   // contenu chiffré
    private const SECRET_BAK  = 'pvit/secret.bak';      // dernière version chiffrée

    private function ensureDir(): void
    {
        if (!Storage::disk('local')->exists('pvit')) {
            Storage::disk('local')->makeDirectory('pvit');
        }
    }

    // --- 2) ÉCRITURE SÉCURISÉE (chiffrée + backup) ---
    private function storeSecret(string $secret, ?int $expiresIn = null, ?string $sourceIp = null): void
    {
        $this->ensureDir();

        // Métadonnées utiles (date d’expiration approximative)
        $data = [
            'secret'      => trim($secret),
            'expires_in'  => $expiresIn,
            'expires_at'  => $expiresIn ? now()->addSeconds((int)$expiresIn)->toDateTimeString() : null,
            'received_at' => now()->toDateTimeString(),
            'source_ip'   => $sourceIp,
            'version'     => 1,
        ];

        // Chiffré avec APP_KEY (envoyer/consommer via encrypt/decrypt)
        $encrypted = encrypt(json_encode($data, JSON_UNESCAPED_SLASHES));

        // Backup de l’ancienne version si présente
        if (Storage::disk('local')->exists(self::SECRET_FILE)) {
            Storage::disk('local')->copy(self::SECRET_FILE, self::SECRET_BAK);
        }

        // Écriture atomique (temp puis move)
        $tmp = self::SECRET_FILE.'.tmp';
        Storage::disk('local')->put($tmp, $encrypted);
        Storage::disk('local')->move($tmp, self::SECRET_FILE);
    }

    // --- 3) LECTURE ROBUSTE (déchiffre ; rétro-compat plain JSON) ---
    private function getSecret(): string
    {
        try {
            if (!Storage::disk('local')->exists(self::SECRET_FILE)) {
                // rétro-compat: ancien fichier JSON non chiffré ?
                if (Storage::disk('local')->exists('pvit/secret.json')) {
                    $legacy = json_decode(Storage::disk('local')->get('pvit/secret.json'), true);
                    return (string)($legacy['secret'] ?? '');
                }
                return '';
            }
            $payload = Storage::disk('local')->get(self::SECRET_FILE);
            $decoded = json_decode(decrypt($payload), true);
            return (string)($decoded['secret'] ?? '');
        } catch (\Throwable $e) {
            Log::error('PVIT getSecret error', ['err' => $e->getMessage()]);
            return '';
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

        // 0) Normaliser les noms de champs (JSON ou form, snake_case ou camelCase)
        $opCode    = $request->input('operation_account_code', $request->input('operationAccountCode'));
        $secretKey = $request->input('secret_key', $request->input('secretKey'));
        $expiresIn = $request->input('expires_in', $request->input('expiresIn'));

        // 1) Validation "à la main" (pour accepter les deux notations)
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

        dd($opCode, $secretKey, $expiresIn);

        // 2) (Optionnel) Filtrage IP — active en mettant PVIT_CALLBACK_IPS="1.2.3.4,5.6.7.8" dans .env
        $allowIps = array_filter(array_map('trim', explode(',', (string) env('PVIT_CALLBACK_IPS'))));
        if (!empty($allowIps) && !in_array($request->ip(), $allowIps, true)) {
            Log::warning('PVIT RECEIVE-SECRET ip not allowed', ['ip' => $request->ip(), 'allow' => $allowIps]);
            return response()->json(['error' => 'IP_NOT_ALLOWED'], 403);
        }

        // 3) Contrôle du compte d’opération
        if ($opCode !== self::ACCOUNT_CODE) {
            Log::warning('PVIT RECEIVE-SECRET account mismatch', [
                'expected' => self::ACCOUNT_CODE, 'got' => $opCode,
            ]);
            return response()->json(['error' => 'ACCOUNT_MISMATCH'], 400);
        }

        // 4) Stockage sécurisé (chiffré + backup)
        try {
            $this->storeSecret((string)$secretKey, $expiresIn !== null ? (int)$expiresIn : null, $request->ip());
        } catch (\Throwable $e) {
            Log::error('PVIT store secret error', ['err' => $e->getMessage()]);
            return response()->json(['error' => 'STORE_FAILED', 'message' => $e->getMessage()], 500);
        }

        // 5) Accusé de réception OK (attendu par MyPVit)
        return response()->json(['ok' => true]);
    }

}
