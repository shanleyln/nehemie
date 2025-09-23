{{-- resources/views/livewire/nehemie/page-menu.blade.php --}}
<div>
    <h2 class="text-xl font-bold mb-4 text-center">Menu Principal</h2>
    @php
        $items = [
            ['icon' => 'fa-info-circle', 'label' => 'À propos de NÉHÉMIE'],
            ['icon' => 'fa-project-diagram', 'label' => 'Nos Projets'],
            ['icon' => 'fa-hands-helping', 'label' => "S'engager"],
        ];
    @endphp
    <div class="space-y-3">
        @foreach ($items as $it)
            <a class="card flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas {{ $it['icon'] }} text-blue-600 mr-3 text-xl"></i>
                    <div class="font-semibold">{{ $it['label'] }}</div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        @endforeach
    </div>

    <div class="card mt-6 text-center">
        <h3 class="font-bold mb-2">Version de l'application</h3>
        <p class="text-gray-600">v1.2.0</p>
        <p class="text-sm text-gray-500 mt-2">© 2024 NÉHÉMIE International</p>
    </div>
</div>
