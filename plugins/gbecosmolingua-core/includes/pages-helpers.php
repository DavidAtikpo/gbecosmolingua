<?php
/**
 * Helpers for building the GbeCosmoLingua page tree.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Simple outline list content.
 *
 * @param string[] $items List items.
 * @return string
 */
function gbe_outline( $items ) {
	return '<ul><li>' . implode( '</li><li>', array_map( 'esc_html', $items ) ) . '</li></ul>';
}

/**
 * Standard intro paragraph for a section.
 *
 * @param string $text Intro text.
 * @return string
 */
function gbe_intro( $text ) {
	return '<p>' . esc_html( $text ) . '</p>';
}

/**
 * Language pages under Le Gbe.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_langue_pages() {
	$langues = array(
		'Éwé'          => 'ewe',
		'Gen (Mina)'   => 'gen-mina',
		'Fon'          => 'fon',
		'Aja'          => 'aja',
		'Gun'          => 'gun',
		'Waci'         => 'waci',
		'Xwela'        => 'xwela',
		'Xwla'         => 'xwla',
		'Phla-Phera'   => 'phla-phera',
		'Autres variétés' => 'autres-varietes',
	);

	$pages = array();
	foreach ( $langues as $title => $slug ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => $slug,
			'content' => gbe_intro(
				sprintf(
					'Documentation linguistique et culturelle de la variété %s du continuum gbe : description, corpus, ressources et perspectives de recherche.',
					$title
				)
			) . gbe_outline(
				array(
					'Présentation et aire géographique',
					'Phonologie et alphabet',
					'Morphosyntaxe',
					'Lexique et corpus',
					'Patrimoine oral et culturel',
				)
			),
		);
	}

	return $pages;
}

/**
 * Linguistics sub-pages.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_linguistique_pages() {
	$sections = array(
		'Alphabet'      => array( 'alphabet', 'Orthographes et systèmes d\'écriture des variétés gbe.' ),
		'Phonologie'    => array( 'phonologie', 'Inventaires phonologiques, tons et structures syllabiques.' ),
		'Morphologie'   => array( 'morphologie', 'Formation des mots, dérivation et morphologie verbale.' ),
		'Syntaxe'       => array( 'syntaxe', 'Structures phrastiques et ordre des constituants.' ),
		'Lexicologie'   => array( 'lexicologie', 'Champs lexicaux, néologie et terminologie culturelle.' ),
		'Dialectologie' => array( 'dialectologie', 'Variation dialectale et relations intervariétales du continuum.' ),
	);

	$pages = array();
	foreach ( $sections as $title => $data ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => $data[0],
			'content' => gbe_intro( $data[1] ) . gbe_outline(
				array(
					'Notions fondamentales',
					'Ouvrages de référence',
					'Corpus et ressources numériques',
					'Axes de recherche GbeCosmoLingua',
				)
			),
		);
	}

	return $pages;
}

/**
 * Terminology pages under Xótùtù.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_terminologie_pages() {
	$terms = array(
		'Tradition orale'                        => 'tradition-orale',
		'Littérature orale'                      => 'litterature-orale',
		'Patrimoine immatériel'                  => 'patrimoine-immateriel',
		'Oralité'                                => 'oralite',
		'Ethnolinguistique'                      => 'ethnolinguistique',
		'Ethnopoétique'                          => 'ethnopoetique',
		'Performance orale'                      => 'performance-orale',
		'Transmission intergénérationnelle'      => 'transmission-intergenerationnelle',
	);

	$pages = array();
	foreach ( $terms as $title => $slug ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => $slug,
			'content' => gbe_intro(
				sprintf( 'Définition, enjeux et usages du concept « %s » dans le cadre du Xótùtù et des études gbe.', $title )
			),
		);
	}

	return $pages;
}

/**
 * Folkloric genre pages.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_genres_folkloriques_pages() {
	return array(
		array(
			'title'   => 'Lododowo — Proverbes',
			'slug'    => 'lododowo-proverbes',
			'content' => gbe_intro( 'Les lododowo condensent la sagesse populaire éwé et gbe.' ),
		),
		array(
			'title'   => 'Àdàgana — Locutions idiomatiques',
			'slug'    => 'adagana-locutions',
			'content' => gbe_intro( 'Expressions idiomatiques et tournures figées de la parole gbe.' ),
		),
		array(
			'title'   => 'Nyàgblɔ̀ɖɛ — Dictons',
			'slug'    => 'nyagblode-dictons',
			'content' => gbe_intro( 'Dictons et formules sentencieuses transmises oralement.' ),
		),
		array(
			'title'   => 'Àlòbalo — Énigmes et paraboles',
			'slug'    => 'alobalo-enigmes',
			'content' => gbe_intro( 'Énigmes, paraboles et récits à visée didactique.' ),
		),
		array(
			'title'   => 'Àdzò — Devinettes',
			'slug'    => 'adzo-devinettes',
			'content' => gbe_intro( 'Devinettes et jeux de parole intergénérationnels.' ),
		),
		array(
			'title'    => 'Ègli — Contes',
			'slug'     => 'egli-contes',
			'content'  => gbe_intro( 'Les contes constituent un vaste répertoire narratif du continuum gbe.' ),
			'children' => array(
				array( 'title' => 'Contes initiatiques', 'slug' => 'contes-initiatiques', 'content' => gbe_intro( 'Récits liés aux parcours d\'initiation et de transmission des savoirs.' ) ),
				array( 'title' => 'Contes merveilleux', 'slug' => 'contes-merveilleux', 'content' => gbe_intro( 'Récits merveilleux et univers fictionnels de la tradition orale.' ) ),
				array( 'title' => 'Contes d\'animaux', 'slug' => 'contes-animaux', 'content' => gbe_intro( 'Fables et récits zoomorphes de la littérature orale gbe.' ) ),
			),
		),
		array(
			'title'   => 'Xó — Traditions lignagères',
			'slug'    => 'xo-traditions-lignageres',
			'content' => gbe_intro( 'Chroniques claniques, généalogies et mémoires lignagères.' ),
		),
		array(
			'title'   => 'Èdù — Messages divinatoires',
			'slug'    => 'edu-messages-divinatoires',
			'content' => gbe_intro( 'Paroles rituelles, messages divinatoires et invocations sacrées.' ),
		),
		array(
			'title'   => 'ɖɛ̀wo — Prières de libation',
			'slug'    => 'dewo-prieres-libation',
			'content' => gbe_intro( 'Prières de libation, bénédictions et invocations ancestrales.' ),
		),
		array(
			'title'    => 'Hàwo — Chants',
			'slug'     => 'havo-chants',
			'content'  => gbe_intro( 'Chants traditionnels, rituels, festifs et de travail.' ),
			'children' => array(
				array( 'title' => 'Tsɔhàwo — Chants funéraires', 'slug' => 'tsohavo-chants-funerailles', 'content' => gbe_intro( 'Chants funéraires et rituels de passage.' ) ),
				array( 'title' => 'Hakɛ — Chants satiriques', 'slug' => 'hake-chants-satiriques', 'content' => gbe_intro( 'Chants satiriques et de dérision sociale.' ) ),
				array( 'title' => 'Hahamelɔ — Chants de dérision', 'slug' => 'hahamelo-chants-derision', 'content' => gbe_intro( 'Formes chantées de critique et de dérision.' ) ),
				array( 'title' => 'Chants rituels', 'slug' => 'chants-rituels', 'content' => gbe_intro( 'Chants associés aux cérémonies et aux cultes.' ) ),
				array( 'title' => 'Chants de travail', 'slug' => 'chants-travail', 'content' => gbe_intro( 'Chants collectifs accompagnant le travail communautaire.' ) ),
				array( 'title' => 'Chants festifs', 'slug' => 'chants-festifs', 'content' => gbe_intro( 'Chants des fêtes, célébrations et événements communautaires.' ) ),
			),
		),
	);
}

/**
 * Onomastics pages.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_onomastique_pages() {
	return array(
		array(
			'title'    => 'Anthroponymie',
			'slug'     => 'anthroponymie',
			'content'  => gbe_intro( 'Étude des noms de personnes dans les cultures gbe.' ),
			'children' => array(
				array( 'title' => 'Prénoms', 'slug' => 'prenoms', 'content' => gbe_intro( 'Prénoms, symbolique et choix onomastique.' ) ),
				array( 'title' => 'Noms lignagers', 'slug' => 'noms-lignagers', 'content' => gbe_intro( 'Noms de famille et identités lignagères.' ) ),
				array( 'title' => 'Noms initiatiques', 'slug' => 'noms-initiatiques', 'content' => gbe_intro( 'Noms reçus au cours des parcours initiatiques.' ) ),
				array( 'title' => 'Noms circonstanciels', 'slug' => 'noms-circonstanciels', 'content' => gbe_intro( 'Noms liés aux circonstances de naissance ou d\'événements.' ) ),
			),
		),
		array(
			'title'    => 'Toponymie',
			'slug'     => 'toponymie',
			'content'  => gbe_intro( 'Noms de lieux, villages, villes et espaces sacrés.' ),
			'children' => array(
				array( 'title' => 'Villages', 'slug' => 'villages', 'content' => gbe_intro( 'Toponymie des villages et localités rurales.' ) ),
				array( 'title' => 'Villes', 'slug' => 'villes', 'content' => gbe_intro( 'Noms urbains et histoire des agglomérations.' ) ),
				array( 'title' => 'Lieux sacrés', 'slug' => 'lieux-sacres', 'content' => gbe_intro( 'Sanctuaires, bosquets sacrés et lieux de culte.' ) ),
				array( 'title' => 'Montagnes', 'slug' => 'montagnes', 'content' => gbe_intro( 'Oroponymie et mémoire des reliefs.' ) ),
				array( 'title' => 'Hydronymie', 'slug' => 'hydronymie', 'content' => gbe_intro( 'Noms de rivières, cours d\'eau et plans d\'eau.' ) ),
			),
		),
		array(
			'title'   => 'Ethnonymie',
			'slug'    => 'ethnonymie',
			'content' => gbe_intro( 'Noms des peuples, groupes et communautés du continuum gbe.' ),
		),
		array(
			'title'   => 'Théonymie',
			'slug'    => 'theonymie',
			'content' => gbe_intro( 'Noms des divinités, entités sacrées et figures du panthéon gbe.' ),
		),
	);
}

/**
 * Digital archives pages under Xótùtù.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_archives_pages() {
	return array(
		array( 'title' => 'Archives sonores', 'slug' => 'archives-sonores', 'content' => gbe_intro( 'Enregistrements audio de la tradition orale gbe.' ) ),
		array( 'title' => 'Archives audiovisuelles', 'slug' => 'archives-audiovisuelles', 'content' => gbe_intro( 'Vidéos, films ethnographiques et témoignages filmés.' ) ),
		array( 'title' => 'Photothèque', 'slug' => 'phototheque', 'content' => gbe_intro( 'Corpus iconographique des cultures et patrimoines gbe.' ) ),
		array( 'title' => 'Corpus textuels', 'slug' => 'corpus-textuels', 'content' => gbe_intro( 'Transcriptions, manuscrits et corpus numérisés.' ) ),
		array( 'title' => 'Documents historiques', 'slug' => 'documents-historiques', 'content' => gbe_intro( 'Sources historiques et archives documentaires.' ) ),
		array(
			'title'   => 'Bibliothèque numérique Xótùtù',
			'slug'    => 'bibliotheque-numerique-xotutu',
			'content' => '<p>Archives audio, vidéo, témoignages, manuscrits et corpus numériques de la tradition orale gbe.</p>[gbe_xotutu_list limit="24"]',
		),
	);
}
