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
    private function storeSecret(string $secret, ?int $expiresIn = null): void
    {
        Storage::disk('local')->put('pvit/secret.json', json_encode([
            'secret'      => trim($secret),
            'expires_in'  => $expiresIn,
            'received_at' => now()->toDateTimeString(),
        ], JSON_PRETTY_PRINT));
    }

    /** Lit la clé stockée */
    private function getSecret(): string
    {
        $file = 'pvit/secret.json';
        try {
            if (Storage::disk('local')->exists($file)) {
                return (string) (json_decode(Storage::disk('local')->get($file), true)['secret'] ?? '');
            }
        } catch (\Throwable $e) {
            Log::error('PVIT read secret error', ['err' => $e->getMessage()]);
        }
        return '';
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
            return back()->withErrors(['password' => 'Mot de passe requis'])->withInput();
        }

        $url = rtrim(self::PVIT_BASE, '/').'/'.self::RENEW_CODEURL.'/renew-secret';
        $payload = [
            'operationAccountCode' => self::ACCOUNT_CODE,
            'receptionUrlCode'     => self::RECEPTION_CODE,
            'password'             => $password,
        ];

        try {
            // Timeout raisonnable + accept JSON ; body en x-www-form-urlencoded (exigé par la doc)
            $resp = Http::asForm()
                ->acceptJson()
                ->timeout(20)
                ->post($url, $payload);
        } catch (\Throwable $e) {
            Log::error('PVIT renew-secret HTTP error', ['err' => $e->getMessage()]);
            return back()
                ->withErrors(['global' => "Impossible de joindre MyPVit : ".$e->getMessage()])
                ->withInput();
        }

        // Gestion fine des codes HTTP
        if ($resp->failed()) {
            $status = $resp->status();
            $body   = $resp->json() ?? $resp->body();
            Log::warning('PVIT renew-secret failed', ['status' => $status, 'body' => $body]);

            $msg = "Échec du renouvellement (HTTP $status).";
            if ($status === 401) {
                $msg = "Authentification échouée (401). Vérifie mot de passe marchand.";
            }
            if ($status === 415) {
                $msg = "Format invalide (415). Réessaye en x-www-form-urlencoded.";
            }
            if ($status === 429) {
                $msg = "Trop de requêtes (429). Réessaye dans quelques instants.";
            }

            return back()
                ->withErrors([
                    'global' => $msg,
                    'detail' => is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) : (string) $body,
                ])
                ->withInput();
        }

        // Succès : on informe la page, la clé arrivera via /api/pvit/receive-secret
        return redirect()
            ->route('pvit.secret')
            ->with('renew_ok', true)
            ->with('renew_response', $resp->json());
    }

    /** ENDPOINT : réception de la nouvelle clé (appelé par MyPVit) */
    public function receiveSecret(Request $request)
    {
        Log::info('PVIT RECEIVE-SECRET payload', $request->all());

        // Validation API (JSON ou form — on supporte les deux)
        $v = Validator::make($request->all(), [
            'operation_account_code' => 'required|string',
            'secret_key'             => 'required|string|min:10',
            'expires_in'             => 'nullable|integer|min:60',
        ]);

        if ($v->fails()) {
            return response()->json([
                'error'  => 'INVALID_PAYLOAD',
                'fields' => $v->errors(),
            ], 422);
        }

        // Contrôle du compte d’opération
        if ($request->input('operation_account_code') !== self::ACCOUNT_CODE) {
            Log::warning('PVIT RECEIVE-SECRET account mismatch', [
                'expected' => self::ACCOUNT_CODE,
                'got'      => $request->input('operation_account_code'),
            ]);
            return response()->json(['error' => 'ACCOUNT_MISMATCH'], 400);
        }

        $secret = (string) $request->input('secret_key', '');
        try {
            $this->storeSecret($secret, $request->integer('expires_in'));
        } catch (\Throwable $e) {
            Log::error('PVIT store secret error', ['err' => $e->getMessage()]);
            return response()->json(['error' => 'STORE_FAILED', 'message' => $e->getMessage()], 500);
        }

        // accusé de réception pour MyPVit
        return response()->json(['ok' => true]);
    }
}
