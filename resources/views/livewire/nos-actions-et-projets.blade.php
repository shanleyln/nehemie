<div>
    {{-- Hero Section --}}
    <section class="hero-section position-relative overflow-hidden py-5 py-lg-7"
        style="background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url('{{ asset('images/slider/projets.jpg') }}') no-repeat center center/cover; height: 70vh; display: flex; align-items: center;">
        <div class="container position-relative z-index-2">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="hero-content text-white">
                        <h1 class="display-4 fw-bold mb-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3); color: #fff;">
                            Nos Actions et
                            Projets</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section principale --}}
    <section id="actions-projets" class="py-5 py-lg-7 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <button class="btn btn-primary btn-lg shadow-sm" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#events-offcanvas" aria-controls="events-offcanvas">
                    <i class="fas fa-list-ul me-2"></i>Explorer nos actions
                </button>
            </div>

            <div id="event-details-content" class="shadow-sm rounded-3 overflow-hidden">
                <div id="event-placeholder" class="text-center text-muted p-5 bg-light"
                    style="min-height: 50vh; border: 2px dashed rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                    <div class="py-5">
                        <div class="icon-wrapper mb-4">
                            <i class="fas fa-hand-pointer fa-3x text-primary"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Bienvenue dans nos Actions et Projets</h4>
                        <p class="lead text-muted mb-4">Parcourez nos différentes actions et projets en cliquant sur le
                            bouton ci-dessus.</p>
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#events-offcanvas" aria-controls="events-offcanvas">
                            <i class="fas fa-arrow-right me-2"></i>Commencer l'exploration
                        </button>
                    </div>
                </div>
                <div id="event-details" class="bg-white p-4 p-md-5 rounded-3" style="display: none;">
                    <h1 id="event-title" class="display-5 fw-bold text-dark mb-4"></h1>
                    <p id="event-description" class="lead text-muted mb-5"></p>

                    <div class="tabs-navigation mb-4">
                        <div class="tabs-header" id="event-tabs-header" role="tablist"
                            aria-label="Navigation des médias">
                            <!-- Les onglets seront ajoutés ici dynamiquement -->
                        </div>
                    </div>
                    <div class="tabs-content position-relative" id="event-tabs-content">
                        <div class="tab-loading"
                            style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 10; display: flex; align-items: center; justify-content: center;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                        <!-- Le contenu des onglets sera ajouté ici dynamiquement -->
                    </div>
                </div>
            </div>
    </section>
</div>

