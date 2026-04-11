#!/usr/bin/env bash
# ==============================================================================
#  post-deploy.sh — Commandes exécutées sur le serveur après chaque déploiement
#  Exécuté par le workflow CD via SSH
#  Chemin sur le serveur : $DEPLOY_PATH_BACKEND/scripts/post-deploy.sh
# ==============================================================================

set -euo pipefail   # Arrête le script à la première erreur

echo "🚀 [post-deploy] Démarrage du déploiement..."

# ── 1. Installer les dépendances PHP (production uniquement) ─────────────────
echo "📦 [1/7] Installation Composer (production)..."
composer install \
  --no-interaction \
  --prefer-dist \
  --optimize-autoloader \
  --no-dev

# ── 2. Vider tous les caches Laravel ────────────────────────────────────────
echo "🧹 [2/7] Nettoyage des caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# ── 3. Activer le mode maintenance (zero-downtime minimal) ──────────────────
echo "🔒 [3/7] Activation du mode maintenance..."
php artisan down --retry=60 --secret="ukwc-deploy-bypass-$(date +%s)"

# ── 4. Exécuter les migrations ───────────────────────────────────────────────
echo "🗄️  [4/7] Migrations de base de données..."
php artisan migrate --force

# ── 5. Créer le lien symbolique storage si nécessaire ───────────────────────
echo "🔗 [5/7] Lien symbolique storage..."
php artisan storage:link 2>/dev/null || echo "  → Déjà existant, on passe."

# ── 6. Optimiser pour la production ─────────────────────────────────────────
echo "⚡ [6/7] Optimisation production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# ── 7. Désactiver le mode maintenance ───────────────────────────────────────
echo "✅ [7/7] Désactivation du mode maintenance..."
php artisan up

echo "🎉 [post-deploy] Déploiement terminé avec succès !"
