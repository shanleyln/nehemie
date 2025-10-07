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

                    <div class="d-grid gap-3 d-md-flex justify-content-center mt-4">
                        <button onclick="window.close()" class="btn btn-primary px-4">
                            <i class="fas fa-times me-2"></i>Retour à l'accueil
                        </button>
                    </div>

                    <script>
                        // Essayer de fermer automatiquement après 2 minutes
                        setTimeout(function() {
                            try {
                                window.close();
                            } catch (e) {
                                console.log('La fenêtre ne peut pas être fermée automatiquement');
                            }
                        }, 120000); // 120000 ms = 2 minutes
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
