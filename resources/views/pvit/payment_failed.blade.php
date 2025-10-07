<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Échoué - Nehemie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --warning-color: #f6c23e;
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

        .error-circle {
            width: 100px;
            height: 100px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin: 0 auto 1.5rem;
        }

        .error-circle .background {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--danger-color);
            position: absolute;
            opacity: 0.1;
            top: 0;
            left: 0;
        }

        .error-circle .error-mark {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--danger-color);
            font-size: 3rem;
            font-weight: bold;
            animation: bounce 0.5s ease-in-out;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
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

        .btn-outline-secondary {
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-left: 4px solid var(--warning-color);
            border-radius: 0.5rem;
        }

        .reference-box {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 0.5rem;
        }

        #countdown {
            font-weight: bold;
            color: var(--primary-color);
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
                            <!-- Animation d'erreur -->
                            <div class="mb-4">
                                <div class="error-circle">
                                    <div class="background"></div>
                                    <div class="error-mark">!</div>
                                </div>
                            </div>

                            <!-- Titre et message -->
                            <h2 class="mb-3 fw-bold" style="color: var(--danger-color);">Paiement Échoué</h2>
                            <p class="text-muted mb-4 fs-5">
                                Une erreur est survenue lors du traitement de votre paiement.
                            </p>

                            <!-- Message d'erreur -->
                            @if (!empty($message))
                                <div class="alert alert-warning text-start mb-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ $message }}
                                </div>
                            @endif

                            <!-- Référence de paiement -->
                            @if (!empty($reference))
                                <div class="reference-box text-start mb-4">
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

                            <!-- Boutons d'action -->
                            <div class="d-grid gap-3 d-md-flex justify-content-center mt-4">
                                <a href="https://nehemie-international.com/paiement" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-arrow-right me-2"></i>Retour au paiement
                                </a>
                            </div>
                            <div class="mt-3">
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-sync-alt me-1"></i>
                                    Redirection automatique dans <span id="countdown" class="fw-bold">10</span>s
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Configuration du minuteur
        document.addEventListener('DOMContentLoaded', function() {
            let timeLeft = 10; // 10 secondes avant redirection
            const countdownElement = document.getElementById('countdown');
            const redirectUrl = 'https://nehemie-international.com/paiement';
            let countdownInterval;

            // Mettre à jour l'affichage du compte à rebours
            function updateCountdown() {
                if (countdownElement) {
                    countdownElement.textContent = timeLeft.toString().padStart(2, '0');
                }
            }

            // Démarrer le compte à rebours
            updateCountdown(); // Afficher immédiatement
            
            countdownInterval = setInterval(function() {
                timeLeft--;
                updateCountdown();
                
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    window.location.replace(redirectUrl);
                }
            }, 1000);
        });
    </script>
</body>

</html>
