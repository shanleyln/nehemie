<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\PvitSecret;

class PVitController extends Controller
{
    /**
     * Configuration PVit (à déplacer dans config/services.php en production)
     */
    protected function getConfig()
    {
        return [
            'base_url' => 'https://api.mypvit.pro/MR_1756801656/rest',
            'secret_key' => 'sk_test_ba60defe-e26d-49d6-97fa-a66c9c88f2a4',
            'merchant_account' => 'MR_1756801656',
            'callback_code' => 'GP7VJ', // Code de callback pour l'URL de notification
            'success_redirect' => 'https://nehemie-international.com/paiement/succes',
            'fail_redirect' => 'https://nehemie-international.com/paiement/echec',
            'receive_secret_url' => 'https://nehemie-international.com/api/pvit/receive-secret',
            'api_base_url' => 'https://api.mypvit.pro',
            'slug_marchand' => 'MR_1756801656',
            'api_key' => 'ACC_68B6AA786474B' // Clé API de test
        ];
    }

    /**
     * Initialise un nouveau paiement via PVit
     */
    public function initierPaiement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'montant' => ['required', 'numeric', 'min:150', 'max:1000000'],
            'telephone' => ['required', 'string', 'regex:/^(\+241|00241|0)?[0-9]{8,9}$/'],
            'email' => ['nullable', 'email'],
            'nom' => ['nullable', 'string', 'max:100']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $pvitConfig = $this->getConfig();

        // Nettoyer le numéro de téléphone
        $telephone = preg_replace('/^(\+241|00241|0)/', '241', $validated['telephone']);

        // Générer une référence unique
        $reference = 'NEM-' . time() . '-' . Str::random(6);

        // Préparation des données pour PVit
        $requestData = [
            'amount' => (float) $validated['montant'],
            'reference' => $reference,
            'service' => 'RESTFUL',
            'callback_url_code' => $pvitConfig['callback_code'],
            'customer_account_number' => $telephone,
            'merchant_operation_account_code' => $pvitConfig['merchant_account'],
            'transaction_type' => 'PAYMENT',
            'owner_charge' => 'CUSTOMER',
            'operator_owner_charge' => 'MERCHANT',
            'product' => 'DON_NEMIE',
            'description' => 'Don à l\'ONG Nehemie',
            'customer_name' => $validated['nom'] ?? 'Donateur anonyme',
            'customer_email' => $validated['email'] ?? 'don@nehemie.org',
            'customer_phone_number' => $telephone
        ];

        try {
            // Initialisation de cURL pour PVit
            $ch = curl_init($pvitConfig['base_url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'X-Secret: ' . $pvitConfig['secret_key'],
                'X-Callback-MediaType: application/json',
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            // Vérification de la réponse
            if ($http_code !== 200 || !$response) {
                Log::error('Erreur PVit', [
                    'code' => $http_code,
                    'error' => $error,
                    'response' => $response,
                    'request' => $requestData
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la communication avec le service de paiement. Veuillez réessayer.'
                ], 500);
            }

            $responseData = json_decode($response, true);

            if (!isset($responseData['status']) || $responseData['status'] !== 'PENDING') {
                Log::error('Échec PVit', [
                    'response' => $responseData,
                    'request' => $requestData
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de l\'initialisation du paiement: ' . ($responseData['message'] ?? 'Erreur inconnue')
                ], 400);
            }

            // Enregistrement de la transaction
            $transaction = new Transaction();
            $transaction->id = (string) Str::uuid();
            $transaction->reference = $reference;
            $transaction->montant = $validated['montant'];
            $transaction->telephone = $telephone;
            $transaction->email = $validated['email'] ?? null;
            $transaction->nom = $validated['nom'] ?? null;
            $transaction->status = 'en_attente';
            $transaction->operator_reference = $responseData['reference_id'] ?? null;
            $transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Paiement initialisé avec succès',
                'data' => [
                    'reference' => $reference,
                    'status_url' => route('api.pvit.verifier', $reference)
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Exception PVit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur inattendue est survenue: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gestion du callback PVit
     */
    public function handleCallback(Request $request)
    {
        $data = $request->all();
        Log::info('Callback PVit reçu:', $data);

        // Valider la signature si nécessaire
        // À implémenter selon la documentation PVit

        // Mettre à jour la transaction
        $transaction = Transaction::where('reference', $data['merchantReferenceId'] ?? null)
            ->orWhere('operator_reference', $data['transactionId'] ?? null)
            ->first();

        if ($transaction) {
            $transaction->update([
                'status' => strtolower($data['status'] ?? 'inconnu'),
                'frais' => $data['fees'] ?? 0,
                'operator' => $data['operator'] ?? null,
                'operator_reference' => $data['transactionId'] ?? $transaction->operator_reference,
                'updated_at' => now()
            ]);

            // Envoyer un email de confirmation si le paiement est réussi
            if (strtolower($data['status'] ?? '') === 'success') {
                // À implémenter : Envoyer un email de confirmation
                // Mail::to($transaction->email)->send(new PaymentConfirmation($transaction));
            }

            Log::info('Transaction mise à jour', [
                'reference' => $transaction->reference,
                'status' => $transaction->status,
                'data' => $data
            ]);
        } else {
            Log::warning('Transaction non trouvée pour le callback', [
                'merchantReferenceId' => $data['merchantReferenceId'] ?? null,
                'transactionId' => $data['transactionId'] ?? null,
                'data' => $data
            ]);
        }

        // Répondre à PVit
        return response()->json([
            'responseCode' => 200,
            'responseMessage' => 'Notification reçue avec succès',
            'transactionId' => $data['transactionId'] ?? null
        ]);
    }

    /**
     * Vérifie le statut d'un paiement
     */
    public function verifierStatut($reference)
    {
        $transaction = Transaction::where('reference', $reference)
            ->orWhere('operator_reference', $reference)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'reference' => $transaction->reference,
                'status' => $transaction->status,
                'montant' => $transaction->montant,
                'date' => $transaction->updated_at->format('d/m/Y H:i')
            ]
        ]);
    }

    /**
     * Page de succès du paiement
     */
    public function success($reference)
    {
        $transaction = Transaction::where('reference', $reference)
            ->orWhere('operator_reference', $reference)
            ->firstOrFail();

        return view('paiement.resultat', [
            'transaction' => $transaction,
            'message' => 'Paiement effectué avec succès',
            'type' => 'success'
        ]);
    }

    /**
     * Page d'échec du paiement
     */
    public function echec($reference)
    {
        $transaction = Transaction::where('reference', $reference)
            ->orWhere('operator_reference', $reference)
            ->firstOrFail();

        return view('paiement.resultat', [
            'transaction' => $transaction,
            'message' => 'Le paiement a échoué',
            'type' => 'error'
        ]);
    }

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

            // Préparer les données de réponse
            $responseData = [
                'operation_account_code' => self::ACCOUNT_CODE,
                'secret_key' => $secretKey, // Attention: À utiliser avec précaution en production
                'expires_in' => (int)$expiresIn,
                'expires_at' => $expiresIn ? now()->addSeconds((int)$expiresIn)->toDateTimeString() : null,
                'received_at' => now()->toDateTimeString(),
                'version' => $savedSecret ? $savedSecret->version : null
            ];

            // Si la requête vient d'une API (JSON)
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'ok' => true,
                    'data' => $responseData
                ]);
            }

            // Pour les requêtes navigateur standard
            return redirect()
                ->route('pvit.secret')
                ->with('success', 'La clé secrète a été mise à jour avec succès')
                ->with('data', $responseData);

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