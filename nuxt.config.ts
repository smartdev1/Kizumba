// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: false },
  modules: ["@nuxtjs/tailwindcss", "@pinia/nuxt"],
  css: ["~/assets/css/main.css"],

  // ── Runtime Config ──────────────────────────────────────────────────────────
  runtimeConfig: {
    // ✅ Clés PRIVÉES — disponibles uniquement côté serveur (server/api/)
    // Ne jamais mettre des secrets ici dans public{}
    wpApiUrl:
      process.env.NUXT_PUBLIC_WP_API_URL || "http://dance-school.test/wp-json",
    flutterwaveSecretKey: process.env.FLUTTERWAVE_SECRET_KEY || "",
    flutterwaveWebhookHash: process.env.FLUTTERWAVE_WEBHOOK_HASH || "",
    eventflowWebhookSecret: process.env.EVENTFLOW_WEBHOOK_SECRET || "",

    paydunya_mode: process.env.PAYDUNYA_MODE || "test",
    paydunya_master_key: process.env.PAYDUNYA_MASTER_KEY || "",
    paydunya_private_key: process.env.PAYDUNYA_PRIVATE_KEY || "",
    paydunya_token: process.env.PAYDUNYA_TOKEN || "",

    // ✅ Clés PUBLIQUES — accessibles côté client ET serveur via config.public.*
    public: {
      wpApiUrl:
        process.env.NUXT_PUBLIC_WP_API_URL ||
        "http://dance-school.test/wp-json",
      wcConsumerKey: process.env.NUXT_PUBLIC_WC_CONSUMER_KEY || "",
      wcConsumerSecret: process.env.NUXT_PUBLIC_WC_CONSUMER_SECRET || "",
      wpToken: process.env.JWT_AUTH_SECRET_KEY || "",
      flutterwavePublicKey:
        process.env.NUXT_PUBLIC_FLUTTERWAVE_PUBLIC_KEY || "",
    },
  },

  // ── Fix Windows / Laragon ───────────────────────────────────────────────────
  devServer: {
    host: "127.0.0.1",
    port: 3000,
  },

  vite: {
    server: {
      host: "127.0.0.1",
      strictPort: true,
      hmr: {
        protocol: "ws",
        host: "127.0.0.1",
        port: 3000,
      },
      watch: {
        usePolling: true,
        interval: 300,
        ignored: [
          "**/wp-admin/**",
          "**/wp-includes/**",
          "**/wp-content/themes/**",
          "**/wp-content/uploads/**",
          "**/wp-content/plugins/!(eventflow)/**",
          "**/node_modules/**",
          "**/.git/**",
        ],
      },
    },
  },

  // ── App Head ─────────────────────────────────────────────────────────────────
  app: {
    head: {
      title: "PARIS KIZOMBA CONGRESS - PKC Festival Kizomba à PARIS",
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        {
          name: "description",
          content:
            "Plongez dans l'univers vibrant de la kizomba au Paris Kizomba Congress. Découvrez nos stages de danse de renommée internationale.",
        },
      ],
      link: [{ rel: "icon", type: "image/png", href: "/favicon.png" }],
    },
  },
});
