<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="checkmark-circle">
                            <div class="checkmark"></div>
                        </div>
                    </div>
                    <h2 class="mb-3">Paiement Réussi !</h2>
                    <p class="text-muted mb-4">Merci pour votre don. Votre paiement a été traité avec succès.</p>

                    @if (!empty($reference))
                        <div class="alert alert-info">
                            <i class="fas fa-receipt me-2"></i>
                            <strong>Référence :</strong> {{ $reference }}
                        </div>
                    @endif

                    <div class="mt-4 text-center">
                        <div class="mb-3">
                            <div class="progress" style="height: 6px;">
                                <div id="countdown-progress" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted" id="countdown-text">Fermeture automatique dans 2:00</small>
                        </div>
                        <button onclick="window.close()" class="btn btn-primary px-4">
                            <i class="fas fa-home me-2"></i>Retour à l'accueil maintenant
                        </button>
                    </div>

                    <script>
                        // Configuration du minuteur
                        let timeLeft = 120; // 2 minutes en secondes
                        const countdownElement = document.getElementById('countdown-text');
                        const progressBar = document.getElementById('countdown-progress');
                        
                        // Mise à jour du minuteur chaque seconde
                        const countdownInterval = setInterval(function() {
                            timeLeft--;
                            const minutes = Math.floor(timeLeft / 60);
                            const seconds = timeLeft % 60;
                            const progress = (timeLeft / 120) * 100;
                            
                            // Mise à jour de l'affichage
                            countdownElement.textContent = `Fermeture automatique dans ${minutes}:${seconds.toString().padStart(2, '0')}`;
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
                            
                            // Arrêt du minuteur et fermeture
                            if (timeLeft <= 0) {
                                clearInterval(countdownInterval);
                                try {
                                    window.close();
                                } catch (e) {
                                    console.log('La fenêtre ne peut pas être fermée automatiquement');
                                }
                            }
                        }, 1000);
                        
                        // Fermeture après 2 minutes (sécurité)
                        setTimeout(function() {
                            clearInterval(countdownInterval);
                            try {
                                window.close();
                            } catch (e) {
                                console.log('La fenêtre ne peut pas être fermée automatiquement');
                            }
                        }, 120000); // 2 minutes
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkmark-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 4;
        stroke: #4bb71b;
        stroke-miterlimit: 10;
        margin: 0 auto 20px;
        box-shadow: inset 0px 0px 0px #4bb71b;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        position: relative;
    }

    .checkmark {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: block;
        stroke-width: 4;
        stroke: #4bb71b;
        stroke-miterlimit: 10;
        margin: 0 auto;
        animation: scale .3s ease-in-out .9s both;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale {

        0%,
        100% {
            transform: none;
        }

        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 50px rgba(75, 183, 27, 0);
        }
    }
</style>
