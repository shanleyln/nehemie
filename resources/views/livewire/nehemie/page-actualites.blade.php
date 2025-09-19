{{-- resources/views/livewire/nehemie/page-actualites.blade.php --}}
<div class="space-y-4">
    <div class="container py-5">
        <div id="taggbox-loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2">Chargement des actualités en cours...</p>
        </div>
        <div class="taggbox" style="width:100%;height:100%;overflow:auto;" data-widget-id="300959" data-website="1"></div>
        <script src="https://widget.taggbox.com/embed.min.js" type="text/javascript"></script>
        <script src="https://widget.taggbox.com/embed.min.js" type="text/javascript"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadingElement = document.getElementById('taggbox-loading');
                const taggboxElement = document.querySelector('.taggbox');

                // Afficher le contenu Taggbox après un délai pour s'assurer qu'il est chargé
                setTimeout(() => {
                    if (loadingElement) loadingElement.style.display = 'none';
                    if (taggboxElement) taggboxElement.style.display = 'block';
                }, 2000); // Délai de 2 secondes avant de masquer le chargement
            });
        </script>
    </div>
</div>
