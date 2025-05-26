<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="n8n-session-id" content="<?= \Illuminate\Support\Facades\Session::getId() ?>">
    <title>@yield('title')</title>

    <!-- icone du site -->
    <link rel="icon" href="<?= asset('images/logo2.png') ?>" type="image/x-icon">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.6.8/plyr.polyfilled.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- Fichiers CSS personnalisés -->
    <link rel="stylesheet" href="<?= asset('css/styles.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/chatbot.css') ?>">

    <!-- Bibliothèques tierces -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        integrity="sha512-c42qXSf5l7l5W0kY8J1J3xXqT0B8h+EeJxJ5U2qyJ3OzX3VqLLh4Lh5kjJ53X1qQ==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
</head>

<!-- En-tête et navigation -->
<header class="header" id="header">
    @include('modules.overlay')
    <div class="header-wrapper">
        <div class="logo">
            <a href="{{ route('route_accueil') }}">
                <img src="<?= asset('images/logo2.png') ?>" alt="Logo NÉHÉMIE International"
                    style="height: 75px; width: auto;">
                <span style="display: block; font-size: 0.9em; line-height: 1.2;">
                    <span style="display: block;">NÉHÉMIE</span>
                    <span style="display: block; font-size: 0.8em;">International</span>
                </span>
            </a>
        </div>

        <nav class="main-nav" style="font-size: 0.9em;">
            <ul class="nav-list">
                @php
                    $currentRoute = request()->route() ? request()->route()->getName() : '';
                    $isQuiSommesNous = $currentRoute === 'route_qui_sommes_nous';
                    $isNosProgrammes = $currentRoute === 'route_nos_programmes';
                    $isNosActions = $currentRoute === 'route_nos_actions_et_projets';
                    $isActualites = $currentRoute === 'route_actualites';
                @endphp

                <li><a href="{{ route('route_accueil') }}"
                        class="nav-link {{ $currentRoute === 'route_accueil' ? 'active' : '' }}">Accueil</a></li>
                <li><a href="{{ route('route_qui_sommes_nous') }}"
                        class="nav-link {{ $isQuiSommesNous ? 'active' : '' }}">Qui sommes-nous</a></li>
                {{-- <li class="dropdown">
                    <a href="{{ route('route_qui_sommes_nous') }}"
                        class="nav-link {{ $isQuiSommesNous ? 'active' : '' }}">Qui
                        sommes-nous <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('route_qui_sommes_nous') }}#histoire"
                                class="{{ $isQuiSommesNous && request()->is('*#histoire*') ? 'active' : '' }}">Notre
                                Histoire</a></li>
                        <li><a href="{{ route('route_qui_sommes_nous') }}#vision-mission"
                                class="{{ $isQuiSommesNous && request()->is('*#vision-mission*') ? 'active' : '' }}">Vision
                                & Mission</a></li>
                        <li><a href="{{ route('route_qui_sommes_nous') }}#valeurs"
                                class="{{ $isQuiSommesNous && request()->is('*#valeurs*') ? 'active' : '' }}">Nos
                                Valeurs</a></li>
                        <li><a href="{{ route('route_qui_sommes_nous') }}#equipe"
                                class="{{ $isQuiSommesNous && request()->is('*#equipe*') ? 'active' : '' }}">Notre
                                Équipe</a></li>
                    </ul>
                </li> --}}
                <li class="dropdown">
                    <a href="{{ route('route_nos_programmes') }}"
                        class="nav-link {{ $isNosProgrammes ? 'active' : '' }}">Nos programmes <i
                            class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('route_nos_programmes') }}#programme-salomon"
                                class="{{ $isNosProgrammes && request()->is('*#programme-salomon*') ? 'active' : '' }}">SALOMON</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-joseph"
                                class="{{ $isNosProgrammes && request()->is('*#programme-joseph*') ? 'active' : '' }}">JOSEPH</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-david"
                                class="{{ $isNosProgrammes && request()->is('*#programme-david*') ? 'active' : '' }}">DAVID</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-daniel"
                                class="{{ $isNosProgrammes && request()->is('*#programme-daniel*') ? 'active' : '' }}">DANIEL</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-priscille"
                                class="{{ $isNosProgrammes && request()->is('*#programme-priscille*') ? 'active' : '' }}">PRISCILLE
                                & AQUILA</a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('route_nos_actions_et_projets') }}"
                        class="nav-link {{ $isNosActions ? 'active' : '' }}">Nos actions et projets</a></li>
                <li><a href="{{ route('route_actualites') }}"
                        class="nav-link {{ $isActualites ? 'active' : '' }}">Actualités</a></li>
                <li class="dropdown">
                    <span class="nav-link" style="cursor: default;">SOS Prière <i
                            class="fas fa-chevron-down"></i></span>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#priereModal">
                                <i class="fas fa-praying-hands me-2"></i>Demande de prière
                            </a>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#appelModal">
                                <i class="fas fa-phone-alt me-2"></i>Nous appeler
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="header-actions" style="font-size: 0.85em;">
            <a href="#" class="btn btn-primary" style="border: none; padding: 0.5em 1em;" data-bs-toggle="modal"
                data-bs-target="#donModal">Faire un don</a>
            <button class="menu-toggle" aria-label="Menu" style="width: 36px; height: 36px;">
                <span style="height: 2px; margin: 5px 0;"></span>
                <span style="height: 2px; margin: 5px 0;"></span>
                <span style="height: 2px; margin: 5px 0;"></span>
            </button>
        </div>
    </div>

