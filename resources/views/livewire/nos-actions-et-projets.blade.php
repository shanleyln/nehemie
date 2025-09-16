<div>
    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 70vh;">
        <img src="{{ asset('images/slider/projets.jpg') }}" alt="Nos Actions et Projets"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">
        <div class="position-absolute top-50 start-50 translate-middle text-center"
            style="z-index: 3; text-shadow: 2px 2px 4px rgb(0, 0, 0);">
            <h1 class="display-5 fw-bold text-white">Nos Actions et Projets</h1>
        </div>
    </section>

    {{-- Section principale --}}
    <section id="actions-projets" class="container mt-5 mb-5">
        <div class="text-center mb-5">
            <button class="btn btn-primary btn-lg" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#events-offcanvas" aria-controls="events-offcanvas">
                <i class="fas fa-list-ul me-2"></i>Voir la liste des actions et projets
            </button>
        </div>

        <div id="event-details-content">
            <div id="event-placeholder" class="text-center text-muted p-5"
                style="min-height: 50vh; border: 2px dashed #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <div>
                    <i class="fas fa-hand-pointer fa-3x mb-3"></i>
                    <h4>Bienvenue dans nos Actions et Projets</h4>
                    <p class="lead">Cliquez sur le bouton ci-dessus pour parcourir nos actions et projets.</p>
                </div>
            </div>
            <div id="event-details" style="display: none;">
                <h2 id="event-title" class="mb-2"></h2>
                <p id="event-description" class="lead mb-4"></p>
                <div class="tabs-navigation">
                    <div class="tabs-header" id="event-tabs-header"></div>
                </div>
                <div class="tabs-content" id="event-tabs-content"></div>
            </div>
        </div>
    </section>

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
    <div class="offcanvas offcanvas-start" tabindex="-1" id="events-offcanvas"
        aria-labelledby="events-offcanvas-label">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="events-offcanvas-label">Nos Actions et Projets</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="p-3"><input type="search" id="event-search-bar" class="form-control"
                    placeholder="Rechercher..."></div>
            <div id="event-list" class="event-list-container"></div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Styles pour la liste d'événements dans l'offcanvas */
            .event-list-container {
                /* Le body de l'offcanvas gère le scroll */
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
                font-size: 1rem;
                font-weight: 600;
            }

            .event-list-item p {
                margin-bottom: 0;
                font-size: 0.85rem;
                color: #6c757d;
            }

            /* Styles existants pour les onglets et galeries (légèrement ajustés) */
            .tabs-navigation {
                margin: 20px 0;
                text-align: left;
            }

            .tabs-header {
                display: inline-flex;
                background: #f5f5f5;
                border-radius: 50px;
                padding: 5px;
                margin-bottom: 20px;
            }

            .tab-btn {
                padding: 10px 20px;
                border: none;
                background: transparent;
                cursor: pointer;
                font-size: 15px;
                font-weight: 600;
                color: #555;
                border-radius: 50px;
                transition: all 0.3s ease;
            }

            .tab-btn.active {
                background: #4a90e2;
                color: #fff;
                box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
            }

            .tab-pane {
                display: none;
                animation: fadeIn 0.5s ease;
            }

            .tab-pane.active {
                display: block;
            }

            .videos-grid,
            .gallery-grid,
            .documents-list {
                margin-top: 20px;
            }

            .videos-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
            }

            .video-item {
                background: #fff;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            }

            .video-wrapper {
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
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
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .gallery-item {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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
                padding: 15px;
                background-color: #fff;
                border: 1px solid #eee;
                border-radius: 8px;
                margin-bottom: 10px;
                transition: box-shadow 0.3s ease;
            }

            .document-item:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .document-item i {
                font-size: 24px;
                color: #4a90e2;
                margin-right: 15px;
            }

            .document-item a {
                text-decoration: none;
                color: #333;
                font-weight: 600;
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
            @media (max-width: 768px) {
                .tabs-header {
                    flex-direction: column;
                    width: 100%;
                    border-radius: 10px;
                    padding: 5px;
                }

                .tab-btn {
                    width: 100%;
                    border-radius: 5px;
                    margin-bottom: 5px;
                }

                .videos-grid,
                .gallery-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
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

                function initializeTabs() {
                    const tabButtons = document.querySelectorAll('#event-tabs-header .tab-btn');
                    tabButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            tabButtons.forEach(btn => btn.classList.remove('active'));
                            document.querySelectorAll('#event-tabs-content .tab-pane').forEach(pane => pane
                                .classList.remove('active'));
                            button.classList.add('active');
                            document.getElementById(button.getAttribute('data-tab')).classList.add('active');
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
