// public/pvit/sw.js
self.addEventListener('install', (event) => {
  // Installe immédiatement
  self.skipWaiting();
});
self.addEventListener('activate', (event) => {
  // Prend le contrôle des pages ouvertes
  event.waitUntil(self.clients.claim());
});
// Pas de handler "fetch" => on laisse passer toutes les requêtes