{{-- Modale Image --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0"><button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body p-0 text-center"><img src="" class="img-fluid" id="modalImage"
                    alt="Image agrandie"></div>
        </div>
    </div>
</div>

{{-- Offcanvas --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="events-offcanvas" aria-labelledby="events-offcanvas-label"
    style="width: 400px; max-width: 100%;">
    <div class="offcanvas-header text-white">
        <div>
            <h5 class="offcanvas-title mb-1" id="events-offcanvas-label">Nos Actions et Projets</h5>
            <p class="small mb-0" style="color: #000000;">Sélectionnez un projet pour voir les détails</p>
        </div>
        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column">
        <div class="p-3 border-bottom">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="search" id="event-search-bar" class="form-control border-start-0"
                    placeholder="Rechercher un projet...">
            </div>
        </div>
        <div id="event-list" class="event-list-container flex-grow-1" style="overflow-y: auto;">
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3 text-muted">Chargement des projets...</p>
            </div>
        </div>
        <div class="p-3 border-top text-center">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="offcanvas">
                <i class="fas fa-times me-1"></i> Fermer
            </button>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Styles généraux */
        .hero-section {
            position: relative;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7));
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .hero-content {
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .section-title {
            font-size: 2.2rem;
            color: #2c3e50;
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: #4a90e2;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        /* Styles pour la liste d'événements dans l'offcanvas */
        .event-list-container {
            height: 100%;
            overflow-y: auto;
            padding: 10px 0;
        }

        .event-list-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .event-list-item:hover {
            background-color: #f5f5f5;
        }

        .event-list-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .event-list-item:hover {
            background-color: #f5f5f5;
        }

        /* La classe 'active' peut être utilisée si vous voulez garder une trace visuelle */
        .event-list-item.active {
            background-color: #e3f2fd;
            border-left: 4px solid #4a90e2;
        }

        .event-list-item h5 {
            margin-bottom: 5px;
            font-size: 1.05rem;
            font-weight: 600;
            color: #2c3e50;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
        }

        .event-list-item h5 i {
            margin-right: 10px;
            color: #4a90e2;
            font-size: 1.1em;
        }

        .event-list-item:hover h5 {
            color: #4a90e2;
        }

        .event-list-item p {
            margin: 5px 0 0 0;
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.5;
            padding-left: 25px;
        }

        .event-list-item .badge {
            font-size: 0.7rem;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            margin-left: 10px;
            background: #e3f2fd;
            color: #1976d2;
        }

        /* Styles pour les onglets */
        .tabs-navigation {
            margin: 30px 0 20px;
            text-align: left;
            position: relative;
        }

        .tabs-navigation:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #f0f0f0;
            z-index: 1;
        }

        .tabs-header {
            display: inline-flex;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 0;
            position: relative;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
        }

        .tab-btn {
            padding: 10px 25px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            color: #6c757d;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
            margin: 0 3px;
        }

        .tab-btn:hover {
            color: #4a90e2;
            background: rgba(74, 144, 226, 0.1);
            transform: translateY(-1px);
        }

        .tab-btn.active {
            background: #4a90e2;
            color: #fff;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.2);
        }

        .tab-btn.active:after {
            content: '';
            position: absolute;
            bottom: -7px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #f8f9fa;
            z-index: 3;
            transition: all 0.3s ease;
        }

        .tab-pane {
            display: none;
            animation: fadeIn 0.5s ease;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .tab-pane.active {
            display: block;
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: #4a90e2;
            bottom: -10px;
            left: 0;
            border-radius: 3px;
        }

        .videos-grid,
        .gallery-grid,
        .documents-list {
            margin-top: 15px;
        }

        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            padding: 10px 0;
        }

        .video-item {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .video-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #000;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            overflow: hidden;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 10px 0;
        }

        .gallery-item {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: white;
            border: 1px solid #f0f0f0;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .gallery-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .gallery-grid a {
            text-decoration: none;
            display: block;
            overflow: hidden;
            border-radius: 10px;
        }

        .gallery-grid a:hover img {
            transform: scale(1.05);
        }

        .document-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .document-item:last-child {
            margin-bottom: 0;
        }

        .document-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-color: #e0e7ff;
        }

        .document-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .document-item i {
            font-size: 24px;
            color: #4a90e2;
            margin-right: 15px;
            min-width: 24px;
            text-align: center;
        }

        .document-item .document-info {
            flex-grow: 1;
        }

        .document-item a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            transition: color 0.2s ease;
            display: block;
            margin-bottom: 3px;
        }

        .document-item a:hover {
            color: #4a90e2;
        }

        .document-item .document-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .pdf-view-link {
            text-decoration: underline;
            cursor: pointer;
        }

        .document-item small {
            color: #6c757d;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive */
        /* Styles responsifs */
        @media (max-width: 1200px) {
            .videos-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .section-title {
                font-size: 1.6rem;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .tab-pane {
                padding: 20px 15px;
            }
        }

        @media (max-width: 768px) {
            .tabs-header {
                flex-direction: column;
                width: 100%;
                border-radius: 8px;
                padding: 5px;
            }

            .tab-btn {
                width: 100%;
                border-radius: 6px;
                margin: 3px 0;
                padding: 12px 20px;
            }

            .tab-btn.active:after {
                display: none;
            }

            .videos-grid,
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .document-item {
                padding: 15px;
            }

            .event-list-item {
                padding: 15px;
                margin: 0 5px 5px;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 1.5rem;
                margin-bottom: 1.2rem;
            }

            .hero-content h1 {
                font-size: 1.8rem;
            }

            .hero-content p.lead {
                font-size: 1.1rem;
            }

            .tab-btn {
                font-size: 0.9rem;
                padding: 10px 15px;
            }

            .document-item {
                flex-direction: column;
                text-align: center;
                padding: 20px 15px;
            }

            .document-item i {
                margin: 0 0 10px 0;
                font-size: 32px;
            }

            .document-item .document-actions {
                margin-top: 10px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Désactiver le smooth scroll par défaut sur les ancres
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du défilement fluide pour les ancres internes
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        const headerOffset = 80; // Hauteur du header fixe
                        const elementPosition = targetElement.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        // Mise à jour de l'URL sans recharger la page
                        if (history.pushState) {
                            history.pushState(null, null, targetId);
                        } else {
                            location.hash = targetId;
                        }
                    }
                });
            });
        });

        function initializeActionsProjets() {
            const eventsData = @json($events);
            if (!Array.isArray(eventsData)) {
                return;
            }

            const eventListContainer = document.getElementById('event-list');
            const searchBar = document.getElementById('event-search-bar');
            const placeholder = document.getElementById('event-placeholder');
            const eventDetailsContainer = document.getElementById('event-details');
            const offcanvasElement = document.getElementById('events-offcanvas');

            if (!eventListContainer || !eventDetailsContainer || !offcanvasElement) {
                return;
            }

            const bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);

            function renderEventList(events) {
                eventListContainer.innerHTML = '';
                if (!events.length) {
                    eventListContainer.innerHTML = '<p class="text-center text-muted p-3">Aucun résultat.</p>';
                    return;
                }
                events.forEach(event => {
                    const item = document.createElement('div');
                    item.className = 'event-list-item d-flex flex-column p-3';
                    item.setAttribute('data-id', event.id);
                    const eventDate = new Date(event.date);
                    const dateString = !isNaN(eventDate.getTime()) ? eventDate.toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }) : 'Date non spécifiée';
                    item.innerHTML =
                        `<h5 class="mb-1">${event.title || 'Sans titre'}</h5><small class="text-muted">${dateString}</small>`;
                    eventListContainer.appendChild(item);
                });
            }

            function displayEventDetails(eventId) {
                const event = eventsData.find(e => e.id == eventId);
                if (!event) return;

                document.querySelectorAll('#event-list .event-list-item').forEach(item => item.classList.remove('active'));
                document.querySelector(`#event-list .event-list-item[data-id='${eventId}']`)?.classList.add('active');

                placeholder.style.display = 'none';
                eventDetailsContainer.style.display = 'block';

                document.getElementById('event-title').textContent = event.title || 'Titre non disponible';
                document.getElementById('event-description').textContent = event.description ||
                    'Description non disponible';

                const tabsHeader = document.getElementById('event-tabs-header');
                const tabsContent = document.getElementById('event-tabs-content');
                tabsHeader.innerHTML = '';
                tabsContent.innerHTML = '';
                let isFirstTab = true;

                const createTab = (id, title, content) => {
                    tabsHeader.innerHTML +=
                        `<button class="tab-btn ${isFirstTab ? 'active' : ''}" data-tab="${id}">${title}</button>`;
                    tabsContent.innerHTML +=
                        `<div id="${id}" class="tab-pane ${isFirstTab ? 'active' : ''}">${content}</div>`;
                    isFirstTab = false;
                };

                if (event.documents?.length > 0) createTab('event-documents', 'Documents',
                    `<div class="documents-list">${event.documents.map(doc => `<div class="document-item"><div class="d-flex align-items-center"><i class="fas fa-file-pdf fa-2x text-danger me-3"></i><div><a href="#" data-url="${doc.url}" class="fw-bold pdf-view-link">${doc.title}</a><small class="d-block text-muted">${doc.type} - ${doc.size}</small></div></div><a href="${doc.url}" class="btn btn-outline-primary btn-sm" download><i class="fas fa-download me-1"></i> Télécharger</a></div>`).join('')}</div>`
                );
                if (event.videos?.length > 0) createTab('event-videos', 'Vidéos',
                    `<div class="videos-grid">${event.videos.map(video => `<div class="video-item"><div class="video-wrapper"><iframe src="https://www.youtube.com/embed/${video.youtubeId}" title="${video.title}" frameborder="0" allowfullscreen></iframe></div></div>`).join('')}</div>`
                );
                if (event.images?.length > 0) createTab('event-images', 'Galerie',
                    `<div class="gallery-grid">${event.images.map(image => `<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="${image.src}" data-img-alt="${image.alt}"><div class="gallery-item"><img src="${image.src}" alt="${image.alt}"></div></a>`).join('')}</div>`
                );

                initializeTabs();
            }

            function switchTab(tabName, event = null) {
                if (event) event.preventDefault();

                // Trouver le conteneur d'onglets parent
                const tabContainer = event ? event.target.closest('.tabs-navigation') : document.querySelector(
                    '.tabs-navigation');
                if (!tabContainer) return;

                // Cacher tous les onglets dans ce conteneur
                const tabPanes = tabContainer.parentElement ? tabContainer.parentElement.querySelectorAll('.tab-pane') : [];
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    pane.style.display = 'none';
                });

                // Désactiver tous les boutons d'onglet dans ce conteneur
                const tabButtons = tabContainer.querySelectorAll('.tab-btn');
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });

                // Activer l'onglet sélectionné avec une animation
                const activePane = document.getElementById(tabName);
                if (activePane) {
                    activePane.style.display = 'block';
                    setTimeout(() => {
                        activePane.classList.add('active');
                    }, 10);
                }

                // Activer le bouton correspondant
                const activeBtn = tabContainer.querySelector(`.tab-btn[data-tab="${tabName}"]`);
                if (activeBtn) {
                    activeBtn.classList.add('active');
                    activeBtn.setAttribute('aria-selected', 'true');

                    // Faire défiler le conteneur d'onglets si nécessaire pour que le bouton soit visible
                    if (tabContainer.scrollWidth > tabContainer.clientWidth) {
                        activeBtn.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                            inline: 'center'
                        });
                    }
                }

                // Mettre à jour l'URL avec un hash
                if (history.pushState) {
                    const newUrl = window.location.pathname + '#' + tabName;
                    window.history.pushState({
                        path: newUrl
                    }, '', newUrl);
                }

                return false;
            }

            function initializeTabs() {
                const tabButtons = document.querySelectorAll('#event-tabs-header .tab-btn');
                tabButtons.forEach(button => {
                    button.addEventListener('click', (e) => {
                        switchTab(button.getAttribute('data-tab'), e);
                    });
                });
            }

            renderEventList(eventsData);

            searchBar.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                renderEventList(eventsData.filter(event => event.title.toLowerCase().includes(searchTerm)));
            });

            eventListContainer.addEventListener('click', (e) => {
                const eventItem = e.target.closest('.event-list-item');
                if (eventItem) {
                    displayEventDetails(eventItem.getAttribute('data-id'));
                    bsOffcanvas.hide();
                }
            });

            document.addEventListener('click', function(e) {
                const pdfLink = e.target.closest('.pdf-view-link');
                if (pdfLink) {
                    e.preventDefault();
                    const pdfUrl = pdfLink.getAttribute('data-url');
                    window.open(pdfUrl, 'pdf-viewer',
                        `width=800,height=700,top=${(screen.height-700)/2},left=${(screen.width-800)/2}`);
                }
            });

            const imageModal = document.getElementById('imageModal');
            if (imageModal) {
                imageModal.addEventListener('show.bs.modal', function(event) {
                    document.getElementById('modalImage').src = event.relatedTarget.getAttribute('data-img-src');
                });
            }

            if (eventsData.length > 0) {
                displayEventDetails(eventsData[0].id);
            }
        }

        document.addEventListener('livewire:initialized', initializeActionsProjets);
        document.addEventListener('livewire:navigated', initializeActionsProjets);
    </script>
@endpush
</div>
