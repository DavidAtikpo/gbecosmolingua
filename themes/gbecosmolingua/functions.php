<?php
/**
 * GbeCosmoLingua theme functions.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

define( 'GBECOSMOLINGUA_VERSION', '1.3.9' );

/**
 * Enqueue parent and child theme styles.
 */
function gbecosmolingua_enqueue_styles() {
	wp_enqueue_style(
		'twentytwentyfive-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
	);

	wp_enqueue_style(
		'gbecosmolingua-style',
		get_stylesheet_uri(),
		array( 'twentytwentyfive-style' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-custom',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		array( 'gbecosmolingua-style' ),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'gbecosmolingua_enqueue_styles' );

/**
 * Register block pattern category.
 */
function gbecosmolingua_register_pattern_category() {
	register_block_pattern_category(
		'gbecosmolingua',
		array(
			'label' => __( 'GbeCosmoLingua', 'gbecosmolingua' ),
		)
	);
}
add_action( 'init', 'gbecosmolingua_register_pattern_category' );

/**
 * Register navigation menu locations.
 */
function gbecosmolingua_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'gbecosmolingua' ),
			'footer'  => __( 'Menu pied de page', 'gbecosmolingua' ),
		)
	);
}
add_action( 'after_setup_theme', 'gbecosmolingua_register_menus' );

/**
 * Theme supports.
 */
function gbecosmolingua_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );
}
add_action( 'after_setup_theme', 'gbecosmolingua_theme_setup' );

/**
 * Favicon du site (onglet navigateur) — fallback si aucune icône n'est définie dans le customizer.
 */
function gbecosmolingua_site_favicon() {
	if ( has_site_icon() ) {
		return;
	}

	$icon_url = get_stylesheet_directory_uri() . '/assets/images/gbecosmolingua-logo.png';
	printf(
		'<link rel="icon" href="%s" sizes="any">' . "\n",
		esc_url( $icon_url )
	);
}
add_action( 'wp_head', 'gbecosmolingua_site_favicon', 5 );
add_action( 'admin_head', 'gbecosmolingua_site_favicon', 5 );
add_action( 'login_head', 'gbecosmolingua_site_favicon', 5 );

/**
 * Enqueue admin branding styles.
 */
function gbecosmolingua_admin_branding_assets() {
	wp_enqueue_style(
		'gbecosmolingua-admin',
		get_stylesheet_directory_uri() . '/assets/css/admin.css',
		array( 'wp-admin', 'common', 'forms' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-editor-admin',
		get_stylesheet_directory_uri() . '/assets/css/editor-admin.css',
		array( 'gbecosmolingua-admin' ),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'gbecosmolingua_admin_branding_assets', 100 );

/**
 * Enqueue login page branding styles.
 */
function gbecosmolingua_login_branding_assets() {
	wp_enqueue_style(
		'gbecosmolingua-admin',
		get_stylesheet_directory_uri() . '/assets/css/admin.css',
		array(),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'login_enqueue_scripts', 'gbecosmolingua_login_branding_assets' );

/**
 * Enqueue editor branding in block editor context.
 */
function gbecosmolingua_block_editor_branding() {
	wp_enqueue_style(
		'gbecosmolingua-editor-admin',
		get_stylesheet_directory_uri() . '/assets/css/editor-admin.css',
		array( 'wp-edit-blocks' ),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'gbecosmolingua_block_editor_branding' );

/**
 * Login page logo link and title.
 *
 * @return string
 */
function gbecosmolingua_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'gbecosmolingua_login_logo_url' );

/**
 * @return string
 */
function gbecosmolingua_login_logo_title() {
	return 'GbeCosmoLingua';
}
add_filter( 'login_headertext', 'gbecosmolingua_login_logo_title' );

/**
 * Replace WordPress logo in admin bar with GbeCosmoLingua branding.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
 */
function gbecosmolingua_admin_bar_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );

	$wp_admin_bar->add_node(
		array(
			'id'    => 'gbe-logo',
			'title' => sprintf(
				'<span class="gbe-admin-bar-logo__icon" aria-hidden="true"></span> <span class="ab-label">%s</span>',
				esc_html__( 'GbeCosmoLingua', 'gbecosmolingua' )
			),
			'href'  => admin_url(),
			'meta'  => array(
				'class' => 'gbe-admin-bar-logo',
				'title' => __( 'Tableau de bord GbeCosmoLingua', 'gbecosmolingua' ),
			),
		)
	);
}
add_action( 'admin_bar_menu', 'gbecosmolingua_admin_bar_logo', 11 );

/**
 * Custom admin footer text.
 *
 * @return string
 */
function gbecosmolingua_admin_footer_text() {
	return __( 'GbeCosmoLingua — Observatoire des langues, cultures et patrimoines gbe', 'gbecosmolingua' );
}
add_filter( 'admin_footer_text', 'gbecosmolingua_admin_footer_text' );
