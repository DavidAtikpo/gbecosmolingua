<?php
/**
 * GbeCosmoLingua theme functions.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

define( 'GBECOSMOLINGUA_VERSION', '1.2.0' );

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
 * Append language switcher next to site navigation when Polylang is active.
 *
 * @param string $block_content Block HTML.
 * @param array  $block         Block data.
 */
function gbecosmolingua_append_lang_switcher( $block_content, $block ) {
	if ( is_admin() || empty( $block['blockName'] ) || 'core/navigation' !== $block['blockName'] ) {
		return $block_content;
	}
	if ( ! shortcode_exists( 'gbe_lang_switcher' ) ) {
		return $block_content;
	}
	return '<div class="gbe-header-nav-wrap">' . $block_content . do_shortcode( '[gbe_lang_switcher]' ) . '</div>';
}
add_filter( 'render_block', 'gbecosmolingua_append_lang_switcher', 10, 2 );