</header>

<!-- Menu mobile -->
<div class="mobile-menu">
    <div class="container">
        <ul class="mobile-nav-list mt-5">
            <li><a href="{{ route('route_accueil') }}" class="mobile-nav-link">Accueil</a></li>
            <li><a href="{{ route('route_qui_sommes_nous') }}" class="mobile-nav-link">Qui sommes-nous</a></li>
            {{-- <li class="mobile-dropdown">
                <a href="{{ route('route_qui_sommes_nous') }}" class="mobile-nav-link" style="cursor: default;">Qui
                    sommes-nous <i class="fas fa-chevron-down"></i></a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="{{ route('route_qui_sommes_nous') }}#histoire">Notre
                            Histoire</a></li>
                    <li><a href="{{ route('route_qui_sommes_nous') }}#vision-mission">Vision & Mission</a></li>
                    <li><a href="{{ route('route_qui_sommes_nous') }}#valeurs">Nos Valeurs</a>
                    </li>
                    <li><a href="{{ route('route_qui_sommes_nous') }}#equipe">Notre Équipe</a>
                    </li>
                </ul>
            </li> --}}
            <li class="mobile-dropdown">
                <a href="{{ route('route_nos_programmes') }}" class="mobile-nav-link" style="cursor: default;">Nos
                    programmes <i class="fas fa-chevron-down"></i></a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="{{ route('route_nos_programmes') }}#programme-salomon">SALOMON</a></li>
                    <li><a href="{{ route('route_nos_programmes') }}#programme-joseph">JOSEPH</a></li>
                    <li><a href="{{ route('route_nos_programmes') }}#programme-david">DAVID</a></li>
                    <li><a href="{{ route('route_nos_programmes') }}#programme-daniel">DANIEL</a></li>
                    <li><a href="{{ route('route_nos_programmes') }}#programme-priscille">PRISCILLE & AQUILA</a></li>
                </ul>
            </li>
            <li><a href="{{ route('route_actualites') }}" class="mobile-nav-link">Actualités</a></li>
            <li><a href="{{ route('route_nos_actions_et_projets') }}" class="mobile-nav-link">Nos actions et
                    projets</a></li>

            <!-- Menu déroulant SOS Prière -->
            <li class="mobile-dropdown">
                <span class="mobile-nav-link" style="cursor: default;">SOS Prière <i
                        class="fas fa-chevron-down"></i></span>
                <ul class="mobile-dropdown-menu">
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#priereModal"
                            data-bs-dismiss="offcanvas">
                            Demande de prière
                        </a>
                    </li>
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#appelModal"
                            data-bs-dismiss="offcanvas">
                            <i class="fas fa-phone-alt me-2"></i>Nous appeler
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="#faire-un-don" class="btn btn-primary mobile-btn">Faire un don</a></li>
        </ul>
    </div>
</div>

