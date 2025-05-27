<!-- Modale de Don (compacte avec bouton marron et popup Mobile Money) -->
<div class="modal fade" id="donModal" tabindex="-1" aria-labelledby="donModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white py-2">
                <h6 class="modal-title mb-0 text-white" id="donModalLabel">
                    <i class="fas fa-hands-helping me-2 small text-white"></i> Soutenir notre mission
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Fermer"></button>
            </div>
            <div class="modal-body py-3 px-4">
                <div class="donation-options">
                    <h6 class="text-center mb-2">Faire un Don</h6>
                    <p class="text-center mb-3 small">
                        Même un petit geste peut changer des vies.
                    </p>

                    <!-- Virement Bancaire -->
                    <div class="donation-method mb-3 p-3 border rounded small">
                        <div class="d-flex align-items-start">
                            <div class="me-2 mt-1">
                                <i class="fas fa-university text-primary"></i>
                            </div>
                            <div>
                                <strong>Virement Bancaire</strong><br>
                                Banque : BGFI Bank Gabon<br>
                                Titulaire : ONG NEHEMIE INTERNATIONAL<br>
                                N° Compte : XXXXXXXXXXXX<br>
                                SWIFT/BIC : BGFXXXXX
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Money avec popup -->
                    <div class="donation-method p-3 border rounded small">
                        <div class="d-flex align-items-start">
                            <div class="me-2 mt-1">
                                <i class="fas fa-mobile-alt text-primary"></i>
                            </div>
                            <div class="w-100">
                                <strong>Mobile Money</strong><br>
                                <button onclick="openMobileMoneyPopup()" class="btn btn-sm w-100 text-white"
                                    style="background-color: #795548; border: none;">
                                    <i class="fas fa-mobile-alt me-1"></i>Faire un don
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openMobileMoneyPopup() {
        const url = "{{ route('index') }}";
        const width = 450;
        const height = 550;

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
