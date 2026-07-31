#!/usr/bin/env bash
# Importe les fichiers médias WordPress partagés par un collègue.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${ROOT}/backups"
INPUT="${1:-${BACKUP_DIR}/gbe_uploads-latest.tar.gz}"

cd "${ROOT}"

if [[ ! -f "${INPUT}" ]]; then
	echo "Erreur : fichier introuvable : ${INPUT}"
	echo "Usage : bash scripts/import-uploads.sh [chemin/vers/gbe_uploads.tar.gz]"
	exit 1
fi

if ! docker compose ps -q wordpress 2>/dev/null | grep -q .; then
	echo "Erreur : le conteneur wordpress n'est pas démarré. Lancez : docker compose up -d"
	exit 1
fi

echo "==> Import des médias depuis ${INPUT} ..."
docker compose exec -T wordpress tar xzf - -C /var/www/html/wp-content < "${INPUT}"

docker compose exec -T wordpress chown -R www-data:www-data /var/www/html/wp-content/uploads
docker compose exec -T wordpress chmod -R 775 /var/www/html/wp-content/uploads

echo ""
echo "=== Import médias terminé ==="
echo "Les images de la médiathèque devraient s'afficher si la base correspond (import-db.sh)."
