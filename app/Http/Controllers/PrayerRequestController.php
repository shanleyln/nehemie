<?php

// Fichier : app/Http/Controllers/PrayerRequestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrayerRequestMail;
use Illuminate\Support\Facades\Log;

class PrayerRequestController extends Controller
{
    /**
     * Traite les données du formulaire et envoie l'e-mail.
     */
    public function store(Request $request)
    {
        // 1. Validate the request
        $validated = $request->validate([
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Définir les destinataires
        $recipientEmails = [
            "info@nehemie-international.com",
            "shanleylipeme00@gmail.com" ,
            // Ajoutez d'autres adresses email si nécessaire
        ];

        // 3. Essayer d'envoyer l'email
        try {
            $mail = new PrayerRequestMail($validated['sujet'], $validated['message']);

            // Envoyer à chaque destinataire individuellement
            foreach ($recipientEmails as $email) {
                Mail::to($email)->send($mail);
            }

            // Retourner une réponse de succès
            return response()->json([
                'success' => true,
                'message' => 'Votre demande de prière a bien été envoyée !'
            ]);

        } catch (\Exception $e) {
            // Log the error and return error response
            Log::error('Erreur envoi email de prière: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Une erreur technique est survenue. Votre demande n\'a pas pu être envoyée.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
