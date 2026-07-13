#!/usr/bin/env bash
# Démarre Docker, vérifie WordPress et charge le contenu de démo GbeCosmoLingua.
set -euo pipefail

cd "$(dirname "$0")/.."

run_wp() {
	docker compose run --rm wpcli wp "$@"
}

echo "==> Démarrage des conteneurs..."
docker compose up -d

echo "==> Attente de WordPress..."
for i in $(seq 1 40); do
	if docker compose exec -T wordpress curl -sf http://localhost/wp-admin/install.php > /dev/null 2>&1; then
		break
	fi
	sleep 3
done

echo "==> Installation WordPress (si nécessaire)..."
if ! run_wp core is-installed 2>/dev/null; then
	run_wp core install \
		--url="http://localhost:8080" \
		--title="GbeCosmoLingua" \
		--admin_user="admin" \
		--admin_password="gbe_admin_2026" \
		--admin_email="admin@gbecosmolingua.local" \
		--locale="fr_FR" \
		--skip-email
fi

echo "==> Activation plugin et thème..."
run_wp plugin activate gbecosmolingua-core
run_wp theme activate gbecosmolingua

echo "==> Permaliens..."
run_wp rewrite structure '/%postname%/' --hard
run_wp rewrite flush --hard

echo "==> Import des pages..."
run_wp eval '
require_once WP_PLUGIN_DIR . "/gbecosmolingua-core/includes/class-page-importer.php";
$result = GBE_Page_Importer::import( true );
GBE_Page_Importer::patch_phase4_shortcodes();
GBE_Page_Importer::patch_phase5_forms();
GBE_Page_Importer::patch_phase7_content();
GBE_Page_Importer::configure_permalinks();
GBE_Page_Importer::reset_theme_template_parts( array( "header", "footer" ) );
GBE_Page_Importer::restore_primary_menu();
echo $result["message"] . "\n";
'

echo "==> Contenu de démonstration..."
run_wp eval '
require_once WP_PLUGIN_DIR . "/gbecosmolingua-core/includes/class-demo-content.php";
echo GBE_Demo_Content::seed( true ) . "\n";
'

echo ""
echo "=== Terminé ==="
echo "Accueil     : http://localhost:8080"
echo "Partenaires : http://localhost:8080/partenaires/"
echo "Admin       : http://localhost:8080/wp-admin (admin / gbe_admin_2026)"
