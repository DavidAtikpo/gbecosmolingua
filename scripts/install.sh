#!/usr/bin/env bash
# Installation WordPress + GbeCosmoLingua via Docker et WP-CLI
set -euo pipefail

cd "$(dirname "$0")/.."

echo "==> Démarrage des conteneurs..."
docker compose up -d

echo "==> Attente de WordPress..."
until docker compose exec -T wordpress curl -sf http://localhost/wp-admin/install.php > /dev/null 2>&1; do
  sleep 3
done

echo "==> Installation WordPress (si nécessaire)..."
docker compose run --rm wpcli wp core is-installed 2>/dev/null || \
docker compose run --rm wpcli wp core install \
  --url="http://localhost:8080" \
  --title="GbeCosmoLingua" \
  --admin_user="admin" \
  --admin_password="gbe_admin_2026" \
  --admin_email="admin@gbecosmolingua.local" \
  --locale="fr_FR" \
  --skip-email

echo "==> Activation du plugin et import des pages..."
docker compose run --rm wpcli wp plugin activate gbecosmolingua-core
docker compose run --rm wpcli wp theme activate gbecosmolingua

echo "==> Installation de Polylang (multilingue)..."
docker compose run --rm wpcli wp plugin install polylang --activate 2>/dev/null || true

echo ""
echo "=== Installation terminée ==="
echo "Site      : http://localhost:8080"
echo "Admin     : http://localhost:8080/wp-admin"
echo "Utilisateur : admin"
echo "Mot de passe : gbe_admin_2026"
echo "phpMyAdmin : http://localhost:8081"
echo ""
echo "Étapes suivantes :"
echo "  - Langues Polylang : ./scripts/setup-polylang.sh"
echo "  - Réglages dons   : Admin > GbeCosmoLingua > Réglages"
