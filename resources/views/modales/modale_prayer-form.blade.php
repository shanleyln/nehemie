<!-- Prayer Request Modal -->
<div class="modal fade" id="prayerModal" tabindex="-1" aria-labelledby="prayerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #5D4037;">
                <h5 class="modal-title text-white" id="prayerModalLabel">Déposer une intention de Prière</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Votre demande sera traitée avec la plus grande confidentialité.</p>

                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form id="prayerForm" action="{{ route('prayer.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="sujet" class="form-label">Sujet</label>
                        <input type="text" class="form-control @error('sujet') is-invalid @enderror" id="sujet"
                            name="sujet" value="{{ old('sujet') }}" required>
                        @error('sujet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label">Votre intention de prière</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                            required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prayerForm = document.getElementById('prayerForm');

        if (prayerForm) {
            prayerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                // Afficher l'état de chargement
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Envoi en cours...';

                // Effacer les messages précédents
                const existingAlerts = document.querySelectorAll('.alert');
                existingAlerts.forEach(alert => alert.remove());

                fetch("{{ route('prayer.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json' // Important pour les réponses d'erreur de validation
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Afficher le message de succès
                            const successAlert = document.createElement('div');
                            successAlert.className = 'alert alert-success';
                            successAlert.textContent = data.message;
                            prayerForm.prepend(successAlert);

                            // Réinitialiser le formulaire
                            prayerForm.reset();

                            // Fermer la modale après 2 secondes
                            // setTimeout(() => {
                            //     const modal = bootstrap.Modal.getInstance(document
                            //         .getElementById('prayerModal'));
                            //     modal.hide();

                            //     // Rafraîchir la page pour vider les messages de session
                            //     // window.location.reload();
                            // }, 6000);

                        } else {
                            // Afficher le message d'erreur
                            const errorAlert = document.createElement('div');
                            errorAlert.className = 'alert alert-danger';
                            errorAlert.textContent = data.message ||
                                'Une erreur est survenue lors de l\'envoi du formulaire.';
                            prayerForm.prepend(errorAlert);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger';

                        // Gestion des erreurs de validation
                        if (error.errors) {
                            let errorMessage =
                                'Veuillez corriger les erreurs suivantes :<ul class="mb-0 mt-2">';
                            Object.values(error.errors).forEach(err => {
                                errorMessage += `<li>${err[0]}</li>`;
                            });
                            errorMessage += '</ul>';
                            errorAlert.innerHTML = errorMessage;
                        } else {
                            errorAlert.textContent = error.message ||
                                'Une erreur inattendue est survenue. Veuillez réessayer plus tard.';
                        }

                        prayerForm.prepend(errorAlert);
                    })
                    .finally(() => {
                        // Réinitialiser l'état du bouton
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
            });
        }
    });
</script>
