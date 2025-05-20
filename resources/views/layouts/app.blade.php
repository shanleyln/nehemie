<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="n8n-session-id" content="{{ \Illuminate\Support\Facades\Session::getId() }}">
    <title>@yield('title')</title>

    {{-- icone du site --}}
    <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/x-icon">

    <!-- FontAwesome 6 (dernier CDN officiel) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.6.8/plyr.polyfilled.js"></script>


    <!-- Google Fonts (Garde seulement celles utilisées) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Ajout du CDN pour animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
</head>

<!-- Overlay de préchargement -->
<div id="preloader">
    <div class="loader">
        <div class="loader-inner"></div>
    </div>
    <div class="loader-text">NÉHÉMIE International</div>
</div>

<!-- En-tête et navigation -->
<header class="header" id="header">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="#accueil">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo NÉHÉMIE International">
                    <span>NÉHÉMIE International</span>
                </a>
            </div>

            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="#accueil" class="nav-link active">Accueil</a></li>
                    <li class="dropdown">
                        <a href="#qui-sommes-nous" class="nav-link">Qui sommes-nous <i
                                class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#notre-histoire">Notre Histoire</a></li>
                            <li><a href="#vision-mission">Vision & Mission</a></li>
                            <li><a href="#nos-valeurs">Nos Valeurs</a></li>
                            <li><a href="#notre-equipe">Notre Équipe</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#nos-programmes" class="nav-link">Nos programmes <i
                                class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#programme-timothee">TIMOTHÉE</a></li>
                            <li><a href="#programme-philippe">PHILIPPE</a></li>
                            <li><a href="#programme-dorcas">DORCAS</a></li>
                            <li><a href="#programme-bethanie">BÉTHANIE</a></li>
                            <li><a href="#programme-daniel">DANIEL</a></li>
                        </ul>
                    </li>
                    <li><a href="#actualites" class="nav-link">Actualités</a></li>
                    <li><a href="#temoignages" class="nav-link">Témoignages</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="#faire-un-don" class="btn btn-primary">Faire un don</a>
                <button class="menu-toggle" aria-label="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Menu mobile -->
<div class="mobile-menu">
    <div class="container">
        <ul class="mobile-nav-list">
            <li><a href="#accueil" class="mobile-nav-link">Accueil</a></li>
            <li class="mobile-dropdown">
                <a href="#qui-sommes-nous" class="mobile-nav-link">Qui sommes-nous <i
                        class="fas fa-chevron-down"></i></a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="#notre-histoire">Notre Histoire</a></li>
                    <li><a href="#vision-mission">Vision & Mission</a></li>
                    <li><a href="#nos-valeurs">Nos Valeurs</a></li>
                    <li><a href="#notre-equipe">Notre Équipe</a></li>
                </ul>
            </li>
            <li class="mobile-dropdown">
                <a href="#nos-programmes" class="mobile-nav-link">Nos programmes <i class="fas fa-chevron-down"></i></a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="#programme-timothee">TIMOTHÉE</a></li>
                    <li><a href="#programme-philippe">PHILIPPE</a></li>
                    <li><a href="#programme-dorcas">DORCAS</a></li>
                    <li><a href="#programme-bethanie">BÉTHANIE</a></li>
                    <li><a href="#programme-daniel">DANIEL</a></li>
                </ul>
            </li>
            <li><a href="#actualites" class="mobile-nav-link">Actualités</a></li>
            <li><a href="#temoignages" class="mobile-nav-link">Témoignages</a></li>
            <li><a href="#contact" class="mobile-nav-link">Contact</a></li>
            <li><a href="#faire-un-don" class="btn btn-primary mobile-btn">Faire un don</a></li>
        </ul>
    </div>
</div>



