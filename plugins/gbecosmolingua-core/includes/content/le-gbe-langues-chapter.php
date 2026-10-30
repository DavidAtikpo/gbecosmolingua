<?php
/**
 * Contenu éditorial — fiches langues du continuum (UI chapitre).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Slugs des fiches langues utilisant le rendu chapitre générique.
 *
 * @return string[]
 */
function gbe_le_gbe_langue_chapter_slugs() {
	return array(
		'ewe',
		'gen-mina',
		'gun',
		'waci',
		'xwela',
		'xwla',
		'phla-phera',
		'autres-varietes',
	);
}

/**
 * Navigation in-page standard des fiches langues.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_langue_chapter_nav() {
	return array(
		array(
			'id'    => 'presentation',
			'label' => __( 'Présentation', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'aire',
			'label' => __( 'Aire', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'phonologie',
			'label' => __( 'Phonologie', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'ecriture',
			'label' => __( 'Écriture', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'travaux',
			'label' => __( 'Travaux', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Clé de section dialectologique à partir du libellé meta.
 *
 * @param string $section Libellé section.
 * @return string|null
 */
function gbe_le_gbe_langue_section_key( $section ) {
	$map = array(
		'Dialectes Vhe'        => 'vhe',
		'Dialectes Gen'        => 'gen',
		'Dialectes Fon'       => 'fon',
		'Dialectes Ajé'        => 'aje',
		'Dialectes Phla-Phera' => 'phla_phera',
	);
	return $map[ $section ] ?? null;
}

/**
 * Innovations phonologiques pour une clé de section.
 *
 * @param string|null $key Clé section.
 * @return string[]
 */
function gbe_le_gbe_langue_innovations( $key ) {
	switch ( $key ) {
		case 'vhe':
			return gbe_le_gbe_innovations_vhe();
		case 'gen':
			return gbe_le_gbe_innovations_gen();
		case 'fon':
			return gbe_le_gbe_innovations_fono();
		case 'aje':
			return gbe_le_gbe_innovations_aje();
		case 'phla_phera':
			return gbe_le_gbe_innovations_phla_phera();
		default:
			return array();
	}
}

/**
 * Ancre regroupement dialectologique pour une clé de section.
 *
 * @param string|null $key Clé section.
 * @return string
 */
function gbe_le_gbe_langue_regroupement_anchor( $key ) {
	$anchors = array(
		'vhe'        => 'vhe',
		'gen'        => 'gen',
		'fon'       => 'fon',
		'aje'        => 'aje',
		'phla_phera' => 'phla-phera',
	);
	if ( ! $key || ! isset( $anchors[ $key ] ) ) {
		return '/le-gbe/le-continuum-gbe/regroupement-des-parlers/';
	}
	return '/le-gbe/le-continuum-gbe/regroupement-des-parlers/#' . $anchors[ $key ];
}

/**
 * Configurations enrichies par fiche langue.
 *
 * @return array<string, array<string, mixed>>
 */
