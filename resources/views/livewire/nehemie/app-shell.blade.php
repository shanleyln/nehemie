{{-- resources/views/livewire/nehemie/app-shell.blade.php --}}
<div>
    {{-- Pages --}}
    @if ($page === 'actualites')
        @livewire('nehemie.page-actualites')
    @endif
    @if ($page === 'don')
        @livewire('nehemie.page-don')
    @endif
    @if ($page === 'membre')
        @livewire('nehemie.page-membre')
    @endif
    @if ($page === 'contact')
        @livewire('nehemie.page-contact')
    @endif
    @if ($page === 'menu')
        @livewire('nehemie.page-menu')
    @endif


    {{-- Bottom nav --}}
    <nav
        style="position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            display: flex;
            justify-content: space-around;
            padding: .5rem 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, .1);
            z-index: 1000">
        @php $tabs = [['id' => 'actualites', 'icon' => 'fa-newspaper', 'label' => 'Actualités'], ['id' => 'don', 'icon' => 'fa-heart', 'label' => 'Faire un don'], ['id' => 'membre', 'icon' => 'fa-user', 'label' => 'Espace membre'], ['id' => 'contact', 'icon' => 'fa-phone', 'label' => 'Contact'], ['id' => 'menu', 'icon' => 'fa-bars', 'label' => 'Menu']]; @endphp

        @foreach ($tabs as $t)
            <a wire:navigate href="{{ route('nehemie.app', ['tab' => $t['id']]) }}" class="mb-5"
                style="display: flex;
            flex-direction: column;
            align-items: center;
            font-size: .75rem;
            padding: .5rem; {{ $page === $t['id'] ? 'color: #825f45' : 'color: #334155' }}">
                <i class="fas {{ $t['icon'] }}"></i>
                <span>{{ $t['label'] }}</span>
            </a>
        @endforeach
    </nav>


    @push('scripts')
        <script>
            // écoute l’événement pour (ré)initialiser le graphique côté membre
            document.addEventListener('livewire:init', () => {
                Livewire.on('init-don-chart', (payload) => {
                    const ctx = document.getElementById('donChart');
                    if (!ctx) return;
                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep',
                                'Oct', 'Nov', 'Déc'
                            ],
                            datasets: [{
                                label: 'Dons (FCFA)',
                                data: payload?.data ?? [15000, 25000, 20000, 35000, 30000,
                                    45000, 25000, 40000, 35000, 75000, 50000, 25000
                                ],
                                borderColor: '#1e40af',
                                backgroundColor: 'rgba(30,64,175,0.1)',
                                tension: .4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: v => v.toLocaleString() + ' FCFA'
                                    }
                                }
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</div>
