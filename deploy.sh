#!/usr/bin/env bash
# ==============================================================================
#  Script de déploiement — United Kizdom World Congress
#  Usage : bash deploy.sh [--first-deploy]
# ==============================================================================
#
#  Ce script :
#    1. Récupère le dernier code depuis git
#    2. Installe / met à jour les dépendances (npm + composer)
#    3. Build le frontend Nuxt
#    4. Optimise Laravel (config, cache, routes)
#    5. Joue les migrations (sans perte de données)
#    6. Redémarre les services via PM2
#
#  Pré-requis sur le serveur LWS :
#    - Node.js >= 20 (https://nodejs.org)
#    - PHP >= 8.3  (apt install php8.3-cli php8.3-mysql php8.3-mbstring ...)
#    - Composer    (https://getcomposer.org)
#    - PM2         (npm install -g pm2)
#    - Git         (apt install git)
#
#  AVANT le premier déploiement :
#    cp .env.example .env           ← Remplir les valeurs frontend
#    cp backend/.env.example backend/.env  ← Remplir les valeurs backend
#    bash deploy.sh --first-deploy  ← Lance aussi les seeds (admin initial)
# ==============================================================================

set -euo pipefail

# ── Couleurs ──────────────────────────────────────────────────────────────────
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

log()     { echo -e "${BLUE}[DEPLOY]${NC} $1"; }
success() { echo -e "${GREEN}[OK]${NC} $1"; }
warn()    { echo -e "${YELLOW}[WARN]${NC} $1"; }
error()   { echo -e "${RED}[ERROR]${NC} $1"; exit 1; }

# ── Paramètres ────────────────────────────────────────────────────────────────
FIRST_DEPLOY=false
[[ "${1:-}" == "--first-deploy" ]] && FIRST_DEPLOY=true

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKEND_DIR="$ROOT_DIR/backend"

# ── Vérifications préalables ──────────────────────────────────────────────────
log "Vérification de l'environnement..."

command -v node    >/dev/null 2>&1 || error "Node.js n'est pas installé"
command -v npm     >/dev/null 2>&1 || error "npm n'est pas installé"
command -v php     >/dev/null 2>&1 || error "PHP n'est pas installé"
command -v composer>/dev/null 2>&1 || error "Composer n'est pas installé"
command -v pm2     >/dev/null 2>&1 || error "PM2 n'est pas installé (npm install -g pm2)"

[[ -f "$ROOT_DIR/.env" ]]         || error "Fichier .env manquant → cp .env.example .env"
[[ -f "$BACKEND_DIR/.env" ]]      || error "Fichier backend/.env manquant → cp backend/.env.example backend/.env"

success "Environnement OK"

# ── 1. Mise à jour du code ────────────────────────────────────────────────────
log "Récupération du dernier code (git pull)..."
cd "$ROOT_DIR"
git pull origin main
success "Code mis à jour"

# ── 2. Frontend — Dépendances ─────────────────────────────────────────────────
log "Installation des dépendances Node.js..."
cd "$ROOT_DIR"
npm ci --prefer-offline
success "Dépendances Node.js installées"

# ── 3. Frontend — Build Nuxt ──────────────────────────────────────────────────
log "Build du frontend Nuxt (peut prendre 1-2 minutes)..."
cd "$ROOT_DIR"
npm run build
success "Frontend buildé → .output/"

# ── 4. Backend — Dépendances ──────────────────────────────────────────────────
log "Installation des dépendances PHP (Composer)..."
cd "$BACKEND_DIR"
composer install --no-dev --optimize-autoloader --no-interaction
success "Dépendances PHP installées"

# ── 5. Backend — Migrations ───────────────────────────────────────────────────
log "Application des migrations..."
cd "$BACKEND_DIR"
php artisan migrate --force
success "Migrations appliquées"

# ── 6. Backend — Premier déploiement (seed) ───────────────────────────────────
if [[ "$FIRST_DEPLOY" == true ]]; then
  log "Premier déploiement — création du compte admin..."
  cd "$BACKEND_DIR"
  php artisan db:seed --force
  warn "IMPORTANT : changez le mot de passe admin dès maintenant !"
  success "Compte admin créé"
fi

# ── 7. Backend — Optimisation Laravel ────────────────────────────────────────
log "Optimisation Laravel (config, routes, vues)..."
cd "$BACKEND_DIR"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
php artisan config:cache
php artisan route:cache
success "Laravel optimisé"

# ── 8. Redémarrage des services PM2 ──────────────────────────────────────────
log "Redémarrage des services via PM2..."
cd "$ROOT_DIR"

if pm2 list | grep -q "ukwc-nuxt"; then
  # Services déjà en cours → reload sans downtime
  pm2 reload ecosystem.config.cjs --env production
  success "Services rechargés (zero-downtime)"
else
  # Premier démarrage
  pm2 start ecosystem.config.cjs --env production
  pm2 save
  success "Services démarrés et sauvegardés"
fi

# ── Résumé ────────────────────────────────────────────────────────────────────
echo ""
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo -e "${GREEN}  Déploiement terminé avec succès !     ${NC}"
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo ""
pm2 list
echo ""
log "Logs en temps réel : pm2 logs"
log "Status des services : pm2 monit"
