{{-- resources/views/livewire/nehemie/chat-assistant.blade.php --}}
<div class="fixed right-5 bottom-24 z-50">
    <button wire:click="toggle" class="w-14 h-14 rounded-full text-white text-xl shadow-lg"
        style="background:linear-gradient(135deg,var(--accent-gold),#f97316)">
        <i class="fas fa-comments"></i>
    </button>

    @if ($open)
        <div class="mt-3 w-72 bg-white rounded-xl shadow-2xl overflow-hidden animate-[slideUp_.3s_ease]">
            <div class="p-4 bg-blue-600 text-white flex justify-between items-center">
                <div class="flex items-center"><i class="fas fa-robot mr-2"></i><span class="font-semibold">Assistant
                        NÉHÉMIE</span></div>
                <button wire:click="toggle"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-4 space-y-2">
                <div class="bg-gray-100 p-3 rounded text-sm">Bonjour ! Comment puis-je vous aider aujourd'hui ?</div>
                <button wire:click="quick('Comment faire un don ?')"
                    class="w-full text-left p-2 text-sm bg-blue-50 rounded hover:bg-blue-100">💰 Comment faire un don
                    ?</button>
                <button wire:click="quick('Devenir bénévole')"
                    class="w-full text-left p-2 text-sm bg-blue-50 rounded hover:bg-blue-100">🤝 Devenir
                    bénévole</button>
                <button wire:click="quick('Suivre mes dons')"
                    class="w-full text-left p-2 text-sm bg-blue-50 rounded hover:bg-blue-100">📊 Suivre mes
                    dons</button>
                <button wire:click="quick('Contacter l équipe')"
                    class="w-full text-left p-2 text-sm bg-blue-50 rounded hover:bg-blue-100">📞 Contacter
                    l'équipe</button>
                <input wire:model.live="question" type="text" class="w-full p-2 border rounded text-sm"
                    placeholder="Tapez votre question...">
            </div>
        </div>
    @endif
</div>
