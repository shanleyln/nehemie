{{-- resources/views/livewire/nehemie/page-menu.blade.php --}}
<div class="space-y-4">
    <h2 class="text-xl font-bold text-center">Menu Principal</h2>

    @php
        $items = [
            ['to' => 'about', 'icon' => 'fa-info-circle', 'label' => 'À propos de NÉHÉMIE'],
            ['to' => 'projects', 'icon' => 'fa-project-diagram', 'label' => 'Nos Projets'],
            ['to' => 'engage', 'icon' => 'fa-hands-helping', 'label' => "S'engager"],
        ];
    @endphp

    <div class="space-y-3">
        @foreach ($items as $it)
            <a wire:navigate href="{{ route('nehemie.app', ['tab' => $it['to']]) }}"
                class="flex items-center justify-between rounded-xl bg-white shadow-sm px-4 py-3 ring-1 ring-gray-100 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 ring-1 ring-blue-100">
                        <i class="fas {{ $it['icon'] }} text-blue-700"></i>
                    </span>
                    <div class="font-medium text-gray-800">{{ $it['label'] }}</div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        @endforeach
    </div>

    <div class="rounded-xl bg-white shadow-sm px-4 py-5 text-center ring-1 ring-gray-100">
        <h3 class="font-bold text-gray-800 mb-1">Version de l'application</h3>
        <p class="text-gray-600">v1.2.0</p>
        <p class="text-xs text-gray-400 mt-2">© 2024 NÉHÉMIE International</p>
    </div>
</div>
