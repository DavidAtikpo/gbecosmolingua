<?php
/**
 * Callbacks runtime — pages chapitre Linguistique.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Map URI → callback pour les rubriques linguistiques chapitre.
 *
 * @return array<string, string>
 */
function gbe_le_gbe_linguistique_chapter_callbacks() {
	return array(
		'le-gbe/linguistique/travaux-scientifiques-recents' => 'gbe_le_gbe_travaux_scientifiques_content',
		'le-gbe/linguistique/hounkpati-b-c-capo'           => 'gbe_le_gbe_capo_auteur_content',
		'le-gbe/linguistique/potentialites-lexicales'        => 'gbe_le_gbe_potentialites_lexicales_content',
		'le-gbe/linguistique/dialectologie'                  => 'gbe_le_gbe_dialectologie_content',
		'le-gbe/linguistique/phonologie'                     => 'gbe_le_gbe_fon_phonologie_content',
		'le-gbe/linguistique/morphologie'                    => 'gbe_le_gbe_fon_morphologie_content',
		'le-gbe/linguistique/lexicologie'                    => 'gbe_le_gbe_lexicologie_content',
	);
}
