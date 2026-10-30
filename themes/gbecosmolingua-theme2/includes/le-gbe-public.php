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
