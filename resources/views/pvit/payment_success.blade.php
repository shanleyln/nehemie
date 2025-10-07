<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi - Nehemie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
        }

        body {
            background-color: var(--light-color);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .checkmark-circle {
            width: 100px;
            height: 100px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin: 0 auto 1.5rem;
        }

        .checkmark-circle .background {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--success-color);
            position: absolute;
            opacity: 0.1;
            top: 0;
            left: 0;
        }

        .checkmark-circle .checkmark {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .checkmark-circle .checkmark:after {
            content: '';
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            width: 25px;
            height: 50px;
            border: solid var(--success-color);
            border-width: 0 6px 6px 0;
            transform: translate(-50%, -50%) rotate(45deg);
            opacity: 0;
            animation: checkmark 0.6s ease-in-out 0.4s forwards;
        }

        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 0;
            }

            20% {
                height: 0;
                width: 25px;
                opacity: 1;
            }

            40% {
                height: 50px;
                width: 25px;
                opacity: 1;
            }

            100% {
                height: 50px;
                width: 25px;
                opacity: 1;
            }
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            margin: 1.5rem 0;
        }

        .alert {
            border-left: 4px solid var(--primary-color);
            border-radius: 0.5rem;
        }

        .countdown-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-lg">
                        <div class="card-body p-4 p-md-5 text-center">
                            <!-- Animation de succès -->
                            <div class="mb-4">
                                <div class="checkmark-circle">
                                    <div class="background"></div>
                                    <div class="checkmark"></div>
                                </div>
                            </div>

                            <!-- Titre et message -->
                            <h2 class="mb-3 fw-bold" style="color: var(--primary-color);">Paiement Réussi !</h2>
                            <p class="text-muted mb-4 fs-5">Merci pour votre don. Votre paiement a été traité avec
                                succès.</p>

                            <!-- Référence de paiement -->
                            @if (!empty($reference))
                                <div class="alert alert-light text-start mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-receipt me-3"
                                            style="font-size: 1.5rem; color: var(--primary-color);"></i>
                                        <div>
                                            <h6 class="mb-0">Référence de paiement</h6>
                                            <p class="mb-0 fw-bold">{{ $reference }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Compte à rebours et bouton -->
                            <div class="mt-4">
                                <div class="progress">
                                    <div id="countdown-progress" class="progress-bar bg-success" role="progressbar"
                                        style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <p id="countdown-text" class="countdown-text">Fermeture automatique dans 1:00</p>

                                <button onclick="window.close()" class="btn btn-primary px-4 py-2 mt-3">
                                    <i class="fas fa-home me-2"></i>Retour à l'accueil
                                </button>
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="mt-4 pt-3 border-top">
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Vous serez redirigé automatiquement vers la page d'accueil dans quelques secondes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted small">
                            Besoin d'aide ? <a href="mailto:support@nehemie.org" class="text-decoration-none">Contactez
                                notre support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Configuration du minuteur
        let timeLeft = 60; // 1 minute en secondes
        const countdownElement = document.getElementById('countdown-text');
        const progressBar = document.getElementById('countdown-progress');

        // Mise à jour du minuteur chaque seconde
        const countdownInterval = setInterval(function() {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const progress = (timeLeft / 60) * 100;

            // Mise à jour de l'affichage
            countdownElement.textContent =
                `Fermeture automatique dans ${minutes}:${seconds.toString().padStart(2, '0')}`;
            progressBar.style.width = `${progress}%`;

            // Changement de couleur en fonction du temps restant
            if (timeLeft <= 30) {
                progressBar.classList.remove('bg-success');
                progressBar.classList.add('bg-warning');
            }
            if (timeLeft <= 10) {
                progressBar.classList.remove('bg-warning');
                progressBar.classList.add('bg-danger');
            }

            // Fermeture automatique
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                window.close();
            }
        }, 1000);

        // Animation de la coche
        document.addEventListener('DOMContentLoaded', function() {
            const checkmark = document.querySelector('.checkmark');
            setTimeout(() => {
                checkmark.classList.add('draw');
            }, 300);
        });
    </script>
</body>

</html>
