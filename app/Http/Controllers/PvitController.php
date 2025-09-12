<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        if (Storage::disk('local')->exists($file)) {
            return (string) (json_decode(Storage::disk('local')->get($file), true)['secret'] ?? '');
        }
        return '';
    }

    /** PAGE : formulaire pour générer la clé + affichage de la clé courante */
    public function secretPage()
    {
        $secret = $this->getSecret();
        $meta = null;
        if (Storage::disk('local')->exists('pvit/secret.json')) {
            $meta = json_decode(Storage::disk('local')->get('pvit/secret.json'), true);
        }
        return view('pvit.secret', [
            'secret' => $secret,
            'meta'   => $meta,
            'info'   => [
                'base'       => self::PVIT_BASE,
                'codeurl'    => self::RENEW_CODEURL,
                'account'    => self::ACCOUNT_CODE,
                'reception'  => self::RECEPTION_CODE,
                'endpoint'   => self::PVIT_BASE.'/'.self::RENEW_CODEURL.'/renew-secret',
            ],
            'renew_ok'  => session('renew_ok'),
            'renew_resp' => session('renew_response'),
        ]);
    }

    /** ACTION : déclenche le renew-secret (x-www-form-urlencoded) */
    public function renewSecretProxy(Request $request)
    {
        $password = (string) $request->input('password');
        if ($password === '') {
            return back()->withErrors(['password' => 'Mot de passe requis'])->withInput();
        }

        $resp = Http::asForm()->acceptJson()->post(
            rtrim(self::PVIT_BASE, '/').'/'.self::RENEW_CODEURL.'/renew-secret',
            [
                'operationAccountCode' => self::ACCOUNT_CODE,
                'receptionUrlCode'     => self::RECEPTION_CODE,
                'password'             => $password,
            ]
        );

        return redirect()
            ->route('pvit.secret')
            ->with('renew_ok', $resp->successful())
            ->with('renew_response', $resp->json());
    }

    /** ENDPOINT : réception de la nouvelle clé (appelé par MyPVit) */
    public function receiveSecret(Request $request)
    {
        Log::info('PVIT RECEIVE-SECRET payload', $request->all());

        $expected = self::ACCOUNT_CODE; // tu peux remplacer par env('PVIT_ACCOUNT_CODE') si tu préfères
        if ($request->input('operation_account_code') !== $expected) {
            return response()->json(['error' => 'ACCOUNT_MISMATCH'], 400);
        }

        $secret = (string) $request->input('secret_key', '');
        if ($secret === '') {
            return response()->json(['error' => 'MISSING_SECRET'], 400);
        }

        $this->storeSecret($secret, $request->integer('expires_in'));

        // accusé de réception pour MyPVit
        return response()->json(['ok' => true]);
    }
}
