{{-- resources/views/livewire/nehemie/page-actualites.blade.php --}}
<div class="space-y-4">
    <div class="container py-5">
        <div id="taggbox-wrapper-300959" class="relative" style="min-height:220px">
            {{-- Loader overlay --}}
            <div id="taggbox-loader-300959"
                class="absolute inset-0 flex items-center justify-center bg-white/60 backdrop-blur-sm z-10" role="status"
                aria-live="polite">
                <div class="flex items-center gap-3">
                    <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span class="text-sm text-gray-700">Chargement…</span>
                </div>
            </div>

            {{-- Conteneur du widget (ignoré par Livewire) --}}
            <div class="taggbox" wire:ignore style="width:100%;height:100%;overflow:auto;" data-widget-id="300959"
                data-website="1"></div>
        </div>

        {{-- Script d’embed --}}
        <script src="https://widget.taggbox.com/embed.min.js" type="text/javascript"></script>

        {{-- Masquage du loader quand le widget est prêt --}}
        <script>
            (function() {
                const loader = document.getElementById('taggbox-loader-300959');
                const box = document.querySelector('.taggbox[data-widget-id="300959"]');

                function hideLoader() {
                    if (loader) loader.classList.add('hidden');
                }

                // 1) Dès que le script d’embed est chargé, observe le conteneur
                const embedScript = document.querySelector('script[src*="widget.taggbox.com/embed.min.js"]');
                const startObserver = () => {
                    if (!box) {
                        setTimeout(hideLoader, 4000);
                        return;
                    }
                    const mo = new MutationObserver(() => {
                        // Dès que Taggbox insère du contenu, on cache le loader
                        if (box.children.length > 0) {
                            hideLoader();
                            mo.disconnect();
                        }
                    });
                    mo.observe(box, {
                        childList: true,
                        subtree: true
                    });

                    // 2) Fallback sécurité au cas où
                    setTimeout(hideLoader, 8000);
                };

                if (embedScript && !embedScript.dataset._taggboxLoaded) {
                    embedScript.dataset._taggboxLoaded = '1';
                    embedScript.addEventListener('load', startObserver);
                } else {
                    // Si déjà chargé (navigations Livewire, etc.)
                    startObserver();
                }

                // 3) Optionnel : afficher le loader pendant les updates Livewire
                document.addEventListener('livewire:request-start', () => {
                    loader?.classList.remove('hidden');
                });
                document.addEventListener('livewire:request-finish', () => {
                    /* laisser l’observer décider */ });
            })();
        </script>
    </div>
</div>
