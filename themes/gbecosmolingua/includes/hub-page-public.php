<?php
/**
 * Affichage public des pages hub : uniquement contenu WordPress (pas de texte codé en dur).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page publiée par slug.
 *
 * @param string $slug Slug page.
 * @return WP_Post|null
 */
function gbecosmolingua_public_hub_page( $slug ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	return ( $page instanceof WP_Post && 'publish' === $page->post_status ) ? $page : null;
}

/**
 * Style CSS pour image mise en avant d'une page.
 *
 * @param int|null $page_id ID page.
 * @param string   $var     Variable CSS.
 * @return string
 */
function gbecosmolingua_public_featured_image_style( $page_id, $var ) {
	$page_id = (int) $page_id;
	if ( $page_id && has_post_thumbnail( $page_id ) ) {
		$url = wp_get_attachment_image_url( get_post_thumbnail_id( $page_id ), 'full' );
		if ( $url ) {
			return $var . ':url(' . esc_url( $url ) . ');';
		}
	}
	return '';
}

/**
 * Style CSS pour une image média.
 *
 * @param int    $attachment_id ID attachment.
 * @param string $var           Variable CSS.
 * @return string
 */
function gbecosmolingua_public_attachment_image_style( $attachment_id, $var ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );
		if ( $url ) {
			return $var . ':url(' . esc_url( $url ) . ');';
		}
	}
	return '';
}

/**
 * Intro = contenu de l'éditeur WordPress (HTML filtré).
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_public_page_intro_html( $page ) {
	if ( ! $page instanceof WP_Post ) {
		return '';
	}
	$content = trim( $page->post_content );
	if ( '' === $content ) {
		return '';
	}
	return apply_filters( 'the_content', $content );
}

/**
 * Extrait un chapô depuis le contenu si pas d'excerpt.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_public_page_excerpt_text( $page ) {
	if ( ! $page instanceof WP_Post ) {
		return '';
	}
	if ( has_excerpt( $page ) ) {
		return get_the_excerpt( $page );
	}
	$content = trim( wp_strip_all_tags( $page->post_content ) );
	if ( '' === $content ) {
		return '';
	}
	return wp_trim_words( $content, 35, '…' );
}
