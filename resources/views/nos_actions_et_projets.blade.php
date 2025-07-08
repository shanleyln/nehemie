@extends('layouts.app')

@section('title', 'Nos Actions et Projets')

@section('content')
    {{-- Hero Section (inchangée) --}}
    <section class="position-relative overflow-hidden" style="height: 70vh;">
        <img src="{{ asset('images/slider/projets.jpg') }}" alt="Nos Actions et Projets"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">
        <div class="position-absolute top-50 start-50 translate-middle text-center"
            style="z-index: 3; text-shadow: 2px 2px 4px rgb(0, 0, 0);">
            <h1 class="display-5 fw-bold text-white">Nos Actions et Projets</h1>
        </div>
    </section>

    {{-- Section principale avec contenu dynamique --}}
    <section id="actions-projets" class="container mt-5 mb-5">

        <!-- BOUTON POUR OUVRIR LA LISTE DES ÉVÉNEMENTS -->
        <div class="text-center mb-5">
            <button class="btn btn-primary btn-lg" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#events-offcanvas" aria-controls="events-offcanvas">
                <i class="fas fa-list-ul me-2"></i>Voir la liste des actions et projets
            </button>
        </div>

        <!-- CONTENEUR PRINCIPAL POUR LES DÉTAILS DE L'ÉVÉNEMENT -->
        <div id="event-details-content">

            {{-- Placeholder affiché par défaut ou si aucun événement n'est sélectionné --}}
            <div id="event-placeholder" class="text-center text-muted p-5"
                style="min-height: 50vh; border: 2px dashed #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <div>
                    <i class="fas fa-hand-pointer fa-3x mb-3"></i>
                    <h4>Bienvenue dans nos Actions et Projets</h4>
                    <p class="lead">Cliquez sur le bouton ci-dessus pour parcourir nos actions et projets et en afficher
                        les
                        détails ici.</p>
                </div>
            </div>

            {{-- Conteneur pour les détails (rempli par JavaScript) --}}
            <div id="event-details" style="display: none;">
                <h2 id="event-title" class="mb-2"></h2>
                <p id="event-description" class="lead mb-4"></p>

                <!-- Navigation par onglets pour les détails -->
                <div class="tabs-navigation">
                    <div class="tabs-header" id="event-tabs-header">
                        {{-- Les boutons d'onglets seront injectés ici --}}
                    </div>
                </div>

                <!-- Contenu des onglets -->
                <div class="tabs-content" id="event-tabs-content">
                    {{-- Le contenu des onglets sera injecté ici --}}
                </div>
            </div>
        </div>

    </section>


    <!-- MODAL POUR LA VISUALISATION D'IMAGES -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="" class="img-fluid" id="modalImage" alt="Image agrandie">
                </div>
            </div>
        </div>
    </div>


    <!-- FENÊTRE LATÉRALE (OFFCANVAS) POUR LA LISTE DES ÉVÉNEMENTS -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="events-offcanvas" aria-labelledby="events-offcanvas-label">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="events-offcanvas-label">Nos Actions et Projets</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="p-3">
                <input type="search" id="event-search-bar" class="form-control" placeholder="Rechercher un événement...">
            </div>
            <div id="event-list" class="event-list-container">
                <!-- La liste des événements sera injectée ici par JavaScript -->
            </div>
        </div>
    </div>


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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- DONNÉES D'EXEMPLE ---
            const eventsData = [{
                    id: 4,
                    title: "Rapport d'Activités 2024",
                    date: "2024-12-18",
                    description: "Rapport annuel présentant les réalisations et la vision de l'ONG Néhémie International pour l'année 2024. Ce document inclut le mot du président, une présentation détaillée de l'ONG, ses missions, et un bilan des actions menées.",
                    documents: [{
                        title: "Rapport d'Activités ONG NÉHÉMIE 2024",
                        url: "{{ asset('pdf/Rapport_Activites_Nehemie_2024.pdf') }}",
                        type: "PDF",
                        size: "N/A"
                    }],
                    videos: [],
                    images: []
                },
                {
                    id: 1,
                    title: "Campagne de Construction pour la Veuve Mboumba",
                    date: "2024-07-15",
                    description: "Un projet visant à construire une maison décente pour la veuve Mboumba et sa famille, mobilisant des bénévoles et des donateurs pour fournir un abri sûr.",
                    documents: [],
                    videos: [{
                        youtubeId: "83OM-xm7MWM",
                        title: "La minute du Bâtisseur"
                    }, {
                        youtubeId: "II4s03zenqk",
                        title: "Appel à l'action"
                    }],
                    images: [{
                        src: "{{ asset('images/actions_projets/act1.jpg') }}",
                        alt: "Chantier"
                    }, {
                        src: "{{ asset('images/actions_projets/act4.jpg') }}",
                        alt: "Bénévoles"
                    }]
                },
                {
                    id: 2,
                    title: "Consécration de l'Année 2025",
                    date: "2024-05-10",
                    description: "Rassemblement pour célébrer les réussites et consacrer l'année à venir.",
                    documents: [],
                    videos: [{
                        youtubeId: "LQ-IQJfyYKg",
                        title: "Consécration 2025"
                    }],
                    images: [{
                        src: "{{ asset('images/actions_projets/act3.jpg') }}",
                        alt: "Rassemblement"
                    }]
                }
            ];

            const eventListContainer = document.getElementById('event-list');
            const searchBar = document.getElementById('event-search-bar');
            const placeholder = document.getElementById('event-placeholder');
            const eventDetailsContainer = document.getElementById('event-details');
            const offcanvasElement = document.getElementById('events-offcanvas');
            const bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);

            // --- FONCTIONS DE GÉNÉRATION HTML ---

            function renderEventList(events) {
                eventListContainer.innerHTML = '';
                if (events.length === 0) {
                    eventListContainer.innerHTML =
                        '<p class="text-center text-muted p-3">Aucun événement trouvé.</p>';
                    return;
                }
                events.forEach(event => {
                    const item = document.createElement('div');
                    item.className = 'event-list-item';
                    item.setAttribute('data-id', event.id);
                    item.innerHTML = `
                        <h5>${event.title}</h5>
                        <p>${new Date(event.date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                    `;
                    eventListContainer.appendChild(item);
                });
            }

            function displayEventDetails(eventId) {
                const event = eventsData.find(e => e.id == eventId);
                if (!event) return;

                // Gérer l'état actif dans la liste d'événements
                document.querySelectorAll('#event-list .event-list-item').forEach(item => {
                    item.classList.remove('active');
                });
                const activeListItem = document.querySelector(`#event-list .event-list-item[data-id='${eventId}']`);
                if (activeListItem) {
                    activeListItem.classList.add('active');
                }

                placeholder.style.display = 'none';
                eventDetailsContainer.style.display = 'block';

                document.getElementById('event-title').textContent = event.title;
                document.getElementById('event-description').textContent = event.description;

                const tabsHeader = document.getElementById('event-tabs-header');
                const tabsContent = document.getElementById('event-tabs-content');
                tabsHeader.innerHTML = '';
                tabsContent.innerHTML = '';
                let isFirstTab = true;

                // Onglet Documents
                if (event.documents.length > 0) {
                    tabsHeader.innerHTML +=
                        `<button class="tab-btn ${isFirstTab ? 'active' : ''}" data-tab="event-documents">Documents</button>`;
                    tabsContent.innerHTML +=
                        `<div id="event-documents" class="tab-pane ${isFirstTab ? 'active' : ''}"><div class="documents-list">${event.documents.map(doc => `
                                                            <div class="document-item">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                                                    <div>
                                                                        <a href="#" data-url="${doc.url}" class="fw-bold pdf-view-link">${doc.title}</a>
                                                                        <small class="d-block text-muted">${doc.type} - ${doc.size}</small>
                                                                    </div>
                                                                </div>
                                                                <a href="${doc.url}" class="btn btn-outline-primary btn-sm" download="${doc.title.replace(/ /g, '_')}.pdf">
                                                                    <i class="fas fa-download me-1"></i> Télécharger
                                                                </a>
                                                            </div>
                                                        `).join('')}</div></div>`;
                    isFirstTab = false;
                }
                // Onglet Vidéos
                if (event.videos.length > 0) {
                    tabsHeader.innerHTML +=
                        `<button class="tab-btn ${isFirstTab ? 'active' : ''}" data-tab="event-videos">Vidéos</button>`;
                    tabsContent.innerHTML +=
                        `<div id="event-videos" class="tab-pane ${isFirstTab ? 'active' : ''}"><div class="videos-grid">${event.videos.map(video => `<div class="video-item"><div class="video-wrapper"><iframe src="https://www.youtube.com/embed/${video.youtubeId}" title="${video.title}" frameborder="0" allowfullscreen></iframe></div></div>`).join('')}</div></div>`;
                    isFirstTab = false;
                }
                // Onglet Images
                if (event.images.length > 0) {
                    tabsHeader.innerHTML +=
                        `<button class="tab-btn ${isFirstTab ? 'active' : ''}" data-tab="event-images">Galerie</button>`;
                    tabsContent.innerHTML +=
                        `<div id="event-images" class="tab-pane ${isFirstTab ? 'active' : ''}"><div class="gallery-grid">${event.images.map(image => `
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="${image.src}" data-img-alt="${image.alt}">
                                                                <div class="gallery-item"><img src="${image.src}" alt="${image.alt}"></div>
                                                            </a>
                                                        `).join('')}</div></div>`;
                    isFirstTab = false;
                }

                initializeTabs();
            }

            function initializeTabs() {
                const tabButtons = document.querySelectorAll('#event-tabs-header .tab-btn');
                const tabPanes = document.querySelectorAll('#event-tabs-content .tab-pane');
                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        tabButtons.forEach(btn => btn.classList.remove('active'));
                        tabPanes.forEach(pane => pane.classList.remove('active'));
                        button.classList.add('active');
                        document.getElementById(button.getAttribute('data-tab')).classList.add(
                            'active');
                    });
                });
            }

            // --- GESTIONNAIRES D'ÉVÉNEMENTS ---

            searchBar.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const filteredEvents = eventsData.filter(event => event.title.toLowerCase().includes(
                    searchTerm));
                renderEventList(filteredEvents);
            });

            eventListContainer.addEventListener('click', (e) => {
                const eventItem = e.target.closest('.event-list-item');
                if (eventItem) {
                    const eventId = eventItem.getAttribute('data-id');
                    displayEventDetails(eventId);

                    // Ferme l'offcanvas après la sélection
                    bsOffcanvas.hide();
                }
            });

            // Ouvre les PDF dans une nouvelle fenêtre centrée
            document.addEventListener('click', function(e) {
                const pdfLink = e.target.closest('.pdf-view-link');
                if (pdfLink) {
                    e.preventDefault();
                    const pdfUrl = pdfLink.getAttribute('data-url');

                    const winWidth = 800;
                    const winHeight = 700;
                    const left = (screen.width - winWidth) / 2;
                    const top = (screen.height - winHeight) / 2;

                    const windowFeatures =
                        `width=${winWidth},height=${winHeight},top=${top},left=${left},resizable=yes,scrollbars=yes`;
                    window.open(pdfUrl, 'pdf-viewer', windowFeatures);
                }
            });

            // --- GESTION DE LA MODALE IMAGE ---
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const triggerElement = event.relatedTarget;
                const imageSrc = triggerElement.getAttribute('data-img-src');
                const imageAlt = triggerElement.getAttribute('data-img-alt');
                modalImage.src = imageSrc;
                modalImage.alt = imageAlt;
            });

            // --- INITIALISATION ---
            renderEventList(eventsData);

            // Afficher le premier événement par défaut s'il y en a
            if (eventsData.length > 0) {
                displayEventDetails(eventsData[0].id);
            }
        });
    </script>

@endsection
