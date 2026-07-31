<?php
/**
 * Limites de téléversement médias (alignées sur config/php/uploads.ini).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Taille max affichée et appliquée dans la médiathèque WordPress.
 */
class GBE_Upload_Limits {

	const MAX_MB = 64;

	/**
	 * Register filter.
	 */
	public static function init() {
		add_filter( 'upload_size_limit', array( __CLASS__, 'filter_limit' ) );
	}

	/**
	 * @param int $size_bytes Taille calculée par WordPress.
	 * @return int
	 */
	public static function filter_limit( $size_bytes ) {
		$ini_bytes   = wp_convert_hr_to_bytes( ini_get( 'upload_max_filesize' ) );
		$post_bytes  = wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) );
		$target      = self::MAX_MB * MB_IN_BYTES;
		$candidates  = array_filter(
			array( (int) $size_bytes, (int) $ini_bytes, (int) $post_bytes, $target ),
			static function ( $value ) {
				return $value > 0;
			}
		);

		return min( $candidates );
	}
}

GBE_Upload_Limits::init();
