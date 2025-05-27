<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'YodiPay')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Assets -->
    <link rel="stylesheet" href="{{ asset('src/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/vendors/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('src/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!-- header starts -->
    <header class="main-header">
        <div class="custom-container">
            <div class="header-panel">
                @if (!request()->routeIs('index'))
                    <a onclick="history.back();">
                        <i class="iconsax icon-btn" data-icon="chevron-left"></i>
                    </a>
                @else
                    <div>

                    </div>
                @endif
                <h1 class="fw-bold">@yield('title2')</h1>
                <div class=""></div>
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
</body>

</html>
