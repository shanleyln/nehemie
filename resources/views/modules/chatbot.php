<!-- pour les images il faut le dossier public/imageschatbot -->
<!-- il y a deja le bouton retour pour scroll est deja dedans -->

<!-- =================================================================
     NOUVELLE STRUCTURE HTML POUR LE BOUTON RETOUR EN HAUT
     ================================================================= -->
<button id="backToTop" aria-label="Retour en haut">
    <i class="fas fa-chevron-up"></i>
</button>

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
                        <img src="<?= asset('imageschatbot/gabriel.jpeg') ?>" class="rounded-circle" alt="Gabriel">
                    </div>
                    <div class="chat-content">
                        <div class="chat-profile-name">
                            <h6>Gabriel<i class="ti ti-circle-filled fs-7 mx-2"></i><span
                                    class="chat-time">Maintenant</span>
                            </h6>
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
                    <textarea id="user-message" class="form-control auto-expand" placeholder="Tapez votre message..."
                        rows="1" data-min-rows="1" data-max-rows="4"></textarea>
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
            <img id="chat-launcher-icon" src="<?= asset('imageschatbot/gabriel.jpeg') ?>" alt="Gabriel"
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
    console.log(url);
}

function initializeEvents() {
    /* ... Votre code inchangé ... */
    console.log('Events initialized');
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
                <img src="<?= asset('imageschatbot/gabriel.jpeg') ?>" class="rounded-circle" alt="Okoumé">
            </div>
            <div class="ms-2 overflow-hidden">
                <h6>Okoumé</h6>
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
                <img src="<?= asset('imageschatbot/user.png') ?>" class="rounded-circle" alt="Utilisateur">
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
                <img src="<?= asset('imageschatbot/gabriel.jpeg') ?>" class="rounded-circle" alt="Okoumé">
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
                console.log('1. Préparation de la requête avec les données:', requestData);

                // Vérifier si la session ID est présente
                const sessionId = document.querySelector('meta[name="n8n-session-id"]')?.content;
                console.log('2. Session ID récupéré:', sessionId || 'non trouvé');

                // Vérifier la connectivité réseau
                console.log('3. Vérification de la connectivité réseau...');
                const isOnline = await checkConnectivity();
                if (!isOnline) {
                    throw new Error('Aucune connexion Internet détectée');
                }

                console.log('4. Tentative de connexion au serveur...');
                const startTime = Date.now();

                // Essayer avec différentes options de requête
                const fetchOptions = {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(requestData),
                    mode: 'cors',
                    credentials: 'same-origin',
                    cache: 'no-cache',
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer'
                };

                console.log('Options de la requête:', fetchOptions);

                //*** */=========                    =========***
                //*** */========= LIEN DE LA REQUETE ==========**
                //*** */=========                    =========***

                const res = await fetch(
                    "LIEN_N8N_CHATBOT",
                    fetchOptions,
                ).catch(error => {
                    const endTime = Date.now();
                    console.error(`5. Erreur de connexion après ${endTime - startTime}ms:`,
                        error);
                    console.error('Détails de l\'erreur:', {
                        name: error.name,
                        message: error.message,
                        stack: error.stack,
                        type: error.type,
                        code: error.code
                    });
                    throw error;
                });

                console.log('Response status:', res.status);

                if (!res.ok) {
                    console.error(`5. Réponse du serveur non valide (${res.status}):`, res.statusText);
                    console.log('6. En-têtes de la réponse:', Object.fromEntries([...res.headers
                        .entries()
                    ]));

                    if (attempt < maxAttempts) {
                        attempt++;
                        console.log(
                            `7. Tentative ${attempt}/${maxAttempts} dans ${attempt} secondes...`);
                        await new Promise(resolve => setTimeout(resolve, attempt * 1000));
                        return sendWithRetry();
                    } else {
                        const errorText = await res.text().catch(() =>
                            'Impossible de lire le corps de la réponse');
                        console.error('8. Dernière tentative échouée. Réponse complète:', errorText);
                        throw new Error(`Erreur serveur (${res.status}): ${res.statusText}`);
                    }
                }

                document.getElementById('typing-indicator')?.remove();

                let reponse = '';
                try {
                    reponse = await res.text();
                    console.log('Raw response:', reponse);
                    reponse = reponse.trim() ||
                        "Désolé, je n'ai pas pu obtenir de réponse. Veuillez réessayer.";
                } catch (error) {
                    console.error('Error parsing response:', error);
                    reponse = "Désolé, une erreur est survenue lors du traitement de la réponse.";
                }

                // 4. Afficher la réponse du bot avec le nouveau design
                const botDiv = document.createElement("div");
                botDiv.className = "chats";
                botDiv.innerHTML = `
                    <div class="chat-avatar">
                        <img src="<?= asset('imageschatbot/gabriel.jpeg') ?>" class="rounded-circle" alt="Okoumé">
                    </div>
                    <div class="chat-content">
                        <div class="chat-profile-name">
                            <h6>Okoumé<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span></h6>
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
                            Désolé, le service de chat est temporairement indisponible. Notre équipe technique a été notifiée. Veuillez réessayer ultérieurement.
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

    // Vérifie la connectivité réseau
    async function checkConnectivity() {
        try {
            // Essayer de récupérer une ressource connue
            const response = await fetch('https://httpbin.org/get', {
                method: 'HEAD',
                cache: 'no-store',
                mode: 'no-cors'
            });
            return true;
        } catch (error) {
            console.error('Erreur de connectivité:', error);
            return false;
        }
    }

    function sanitizeHTML(str) {
        if (!str) return '';
        const temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML.replace(/\n/g, '<br>'); // Convertit les sauts de ligne en <br>
    }

    // --- GESTION DES ÉVÉNEMENTS ---
    userMessage.addEventListener('keydown', function(e) {
        // Envoyer le message uniquement avec Ctrl+Entrée ou Cmd+Entrée
        if (e.key === 'Enter' && !e.shiftKey) {
            if ((e.ctrlKey || e.metaKey) && !userMessage.disabled) {
                e.preventDefault();
                sendMessage();
            }
        }
        // Laisser le comportement par défaut pour Shift+Entrée (nouvelle ligne)
    });

    sendBtn.addEventListener('click', function() {
        if (!userMessage.disabled) {
            sendMessage();
        }
    });

    // Fonction d'auto-ajustement du textarea
    const autoExpand = (field) => {
        // Réinitialiser la hauteur pour obtenir la hauteur de défilement correcte
        field.style.height = 'auto';

        // Obtenir les valeurs min et max de lignes
        const minRows = parseInt(field.getAttribute('data-min-rows') || '1', 10);
        const maxRows = parseInt(field.getAttribute('data-max-rows') || '4', 10);

        // Calculer la hauteur
        const lineHeight = parseInt(window.getComputedStyle(field).lineHeight, 10);
        const paddingTop = parseInt(window.getComputedStyle(field).paddingTop, 10);
        const paddingBottom = parseInt(window.getComputedStyle(field).paddingBottom, 10);

        // Calculer les hauteurs min et max
        const minHeight = minRows * lineHeight + paddingTop + paddingBottom;
        const maxHeight = maxRows * lineHeight + paddingTop + paddingBottom;

        // Ajuster la hauteur
        field.style.overflowY = 'hidden';
        field.style.height = Math.min(Math.max(field.scrollHeight, minHeight), maxHeight) + 'px';

        // Activer le défilement si nécessaire
        field.style.overflowY = field.scrollHeight > maxHeight ? 'auto' : 'hidden';
    };

    // Appliquer l'auto-ajustement au textarea du chat
    if (userMessage) {
        // Appliquer l'ajustement lors de la frappe
        userMessage.addEventListener('input', function() {
            autoExpand(this);
        });

        // Appliquer l'ajustement au chargement initial
        autoExpand(userMessage);
    }

    document.querySelectorAll('.quick-btn').forEach(button => {
        button.addEventListener('click', () => {
            userMessage.value = button.textContent;
            autoExpand(userMessage); // Ajuster la hauteur après avoir défini la valeur
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

//debut Bouton retour en haut
const backToTopBtn = document.getElementById('backToTop');

window.addEventListener('scroll', function() {
    if (window.scrollY > 500) {
        backToTopBtn.classList.add('active');
    } else {
        backToTopBtn.classList.remove('active');
    }
});

backToTopBtn.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
});

// Animation au défilement
const animatedElements = document.querySelectorAll('[data-aos]');

function checkScroll() {
    const triggerBottom = window.innerHeight * 0.8;

    animatedElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;

        if (elementTop < triggerBottom) {
            element.classList.add('aos-animate');
        }
    });
}

window.addEventListener('scroll', checkScroll);
checkScroll(); // Vérifier au chargement initial
//fin bouton retour en haut
</script>