<body>
    <div id="main-content">
        @yield('content')
    </div>

    @include('modules/chatbot')
    @include('modules/bouton_retour')
    @include('modales.modale_priere')
    @include('modales.modale_appel')
    @include('modales.modale_don')

    <!-- Scripts -->
    <!-- jQuery (important avant Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Plyr -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <!-- Script pour le menu déroulant mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du menu déroulant
            const dropdownElement = document.querySelector('.mobile-nav .dropdown');
            const dropdownToggle = dropdownElement.querySelector('.dropdown-toggle');
            const dropdownMenu = dropdownElement.querySelector('.dropdown-menu');

            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Fermer tous les autres menus déroulants
                document.querySelectorAll('.mobile-nav .dropdown').forEach(function(dropdown) {
                    if (dropdown !== dropdownElement) {
                        dropdown.querySelector('.dropdown-menu').classList.remove('show');
                    }
                });

                // Basculer le menu actuel
                dropdownMenu.classList.toggle('show');
            });

            // Fermer le menu déroulant quand on clique ailleurs
            document.addEventListener('click', function(e) {
                if (!dropdownElement.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });

            // Empêcher la fermeture du menu quand on clique dessus
            dropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>

    <!-- Scripts personnalisés -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/priere.js') }}"></script>

    <!-- Initialisation de Plyr -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const players = Plyr.setup('.js-player');

            // Initialisation des tooltips Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

</body>

<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-logo">
                <img src="<?= asset('images/logo2.png') ?>" alt="Logo NÉHÉMIE International">
                <h3>NÉHÉMIE International</h3>
                <p>"Levons-nous et bâtissons!"</p>
                <!-- Section Carte -->
                <section class="map-section" style="max-width: 800px; margin: 0 auto;">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.951512393891!2d9.484083!3d0.420667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMjUnMTQuNCJOIDnCsDI5JzAyLjciRQ!5e0!3m2!1sfr!2sfr!5m1!1s0x0%3A0x0!8m2!3d0.420667!4d9.484083!15sCjQwJzI1JzE0LjQiTiA5wrAyOScwMi43IkqIAQh0cmFuc2l0X3N0YXRpb26aASNDaFpEU1VoTk1HOW5TMFZKUTBGblNVTmhZbXhmVlRZNVJSQULgAQE!16s%2Fg%2F11b8v4z4x9!5m2!1sfr!2sfr&z=12"
                            width="100%" height="150"
                            style="border:0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Localisation de NÉHÉMIE International">
                        </iframe>
                    </div>
                </section>
            </div>

            <div class="footer-links">
                <div class="footer-links-column">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="{{ route('route_accueil') }}">Accueil</a></li>
                        <li><a href="{{ route('route_qui_sommes_nous') }}">Qui sommes-nous</a></li>

                        <li><a href="{{ route('route_nos_actions_et_projets') }}"
                                class="{{ request()->routeIs('route_nos_actions_et_projets') ? 'active' : '' }}">Nos
                                actions et projets</a></li>
                        <li><a href="{{ route('route_actualites') }}"
                                class="{{ request()->routeIs('route_actualites') ? 'active' : '' }}">Actualités</a>
                        </li>


                    </ul>
                </div>

                <div class="footer-links-column">
                    <h4>Nos programmes</h4>
                    <ul>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-salomon">SALOMON</a></li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-joseph">JOSEPH</a></li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-david">DAVID</a></li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-daniel">DANIEL</a></li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-priscille">PRISCILLE & AQUILA</a>
                        </li>
                    </ul>
                </div>
                {{-- 
                <div class="footer-links-column">
                    <h4>Légal</h4>
                    <ul>

                        <li><a href="{{ route('route_politique_de_confidentialite') }}">Politique de
                                confidentialité</a>
                        </li>
                        <li><a href="{{ route('route_conditions_dutilisation') }}">Conditions d'utilisation</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 NÉHÉMIE International. Tous droits réservés.</p>
            <div class="footer-social">
                <a href="https://www.facebook.com/NehemieInternational" target="_blank" rel="noopener noreferrer"
                    aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/internationalnehemie?igsh=djl1N29lbGkyb3c3"
                    aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                {{-- <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a> --}}
                <a href="http://www.youtube.com/@nehemieinternational" target="_blank" aria-label="YouTube"><i
                        class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>

</html>
