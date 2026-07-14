#!/usr/bin/env bash
# Fix WordPress uploads directory permissions (Linux / macOS / Git Bash on Windows).
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
UPLOADS="${ROOT}/wp-content/uploads"

mkdir -p "${UPLOADS}"
touch "${UPLOADS}/index.php"

if command -v docker >/dev/null 2>&1 && docker compose -f "${ROOT}/docker-compose.yml" ps -q wordpress 2>/dev/null | grep -q .; then
	echo "→ Correction via le conteneur WordPress (www-data)…"
	docker compose -f "${ROOT}/docker-compose.yml" exec -T wordpress sh -c '
		mkdir -p /var/www/html/wp-content/uploads
		chown -R www-data:www-data /var/www/html/wp-content/uploads
		chmod -R 775 /var/www/html/wp-content/uploads
	'
else
	echo "→ Correction locale du dossier uploads…"
	if [[ "$(uname -s)" == "Linux" || "$(uname -s)" == "Darwin" ]]; then
		if [ "$(id -u)" -eq 0 ]; then
			chown -R 33:33 "${UPLOADS}" 2>/dev/null || chown -R www-data:www-data "${UPLOADS}" 2>/dev/null || true
		else
			sudo chown -R 33:33 "${UPLOADS}" 2>/dev/null || sudo chown -R www-data:www-data "${UPLOADS}" 2>/dev/null || true
		fi
	fi
	chmod -R 775 "${UPLOADS}" 2>/dev/null || chmod -R 777 "${UPLOADS}"
fi

echo "✓ Dossier uploads prêt : ${UPLOADS}"
