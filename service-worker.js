const swUrl = new URL(self.location.href);
const ASSET_VERSION = swUrl.searchParams.get("v") || "dev";
const ENCODED_ASSET_VERSION = encodeURIComponent(ASSET_VERSION);

const CACHE_NAME = `playflashcards-cache-v-${ASSET_VERSION}`;

const urlsToCache = [
  "assets/css/bootstrap-5.3.8.min.css",
  "assets/css/bootstrap-icons-1.13.1.min.css",
  `assets/css/styles.css?v=${ENCODED_ASSET_VERSION}`,
  "assets/js/bootstrap-5.3.8.bundle.min.js",
  `assets/js/main.js?v=${ENCODED_ASSET_VERSION}`,
  "assets/img/playflashcards-logo.png",
  "assets/img/favicon.png"
];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
  self.skipWaiting();
});

self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
    )
  );
  self.clients.claim();
});

self.addEventListener("fetch", event => {
  if (event.request.method !== "GET") {
    return;
  }

  const requestUrl = new URL(event.request.url);
  const isHttpRequest = requestUrl.protocol === "http:" || requestUrl.protocol === "https:";
  const isSameOrigin = requestUrl.origin === self.location.origin;

  if (!isHttpRequest || !isSameOrigin) {
    return;
  }

  if (event.request.mode === "navigate") {
    event.respondWith(
      fetch(event.request)
        .then(response => {
          const responseClone = response.clone();
          caches.open(CACHE_NAME)
            .then(cache => cache.put(event.request, responseClone))
            .catch(() => {});
          return response;
        })
        .catch(() => caches.match(event.request))
    );
    return;
  }

  const staticDestinations = new Set(["style", "script", "image", "font"]);
  const isStaticAsset = staticDestinations.has(event.request.destination);

  if (isStaticAsset) {
    event.respondWith(
      caches.match(event.request).then(cached => {
        if (cached) {
          return cached;
        }
        return fetch(event.request).then(response => {
          const responseClone = response.clone();
          caches.open(CACHE_NAME)
            .then(cache => cache.put(event.request, responseClone))
            .catch(() => {});
          return response;
        });
      })
    );
  }
});
