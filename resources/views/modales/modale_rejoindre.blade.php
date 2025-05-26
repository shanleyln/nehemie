<style>
    .contact-option {
        transition: all 0.3s ease;
        border: 1px solid #e8d9c5;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .contact-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.1);
        border-color: #8B4513;
    }

    .contact-option .icon-wrapper {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #FFF8F0;
        transition: all 0.3s ease;
    }

    .contact-option:hover .icon-wrapper {
        background-color: #8B4513;
    }

    .contact-option:hover .icon-wrapper i {
        color: white !important;
    }

    .contact-option .text-primary {
        color: #8B4513 !important;
        transition: all 0.3s ease;
    }

    .contact-option:hover .text-primary {
        color: #8B4513 !important;
    }

    .contact-option .text-muted {
        transition: all 0.3s ease;
    }

    .contact-option:hover .text-muted {
        color: #8B4513 !important;
    }
</style>

<!-- Modal Rejoindre -->
<div class="modal fade" id="rejoindreModal" tabindex="-1" aria-labelledby="rejoindreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 p-4 pb-2">
                <div class="text-center w-100">
                    <div class="mb-2">
                        <i class="fas fa-hands-helping fa-2x text-marron"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0">Devenez bénévole</h5>
                    <p class="small text-muted mt-2 mb-0">Rejoignez notre équipe et faites la différence</p>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <div class="d-grid gap-3">
                    <a href="mailto:info@nehemie-internationale.com?subject=Demande%20d%27information%20pour%20devenir%20b%C3%A9n%C3%A9vole"
                        class="contact-option text-decoration-none p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-envelope text-marron"></i>
                            </div>
                            <div>
                                <span class="d-block fw-medium text-primary">Envoyer un email</span>
                                <small class="text-muted">info@nehemie-internationale.com</small>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </a>

                    <a href="tel:+241XXXXXXXX" class="contact-option text-decoration-none p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-phone text-marron"></i>
                            </div>
                            <div>
                                <span class="d-block fw-medium text-primary">Nous appeler</span>
                                <small class="text-muted">+241 66609668</small>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </a>

                    <a href="https://wa.me/24166609668" target="_blank" class="contact-option text-decoration-none p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fab fa-whatsapp text-marron"></i>
                            </div>
                            <div>
                                <span class="d-block fw-medium text-primary">Discuter sur WhatsApp</span>
                                <small class="text-muted">Réponse rapide garantie</small>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-external-link-alt text-muted small"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="mt-4 text-center">
                    <div class="d-inline-flex align-items-center px-3 py-2 rounded" style="background-color: #FFF8F0;">
                        <i class="far fa-clock text-marron me-2"></i>
                        <span class="small text-muted">Disponible du lundi au vendredi, de 8h à 17h</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
