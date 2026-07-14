#!/usr/bin/env bash
# Exporte la base WordPress locale pour partage avec l'équipe.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${ROOT}/backups"
STAMP="$(date +%Y%m%d-%H%M%S)"
OUTPUT="${BACKUP_DIR}/gbe_wp-${STAMP}.sql"
LATEST="${BACKUP_DIR}/gbe_wp-latest.sql"

mkdir -p "${BACKUP_DIR}"

cd "${ROOT}"

if ! docker compose ps -q db 2>/dev/null | grep -q .; then
	echo "Erreur : le conteneur db n'est pas démarré. Lancez : docker compose up -d"
	exit 1
fi

echo "==> Export de la base gbe_wp..."
docker compose exec -T db mysqldump \
	-ugbe_user \
	-pgbe_pass \
	--single-transaction \
	--quick \
	--lock-tables=false \
	gbe_wp > "${OUTPUT}"

cp "${OUTPUT}" "${LATEST}"

echo ""
echo "=== Export terminé ==="
echo "Fichier     : ${OUTPUT}"
echo "Copie       : ${LATEST}"
echo ""
echo "Partagez gbe_wp-latest.sql avec l'équipe (Drive, Slack, etc.)"
echo "Ils importent avec : bash scripts/import-db.sh"
