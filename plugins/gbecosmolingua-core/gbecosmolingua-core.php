<?php
/**
 * Plugin Name: GbeCosmoLingua Core
 * Plugin URI: https://gbecosmolingua.org
 * Description: Types de contenu, import des pages et configuration de base pour GbeCosmoLingua.
 * Version: 1.10.6
 * Author: GbeCosmoLingua
 * Text Domain: gbecosmolingua-core
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

define( 'GBE_CORE_VERSION', '1.10.6' );
define( 'GBE_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'GBE_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once GBE_CORE_PATH . 'includes/class-dynamic-dev-url.php';
require_once GBE_CORE_PATH . 'includes/class-upload-limits.php';
require_once GBE_CORE_PATH . 'includes/class-image-upload.php';
require_once GBE_CORE_PATH . 'includes/class-cpt.php';
require_once GBE_CORE_PATH . 'includes/class-meta-boxes.php';
require_once GBE_CORE_PATH . 'includes/class-page-importer.php';
require_once GBE_CORE_PATH . 'includes/class-admin.php';
require_once GBE_CORE_PATH . 'includes/class-frontend.php';
require_once GBE_CORE_PATH . 'includes/class-shortcodes.php';
require_once GBE_CORE_PATH . 'includes/class-demo-content.php';
require_once GBE_CORE_PATH . 'includes/class-membres-photos.php';
require_once GBE_CORE_PATH . 'includes/class-proverbes-importer.php';
require_once GBE_CORE_PATH . 'includes/class-polylang.php';
require_once GBE_CORE_PATH . 'includes/class-settings.php';
require_once GBE_CORE_PATH . 'includes/class-forms.php';
require_once GBE_CORE_PATH . 'includes/class-le-gbe-hub-admin.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-accueil-intro.php';
require_once GBE_CORE_PATH . 'includes/content/gbe-mission-statuts.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-capo-auteur.php';
require_once GBE_CORE_PATH . 'includes/class-home-composer-admin.php';

/**
 * Plugin bootstrap.
 */
function gbe_core_init() {
	GBE_CPT::register();
	GBE_Meta_Boxes::init();
	GBE_Admin::init();
	GBE_Le_Gbe_Hub_Admin::init();
	GBE_Home_Composer_Admin::init();
	GBE_Frontend::init();
	GBE_Shortcodes::init();
	GBE_Settings::init();
	GBE_Forms::init();
	GBE_Polylang::init();
}
add_action( 'plugins_loaded', 'gbe_core_init' );

/**
 * Run phase 4 patches after theme/plugin update.
 */
function gbe_core_maybe_upgrade() {
	$version = get_option( 'gbe_core_version', '0' );
	if ( version_compare( $version, GBE_CORE_VERSION, '<' ) ) {
		GBE_Page_Importer::import( true );
		GBE_Page_Importer::patch_phase4_shortcodes();
		GBE_Page_Importer::patch_phase5_forms();
		GBE_Page_Importer::patch_phase7_content();
		GBE_Page_Importer::patch_culture_subpages();
		GBE_Page_Importer::patch_le_gbe_subpages();
		GBE_Page_Importer::patch_linguistique_subpages();
		GBE_Page_Importer::patch_paremiologie_subpages();
		GBE_Page_Importer::patch_onomastique_subpages();
		GBE_Page_Importer::patch_recherche_innovation_subpages();
		GBE_Page_Importer::patch_site_hubs_subpages();
		GBE_Page_Importer::patch_membres_fondateurs();
		GBE_Page_Importer::patch_mission_statuts();
		GBE_Page_Importer::patch_capo_auteur_page();
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::restore_primary_menu();
		GBE_Page_Importer::deduplicate_imported_pages();
		GBE_Page_Importer::remove_obsolete_pages();
		GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		GBE_Page_Importer::reset_theme_templates(
			array(
				'front-page',
				'page-le-gbe',
				'page-cultures-gbe',
				'page-xotutu',
				'page-onomastique',
				'page-linguistique',
				'page-paremiologie',
				'page-recherche-innovation',
				'page-sejours-mobilite',
				'page-partenaires',
				'page-nous-soutenir',
				'page-philosophie',
			)
		);
		GBE_Home_Composer_Admin::maybe_seed_defaults();
		update_option( 'gbe_core_version', GBE_CORE_VERSION );
		flush_rewrite_rules();
	}
}
add_action( 'init', 'gbe_core_maybe_upgrade', 20 );

/**
 * Garantit la présence des membres fondateurs en base (y compris si la mise à jour a déjà tourné).
 */
function gbe_core_ensure_membres_fondateurs() {
	if ( wp_doing_cron() ) {
		return;
	}

	$expected = class_exists( 'GBE_Membres_Photos' ) ? count( GBE_Membres_Photos::get_fondateurs_catalog() ) : 5;
	if ( get_transient( 'gbe_membres_fondateurs_ok' ) ) {
		return;
	}

	$published = class_exists( 'GBE_Membres_Photos' )
		? GBE_Membres_Photos::count_published_in_group( 'fondateur' )
		: 0;

	if ( $published >= $expected ) {
		set_transient( 'gbe_membres_fondateurs_ok', 1, DAY_IN_SECONDS );
		return;
	}

	if ( class_exists( 'GBE_Demo_Content' ) ) {
		GBE_Demo_Content::seed_membres_fondateurs();
	}

	$published = class_exists( 'GBE_Membres_Photos' )
		? GBE_Membres_Photos::count_published_in_group( 'fondateur' )
		: 0;

	if ( $published >= $expected ) {
		set_transient( 'gbe_membres_fondateurs_ok', 1, DAY_IN_SECONDS );
	}
}
add_action( 'init', 'gbe_core_ensure_membres_fondateurs', 25 );

/**
 * Ensure permalinks and .htaccess on front-end if still broken.
 */
function gbe_core_ensure_permalinks() {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}

	$verified = get_option( 'gbe_permalinks_verified', '' );
	if ( $verified === GBE_CORE_VERSION ) {
		return;
	}

	GBE_Page_Importer::configure_permalinks();
	update_option( 'gbe_permalinks_verified', GBE_CORE_VERSION );
}
add_action( 'init', 'gbe_core_ensure_permalinks', 5 );

/**
 * Run setup on activation.
 */
function gbe_core_activate() {
	gbe_core_init();
	GBE_Page_Importer::import();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'gbe_core_activate' );

/**
 * Flush rewrite rules on deactivation.
 */
function gbe_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'gbe_core_deactivate' );
