<?php
/**
 * Plugin Name: GbeCosmoLingua Core
 * Plugin URI: https://gbecosmolingua.org
 * Description: Types de contenu, import des pages et configuration de base pour GbeCosmoLingua.
 * Version: 1.4.5
 * Author: GbeCosmoLingua
 * Text Domain: gbecosmolingua-core
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

define( 'GBE_CORE_VERSION', '1.4.5' );
define( 'GBE_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'GBE_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once GBE_CORE_PATH . 'includes/class-cpt.php';
require_once GBE_CORE_PATH . 'includes/class-meta-boxes.php';
require_once GBE_CORE_PATH . 'includes/class-page-importer.php';
require_once GBE_CORE_PATH . 'includes/class-admin.php';
require_once GBE_CORE_PATH . 'includes/class-frontend.php';
require_once GBE_CORE_PATH . 'includes/class-shortcodes.php';
require_once GBE_CORE_PATH . 'includes/class-demo-content.php';
require_once GBE_CORE_PATH . 'includes/class-polylang.php';
require_once GBE_CORE_PATH . 'includes/class-settings.php';
require_once GBE_CORE_PATH . 'includes/class-forms.php';

/**
 * Plugin bootstrap.
 */
function gbe_core_init() {
	GBE_CPT::register();
	GBE_Meta_Boxes::init();
	GBE_Admin::init();
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
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::restore_primary_menu();
		GBE_Page_Importer::deduplicate_imported_pages();
		GBE_Page_Importer::remove_obsolete_pages();
		GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		update_option( 'gbe_core_version', GBE_CORE_VERSION );
		flush_rewrite_rules();
	}
}
add_action( 'init', 'gbe_core_maybe_upgrade', 20 );

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
