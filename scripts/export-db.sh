#!/usr/bin/env bash
# Exporte la base WordPress locale pour partage avec l'équipe.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${ROOT}/backups"
STAMP="$(date +%Y%m%d-%H%M%S)"
OUTPUT="${BACKUP_DIR}/gbe_wp-${STAMP}.sql"
LATEST="${BACKUP_DIR}/gbe_wp-latest.sql"

mkdir -p "${BACKUP_DIR}"

if [[ ! -w "${BACKUP_DIR}" ]]; then
	echo "Erreur : le dossier backups/ n'est pas accessible en écriture."
	echo "Corrigez avec : sudo chown -R \$(whoami):\$(whoami) \"${BACKUP_DIR}\""
	exit 1
fi

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
	--no-tablespaces \
	gbe_wp > "${OUTPUT}"

rm -f "${LATEST}"
cp "${OUTPUT}" "${LATEST}"

echo ""
echo "=== Export terminé ==="
echo "Fichier     : ${OUTPUT}"
echo "Copie       : ${LATEST}"
echo ""
echo "Partagez gbe_wp-latest.sql avec l'équipe (Drive, Slack, etc.)"
echo "Ils importent avec : bash scripts/import-db.sh"
