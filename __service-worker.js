// Version
var VERSION = '2.8';

// Cache name
var CACHE_NAME = 'cache-version-' + VERSION;

// Files
var REQUIRED_FILES = [
  '/index.php',
  '/assets/css/style.css',
  '/assets/js/base.js',
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        return cache.addAll(REQUIRED_FILES);
      })
      .then(function() {
        return self.skipWaiting();
      })
      .catch(function(error) {
        console.error('Failed to cache:', error);
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response; // Retorna do cache
        }
        return fetch(event.request); // Tenta buscar da rede
      })
      .catch(function(error) {
        console.error('Failed to fetch from cache or network:', error);
        return caches.match('/logout.php'); // Fallback para uma página offline, se disponível
      })
  );
});

self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName);
          }
        })
      );
    }).then(function() {
      return self.clients.claim();
    })
  );
});