<body>
    <div style="padding-top: 65px;">
        <div id="main-content">
            @yield('content')
        </div>
    </div>
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

                {{-- 🤖 Message d’accueil --}}
                <div class="bot-message" style="display: flex; align-items: start; gap: 10px;">
                    <img src="{{ asset('images/clement.jpg') }}" alt="Logo OGAR"
                        class="chat-logo  w-8 h-8 rounded-full" style="width: 32px; height: 32px;">
                    <span>Bienvenue, je m'appelle Okoumé. Comment puis-je vous aider aujourd'hui ?</span>
                </div>
                <!-- Boutons rapides -->
                <div id="quick-buttons" class="flex flex-wrap gap-2 mt-2 mb-2">
                    <button class="quick-btn">Je veux souscrire une assurance 📝</button>
                    <button class="quick-btn">J'ai besoin de souscrire à une assurance auto 🚗</button>
                    <button class="quick-btn">Je veux modifier mon contrat 📋</button>
                    <button class="quick-btn">J'ai une question sur mon devis 💬</button>
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
                <img id="chat-launcher-icon" src="{{ asset('images/clement.jpg') }}" alt="Clément"
                    class="chat-icon-image">
            </div>
        </div>


        <!-- Bouton de remontée -->
        <button type="button" class="btn-scroll-top" id="scrollToTop">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
    <audio id="sound-open" src="{{ asset('sounds/open.mp3') }}"></audio>
    <audio id="sound-close" src="{{ asset('sounds/close.mp3') }}"></audio>
    <audio id="sound-receive" src="{{ asset('sounds/message-received.mp3') }}"></audio>
    <audio id="sound-send" src="{{ asset('sounds/message-sent.mp3') }}"></audio>
    <audio id="sound-hint" src="{{ asset('sounds/hint-popup.mp3') }}"></audio>



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
                chatLauncherIcon.src = "{{ asset('images/close-icon.png') }}";
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
                chatLauncherIcon.src = "{{ asset('images/clement.jpg') }}";
                chatLauncherIcon.alt = "Clément";
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
                      <img src="{{ asset('images/clement.jpg') }}" 
                          alt="Logo OGAR" 
                          class="chat-logo rounded-full" 
                          style="width: 48px; height: 48px; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

                       <!-- ✅ Point vert en ligne -->
                       <span style="position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; background-color: #4CAF50; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);"></span>
                  </div>
              </div>
              <div class="col-lg-9">
                  <span class="chat-title font-semibold">Okoumé</span>
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
                    `<img src="{{ asset('images/user.jpg') }}" alt="Utilisateur" class="chat-logo w-8 h-8 rounded-full" style="width: 32px; height: 32px;"><span>${message}</span>`;
                chatMessages.appendChild(msgDiv);
                soundSend.play().catch(e => {});
                userMessage.value = "";

                // Afficher les 3 points
                const typingDiv = document.createElement("div");
                typingDiv.className = "typing-indicator";
                typingDiv.innerHTML = `
               <img src="{{ asset('images/clement.jpg') }}" 
                    alt="Logo OGAR" 
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
                            "https://yodn8n.app.n8n.cloud/webhook/bce52481-c326-432a-b1c2-3f17665d218d/chat", {
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
                                <img src="{{ asset('images/clement.jpg') }}" alt="Okoumé" class="chat-logo w-8 h-8 rounded-full" style="width: 32px; height: 32px;">
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
            background: #f68b1e;
            color: white;
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
                hint.style.bottom = "80px";
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


    {{-- script --}}
    <!-- Bouton retour en haut -->
    <button id="backToTop" aria-label="Retour en haut">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Scripts -->
    <script src="js/main.js"></script>
    <!-- jQuery (important avant Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>


<!-- Pied de page -->
<footer class="footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-logo">
                <img src="https://nehemie-international.com/wp-content/uploads/2024/01/LOGO-NEHEMIE-carre-e1704837809114.png"
                    alt="Logo NÉHÉMIE International">
                <h3>NÉHÉMIE International</h3>
                <p>"Levons-nous et bâtissons!"</p>
            </div>

            <div class="footer-links">
                <div class="footer-links-column">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#accueil">Accueil</a></li>
                        <li><a href="#qui-sommes-nous">Qui sommes-nous</a></li>
                        <li><a href="#nos-programmes">Nos programmes</a></li>
                        <li><a href="#actualites">Actualités</a></li>
                        <li><a href="#temoignages">Témoignages</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-links-column">
                    <h4>Nos programmes</h4>
                    <ul>
                        <li><a href="#programme-timothee">TIMOTHÉE</a></li>
                        <li><a href="#programme-philippe">PHILIPPE</a></li>
                        <li><a href="#programme-dorcas">DORCAS</a></li>
                        <li><a href="#programme-bethanie">BÉTHANIE</a></li>
                        <li><a href="#programme-daniel">DANIEL</a></li>
                    </ul>
                </div>

                <div class="footer-links-column">
                    <h4>Légal</h4>
                    <ul>
                        <li><a href="#">Mentions légales</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Conditions d'utilisation</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 NÉHÉMIE International. Tous droits réservés.</p>
            <div class="footer-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>


</html>
