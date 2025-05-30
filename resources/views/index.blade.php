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
                                    <h6 class="fw-bold mb-2" style="color: #F57C00;">Virement Bancaire</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Banque :</strong> BGFI Bank Gabon</li>
                                        <li><strong>Titulaire :</strong> ONG NEHEMIE INTERNATIONAL</li>
                                        <li><strong>N° Compte :</strong> XXXXXXXXXXXX</li>
                                        <li><strong>SWIFT/BIC :</strong> BGFXXXXX</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- paiement en ligne --}}
                <div class="tab-pane fade show active" id="morale-pane" role="tabpanel" aria-labelledby="morale-tab">
                    <div id="moralTableBodyContainer">

                        {{-- <!-- ✅ Titre et message -->
                        <div class="auth-title text-center">
                            <p class="text-muted" style="font-size: 15px">Veuillez entrer le montant que vous souhaitez
                                régler.</p>
                        </div> --}}

                        <!-- ✅ Message de succès -->
                        @if (session('success'))
                            <div class="alert alert-success mt-3" style="font-size: 13px">
                                {{ session('success') }}
                                <button type="button" class="btn-close float-end" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <i class="iconsax" data-icon="close"></i>
                                </button>
                            </div>
                        @endif
                        <!-- ✅ Message d'erreur -->
                        @if (session('error'))
                            <div class="alert alert-danger mt-3" style="font-size: 13px">
                                {{ session('error') }}
                                <button type="button" class="btn-close float-end" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <i class="iconsax" data-icon="close"></i>
                                </button>
                            </div>
                        @endif
                        <!-- ✅ Informations de la transaction -->
                        @php
                            $montant = null;
                            if (session('error')) {
                                // Exemple : "Le paiement de 100 000 a échoué."
                                $message = session('error');

                                if (preg_match('/Le paiement de\s+([\d\s]+)\s+a échoué/i', $message, $matches)) {
                                    $montant = str_replace(' ', '', $matches[1]); // ➜ "100000"
                                }
                            }
                        @endphp

                        <!-- ✅ Formulaire de paiement -->
                        <form class="auth-form mt-4 shadow" method="POST" action="{{ route('paiement.valider') }}">
                            @csrf

                            <div class="form-group">
                                <label class="form-label mb-2" for="InputMontant">Montant à payer (FCFA)</label>
                                <div class="form-input">
                                    <input type="text" id="montant_affiche" class="form-control shadow-sm ps-5"
                                        {{-- ps-5 = padding left pour l’icône --}} placeholder="Ex : 10 000" oninput="formatMontant(this)"
                                        inputmode="numeric" value="{{ $montant ?? null }}" autocomplete="off" required>

                                    <!-- 📤 Champ réel soumis au backend -->
                                    <input type="hidden" name="montant" id="montant" value="{{ $montant ?? null }}"
                                        required>
                                </div>

                            </div>

                            <button type="submit" class="btn w-100 mt-4 shadow theme-btn"
                                style="font-weight: bold; border-radius: 8px; padding: 10px 0; font-size: 16px;">
                                Payer maintenant
                            </button>
                        </form>
                        <script>
                            function formatMontant(input) {
                                let valeur = input.value.replace(/\s/g, '').replace(/\D/g, '');

                                // Mettre à jour le champ masqué
                                document.getElementById('montant').value = valeur;

                                // Appliquer l'espacement tous les 3 chiffres
                                input.value = valeur.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            }
                        </script>

                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
