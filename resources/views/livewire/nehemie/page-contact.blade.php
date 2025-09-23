{{-- resources/views/livewire/nehemie/page-contact.blade.php --}}
<div class="space-y-6">
    <h2 class="text-xl font-bold text-center">Nous Contacter</h2>

    <div class="rounded-2xl border border-amber-200 bg-white/80 backdrop-blur-sm shadow-sm">
        <div class="p-4 pt-2">
            <div class="grid gap-3">
                {{-- Disponibilité --}}
                <div class="mt-5 text-center">
                    <div class="inline-flex items-center rounded-full bg-[#FFF8F0] px-3 py-2 ring-1 ring-amber-200">
                        <i class="far fa-clock mr-2 text-[#8B4513]"></i>
                        <span class="text-xs text-gray-600">Disponible du lundi au vendredi, de 8h à 17h</span>
                    </div>
                </div>

                {{-- Appel --}}
                <a href="tel:+24166609668"
                    class="group flex items-center justify-between rounded-xl border border-amber-100 bg-[#FFF8F0] p-3 transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-[#8B4513]">
                    <div class="flex items-center">
                        <div
                            class="icon-wrapper mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 ring-1 ring-amber-200 transition-all group-hover:bg-[#8B4513]">
                            <i class="fas fa-phone text-[#8B4513] transition-colors group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="block font-medium text-[#8B4513]">Nous appeler</span>
                            <small class="text-gray-500 transition-colors group-hover:text-[#8B4513]">+241 66 60 96
                                68</small>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 transition-colors group-hover:text-[#8B4513]"></i>
                </a>

                {{-- WhatsApp --}}
                <a href="https://wa.me/24166609668" target="_blank" rel="noopener"
                    class="group flex items-center justify-between rounded-xl border border-amber-100 bg-white p-3 transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-[#8B4513]">
                    <div class="flex items-center">
                        <div
                            class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 ring-1 ring-emerald-200 transition-all group-hover:bg-[#8B4513]">
                            <i class="fab fa-whatsapp text-[#8B4513] transition-colors group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="block font-medium text-[#8B4513]">Discuter sur WhatsApp</span>
                            <small class="text-gray-500 transition-colors group-hover:text-[#8B4513]">Réponse rapide
                                garantie</small>
                        </div>
                    </div>
                    <i
                        class="fas fa-external-link-alt text-gray-400 text-xs transition-colors group-hover:text-[#8B4513]"></i>
                </a>

                {{-- Email (optionnel, garde si tu veux) --}}
                <a href="mailto:info@nehemie-international.com"
                    class="group flex items-center justify-between rounded-xl border border-amber-100 bg-white p-3 transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-[#8B4513]">
                    <div class="flex items-center">
                        <div
                            class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-orange-50 ring-1 ring-orange-200 transition-all group-hover:bg-[#8B4513]">
                            <i class="fas fa-envelope text-[#8B4513] transition-colors group-hover:text-white"></i>
                        </div>
                        <div>
                            <span class="block font-medium text-[#8B4513]">Envoyer un email</span>
                            <small
                                class="text-gray-500 transition-colors group-hover:text-[#8B4513]">info@nehemie-international.com</small>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 transition-colors group-hover:text-[#8B4513]"></i>
                </a>

                <!-- Section Carte -->
                <section class="map-section" style="max-width: 1000px; margin: 0 auto;">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.951512393891!2d9.484083!3d0.420667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMjUnMTQuNCJOIDnCsDI5JzAyLjciRQ!5e0!3m2!1sfr!2sfr!5m1!1s0x0%3A0x0!8m2!3d0.420667!4d9.484083!15sCjQwJzI1JzE0LjQiTiA5wrAyOScwMi43IkqIAQh0cmFuc2l0X3N0YXRpb26aASNDaFpEU1VoTk1HOW5TMFZKUTBGblNVTmhZbXhmVlRZNVJSQULgAQE!16s%2Fg%2F11b8v4z4x9!5m2!1sfr!2sfr&z=12"
                            width="100%" height="150"
                            style="border:0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Localisation de NÉHÉMIE International">
                        </iframe>
                    </div>
                </section>
            </div>


        </div>
    </div>
</div>
