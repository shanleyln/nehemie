<div class="space-y-4">
    <div class="flex items-center gap-3">
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'menu']) }}" class="text-blue-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold">S'engager</h2>
    </div>

    <div class="card">
        <h3 class="font-semibold mb-2">Devenir bénévole</h3>
        <p class="text-gray-700 mb-3">Rejoignez nos équipes sur le terrain (logistique, éducation, sensibilisation).</p>
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'contact']) }}"
            class="inline-block bg-gradient-to-tr from-blue-800 to-blue-500 text-white font-semibold px-4 py-2 rounded">
            Je me porte volontaire
        </a>
    </div>

    <div class="card">
        <h3 class="font-semibold mb-2">Soutenir financièrement</h3>
        <p class="text-gray-700 mb-3">Chaque contribution compte pour financer nos actions.</p>
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'don']) }}"
            class="inline-block bg-yellow-500 text-white font-semibold px-4 py-2 rounded">
            Faire un don
        </a>
    </div>

    <div class="card">
        <h3 class="font-semibold mb-2">Devenir partenaire</h3>
        <p class="text-gray-700 mb-3">Entreprises & institutions : construisons ensemble un impact durable.</p>
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'contact']) }}"
            class="inline-block text-blue-700 font-semibold">
            Proposer un partenariat →
        </a>
    </div>
</div>
