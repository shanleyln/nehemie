<!-- =================================================================
     NOUVELLE STRUCTURE HTML POUR LE CHATBOT
     ================================================================= -->
<div id="chat-floating-container">
    <!-- Chat Box (adapté du template DreamsChat) -->
    <div id="chat-box" class="chat chat-messages hidden">
        <!-- Chat Header -->
        <div id="chat-header" class="chat-header">
            <!-- Le header sera injecté par JavaScript -->
        </div>

        <!-- Chat Body -->
        <div id="chat-messages" class="chat-body chat-page-group slimscroll">
            <div class="messages">
                <!-- Message d’accueil -->
                <div class="chats">
                    <div class="chat-avatar">
                        <img src="<?= asset('images/gabriel.jpeg') ?>" class="rounded-circle" alt="Gabriel">
                    </div>
                    <div class="chat-content">
                        <div class="chat-profile-name">
                            <h6>Gabriel<i class="ti ti-circle-filled fs-7 mx-2"></i><span
                                    class="chat-time">Maintenant</span></h6>
                        </div>
                        <div class="chat-info">
                            <div class="message-content">
                                Bienvenue, je suis Gabriel. Comment puis-je vous aider aujourd'hui ?
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons rapides -->
                <div id="quick-buttons" class="quick-buttons-container">
                    <button class="quick-btn">Découvrir notre mission</button>
                    <button class="quick-btn">Découvrir nos programmes</button>
                    <button class="quick-btn">Actualités</button>
                    <button class="quick-btn">Témoignages</button>
                    <button class="quick-btn">Contact</button>
                </div>
            </div>
        </div>

        <!-- Chat Footer (Input Area) -->
        <div class="chat-footer">
            <div class="chat-footer-wrap">
                <div class="form-wrap">
                    <input id="user-message" type="text" class="form-control" placeholder="Tapez votre message...">
                </div>
                <div class="form-btn">
                    <button id="send-btn" class="btn btn-primary" type="button">
                        <i class="ti ti-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulle flottante (Launcher) -->
    <div id="chat-launcher" class="chat-bubble">
        <div class="chat-bubble-content">
            <img id="chat-launcher-icon" src="<?= asset('images/gabriel.jpeg') ?>" alt="Gabriel"
                class="chat-icon-image">
        </div>
    </div>
</div>

<!-- =================================================================
     FIN DE LA NOUVELLE STRUCTURE
     ================================================================= -->

<!-- Vos balises audio restent inchangées -->
<audio id="sound-open" src="<?= asset('sounds/open.mp3') ?>"></audio>
<audio id="sound-close" src="<?= asset('sounds/close.mp3') ?>"></audio>
<audio id="sound-receive" src="<?= asset('sounds/message-received.mp3') ?>"></audio>
<audio id="sound-send" src="<?= asset('sounds/message-sent.mp3') ?>"></audio>
<audio id="sound-hint" src="<?= asset('sounds/hint-popup.mp3') ?>"></audio>


<script>
// Gérer le système de navigation SPA (inchangé)
let historyArr = []; // Renommé pour éviter conflit avec window.history
let currentUrl = window.location.pathname;
async function loadPage(url) {
    /* ... Votre code inchangé ... */
}

function initializeEvents() {
    /* ... Votre code inchangé ... */
}
initializeEvents();


