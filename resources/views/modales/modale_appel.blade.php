<div class="modal fade" id="appelModal" tabindex="-1" aria-labelledby="appelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header border-0 p-3">
                <h6 class="modal-title fw-bold m-0" id="appelModalLabel">
                    <i class="fas fa-phone-alt me-2 text-primary"></i>Contact
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-phone-volume text-primary" style="font-size: 2rem;"></i>
                </div>

                <!-- Affiché sur tous les appareils -->
                <div class="phone-number mb-3">
                    <span class="h5 fw-bold">+241 66 60 96 68</span>
                </div>

                <!-- Bouton d'appel - visible uniquement sur mobile -->
                <div class="d-block d-md-none mb-3">
                    <a href="tel:+24166609668" class="btn btn-primary">
                        <i class="fas fa-phone-alt me-2"></i>Appeler maintenant
                    </a>
                </div>

                <div class="text-muted small">
                    <p class="mb-1"><i class="far fa-clock me-1"></i>Lun-Ven: 8h-17h</p>
                    <p class="mb-0">
                        <span id="availability-status">
                            <i class="fas fa-circle-notch fa-spin me-1"></i> Vérification...
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateAvailabilityStatus() {
            const now = new Date();
            const day = now.getDay(); // 0 (dimanche) à 6 (samedi)
            const hour = now.getHours();
            const statusElement = document.getElementById('availability-status');

            // Vérifie si c'est un jour de semaine (1-5) et entre 8h et 17h
            const isAvailable = (day >= 1 && day <= 5) && (hour >= 8 && hour < 17);

            if (isAvailable) {
                statusElement.innerHTML =
                    '<i class="fas fa-check-circle text-success me-1"></i>  Disponible maintenant';
            } else {
                // Si c'est en dehors des heures d'ouverture
                statusElement.innerHTML = '<i class="fas fa-clock text-muted me-1"></i> Hors service';

                // Si c'est le week-end
                if (day === 0 || day === 6) {
                    statusElement.innerHTML =
                        '<i class="fas fa-calendar-weekend text-muted me-1"></i> Fermé le week-end';
                }

                // Si c'est en dehors des heures d'ouverture mais un jour de semaine
                if ((day >= 1 && day <= 5) && hour < 8) {
                    statusElement.innerHTML = '<i class="fas fa-clock text-muted me-1"></i> Ouvre à 8h';
                } else if ((day >= 1 && day <= 5) && hour >= 17) {
                    statusElement.innerHTML =
                        '<i class="fas fa-moon text-muted me-1"></i> Fermé pour aujourd\'hui';
                }
            }
        }

        // Mettre à jour le statut immédiatement
        updateAvailabilityStatus();

        // Mettre à jour le statut toutes les minutes
        setInterval(updateAvailabilityStatus, 60000);
    });
</script>
