/**
 * PM2 Ecosystem — United Kizdom World Congress
 * ─────────────────────────────────────────────
 * Gère deux processus en production sur le serveur LWS :
 *   1. ukwc-nuxt    — Frontend Nuxt 4 (port 3000)
 *   2. ukwc-laravel — Backend Laravel (port 8000, localhost uniquement)
 *
 * Commandes utiles :
 *   pm2 start ecosystem.config.cjs --env production   ← premier démarrage
 *   pm2 reload ecosystem.config.cjs --env production  ← redémarrage sans downtime
 *   pm2 save                                           ← sauvegarder pour redémarrage auto
 *   pm2 startup                                        ← lancer PM2 au boot du serveur
 *   pm2 logs                                           ← voir les logs en temps réel
 *   pm2 monit                                          ← dashboard de monitoring
 */

const path = require('path')

// Répertoire racine du projet (là où ce fichier se trouve)
const ROOT = __dirname

module.exports = {
  apps: [

    // ── 1. Frontend — Nuxt 4 ───────────────────────────────────────────────────
    {
      name: 'ukwc-nuxt',

      // Lance le serveur Nitro (généré par "npm run build")
      script: path.join(ROOT, '.output/server/index.mjs'),
      cwd: ROOT,

      instances: 1,
      exec_mode: 'fork',
      autorestart: true,
      watch: false,
      max_memory_restart: '512M',

      // Variables d'environnement de production
      // (remplacées par le .env au démarrage via dotenv ou directement ici)
      env_production: {
        NODE_ENV: 'production',

        // Ces vars correspondent à celles du .env frontend (root)
        // PM2 charge automatiquement le .env si vous utilisez "--env production"
        // Mais elles sont aussi surchargeable ici en fallback :
        NITRO_HOST: '127.0.0.1',
        NITRO_PORT: 3000,
      },
    },

    // ── 2. Backend — Laravel (PHP) ─────────────────────────────────────────────
    {
      name: 'ukwc-laravel',

      // php artisan serve — suffisant pour LWS VPS
      // Pour un trafic plus élevé : passer à php-fpm + nginx (voir nginx.conf.example)
      script: 'artisan',
      args: 'serve --host=127.0.0.1 --port=8000',
      interpreter: 'php',        // s'assurer que "php" est bien dans le PATH du serveur
      cwd: path.join(ROOT, 'backend'),

      instances: 1,
      exec_mode: 'fork',
      autorestart: true,
      watch: false,
      max_memory_restart: '256M',

      env_production: {
        APP_ENV: 'production',
      },
    },

  ],
}