// Logique du Chatbot (mise à jour)
document.addEventListener('DOMContentLoaded', function() {

    // --- SONS (inchangé) ---
    const soundOpen = document.getElementById('sound-open');
    const soundClose = document.getElementById('sound-close');
    const soundReceive = document.getElementById('sound-receive');
    const soundSend = document.getElementById('sound-send');

    // --- RÉFÉRENCES DOM (mises à jour) ---
    const chatLauncher = document.getElementById('chat-launcher');
    const chatLauncherIcon = document.getElementById('chat-launcher-icon');
    const chatBox = document.getElementById('chat-box');
    const chatHeader = document.getElementById('chat-header');
    const chatMessagesContainer = document.querySelector('#chat-messages .messages'); // Le conteneur interne
    const chatMessages = document.getElementById('chat-messages'); // Le conteneur scrollable
    const userMessage = document.getElementById('user-message');
    const quickButtons = document.getElementById('quick-buttons');
    const sendBtn = document.getElementById('send-btn'); // Séléction par ID plus simple

    if (!chatLauncher || !chatBox || !chatHeader || !chatMessages || !userMessage || !sendBtn) {
        console.error('Erreur: Un ou plusieurs éléments du chat sont manquants');
        return;
    }

    // --- ANIMATIONS (inchangé) ---
    chatBox.classList.add('animate__animated', 'animate__faster');

    // --- OUVERTURE / FERMETURE (mises à jour mineures) ---
    // --- OUVERTURE / FERMETURE (simplifié) ---
    function openChat() {
        soundOpen.play().catch(e => {});
        if (!chatBox.classList.contains('hidden')) return;

        chatBox.classList.remove('animate__slideOutRight', 'hidden');
        chatBox.classList.add('animate__slideInRight');
        userMessage.focus();

        // La bulle flottante devient "inactive" ou se cache
        chatLauncher.classList.add('hidden');
    }

    function closeChat() {
        soundClose.play().catch(e => {});
        if (chatBox.classList.contains('hidden')) return;

        chatBox.classList.remove('animate__slideInRight');
        chatBox.classList.add('animate__slideOutRight');
        setTimeout(() => {
            chatBox.classList.add('hidden');
        }, 500);

        // On fait réapparaître la bulle flottante
        chatLauncher.classList.remove('hidden');
    }

    // L'événement sur le launcher ne sert plus qu'à ouvrir
    chatLauncher.addEventListener('click', openChat);

    // --- HEADER DU CHAT (mis à jour avec la nouvelle structure) ---
    function createChatHeader() {
        chatHeader.innerHTML = `
        <div class="user-details">
            <div class="avatar avatar-lg online flex-shrink-0">
                <img src="<?= asset('images/gabriel.jpeg') ?>" class="rounded-circle" alt="Gabriel">
            </div>
            <div class="ms-2 overflow-hidden">
                <h6>Gabriel</h6>
                <span class="last-seen">En ligne</span>
            </div>
        </div>
        <div class="chat-options">
            <ul>
                <li>
                 <button class="btn expand-btn" title="Agrandir">
                 <i class="ti ti-arrows-maximize"></i>
                </button>
                </li>
                <li>
                    <!-- NOUVEAU BOUTON DE FERMETURE -->
                    <button class="btn close-btn" title="Fermer le chat" >
                        <i class="ti ti-x"></i>
                    </button>
                </li>
            </ul>
        </div>
    `;

        // Logique pour Agrandir/Réduire (inchangée)
        const expandButton = chatHeader.querySelector('.expand-btn');
        let isExpanded = false;
        expandButton.addEventListener('click', () => {
            isExpanded = !isExpanded;
            chatBox.classList.toggle('expanded', isExpanded);
            if (isExpanded) {
                expandButton.innerHTML = '<i class="ti ti-arrows-minimize"></i>';
                expandButton.title = 'Réduire';
            } else {
                expandButton.innerHTML = '<i class="ti ti-arrows-maximize"></i>';
                expandButton.title = 'Agrandir';
            }
        });

        // NOUVELLE LOGIQUE : Attacher l'événement au bouton de fermeture
        const closeButton = chatHeader.querySelector('.close-btn');
        if (closeButton) {
            closeButton.addEventListener('click', closeChat);
        }
    }
    createChatHeader();


    // --- ENVOI DE MESSAGE (entièrement mis à jour) ---
    async function sendMessage() {
        const message = userMessage.value.trim();
        if (!message) return;

        // 1. Afficher le message de l'utilisateur avec le nouveau design
        const userMsgDiv = document.createElement("div");
        userMsgDiv.className = "chats chats-right";
        userMsgDiv.innerHTML = `
            <div class="chat-content">
                <div class="chat-profile-name text-end">
                    <h6>Vous<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span></h6>
                </div>
                <div class="chat-info">
                    <div class="message-content">
                        ${sanitizeHTML(message)}
                    </div>
                </div>
            </div>
            <div class="chat-avatar">
                <img src="<?= asset('images/user.png') ?>" class="rounded-circle" alt="Utilisateur">
            </div>
        `;
        chatMessagesContainer.appendChild(userMsgDiv);
        soundSend.play().catch(e => {});
        userMessage.value = "";
        if (quickButtons) quickButtons.style.display = 'none'; // Cacher les boutons rapides
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // 2. Afficher l'indicateur "is typing"
        const typingDiv = document.createElement("div");
        typingDiv.className = "chats";
        typingDiv.id = "typing-indicator"; // Pour le retrouver facilement
        typingDiv.innerHTML = `
            <div class="chat-avatar">
                <img src="<?= asset('images/gabriel.jpeg') ?>" class="rounded-circle" alt="Gabriel">
            </div>
            <div class="chat-content">
                 <div class="chat-info">
                    <div class="message-content">
                        <span class="animate-typing">
                            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
                        </span>
                    </div>
                </div>
            </div>
        `;
        chatMessagesContainer.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        userMessage.disabled = true;
        sendBtn.disabled = true;

        // 3. Logique d'envoi (inchangée)
        const requestData = {
            sessionId: document.querySelector('meta[name="n8n-session-id"]').content,
            action: "sendMessage",
            chatInput: message
        };

        const maxAttempts = 3;
        let attempt = 1;

        async function sendWithRetry() {
            try {
                const res = await fetch(
                    "https://yodn8n.app.n8n.cloud/webhook/aef2708c-8929-4313-8c16-d383bbc828c3/chat", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(requestData)
                    }
                );

                if (!res.ok) {
                    if (attempt < maxAttempts) {
                        attempt++;
                        await new Promise(resolve => setTimeout(resolve, attempt * 1000));
                        return sendWithRetry();
                    } else {
                        throw new Error(`Erreur réseau (${res.status})`);
                    }
                }

                document.getElementById('typing-indicator')?.remove();

                let reponse = await res.text();
                reponse = reponse.trim() || "Désolé, une erreur est survenue. Veuillez réessayer.";

                // 4. Afficher la réponse du bot avec le nouveau design
                const botDiv = document.createElement("div");
                botDiv.className = "chats";
                botDiv.innerHTML = `
                    <div class="chat-avatar">
                        <img src="<?= asset('images/gabriel.jpeg') ?>" class="rounded-circle" alt="Gabriel">
                    </div>
                    <div class="chat-content">
                        <div class="chat-profile-name">
                            <h6>Gabriel<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span></h6>
                        </div>
                        <div class="chat-info">
                            <div class="message-content">
                                ${sanitizeHTML(reponse)}
                            </div>
                        </div>
                    </div>
                `;
                chatMessagesContainer.appendChild(botDiv);

                soundReceive.play().catch(() => {});
                userMessage.disabled = false;
                sendBtn.disabled = false;
                userMessage.focus();
                chatMessages.scrollTop = chatMessages.scrollHeight;

            } catch (error) {
                document.getElementById('typing-indicator')?.remove();
                const errorDiv = document.createElement("div");
                errorDiv.className = "chats";
                errorDiv.innerHTML = `
                    <div class="chat-content">
                        <div class="chat-info error-message">
                            <i class="ti ti-alert-triangle me-2"></i>
                            Une erreur est survenue. Veuillez réessayer plus tard.
                        </div>
                    </div>
                `;
                chatMessagesContainer.appendChild(errorDiv);
                userMessage.disabled = false;
                sendBtn.disabled = false;
                userMessage.focus();
            }
        }

        sendWithRetry();
    }

    function sanitizeHTML(str) {
        const temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML.replace(/\n/g, '<br>'); // Convertit les sauts de ligne en <br>
    }

    // --- GESTION DES ÉVÉNEMENTS (inchangé) ---
    userMessage.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !userMessage.disabled) {
            sendMessage();
        }
    });

    sendBtn.addEventListener('click', function() {
        if (!userMessage.disabled) {
            sendMessage();
        }
    });

    document.querySelectorAll('.quick-btn').forEach(button => {
        button.addEventListener('click', () => {
            userMessage.value = button.textContent;
            sendMessage();
            if (quickButtons) quickButtons.style.display = 'none';
        });
    });

    // --- LOGIQUE D'INACTIVITÉ ET BULLE D'AIDE (complète) ---
    let hintTimeout = null;
    let inactivityTimer = null;

    // Fonction qui affiche la mini bulle d'aide
    function showHintBubble() {
        // Ne rien faire si le chat est déjà ouvert
        if (!chatBox.classList.contains('hidden')) {
            scheduleNextHint(); // On reprogramme pour plus tard
            return;
        }

        // Ne pas afficher si une bulle d'aide est déjà visible
        if (document.querySelector('.chat-bubble-hint')) return;

        const hint = document.createElement("div");
        hint.className = "chat-bubble-hint animate__animated animate__fadeInUp animate__faster";
        hint.innerHTML = `
            <div style="
                background: white;
                color: #333;
                padding: 10px 16px;
                border-radius: 16px;
                font-size: 0.9rem;
                font-weight: 500;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                white-space: nowrap;
            ">
                Une question ? Je peux vous aider 👋
            </div>
        `;
        hint.style.cursor = "pointer";
        hint.style.position = "fixed";
        hint.style.bottom = "110px"; // Un peu au-dessus de la bulle principale
        hint.style.right = "100px";
        hint.style.zIndex = "10000";

        // Action au clic sur la bulle d'aide
        hint.addEventListener("click", () => {
            hint.remove(); // On la retire
            clearTimeout(hintTimeout); // On annule sa disparition automatique
            openChat(); // On ouvre le chat
            resetInactivityTimer(); // On réinitialise le cycle
        });

        document.body.appendChild(hint);

        // Supprimer la bulle d'aide après 15 secondes si elle est toujours là
        hintTimeout = setTimeout(() => {
            if (document.body.contains(hint)) {
                hint.classList.remove('animate__fadeInUp');
                hint.classList.add('animate__fadeOutDown');
                setTimeout(() => hint.remove(), 500); // Laisse le temps à l'animation de se jouer
            }
            scheduleNextHint(); // Planifie la prochaine apparition
        }, 15000);
    }

    // Planifie la prochaine apparition de la bulle après un délai d'inactivité
    function scheduleNextHint() {
        clearTimeout(inactivityTimer);
        // On attend 15 secondes d'inactivité avant de montrer la bulle
        inactivityTimer = setTimeout(showHintBubble, 15000);
    }

    // Réinitialise le timer sur une interaction utilisateur
    function resetInactivityTimer() {
        clearTimeout(inactivityTimer); // Annule le timer d'inactivité en cours
        clearTimeout(hintTimeout); // Annule la disparition programmée de la bulle

        // Supprime la bulle d'aide si elle est visible
        const existingHint = document.querySelector('.chat-bubble-hint');
        if (existingHint) {
            existingHint.remove();
        }

        scheduleNextHint(); // Relance un nouveau cycle de détection d'inactivité
    }
    ['mousemove', 'keydown', 'scroll', 'click'].forEach(evt => document.addEventListener(evt,
        resetInactivityTimer));
    resetInactivityTimer();
});
</script>