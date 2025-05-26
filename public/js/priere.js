document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la soumission du formulaire de prière
    const priereForm = document.getElementById('priereForm');
    if (priereForm) {
        priereForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(priereForm);
            const submitButton = priereForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            // Désactiver le bouton et afficher un indicateur de chargement
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Envoi en cours...';
            
            // Envoyer la requête AJAX
            fetch(priereForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher le message de succès
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success';
                    alertDiv.textContent = data.message;
                    
                    // Remplacer le formulaire par le message de succès
                    priereForm.innerHTML = '';
                    priereForm.appendChild(alertDiv);
                    
                    // Fermer automatiquement la modale après 3 secondes
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('priereModal'));
                        if (modal) modal.hide();
                        
                        // Réinitialiser le formulaire après la fermeture de la modale
                        priereForm.reset();
                        priereForm.innerHTML = document.querySelector('#priereForm').innerHTML;
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer.');
            })
            .finally(() => {
                // Réactiver le bouton et restaurer le texte original
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
    
    // Réinitialiser le formulaire lorsque la modale est fermée
    const priereModal = document.getElementById('priereModal');
    if (priereModal) {
        priereModal.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('priereForm');
            if (form) {
                form.reset();
                // Supprimer les messages d'erreur
                const errorMessages = form.querySelectorAll('.invalid-feedback');
                errorMessages.forEach(el => el.remove());
                // Réinitialiser les classes is-invalid
                const invalidInputs = form.querySelectorAll('.is-invalid');
                invalidInputs.forEach(el => el.classList.remove('is-invalid'));
            }
            // Réinitialiser le formulaire avec le contenu original si nécessaire
            const successAlert = form ? form.querySelector('.alert-success') : null;
            if (successAlert && form) {
                form.innerHTML = document.querySelector('#priereForm').innerHTML;
            }
        });
    }
});
