<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    //


    public function valider(Request $request)
    {
        $request->validate([
            'montant' => ['required', 'numeric', 'min:100', 'max:100000000000000000000000000000000'],
        ]);

        // Chiffrer le montant pour sécuriser le transport dans l'URL
        $token = Crypt::encrypt($request->montant);

        // Rediriger vers la page de confirmation avec token chiffré
        return redirect()->route('paiement.confirmer', ['token' => $token])
            ->with('success', 'Merci de confirmer votre paiement.');
    }

    public function confirmer($token)
    {

        $montant = Crypt::decrypt($token); // 🔓 Déchiffrer le montant



        // Configuration API SingPay
        // $client_id = "2dc530ba-f3b5-4951-a832-3f3fc91ad2a6";
        // $client_secret = "bf68c6a3b77e093a035fdc28b9f9e7664927a887ffda4343d608e35f5732a295";
        // $portefeuille = "65c0abbc2862fef2771839b8";
        // $logo = "https://nehemie-international.com/img/logo2.png";
        // $disbursement = "65c208d42862fe0e10183e17";

        $client_id = "6993befa-494a-473f-b7ac-a6de7f8465d6";
        $client_secret = "144ee596776269b5e4534e3ea1f36884781a24e4b3c8d20e6c960817592e3bbc";
        $portefeuille = "68357017c1b8924dcbf2739a";
        $logo = "data:image/jpeg;base64,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";
        $disbursement = "6835b55ec1b8923e90f2ebec";
        // Générer une référence unique
        $reference = 'REF-' . strtoupper(Str::random(10));
        // dd($reference); // Pour débogage, à retirer en production

        // URLs de redirection
        $callback_success = route('paiement.confirme.finaliser', ['ref' => $reference]);
        $callback_error = route('paiement.echouer', ['ref' => $reference]);

        // Appel API SingPay via cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://gateway.singpay.ga/v1/ext");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'portefeuille' => $portefeuille,
            'reference' => $reference,
            'redirect_success' => $callback_success,
            'redirect_error' => $callback_error,
            'amount' => $montant,
            'logoURL' => $logo,
            'disbursement' => $disbursement,
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'x-client-id:' . $client_id,
            'x-client-secret:' . $client_secret,
            'x-wallet:' . $portefeuille,
            'accept: */*',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CAINFO, base_path('certs/cer.crt'));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Vérification
        if ($http_code !== 200 || !$response) {
            return back()->withErrors(['paiement' => 'Erreur lors de la communication avec SingPay: ' . $error]);
        }

        $data = json_decode($response, true);
        $lienPaiement = $data['link'] ?? null;

        if (!$lienPaiement) {
            return back()->withErrors(['paiement' => 'Aucun lien de paiement retourné.']);
        }
        $Transaction = new Transaction();
        $Transaction->id = (string) Str::uuid(); // Générer un UUID pour la transaction
        $Transaction->reference = $reference;
        $Transaction->montant = $montant;
        $Transaction->status = 'en_attente'; // Statut initial
        $Transaction->save(); // Enregistrer la transaction dans la base de données

        // Affichage dans la vue
        return view('confirme_payment', [
            'montant' => $montant,
            'lienPaiement' => $lienPaiement,
            'reference' => $reference,
        ]);
    }
    public function finaliser($ref)
    {
        $transaction = Transaction::where('reference', $ref)->firstOrFail();
        $transaction->update(['status' => 'succes']);

        return redirect()->route('index')
            ->with('success', 'Le paiement de ' . number_format($transaction->montant, 0, ',', ' ') . ' FCFA a été réalisé avec succès.');
    }

    public function echouer($ref)
    {
        $transaction = Transaction::where('reference', $ref)->first();
        if ($transaction) {
            $transaction->update(['status' => 'echec']);
        }

        // Rediriger vers la page d'accueil avec un message d'erreur
        return redirect()->route('index')
            ->with('error', 'Le paiement de ' . number_format($transaction->montant, 0, ',', ' ') . ' a échoué. Veuillez réessayer ou vérifier vos informations.');
    }
}