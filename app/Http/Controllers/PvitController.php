<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PvitController extends Controller
{
    /** Enregistre la clé reçue dans storage/app/pvit/secret.json */
    private function storeSecret(string $secret, ?int $expiresIn = null): void
    {
        Storage::disk('local')->put('pvit/secret.json', json_encode([
            'secret'      => trim($secret),
            'expires_in'  => $expiresIn,
            'received_at' => now()->toDateTimeString(),
        ], JSON_PRETTY_PRINT));
    }

    /** (on l’utilisera ensuite pour les paiements REST) */
    private function getSecret(): string
    {
        try {
            $path = 'pvit/secret.json';
            if (Storage::disk('local')->exists($path)) {
                $data = json_decode(Storage::disk('local')->get($path), true);
                return (string)($data['secret'] ?? '');
            }
        } catch (\Throwable $e) {
            Log::error('PVIT getSecret error', ['err' => $e->getMessage()]);
        }
        return '';
    }

    /** Endpoint déclaré chez MyPVit (Type: Réception de clé secrète) */
    public function receiveSecret(Request $request)
    {
        Log::info('PVIT RECEIVE-SECRET payload', $request->all());

        // Petite vérif du compte d’opération
        $expected = env('PVIT_ACCOUNT_CODE'); // ex: ACC_68B6AA786474B
        if ($request->input('operation_account_code') !== $expected) {
            return response()->json(['error' => 'ACCOUNT_MISMATCH'], 400);
        }

        $secret = (string)$request->input('secret_key', '');
        if ($secret === '') {
            return response()->json(['error' => 'MISSING_SECRET'], 400);
        }

        $this->storeSecret($secret, $request->integer('expires_in'));

        // Accusé de réception OK pour MyPVit
        return response()->json(['ok' => true]);
    }
}
