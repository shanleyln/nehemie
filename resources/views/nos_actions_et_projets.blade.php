@extends('layouts.app')

@section('title', 'Nos Actions et Projets')
@section('content')
    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 50vh;">
        <!-- Image de fond -->
        <img src="{{ asset('images/notre-histoire.jpg') }}" alt="Nos Actions et Projets"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">

        <!-- Filtre sombre sur toute l’image -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75" style="z-index: 2;"></div>

        <!-- Titre centré -->
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 3;">
            <h1 class="display-5 fw-bold text-center text-white">Nos Actions et Projets</h1>
        </div>
    </section>

    <style>
        /* Styles pour les onglets */
        .tabs-navigation {
            margin: 40px 0 30px;
            text-align: center;
        }

        .tabs-header {
            display: inline-flex;
            background: #f5f5f5;
            border-radius: 50px;
            padding: 5px;
            margin-bottom: 30px;
        }

        .tab-btn {
            padding: 12px 25px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 16px;
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

        /* Styles pour la grille de vidéos */
        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .video-item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .video-item:hover {
            transform: translateY(-5px);
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
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

        .video-item h4 {
            padding: 15px 20px 5px;
            margin: 0;
            color: #333;
        }

        .video-item p {
            padding: 0 20px 20px;
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        /* Styles pour la galerie photos */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .gallery-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px 15px;
            font-size: 14px;
            text-align: center;
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
        // Gestion des onglets
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Retirer la classe active de tous les boutons et panneaux
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabPanes.forEach(pane => pane.classList.remove('active'));

                    // Ajouter la classe active au bouton cliqué
                    button.classList.add('active');

                    // Afficher le panneau correspondant
                    const tabId = button.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });

            // Gestion du carrousel de témoignages
            const testimonials = document.querySelectorAll('.testimonial');
            const dots = document.querySelectorAll('.testimonial-dot');
            let currentIndex = 0;

            function showTestimonial(index) {
                testimonials.forEach(testimonial => testimonial.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                testimonials[index].classList.add('active');
                dots[index].classList.add('active');
                currentIndex = index;
            }

            // Navigation par points
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showTestimonial(index));
            });

            // Boutons précédent/suivant
            document.querySelector('.testimonial-control.prev').addEventListener('click', () => {
                const newIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
                showTestimonial(newIndex);
            });

            document.querySelector('.testimonial-control.next').addEventListener('click', () => {
                const newIndex = (currentIndex + 1) % testimonials.length;
                showTestimonial(newIndex);
            });

            // Défilement automatique
            setInterval(() => {
                const newIndex = (currentIndex + 1) % testimonials.length;
                showTestimonial(newIndex);
            }, 5000);
        });
    </script>

    <!-- Section Actions et Témoignages -->
    <section id="actions-temoignages" class="actions-testimonials-section mt-5 mb-5">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                {{-- <h2>Nos Actions et Projets</h2> --}}
                <div class="heading-line center"></div>
                <p class="section-subtitle">Découvrez notre impact à travers différents médias</p>
            </div>

            <!-- Navigation par onglets -->
            <div class="tabs-navigation" data-aos="fade-up">
                <div class="tabs-header">
                    <button class="tab-btn active" data-tab="temoignages">Témoignages</button>
                    <button class="tab-btn" data-tab="videos">Vidéos</button>
                    <button class="tab-btn" data-tab="images">Galerie Photos</button>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div class="tabs-content">
                <!-- Onglet Témoignages -->
                <div id="temoignages" class="tab-pane active">
                    <div class="testimonials-slider">
                        <div class="testimonials-wrapper">
                            <div class="testimonial active">
                                <div class="testimonial-content">
                                    <div class="testimonial-quote">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <p>Grâce à la formation en entrepreneuriat de NÉHÉMIE, j'ai pu lancer ma
                                        petite entreprise et subvenir aux besoins de ma famille. C'est bien plus
                                        qu'une aide, c'est une transformation complète de ma vie.</p>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('images/logo2.png') }}" alt="Marie Koumba">
                                        <div class="author-info">
                                            <h4>Marie Koumba</h4>
                                            <p>Bénéficiaire du Programme TIMOTHÉE</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="testimonial">
                                <div class="testimonial-content">
                                    <div class="testimonial-quote">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <p>L'accompagnement spirituel reçu au travers du programme DANIEL m'a redonné
                                        espoir et force dans une période difficile. Je suis reconnaissant pour
                                        leur écoute et leurs prières.</p>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('images/logo2.png') }}" alt="Paul Ntoutoume">
                                        <div class="author-info">
                                            <h4>Paul Ntoutoume</h4>
                                            <p>Participant au Programme DANIEL</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial">
                                <div class="testimonial-content">
                                    <div class="testimonial-quote">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <p>En tant que partenaire, nous sommes impressionnés par le dévouement et la
                                        transparence de NÉHÉMIE International. Leur impact sur la communauté est
                                        tangible.</p>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('images/logo2.png') }}" alt="M. Diallo Ibrahim">
                                        <div class="author-info">
                                            <h4>M. Diallo Ibrahim</h4>
                                            <p>Directeur, Fondation Espoir</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonials-controls">
                            <button class="testimonial-control prev" aria-label="Témoignage précédent">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="testimonial-dots">
                                <button class="testimonial-dot active" aria-label="Témoignage 1"></button>
                                <button class="testimonial-dot" aria-label="Témoignage 2"></button>
                                <button class="testimonial-dot" aria-label="Témoignage 3"></button>
                            </div>
                            <button class="testimonial-control next" aria-label="Témoignage suivant">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Onglet Vidéos -->
                <div id="videos" class="tab-pane">
                    <div class="videos-grid">
                        <div class="video-item">
                            <div class="video-wrapper">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/LQ-IQJfyYKg?si=N0Eg9aEs21D7uDQQ"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <h4>Néhémie International Consécration de l'année 2025</h4>
                            <p>Une réunion avec les dirigeants et les bénévoles pour célébrer l'année 2025.</p>
                        </div>
                        <div class="video-item">
                            <div class="video-wrapper">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/83OM-xm7MWM?si=BuNVtSpZGUn5Rve3"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <h4>La minute du Bâtisseur</h4>
                            <p>Appel aux bénévoles; Construisons ensemble l'avenir de la veuve Mboumba</p>
                        </div>
                        <div class="video-item">
                            <div class="video-wrapper">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/II4s03zenqk?si=48NeYxWXmSkmqlvR"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <h4>Urgent!!! Appel à l'action</h4>
                            <p>Aidons la veuve et sa famille à couvrir leur maison!</p>
                        </div>
                    </div>
                </div>

                <!-- Onglet Galerie Photos -->
                <div id="images" class="tab-pane">
                    <div class="gallery-grid">
                        <div class="gallery-item">
                            <img src="{{ asset('images/actions_projets/act6.jpg') }}" alt="Formation en entrepreneuriat">
                            <div class="gallery-caption">Formation en entrepreneuriat</div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('images/actions_projets/act2.jpg') }}" alt="Événement communautaire">
                            <div class="gallery-caption">Événement communautaire</div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('images/actions_projets/act3.jpg') }}"
                                alt="Rencontre avec les bénéficiaires">
                            <div class="gallery-caption">Rencontre avec les bénéficiaires</div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('images/actions_projets/act4.jpg') }}" alt="Projet communautaire">
                            <div class="gallery-caption">Projet communautaire</div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('images/actions_projets/act5.jpg') }}" alt="Notre équipe">
                            <div class="gallery-caption">Notre équipe dévouée</div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('images/actions_projets/act1.jpg') }}" alt="Action humanitaire">
                            <div class="gallery-caption">Action humanitaire</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
