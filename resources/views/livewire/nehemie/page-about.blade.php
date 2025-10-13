{{-- resources/views/livewire/nehemie/page-about.blade.php --}}
<div class="space-y-10">
    {{-- Barre titre + retour --}}
    <div class="flex items-center gap-3">
        <a wire:navigate href="{{ route('nehemie.app', ['tab' => 'menu']) }}" class="text-blue-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-xl font-bold">À propos de NÉHÉMIE</h2>
    </div>

    {{-- ========== Section Notre Histoire ========== --}}
    <section id="histoire" class="space-y-8">
        <div class="text-center">
            <h3 class="text-2xl font-bold">Notre Histoire</h3>
            <div class="mx-auto mt-2 h-1 w-16 rounded bg-blue-600"></div>
        </div>

        <div class="mx-auto max-w-3xl space-y-4 text-center">
            <h4 class="text-lg font-semibold">NÉHÉMIE International</h4>
            <p class="text-gray-700">
                Fondée en 2020, notre organisation est née de la vision partagée de plusieurs membres engagés de la
                communauté
                chrétienne du Gabon, unis par la foi et la volonté de faire une différence tangible dans la société.
            </p>
            <p class="text-gray-700">
                Inspirée par l’exemple biblique de Néhémie, qui a reconstruit les murailles de Jérusalem, notre
                organisation
                s’est donnée pour mission de reconstruire les vies brisées et de restaurer l’espérance dans les cœurs.
            </p>
            <p class="text-gray-700">
                Depuis nos débuts, nous œuvrons sans relâche pour apporter un soutien concret aux plus démunis, en nous
                appuyant sur des valeurs chrétiennes fortes et un engagement sans faille envers notre communauté.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="flex items-start gap-3 rounded-xl bg-[#FFF8F0] p-4 ring-1 ring-amber-200">
                <div
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-200">
                    <i class="fas fa-users text-[#8B4513]"></i>
                </div>
                <div>
                    <h5 class="font-semibold">Notre Communauté</h5>
                    <p class="text-sm text-gray-600">
                        Une équipe dévouée au service des autres, répondant aux défis sociaux et spirituels du Gabon.
                    </p>
                </div>
            </div>
            <div class="flex items-start gap-3 rounded-xl bg-[#FFF8F0] p-4 ring-1 ring-amber-200">
                <div
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-200">
                    <i class="fas fa-hands-helping text-[#8B4513]"></i>
                </div>
                <div>
                    <h5 class="font-semibold">Notre Impact</h5>
                    <p class="text-sm text-gray-600">
                        Des centaines de vies touchées chaque année à travers nos programmes d’aide et d’accompagnement.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== Section Vision & Mission ========== --}}
    <section id="vision-mission" class="space-y-8">
        <div class="text-center">
            <h3 class="text-2xl font-bold">Notre vision & mission</h3>
            <div class="mx-auto mt-2 h-1 w-16 rounded bg-blue-600"></div>
            <p class="mx-auto mt-3 max-w-3xl text-sm text-gray-600">
                NÉHÉMIE International existe pour exprimer sa foi par son engagement en faveur de la restauration, de la
                solidarité et de l’autonomie des personnes vulnérables et fragilisées.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl bg-white p-5 text-center shadow-sm ring-1 ring-gray-100">
                <div
                    class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 ring-1 ring-emerald-200">
                    <i class="fas fa-hands-helping text-emerald-700"></i>
                </div>
                <h4 class="font-semibold">Aide & Soutien</h4>
                <p class="text-sm text-gray-600">Répondre aux besoins essentiels des populations les plus défavorisées.
                </p>
            </div>
            <div class="rounded-2xl bg-white p-5 text-center shadow-sm ring-1 ring-gray-100">
                <div
                    class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 ring-1 ring-blue-200">
                    <i class="fas fa-chalkboard-teacher text-blue-700"></i>
                </div>
                <h4 class="font-semibold">Formation</h4>
                <p class="text-sm text-gray-600">Former et accompagner les personnes vers l’autonomie économique et
                    sociale.</p>
            </div>
            <div class="rounded-2xl bg-white p-5 text-center shadow-sm ring-1 ring-gray-100">
                <div
                    class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-200">
                    <i class="fas fa-pray text-amber-700"></i>
                </div>
                <h4 class="font-semibold">Accompagnement Spirituel</h4>
                <p class="text-sm text-gray-600">Offrir un accompagnement spirituel qui respecte la liberté de
                    conscience.</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="text-center">
                <h4 class="text-lg font-bold">Notre approche : L’évangélisation par les actes</h4>
                <div class="mx-auto mt-2 h-1 w-12 rounded bg-blue-600"></div>
            </div>
            <figure class="relative rounded-2xl bg-[#FFF8F0] p-5 ring-1 ring-amber-200">
                <i class="fas fa-quote-left absolute -top-3 left-4 text-2xl text-amber-500"></i>
                <blockquote class="text-sm text-gray-700">
                    À quoi bon dire qu’on a la foi, si l’on n’a pas les œuvres ? La foi peut-elle sauver, si elle n’a
                    pas les
                    œuvres ? Si un frère ou une sœur sont nus, s’ils manquent de leur nourriture quotidienne, et que
                    l’un d’entre
                    vous leur dise : Allez en paix, chauffez-vous et rassasiez-vous ! sans leur donner ce qui est
                    nécessaire au
                    corps, à quoi cela sert-il ?
                </blockquote>
                <figcaption class="mt-2 text-right text-xs text-gray-500">Jacques 2:14-17</figcaption>
            </figure>
        </div>
    </section>

    {{-- ========== Section Nos Valeurs ========== --}}
    <section id="valeurs" class="space-y-6">
        <div class="text-center">
            <h3 class="text-2xl font-bold">Nos Valeurs Fondamentales</h3>
            <div class="mx-auto mt-2 h-1 w-16 rounded bg-blue-600"></div>
        </div>

        {{-- Accordéon sans JS via <details> --}}
        <div class="space-y-2">
            @php
                $valeurs = [
                    [
                        'id' => 'amour',
                        'icon' => 'fa-heart',
                        'label' => 'Amour du prochain',
                        'text' =>
                            'Nous croyons en l’amour inconditionnel pour chaque être humain, inspiré par l’exemple du Christ.',
                    ],
                    [
                        'id' => 'solidarite',
                        'icon' => 'fa-hands-helping',
                        'label' => 'Solidarité',
                        'text' =>
                            'Nous nous engageons à marcher aux côtés des plus vulnérables pour construire une société plus juste.',
                    ],
                    [
                        'id' => 'compassion',
                        'icon' => 'fa-hand-holding-heart',
                        'label' => 'Compassion',
                        'text' =>
                            'Nous portons une attention particulière aux souffrances humaines et cherchons à les soulager.',
                    ],
                    [
                        'id' => 'integrite',
                        'icon' => 'fa-shield-alt',
                        'label' => 'Intégrité',
                        'text' =>
                            'Nous agissons avec transparence, honnêteté et responsabilité dans toutes nos actions.',
                    ],
                    [
                        'id' => 'respect',
                        'icon' => 'fa-handshake',
                        'label' => 'Respect',
                        'text' =>
                            'Nous reconnaissons la dignité de chaque personne et respectons ses croyances et ses choix.',
                    ],
                ];
            @endphp

            @foreach ($valeurs as $v)
                <details class="group rounded-xl bg-white p-3 shadow-sm ring-1 ring-gray-100 open:ring-amber-200">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-200">
                                <i class="fas {{ $v['icon'] }} text-[#8B4513]"></i>
                            </span>
                            <span class="font-semibold">{{ $v['label'] }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="mt-2 pl-12 text-sm text-gray-600">
                        {{ $v['text'] }}
                    </div>
                </details>
            @endforeach
        </div>
    </section>

    {{-- ========== Section Notre Équipe ========== --}}
    <section id="equipe" class="space-y-6">
        <div class="text-center">
            <h3 class="text-2xl font-bold">Notre Équipe</h3>
            <div class="mx-auto mt-2 h-1 w-16 rounded bg-blue-600"></div>
            <p class="mt-3 text-xs text-gray-500">Direction et Administration</p>
        </div>

        {{-- Lightbox --}}
        <div id="teamLightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
            <button class="absolute right-4 top-4 text-white text-2xl" data-close>&times;</button>
            <img id="lightboxImg" class="max-h-[75vh] rounded-xl shadow-2xl" alt="">
            <div id="lightboxCaption" class="mt-2 text-center text-sm text-gray-200"></div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            {{-- 1 --}}
            <div class="rounded-2xl bg-[#FFF8F0] p-5 text-center ring-1 ring-amber-200">
                <img src="{{ asset('images/team/dg.png') }}" alt="Davy NGUEL'ENGOGO"
                    class="mx-auto mb-3 h-36 w-36 cursor-pointer rounded-full object-cover ring-2 ring-amber-200 team-photo"
                    data-src="{{ asset('images/team/dg.png') }}" data-name="Davy NGUEL'ENGOGO" data-role="Président">
                <h5 class="font-semibold">Davy NGUEL'ENGOGO</h5>
                <p class="text-sm text-gray-500">Président</p>
            </div>

            {{-- 2 --}}
            <div class="rounded-2xl bg-[#FFF8F0] p-5 text-center ring-1 ring-amber-200">
                <img src="{{ asset('images/team/secretaire-general.jpg') }}" alt="Patrick MEVIANE BLAMPAIN"
                    class="mx-auto mb-3 h-36 w-36 cursor-pointer rounded-full object-cover ring-2 ring-amber-200 team-photo"
                    data-src="{{ asset('images/team/secretaire-general.jpg') }}" data-name="Patrick MEVIANE BLAMPAIN"
                    data-role="Secrétaire Général">
                <h5 class="font-semibold">Patrick MEVIANE BLAMPAIN</h5>
                <p class="text-sm text-gray-500">Secrétaire Général</p>
            </div>

            {{-- 3 --}}
            <div class="rounded-2xl bg-[#FFF8F0] p-5 text-center ring-1 ring-amber-200">
                <img src="{{ asset('images/logo2.png') }}" alt="Arsène BOUYOU NENDJO"
                    class="mx-auto mb-3 h-36 w-36 cursor-pointer rounded-full object-cover ring-2 ring-amber-200 team-photo"
                    data-src="{{ asset('images/logo2.png') }}" data-name="Arsène BOUYOU NENDJO"
                    data-role="Secrétaire Général Adjoint">
                <h5 class="font-semibold">Arsène BOUYOU NENDJO</h5>
                <p class="text-sm text-gray-500">Secrétaire Général Adjoint</p>
            </div>

            {{-- 4 --}}
            <div class="rounded-2xl bg-[#FFF8F0] p-5 text-center ring-1 ring-amber-200">
                <img src="{{ asset('images/logo2.png') }}" alt="ROGOULA Kassandra"
                    class="mx-auto mb-3 h-36 w-36 cursor-pointer rounded-full object-cover ring-2 ring-amber-200 team-photo"
                    data-src="{{ asset('images/logo2.png') }}" data-name="ROGOULA Kassandra"
                    data-role="Assistance de Direction">
                <h5 class="font-semibold">ROGOULA Kassandra</h5>
                <p class="text-sm text-gray-500">Assistance de Direction</p>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Lightbox minimaliste (aucune dépendance)
            (function() {
                const box = document.getElementById('teamLightbox');
                if (!box) return;
                const img = document.getElementById('lightboxImg');
                const cap = document.getElementById('lightboxCaption');

                document.querySelectorAll('.team-photo').forEach(el => {
                    el.addEventListener('click', () => {
                        img.src = el.dataset.src || el.src;
                        cap.textContent =
                            `${el.dataset.name ?? ''}${el.dataset.role ? ' — ' + el.dataset.role : ''}`;
                        box.classList.remove('hidden');
                        box.classList.add('flex');
                    });
                });

                box.querySelector('[data-close]').addEventListener('click', () => {
                    box.classList.add('hidden');
                    box.classList.remove('flex');
                });
                box.addEventListener('click', (e) => {
                    if (e.target === box) {
                        box.classList.add('hidden');
                        box.classList.remove('flex');
                    }
                });
            })();
        </script>
    @endpush
</div>
