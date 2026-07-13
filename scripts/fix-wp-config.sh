#!/usr/bin/env bash
# Aligne wp-config.php sur la base gbe_wp (existante dans MySQL)
set -euo pipefail

cd "$(dirname "$0")/.."

echo "==> Base attendue : gbe_wp"
echo "==> Contenu actuel de wp-config.php :"
docker compose exec -T wordpress grep -E "DB_NAME|DB_USER|DB_HOST" /var/www/html/wp-config.php || true

echo ""
echo "==> Correction DB_NAME -> gbe_wp ..."
docker compose exec -T wordpress sed -i "s/db_gbecosmolingua/gbe_wp/g" /var/www/html/wp-config.php
docker compose exec -T wordpress sed -i "s/define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', '[^']*') );/define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'gbe_wp') );/" /var/www/html/wp-config.php 2>/dev/null || true

echo ""
echo "==> Après correction :"
docker compose exec -T wordpress grep -E "DB_NAME|DB_USER|DB_HOST" /var/www/html/wp-config.php || true

echo ""
echo "==> Redémarrage WordPress..."
docker compose restart wordpress

echo ""
echo "=== Terminé ==="
echo "Ouvrez http://localhost:8080"
