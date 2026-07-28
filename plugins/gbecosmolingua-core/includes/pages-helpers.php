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

/**
 * Sous-pages thématiques pour une rubrique Le Gbe.
 *
 * @param string[] $titles       Titres des sous-thèmes.
 * @param string   $parent_label Contexte (ex. « l'histoire des peuples gbe »).
 * @return array<int, array<string, mixed>>
 */
function gbe_le_gbe_subpages( $titles, $parent_label ) {
	$pages = array();
	foreach ( $titles as $title ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => sanitize_title( $title ),
			'content' => gbe_intro(
				sprintf(
					/* translators: 1: topic title, 2: parent context phrase */
					'Découvrez « %1$s » dans le cadre de %2$s.',
					$title,
					$parent_label
				)
			),
		);
	}
	return $pages;
}

/**
 * Sous-pages thématiques Recherche et Innovation.
 *
 * @param string[] $titles       Titres.
 * @param string   $parent_label Contexte.
 * @return array<int, array<string, mixed>>
 */
function gbe_recherche_subpages( $titles, $parent_label ) {
	$pages = array();
	foreach ( $titles as $title ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => sanitize_title( $title ),
			'content' => gbe_intro(
				sprintf(
					'Découvrez « %1$s » dans le cadre de %2$s.',
					$title,
					$parent_label
				)
			),
		);
	}
	return $pages;
}

/**
 * Arborescence Séjours et Mobilité.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_sejours_mobilite_children() {
	return array(
		array(
			'title'    => 'Immersion linguistique',
			'slug'     => 'immersion-linguistique',
			'content'  => gbe_intro( 'Séjours linguistiques en contexte gbe.' ),
			'children' => gbe_recherche_subpages(
				array( 'Français', 'Éwé', 'Gen/Mina', 'Fon' ),
				'l\'immersion linguistique gbe'
			),
		),
		array(
			'title'    => 'Tourisme culturel',
			'slug'     => 'tourisme-culturel',
			'content'  => gbe_intro( 'Découverte responsable des patrimoines gbe.' ),
			'children' => gbe_recherche_subpages(
				array( 'Circuits patrimoniaux', 'Tourisme communautaire', 'Écotourisme', 'Découverte des terroirs' ),
				'le tourisme culturel gbe'
			),
		),
		array(
			'title'    => 'Mobilité universitaire',
			'slug'     => 'mobilite-universitaire',
			'content'  => gbe_intro( 'Échanges et programmes universitaires.' ),
			'children' => gbe_recherche_subpages(
				array( 'Orientation universitaire', 'Réseaux partenaires', 'Programmes de recherche' ),
				'la mobilité universitaire gbe'
			),
		),
		array(
			'title'   => 'Stages',
			'slug'    => 'stages',
			'content' => gbe_intro( 'Stages de terrain, de recherche et d\'immersion culturelle.' ),
		),
		array(
			'title'   => 'Programmes d\'été',
			'slug'    => 'programmes-ete',
			'content' => gbe_intro( 'Séjours estivaux d\'immersion linguistique et culturelle.' ),
		),
		array(
			'title'   => 'Programmes d\'hiver',
			'slug'    => 'programmes-hiver',
			'content' => gbe_intro( 'Programmes hivernaux d\'échanges et de formation.' ),
		),
	);
}

/**
 * Arborescence Partenaires.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_partenaires_children() {
	return array(
		array(
			'title'    => 'Universités et laboratoires',
			'slug'     => 'universites-laboratoires',
			'content'  => gbe_intro( 'Partenariats académiques et scientifiques.' ),
			'children' => gbe_recherche_subpages(
				array( 'Universités', 'Laboratoires', 'Centres de recherche' ),
				'le réseau universitaire partenaire'
			),
		),
		array(
			'title'   => 'UNESCO',
			'slug'    => 'unesco',
			'content' => gbe_intro( 'Coopération avec l\'UNESCO pour la sauvegarde du patrimoine culturel immatériel.' ),
		),
		array(
			'title'   => 'OIF',
			'slug'    => 'oif',
			'content' => gbe_intro( 'Partenariat avec l\'Organisation internationale de la Francophonie.' ),
		),
		array(
			'title'   => 'CEDEAO et Union africaine',
			'slug'    => 'cedeao-union-africaine',
			'content' => gbe_intro( 'Coopération régionale et panafricaine.' ),
		),
		array(
			'title'    => 'Ambassades et centres culturels',
			'slug'     => 'ambassades-centres-culturels',
			'content'  => gbe_intro( 'Réseau diplomatique et culturel.' ),
			'children' => gbe_recherche_subpages(
				array( 'Ambassades', 'Centres culturels', 'Instituts' ),
				'les partenariats institutionnels'
			),
		),
		array(
			'title'   => 'Fondations',
			'slug'    => 'fondations',
			'content' => gbe_intro( 'Fondations soutenant la recherche et la culture gbe.' ),
		),
		array(
			'title'   => 'Diaspora gbe',
			'slug'    => 'diaspora-gbe',
			'content' => gbe_intro( 'Réseaux de la diaspora gbe et partenariats communautaires.' ),
		),
	);
}

/**
 * Arborescence des pages sous Recherche et Innovation.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_recherche_innovation_children() {
	return array(
		array(
			'title'   => 'Ressources documentaires',
			'slug'    => 'ressources-documentaires',
			'content' => '<p>Bibliothèque numérique, corpus linguistiques et archives scientifiques.</p>[gbe_bibliotheque]',
		),
		array(
			'title'   => 'Activités',
			'slug'    => 'activites',
			'content' => '<p>Colloques, conférences, séminaires et publications de GbeCosmoLingua.</p>[gbe_evenements_list limit="24"]',
		),
		array(
			'title'    => 'Domaines de recherche',
			'slug'     => 'domaines-de-recherche',
			'content'  => gbe_intro( 'Champs disciplinaires et approches interdisciplinaires des études gbe.' ),
			'children' => gbe_recherche_subpages(
				array(
					'Linguistique',
					'Anthropologie',
					'Ethnolinguistique',
					'Paremiologie',
					'Onomastique',
					'Traduction',
					'Interculturalité',
					'Humanités numériques',
				),
				'les domaines de recherche gbe'
			),
		),
		array(
			'title'   => 'Humanités numériques',
			'slug'    => 'humanites-numeriques',
			'content' => gbe_intro( 'Corpus numériques, outils de recherche et méthodes des humanités numériques appliquées aux patrimoines gbe.' ),
		),
		array(
			'title'   => 'Observatoire documentaire',
			'slug'    => 'observatoire-documentaire',
			'content' => gbe_intro( 'Veille scientifique, base documentaire et ressources pour la recherche sur les langues et cultures gbe.' ),
		),
	);
}

/**
 * Sous-pages thématiques Paremiologie.
 *
 * @param string[] $titles       Titres.
 * @param string   $parent_label Contexte.
 * @return array<int, array<string, mixed>>
 */
