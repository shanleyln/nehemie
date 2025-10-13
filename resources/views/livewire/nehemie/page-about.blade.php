<div class="space-y-4">
    <div class="flex items-center gap-3">
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'menu']) }}" class="text-blue-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold">À propos de NÉHÉMIE</h2>
    </div>

    <div class="card">
        <h3 class="font-semibold mb-2">Qui sommes-nous ?</h3>
        <p class="text-gray-700">Organisation engagée pour l’aide alimentaire, l’éducation et l’autonomisation des
            familles.</p>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div class="card text-center">
            <div class="text-2xl font-bold text-blue-700">+1,500</div>
            <div class="text-xs text-gray-500">Repas distribués</div>
        </div>
        <div class="card text-center">
            <div class="text-2xl font-bold text-blue-700">+120</div>
            <div class="text-xs text-gray-500">Enfants scolarisés</div>
        </div>
    </div>

    <div class="card">
        <h3 class="font-semibold mb-2">Nos valeurs</h3>
        <ul class="space-y-1 text-gray-700 list-disc list-inside">
            <li>Intégrité & transparence</li>
            <li>Solidarité & dignité</li>
            <li>Impact concret & mesurable</li>
        </ul>
    </div>
</div>
