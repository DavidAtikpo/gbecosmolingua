#!/usr/bin/env bash
# Corrige les erreurs 404 Apache (permaliens + import des pages).
set -euo pipefail

cd "$(dirname "$0")/.."

run_wp() {
	docker compose run --rm wpcli wp "$@"
}

echo "==> Redémarrage des conteneurs (montage .htaccess)..."
docker compose up -d

echo "==> Attente de WordPress..."
sleep 5

echo "==> Permaliens..."
run_wp rewrite structure '/%postname%/' --hard
run_wp rewrite flush --hard

echo "==> Import des pages GbeCosmoLingua..."
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

echo "==> Vérification page partenaires..."
run_wp eval '
$page = get_page_by_path( "partenaires", OBJECT, "page" );
if ( $page ) {
    echo "OK: " . get_permalink( $page ) . "\n";
} else {
    echo "ERREUR: page partenaires introuvable\n";
    exit(1);
}
'

echo ""
echo "=== Corrigé ==="
echo "Testez : http://localhost:8080/partenaires/"
