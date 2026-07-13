<?php
/**
 * Plugin Name: GbeCosmoLingua Core
 * Plugin URI: https://gbecosmolingua.org
 * Description: Types de contenu, import des pages et configuration de base pour GbeCosmoLingua.
 * Version: 1.2.8
 * Author: GbeCosmoLingua
 * Text Domain: gbecosmolingua-core
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

define( 'GBE_CORE_VERSION', '1.2.8' );
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
		GBE_Page_Importer::patch_phase4_shortcodes();
		GBE_Page_Importer::patch_phase5_forms();
		GBE_Page_Importer::restore_primary_menu();
		update_option( 'gbe_core_version', GBE_CORE_VERSION );
		flush_rewrite_rules();
	}
}
add_action( 'init', 'gbe_core_maybe_upgrade', 20 );

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
