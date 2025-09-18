<div>
    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 70vh;">
        <img src="{{ asset('images/slider/Evenement.jpg') }}" alt="Actualités"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">
        <div class="position-absolute top-50 start-50 translate-middle text-center"
            style="z-index: 3; text-shadow: 2px 2px 4px rgb(0, 0, 0);">
            <h1 class="display-5 fw-bold text-white">Actualités</h1>
        </div>
    </section>

    {{-- <div class="container py-5">
        <div class="section-heading text-center">
            <h2>Dernières actualités</h2>
            <div class="heading-line center"></div>
            <p class="section-subtitle">Restez informés de nos dernières actions et événements</p>
        </div>

        @if ($isLoading)
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3">Chargement des actualités...</p>
            </div>
        @elseif($error)
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}
                <button wire:click="loadActualites" class="btn btn-sm btn-outline-danger ms-3">
                    <i class="fas fa-sync-alt me-1"></i> Réessayer
                </button>
            </div>
        @else
            <div class="row g-4">
                <!-- Article vedette -->
                @if ($featured)
                    <div class="col-12 mb-5">
                        <div class="card shadow-sm h-100 border-0">
                            @if (!empty($featured['fichier_cover']))
                                <img src="{{ $featured['fichier_cover'] }}" class="card-img-top"
                                    alt="Actualité à la une" style="height: 400px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary me-2">À la une</span>
                                    <small class="text-muted">{{ $featured['date_formatted'] ?? '' }}</small>
                                </div>
                                <h3 class="h4 card-title mb-3">Dernière actualité</h3>
                                <div class="card-text mb-3">
                                    @php
                                        $featuredParagraphs = array_filter(
                                            explode("\n", $featured['texte_publication']),
                                            function ($p) {
                                                return trim($p) !== '';
                                            },
                                        );
                                        $featuredPreview = array_slice($featuredParagraphs, 0, 3);
                                    @endphp

                                    @foreach ($featuredPreview as $index => $paragraph)
                                        <p class="mb-2">{{ trim($paragraph) }}</p>
                                    @endforeach

                                    <button class="btn btn-link p-0 text-primary mt-2"
                                        wire:click="showFullNews({
                                            title: 'Dernière actualité',
                                            content: {{ json_encode(implode("\n\n", $featuredParagraphs)) }},
                                            image: '{{ $featured['fichier_cover'] ?? '' }}',
                                            date: '{{ $featured['date_formatted'] ?? '' }}',
                                            author: '{{ $featured['username'] ?? '' }}'
                                        })">
                                        Ouvrir la publication
                                    </button>
                                </div>
                                @if (!empty($featured['username']))
                                    <div class="mt-3 text-muted small">
                                        <i class="fas fa-user me-1"></i> Publié par {{ $featured['username'] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Liste des autres articles -->
                @forelse($publications as $publication)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            @if (!empty($publication['fichier_cover']))
                                <img src="{{ $publication['fichier_cover'] }}" class="card-img-top"
                                    alt="Actualité NÉHÉMIE" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <small
                                    class="text-muted d-block mb-2">{{ $publication['date_formatted'] ?? '' }}</small>
                                <h4 class="h5 card-title mb-3">Actualité</h4>
                                <div class="card-text mb-3">
                                    @php
                                        $paragraphs = array_filter(
                                            explode("\n", $publication['texte_publication']),
                                            function ($p) {
                                                return trim($p) !== '';
                                            },
                                        );
                                        $previewParagraphs = array_slice($paragraphs, 0, 2);
                                    @endphp

                                    @foreach ($previewParagraphs as $index => $paragraph)
                                        <p class="{{ $index === 0 ? '' : 'mb-2' }}">
                                            {{ trim($paragraph) }}
                                        </p>
                                    @endforeach

                                    <button class="btn btn-link p-0 text-primary mt-2"
                                        wire:click="showFullNews({
                                            title: 'Actualité',
                                            content: {{ json_encode(implode("\n\n", $paragraphs)) }},
                                            image: '{{ $publication['fichier_cover'] ?? '' }}',
                                            date: '{{ $publication['date_formatted'] ?? '' }}',
                                            author: '{{ $publication['username'] ?? '' }}'
                                        })">
                                        Ouvrir la publication
                                    </button>
                                </div>
                                @if (!empty($publication['username']))
                                    <div class="mt-2 text-muted small">
                                        <i class="fas fa-user me-1"></i> {{ $publication['username'] }}
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Aucune actualité disponible pour le moment.
                        </div>
                    </div>
                @endforelse
            </div>
        @endif
    </div> --}}

    <!-- Modal Livewire pour afficher l'actualité complète -->
    {{-- <div class="modal" tabindex="-1"
        style="display: {{ $showModal ? 'block' : 'none' }}; background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    @if ($modalDate)
                        <div class="text-muted mb-3">{{ $modalDate }}</div>
                    @endif

                    @if ($modalImage)
                        <div class="mb-4 text-center">
                            <img src="{{ $modalImage }}" alt="{{ $modalTitle }}" class="img-fluid rounded">
                        </div>
                    @endif

                    <div style="white-space: pre-line;">{{ $modalContent }}</div>

                    @if ($modalAuthor)
                        <div class="mt-3 text-muted small">
                            <i class="fas fa-user me-1"></i> Publié par {{ $modalAuthor }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Fermer</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container py-5">
        <div id="taggbox-loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2">Chargement des actualités en cours...</p>
        </div>
        <div class="taggbox" style="width:100%;height:100%;overflow:auto;display:none;" data-widget-id="300959" data-website="1">
        </div>
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

    @if ($showModal)
        <div class="modal-backdrop fade show"></div>
    @endif

    @push('styles')
        <style>
            .card {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 0, 0, .08);
                border-radius: 0.75rem;
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
                background: #fff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
                border-color: rgba(0, 0, 0, 0.1);
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
                border-color: rgba(0, 0, 0, .2);
            }

            .badge {
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.35em 0.65em;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .card-img-top {
                object-fit: cover;
                width: 100%;
            }

            .card-body {
                padding: 1.75rem;
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .card-title {
                color: #2c3e50;
                font-weight: 600;
            }

            .card-text {
                color: #4a5568;
                line-height: 1.7;
                flex: 1;
            }

            .card-footer {
                background-color: #f8f9fa;
                border-top: 1px solid rgba(0, 0, 0, .05);
                padding: 1rem 1.75rem;
            }

            .btn-link {
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .btn-link:hover {
                text-decoration: underline;
            }

            .modal-content {
                border: none;
                border-radius: 0.75rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .modal-header {
                border-bottom: 1px solid #f0f0f0;
                padding: 1.5rem 2rem;
            }

            .modal-body {
                padding: 2rem;
            }

            .modal-title {
                font-weight: 600;
                color: #2c3e50;
            }

            #newsContent {
                font-size: 1.05rem;
                line-height: 1.8;
                color: #4a5568;
            }

            .card-text {
                flex: 1;
                overflow: hidden;
            }

            .card-text p:last-child {
                margin-bottom: 0;
            }

            .card-text p:first-child {
                margin-top: 0;
            }

            .card-footer {
                background-color: rgba(0, 0, 0, .02);
                border-top: 1px solid rgba(0, 0, 0, .05);
                padding: 0.75rem 1.5rem;
            }

            .section-heading {
                margin-bottom: 3rem;
            }

            .heading-line {
                width: 80px;
                height: 3px;
                background: #0d6efd;
                margin: 1.5rem auto;
                position: relative;
            }

            .heading-line::after {
                content: '';
                position: absolute;
                width: 40px;
                height: 3px;
                background: #6c757d;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
            }
        </style>
    @endpush

</div>
