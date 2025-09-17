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
                    $isParametresPVIT = $currentRoute === 'pvit.settings';
                    $isHistoriqueDesClesSecrètes = $currentRoute === 'pvit.secretsLog';
                    $isFormulaireDeTestDeTransaction = $currentRoute === 'pvit.transactions';
                    $isAccueil = $currentRoute === 'route_accueil';
                @endphp

                <li>
                    <a href="{{ route('route_accueil') }}" wire:navigate
                        class="nav-link {{ $isAccueil ? 'active' : '' }}">Aller sur le site</a>
                </li>
                <li>
                    <a href="{{ route('pvit.settings') }}" wire:navigate
                        class="nav-link {{ $isParametresPVIT ? 'active' : '' }}">Paramètres PVIT</a>
                </li>
                <li>
                    <a href="{{ route('pvit.secretsLog') }}"
                        class="nav-link {{ $isHistoriqueDesClesSecrètes ? 'active' : '' }}" wire:navigate>Historique
                        des clés
                        secrètes</a>
                </li>
                <li>
                    <a href="{{ route('pvit.transactions') }}"
                        class="nav-link {{ $isFormulaireDeTestDeTransaction ? 'active' : '' }}"
                        wire:navigate>Formulaire de test de transaction</a>
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

<body>

    <div id="main-content" style="margin-top: 100px;">
        @yield('content')
    </div>




    <!-- Scripts -->
    <!-- jQuery (important avant Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Plyr -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>




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


    <!-- Scripts Livewire -->
    @livewireScripts

    <!-- Scripts personnalisés -->
    <script src="{{ asset('js/script.js') }}"></script>
    @if (file_exists(public_path('js/priere.js')))
        <script src="{{ asset('js/priere.js') }}"></script>
    @endif

    <!-- Script pour le popup mobile money -->
    <script>
        function openMobileMoneyPopup() {
            const url = "{{ route('pvit.public.pay') }}";
            const width = 550;
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

    <!-- Pile de scripts pour les composants -->
    @stack('scripts')
</body>

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


        <div class="footer-bottom">
            <p>&copy; 2025 NÉHÉMIE International. Tous droits réservés.</p>

        </div>
    </div>
</footer>


</html>
