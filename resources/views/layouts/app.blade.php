<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="n8n-session-id" content="{{ session()->getId() }}">
    <meta name="theme-color" content="#fff">
    <title>@yield('title')</title>

    <!-- Icône du site -->
    <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Open+Sans:wght@300;400;600&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Plyr -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.6.8/plyr.polyfilled.js"></script>

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- n8n chat -->
    <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />

    <!-- Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">



    <!-- CSS personnalisés -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chatbot.css') }}">

    <link rel="manifest" href="manifest.json">

    @livewireStyles
</head>

<!-- En-tête et navigation -->
<header class="header" id="header">
    {{-- @include('modules.overlay') --}}
    <div class="header-wrapper">
        <div class="logo">
            <a href="{{ route('route_accueil') }}">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo NÉHÉMIE International"
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
                    $isAccueil = $currentRoute === 'route_accueil';
                @endphp

                <li>
                    <a href="{{ route('route_accueil') }}" wire:navigate
                        class="nav-link {{ $isAccueil ? 'active' : '' }}">Accueil</a>
                </li>
                <li>
                    <a href="{{ route('route_qui_sommes_nous') }}" wire:navigate
                        class="nav-link {{ $isQuiSommesNous ? 'active' : '' }}">Qui sommes-nous</a>
                </li>
                <li>
                    <a href="{{ route('route_nos_programmes') }}"
                        class="nav-link {{ $isNosProgrammes ? 'active' : '' }}" wire:navigate>Nos programmes</a>
                </li>
                <li>
                    <a href="{{ route('route_nos_actions_et_projets') }}"
                        class="nav-link {{ $isNosActions ? 'active' : '' }}" wire:navigate>Nos actions</a>
                </li>

                <li>
                    <a href="{{ route('route_actualites') }}" class="nav-link {{ $isActualites ? 'active' : '' }}"
                        wire:navigate>Actualités</a>
                </li>
                <li class="dropdown">
                    <span class="nav-link" style="cursor: default;">SOS Prière <i
                            class="fas fa-chevron-down"></i></span>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#prayerModal">
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
            <a href="#" onclick="openMobileMoneyPopup()" class="btn btn-primary"
                style="border: none; padding: 0.5em 1em;">Faire un
                don</a>
            <button class="menu-toggle mx-2" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

</header>

<!-- Menu mobile -->
<div class="mobile-menu">
    <div class="container">
        <ul class="mobile-nav-list mt-5">
            <li><a href="{{ route('route_accueil') }}" wire:navigate class="mobile-nav-link">Accueil</a></li>
            <li><a href="{{ route('route_qui_sommes_nous') }}" wire:navigate class="mobile-nav-link">Qui
                    sommes-nous</a></li>

            <li><a href="{{ route('route_nos_programmes') }}" wire:navigate class="mobile-nav-link">Nos
                    programmes</a></li>

            <li><a href="{{ route('route_actualites') }}" wire:navigate class="mobile-nav-link">Actualités</a></li>
            <li><a href="{{ route('route_nos_actions_et_projets') }}" wire:navigate class="mobile-nav-link">Nos
                    actions</a>
            </li>

            <!-- Menu déroulant SOS Prière -->
            <li class="mobile-dropdown">
                <span class="mobile-nav-link" style="cursor: default;">SOS Prière <i
                        class="fas fa-chevron-down"></i></span>
                <ul class="mobile-dropdown-menu">
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#prayerModal">
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
            <a href="#" onclick="openMobileMoneyPopup()" class="btn btn-primary mt-4"
                style="border: none; padding: 0.5em 1em;">Faire un don</a>
        </ul>
    </div>
</div>

