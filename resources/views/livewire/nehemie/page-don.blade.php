{{-- resources/views/livewire/nehemie/page-don.blade.php --}}
<div>
    <h2 class="text-xl font-bold mb-4 text-center">Faire un Don</h2>

    <div class="card mb-4">
        <h3 class="font-bold mb-4">Choisissez le montant</h3>

        <div class="grid grid-cols-2 gap-3">
            @foreach ([5000 => 'Repas pour 2 familles', 10000 => 'Kit scolaire complet', 25000 => 'Formation professionnelle', 50000 => 'Aide d\'urgence famille'] as $v => $label)
                <button type="button" wire:click="selectAmount({{ $v }})"
                    class="p-3 border-2 rounded text-center {{ $amount === $v ? 'border-blue-700 bg-blue-50' : 'border-gray-200 bg-white' }}">
                    <div class="font-bold text-lg text-blue-700">{{ number_format($v, 0, ',', ' ') }} FCFA</div>
                    <div class="text-sm text-gray-600">{{ $label }}</div>
                </button>
            @endforeach
        </div>

        <div class="mt-4">
            <label class="block font-semibold mb-1">Montant personnalisé (FCFA)</label>
            <input type="number" min="1000" wire:model.live="amount" class="w-full p-3 border-2 rounded"
                placeholder="Entrez votre montant">
        </div>

        <div class="mt-4">
            <label class="block font-semibold mb-1">Programme à soutenir</label>
            <select wire:model.live="program" class="w-full p-3 border-2 rounded">
                <option>Tous les programmes</option>
                <option>Programme SALOMON (Gouvernement/Éducation)</option>
                <option>Programme JOSEPH (Économie/Affaires)</option>
                <option>Programme DAVID (Arts/Médias)</option>
                <option>Programme DANIEL (Religion/Spiritualité)</option>
                <option>Programme PRISCILLE & AQUILA (Famille/Social)</option>
            </select>
        </div>

        <div class="mt-4">
            <label class="block font-semibold mb-1">Fréquence</label>
            <div class="flex gap-6">
                <label class="flex items-center">
                    <input type="radio" class="mr-2" value="once" wire:model.live="frequency"> Don unique
                </label>
                <label class="flex items-center">
                    <input type="radio" class="mr-2" value="monthly" wire:model.live="frequency"> Mensuel
                </label>
            </div>
        </div>

        <button wire:click="confirm"
            class="mt-4 w-full bg-gradient-to-tr from-blue-800 to-blue-500 text-white font-semibold py-3 rounded">
            <i class="fas fa-heart mr-2"></i> Confirmer le don
        </button>
    </div>

    {{-- Programmes --}}
    <div class="card">
        <h3 class="font-bold mb-4">Nos Programmes</h3>
        <div class="grid grid-cols-2 gap-3 text-center">
            @php
                $progs = [
                    ['img' => 'salomon.png', 'name' => 'SALOMON', 'desc' => 'Gouvernement'],
                    ['img' => 'joseph.png', 'name' => 'JOSEPH', 'desc' => 'Économie'],
                    ['img' => 'david.png', 'name' => 'DAVID', 'desc' => 'Arts & Médias'],
                    ['img' => 'priscille.png', 'name' => 'PRISCILLE', 'desc' => 'Famille'],
                ];
            @endphp
            @foreach ($progs as $p)
                <div>
                    <img class="w-16 h-16 mx-auto mb-2 rounded-lg"
                        src="https://nehemie-international.com/images/programme/{{ $p['img'] }}" alt="">
                    <p class="text-sm font-semibold">{{ $p['name'] }}</p>
                    <p class="text-xs text-gray-600">{{ $p['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
