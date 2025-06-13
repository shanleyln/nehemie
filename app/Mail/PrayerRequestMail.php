<?php

// Fichier : app/Mail/PrayerRequestMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PrayerRequestMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    // Ces variables contiendront les données du formulaire
    public string $userSubject;
    public string $userMessage;

    /**
     * On récupère le sujet et le message pour les utiliser dans l'email.
     */
    public function __construct(string $userSubject, string $userMessage)
    {
        $this->userSubject = $userSubject;
        $this->userMessage = $userMessage;
    }

    /**
     * Définit le sujet de l'e-mail que VOUS allez recevoir.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de Prière',
        );
    }

    /**
     * Indique quel fichier "vue" utiliser pour le corps de l'e-mail.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.prayer-request',
        );
    }

    /**
     * Pour les pièces jointes (nous n'en avons pas besoin ici).
     */
    public function attachments(): array
    {
        return [];
    }
}
