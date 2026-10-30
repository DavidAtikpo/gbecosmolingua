<?php
/**
 * Textes d'introduction accueil — qu'est-ce que Gbe ?
 *
 * Synthèse des chapitres 1, 7 et 9 (inventaire, regroupement, langue unique).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Contenu par défaut de la section « Qu'est-ce que Gbe ? » (page d'accueil).
 *
 * @return array<string, mixed>
 */
function gbe_home_introduction_defaults() {
	return array(
		'kicker'     => 'Le continuum gbe',
		'title'      => 'Qu\'est-ce que Gbe ?',
		'paragraphs' => array(
			'Gbe est une langue unique de la branche kwa (Volta-Congo) de la famille Niger-Congo. Elle désigne un ensemble d’environ cinquante parlers mutuellement intelligibles, parlés par près de quatre millions de locuteurs au Ghana, au Togo, au Bénin et au Nigeria — de l’océan Atlantique aux fleuves Volta et Ouémé.',
			'Chaque communauté a son parler (Éwé, Fon, Gen, Aja, Gun, Waci, Phla…), mais les travaux linguistiques montrent une intercompréhension appréciable et un patrimoine lexical commun : entre 82 % et 96 % de ressemblance sur la liste Swadesh entre les principales formes écrites. Linguistiquement, il s’agit d’une seule langue avec ses dialectes.',
			'Ces parlers se regroupent en cinq sections — Vhe, Gen, Ajé, Fon et Phla-Phera — qui partagent une grammaire de base et une littérature orale mobile (proverbes, contes, chants) à travers tout le continuum. GbeCosmoLingua documente cette diversité et contribue à la renaissance de Gbe.',
		),
		'highlights' => array(
			array(
				'label' => 'Aire géographique',
				'text'  => 'Ghana · Togo · Bénin · Nigeria',
			),
			array(
				'label' => 'Parlers recensés',
				'text'  => 'Une cinquantaine de variétés',
			),
			array(
				'label' => 'Locuteurs',
				'text'  => 'Environ 4 millions',
			),
			array(
				'label' => 'Sections dialectales',
				'text'  => 'Vhe · Gen · Ajé · Fon · Phla-Phera',
			),
		),
		'link_text'  => 'Explorer le continuum Gbe →',
		'link_url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
		'link2_text' => 'Gbe, une langue unique →',
		'link2_url'  => '/le-gbe/le-continuum-gbe/langue-unique/',
	);
}
