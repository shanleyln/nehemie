// Service Worker Register
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('service-worker.js')
            .then(registration => {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            })
            .catch(err => {
                console.log('ServiceWorker registration failed: ', err);
            });
    });
}

// PWA Installation Handling
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
});

document.addEventListener("DOMContentLoaded", function () {
    const installButton = document.getElementById('installAffan');
    const installWrap = document.getElementById('installWrap');

    if (installButton && installWrap) {
        function updateInstallButton() {
            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                installButton.textContent = 'Installe';
                installWrap.style.display = 'none';
            } else {
                installButton.textContent = 'Installer maintenant';
                installWrap.style.display = 'block';
            }
        }

        installButton.addEventListener('click', async () => {
            if (installButton.textContent === 'Installe') return;

            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;

                if (outcome === 'accepted') {
                    installButton.textContent = 'Installe';
                    installWrap.style.display = 'none';
                } else {
                    installButton.textContent = 'Installer maintenant';
                }
                deferredPrompt = null;
            }
        });

        updateInstallButton();
        window.matchMedia('(display-mode: standalone)').addEventListener('change', updateInstallButton);
    }
});