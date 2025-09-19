{{-- resources/views/livewire/nehemie/page-don.blade.php --}}
<div>
    <h2 class="text-xl font-bold mb-4 text-center">Faire un Don</h2>

    <div class="card mb-4">
        @include('pvit.public_pay')
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
