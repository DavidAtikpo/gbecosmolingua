#!/usr/bin/env bash
# Exporte base + médias pour partager tout le contenu WordPress avec l'équipe.
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

bash "${ROOT}/scripts/export-db.sh"
bash "${ROOT}/scripts/export-uploads.sh"

echo ""
echo "=== Export complet terminé ==="
echo "Envoyez à l'équipe :"
echo "  - backups/gbe_wp-latest.sql"
echo "  - backups/gbe_uploads-latest.tar.gz"
echo ""
echo "Import chez un collègue :"
echo "  bash scripts/import-db.sh"
echo "  bash scripts/import-uploads.sh"
