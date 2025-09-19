{{-- resources/views/layouts/nehemie-mobile.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'NÉHÉMIE International - App Mobile')</title>

    {{-- Tailwind & FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #3b82f6;
            --accent-gold: #f59e0b;
            --light-gray: #f8fafc;
            --dark-gray: #334155;
        }

        body {
            background: var(--light-gray);
            color: var(--dark-gray);
            padding-bottom: 80px
        }

        .header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: #fff;
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1)
        }

        .content {
            margin-top: 80px;
            min-height: calc(100vh - 160px)
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1)
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            display: flex;
            justify-content: space-around;
            padding: .5rem 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, .1);
            z-index: 1000
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: .75rem;
            padding: .5rem
        }

        .nav-item.active {
            color: var(--primary-blue)
        }

        .badge {
            display: inline-block;
            padding: .25rem .75rem;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
            color: #fff;
            background: var(--accent-gold)
        }
    </style>

    @stack('head')
    @livewireStyles
</head>

<body>

    {{-- Header commun --}}
    <header class="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-church text-2xl mr-3"></i>
                <div>
                    <h1 class="text-lg font-bold">NÉHÉMIE International</h1>
                    <p class="text-sm opacity-90">"Levons-nous et bâtissons!"</p>
                </div>
            </div>
            <button class="text-2xl">
                <i class="fas fa-user-circle"></i>
            </button>
        </div>
    </header>

    <main class="content px-3">
        {{ $slot }}
    </main>

    @livewireScripts
    @stack('scripts')

    <div id="nav-progress"
        style="position:fixed;top:0;left:0;height:3px;width:0;
background:linear-gradient(90deg,#1e40af,#3b82f6);z-index:2000;">
    </div>

    @push('scripts')
        <script>
            const bar = () => document.getElementById('nav-progress');
            document.addEventListener('livewire:navigating', () => {
                const el = bar();
                if (!el) return;
                el.style.transition = 'none';
                el.style.width = '0%';
                requestAnimationFrame(() => {
                    el.style.transition = 'width .5s ease';
                    el.style.width = '80%';
                });
            });
            document.addEventListener('livewire:navigated', () => {
                const el = bar();
                if (!el) return;
                el.style.width = '100%';
                setTimeout(() => {
                    el.style.width = '0%';
                }, 250);
            });
        </script>
    @endpush

</body>

</html>
