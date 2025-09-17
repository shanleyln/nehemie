@extends('layout.app')
@php
    // Réponse renvoyée par linkInit() après POST (redirige "back" sur cette page)
    $resp = session('pvit_link_response');
@endphp

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

                        {{-- indisponible --}}
                        {{-- <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Votre paiement en ligne est indisponible pour le moment. Veuillez réessayer plus tard.
                        </div> --}}

                        <div class="container py-5" style="max-width: 720px;">

                            {{-- Messages flash --}}
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h3 class="mb-1">Paiement sécurisé</h3>
                                    <div class="text-muted mb-4">Saisissez le montant puis choisissez Mobile Money ou Carte.
                                    </div>

                                    {{-- Sélecteur d'onglets --}}
                                    <ul class="nav nav-pills mb-3" id="payTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="tab-mobile" data-bs-toggle="pill"
                                                data-bs-target="#pane-mobile" type="button" role="tab"
                                                aria-controls="pane-mobile" aria-selected="true">
                                                Mobile Money
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tab-card" data-bs-toggle="pill"
                                                data-bs-target="#pane-card" type="button" role="tab"
                                                aria-controls="pane-card" aria-selected="false">
                                                Visa / Mastercard
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="payTabsContent">

                                        {{-- === Onglet Mobile Money (RESTLINK) === --}}
                                        <div class="tab-pane fade show active" id="pane-mobile" role="tabpanel"
                                            aria-labelledby="tab-mobile" tabindex="0">
                                            <form method="POST" action="{{ route('pvit.link.init') }}" class="row gy-3"
                                                id="form-mobile">
                                                @csrf
                                                {{-- Champs visibles --}}
                                                <div class="col-12">
                                                    <label class="form-label">Montant (XAF) *</label>
                                                    <input type="number" min="150" step="1" name="amount"
                                                        class="form-control" required>
                                                    <div class="form-text">Minimum 150 XAF.</div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Numéro de téléphone *</label>
                                                    <input type="text" maxlength="20" name="customer_account_number"
                                                        class="form-control" required placeholder="Ex: 066820866">
                                                    <div class="form-text">Ce numéro recevra le prompt (sandbox:
                                                        auto-validation possible).</div>
                                                </div>

                                                {{-- Champs cachés (on utilise ta fonction existante linkInit) --}}
                                                <input type="hidden" name="service" value="RESTLINK">
                                                <input type="hidden" name="owner_charge" value="CUSTOMER">
                                                <input type="hidden" name="operator_owner_charge" value="">
                                                {{-- reference facultative -> laissée vide pour génération auto --}}
                                                <input type="hidden" name="reference" value="">
                                                <input type="hidden" name="agent" value="">
                                                <input type="hidden" name="product" value="">
                                                <input type="hidden" name="free_info" value="">

                                                <div class="col-12 d-grid">
                                                    <button class="btn btn-primary btn-lg">Payer par Mobile Money</button>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- === Onglet Carte (VISA_MASTERCARD) === --}}
                                        <div class="tab-pane fade" id="pane-card" role="tabpanel"
                                            aria-labelledby="tab-card" tabindex="0">
                                            <form method="POST" action="{{ route('pvit.link.init') }}" class="row gy-3"
                                                id="form-card">
                                                @csrf
                                                <div class="col-12">
                                                    <label class="form-label">Montant (XAF) *</label>
                                                    <input type="number" min="150" step="1" name="amount"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Numéro de carte / Identifiant *</label>
                                                    <input type="text" maxlength="20" name="customer_account_number"
                                                        class="form-control" required
                                                        placeholder="Ex: 4111 1111 1111 1111">
                                                    <div class="form-text">En PROD, vous serez redirigé vers la page de
                                                        paiement carte de PVit.</div>
                                                </div>

                                                {{-- Champs cachés --}}
                                                <input type="hidden" name="service" value="VISA_MASTERCARD">
                                                <input type="hidden" name="owner_charge" value="CUSTOMER">
                                                <input type="hidden" name="operator_owner_charge" value="">
                                                <input type="hidden" name="reference" value="">
                                                <input type="hidden" name="agent" value="">
                                                <input type="hidden" name="product" value="">
                                                <input type="hidden" name="free_info" value="">

                                                <div class="col-12 d-grid">
                                                    <button class="btn btn-dark btn-lg">Payer par Carte</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div> {{-- /tab-content --}}

                                    {{-- Bloc de retour (après submit) --}}
                                    @if ($resp)
                                        <hr class="my-4">
                                        <h5>Résultat</h5>

                                        {{-- Affiche la référence marchande utilisée (auto-générée chez nous) --}}
                                        @if (!empty($resp['_merchant_reference']))
                                            <div class="alert alert-info">
                                                <strong>Référence :</strong> <code>{{ $resp['_merchant_reference'] }}</code>
                                                <div class="small text-muted">Conservez-la pour suivi.</div>
                                            </div>
                                        @endif

                                        {{-- Si PVit fournit une URL (WEB / VISA_MASTERCARD), on propose la redirection --}}
                                        @if (!empty($resp['url']))
                                            <div class="d-flex align-items-center gap-2">
                                                <a class="btn btn-success" href="{{ $resp['url'] }}"
                                                    target="_blank">Continuer vers le paiement</a>
                                                <span class="text-muted small">Une nouvelle fenêtre s’ouvrira.</span>
                                            </div>

                                            {{-- Auto-redirect (facultatif) — décommente si tu veux rediriger d'office
                                    <script> window.location.href = @json($resp['url']); </script>
                                    --}}
                                        @else
                                            {{-- RESTLINK: pas d’URL, on informe l’utilisateur --}}
                                            <div class="alert alert-secondary mt-2">
                                                <div class="fw-semibold mb-1">Demande envoyée.</div>
                                                <div class="small">Si vous êtes en sandbox, la validation peut être
                                                    automatique. En PROD, un prompt s’affiche sur votre téléphone pour
                                                    confirmer l’opération.</div>
                                            </div>
                                        @endif

                                        {{-- Debug léger (masquer en PROD si tu veux) --}}
                                        <details class="mt-3">
                                            <summary>Voir la réponse technique</summary>
                                            <pre class="mt-2 bg-light p-3 border rounded small">{{ json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </details>
                                    @endif

                                </div>
                            </div>

                            {{-- Lien retour admin (optionnel) --}}
                            <div class="text-center mt-3">
                                <a href="{{ route('pvit.settings') }}" class="text-muted small">Administration PVit</a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
