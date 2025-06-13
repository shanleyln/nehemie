{{-- Fichier : resources/views/emails/prayer-request.blade.php --}}
{{-- Version finale avec sujet/date stylisés en marron et pied de page minimaliste --}}

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intention de Prière</title>
</head>

<body
    style="margin: 0; padding: 0; width: 100%; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif; background-color: #f7f5f2;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0"
        style="background-color: #f7f5f2; padding: 20px 10px;">
        <tr>
            <td align="center">

                <!-- Fausse ombre -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td style="background-color: #d8d2c9; height: 10px; border-radius: 12px 12px 0 0;"></td>
                    </tr>
                </table>

                <!-- Conteneur principal -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 0 0 12px 12px;">

                    <!-- En-tête de couleur -->
                    <tr>
                        <td align="center" style="background-color: #5D4037; padding: 30px 25px;">
                            <img src="https://nehemie-international.com/images/logo2.png" alt="Logo Néhémie"
                                width="80" style="max-width: 80px; margin-bottom: 15px;">
                            <h1
                                style="margin: 0; font-size: 20px; font-weight: 500; color: #ffffff; text-align: center;">
                                Intention de Prière</h1>
                        </td>
                    </tr>

                    <!-- Section du contenu principal -->
                    <tr>
                        <td style="padding: 35px 25px;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                <!-- == DEBUT DE LA SECTION SUJET/DATE STYLISEE == -->
                                <!-- Bloc : Sujet -->
                                <tr>
                                    <td style="padding-bottom: 25px;">
                                        <div style="margin-bottom: 8px;">
                                            <span
                                                style="display: inline-block; padding: 4px 12px; background-color: #5D4037; color: #ffffff; border-radius: 5px; font-size: 12px; font-weight: bold; text-transform: uppercase;">Sujet</span>
                                        </div>
                                        <p style="margin: 0; font-size: 18px; color: #333333; line-height: 1.4;">
                                            {{ $userSubject }}</p>
                                    </td>
                                </tr>

                                <!-- Bloc : Date -->
                                <tr>
                                    <td style="padding-bottom: 25px;">
                                        <div style="margin-bottom: 8px;">
                                            <span
                                                style="display: inline-block; padding: 4px 12px; background-color: #5D4037; color: #ffffff; border-radius: 5px; font-size: 12px; font-weight: bold; text-transform: uppercase;">Date</span>

                                        </div>
                                        <p style="margin: 0; font-size: 18px; color: #848484; font-style: italic">
                                            {{ now()->format('d/m/Y à H:i') }}</p>
                                    </td>
                                </tr>
                                <!-- == FIN DE LA SECTION SUJET/DATE STYLISEE == -->

                                <!-- Bloc : Message -->
                                <tr>
                                    <td style="padding-top: 15px;">
                                        <div style="margin-bottom: 8px;">
                                            <span
                                                style="display: inline-block; padding: 4px 12px; background-color: #888888; color: #ffffff; border-radius: 5px; font-size: 12px; font-weight: bold; text-transform: uppercase;">Message</span>
                                        </div>
                                        <div
                                            style="margin-top: 8px; padding: 20px; background-color: #fdfdfd; border: 1px solid #eeeeee; border-radius: 8px; font-size: 16px; line-height: 1.7; color: #555555;">
                                            {!! nl2br(e($userMessage)) !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Pied de page minimaliste -->
                    <tr>
                        <td style="padding: 30px 25px;">
                            <hr style="border: 0; border-top: 1px solid #eeeeee;">
                            <p
                                style="margin: 30px 0 0 0; text-align: center; font-size: 12px; color: #999999; line-height: 1.5;">
                                © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.<br>
                                <a href="https://nehemie-international.com" target="_blank"
                                    style="color: #999999; text-decoration: underline;">nehemie-international.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
