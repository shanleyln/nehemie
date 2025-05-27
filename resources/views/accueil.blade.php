@extends('layouts.app')

@section('title', 'Accueil')
@section('content')

    <!-- Section Héro avec slider -->
    <section id="accueil" class="hero-section">
        <div class="hero-slider">
            <div class="hero-slide active" style="background-image: url('{{ asset('images/slider/slide1.png') }}')">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title" data-aos="fade-up">"Levons-nous et bâtissons!"</h1>
                        <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">Une ONG chrétienne
                            engagée
                            auprès des vulnérables</p>
                        <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                            <a href="{{ route('route_qui_sommes_nous') }}#vision-mission" class="btn btn-primary"
                                style="border: none;">Découvrir
                                notre mission</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/slider/slide2.png') }}')">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Donnez-leur vous-mêmes à manger</h1>
                        <p class="hero-subtitle">Campagne de levée de fonds - Juin 2025</p>
                        <div class="hero-buttons">
                            <a href="#faire-un-don" class="btn btn-primary" style="border: none;">Participez
                                maintenant</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/slider/slide3.png') }}')">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">L'Évangélisation par les actes</h1>
                        <p class="hero-subtitle">Notre engagement pour la transformation sociale</p>
                        <div class="hero-buttons">
                            <a href="{{ route('route_nos_programmes') }}" class="btn btn-primary"
                                style="border: none;">Découvrir
                                nos
                                programmes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-controls">
            <button class="hero-control prev" aria-label="Slide précédent"><i class="fas fa-chevron-left"></i></button>
            <div class="hero-dots">
                <button class="hero-dot active" aria-label="Slide 1"></button>
                <button class="hero-dot" aria-label="Slide 2"></button>
                <button class="hero-dot" aria-label="Slide 3"></button>
            </div>
            <button class="hero-control next" aria-label="Slide suivant"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <!-- Section Message de bienvenue -->
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-wrapper">
                <div class="welcome-image" data-aos="fade-right">
                    <img src="{{ asset('images/team/dg.png') }}" alt="NGUEL'ENGOGO Davy, Président">
                    <div class="welcome-image-info">
                        <h3>NGUEL'ENGOGO Davy</h3>
                        <p>Président, NÉHÉMIE International</p>
                    </div>
                </div>
                <div class="welcome-content" data-aos="fade-left">
                    <div class="section-heading">
                        <h2>Message de bienvenue</h2>
                        <div class="heading-line"></div>
                    </div>
                    <div class="welcome-text">
                        <p>"Bienvenue sur le site de NÉHÉMIE International. Si vous êtes ici, c’est sans doute que vous
                            partagez, comme nous, le désir de voir les choses changer concrètement. NÉHÉMIE est née d’une
                            conviction simple mais forte : notre foi ne peut pas rester théorique. Elle prend tout son sens
                            lorsqu’elle se traduit par des gestes d’amour, de solidarité, et des actions qui redonnent de la
                            valeur à chaque être humain."</p>
                        <p>"Le Gabon traverse aujourd’hui des temps difficiles. Mais nous croyons qu’en mettant en avant des
                            valeurs vraies – la compassion, le sens du service, l’honnêteté – on peut poser ensemble les
                            bases d’un avenir plus juste et durable."</p>
                        <p>"Je vous invite à faire un bout de chemin avec nous. Explorez notre mission, découvrez nos
                            actions, et si cela vous parle, rejoignez-nous dans ce bel engagement pour reconstruire, espérer
                            et agir."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Section Campagne en cours -->
    <section class="campaign-section">
        <div class="container">
            <div class="campaign-wrapper">
                <div class="campaign-image" data-aos="fade-right">
                    <img src="{{ asset('images/campagne.jpg') }}" alt="Campagne Donnez-leur vous-mêmes à manger">
                </div>
                <div class="campaign-content" data-aos="fade-left">
                    <div class="campaign-badge">Campagne en cours</div>
                    <h2>Donnez-leur vous-mêmes à manger</h2>
                    <p>Durant tout le mois de juin, NÉHÉMIE International vous invite à faire partie d'un miracle
                        quotidien. Chaque don collecté permettra d'organiser en juillet une grande distribution
                        alimentaire pour les familles les plus vulnérables.</p>

                    {{-- <div class="campaign-progress">
                              <div class="progress-info">
                                  <span>Objectif: 10 000 000 FCFA</span>
                                  <span>65% atteint</span>
                              </div>
                              <div class="progress-bar">
                                  <div class="progress-fill" style="width: 65%"></div>
                              </div>
                          </div> --}}

                    <div class="campaign-actions">
                        <a href="{{ route('route_donnez_leur_vous_memes') }}" class="btn btn-outline">En savoir
                            plus</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Faire un Don -->
    <section id="faire-un-don" class="donation-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2>S'impliquer</h2>
                <div class="heading-line center"></div>
                <p class="section-subtitle">Votre soutien est précieux pour continuer notre mission</p>
            </div>

            <div class="donation-wrapper" data-aos="fade-up">
                {{-- bloc image --}}
                <div class="col-md-6" data-aos="fade-right">
                    <img src="{{ asset('images/rejoindre.jpg') }}" alt="Campagne Donnez-leur vous-mêmes à manger"
                        class="rounded" style="width: 100%; height: auto;">
                </div>

                {{-- bloc texte --}}
                <div class="col-md-6 volunteer-options">
                    <h3>Devenir Bénévole</h3>
                    <p>Vous souhaitez vous engager à nos côtés ? Nous avons besoin de bénévoles dans différents
                        domaines :</p>

                    <ul class="volunteer-list">
                        <li><i class="fas fa-check-circle"></i> Distribution alimentaire</li>
                        <li><i class="fas fa-check-circle"></i> Animation d'ateliers</li>
                        <li><i class="fas fa-check-circle"></i> Soutien administratif</li>
                        <li><i class="fas fa-check-circle"></i> Communication</li>
                        <li><i class="fas fa-check-circle"></i> Logistique</li>
                    </ul>

                    <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#rejoindreModal">Nous rejoindre</a>
                </div>
            </div>
        </div>
    </section>
    {{-- modal rejoindre --}}
    @include('modales.modale_rejoindre')

    @push('styles')
        <style>
            .icon-marron {
                color: #8B4513;
            }

            .btn-outline-primary {
                transition: all 0.3s ease;
                border-color: #E8D9C5;
            }

            .btn-outline-primary:hover {
                background-color: #FFF8F0;
                border-color: #8B4513;
            }
        </style>
    @endpush


    <!-- Section Impact -->
    {{-- <section class="impact-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2>Notre impact</h2>
                <div class="heading-line center"></div>
                <p class="section-subtitle">Les chiffres qui témoignent de notre action depuis 2020</p>
            </div>

            <div class="impact-counters" data-aos="fade-up">
                <div class="impact-counter">
                    <div class="counter-value" data-count="1250">0</div>
                    <div class="counter-label">Familles soutenues</div>
                </div>
                <div class="impact-counter">
                    <div class="counter-value" data-count="350">0</div>
                    <div class="counter-label">Jeunes formés</div>
                </div>
                <div class="impact-counter">
                    <div class="counter-value" data-count="25">0</div>
                    <div class="counter-label">Projets communautaires</div>
                </div>
                <div class="impact-counter">
                    <div class="counter-value" data-count="50">0</div>
                    <div class="counter-label">Bénévoles actifs</div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Section Nos Programmes -->
    <section id="nos-programmes" class="programs-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h2>Nos programmes</h2>
                <div class="heading-line center"></div>
                <p class="section-subtitle">Découvrez nos cinq programmes fondamentaux, chacun répondant à une
                    dimension spécifique de notre mission globale.</p>
            </div>

            <div class="programs-tabs" data-aos="fade-up">
                <div class="programs-tabs-nav">
                    <button class="program-tab active" data-program="salomon">
                        <i class="fas fa-graduation-cap"></i>
                        <span>SALOMON</span>
                    </button>
                    <button class="program-tab" data-program="joseph">
                        <i class="fas fa-bullhorn"></i>
                        <span>JOSEPH</span>
                    </button>
                    <button class="program-tab" data-program="david">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>DAVID</span>
                    </button>
                    <button class="program-tab" data-program="daniel">
                        <i class="fas fa-users"></i>
                        <span>DANIEL</span>
                    </button>
                    <button class="program-tab" data-program="priscille">
                        <i class="fas fa-pray"></i>
                        <span>PRISCILLE & AQUILA</span>
                    </button>
                </div>

                <div class="programs-tabs-content">
                    <div class="program-content active" id="program-salomon">
                        <div class="program-content-inner">
                            <div class="program-image">
                                <img src="{{ asset('images/programme/salomon.png') }}" alt="Programme SALOMON">
                            </div>
                            <div class="program-details">
                                <h3>Programme SALOMON</h3>
                                <p class="program-tagline">Gouvernement/Politique + Éducation</p>
                                <p>Former et équiper des leaders de gouvernance éthique et sage, influencer les systèmes
                                    politiques avec des principes bibliques, et développer des systèmes éducatifs qui
                                    intègrent sagesse et connaissance pour transformer la société.</p>
                                <a href="{{ route('route_nos_programmes') }}#nos-programmes" class="btn btn-secondary">En
                                    savoir plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="program-content" id="program-joseph">
                        <div class="program-content-inner">
                            <div class="program-image">
                                <img src="{{ asset('images/programme/joseph.png') }}" alt="Programme JOSEPH">
                            </div>
                            <div class="program-details">
                                <h3>Programme JOSEPH</h3>
                                <p class="program-tagline">Économie/Affaires</p>
                                <p>Transformer la sphère économique selon des principes bibliques,
                                    former des entrepreneurs et dirigeants d'entreprise éthiques, développer des modèles
                                    d'affaires durables et équitables, et utiliser les ressources économiques pour avoir un
                                    impact social positif.</p>

                                <a href="{{ route('route_nos_programmes') }}#nos-programmes" class="btn btn-secondary">En
                                    savoir plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="program-content" id="program-david">
                        <div class="program-content-inner">
                            <div class="program-image">
                                <img src="{{ asset('images/programme/david.png') }}" alt="Programme DAVID">
                            </div>
                            <div class="program-details">
                                <h3>Programme DAVID</h3>
                                <p class="program-tagline">Arts/Divertissement + Médias/Communications</p>
                                <p>Former et promouvoir des artistes et communicateurs chrétiens
                                    qui créent des œuvres d'excellence porteuses de sens, de beauté et de vérité. Influencer
                                    les sphères des arts, du divertissement et des médias avec des contenus qui élèvent
                                    l'esprit et reflètent les valeurs du Royaume.</p>

                                <a href="{{ route('route_nos_programmes') }}#nos-programmes" class="btn btn-secondary">En
                                    savoir plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="program-content" id="program-daniel">
                        <div class="program-content-inner">
                            <div class="program-image">
                                <img src="{{ asset('images/programme/daniel.png') }}" alt="Programme DANIEL">
                            </div>
                            <div class="program-details">
                                <h3>Programme DANIEL</h3>
                                <p class="program-tagline">Religion/Spiritualité + Gouvernement (secondaire)</p>
                                <p>Renforcer la montagne de la religion et de la spiritualité en
                                    équipant les leaders religieux et les croyants pour un impact sociétal pertinent.
                                    Former des individus capables d'opérer avec sagesse et intégrité dans des contextes
                                    séculiers, en particulier gouvernementaux, tout en étant des témoins vivants de leur
                                    foi.</p>


                                <a href="{{ route('route_nos_programmes') }}#nos-programmes" class="btn btn-secondary">En
                                    savoir plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="program-content" id="program-priscille">
                        <div class="program-content-inner">
                            <div class="program-image">
                                <img src="{{ asset('images/programme/priscille.png') }}"
                                    alt="Programme PRISCILLE & AQUILA">
                            </div>
                            <div class="program-details">
                                <h3>Programme PRISCILLE & AQUILA</h3>
                                <p class="program-tagline">Famille + Action Sociale Communautaire + Éducation (secondaire)
                                </p>
                                <p>Soutenir et renforcer les familles comme fondement de la société
                                    et piliers de la communauté, en promouvant des modèles basés sur des principes
                                    bibliques. Le programme vise à équiper les foyers pour être des centres d'influence
                                    positive, de soin et d'éducation, s'étendant vers la communauté environnante par
                                    l'hospitalité, le mentorat et des actions sociales concrètes de soutien aux personnes et
                                    familles vulnérables.</p>


                                <a href="{{ route('route_nos_programmes') }}#nos-programmes" class="btn btn-secondary">En
                                    savoir plus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
