<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Nehemie')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icône du site -->
    <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/x-icon">
    <!-- Assets -->
    <link rel="stylesheet" href="{{ asset('src/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/vendors/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast_pwa.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!-- header starts -->
    <header class="main-header">
        <div class="custom-container">
            <div class="header-panel d-flex justify-content-between align-items-center">
                @if (!request()->routeIs('index'))
                    <a onclick="history.back();" class="me-3">
                        <i class="iconsax icon-btn" data-icon="chevron-left"></i>
                    </a>
                @else
                    <div>
                        {{-- LOGO --}}
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="logo" style="width: 60px;">
                    </div>
                @endif

                <h1 class="fw-bold mb-0 flex-grow-1 text-center" style="margin-left: -50px;">
                    @yield('title2')
                </h1>

                <a href="#" class="text-decoration-none ms-3" title="Retour au site"
                    onclick="returnToMainSite();">
                    <i class="fas fa-home icon-btn text-black"></i>
                </a>


            </div>
        </div>
    </header>

    <!-- header end -->
    <!-- Main content -->
    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('src/assets/js/password-show.js') }}"></script>
    <script src="{{ asset('src/assets/js/iconsax.js') }}"></script>
    <script src="{{ asset('src/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('src/assets/js/template-setting.js') }}"></script>
    <script src="{{ asset('src/assets/js/script.js') }}"></script>
    <script>
        function returnToMainSite() {
            if (window.opener && !window.opener.closed) {
                window.opener.location.href = "{{ route('route_accueil') }}"; // Redirige l'onglet principal
                window.close(); // Ferme cette fenêtre popup
            } else {
                window.location.href = "{{ route('route_accueil') }}"; // Fallback si ouvert dans l’onglet principal
            }
        }
    </script>



</body>

</html>
