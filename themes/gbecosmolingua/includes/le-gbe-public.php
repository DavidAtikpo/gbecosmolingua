<?php
/**
 * Compatibilité Gbe → composeur hub générique.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

function gbecosmolingua_le_gbe_public_page() {
	return gbecosmolingua_hub_composer_page( 'le-gbe' );
}

function gbecosmolingua_le_gbe_public_layout() {
	$page = gbecosmolingua_le_gbe_public_page();
	return gbecosmolingua_hub_composer_layout( $page ? (int) $page->ID : 0 );
}

function gbecosmolingua_le_gbe_public_hero_slides() {
	return gbecosmolingua_hub_composer_hero_slides( 'le-gbe' );
}

function gbecosmolingua_le_gbe_render_public_hero() {
	gbecosmolingua_hub_render_public_hero( 'le-gbe' );
}

function gbecosmolingua_le_gbe_render_public_intro() {
	gbecosmolingua_hub_render_public_intro( 'le-gbe' );
}

function gbecosmolingua_le_gbe_public_row_url( $row ) {
	return gbecosmolingua_hub_composer_row_url( $row );
}

function gbecosmolingua_le_gbe_render_public_sections() {
	gbecosmolingua_hub_render_public_sections( 'le-gbe' );
}

/**
 * Image du thème pour le hub Gbe (bannière, figure…).
 *
 * @param string $filename Nom de fichier dans assets/images/le-gbe/ (ou repli home / culture-gbe).
 * @return string URL ou chaîne vide.
 */
function gbecosmolingua_le_gbe_hub_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$dirs     = array( 'le-gbe', 'home', 'culture-gbe' );

	foreach ( $dirs as $dir ) {
		$path = get_stylesheet_directory() . '/assets/images/' . $dir . '/' . $filename;
		if ( file_exists( $path ) ) {
			return get_stylesheet_directory_uri() . '/assets/images/' . $dir . '/' . $filename;
		}
	}

	return '';
}

/**
 * Variable CSS pour une image du hub Gbe.
 *
 * @param string $filename Fichier.
 * @param string $var_name Variable CSS (--gbe-le-gbe-hero-image, etc.).
 * @return string
 */
function gbecosmolingua_le_gbe_hub_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_le_gbe_hub_image( $filename );
	if ( ! $url ) {
		return '';
	}

	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * URL de fond hero hub Gbe (médiathèque → image à la une → thème).
 *
 * @param WP_Post|null $page     Page hub.
 * @param int          $bg_id    ID attachment enregistré.
 * @return string
 */
function gbecosmolingua_le_gbe_hub_hero_bg_url( $page, $bg_id = 0 ) {
	$bg_id = (int) $bg_id;
	if ( $bg_id ) {
		$url = wp_get_attachment_image_url( $bg_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	if ( $page instanceof WP_Post && has_post_thumbnail( $page ) ) {
		$url = wp_get_attachment_image_url( get_post_thumbnail_id( $page ), 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return gbecosmolingua_le_gbe_hub_image( 'hero-village.jpg' );
}

/**
 * URL figure hero hub Gbe (médiathèque → thème).
 *
 * @param int $figure_id ID attachment enregistré.
 * @return string
 */
function gbecosmolingua_le_gbe_hub_hero_figure_url( $figure_id = 0 ) {
	$figure_id = (int) $figure_id;
	if ( $figure_id ) {
		$url = wp_get_attachment_image_url( $figure_id, 'large' );
		if ( $url ) {
			return $url;
		}
	}

	return gbecosmolingua_le_gbe_hub_image( 'sculpture.jpg' );
}

/**
 * Chapô par défaut de la bannière hub Gbe.
 *
 * @return string
 */
function gbecosmolingua_le_gbe_hub_default_hero_lead() {
	return __( 'Gbe désigne une langue unique de la branche kwa (Volta-Congo), parlée par environ quatre millions de locuteurs entre l\'océan Atlantique et les fleuves Volta et Ouémé.', 'gbecosmolingua' );
}

/**
 * Source du chapô hero hub Gbe (estimation des locuteurs).
 *
 * @return string
 */
function gbecosmolingua_le_gbe_hub_default_hero_lead_source() {
	return __( 'Source : H. C. Capo (Gbekɔbu, 2014), ch. 1 — estimation d’environ quatre millions de locuteurs autochtones.', 'gbecosmolingua' );
}
