@extends('layout.app')

@section('title', 'Paiement')

@section('content')

    <!-- wallet balance section starts -->
    <section class="section-lg-t-space">
        <div class="custom-container">
            <div class="wallet-balance-box">
                <img class="img-fluid wallet-icon"
                    src="https://themes.pixelstrap.com/pwa/fixit/assets/images/svg/wallet-fill.svg" alt="p8">
                <div class="wallet-details">
                    <h5>Montant à regler.</h5>
                    <h4>{{ number_format($montant, 0, ',', ' ') }} FCFA</h4>
                </div>
            </div>
        </div>
    </section>
    <!-- wallet balance section end -->

    <div class="offcanvas offcanvas-bottom service-booking-offcanvas" tabindex="-1" id="add-money">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasBottomLabel">Modifier le montant</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form class="auth-form mt-4" method="POST" action="{{ route('paiement.valider') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label mb-2" for="InputMontant">Montant à payer (FCFA)</label>
                    <div class="form-input">
                        <input type="text" id="montant_affiche" class="form-control shadow-sm ps-5" {{-- ps-5 = padding left pour l’icône --}}
                            placeholder="Ex : 10 000" oninput="formatMontant(this)" value="{{ $montant }}"
                            inputmode="numeric" autocomplete="off" required>

                        <!-- 📤 Champ réel soumis au backend -->
                        <input type="hidden" name="montant" id="montant" pattern="\d+" value="{{ $montant }}"
                            required>
                    </div>

                </div>

                <button type="submit" class="btn w-100 mt-4 shadow theme-btn"
                    style="font-weight: bold; border-radius: 8px; padding: 10px 0; font-size: 16px;">
                     Modifier le montant
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
    <!-- payment history section starts -->
    <section class="section-b-space">
        <div class="custom-container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close">
                        <i class="iconsax" data-icon="close"></i>
                    </button>
                </div>
            @endif
            <div class="custom-container1">
                <div class="wallet-balance-box mb-1" style="background-color: transparent;border-radius:5px">

                    <div class="wallet-details">
                        <h4><strong class="text-muted">Moyen de paiement disponible</strong></h4>
                        <img class="img-fluid wallet-icon1"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA4CAMAAACfWMssAAAAdVBMVEXoAAD////lAADlAwTzxsb67+/67OzwpaX56OjyurvuoKDxtbbsZ2jtiIjrgoLlFhj53+DnNDTrfX3qdXXnQUH0zMz89/fmR0jxr7DlDg/219jnVlftjo7ywMHlHR3tm5vtlJXqbm/rX2DlIyToT0/mKyvnOjpZTp5wAAABg0lEQVRIie2UW4+DIBCFOeP9gqJU26pVq23//09cpNp92YTSbLL74BGIknyZcTgMY7t2/bbyMggkWWOHCovqox1GJ2w623Dn8MVhsIknVqhW07UAyyfWtEQ1IgvQ1ZyuaIPMAuwUdtFFURGtDqSVPWmAW9VGh7ogZqyAsHXABQhYj9CWK4CEjqisHSdROSdwe6f2qq5Rbo0pOQf7aH+ho/yMUz7T1/c+pOvOdDLfysVqPKLlJQVfNy5wDFjaIJxY6RINfl3CG2nwxMQiI5gFaQiqQBHi6wS3zRCL5csEkhwb9K5mmUqVRN0GSBMTSA2qELkCXQ12qk5CiNQYcYar+ts3yMn3iZH6R4OPCN6j0uCS6hGuM4DfkvsJppNtfficRR6pwShAQIlqWo9e4G4gSbcM0uO50Gv5h6It1S3jNxWMw5heu7GI45vkZcZKk21WDTQSH5m8plQmMpbF+GbEjnXEFd22eTnQRFXxJvhYHic75LNTzLxgtr1803z7ENy16wd9ASDTEn5PZFY+AAAAAElFTkSuQmCC"
                            alt="p8">
                    </div>
                </div>
            </div>
            <div class="title">
                <h2>Détails de la transaction</h2>
            </div>
            <ul class="payment-history-list">
                <li class="payment-history-box">
                    <div class="payment-service-head d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-medium title-color">Montant à régler</h5>
                            <h3 class="fw-semibold title-color mt-1">{{ number_format($montant, 0, ',', ' ') }} FCFA</h3>
                        </div>
                        <div class="text-end">
                            <h6 class="content-color">Référence :</h6>
                            <h6 class="fw-bold title-color"> <code>{{ $reference }}</code></h6>
                        </div>
                    </div>

                    <div class="bill-box mt-3">
                        <div class="bill-box-content">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="fw-normal content-color">Frais de paiement</h5>
                                <h5 class="fw-medium title-color">{{ number_format(1520, 0, ',', ' ') }} FCFA</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-2">
                                <h5 class="fw-normal content-color">Statut</h5>
                                <h5 class="fw-medium warning-color">🕒 En attente</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-2">
                                <h5 class="fw-normal content-color">Date</h5>
                                <h5 class="fw-medium title-color">{{ now()->format('d/m/Y à H:i') }}</h5>
                            </div>
                        </div>
                        <img class="img-fluid bottom-design"
                            src="https://themes.pixelstrap.com/pwa/fixit/assets/images/svg/dots-design.svg"
                            alt="dots-design">
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center gap-3 mt-3">
                            <!-- ✅ Modifier (offcanvas) -->
                            <a href="#add-money" data-bs-toggle="offcanvas" class="btn outline-btn w-100">Modifier le
                                montant</a>

                            <!-- ✅ Confirmer (form POST sécurisé) -->
                            {{-- <form method="POST" action="{{ route('paiement.confirme.finaliser') }}" class="w-100">
                                @csrf
                                <input type="hidden" name="montant" value="{{ $montant }}"> --}}
                            <button onclick="singPayPopup()" class="btn theme-btn w-100">Confirmer le
                                paiement</button>
                            {{-- </form> --}}
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </section>

    <script>
        function singPayPopup() {
            const url = "{{ $lienPaiement }}";
            const width = 450;
            const height = 580;

            // Calcul de la position centrée
            const left = (window.screen.width / 2) - (width / 2);
            const top = (window.screen.height / 2) - (height / 2);

            // Ouverture de la fenêtre centrée
            window.open(
                url,
                'mobileMoneyPopup',
                `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=no`
            );
        }
    </script>

@endsection
