<!-- Modal -->
<div class="modal fade" id="priereModal" tabindex="-1" aria-labelledby="priereModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2">
                <h6 class="modal-title mb-0 text-white" id="priereModalLabel">
                    <i class="fas fa-praying-hands me-2"></i>SOS Prière
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-3">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="alert alert-info small mb-3">
                    <h6 class="alert-heading mb-2">Notre engagement</h6>
                    <p class="mb-0">Votre demande sera traitée avec la plus grande discrétion. Nous nous engageons à
                        respecter votre confidentialité.</p>
                </div>

                <p class="small mb-3">Partagez-nous votre demande de prière. Notre équipe s'engage à prier pour vous.
                </p>

                <form id="priereForm" onsubmit="return openMailClient(event);">
                    <div class="row g-3">
                        <!-- Première colonne -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label required">Votre nom</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                    id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label required">Votre email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sujet" class="form-label required">Sujet de prière</label>
                                <input type="text" class="form-control @error('sujet') is-invalid @enderror"
                                    id="sujet" name="sujet" value="{{ old('sujet') }}" required>
                                @error('sujet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deuxième colonne -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="message" class="form-label required">Votre demande de prière</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="10"
                                    style="min-height: 200px;" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox"
                                    class="form-check-input @error('confidentialite') is-invalid @enderror"
                                    id="confidentialite" name="confidentialite"
                                    {{ old('confidentialite') ? 'checked' : '' }} required>
                                <label class="form-check-label small required" for="confidentialite">
                                    J'accepte que ma demande de prière soit partagée de manière anonyme avec l'équipe de
                                    prière
                                </label>
                                @error('confidentialite')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="button" class="btn btn-primary" id="sendPrayerBtn">
                            <i class="fas fa-paper-plane me-2"></i>Ouvrir mon client de messagerie
                        </button>
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const sendBtn = document.getElementById('sendPrayerBtn');
                        
                        sendBtn.addEventListener('click', function() {
                            // Récupérer les valeurs du formulaire
                            const nom = document.getElementById('nom').value;
                            const email = document.getElementById('email').value;
                            const sujet = document.getElementById('sujet').value;
                            const message = document.getElementById('message').value;

                            // Vérifier les champs requis
                            if (!nom || !email || !sujet || !message) {
                                alert('Veuillez remplir tous les champs obligatoires');
                                return;
                            }

                            // Créer le corps du message
                            const body = `Bonjour,\n\nJe souhaite partager une demande de prière :\n\n${message}\n\nCordialement,\n${nom}`;

                            // Créer le lien mailto
                            const mailtoLink = `mailto:info@nehemie-internationale.com?subject=${encodeURIComponent('Demande de prière : ' + sujet)}&body=${encodeURIComponent(body)}&cc=${encodeURIComponent(email)}`;

                            // Fermer la modale
                            const modal = bootstrap.Modal.getInstance(document.getElementById('priereModal'));
                            if (modal) modal.hide();

                            // Ouvrir le client de messagerie
                            window.location.href = mailtoLink;
                        });
                    });
                    </script>
                </form>


            </div>
        </div>
    </div>
</div>