function gbe_le_gbe_langue_chapter_configs() {
	return array(
		'ewe' => array(
			'source'  => __( 'Fiche langue — Éwé (section Vhe). Voir inventaire et ch. 9.', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Vhe', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
				array( 'value' => '82–96%', 'label' => __( 'Swadesh (ch. 9)', 'gbecosmolingua-core' ) ),
				array( 'value' => '1910', 'label' => __( 'Dictionnaire Westermann', 'gbecosmolingua-core' ) ),
				array( 'value' => '2', 'label' => __( 'Pays (Ghana, Togo)', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Vhe (Éwé)', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Awlan',
					'title' => __( 'Base standard', 'gbecosmolingua-core' ),
					'body'  => __( 'L’Éwé écrit repose sur Awlan (Anlo, Ghana) et parlers voisins — dialecte prestigieux de référence.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1910',
					'title' => 'D. Westermann',
					'body'  => __( 'Dictionnaire de la langue Éwé — fondation lexicographique majeure du continuum.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1975',
					'title' => __( 'Alphabétisation', 'gbecosmolingua-core' ),
					'body'  => __( 'Graphie standard, dictionnaires (Adornu & Ardzena 1975), littérature religieuse et didactique.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '1910',
					'title' => 'D. Westermann',
					'body'  => __( 'Dictionnaire de la langue Éwé — référence lexicographique historique.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1975',
					'title' => 'Adornu & Ardzena',
					'body'  => __( 'Dictionnaire éwé–français — outil didactique et lexicographique moderne.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1976',
					'title' => 'R. Pazzi',
					'body'  => __( 'Comparaison lexicale inter-sections — Éwé au cœur du continuum gbe.', 'gbecosmolingua-core' ),
				),
			),
			'timeline' => array(
				array(
					'year'   => '1910',
					'author' => 'D. Westermann',
					'title'  => __( 'Dictionnaire de la langue Éwé', 'gbecosmolingua-core' ),
				),
				array(
					'year'   => '1975',
					'author' => 'Adornu & Ardzena',
					'title'  => __( 'Dictionnaire éwé–français', 'gbecosmolingua-core' ),
				),
				array(
					'year'   => '—',
					'author' => __( 'Académie de la langue Éwé', 'gbecosmolingua-core' ),
					'title'  => __( 'Normalisation et enseignement — Togo et Ghana', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/paremiologie/banque-numerique-proverbes/',
					'label' => __( 'Corpus paremiologique Éwé', 'gbecosmolingua-core' ),
				),
			),
		),
		'gen-mina' => array(
			'source'  => __( 'Fiche langue — Gen (section Gen). Voir regroupement (ch. 7) et langue unique (ch. 9).', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Gen', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
				array( 'value' => '3', 'label' => __( 'Parlers (Gliji, Agói, Anéxo)', 'gbecosmolingua-core' ) ),
				array( 'value' => '96%', 'label' => __( 'Swadesh avec Éwé/Aja', 'gbecosmolingua-core' ) ),
				array( 'value' => '1981', 'label' => __( 'Dictionnaire Pazzi', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Gen', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Gliji',
					'title' => __( 'Parler de référence', 'gbecosmolingua-core' ),
					'body'  => __( 'Le Gen écrit s’appuie sur Gliji et parlers voisins — base de la standardisation graphique.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1981',
					'title' => 'R. Pazzi',
					'body'  => __( 'Dictionnaire mina–français — ouvrage de référence pour la section Gen.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1975',
					'title' => __( 'Syllabaire', 'gbecosmolingua-core' ),
					'body'  => __( 'Alphabétisation et littérature religieuse en Gen depuis la campagne nationale.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '1981',
					'title' => 'R. Pazzi',
					'body'  => __( 'Dictionnaire mina–français — lexicographie de référence du Gen.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1976',
					'title' => 'R. Pazzi',
					'body'  => __( 'L’homme, le Bénin, Fon et son univers — comparaison inter-sections.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '—',
					'title' => __( 'Pazzi & Agban', 'gbecosmolingua-core' ),
					'body'  => __( 'Recueil de proverbes Gen/Mina — corpus paremiologique de référence.', 'gbecosmolingua-core' ),
				),
			),
			'timeline' => array(
				array(
					'year'   => '1976',
					'author' => 'R. Pazzi',
					'title'  => __( 'Monographie comparative du continuum gbe', 'gbecosmolingua-core' ),
				),
				array(
					'year'   => '1981',
					'author' => 'R. Pazzi',
					'title'  => __( 'Dictionnaire mina–français', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/paremiologie/banque-numerique-proverbes/',
					'label' => __( 'Proverbes Gen/Mina', 'gbecosmolingua-core' ),
				),
			),
		),
		'gun' => array(
			'source'  => __( 'Fiche langue — Gun (section Fon). Voir inventaire et regroupement.', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Fon', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
				array( 'value' => '1975', 'label' => __( 'Syllabaire (campagne)', 'gbecosmolingua-core' ) ),
				array( 'value' => '2', 'label' => __( 'Pays (Bénin, Nigeria)', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Gun', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Gun',
					'title' => __( 'Graphie propre', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire Gun et ouvrages de référence — coexiste avec le Fon écrit au Bénin.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => 'Fon',
					'title' => __( 'Parenté linguistique', 'gbecosmolingua-core' ),
					'body'  => __( 'Innovations phonologiques communes avec Kpase et Agbome — section Fon du continuum.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '1976',
					'title' => 'R. Pazzi',
					'body'  => __( 'Distinction sociologique Gun/Fon dans la cartographie dialectologique.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1975',
					'title' => __( 'Alphabétisation', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire Gun produit lors de la campagne nationale d’alphabétisation.', 'gbecosmolingua-core' ),
				),
			),
			'timeline' => array(
				array(
					'year'   => '1975',
					'author' => __( 'CENALA / campagne nationale', 'gbecosmolingua-core' ),
					'title'  => __( 'Syllabaire Gun — Porto-Novo et lagune', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/le-gbe/les-langues/fon/',
					'label' => __( 'Fiche Fon (voisin)', 'gbecosmolingua-core' ),
				),
			),
		),
		'waci' => array(
			'source'  => __( 'Fiche langue — Waci (section Vhe). Parlé des deux côtés du Mono (ch. 9).', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Vhe', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
				array( 'value' => '2', 'label' => __( 'Pays (Togo, Bénin)', 'gbecosmolingua-core' ) ),
				array( 'value' => 'Mono', 'label' => __( 'Frontière fluviale', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Waci', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Waci',
					'title' => __( 'Orthographe propre', 'gbecosmolingua-core' ),
					'body'  => __( 'Système orthographique distinct de l’Éwé standard — ouvrages descriptifs dédiés.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => 'Vhe',
					'title' => __( 'Section dialectale', 'gbecosmolingua-core' ),
					'body'  => __( 'Le Waci écrit coexiste dans la même section que l’Éwé — Awlan reste la référence occidentale.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '—',
					'title' => __( 'Ouvrages descriptifs', 'gbecosmolingua-core' ),
					'body'  => __( 'Wacigbe transfrontalier — Kômé (Bénin) et Aného (Togo).', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/le-gbe/les-langues/ewe/',
					'label' => __( 'Fiche Éwé (section Vhe)', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/les-langues/aja/',
					'label' => __( 'Fiche Aja (voisin)', 'gbecosmolingua-core' ),
				),
			),
		),
		'xwela' => array(
			'source'  => __( 'Fiche langue — Phelé/Xwela (Phla-Phera). Voir inventaire.', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Phla-Phera', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
				array( 'value' => '1975', 'label' => __( 'Syllabaire (campagne)', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Phelé (Xwela)', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Phelé',
					'title' => __( 'Variété de référence', 'gbecosmolingua-core' ),
					'body'  => __( 'Le Phelé (Xwela) est la forme côtière principale — graphie en cours d’élaboration.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => '1975',
					'title' => __( 'Alphabétisation', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire produit lors de la campagne nationale — consolidation en cours.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '1976',
					'title' => 'R. Pazzi',
					'body'  => __( 'Langue Xwela — cartographie dialectologique Phla-Phera.', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/le-gbe/les-langues/xwla/',
					'label' => __( 'Fiche Xwla (Phla)', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/les-langues/phla-phera/',
					'label' => __( 'Groupe Phla-Phera', 'gbecosmolingua-core' ),
				),
			),
		),
		'xwla' => array(
			'source'  => __( 'Fiche langue — Phla/Xwla (Phla-Phera). Voir inventaire.', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Phla-Phera', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Phla (Xwla)', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Phla',
					'title' => __( 'Forme écrite', 'gbecosmolingua-core' ),
					'body'  => __( 'Standardisation graphique en cours — proximité phonologique avec le Phelé.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '—',
					'title' => __( 'Études comparatives', 'gbecosmolingua-core' ),
					'body'  => __( 'Travaux dialectologiques Phla/Phelé — innovations et préfixes nominaux.', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/le-gbe/les-langues/xwela/',
					'label' => __( 'Fiche Xwela (Phelé)', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/les-langues/phla-phera/',
					'label' => __( 'Groupe Phla-Phera', 'gbecosmolingua-core' ),
				),
			),
		),
		'phla-phera' => array(
			'source'  => __( 'Fiche langue — Phla-Phera (section v). Voir regroupement (ch. 7).', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => 'Phla-Phera', 'label' => __( 'Section dialectale', 'gbecosmolingua-core' ) ),
				array( 'value' => '1975', 'label' => __( 'Syllabaires (campagne)', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers Phla-Phera', 'gbecosmolingua-core' ),
			'ecriture_cards' => array(
				array(
					'tag'   => 'Ayizo',
					'title' => __( 'Graphie développée', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire Ayizo depuis 1975 — l’une des formes écrites les plus avancées du groupe.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => 'Kotafon',
					'title' => __( 'Alphabétisation', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire Kotafon — ouvrages de référence en cours de consolidation.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => 'Saxwe',
					'title' => __( 'Corpus écrit', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire Saxwe — littérature religieuse et didactique.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '1976',
					'title' => 'R. Pazzi',
					'body'  => __( 'Cartographie des langues Ayizo, Saxwe, Xwela — au-delà du label Phla-Phera.', 'gbecosmolingua-core' ),
				),
			),
			'footer_extra' => array(
				array(
					'url'   => '/le-gbe/les-langues/xwela/',
					'label' => __( 'Fiche Xwela', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/les-langues/xwla/',
					'label' => __( 'Fiche Xwla', 'gbecosmolingua-core' ),
				),
			),
		),
		'autres-varietes' => array(
			'source'  => __( 'Autres parlers du continuum — voir inventaire (ch. 1).', 'gbecosmolingua-core' ),
			'stats'   => array(
				array( 'value' => '~50', 'label' => __( 'Parlers inventoriés', 'gbecosmolingua-core' ) ),
				array( 'value' => '4', 'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ) ),
			),
			'panel_title' => __( 'Parlers divers', 'gbecosmolingua-core' ),
			'skip_phonologie' => true,
			'ecriture_cards' => array(
				array(
					'tag'   => 'Ifè',
					'title' => __( 'Parler distinct', 'gbecosmolingua-core' ),
					'body'  => __( 'Parler gbe du nord-est béninois — syllabaire et projets graphiques.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => 'Saxwe',
					'title' => __( 'Graphie', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire depuis 1975 — groupe Phla-Phera selon Pazzi.', 'gbecosmolingua-core' ),
				),
				array(
					'tag'   => 'Kotafon',
					'title' => __( 'Alphabétisation', 'gbecosmolingua-core' ),
					'body'  => __( 'Syllabaire Kotafon — ouvrages de référence en cours.', 'gbecosmolingua-core' ),
				),
			),
			'travaux_cards' => array(
				array(
					'tag'   => '—',
					'title' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
					'body'  => __( 'Cinquante parlers recensés — territoire, locuteurs et diversité dialectale.', 'gbecosmolingua-core' ),
				),
			),
			'fiches_links' => true,
			'footer_extra' => array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire complet', 'gbecosmolingua-core' ),
				),
			),
		),
	);
}

/**
 * Libellé de section pour le pied de page regroupement.
 *
 * @param string|null $key Clé section.
 * @return string
 */
function gbe_le_gbe_langue_regroupement_label( $key ) {
	$labels = array(
		'vhe'        => __( 'Section Vhe (regroupement)', 'gbecosmolingua-core' ),
		'gen'        => __( 'Section Gen (regroupement)', 'gbecosmolingua-core' ),
		'fon'       => __( 'Section Fon (regroupement)', 'gbecosmolingua-core' ),
		'aje'        => __( 'Section Ajé (regroupement)', 'gbecosmolingua-core' ),
		'phla_phera' => __( 'Groupe Phla-Phera (regroupement)', 'gbecosmolingua-core' ),
	);
	if ( ! $key || ! isset( $labels[ $key ] ) ) {
		return __( 'Regroupement dialectologique', 'gbecosmolingua-core' );
	}
	return $labels[ $key ];
}

/**
 * Rendu chapitre générique d’une fiche langue.
 *
 * @param string $slug Slug de la fiche.
 * @return string
 */
function gbe_le_gbe_langue_chapter_content( $slug ) {
	$meta_all = gbe_le_gbe_langue_meta();
	$configs  = gbe_le_gbe_langue_chapter_configs();

	if ( ! isset( $meta_all[ $slug ], $configs[ $slug ] ) ) {
		return gbe_le_gbe_langue_page_content( $slug );
	}

	$meta   = $meta_all[ $slug ];
	$config = $configs[ $slug ];
	$key    = gbe_le_gbe_langue_section_key( $meta['section'] );
	$code   = preg_replace( '/^Dialectes /', '', $meta['section'] );
	if ( 'Autres parlers' === $meta['section'] ) {
		$code = __( 'Divers', 'gbecosmolingua-core' );
	}

	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php echo esc_html( $config['source'] ); ?></em></p>

		<?php
		echo gbe_chapter_stats( $config['stats'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_langue_chapter_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php echo esc_html( $meta['intro'] ); ?></p>
			<?php if ( ! empty( $config['callout'] ) ) : ?>
				<div class="gbe-chapter-callout">
					<p><?php echo esc_html( $config['callout'] ); ?></p>
				</div>
			<?php endif; ?>
		</section>

		<section id="aire" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Aire et parlers', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['area'] ); ?></p>
			<?php
			if ( ! empty( $meta['parlers'] ) ) {
				echo gbe_chapter_parler_panels( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					array(
						array(
							'code'    => $code,
							'title'   => $config['panel_title'],
							'parlers' => $meta['parlers'],
						),
					)
				);
			}
			if ( ! empty( $config['area_extra'] ) ) {
				echo '<p>' . esc_html( $config['area_extra'] ) . '</p>';
			}
			if ( ! empty( $config['fiches_links'] ) && function_exists( 'gbe_le_gbe_varietes_fiches_links' ) ) {
				echo gbe_chapter_country_link_cards( gbe_le_gbe_varietes_fiches_links() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</section>

		<?php if ( empty( $config['skip_phonologie'] ) && $key ) : ?>
			<section id="phonologie" class="gbe-chapter-section">
				<h2><?php esc_html_e( 'Phonologie et section dialectale', 'gbecosmolingua-core' ); ?></h2>
				<?php if ( ! empty( $meta['notes'] ) ) : ?>
					<p><?php echo esc_html( $meta['notes'] ); ?></p>
				<?php endif; ?>
				<h3><?php echo esc_html( sprintf( __( 'Innovations phonologiques — %s', 'gbecosmolingua-core' ), $code ) ); ?></h3>
				<?php echo gbe_chapter_list( gbe_le_gbe_langue_innovations( $key ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</section>
		<?php elseif ( ! empty( $meta['notes'] ) ) : ?>
			<section id="phonologie" class="gbe-chapter-section">
				<h2><?php esc_html_e( 'Notes dialectologiques', 'gbecosmolingua-core' ); ?></h2>
				<p><?php echo esc_html( $meta['notes'] ); ?></p>
			</section>
		<?php endif; ?>

		<section id="ecriture" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Forme écrite', 'gbecosmolingua-core' ); ?></h2>
			<?php if ( ! empty( $meta['ecrit'] ) ) : ?>
				<p><?php echo esc_html( $meta['ecrit'] ); ?></p>
			<?php endif; ?>
			<?php
			if ( ! empty( $config['ecriture_cards'] ) ) {
				echo gbe_chapter_ref_cards( $config['ecriture_cards'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</section>

		<section id="travaux" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Travaux de référence', 'gbecosmolingua-core' ); ?></h2>
			<?php
			if ( ! empty( $config['travaux_cards'] ) ) {
				echo gbe_chapter_ref_cards( $config['travaux_cards'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			if ( ! empty( $config['timeline'] ) ) {
				echo gbe_chapter_timeline( $config['timeline'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</section>

		<?php
		$footer = array(
			array(
				'url'   => gbe_le_gbe_langue_regroupement_anchor( $key ),
				'label' => gbe_le_gbe_langue_regroupement_label( $key ),
			),
			array(
				'url'   => '/le-gbe/le-continuum-gbe/varietes-principales/',
				'label' => __( 'Variétés principales', 'gbecosmolingua-core' ),
			),
			array(
				'url'   => '/le-gbe/linguistique/travaux-scientifiques-recents/',
				'label' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ),
			),
		);
		if ( ! empty( $config['footer_extra'] ) ) {
			$footer = array_merge( $footer, $config['footer_extra'] );
		}
		echo gbe_chapter_footer_links( $footer ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Callbacks runtime par slug (wrappers fins).
 */
function gbe_le_gbe_ewe_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'ewe' );
}

function gbe_le_gbe_gen_mina_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'gen-mina' );
}

function gbe_le_gbe_gun_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'gun' );
}

function gbe_le_gbe_waci_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'waci' );
}

function gbe_le_gbe_xwela_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'xwela' );
}

function gbe_le_gbe_xwla_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'xwla' );
}

function gbe_le_gbe_phla_phera_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'phla-phera' );
}

function gbe_le_gbe_autres_varietes_langue_content() {
	return gbe_le_gbe_langue_chapter_content( 'autres-varietes' );
}

/**
 * Map URI → callback pour les fiches langues chapitre.
 *
 * @return array<string, string>
 */
function gbe_le_gbe_langue_chapter_callbacks() {
	return array(
		'le-gbe/les-langues/aja'             => 'gbe_le_gbe_aja_langue_content',
		'le-gbe/les-langues/ewe'             => 'gbe_le_gbe_ewe_langue_content',
		'le-gbe/les-langues/gen-mina'        => 'gbe_le_gbe_gen_mina_langue_content',
		'le-gbe/les-langues/fon'             => 'gbe_le_gbe_fon_langue_content',
		'le-gbe/les-langues/gun'             => 'gbe_le_gbe_gun_langue_content',
		'le-gbe/les-langues/waci'            => 'gbe_le_gbe_waci_langue_content',
		'le-gbe/les-langues/xwela'           => 'gbe_le_gbe_xwela_langue_content',
		'le-gbe/les-langues/xwla'            => 'gbe_le_gbe_xwla_langue_content',
		'le-gbe/les-langues/phla-phera'      => 'gbe_le_gbe_phla_phera_langue_content',
		'le-gbe/les-langues/autres-varietes' => 'gbe_le_gbe_autres_varietes_langue_content',
	);
}