function gbe_paremiologie_subpages( $titles, $parent_label ) {
	$pages = array();
	foreach ( $titles as $title ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => sanitize_title( $title ),
			'content' => gbe_intro(
				sprintf(
					'Découvrez « %1$s » dans le cadre de %2$s.',
					$title,
					$parent_label
				)
			),
		);
	}
	return $pages;
}

/**
 * Arborescence des pages sous Paremiologie.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_paremiologie_children() {
	return array(
		array(
			'title'   => 'Banque numérique de proverbes',
			'slug'    => 'banque-numerique-proverbes',
			'content' => '<p>Pour chaque proverbe : texte original, transcription, traductions, contexte, commentaire culturel et analyses.</p>[gbe_proverbes_list limit="24"]',
		),
		array(
			'title'    => 'Corpus éwé',
			'slug'     => 'corpus-ewe',
			'content'  => gbe_intro( 'Corpus paremiologique éwé : lododowo, dictons et formules sapientielles.' ),
			'children' => gbe_paremiologie_subpages(
				array( 'Lododowo', 'Dzu lododowo', 'Hake', 'Halo hamelo' ),
				'le corpus paremiologique éwé'
			),
		),
		array(
			'title'    => 'Corpus Gen/Mina',
			'slug'     => 'corpus-gen-mina',
			'content'  => gbe_intro( 'Proverbes et expressions sentencieuses de la variété gen (mina).' ),
			'children' => gbe_paremiologie_subpages(
				array( 'Proverbes gen', 'Expressions sentencieuses', 'Traditions sapientielles' ),
				'le corpus paremiologique gen/mina'
			),
		),
		array(
			'title'    => 'Corpus fon',
			'slug'     => 'corpus-fon',
			'content'  => gbe_intro( 'Corpus paremiologique fon.' ),
			'children' => gbe_paremiologie_subpages(
				array( 'Proverbes fon', 'Formules proverbiales' ),
				'le corpus paremiologique fon'
			),
		),
		array(
			'title'   => 'Corpus aja',
			'slug'    => 'corpus-aja',
			'content' => gbe_intro( 'Corpus paremiologique de la variété aja.' ),
		),
		array(
			'title'   => 'Corpus gun',
			'slug'    => 'corpus-gun',
			'content' => gbe_intro( 'Corpus paremiologique de la variété gun.' ),
		),
		array(
			'title'    => 'Comparaisons interculturelles',
			'slug'     => 'comparaisons-interculturelles',
			'content'  => gbe_intro( 'Paremiologie comparée entre les traditions gbe et d\'autres aires linguistiques.' ),
			'children' => gbe_paremiologie_subpages(
				array( 'Gbe – Français', 'Gbe – Espagnol', 'Gbe – Russe', 'Gbe – Anglais' ),
				'les comparaisons interculturelles paremiologiques'
			),
		),
		array(
			'title'    => 'Axes de recherche',
			'slug'     => 'axes-de-recherche',
			'content'  => gbe_intro( 'Thématiques et programmes de recherche en paremiologie gbe.' ),
			'children' => gbe_paremiologie_subpages(
				array(
					'Paremiologie comparée',
					'Cosmovisions',
					'Imaginaires culturels',
					'Traduction des proverbes',
					'Paremacie interculturelle',
				),
				'les axes de recherche paremiologique'
			),
		),
	);
}

/**
 * Arborescence des pages sous Le Gbe (hub et menu principal).
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_le_gbe_children() {
	return array(
		array(
			'title'   => 'Bibliothèque',
			'slug'    => 'bibliotheque-linguistique',
			'content' => '<p>Bibliothèque numérique des langues et patrimoines gbe.</p>[gbe_bibliotheque]',
		),
		array(
			'title'   => 'Carte interactive',
			'slug'    => 'carte-interactive',
			'content' => '<p>Explorez la répartition géographique des langues gbe, les zones culturelles, les routes migratoires historiques et les centres patrimoniaux.</p>[gbe_carte_interactive]',
		),
		array(
			'title'   => 'Corpus numériques',
			'slug'    => 'corpus-numeriques',
			'content' => gbe_intro( 'Accédez aux corpus numériques de GbeCosmoLingua : proverbes, archives orales et ressources documentaires.' ) .
				'<p><a href="/paremiologie/banque-numerique-proverbes/">Banque de proverbes</a> · <a href="/xotutu/bibliotheque-numerique-xotutu/">Archives Xótùtù</a> · <a href="/recherche-et-innovation/ressources-documentaires/">Bibliothèque numérique</a></p>',
		),
		array(
			'title'    => 'Histoire et migrations',
			'slug'     => 'histoire-et-migrations',
			'content'  => gbe_intro( 'Récits fondateurs, royaumes précoloniaux et circulations des peuples gbe à travers l\'Afrique de l\'Ouest.' ),
			'children' => array(
				array(
					'title'    => 'Les récits fondateurs',
					'slug'     => 'les-recits-fondateurs',
					'content'  => gbe_intro( 'Origines mythiques et mémoires collectives des peuples du continuum gbe.' ),
					'children' => gbe_le_gbe_subpages(
						array(
							'Origines des peuples gbe',
							'Notsé dans la mémoire collective',
							'Traditions migratoires',
							'Mythes et récits d\'origine',
						),
						'les récits fondateurs'
					),
				),
				array(
					'title'    => 'Royaumes et formations politiques',
					'slug'     => 'royaumes-et-formations-politiques',
					'content'  => gbe_intro( 'Organisations politiques et chefferies avant et pendant la colonisation.' ),
					'children' => gbe_le_gbe_subpages(
						array(
							'Royaumes précoloniaux',
							'Chefferies traditionnelles',
							'Organisation sociale et politique',
						),
						'les royaumes et formations politiques gbe'
					),
				),
				array(
					'title'    => 'Migrations et échanges',
					'slug'     => 'migrations-et-echanges',
					'content'  => gbe_intro( 'Mobilités, réseaux commerciaux et contacts interculturels.' ),
					'children' => gbe_le_gbe_subpages(
						array(
							'Relations interethniques',
							'Réseaux commerciaux',
							'Influences culturelles régionales',
						),
						'les migrations et échanges gbe'
					),
				),
			),
		),
		array(
			'title'    => 'Le continuum gbe',
			'slug'     => 'le-continuum-gbe',
			'content'  => gbe_intro( 'Unité linguistique, variétés principales et aires géographiques du continuum gbe.' ),
			'children' => array(
				array(
					'title'   => 'Variétés principales',
					'slug'    => 'varietes-principales',
					'content' => gbe_intro( 'Panorama des variétés majeures et de leur intercompréhension au sein du continuum.' ) .
						gbe_outline(
							array(
								'Éwé',
								'Gen (Mina)',
								'Fon',
								'Aja',
								'Gun',
								'Waci',
								'Xwela',
								'Xwla',
								'Phla-Phera',
								'Autres variétés du continuum',
							)
						) .
						'<p><a href="/le-gbe/les-langues/">Explorer les fiches langues →</a></p>',
				),
				array(
					'title'    => 'Pays et territoires',
					'slug'     => 'pays-et-territoires',
					'content'  => gbe_intro( 'Répartition du continuum au Togo, au Bénin, au Ghana et au Nigeria.' ),
					'children' => gbe_le_gbe_subpages(
						array( 'Togo', 'Bénin', 'Ghana', 'Nigeria' ),
						'les pays et territoires du continuum gbe'
					),
				),
			),
		),
		array(
			'title'    => 'Les langues',
			'slug'     => 'les-langues',
			'content'  => gbe_intro( 'Documentation des variétés principales du continuum gbe.' ),
			'children' => gbe_get_langue_pages(),
		),
		array(
			'title'    => 'Linguistique',
			'slug'     => 'linguistique',
			'content'  => gbe_intro( 'Ressources linguistiques pour l\'étude scientifique des variétés gbe.' ),
			'children' => gbe_get_linguistique_pages(),
		),
		array(
			'title'   => 'Présentation générale',
			'slug'    => 'presentation-generale',
			'content' => gbe_intro( 'Le gbe : une langue, plusieurs variétés. Présentation du continuum linguistique et de sa vitalité contemporaine.' ),
		),
		array(
			'title'   => 'Peuples du continuum',
			'slug'    => 'peuples-du-continuum',
			'content' => gbe_intro( 'Les peuples gbe partagent une histoire, des traditions et des systèmes de pensée communs, tout en présentant une riche diversité culturelle et linguistique.' ) .
				gbe_outline(
					array(
						'Identités et ethnonymes',
						'Organisation sociale',
						'Chefferies et royaumes',
						'Diaspora gbe',
						'Vitalité culturelle contemporaine',
					)
				),
		),
	);
}

function gbe_culture_subpages( $titles, $parent_label ) {
	$pages = array();
	foreach ( $titles as $title ) {
		$pages[] = array(
			'title'   => $title,
			'slug'    => sanitize_title( $title ),
			'content' => gbe_intro(
				sprintf(
					/* translators: 1: topic title, 2: parent context phrase */
					'Découvrez « %1$s » dans le cadre de %2$s au sein des cultures gbe.',
					$title,
					$parent_label
				)
			),
		);
	}
	return $pages;
}

