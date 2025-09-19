{{-- resources/views/livewire/nehemie/page-membre.blade.php --}}
<div>
    @if (!$logged)
        <h2 class="text-xl font-bold mb-4 text-center">Connexion Membre</h2>
        <div class="card space-y-3">
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" class="w-full p-3 border-2 rounded" placeholder="votre@email.com">
            </div>
            <div>
                <label class="block font-semibold mb-1">Mot de passe</label>
                <input type="password" class="w-full p-3 border-2 rounded" placeholder="••••••••">
            </div>
            <button wire:click="login"
                class="w-full bg-gradient-to-tr from-blue-800 to-blue-500 text-white font-semibold py-3 rounded">Se
                connecter</button>
            <button class="w-full bg-yellow-500 text-white font-semibold py-3 rounded">Créer un compte</button>
            <div class="text-center">
                <a class="text-blue-600 text-sm" href="#">Mot de passe oublié ?</a>
            </div>
        </div>
    @else
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Mon Espace</h2>
            <button wire:click="logout" class="text-red-600"><i class="fas fa-sign-out-alt"></i></button>
        </div>

        {{-- Profil --}}
        <div class="card mb-4">
            <div class="flex items-center">
                <div
                    class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                    JD</div>
                <div>
                    <h3 class="font-bold text-lg">Jean Dupont</h3>
                    <p class="text-gray-600">Membre depuis mars 2023</p>
                    <div class="flex mt-2 gap-2">
                        <span class="badge" style="background:#f59e0b">Donateur Fidèle</span>
                        <span class="badge" style="background:#c0c0c0">Parrain</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="text-white rounded-xl p-6 text-center"
                style="background:linear-gradient(135deg,var(--primary-blue),var(--secondary-blue))">
                <div class="text-3xl font-bold">247 500</div>
                <div class="opacity-90 text-sm">FCFA donnés</div>
            </div>
            <div class="text-white rounded-xl p-6 text-center"
                style="background:linear-gradient(135deg,var(--accent-gold),#f97316)">
                <div class="text-3xl font-bold">12</div>
                <div class="opacity-90 text-sm">Dons effectués</div>
            </div>
        </div>

        {{-- Graphique --}}
        <div class="card mb-4">
            <h3 class="font-bold mb-4">Évolution de mes dons (FCFA)</h3>
            <div class="h-52"><canvas id="donChart"></canvas></div>
        </div>

        {{-- Historique --}}
        <div class="card mb-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold">Historique des dons</h3>
                <button class="text-blue-600"><i class="fas fa-download mr-1"></i>Export</button>
            </div>

            @php
                $rows = [
                    [
                        'titre' => 'Campagne alimentaire',
                        'date' => '15 décembre 2024',
                        'etat' => ['✓ Confirmé', 'text-green-600'],
                        'montant' => 25000,
                        'receipt' => true,
                    ],
                    [
                        'titre' => 'Programme SALOMON',
                        'date' => '28 novembre 2024',
                        'etat' => ['✓ Confirmé', 'text-green-600'],
                        'montant' => 50000,
                        'receipt' => true,
                    ],
                    [
                        'titre' => 'Don mensuel récurrent',
                        'date' => '1 décembre 2024',
                        'etat' => ['⏳ En attente', 'text-yellow-600'],
                        'montant' => 15000,
                        'receipt' => false,
                    ],
                    [
                        'titre' => 'Programme JOSEPH',
                        'date' => '15 octobre 2024',
                        'etat' => ['✓ Confirmé', 'text-green-600'],
                        'montant' => 75000,
                        'receipt' => true,
                    ],
                ];
            @endphp

            @foreach ($rows as $r)
                <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                    <div>
                        <div class="font-semibold">{{ $r['titre'] }}</div>
                        <div class="text-sm text-gray-600">{{ $r['date'] }}</div>
                        <div class="text-xs {{ $r['etat'][1] }}">{{ $r['etat'][0] }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-blue-700">{{ number_format($r['montant'], 0, ',', ' ') }} FCFA</div>
                        <button class="text-blue-600 text-sm {{ $r['receipt'] ?: 'text-gray-400 pointer-events-none' }}">
                            <i class="fas fa-receipt"></i> Reçu
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-4">
                <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded">Voir tous les dons</button>
            </div>
        </div>

        {{-- Récap --}}
        <div class="card">
            <h3 class="font-bold mb-4">Récapitulatif 2024</h3>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-blue-600">247 500</div>
                    <div class="text-sm text-gray-600">FCFA donnés</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">12</div>
                    <div class="text-sm text-gray-600">Dons effectués</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-yellow-600">3</div>
                    <div class="text-sm text-gray-600">Programmes soutenus</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-purple-600">147</div>
                    <div class="text-sm text-gray-600">Personnes aidées</div>
                </div>
            </div>
            <button
                class="w-full mt-4 bg-gradient-to-tr from-blue-800 to-blue-500 text-white font-semibold py-3 rounded">
                <i class="fas fa-download mr-2"></i> Télécharger le récapitulatif
            </button>
        </div>
    @endif
</div>
