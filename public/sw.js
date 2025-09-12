// Service Worker basique
self.addEventListener('install', event => {
    console.log('Service Worker installé');
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    console.log('Service Worker activé');
});

self.addEventListener('fetch', event => {
    // Laisser passer toutes les requêtes
    return;
});
