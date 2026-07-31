#!/usr/bin/env bash
# Exporte les fichiers médias WordPress (wp-content/uploads) pour partage avec l'équipe.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${ROOT}/backups"
STAMP="$(date +%Y%m%d-%H%M%S)"
OUTPUT="${BACKUP_DIR}/gbe_uploads-${STAMP}.tar.gz"
LATEST="${BACKUP_DIR}/gbe_uploads-latest.tar.gz"

mkdir -p "${BACKUP_DIR}"

cd "${ROOT}"

if ! docker compose ps -q wordpress 2>/dev/null | grep -q .; then
	echo "Erreur : le conteneur wordpress n'est pas démarré. Lancez : docker compose up -d"
	exit 1
fi

echo "==> Export des médias (uploads)..."
docker compose exec -T wordpress tar czf - -C /var/www/html/wp-content uploads > "${OUTPUT}"

cp "${OUTPUT}" "${LATEST}"

echo ""
echo "=== Export médias terminé ==="
echo "Fichier : ${OUTPUT}"
echo "Copie   : ${LATEST}"
echo ""
echo "Partagez gbe_uploads-latest.tar.gz avec l'équipe."
echo "Ils importent avec : bash scripts/import-uploads.sh"
