#!/usr/bin/env bash
# Installe Polylang et affiche les étapes de configuration des langues
set -euo pipefail

cd "$(dirname "$0")/.."

echo "==> Installation de Polylang..."
docker compose run --rm wpcli wp plugin install polylang --activate 2>/dev/null || \
docker compose run --rm wpcli wp plugin is-active polylang

echo ""
echo "=== Polylang installé ==="
echo ""
echo "Configurez les langues dans l'admin WordPress :"
echo "  1. Langues > Ajouter une langue : English (en_US)"
echo "  2. Langues > Ajouter une langue : Español (es_ES)"
echo "  3. Langues > Ajouter une langue : Русский (ru_RU)"
echo "  4. Langues > Le français doit être la langue par défaut"
echo "  5. Traduisez les pages principales via l'icône + dans Pages"
echo ""
echo "Le sélecteur [gbe_lang_switcher] apparaît automatiquement dans l'en-tête."
echo "Les CPT (proverbes, Xótùtù, etc.) sont enregistrés comme traduisibles."
