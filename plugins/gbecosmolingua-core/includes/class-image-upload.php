<?php
/**
 * Fiabilise le téléversement d’images lourdes (captures d’écran, PNG larges).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Traitement médias — mémoire, éditeur d’image, miniatures.
 */
class GBE_Image_Upload {

	/**
	 * Register hooks.
	 */
	public static function init() {
		add_filter( 'wp_image_editors', array( __CLASS__, 'prefer_gd_editor' ) );
		add_filter( 'wp_memory_limit', array( __CLASS__, 'raise_memory_limit' ) );
		add_filter( 'admin_memory_limit', array( __CLASS__, 'raise_memory_limit' ) );
		add_filter( 'big_image_size_threshold', array( __CLASS__, 'big_image_threshold' ) );
		add_filter( 'intermediate_image_sizes_advanced', array( __CLASS__, 'trim_huge_subsizes' ), 10, 2 );
		add_action( 'load-async-upload.php', array( __CLASS__, 'raise_runtime_limits' ) );
		add_action( 'load-media-new.php', array( __CLASS__, 'raise_runtime_limits' ) );
	}

	/**
	 * GD gère souvent mieux les PNG / captures d’écran que Imagick en local.
	 *
	 * @param string[] $editors Editors stack.
	 * @return string[]
	 */
	public static function prefer_gd_editor( $editors ) {
		return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
	}

	/**
	 * @param string|int $limit Current limit.
	 * @return string
	 */
	public static function raise_memory_limit( $limit ) {
		return '512M';
	}

	/**
	 * Réduit la taille des originaux très larges avant les miniatures.
	 *
	 * @param int|false $threshold Default threshold.
	 * @return int
	 */
	public static function big_image_threshold( $threshold ) {
		return 2560;
	}

	/**
	 * Évite de générer des variantes énormes sur les très grandes sources.
	 *
	 * @param array<string, array<string, mixed>> $sizes    Sizes to generate.
	 * @param array<string, mixed>               $metadata Attachment metadata.
	 * @return array<string, array<string, mixed>>
	 */
	public static function trim_huge_subsizes( $sizes, $metadata ) {
		unset( $sizes['1536x1536'], $sizes['2048x2048'] );

		$width  = isset( $metadata['width'] ) ? (int) $metadata['width'] : 0;
		$height = isset( $metadata['height'] ) ? (int) $metadata['height'] : 0;

		if ( max( $width, $height ) > 4000 ) {
			unset( $sizes['large'], $sizes['medium_large'] );
		}

		return $sizes;
	}

	/**
	 * Limites PHP au moment du téléversement.
	 */
	public static function raise_runtime_limits() {
		if ( function_exists( 'wp_raise_memory_limit' ) ) {
			wp_raise_memory_limit( 'image' );
		}

		@ini_set( 'memory_limit', '512M' ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}
}

GBE_Image_Upload::init();
