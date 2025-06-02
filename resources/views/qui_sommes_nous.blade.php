@extends('layouts.app')

@section('title', 'Qui sommes-nous')

@section('content')


    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden" style="height: 50vh;">
        <!-- Image de fond -->
        <img src="{{ asset('images/notre-histoire.jpg') }}" alt="Qui sommes-nous"
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="z-index: 1;">

        <!-- Filtre sombre sur toute l’image -->
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75" style="z-index: 2;"></div>

        <!-- Titre centré -->
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="z-index: 3;">
            <h1 class="display-5 fw-bold text-center text-white">Qui sommes-nous ?</h1>
        </div>
    </section>

    <!-- Section Notre Histoire -->
    <section id="histoire" class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="text-center mb-5">
                        <div class="section-heading text-center" data-aos="fade-up">
                            <h2>Notre Histoire</h2>
                            <div class="heading-line center"></div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <h3 class="h3 mb-4">NÉHÉMIE International</h3>
                                <p class="lead mb-4">Fondée en 2020, notre organisation est née de la vision
                                    partagée de
                                    plusieurs membres engagés de la communauté chrétienne du Gabon, unis par la foi
                                    et
                                    la volonté de faire une différence tangible dans la société.</p>
                                <p class="mb-4">Inspirée par l'exemple biblique de Néhémie, qui a reconstruit les
                                    murailles de Jérusalem, notre organisation s'est donnée pour mission de
                                    reconstruire
                                    les vies brisées et de restaurer l'espérance dans les cœurs.</p>
                                <p class="mb-4">Depuis nos débuts, nous avons œuvré sans relâche pour apporter un
                                    soutien concret aux plus démunis, en nous appuyant sur des valeurs chrétiennes
                                    fortes et un engagement sans faille envers notre communauté.</p>
                            </div>
                        </div>

                        <div class="row g-4 mt-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start bg-light p-4 rounded-3 h-100">
                                    <div class="bg-icon p-3 rounded-circle me-3">
                                        <i class="fas fa-users icon-marron"></i>
                                    </div>
                                    <div>
                                        <h4 class="h5 mb-2">Notre Communauté</h4>
                                        <p class="text-muted mb-0">Une équipe dévouée au service des autres,
                                            répondant aux défis sociaux et spirituels du Gabon.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start bg-light p-4 rounded-3 h-100">
                                    <div class="bg-icon p-3 rounded-circle me-3">
                                        <i class="fas fa-hands-helping icon-marron"></i>
                                    </div>
                                    <div>
                                        <h4 class="h5 mb-2">Notre Impact</h4>
                                        <p class="text-muted mb-0">Des centaines de vies touchées chaque
                                            année à travers nos programmes d'aide et d'accompagnement.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Notre vision & mission -->
    <section id="vision-mission" class="mission-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2>Notre vision & mission</h2>
                <div class="heading-line center"></div>
                <p class="section-subtitle">NÉHÉMIE International existe pour exprimer sa foi par son engagement
                    en
                    faveur de la restauration, de la solidarité et de l'autonomie des personnes vulnérables et
                    fragilisées.</p>
            </div>

            <div class="mission-cards">
                <div class="mission-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="mission-card-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Aide & Soutien</h3>
                    <p>Répondre aux besoins essentiels des populations les plus défavorisées.</p>
                </div>
                <div class="mission-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="mission-card-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Formation</h3>
                    <p>Former et accompagner les personnes vers l'autonomie économique et sociale.</p>
                </div>
                <div class="mission-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="mission-card-icon">
                        <i class="fas fa-pray"></i>
                    </div>
                    <h3>Accompagnement Spirituel</h3>
                    <p>Offrir un accompagnement spirituel qui respecte la liberté de conscience.</p>
                </div>
            </div>

            <div class="mission-approach" data-aos="fade-up">
                <div class="section-heading text-center">
                    <h3>Notre approche : L'évangélisation par les actes</h3>
                    <div class="heading-line center"></div>
                </div>
                <div class="mission-quote">
                    <i class="fas fa-quote-left"></i>
                    <blockquote>
                        À quoi bon dire qu'on a la foi, si l'on n'a pas les œuvres ? La foi peut-elle sauver, si
                        elle
                        n'a pas les œuvres ? Si un frère ou une sœur sont nus, s'ils manquent de leur nourriture
                        quotidienne, et que l'un d'entre vous leur dise : Allez en paix, chauffez-vous et
                        rassasiez-vous
                        ! sans leur donner ce qui est nécessaire au corps, à quoi cela sert-il ?
                        <cite>Jacques 2:14-17</cite>
                    </blockquote>
                </div>
            </div>

        </div>
    </section>

    <!-- Section Nos Valeurs -->
    <section id="valeurs" class="bg-light" style="padding: 70px;">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-heading text-center" data-aos="fade-up">
                    <h2>Nos Valeurs Fondamentales</h2>
                    <div class="heading-line center"></div>
                </div>
            </div>
            <div class="values-container">
                <div class="accordion" id="valeursAccordion">
                    <div class="accordion-item border-0 mb-2">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                data-bs-target="#amour" aria-expanded="false" aria-controls="amour">
                                <div class="d-flex align-items-center w-100">
                                    <div class="bg-icon p-2 rounded-circle me-3">
                                        <i class="fas fa-heart icon-marron"></i>
                                    </div>
                                    <span class="h6 mb-0">Amour du prochain</span>
                                </div>
                            </button>
                        </h3>
                        <div id="amour" class="accordion-collapse collapse" data-bs-parent="#valeursAccordion">
                            <div class="accordion-body ps-5 small text-muted">
                                Nous croyons en l'amour inconditionnel pour chaque être humain, inspiré par
                                l'exemple du Christ.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                data-bs-target="#solidarite" aria-expanded="false" aria-controls="solidarite">
                                <div class="d-flex align-items-center w-100">
                                    <div class="bg-icon p-2 rounded-circle me-3">
                                        <i class="fas fa-hands-helping icon-marron"></i>
                                    </div>
                                    <span class="h6 mb-0">Solidarité</span>
                                </div>
                            </button>
                        </h3>
                        <div id="solidarite" class="accordion-collapse collapse" data-bs-parent="#valeursAccordion">
                            <div class="accordion-body ps-5 small text-muted">
                                Nous nous engageons à marcher aux côtés des plus vulnérables pour construire
                                une
                                société plus juste.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                data-bs-target="#compassion" aria-expanded="false" aria-controls="compassion">
                                <div class="d-flex align-items-center w-100">
                                    <div class="bg-icon p-2 rounded-circle me-3">
                                        <i class="fas fa-hand-holding-heart icon-marron"></i>
                                    </div>
                                    <span class="h6 mb-0">Compassion</span>
                                </div>
                            </button>
                        </h3>
                        <div id="compassion" class="accordion-collapse collapse" data-bs-parent="#valeursAccordion">
                            <div class="accordion-body ps-5 small text-muted">
                                Nous portons une attention particulière aux souffrances humaines et
                                cherchons à
                                les soulager.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                data-bs-target="#integrite" aria-expanded="false" aria-controls="integrite">
                                <div class="d-flex align-items-center w-100">
                                    <div class="bg-icon p-2 rounded-circle me-3">
                                        <i class="fas fa-shield-alt icon-marron"></i>
                                    </div>
                                    <span class="h6 mb-0">Intégrité</span>
                                </div>
                            </button>
                        </h3>
                        <div id="integrite" class="accordion-collapse collapse" data-bs-parent="#valeursAccordion">
                            <div class="accordion-body ps-5 small text-muted">
                                Nous agissons avec transparence, honnêteté et responsabilité dans toutes nos
                                actions.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                data-bs-target="#respect" aria-expanded="false" aria-controls="respect">
                                <div class="d-flex align-items-center w-100">
                                    <div class="bg-icon p-2 rounded-circle me-3">
                                        <i class="fas fa-handshake icon-marron"></i>
                                    </div>
                                    <span class="h6 mb-0">Respect</span>
                                </div>
                            </button>
                        </h3>
                        <div id="respect" class="accordion-collapse collapse" data-bs-parent="#valeursAccordion">
                            <div class="accordion-body ps-5 small text-muted">
                                Nous reconnaissons la dignité de chaque personne et respectons ses croyances
                                et
                                ses choix.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Section Notre Équipe -->
    <section id="equipe" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-heading text-center" data-aos="fade-up">
                    <h2>Notre Équipe</h2>
                    <div class="heading-line center"></div>
                </div>
                <p class="lead text-muted mt-3">Direction et Administration</p>
            </div>

            <!-- Lightbox for team images -->
            <div id="teamLightbox" class="lightbox">
                <span class="lightbox-close">&times;</span>
                <img class="lightbox-content" id="lightboxImg">
                <div id="lightboxCaption"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Team Member 1 -->
                <div class="col-lg-6">
                    <div class="team-member text-center p-4 rounded-3" style="background-color: #FFF8F0;">
                        <div class="mb-3">
                            <img src="{{ asset('images/team/dg.png') }}" alt="Davy NGUEL'ENGOGO"
                                class="img-fluid rounded-circle mb-3 mx-auto d-block team-photo"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #E8D9C5; cursor: pointer;"
                                data-src="{{ asset('images/team/dg.png') }}" data-name="Davy NGUEL'ENGOGO"
                                data-role="Président">
                        </div>
                        <h5 class="mb-1">Davy NGUEL'ENGOGO</h5>
                        <p class="text-muted mb-3">Président</p>
                        <p class="small text-muted mb-0">Dirige visionnaire à la tête de notre organisation, guidant
                            nos actions avec détermination et engagement.</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="col-lg-6">
                    <div class="team-member text-center p-4 rounded-3" style="background-color: #FFF8F0;">
                        <div class="mb-3">
                            <img src="{{ asset('images/team/secretaire-general.jpg') }}" alt="Patrick MEVIANE BLAMPAIN"
                                class="img-fluid rounded-circle mb-3 mx-auto d-block team-photo"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #E8D9C5; cursor: pointer;"
                                data-src="{{ asset('images/team/secretaire-general.jpg') }}"
                                data-name="Patrick MEVIANE BLAMPAIN" data-role="Secrétaire Général">
                        </div>
                        <h5 class="mb-1">Patrick MEVIANE BLAMPAIN</h5>
                        <p class="text-muted mb-3">Secrétaire Général</p>
                        <p class="small text-muted mb-0">Garant de la bonne coordination et du suivi des activités de
                            l'association.</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="col-lg-6">
                    <div class="team-member text-center p-4 rounded-3" style="background-color: #FFF8F0;">
                        <div class="mb-3">
                            <img src="{{ asset('images/logo2.png') }}" alt="Arsène BOUYOU NENDJO"
                                class="img-fluid rounded-circle mb-3 mx-auto d-block team-photo"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #E8D9C5; cursor: pointer;"
                                data-src="{{ asset('images/logo2.png') }}" data-name="Arsène BOUYOU NENDJO"
                                data-role="Assistance de Direction">
                        </div>
                        <h5 class="mb-1">Arsène BOUYOU NENDJO</h5>
                        <p class="text-muted mb-3">Secrétaire Général Adjoint</p>
                        <p class="small text-muted mb-0">Appui au secrétariat général et coordination des activités
                            opérationnelles.</p>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="col-lg-6">
                    <div class="team-member text-center p-4 rounded-3" style="background-color: #FFF8F0;">
                        <div class="mb-3">
                            <img src="{{ asset('images/logo2.png') }}" alt="ROGOULA Kassandra"
                                class="img-fluid rounded-circle mb-3 mx-auto d-block team-photo"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #E8D9C5; cursor: pointer;"
                                data-src="{{ asset('images/logo2.png') }}" data-name="ROGOULA Kassandra"
                                data-role="Assistance de Direction">
                        </div>
                        <h5 class="mb-1">ROGOULA Kassandra</h5>
                        <p class="text-muted mb-3">Assistance de Direction</p>
                        <p class="small text-muted mb-0">Soutien administratif et logistique à la direction de
                            l'organisation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .accordion-button:not(.collapsed) {
                background-color: #f8f9fa;
                box-shadow: none;
            }

            .accordion-button:focus {
                box-shadow: none;
                border-color: transparent;
            }

            .accordion-button::after {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%238B4513'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            }

            .bg-icon {
                transition: all 0.3s ease;
            }

            .accordion-button:not(.collapsed) .bg-icon {
                transform: scale(1.1);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .accordion-button:not(.collapsed) .fa-heart {
                animation: pulse 1.5s infinite;
            }

            .accordion-button:not(.collapsed) .fa-hands-helping {
                animation: bounce 1s infinite;
            }

            .accordion-button:not(.collapsed) .fa-hand-holding-heart {
                animation: pulse 1.2s infinite;
            }

            .accordion-button:not(.collapsed) .fa-shield-alt {
                animation: spin 2s infinite linear;
            }

            .accordion-button:not(.collapsed) .fa-handshake {
                animation: swing 1.5s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.2);
                }

                100% {
                    transform: scale(1);
                }
            }

            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-5px);
                }
            }

            @keyframes spin {
                0% {
                    transform: rotateY(0);
                }

                100% {
                    transform: rotateY(360deg);
                }
            }

            @keyframes swing {

                0%,
                100% {
                    transform: rotate(-10deg);
                }

                50% {
                    transform: rotate(10deg);
                }
            }

            .card {
                transition: transform 0.2s;
            }

            .card:hover {
                transform: translateY(-2px);
            }

            .icon-marron {
                color: #8B4513;
            }

            .bg-icon {
                background-color: #FFF8F0;
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Style personnalisé pour la barre de défilement */
            .values-container::-webkit-scrollbar {
                width: 6px;
            }

            .values-container::-webkit-scrollbar-track {
                background: #f8f9fa;
                border-radius: 10px;
            }

            .values-container::-webkit-scrollbar-thumb {
                background: #8B4513;
                border-radius: 10px;
            }

            .values-container::-webkit-scrollbar-thumb:hover {
                background: #6d3600;
            }

            /* Pour Firefox */
            .values-container {
                scrollbar-width: thin;
                scrollbar-color: #8B4513 #f8f9fa;
            }

            .section-heading {
                position: relative;
                margin-bottom: 2rem;
            }

            .heading-line {
                width: 80px;
                height: 3px;
                background-color: #8B4513;
                margin: 1rem auto;
            }

            .bg-icon {
                background-color: rgba(139, 69, 19, 0.1);
                color: #8B4513;
            }

            .mission-card {
                background: #fff;
                border-radius: 10px;
                padding: 2rem;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
                height: 100%;
            }

            .mission-card:hover {
                transform: translateY(-5px);
            }

            .mission-card-icon {
                font-size: 2.5rem;
                color: white;
                margin-bottom: 1rem;
            }

            .team-member img {
                width: 200px;
                height: 200px;
                object-fit: cover;
                border-radius: 50%;
                border: 5px solid #fff;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .team-member img:hover {
                transform: scale(1.05);
            }

            .lightbox {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.9);
                text-align: center;
                padding-top: 50px;
            }

            .lightbox-content {
                max-width: 80%;
                max-height: 80vh;
                margin: 0 auto;
                display: block;
            }

            .lightbox-close {
                position: absolute;
                top: 15px;
                right: 35px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                cursor: pointer;
            }

            .accordion-button:not(.collapsed) {
                background-color: #f8f9fa;
                color: #8B4513;
                box-shadow: none;
            }

            .accordion-button:focus {
                box-shadow: none;
                border-color: rgba(0, 0, 0, .125);
            }

            .accordion-button:not(.collapsed)::after {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%238B4513'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            }
        </style>
        <style>
            /* Team Member Cards */
            .team-member {
                transition: all 0.3s ease-in-out;
                border: 1px solid #f0e6d9;
                height: 100%;
            }

            .team-member:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                border-color: #E8D9C5;
            }

            .team-member h5 {
                color: #8B4513;
                transition: color 0.3s ease;
            }


            .team-member:hover h5 {
                color: #6b3200;
            }

            /* Lightbox Styles */
            .lightbox {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.9);
                text-align: center;
                padding: 20px;
                box-sizing: border-box;
            }

            .lightbox-content {
                max-width: 90%;
                max-height: 80%;
                margin: 5% auto;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            }

            .lightbox-close {
                position: absolute;
                top: 20px;
                right: 30px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.3s;
            }

            .lightbox-close:hover,
            .lightbox-close:focus {
                color: #8B4513;
                text-decoration: none;
            }

            #lightboxCaption {
                color: #fff;
                text-align: center;
                padding: 10px 0;
                font-size: 1.2em;
            }

            .team-photo {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .team-photo:hover {
                transform: scale(1.05) rotate(1deg);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            }

            /* Animation for the history image */
            .animate-image {
                transition: transform 0.8s ease, opacity 0.8s ease;
            }

            .animate-on-scroll .animate-image {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            .animate-on-scroll.visible .animate-image {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animation for history image on scroll
                const animateOnScroll = () => {
                    const elements = document.querySelectorAll('.animate-on-scroll');

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('visible');
                                const image = entry.target.querySelector('.animate-image');
                                if (image) {
                                    setTimeout(() => {
                                        image.classList.add('visible');
                                    }, 200);
                                }
                                // Optional: Unobserve after animation
                                // observer.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    });

                    elements.forEach(element => {
                        observer.observe(element);
                    });
                };

                // Initialize animations
                animateOnScroll();

                // Re-run animations if content is loaded dynamically
                document.addEventListener('turbolinks:load', animateOnScroll);
                // Get elements
                const lightbox = document.getElementById('teamLightbox');
                const lightboxImg = document.getElementById('lightboxImg');
                const lightboxCaption = document.getElementById('lightboxCaption');
                const closeBtn = document.querySelector('.lightbox-close');
                const teamPhotos = document.querySelectorAll('.team-photo');

                // Open lightbox function
                function openLightbox(imgSrc, name, role) {
                    lightbox.style.display = 'block';
                    lightboxImg.src = imgSrc;
                    lightboxCaption.innerHTML = `<strong>${name}</strong><br>${role}`;
                    document.body.style.overflow = 'hidden';
                }

                // Close lightbox function
                function closeLightbox() {
                    lightbox.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }

                // Add event listeners to team photos
                teamPhotos.forEach(photo => {
                    photo.addEventListener('click', function() {
                        const imgSrc = this.getAttribute('data-src');
                        const name = this.getAttribute('data-name');
                        const role = this.getAttribute('data-role');
                        openLightbox(imgSrc, name, role);
                    });
                });

                // Close button event
                closeBtn.addEventListener('click', closeLightbox);

                // Close when clicking outside the image
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });

                // Close with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeLightbox();
                    }
                });
            });
        </script>
    @endpush


@endsection
