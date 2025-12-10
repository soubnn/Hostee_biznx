// -------------------- CONFIG --------------------
const CACHE_VERSION = 'v1.0.1';
const STATIC_CACHE = `static-${CACHE_VERSION}`;
const DYNAMIC_CACHE = `dynamic-${CACHE_VERSION}`;
const OFFLINE_PAGE = '/offline.html';

// -------------------- ASSETS TO CACHE --------------------
const ASSETS = [
    '/',
    '/offline.html',
    '/assets/css/app.min.css',
    '/assets/js/app.js',
];

// -------------------- INSTALL --------------------
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(STATIC_CACHE).then(cache =>
            Promise.all(
                ASSETS.map(url =>
                    cache.add(url).catch(err =>
                        console.warn('SW: Failed to cache:', url)
                    )
                )
            )
        )
    );

    self.skipWaiting();
});

// -------------------- ACTIVATE --------------------
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => key !== STATIC_CACHE && key !== DYNAMIC_CACHE)
                    .map(key => caches.delete(key))
            )
        )
    );

    self.clients.claim();
});

// -------------------- FETCH --------------------
self.addEventListener('fetch', event => {
    const req = event.request;
    const url = new URL(req.url);

    // ❌ EXCLUDE LOGIN / LOGOUT / AUTH ROUTES
    if (
        url.pathname.startsWith('/loginsubmit') ||
        url.pathname.startsWith('/login') ||
        url.pathname.startsWith('/logout')
    ) {
        return; // Do not touch these requests
    }

    // Only process GET requests
    if (req.method !== 'GET') return;

    // Only handle HTTP requests
    if (!req.url.startsWith('http')) return;


    // -------- NETWORK FIRST STRATEGY --------
    event.respondWith(
        fetch(req)
            .then(res => {
                // Clone response before caching
                const resClone = res.clone();

                // Cache only valid responses
                if (res.status === 200 && res.type === 'basic') {
                    caches.open(DYNAMIC_CACHE).then(cache => {
                        cache.put(req, resClone);
                    });
                }

                return res;
            })
            .catch(() => {
                // If offline → try cache
                return caches.match(req).then(cacheRes => {
                    return cacheRes || caches.match(OFFLINE_PAGE);
                });
            })
    );
});
