<script>
// Configuration de l'historique de navigation
let history = [];
let currentUrl = window.location.pathname;

// Fonction pour charger une page via AJAX
async function loadPage(url) {
    try {
        const response = await fetch(url);
        const html = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Mettre à jour le contenu principal
        const newContent = doc.getElementById('main-content').innerHTML;
        document.getElementById('main-content').innerHTML = newContent;

        // Mettre à jour le titre
        document.title = doc.title;

        // Mettre à jour l'historique
        history.push({
            url: url
        });
        window.history.pushState({}, '', url);

        // Réinitialiser les événements
        initializeEvents();
    } catch (error) {
        console.error('Erreur lors du chargement de la page:', error);
    }
}

// Fonction pour initialiser les événements
function initializeEvents() {
    // Gérer les clics sur les liens
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('/')) {
                e.preventDefault();
                loadPage(href);
            }
        });
    });

    // Gérer le retour en arrière/avant
    window.addEventListener('popstate', function() {
        if (history.length > 1) {
            history.pop();
            loadPage(history[history.length - 1].url);
        }
    });
}

// Initialiser les événements
initializeEvents();
</script>
<!-- Conteneur des éléments flottants -->
<div id="chat-floating-container">
    <!-- Chat Box -->
    <div id="chat-box" class="chat-container hidden">
        <div id="chat-header" class="chat-header"></div>

        <div id="chat-messages" class="chat-messages">
            <!-- Messages seront insérés ici -->

            <!-- 🤖 Message d’accueil -->
            <div class="bot-message" style="display: flex; align-items: start; gap: 10px;">
                <img src="<?= asset('images/gabriel.jpeg') ?>" alt="Gabriel" class="chat-logo w-8 h-8 rounded-full"
                    style="width: 32px; height: 32px;">
                <span>Bienvenue, je suis Gabriel. Comment puis-je vous aider aujourd'hui ?</span>
            </div>
            <!-- Boutons rapides -->
            <div id="quick-buttons" class="flex flex-wrap gap-2 mt-2 mb-2">
                <button class="quick-btn">Découvrir notre mission</button>
                <button class="quick-btn">Découvrir nos programmes</button>
                <button class="quick-btn">Actualités</button>
                <button class="quick-btn">Témoignages</button>
                <button class="quick-btn">Contact</button>
            </div>
        </div>

        <div id="chat-input" class="chat-input">
            <input id="user-message" type="text" placeholder="Tapez votre message...">
            <button class="send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>



    <!-- Bulle flottante -->
    <div id="chat-launcher" class="chat-bubble">
        <div class="chat-bubble-content">
            <img id="chat-launcher-icon" src="<?= asset('images/gabriel.jpeg') ?>" alt="Gabriel"
                class="chat-icon-image">
        </div>
    </div>


    <!-- Bouton de remontée -->
    <button type="button" class="btn-scroll-top" id="scrollToTop">
        <i class="fas fa-arrow-up"></i>
    </button>
</div>
<audio id="sound-open" src="<?= asset('sounds/open.mp3') ?>"></audio>
<audio id="sound-close" src="<?= asset('sounds/close.mp3') ?>"></audio>
<audio id="sound-receive" src="<?= asset('sounds/message-received.mp3') ?>"></audio>
<audio id="sound-send" src="<?= asset('sounds/message-sent.mp3') ?>"></audio>
<audio id="sound-hint" src="<?= asset('sounds/hint-popup.mp3') ?>"></audio>



