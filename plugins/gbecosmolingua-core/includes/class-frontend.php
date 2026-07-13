<?php
/**
 * Front-end assets and helpers.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueues public scripts and styles.
 */
class GBE_Frontend {

	/**
	 * Initialize hooks.
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
		add_filter( 'the_content', array( __CLASS__, 'append_proverbe_detail' ), 20 );
		add_filter( 'the_content', array( __CLASS__, 'append_genre_oral_detail' ), 20 );
		add_filter( 'the_content', array( __CLASS__, 'append_evenement_detail' ), 20 );
		add_filter( 'the_content', array( __CLASS__, 'append_partenaire_detail' ), 20 );
	}

	/**
	 * Enqueue Leaflet and GbeCosmoLingua front assets.
	 */
	public static function enqueue_assets() {
		wp_register_style(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
			array(),
			'1.9.4'
		);
		wp_register_script(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
			array(),
			'1.9.4',
			true
		);

		wp_register_style(
			'gbe-frontend',
			GBE_CORE_URL . 'assets/css/frontend.css',
			array(),
			GBE_CORE_VERSION
		);

		wp_register_script(
			'gbe-map',
			GBE_CORE_URL . 'assets/js/gbe-map.js',
			array( 'leaflet' ),
			GBE_CORE_VERSION,
			true
		);

		if ( self::needs_map_assets() ) {
			wp_enqueue_style( 'leaflet' );
			wp_enqueue_style( 'gbe-frontend' );
			wp_enqueue_script( 'leaflet' );
			wp_enqueue_script( 'gbe-map' );
			wp_localize_script( 'gbe-map', 'gbeMapData', gbe_get_map_data() );
		}

		if ( self::needs_frontend_styles() ) {
			wp_enqueue_style( 'gbe-frontend' );
		}
	}

	/**
	 * Whether current page needs map JS.
	 */
	private static function needs_map_assets() {
		if ( is_page( 'carte-interactive' ) ) {
			return true;
		}
		global $post;
		return $post && has_shortcode( $post->post_content, 'gbe_carte_interactive' );
	}

	/**
	 * Whether current page needs frontend CSS.
	 */
	private static function needs_frontend_styles() {
		if ( is_front_page() ) {
			return true;
		}
		if ( self::needs_map_assets() ) {
			return true;
		}
		if ( is_post_type_archive( array( 'proverbe', 'genre_oral', 'ressource', 'evenement' ) ) ) {
			return true;
		}
		if ( is_singular( array( 'proverbe', 'genre_oral', 'ressource', 'evenement', 'partenaire' ) ) ) {
			return true;
		}
		global $post;
		if ( ! $post ) {
			return false;
		}
		$shortcodes = array(
			'gbe_proverbes_list',
			'gbe_bibliotheque',
			'gbe_xotutu_list',
			'gbe_formulaire',
			'gbe_lang_switcher',
			'gbe_actualites',
			'gbe_agenda',
			'gbe_partenaires',
			'gbe_evenements_list',
			'gbe_partenaires_list',
			'gbe_menu_principal',
		);
		foreach ( $shortcodes as $sc ) {
			if ( has_shortcode( $post->post_content, $sc ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Append proverb meta on single proverbe pages.
	 *
	 * @param string $content Post content.
	 */
	public static function append_proverbe_detail( $content ) {
		if ( ! is_singular( 'proverbe' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		return $content . GBE_Shortcodes::render_proverbe_detail( get_the_ID(), false );
	}

	/**
	 * Append genre oral meta on single pages.
	 *
	 * @param string $content Post content.
	 */
	public static function append_genre_oral_detail( $content ) {
		if ( ! is_singular( 'genre_oral' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		return $content . GBE_Shortcodes::render_genre_oral_detail( get_the_ID(), false );
	}

	/**
	 * Append event meta on single evenement pages.
	 *
	 * @param string $content Post content.
	 */
	public static function append_evenement_detail( $content ) {
		if ( ! is_singular( 'evenement' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		return $content . GBE_Shortcodes::render_evenement_detail( get_the_ID(), false );
	}

	/**
	 * Append partner meta on single partenaire pages.
	 *
	 * @param string $content Post content.
	 */
	public static function append_partenaire_detail( $content ) {
		if ( ! is_singular( 'partenaire' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		return $content . GBE_Shortcodes::render_partenaire_detail( get_the_ID(), false );
	}

	/**
	 * Get a post meta value with underscore prefix.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $key     Meta key without prefix.
	 */
	public static function get_meta( $post_id, $key ) {
		return get_post_meta( $post_id, '_gbe_' . $key, true );
	}
}
