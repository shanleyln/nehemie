{{-- resources/views/livewire/nehemie/page-actualites.blade.php --}}
<div class="space-y-4">
    <h2 class="text-xl font-bold text-center">Actualités NÉHÉMIE</h2>

    <div class="bg-white rounded-xl shadow">
        <img src="https://nehemie-international.com/images/campagne.jpg" alt=""
            class="w-full h-52 object-cover rounded-t-xl">
        <div class="p-4">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-lg">Donnez-leur vous-mêmes à manger</h3>
                <span class="badge">En cours</span>
            </div>
            <p class="text-gray-600 text-sm mb-3">Durant tout le mois de juin, faites partie d'un miracle quotidien.</p>
            <div class="w-full h-2 bg-gray-200 rounded">
                <div class="h-2 rounded" style="width:65%;background:linear-gradient(90deg,#1e40af,#3b82f6)"></div>
            </div>
            <div class="flex justify-between text-sm text-gray-600 my-3">
                <span>Collecté: 1 950 000 FCFA</span><span>Objectif: 3 000 000 FCFA</span>
            </div>
            <div class="flex gap-2">
                <button wire:click="$dispatch('goto','don')" class="btn-primary flex-1 text-center">Faire un
                    don</button>
                <button class="px-3 rounded bg-yellow-500 text-white"><i class="fas fa-share"></i></button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow">
        <img src="https://nehemie-international.com/images/rejoindre.jpg" alt=""
            class="w-full h-52 object-cover rounded-t-xl">
        <div class="p-4">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-lg">Appel aux bénévoles</h3>
                <span class="text-sm text-gray-500">Il y a 2 jours</span>
            </div>
            <p class="text-gray-600 text-sm mb-3">Rejoignez nos programmes d'aide alimentaire et d'éducation.</p>
            <button class="btn-primary">Nous rejoindre</button>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center mb-3">
            <img src="https://nehemie-international.com/images/team/dg.png" class="w-12 h-12 rounded-full mr-3"
                alt="">
            <div>
                <h4 class="font-bold">NGUEL'ENGOGO Davy</h4>
                <p class="text-sm text-gray-600">Président</p>
            </div>
            <span class="text-sm text-gray-500 ml-auto">Il y a 5 jours</span>
        </div>
        <p class="text-gray-700">"Notre foi prend tout son sens lorsqu'elle se traduit par des gestes d'amour et de
            solidarité."</p>
    </div>
</div>
