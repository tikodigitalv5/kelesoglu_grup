// Servis çalışanını yüklerken önbelleğe alınacak dosyaların listesi
const CACHE_NAME = 'my-pwa-cache-v1';
const urlsToCache = [
  'https://app.tikoportal.com.tr/custom/manifest.json',
];

// Kurulum aşamasında dosyaları önbelleğe alın
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Açılan önbellek');
        return cache.addAll(urlsToCache);
      })
  );
});

// Ağdan dosya isteği yapılırken önbellekten yükleyin
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Önbellekteki dosyayı döndür veya ağdan iste
        return response || fetch(event.request);
      })
  );
});