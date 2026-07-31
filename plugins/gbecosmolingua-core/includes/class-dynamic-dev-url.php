<?php
/**
 * Dynamic home/siteurl for local dev (localhost + LAN IP).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adjust WordPress URLs from the current request on trusted local hosts.
 */
class GBE_Dynamic_Dev_URL {

	/**
	 * Register filters.
	 */
	public static function init() {
		add_filter( 'option_home', array( __CLASS__, 'filter_url' ) );
		add_filter( 'option_siteurl', array( __CLASS__, 'filter_url' ) );
	}

	/**
	 * @param string $url Stored option value.
	 * @return string
	 */
	public static function filter_url( $url ) {
		$dynamic = self::request_url();

		return $dynamic ? $dynamic : $url;
	}

	/**
	 * @return string|null
	 */
	private static function request_url() {
		if ( empty( $_SERVER['HTTP_HOST'] ) ) {
			return null;
		}

		$host = strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) );

		$allowed = array(
			'/^localhost(?::\d+)?$/',
			'/^127\.0\.0\.1(?::\d+)?$/',
			'/^192\.168\.\d{1,3}\.\d{1,3}(?::\d+)?$/',
			'/^10\.\d{1,3}\.\d{1,3}\.\d{1,3}(?::\d+)?$/',
			'/^172\.(?:1[6-9]|2\d|3[01])\.\d{1,3}\.\d{1,3}(?::\d+)?$/',
		);

		foreach ( $allowed as $pattern ) {
			if ( preg_match( $pattern, $host ) ) {
				$https  = ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) || ( isset( $_SERVER['SERVER_PORT'] ) && 443 === (int) $_SERVER['SERVER_PORT'] );
				$scheme = $https ? 'https' : 'http';

				return $scheme . '://' . $host;
			}
		}

		return null;
	}
}

GBE_Dynamic_Dev_URL::init();
