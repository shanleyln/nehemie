<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Nehemie')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('src/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/vendors/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast_pwa.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .nav-tabs .nav-link {
            border: none;
            color: #555;
            font-weight: 500;
            transition: background-color .3s, color .3s;
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        /* anti double-submit */
        .btn[disabled] {
            opacity: .7;
            cursor: not-allowed;
        }

        .btn .spinner-border {
            width: 1rem;
            height: 1rem;
            margin-left: .5rem;
            display: none;
            vertical-align: middle;
        }

        .btn.loading .spinner-border {
            display: inline-block;
        }
    </style>

</head>

@php
    // Réponse renvoyée par linkInit() après POST (redirige "back" sur cette page)
    $resp = session('pvit_link_response');
    // Ce flag te vient du contrôleur (false par défaut tant que le canal carte n'est pas activé chez PVit)
    $visaActive = $visaActive ?? false;
@endphp

<body>
    <div class="custom-container mt-5">
        <!-- Onglets principaux -->
        <ul class="nav nav-tabs nav-justified mb-3 shadow-sm rounded bg-white" id="beneficiaireTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active d-flex align-items-center justify-content-center gap-2 py-3"
                    id="morale-tab" data-bs-toggle="tab" data-bs-target="#morale-pane" type="button" role="tab"
                    aria-controls="morale-pane" aria-selected="true">
                    <i class="fas fa-credit-card"></i><span>Paiement en ligne</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center justify-content-center gap-2 py-3" id="physique-tab"
                    data-bs-toggle="tab" data-bs-target="#physique-pane" type="button" role="tab"
                    aria-controls="physique-pane" aria-selected="false">
                    <i class="fas fa-university"></i><span>Virement Bancaire</span>
                </button>
            </li>
        </ul>

        <div class="tab-content mb-2">
            <!-- Virement bancaire -->
            <div class="tab-pane fade" id="physique-pane" role="tabpanel" aria-labelledby="physique-tab">
                <div class="donation-method mb-4 p-4 border rounded shadow-sm bg-white small">
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            <div class="bg-icon rounded-circle"><i class="fas fa-university"></i></div>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color:#F57C00;">Virement Bancaire</h6>
                            <ul class="list-unstyled mb-0">
                                <li><strong>Banque :</strong> Orabank Gabon</li>
                                <li><strong>Titulaire :</strong> ONG NEHEMIE</li>
                                <li><strong>N° Compte :</strong> 01005 - 24133400901 - 96</li>
                                <li><strong>Devise :</strong> XAF (FCFA)</li><br>
                                <li><strong>SWIFT :</strong> ORBKGALI</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paiement en ligne -->
            <div class="tab-pane fade show active" id="morale-pane" role="tabpanel" aria-labelledby="morale-tab">
                <div>

                    <div aria-live="polite">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h3 class="mb-1">Paiement sécurisé</h3>
                            <div class="text-muted mb-4">Saisissez le montant puis choisissez Mobile Money ou Carte.
                            </div>

                            <!-- Sous-onglets Mobile Money / Carte -->
                            <ul class="nav nav-pills mb-3" id="payTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tab-mobile" data-bs-toggle="pill"
                                        data-bs-target="#pane-mobile" type="button" role="tab"
                                        aria-controls="pane-mobile" aria-selected="true">
                                        Airte Money
                                        <img src="assets/images/airtel_money.png" alt="">
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="tab-card" data-bs-toggle="pill"
                                        data-bs-target="#pane-card" type="button" role="tab"
                                        aria-controls="pane-card" aria-selected="false">
                                        Visa / Mastercard
                                        <img src="assets/images/visa_mastercard.png" alt="">
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="payTabsContent">
                                <!-- Mobile Money (RESTLINK) -->
                                <div class="tab-pane fade show active" id="pane-mobile" role="tabpanel"
                                    aria-labelledby="tab-mobile" tabindex="0">
                                    <form method="POST" action="{{ route('pvit.link.init') }}" class="row gy-3"
                                        id="form-mobile">
                                        @csrf
                                        <div class="col-12">
                                            <label class="form-label">Montant (FCFA) *</label>
                                            <input type="number" min="150" step="1" inputmode="numeric"
                                                name="amount" class="form-control" required>
                                            <div class="form-text">Minimum 150 FCFA.</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Numéro de téléphone *</label>
                                            <input type="tel" inputmode="numeric" pattern="[0-9]{8,20}"
                                                maxlength="20" name="customer_account_number" class="form-control"
                                                required placeholder="Ex: 074573960" autocomplete="tel">
                                            <div class="form-text">9 chiffres, sans espaces.</div>
                                        </div>

                                        <!-- Champs cachés -->
                                        <!-- Mobile Money (RESTLINK) -->
                                        <input type="hidden" name="service" value="RESTLINK">
                                        <input type="hidden" name="owner_charge" value="MERCHANT">
                                        <!-- marchand paie frais PVit -->
                                        <input type="hidden" name="operator_owner_charge" value="MERCHANT">
                                        <!-- marchand paie frais opérateur -->
                                        <input type="hidden" name="reference" value="">
                                        <input type="hidden" name="agent" value="">
                                        <input type="hidden" name="product" value="">
                                        <input type="hidden" name="free_info" value="">


                                        <div class="col-12 d-grid">
                                            <button class="btn btn-primary btn-lg">
                                                Payer par Mobile Money
                                                <span class="spinner-border" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Carte (VISA/Mastercard) -->
                                <div class="tab-pane fade {{ $visaActive ? '' : 'disabled' }}" id="pane-card"
                                    role="tabpanel" aria-labelledby="tab-card" tabindex="0">
                                    @if (!$visaActive)
                                        <div class="alert alert-warning">Le paiement par carte sera disponible
                                            prochainement.</div>
                                    @endif
                                    @if ($visaActive)
                                        <form method="POST" action="{{ route('pvit.link.init') }}" class="row gy-3"
                                            id="form-card">
                                            @csrf
                                            <div class="col-12">
                                                <label class="form-label">Montant (XAF) *</label>
                                                <input type="number" min="150" step="1"
                                                    inputmode="numeric" name="amount" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Numéro de carte / Identifiant *</label>
                                                <input type="text" inputmode="numeric" pattern="[0-9 ]{12,22}"
                                                    maxlength="22" name="customer_account_number"
                                                    class="form-control" required
                                                    placeholder="Ex: 4111 1111 1111 1111" autocomplete="cc-number">
                                                <div class="form-text">Vous serez redirigé vers la page PVit en
                                                    production.</div>
                                            </div>
                                            <!-- Carte (VISA_MASTERCARD) -->
                                            <input type="hidden" name="service" value="VISA_MASTERCARD">
                                            <input type="hidden" name="owner_charge" value="MERCHANT">
                                            <!-- marchand paie frais PVit -->
                                            <input type="hidden" name="operator_owner_charge" value="MERCHANT">
                                            <!-- marchand paie frais opérateur -->
                                            <input type="hidden" name="reference" value="">
                                            <input type="hidden" name="agent" value="">
                                            <input type="hidden" name="product" value="">
                                            <input type="hidden" name="free_info" value="">


                                            <div class="col-12 d-grid">
                                                <button class="btn btn-dark btn-lg">
                                                    Payer par Carte
                                                    <span class="spinner-border" role="status"
                                                        aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Avertissement SERVICE_NOT_ACTIVE --}}
                            @if ($resp && (($resp['status_code'] ?? null) == 3004 || ($resp['error'] ?? '') === 'SERVICE_NOT_ACTIVE'))
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Service momentanément indisponible. Réessayez plus tard.
                                </div>
                            @endif

                            {{-- Bloc de retour (après submit) --}}
                            @if ($resp && !empty($resp['url']))
                                {{-- Redirection automatique --}}
                                <script>
                                    window.onload = function() {
                                        window.location.href = @json($resp['url']);
                                    };
                                </script>
                                <div class="text-center py-3">
                                    <div class="spinner-border text-primary mb-3" style="width: 2.5rem; height: 2.5rem;" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                    <h5 class="mb-3">Redirection en cours</h5>
                                    <p class="mb-3">Vous allez être redirigé vers la page de paiement...</p>
                                    <a href="{{ $resp['url'] }}" class="btn btn-primary">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        Cliquez ici si la redirection ne fonctionne pas
                                    </a>
                                </div>
                            @elseif ($resp)
                                <div class="text-center py-3">
                                    <div class="spinner-border text-primary mb-3" style="width: 2.5rem; height: 2.5rem;" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                    <h5 class="mb-3">Paiement en cours</h5>
                                    
                                    @if (!empty($resp['_merchant_reference']))
                                        <div class="alert alert-info py-2 px-3 mb-3">
                                            <i class="fas fa-receipt me-2"></i>
                                            <strong>Réf :</strong> {{ $resp['_merchant_reference'] }}
                                        </div>
                                    @endif

                                    <div class="alert alert-warning py-2 px-3 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-mobile-alt me-2"></i>
                                            <div>
                                                <div>Notification à venir sur votre téléphone</div>
                                                <small class="text-muted">Temps d'attente : 1-2 min</small>
                                            </div>
                                        </div>
                                    </div>

                                    @if (!empty($resp['url']))
                                        <div class="d-grid gap-2">
                                            <a href="{{ $resp['url'] }}" class="btn btn-primary" target="_blank">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                Poursuivre le paiement
                                            </a>
                                            <small class="text-muted">Si aucune notification n'apparaît</small>
                                        </div>
                                    @else
                                        <div class="alert alert-light py-2 px-3 mt-2 small">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pas de notification ? Vérifiez votre connexion et réessayez.
                                        </div>
                                    @endif
                                </div>

                                {{-- Section technique masquée --}}
                                <div class="text-center mt-3">
                                    <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="collapse" data-bs-target="#techDetails" aria-expanded="false" aria-controls="techDetails">
                                        <i class="fas fa-cog me-1"></i> Afficher les détails techniques
                                    </button>
                                    <div class="collapse mt-2" id="techDetails">
                                        <div class="card card-body small p-2 bg-light">
                                            <pre class="mb-0">{{ json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('src/assets/js/password-show.js') }}"></script>
    <script src="{{ asset('src/assets/js/iconsax.js') }}"></script>
    <script src="{{ asset('src/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/template-setting.js') }}"></script>
    <script src="{{ asset('src/assets/js/script.js') }}"></script>


    <script>
        // Masquer le formulaire si une réponse est déjà présente
        document.addEventListener('DOMContentLoaded', function() {
            const responseSection = document.querySelector('div.text-center.py-4');
            const forms = document.querySelectorAll('form[id^="form-"]');
            
            if (responseSection) {
                forms.forEach(form => {
                    form.style.display = 'none';
                });
            }
        });

        // Empêche les doubles envois + validations rapides
        function protectSubmit(form) {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.classList.add('loading');
                btn.setAttribute('disabled', 'disabled');
                
                // Masquer le formulaire après soumission
                form.style.opacity = '0.6';
                form.style.pointerEvents = 'none';
                
                setTimeout(() => btn.removeAttribute('disabled'), 8000);
            }
            return true;
        }

        document.getElementById('form-mobile')?.addEventListener('submit', function(e) {
            const amt = this.amount.valueAsNumber || 0;
            const num = (this.customer_account_number.value || '').replace(/\s+/g, '');
            if (amt < 150 || !/^\d{8,20}$/.test(num)) {
                e.preventDefault();
                alert('Vérifiez le montant (≥150) et le numéro (8–20 chiffres).');
                return;
            }
            protectSubmit(this);
        });

        document.getElementById('form-card')?.addEventListener('submit', function(e) {
            const amt = this.amount.valueAsNumber || 0;
            const num = (this.customer_account_number.value || '').replace(/\s+/g, '');
            if (amt < 150 || !/^[\d ]{12,22}$/.test(num)) {
                e.preventDefault();
                alert('Vérifiez le montant (≥150) et le numéro de carte.');
                return;
            }
            protectSubmit(this);
        });
    </script>

    {{-- <script>
        // Service worker (déjà en place côté /public/pvit/sw.js)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker
                    .register('/pvit/sw.js', {
                        scope: '/pvit/'
                    })
                    .then(reg => console.log('SW registered:', reg.scope))
                    .catch(err => console.error('SW registration failed:', err));
            });
        }
    </script> --}}
</body>

</html>
