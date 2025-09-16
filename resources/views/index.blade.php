@extends('layout.app')

@section('title2', 'Bienvenue !')

@section('content')
    <style>
        .nav-tabs .nav-link {
            border: none;
            color: #555;
            font-weight: 500;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-tabs .nav-link:hover {
            background-color: #f8f9fa;
            color: #F57C00;
        }

        .nav-tabs .nav-link.active {
            background-color: #F57C00;
            color: #fff;
            border-radius: .5rem;
            font-weight: 600;
        }

        .nav-tabs {
            border: none;
        }

        .bg-icon {
            width: 40px;
            height: 40px;
            background-color: #F57C00;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>


    <section class="section-lg-t-space section-b-space">
        <div class="custom-container">

            <!-- ✅ Image illustrative -->
            <div class="text-center mt-2">
                <img src="{{ asset('src/assets/images/logo/paiement.png') }}" alt="Paiement" class="img-fluid"
                    style="max-width: 180px;">
            </div>

            <!-- Onglets de sélection de mode de paiement -->
            <ul class="nav nav-tabs nav-justified mb-3 shadow-sm rounded bg-white" id="beneficiaireTabs" role="tablist">

                <!-- Onglet Paiement en ligne -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active d-flex align-items-center justify-content-center gap-2 py-3"
                        id="morale-tab" data-bs-toggle="tab" data-bs-target="#morale-pane" type="button" role="tab"
                        aria-controls="morale-pane" aria-selected="false">
                        <i class="fas fa-credit-card"></i>
                        <span>Paiement en ligne</span>
                    </button>
                </li>

                <!-- Onglet Virement Bancaire -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link  d-flex align-items-center justify-content-center gap-2 py-3" id="physique-tab"
                        data-bs-toggle="tab" data-bs-target="#physique-pane" type="button" role="tab"
                        aria-controls="physique-pane" aria-selected="true">
                        <i class="fas fa-university"></i>
                        <span>Virement Bancaire</span>
                    </button>
                </li>

            </ul>



            <div class="tab-content mb-2">
                {{-- virement Bancaire --}}
                <div class="tab-pane fade " id="physique-pane" role="tabpanel" aria-labelledby="physique-tab">
                    <div id="physiqueTableBodyContainer">

                        <!-- Virement Bancaire - Bloc stylisé -->
                        <div class="donation-method mb-4 p-4 border rounded shadow-sm bg-white small">
                            <div class="d-flex align-items-start">
                                <!-- Icône stylisée -->
                                <div class="me-3">
                                    <div class="bg-icon text-white d-flex align-items-center justify-content-center rounded-circle"
                                        style="width: 40px; height: 40px; background-color: #F57C00;">
                                        <i class="fas fa-university"></i>
                                    </div>
                                </div>

                                <!-- Texte structuré -->
                                <div>
                                    <h6 class="fw-bold mb-1" style="color: #F57C00;">Virement Bancaire</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Banque :</strong> Orabank Gabon</li>
                                        <li><strong>Titulaire :</strong> ONG NEHEMIE</li>
                                        <li><strong>N° Compte :</strong> 01005 - 24133400901 - 96</li>
                                        <li><strong>Device :</strong>XAF FCFA</li> <br>
                                        <li><strong>SWIFT :</strong> ORBKGALI</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- paiement en ligne --}}
                <div class="tab-pane fade show active" id="morale-pane" role="tabpanel" aria-labelledby="morale-tab">
                    <div id="moralTableBodyContainer">

                        <form id="paymentForm">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nom" class="form-label">Votre nom (optionnel)</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                    placeholder="Votre nom">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Votre email (optionnel)</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="votre@email.com">
                            </div>
                            <div class="form-group mb-3">
                                <label for="telephone" class="form-label">Numéro de téléphone <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+241</span>
                                    <input type="tel" class="form-control" id="telephone" name="telephone"
                                        placeholder="060102030" pattern="[0-9]{8,9}" required>
                                </div>
                                <small class="form-text text-muted">Format: 060102030 (sans espace, 8 ou 9 chiffres)</small>
                            </div>
                            <div class="form-group mb-4">
                                <label for="montant" class="form-label">Montant (FCFA) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="montant" name="montant" min="150"
                                        step="50" value="1000" required>
                                    <span class="input-group-text">FCFA</span>
                                </div>
                                <small class="form-text text-muted">Montant minimum: 150 FCFA</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true" id="spinner"></span>
                                    <span id="btnText">Payer avec Mobile Money</span>
                                </button>
                            </div>

                            <div class="alert alert-info mt-3 mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Vous recevrez une demande de confirmation sur votre téléphone pour valider le paiement.
                            </div>
                        </form>

                        <!-- Modal d'erreur -->
                        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Erreur de paiement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body" id="errorMessage">
                                        Une erreur est survenue lors du traitement de votre demande.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const form = document.getElementById('paymentForm');
                                    const submitBtn = document.getElementById('submitBtn');
                                    const spinner = document.getElementById('spinner');
                                    const btnText = document.getElementById('btnText');
                                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                    const errorMessage = document.getElementById('errorMessage');

                                    form.addEventListener('submit', async function(e) {
                                        e.preventDefault();

                                        // Désactiver le bouton et afficher le spinner
                                        submitBtn.disabled = true;
                                        spinner.classList.remove('d-none');
                                        btnText.textContent = 'Traitement en cours...';

                                        try {
                                            const formData = new FormData(this);
                                            const response = await fetch('{{ route('api.pvit.initier') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Accept': 'application/json',
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                        .content
                                                },
                                                body: formData
                                            });

                                            const result = await response.json();

                                            if (!response.ok) {
                                                throw new Error(result.message || 'Erreur lors de la requête');
                                            }

                                            if (result.success) {
                                                // Rediriger vers la page de succès avec la référence
                                                const reference = encodeURIComponent(result.data.reference);
                                                window.location.href = '/paiement/succes/' + reference;
                                            } else {
                                                throw new Error(result.message || 'Erreur inconnue');
                                            }
                                        } catch (error) {
                                            console.error('Erreur:', error);
                                            errorMessage.textContent = error.message ||
                                                'Une erreur est survenue lors du traitement de votre demande.';
                                            errorModal.show();

                                            // Réactiver le bouton
                                            submitBtn.disabled = false;
                                            spinner.classList.add('d-none');
                                            btnText.textContent = 'Payer avec Mobile Money';
                                        }
                                    });
                                });
                            </script>
                        @endpush
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
