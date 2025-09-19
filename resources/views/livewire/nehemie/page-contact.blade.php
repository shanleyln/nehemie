{{-- resources/views/livewire/nehemie/page-contact.blade.php --}}
<div class="space-y-4">
    <h2 class="text-xl font-bold text-center">Nous Contacter</h2>

    <div class="card">
        <h3 class="font-bold mb-4">Informations de contact</h3>
        <div class="space-y-3">
            <div class="flex items-center"><i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                <div>
                    <div class="font-semibold">Adresse</div>
                    <div class="text-gray-600">Libreville, Gabon</div>
                </div>
            </div>
            <div class="flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>
                <div>
                    <div class="font-semibold">Téléphone</div>
                    <div class="text-gray-600">+241 XX XX XX XX</div>
                </div>
            </div>
            <div class="flex items-center"><i class="fas fa-envelope text-blue-600 mr-3"></i>
                <div>
                    <div class="font-semibold">Email</div>
                    <div class="text-gray-600">contact@nehemie-international.com</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="font-bold mb-4">Envoyez-nous un message</h3>
        <div class="space-y-3">
            <div><label class="block font-semibold mb-1">Nom complet</label><input wire:model.live="name"
                    class="w-full p-3 border-2 rounded" type="text" placeholder="Votre nom"></div>
            <div><label class="block font-semibold mb-1">Email</label><input wire:model.live="email"
                    class="w-full p-3 border-2 rounded" type="email" placeholder="votre@email.com"></div>
            <div><label class="block font-semibold mb-1">Sujet</label>
                <select wire:model.live="subject" class="w-full p-3 border-2 rounded">
                    <option>Question générale</option>
                    <option>Devenir bénévole</option>
                    <option>Partenariat</option>
                    <option>Support don</option>
                    <option>Autre</option>
                </select>
            </div>
            <div><label class="block font-semibold mb-1">Message</label>
                <textarea wire:model.live="message" rows="4" class="w-full p-3 border-2 rounded" placeholder="Votre message..."></textarea>
            </div>
            <button wire:click="send"
                class="w-full bg-gradient-to-tr from-blue-800 to-blue-500 text-white font-semibold py-3 rounded">
                <i class="fas fa-paper-plane mr-2"></i> Envoyer le message
            </button>
        </div>
    </div>
</div>