<script>
document.addEventListener('DOMContentLoaded', function() {

    const soundOpen = document.getElementById('sound-open');
    const soundClose = document.getElementById('sound-close');
    const soundReceive = document.getElementById('sound-receive');
    const soundSend = document.getElementById('sound-send');
    // const soundHint = document.getElementById('sound-hint');



    // 🌐 Références uniques
    const chatLauncher = document.getElementById('chat-launcher');
    const chatLauncherIcon = document.getElementById('chat-launcher-icon');
    const chatBox = document.getElementById('chat-box');
    const chatHeader = document.getElementById('chat-header');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const userMessage = document.getElementById('user-message');
    const quickButtons = document.getElementById('quick-buttons');
    const sendBtn = document.querySelector('#chat-input .send-btn');


    if (!chatLauncher || !chatBox || !chatHeader || !chatMessages || !chatInput || !userMessage) {
        console.error('Erreur: Un ou plusieurs éléments du chat sont manquants');
        return;
    }

    // 💬 Animation d'entrée
    chatBox.classList.add('animate__animated', 'animate__faster');

    // 🚪 Ouvrir le chat
    function openChat() {
        soundOpen.play().catch(e => {}); // évite l’erreur sur autoplay bloqué

        if (!chatBox.classList.contains('hidden')) return;
        chatBox.classList.remove('animate__slideOutRight', 'hidden');
        chatBox.classList.add('animate__slideInRight');
        chatInput.style.display = 'flex';
        userMessage.focus();

        // 🔄 Changer image vers icône "fermer"
        chatLauncherIcon.src = "<?= asset('images/close_icone.png') ?>";
        chatLauncherIcon.alt = "Fermer";
    }


    // ❌ Fermer le chat
    function closeChat() {
        soundClose.play().catch(e => {});

        if (chatBox.classList.contains('hidden')) return;
        chatBox.classList.remove('animate__slideInRight');
        chatBox.classList.add('animate__slideOutRight');
        setTimeout(() => {
            chatBox.classList.add('hidden');
            chatInput.style.display = 'none';
        }, 500);

        // 🔄 Revenir à l’image de Clément
        chatLauncherIcon.src = "<?= asset('images/gabriel.jpeg') ?>";
        chatLauncherIcon.alt = "Gabriel";
    }



    // 🎯 Clic sur la bulle flottante
    chatLauncher.addEventListener('click', function() {
        if (chatBox.classList.contains('hidden')) {
            openChat();
        } else {
            closeChat();
        }
    });

    // 🧠 Titre/logo dans l'en-tête
    const chatInfo = document.createElement('div');
    chatInfo.className = 'chat-info';
    chatInfo.innerHTML = `
             <div class="row items-center">
              <div class="col-lg-3">
                  <div style="position: relative; display: inline-block;">
                      <img src="<?= asset('images/gabriel.jpeg') ?>" 
                          alt="Gabriel" 
                          class="chat-logo rounded-full" 
                          style="width: 100px; height: 50px; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

                       <!-- ✅ Point vert en ligne -->
                       <span style="position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; background-color: #4CAF50; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);"></span>
                  </div>
              </div>
              <div class="col-lg-9">
                  <span class="chat-title font-semibold">Gabriel</span>
                  <br>
                  <span class="text-gray-500 text-sm ">Conseiller virtuel</span>
              </div>
             </div>
         `;
    chatHeader.appendChild(chatInfo);

    // 🔳 Bouton agrandir/réduire
    const expandButton = document.createElement('button');
    expandButton.className = 'expand-btn';
    expandButton.innerHTML = '<i class="fas fa-expand-alt"></i>';
    chatHeader.appendChild(expandButton);

    let isExpanded = false;
    expandButton.addEventListener('click', () => {
        isExpanded = !isExpanded;
        if (isExpanded) {
            chatBox.style.width = '80%';
            chatBox.style.height = '530px';
            // chatBox.style.maxHeight = '800px';
            chatBox.style.borderRadius = '5px';
            expandButton.innerHTML = '<i class="fas fa-compress-alt"></i>';
        } else {
            chatBox.style.width = '400px';
            // chatBox.style.maxHeight = '800px';
            chatBox.style.height = '530px';
            chatBox.style.borderRadius = '5px';
            expandButton.innerHTML = '<i class="fas fa-expand-alt"></i>';
        }
    });



    // ✉️ Envoi du message utilisateur
    async function sendMessage() {
        const message = userMessage.value.trim();
        if (!message) return;

        // Afficher le message utilisateur
        const msgDiv = document.createElement("div");
        msgDiv.className = "user-message";
        msgDiv.innerHTML =
            `<img src="<?= asset('images/user.png') ?>" alt="Utilisateur" class="chat-logo w-8 h-8 rounded-full" style="width: 32px; height: 32px;"><span>${message}</span>`;
        chatMessages.appendChild(msgDiv);
        soundSend.play().catch(e => {});
        userMessage.value = "";

        // Afficher les 3 points
        const typingDiv = document.createElement("div");
        typingDiv.className = "typing-indicator";
        typingDiv.innerHTML = `
               <img src="<?= asset('images/gabriel.jpeg') ?>" 
                    alt="Gabriel" 
                    class="chat-logo w-8 h-8 rounded-full" 
                    style="width: 32px; height: 32px;">
               <span class="typing-container">
                   <span></span>
                   <span></span>
                   <span></span>
               </span>
                `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        userMessage.disabled = true;

        // const userId = localStorage.getItem("ogar_uid") || `user_${Date.now()}`;
        // localStorage.setItem("ogar_uid", userId);
        const requestData = {
            sessionId: document.querySelector('meta[name="n8n-session-id"]').content,
            // sessionId: userId, // ton identifiant utilisateur
            action: "sendMessage", // action attendue
            chatInput: message // le message de l'utilisateur
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
                    const errorDetails = await res.text();
                    if (attempt < maxAttempts) {
                        attempt++;
                        await new Promise(resolve => setTimeout(resolve, attempt * 1000));
                        return sendWithRetry();
                    } else {
                        throw new Error(`Erreur réseau (${res.status}): ${errorDetails}`);
                    }
                }

                typingDiv.remove();

                // 🔁 Récupère une réponse TEXTUELLE brute (pas JSON)
                let reponse = await res.text();

                // 🧽 Nettoyer la réponse (trim + fallback)
                reponse = reponse.trim();
                if (!reponse) {
                    reponse = "Désolé, je n’ai pas compris. Pouvez-vous reformuler ?";
                }

                // 📦 Créer le message du bot
                const botDiv = document.createElement("div");
                botDiv.className = "bot-message";
                botDiv.innerHTML = `
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <img src="<?= asset('images/gabriel.jpeg') ?>" alt="Gabriel" class="chat-logo w-8 h-8 rounded-full" style="width: 32px; height: 32px;">
                                <span>${sanitizeHTML(reponse)}</span>
                            </div>
                        `;
                chatMessages.appendChild(botDiv);

                soundReceive.play().catch(() => {});
                userMessage.disabled = false;
                userMessage.focus();
                chatMessages.scrollTop = chatMessages.scrollHeight;


            } catch (error) {
                typingDiv.remove();
                const errorDiv = document.createElement("div");
                errorDiv.className = "error-message";
                errorDiv.innerHTML = `
                           <div class="error-message-content">
                               <i class="fas fa-exclamation-triangle"></i>
                               <p>Une erreur est survenue : ${error.message}</p>
                           </div>`;
                chatMessages.appendChild(errorDiv);
                setTimeout(() => {
                    userMessage.disabled = false;
                    userMessage.focus();
                }, 3000);
            }
        }


        sendWithRetry();

        function sanitizeHTML(str) {
            const temp = document.createElement('div');
            temp.textContent = str;
            return temp.innerHTML;
        }

    }

    // 🔄 Envoi par Entrée
    userMessage.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !userMessage.disabled) {
            sendMessage();
        }
    });

    // 📤 Envoi par clic
    sendBtn.addEventListener('click', function() {
        if (!userMessage.disabled) {
            sendMessage();
        }
    });

    // // 🤖 Message d’accueil
    // const initialMessages = [
    //     'Bienvenue, je m\'appelle Clément. Comment puis-je vous aider aujourd\'hui ?'
    // ];

    // initialMessages.forEach(msg => {
    //     const botDiv = document.createElement("div");
    //     botDiv.className = "bot-message";
    //     botDiv.innerHTML =
    //         ` <div  style="display: flex; align-items: start; gap: 10px;">
    //           <img src="{{ asset('images/clement.jpg') }}" alt="Logo OGAR" class="chat-logo  w-8 h-8 rounded-full" style="width: 32px; height: 32px;">
    //           <span>${msg}</span> 
    //           </div>`;
    //     chatMessages.appendChild(botDiv);
    // });
    // ⚡ Boutons rapides
    document.querySelectorAll('.quick-btn').forEach(button => {
        button.addEventListener('click', () => {
            userMessage.value = button.textContent;
            sendBtn.click();
            quickButtons.style.display = 'none';
        });
    });
    let hintTimeout = null;
    let inactivityTimer = null;

    // Fonction qui affiche la mini bulle
    function showHintBubble() {
        if (!chatBox.classList.contains('hidden')) {
            scheduleNextHint(); // 🔁 Même si le chat est ouvert, on programme la suite
            return;
        }

        // Ne pas afficher si déjà présente
        if (document.querySelector('.chat-bubble-hint')) return;

        const hint = document.createElement("div");
        hint.className = "chat-bubble-hint";
        hint.innerHTML = `
        <div style="
            background: white;
            color: #5D4037;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            white-space: nowrap;
        ">
            Une question ? Je peux vous aider 👋
        </div>
    `;
        hint.style.cursor = "pointer";
        hint.style.position = "fixed";
        hint.style.bottom = "100px";
        hint.style.right = "90px";
        hint.style.zIndex = "10000";

        // ▶️ Lecture son + action au clic
        // soundHint.play().catch(e => {});
        hint.addEventListener("click", () => {
            openChat();
            // soundHint.play().catch(e => {});
            hint.remove();
            clearTimeout(hintTimeout);
            resetInactivityTimer(); // Redémarre la boucle après clic
        });

        document.body.appendChild(hint);

        // ⏱ Supprimer après 15 secondes
        hintTimeout = setTimeout(() => {
            if (document.body.contains(hint) && chatBox.classList.contains('hidden')) {
                hint.remove();
            }
            scheduleNextHint(); // 🔁 Planifie la prochaine apparition
        }, 15000);
    }

    // 🔁 Planifie la prochaine apparition après délai d’inactivité
    function scheduleNextHint() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(() => {
            showHintBubble();
        }, 15000); // 🔄 Toutes les 15s sans interaction
    }

    // 🔄 Réinitialise le timer sur interaction utilisateur
    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        clearTimeout(hintTimeout);

        // Supprime la bulle si visible
        const existingHint = document.querySelector('.chat-bubble-hint');
        if (existingHint) existingHint.remove();

        scheduleNextHint();
    }

    // 👂 Détecte toute interaction utilisateur
    ['mousemove', 'keydown', 'scroll', 'click'].forEach(evt => {
        document.addEventListener(evt, resetInactivityTimer);
    });

    // ⏱ Démarrage initial
    resetInactivityTimer();



});
</script>