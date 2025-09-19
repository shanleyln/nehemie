{{-- resources/views/livewire/nehemie/page-contact.blade.php --}}
<div class="space-y-4">
    <style>
        .contact-option {
            transition: all 0.3s ease;
            border: 1px solid #e8d9c5;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .contact-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.1);
            border-color: #8B4513;
        }

        .contact-option .icon-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #FFF8F0;
            transition: all 0.3s ease;
        }

        .contact-option:hover .icon-wrapper {
            background-color: #8B4513;
        }

        .contact-option:hover .icon-wrapper i {
            color: white !important;
        }

        .contact-option .text-primary {
            color: #8B4513 !important;
            transition: all 0.3s ease;
        }

        .contact-option:hover .text-primary {
            color: #8B4513 !important;
        }

        .contact-option .text-muted {
            transition: all 0.3s ease;
        }

        .contact-option:hover .text-muted {
            color: #8B4513 !important;
        }
    </style>
    <h2 class="text-xl font-bold text-center">Nous Contacter</h2>

    <div class="card">
        <h3 class="font-bold mb-4">Informations de contact</h3>
        <div class="modal-body p-4 pt-2">
            <div class="d-grid gap-3">
                <a href="tel:+24166609668" class="contact-option text-decoration-none p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fas fa-phone text-marron"></i>
                        </div>
                        <div>
                            <span class="d-block fw-medium text-primary">Nous appeler</span>
                            <small class="text-muted">+241 66609668</small>
                        </div>
                        <div class="ms-auto">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>

                <a href="https://wa.me/24166609668" target="_blank" class="contact-option text-decoration-none p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="fab fa-whatsapp text-marron"></i>
                        </div>
                        <div>
                            <span class="d-block fw-medium text-primary">Discuter sur WhatsApp</span>
                            <small class="text-muted">Réponse rapide garantie</small>
                        </div>
                        <div class="ms-auto">
                            <i class="fas fa-external-link-alt text-muted small"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mt-4 text-center">
                <div class="d-inline-flex align-items-center px-3 py-2 rounded" style="background-color: #FFF8F0;">
                    <i class="far fa-clock text-marron me-2"></i>
                    <span class="small text-muted">Disponible du lundi au vendredi, de 8h à 17h</span>
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
