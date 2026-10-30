<?php
/**
 * Assets statiques page d'accueil (images thème).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL d'un fichier dans assets/images/home/.
 *
 * @param string $filename Nom de fichier.
 * @return string
 */
function gbecosmolingua_home_asset_url( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	if ( '' === $filename ) {
		return '';
	}
	$path = get_stylesheet_directory() . '/assets/images/home/' . $filename;
	if ( ! file_exists( $path ) ) {
		return '';
	}
	return get_stylesheet_directory_uri() . '/assets/images/home/' . $filename;
}

/**
 * Diapositives du slider hero (fichiers thème + transitions).
 *
 * @return array<int, array{file: string, transition: string, label: string}>
 */
function gbecosmolingua_home_hero_slides() {
	$definitions = array(
		array(
			'file'       => 'hero-slide-01.jpg',
			'transition' => 'kenburns',
			'label'      => __( 'Musiciens traditionnels', 'gbecosmolingua' ),
		),
		array(
			'file'       => 'hero-slide-02.jpg',
			'transition' => 'crossfade',
			'label'      => __( 'Cérémonie royale', 'gbecosmolingua' ),
		),
		array(
			'file'       => 'hero-slide-03.jpg',
			'transition' => 'push',
			'label'      => __( 'Village et savoirs agricoles', 'gbecosmolingua' ),
		),
		array(
			'file'       => 'hero-slide-04.jpg',
			'transition' => 'rise',
			'label'      => __( 'Place des Martyrs, Cotonou', 'gbecosmolingua' ),
		),
		array(
			'file'       => 'hero-slide-05.jpg',
			'transition' => 'fragment-scatter',
			'label'      => __( 'Monument des Amazones', 'gbecosmolingua' ),
		),
		array(
			'file'       => 'hero-slide-06.jpg',
			'transition' => 'fragment-cascade',
			'label'      => __( 'Place de l\'Étoile Rouge', 'gbecosmolingua' ),
		),
		array(
			'file'       => 'hero-slide-07.jpg',
			'transition' => 'fragment-shatter',
			'label'      => __( 'Pont de Cotonou', 'gbecosmolingua' ),
		),
	);

	$slides = array();
	foreach ( $definitions as $def ) {
		$url = gbecosmolingua_home_asset_url( $def['file'] );
		if ( ! $url ) {
			continue;
		}
		$slides[] = array(
			'url'        => $url,
			'file'       => $def['file'],
			'transition' => $def['transition'],
			'label'      => $def['label'],
		);
	}

	if ( empty( $slides ) ) {
		$fallback = gbecosmolingua_home_asset_url( 'hero-patrimoine.jpg' );
		if ( $fallback ) {
			$slides[] = array(
				'url'        => $fallback,
				'file'       => 'hero-patrimoine.jpg',
				'transition' => 'fade',
				'label'      => __( 'Patrimoine gbe', 'gbecosmolingua' ),
			);
		}
	}

	return $slides;
}

/**
 * URL image : image_id média, image_file thème, ou clé legacy.
 *
 * @param array<string, mixed> $item Données item.
 * @param string               $size  Taille WP (ignorée pour fichiers thème).
 * @return string
 */
function gbecosmolingua_home_image_url( $item, $size = 'large' ) {
	if ( ! is_array( $item ) ) {
		return '';
	}

	$image_id = (int) ( $item['image_id'] ?? 0 );
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return $url;
		}
	}

	$file = trim( (string) ( $item['image_file'] ?? '' ) );
	if ( $file ) {
		return gbecosmolingua_home_asset_url( $file );
	}

	return '';
}
