<div class="space-y-4">
    <div class="flex items-center gap-3">
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'menu']) }}" class="text-blue-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold">Nos Projets</h2>
    </div>

    @php
        $projets = [
            [
                'icon' => 'fa-utensils',
                'title' => 'Aide alimentaire',
                'desc' => 'Distribution de paniers repas hebdomadaires.',
            ],
            [
                'icon' => 'fa-graduation-cap',
                'title' => 'Kits scolaires',
                'desc' => 'Équipement complet pour la rentrée.',
            ],
            ['icon' => 'fa-briefcase', 'title' => 'Insertion pro', 'desc' => 'Formations courtes & accompagnement.'],
        ];
    @endphp

    <div class="space-y-3">
        @foreach ($projets as $p)
            <div class="card flex items-start gap-3">
                <div
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 ring-1 ring-blue-100">
                    <i class="fas {{ $p['icon'] }} text-blue-700"></i>
                </div>
                <div>
                    <div class="font-semibold">{{ $p['title'] }}</div>
                    <div class="text-sm text-gray-600">{{ $p['desc'] }}</div>
                </div>
                <div class="ml-auto">
                    <button class="text-blue-700 text-sm">Voir détails</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