<body>
    @include('modules/chatbot')

    @include('modales.modale_priere')
    @include('modales.modale_appel')
    @include('modales.modale_prayer-form')
    <div id="main-content">
        {{ $slot }}
    </div>




    <!-- Scripts -->
    <!-- jQuery (important avant Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Plyr -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/plugins/swiper/swiper.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>

    <!-- FancyBox JS -->
    <script src="{{ asset('assets/plugins/fancybox/jquery.fancybox.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>

    <!-- Select JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="975494c0d05ce29815c81f40-text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"
        data-cf-beacon='{"rayId":"954c67261d95cc00","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>


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
    
    <!-- Scripts Livewire -->
    @livewireScripts
    
    <!-- Scripts personnalisés -->
    <script src="{{ asset('js/script.js') }}" defer></script>
    @if(file_exists(public_path('js/priere.js')))
    <script src="{{ asset('js/priere.js') }}" defer></script>
    @endif

    <!-- Script pour le popup mobile money -->
    <script>
        function openMobileMoneyPopup() {
            const url = "{{ route('index') }}";
            const width = 450;
            const height = 550;

            // Calcul de la position centrée
            const left = (window.screen.width / 2) - (width / 2);
            const top = (window.screen.height / 2) - (height / 2);

            // Ouverture de la fenêtre centrée
            window.open(
                url,
                'mobileMoneyPopup',
                `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=no`
            );
        }
    </script>

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
    {{-- Script pour le service worker popup d'intallation --}}
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('sw.js');
        }

        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            const btn = document.createElement('button');
            btn.textContent = '📲 Installer l’appli mobile ';
            btn.id = 'installBtn';
            document.body.appendChild(btn);

            // Appliquer les styles et animations
            const style = document.createElement('style');
            style.innerHTML = `
                #installBtn {
                    position: fixed;
                    bottom: 20px;
                    left: 20px;
                    padding: 12px 24px;
                    background: #5D4037;
                    color: white;
                    border: none;
                    border-radius: 8px;
                    font-size: 16px;
                    cursor: pointer;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                    opacity: 0;
                    transform: translateY(20px);
                    animation: fadeInUp 1s ease forwards;
                    z-index: 9999;
                }

                #installBtn:hover {
                    background-color: #5D4037;
                    transform: scale(1.05);
                    transition: background-color 0.3s, transform 0.3s;
                }
    
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);

            // Action au clic
            btn.addEventListener('click', () => {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(choice => {
                    if (choice.outcome === 'accepted') {
                        btn.remove();
                        console.log("✅ L'application NÉHÉMIE International a été installée !");
                    } else {
                        console.log("❌ Installation refusée.");
                    }
                });
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
                <section class="map-section" style="max-width: 1000px; margin: 0 auto;">
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

            <div class="footer-links " style="margin-left: 120px;">
                <div class="footer-links-column">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="{{ route('route_accueil') }}" wire:navigate>Accueil</a></li>
                        <li><a href="{{ route('route_qui_sommes_nous') }}" wire:navigate>Qui sommes-nous</a></li>
                        <li><a href="{{ route('route_nos_programmes') }}" wire:navigate>Nos programmes</a></li>
                        <li><a href="{{ route('route_nos_actions_et_projets') }}" wire:navigate
                                class="{{ request()->routeIs('route_nos_actions_et_projets') ? 'active' : '' }}">Nos
                                actions</a></li>
                        <li><a href="{{ route('route_actualites') }}" wire:navigate
                                class="{{ request()->routeIs('route_actualites') ? 'active' : '' }}">Actualités</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-links-column">
                    <h4>Nos programmes</h4>
                    <ul>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-salomon" wire:navigate>Salomon</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-joseph" wire:navigate>Joseph</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-david" wire:navigate>David</a></li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-daniel" wire:navigate>Daniel</a>
                        </li>
                        <li><a href="{{ route('route_nos_programmes') }}#programme-priscille"
                                wire:navigate>Priscille</a>
                        </li>
                    </ul>
                </div>

                {{-- <div class="footer-links-column">
                    <h4>Légal</h4>
                    <ul>
                       
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Conditions d'utilisation</a></li>
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