/**
 * Rubriques et sous-pages du hub Cultures Gbe.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_cultures_gbe_children() {
	return array(
		array(
			'title'    => 'Architecture',
			'slug'     => 'architecture',
			'content'  => gbe_intro( 'Architecture vernaculaire, habitat traditionnel et espaces sacrés des peuples gbe.' ),
			'children' => gbe_culture_subpages(
				array( 'Architecture vernaculaire', 'Habitat traditionnel', 'Espaces sacrés' ),
				"l'architecture gbe"
			),
		),
		array(
			'title'    => 'Artisanat',
			'slug'     => 'artisanat',
			'content'  => gbe_intro( 'Techniques artisanales et savoir-faire traditionnels des peuples gbe.' ),
			'children' => gbe_culture_subpages(
				array( 'Techniques artisanales', 'Savoir-faire traditionnels', 'Transmission intergénérationnelle' ),
				"l'artisanat gbe"
			),
		),
		array(
			'title'    => 'Arts',
			'slug'     => 'arts',
			'content'  => gbe_intro( 'Sculpture, artisanat, tissage, poterie et arts décoratifs.' ),
			'children' => gbe_culture_subpages(
				array( 'Sculpture', 'Artisanat', 'Tissage', 'Poterie', 'Arts décoratifs' ),
				'les arts gbe'
			),
		),
		array(
			'title'    => 'Croyances et cosmologies',
			'slug'     => 'croyances-et-cosmologies',
			'content'  => gbe_intro( 'Spiritualités, cultes et représentations du monde dans les cultures gbe.' ),
			'children' => gbe_culture_subpages(
				array(
					'Vodun',
					'Cultes ancestraux',
					'Cosmologies africaines',
					'Religions et spiritualités',
					'Symboles et représentations',
				),
				'les croyances et cosmologies gbe'
			),
		),
		array(
			'title'    => 'Danse',
			'slug'     => 'danse',
			'content'  => gbe_intro( 'Danses cérémonielles, festives et rituelles — expression du corps et de la mémoire collective.' ),
			'children' => gbe_culture_subpages(
				array( 'Danses cérémonielles', 'Danses festives', 'Danses rituelles' ),
				'la danse gbe'
			),
		),
		array(
			'title'    => 'Fêtes et cérémonies',
			'slug'     => 'fetes-et-ceremonies',
			'content'  => gbe_intro( 'Rites de passage et célébrations communautaires.' ),
			'children' => gbe_culture_subpages(
				array( 'Naissance', 'Initiation', 'Mariage', 'Funérailles', 'Fêtes communautaires' ),
				'les fêtes et cérémonies gbe'
			),
		),
		array(
			'title'    => 'Gastronomie',
			'slug'     => 'gastronomie',
			'content'  => gbe_intro( 'Cuisine traditionnelle et patrimoine alimentaire.' ),
			'children' => gbe_culture_subpages(
				array( 'Cuisine traditionnelle', 'Produits du terroir', 'Patrimoine alimentaire' ),
				'la gastronomie gbe'
			),
		),
		array(
			'title'    => 'Musique',
			'slug'     => 'musique',
			'content'  => gbe_intro( 'Chants, musiques rituelles et instruments — la dimension sonore du patrimoine gbe.' ),
			'children' => gbe_culture_subpages(
				array( 'Chants traditionnels', 'Musiques rituelles', 'Instruments de musique' ),
				'la musique gbe'
			),
		),
		array(
			'title'    => 'Savoirs endogènes',
			'slug'     => 'savoirs-endogenes',
			'content'  => gbe_intro( 'Médecine, pharmacopée, agriculture et savoirs écologiques locaux.' ),
			'children' => gbe_culture_subpages(
				array(
					'Médecine traditionnelle',
					'Pharmacopée',
					'Agriculture traditionnelle',
					'Gestion de l\'environnement',
					'Techniques artisanales',
				),
				'les savoirs endogènes gbe'
			),
		),
		array(
			'title'    => 'Patrimoines matériels',
			'slug'     => 'patrimoines-materiels',
			'content'  => gbe_intro( 'Sites, monuments, objets et témoignages matériels des cultures gbe.' ),
			'children' => gbe_culture_subpages(
				array( 'Sites et monuments', 'Objets patrimoniaux', 'Conservation et restauration' ),
				'le patrimoine matériel gbe'
			),
		),
		array(
			'title'    => 'Patrimoines immatériels',
			'slug'     => 'patrimoines-immateriels',
			'content'  => gbe_intro( 'Traditions orales, savoir-faire, rituels et expressions vivantes.' ),
			'children' => gbe_culture_subpages(
				array( 'Traditions orales', 'Savoir-faire', 'Rituels et pratiques vivantes' ),
				'le patrimoine immatériel gbe'
			),
		),
	);
}
