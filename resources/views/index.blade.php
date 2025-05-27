@extends('layout.app')

@section('title2', 'Bienvenue !')

@section('content')
    <section class="section-lg-t-space section-b-space">
        <div class="custom-container">

            <!-- ✅ Image illustrative -->
            <div class="text-center">
                <img src="{{ asset('src/assets/images/logo/paiement.png') }}" alt="Paiement" class="img-fluid"
                    style="max-width: 180px;">
            </div>

            <!-- ✅ Titre et message -->
            <div class="auth-title text-center">
                <p class="text-muted" style="font-size: 15px">Veuillez entrer le montant que vous souhaitez régler.</p>
            </div>

            <!-- ✅ Message de succès -->
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">
                        <i class="iconsax" data-icon="close"></i>
                    </button>
                </div>
            @endif
            <!-- ✅ Message d'erreur -->
            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">
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
                        <input type="text" id="montant_affiche" class="form-control shadow-sm ps-5" {{-- ps-5 = padding left pour l’icône --}}
                            placeholder="Ex : 10 000" oninput="formatMontant(this)" inputmode="numeric"
                            value="{{ $montant ?? null }}" autocomplete="off" required>

                        <!-- 📤 Champ réel soumis au backend -->
                        <input type="hidden" name="montant" id="montant" value="{{ $montant ?? null }}" required>
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
    </section>

@endsection
