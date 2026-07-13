#!/usr/bin/env bash
# Corrige l'erreur "Cannot select database db_gbecosmolingua"
set -euo pipefail

cd "$(dirname "$0")/.."

echo "==> Vérification des conteneurs..."
docker compose ps

echo ""
echo "==> Bases de données existantes :"
docker compose exec -T db mysql -uroot -proot_pass -e "SHOW DATABASES;"

echo ""
echo "==> Création de gbe_wp et droits pour gbe_user..."
docker compose exec -T db mysql -uroot -proot_pass -e "
CREATE DATABASE IF NOT EXISTS gbe_wp
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON gbe_wp.* TO 'gbe_user'@'%';
FLUSH PRIVILEGES;
"

echo ""
echo "==> Vérification finale :"
docker compose exec -T db mysql -ugbe_user -pgbe_pass -e "USE gbe_wp; SELECT 'OK' AS status;"

echo ""
echo "=== Base de données prête ==="
echo "Rechargez http://localhost:8080"
echo "Si WordPress demande l'installation, suivez l'assistant puis activez le thème et le plugin."
