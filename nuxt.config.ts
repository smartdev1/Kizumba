// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: false },
  modules: ["@nuxtjs/tailwindcss", "@pinia/nuxt"],
  css: ["~/assets/css/main.css"],

  // ── Génération statique (hébergement mutualisé) ──────────────────────────────
  // Décommentez pour le build de production :
  // nitro: { preset: "static" },

  // ── Runtime Config ──────────────────────────────────────────────────────────
  runtimeConfig: {
    // Côté serveur uniquement (non exposé au navigateur)
    apiBackendUrl: 'http://localhost:8000/api',
    public: {
      // /api-proxy → server/routes/api-proxy/[...path].ts → Laravel
      apiBaseUrl: '/api-proxy',
    },
  },

  // ── Fix Windows / WSL dev ───────────────────────────────────────────────────
  devServer: {
    host: "127.0.0.1",
    port: 3000,
  },

  // ── Security Headers ─────────────────────────────────────────────────────────
  routeRules: {
    '/**': {
      headers: {
        'X-Frame-Options': 'DENY',
        'X-Content-Type-Options': 'nosniff',
        'Referrer-Policy': 'strict-origin-when-cross-origin',
        'Permissions-Policy': 'camera=(), microphone=(), geolocation=()',
        'Content-Security-Policy': [
          "default-src 'self'",
          "script-src 'self' 'unsafe-inline'",
          "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
          "font-src 'self' https://fonts.gstatic.com",
          "img-src 'self' data: blob: http: https:",
          "connect-src 'self' https://app.paydunya.com",
          "frame-ancestors 'none'",
        ].join('; '),
      },
    },
  },

  // ── App Head ─────────────────────────────────────────────────────────────────
  app: {
    head: {
      title: "UNITED KIZDOM WOLRD CONGRESS - UKWC Festival Kizomba au Bénin",
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        {
          name: "description",
          content:
            "Plongez dans l'univers vibrant de la kizomba au United Kizdom World Congress. Découvrez nos stages de danse de renommée internationale.",
        },
      ],
      link: [{ rel: "icon", type: "image/png", href: "/favicon.png" }],
    },
  },
});
