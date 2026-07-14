#!/usr/bin/env bash
# Importe une base WordPress partagée (pages, contenus, réglages).
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${ROOT}/backups"
INPUT="${1:-${BACKUP_DIR}/gbe_wp-latest.sql}"

cd "${ROOT}"

if [[ ! -f "${INPUT}" ]]; then
	echo "Erreur : fichier introuvable : ${INPUT}"
	echo "Usage : bash scripts/import-db.sh [chemin/vers/gbe_wp.sql]"
	exit 1
fi

if ! docker compose ps -q db 2>/dev/null | grep -q .; then
	echo "Erreur : le conteneur db n'est pas démarré. Lancez : docker compose up -d"
	exit 1
fi

echo "==> Préparation de la base..."
docker compose exec -T db mysql -uroot -proot_pass -e "
CREATE DATABASE IF NOT EXISTS gbe_wp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON gbe_wp.* TO 'gbe_user'@'%';
FLUSH PRIVILEGES;
"

echo "==> Import depuis ${INPUT} ..."
docker compose exec -T db mysql -ugbe_user -pgbe_pass gbe_wp < "${INPUT}"

echo "==> Permaliens..."
docker compose run --rm wpcli wp rewrite structure '/%postname%/' --hard 2>/dev/null || true
docker compose run --rm wpcli wp rewrite flush --hard 2>/dev/null || true

echo ""
echo "=== Import terminé ==="
echo "Site  : http://localhost:8080"
echo "Admin : http://localhost:8080/wp-admin"
echo ""
echo "Si l'en-tête est incorrect : GbeCosmoLingua → Réinitialiser en-tête et pied de page"
