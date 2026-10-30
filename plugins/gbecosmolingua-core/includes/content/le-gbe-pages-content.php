<?php
/**
 * Contenu éditorial — pages hub « Gbe » (synthèse des chapitres intégrés).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Liens de navigation entre les pages clés du continuum.
 *
 * @return string
 */
function gbe_le_gbe_nav_links() {
	$links = array(
		'/le-gbe/le-continuum-gbe/inventaire-des-parlers/' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
		'/le-gbe/le-continuum-gbe/regroupement-des-parlers/' => __( 'Regroupement dialectologique', 'gbecosmolingua-core' ),
		'/le-gbe/le-continuum-gbe/langue-unique/'           => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
		'/le-gbe/le-continuum-gbe/varietes-principales/'    => __( 'Variétés principales', 'gbecosmolingua-core' ),
		'/le-gbe/linguistique/dialectologie/'               => __( 'Dialectologie', 'gbecosmolingua-core' ),
	);

	$out = array();
	foreach ( $links as $url => $label ) {
		$out[] = '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
	}

	return '<p>' . implode( ' · ', $out ) . '</p>';
}

/**
 * Page racine « Gbe » — voir le-gbe-main-hubs.php.
 */

/**
 * Page parent « Le continuum gbe » — voir le-gbe-continuum-hub.php.
 */

/**
 * Page « Variétés principales » — voir le-gbe-varietes-principales.php.
 */

/**
 * Page « Présentation générale ».
 *
 * @return string
 */
function gbe_le_gbe_presentation_generale_content() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Gbe est une langue monosyllabique (lexèmes de base en (C)V ou (C)V(C)) appartenant à la famille Niger-Congo. Aucun parler gbe n’est plus proche de l’Akan, du Ga, du Dangme ou du Yoruba que de l’ensemble gbe lui-même.', 'gbecosmolingua-core' ); ?></p>
	<p><?php esc_html_e( 'Son territoire s’étend de l’Atlantique aux fleuves Volta et Ouémé, en dessous du 10° parallèle nord. Les voisins linguistiques incluent le yoruba, l’adja, l’akpafo, l’akan, le ga et le dangme ; des enclaves avatime, trolobi et aguna existent au sein des populations gbe.', 'gbecosmolingua-core' ); ?></p>
	<h2><?php esc_html_e( 'Unité linguistique', 'gbecosmolingua-core' ); ?></h2>
	<p><?php esc_html_e( 'Comparaison lexicostatistique (liste Swadesh, 100 mots) entre Fon, Gen, Aja et Éwé : de 82 % à 96 % de termes apparentés. Le Gen joue le rôle de « plaque tournante » dans le continuum pour l’intercompréhension.', 'gbecosmolingua-core' ); ?></p>
	<p><?php esc_html_e( 'Le patrimoine oral (proverbes, comptines, chants, contes) circule librement entre sections dialectales — base d’une littérature écrite commune en orthographe uniforme.', 'gbecosmolingua-core' ); ?></p>
	<?php echo gbe_le_gbe_nav_links(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php
	return (string) ob_get_clean();
}

/**
 * Page « Peuples du continuum » — voir le-gbe-peuples-continuum.php.
 */

/**
 * Page parent « Les langues » — voir le-gbe-langues-hub.php.
 */

/**
 * Hubs principaux — voir le-gbe-main-hubs.php (Gbe, Linguistique, Cultures, Xótùtù, Onomastique).
 */

/**
 * Page « Dialectologie » — voir le-gbe-dialectologie.php.
 */

/**
 * Contenu fiche langue par slug.
 *
 * @param string $slug Slug de la fiche.
 * @return string
 */
function gbe_le_gbe_langue_page_content( $slug ) {
	$meta = gbe_le_gbe_langue_meta();
	if ( ! isset( $meta[ $slug ] ) ) {
		return gbe_intro( __( 'Documentation linguistique et culturelle de cette variété du continuum gbe.', 'gbecosmolingua-core' ) );
	}

	$data = $meta[ $slug ];
	ob_start();
	?>
	<p><strong><?php echo esc_html( $data['section'] ); ?></strong> — <?php echo esc_html( $data['intro'] ); ?></p>
	<h2><?php esc_html_e( 'Aire et parlers', 'gbecosmolingua-core' ); ?></h2>
	<p><?php echo esc_html( $data['area'] ); ?></p>
	<?php if ( ! empty( $data['parlers'] ) ) : ?>
		<?php echo gbe_outline( $data['parlers'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php endif; ?>
	<?php if ( ! empty( $data['ecrit'] ) ) : ?>
		<h2><?php esc_html_e( 'Forme écrite', 'gbecosmolingua-core' ); ?></h2>
		<p><?php echo esc_html( $data['ecrit'] ); ?></p>
	<?php endif; ?>
	<?php if ( ! empty( $data['notes'] ) ) : ?>
		<h2><?php esc_html_e( 'Notes dialectologiques', 'gbecosmolingua-core' ); ?></h2>
		<p><?php echo esc_html( $data['notes'] ); ?></p>
	<?php endif; ?>
	<p><a href="/le-gbe/le-continuum-gbe/regroupement-des-parlers/"><?php esc_html_e( 'Regroupement dialectologique →', 'gbecosmolingua-core' ); ?></a></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Métadonnées des fiches langues.
 *
 * @return array<string, array<string, mixed>>
 */
function gbe_le_gbe_langue_meta() {
	return array(
		'ewe' => array(
			'section' => 'Dialectes Vhe',
			'intro'   => 'L’Éwé standard repose surtout sur Awlan (Anlo, Ghana) et parlers voisins. Section la plus occidentale du continuum, intercompréhension quasi totale entre ses parlers.',
			'area'    => 'Ghana (Volta Region), Togo — langue nationale au Togo.',
			'parlers' => array_slice( gbe_le_gbe_section_vhe(), 0, 10 ),
			'ecrit'   => 'Éwé/Ewe — graphie standard, dictionnaires (Westermann 1910, Adornu & Ardzena 1975), littérature religieuse et didactique.',
			'notes'   => 'Awlan = dialecte prestigieux. Waci écrit coexiste dans la même section.',
		),
		'gen-mina' => array(
			'section' => 'Dialectes Gen',
			'intro'   => 'Le Gen forme une section compacte : Gliji, Agói et Anéxo. Tous les locuteurs disent parler Gengbe.',
			'area'    => 'Togo et Bénin — Peci (Gbingbe), Gliji, Agói, Anéxo.',
			'parlers' => gbe_le_gbe_section_gen(),
			'ecrit'   => 'Gen — syllabaire et dictionnaire (Pazzi 1981), littérature religieuse.',
			'notes'   => 'Le Gen apparaît comme une « plaque tournante » du continuum (ch. 9).',
		),
		'fon' => array(
			'section' => 'Dialectes Fon',
			'intro'   => 'Le Fon (Danxomegbe) regroupe Kpase, Arohún, Agbome, Maxi et Weme.',
			'area'    => 'Bénin — sud du pays.',
			'parlers' => array( 'Kpase', 'Arohún', 'Agbome', 'Maxi', 'Weme' ),
			'ecrit'   => 'Fon — dictionnaires Kponton & Xwégbénu (1963), Rassidi (1974), syllabaire depuis 1975, loi fondamentale traduite.',
			'notes'   => 'Forme écrite légèrement plus éloignée des autres (82 % Swadesh avec Éwé).',
		),
		'aja' => array(
			'section' => 'Dialectes Ajé',
			'intro'   => 'L’Aja (Ajatɔ) comprend Hwe, Dogbé et Stédé, avec intercompréhension totale. Sikpi est quasi-total.',
			'area'    => 'Bénin — sud-ouest, Dogbo, Grand-Popo, région monoéenne.',
			'parlers' => gbe_le_gbe_section_aje(),
			'ecrit'   => 'Aja — basé sur Dogbé et Hwe, syllabaire depuis la 2e vague d’alphabétisation (1975).',
			'notes'   => 'Palatalisation devant voyelles fermées, chuintantes. 96 % de ressemblance lexicale avec Éwé et Gen.',
		),
		'gun' => array(
			'section' => 'Dialectes Fon',
			'intro'   => 'Le Gun appartient linguistiquement à la section Fon, avec Kpase et Agbome. Sociologiquement distinct du Fon propre.',
			'area'    => 'Bénin (Porto-Novo, région lagunaire), Nigeria (État d’Ogun).',
			'parlers' => array( 'Gun', 'Alada (proche, section Phla-Phera)' ),
			'ecrit'   => 'Gun — syllabaire et ouvrages de référence, coexiste avec le Fon écrit.',
			'notes'   => 'Les Gun tendent à refuser l’appellation Fon pour des raisons historiques ; linguistiquement proches du Fongbe.',
		),
		'waci' => array(
			'section' => 'Dialectes Vhe',
			'intro'   => 'Le Waci (Wacigbe) est un dialecte Vhe parlé au Bénin et au Togo, des deux côtés du Mono.',
			'area'    => 'Bénin (Kômé, Mono), Togo (Aného).',
			'parlers' => array( 'Waci', 'Wancé', 'Agu' ),
			'ecrit'   => 'Waci — système orthographique propre, ouvrages descriptifs.',
			'notes'   => 'Intercompréhension parfaite avec les autres Vhe et en grande partie avec Gen et Ajé.',
		),
		'xwela' => array(
			'section' => 'Dialectes Phla-Phera',
			'intro'   => 'Le Xwela (Phelé) fait partie du groupe Phla-Phera, avec différences lexicales marquées.',
			'area'    => 'Bénin — côte, Grand-Popo, région monoéenne.',
			'parlers' => array( 'Phelé', 'Phla', 'Saxwe' ),
			'ecrit'   => 'En cours d’élaboration — syllabaire depuis 1975.',
			'notes'   => 'Pazzi désigne cette variété comme « langue Xwela » ; regroupement Phla-Phera = label conventionnel.',
		),
		'xwla' => array(
			'section' => 'Dialectes Phla-Phera',
			'intro'   => 'Le Xwla (Phla) est parlé au Togo et au Bénin, proche du Phelé phonologiquement.',
			'area'    => 'Togo, Bénin — région côtière.',
			'parlers' => array( 'Phla (Xwla)', 'Phelé' ),
			'ecrit'   => 'Forme écrite en cours d’élaboration.',
			'notes'   => 'Au moins trois préfixes nominaux (e-, a-, l-/n-), comme les autres Phla-Phera.',
		),
		'phla-phera' => array(
			'section' => 'Dialectes Phla-Phera',
			'intro'   => 'Groupe conventionnel regroupant les parlers non classables dans les quatre premières sections : Tsapha, Kotafon, Ayizo, Tèvi, Phelé, Phla, Alada.',
			'area'    => 'Bénin, Nigeria — territoire non continu.',
			'parlers' => gbe_le_gbe_section_phla_phera(),
			'ecrit'   => 'Ayizo, Kotafon, Saxwe — syllabaires depuis 1975 ; ouvrages de référence en cours.',
			'notes'   => 'Différences lexicales importantes, moins phonologiques. Intercompréhension appréciable mais unité subjectivement plus faible.',
		),
		'autres-varietes' => array(
			'section' => 'Autres parlers',
			'intro'   => 'Parlers du continuum non couverts par les fiches principales : Ifè, Saxwe, Se, Kotafon, Tèfin, Weme, Movɔli, etc.',
			'area'    => 'Répartis au Bénin, Togo, Ghana et Nigeria.',
			'parlers' => array( 'Ifè', 'Saxwe', 'Se', 'Tèfin', 'Kotafon', 'Tsapha', 'Movɔli', 'Setto' ),
			'ecrit'   => 'Plusieurs disposent de syllabaires ou de projets graphiques depuis la campagne d’alphabétisation de 1975.',
			'notes'   => 'Voir l’inventaire complet pour la liste des cinquante parlers recensés.',
		),
	);
}

/**
 * Page pays — Ghana.
 *
 * @return string
 */
function gbe_le_gbe_pays_ghana_content() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Au Ghana, les parlers gbe se concentrent dans la Volta Region (moitié septentrionale). L’Éwé y est langue véhiculaire et objet d’enseignement (Université du Ghana, Legon).', 'gbecosmolingua-core' ); ?></p>
	<h2><?php esc_html_e( 'Parlers recensés', 'gbecosmolingua-core' ); ?></h2>
	<?php echo gbe_outline( gbe_le_gbe_parlers_ghana() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<p><?php esc_html_e( 'Awlan (Anlo) constitue la base de l’Éwé standard. Intercompréhension quasi totale avec les parlers du Togo voisin.', 'gbecosmolingua-core' ); ?></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Page pays — Togo.
 *
 * @return string
 */
function gbe_le_gbe_pays_togo_content() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Au Togo, l’Éwé est l’une des deux langues nationales officielles. Le continuum y inclut des parlers Vhe (Awlan, Waci), Gen (Gliji, Agwe), Ajé (Hwe, Stédé) et Fon.', 'gbecosmolingua-core' ); ?></p>
	<h2><?php esc_html_e( 'Parlers recensés', 'gbecosmolingua-core' ); ?></h2>
	<?php echo gbe_outline( gbe_le_gbe_parlers_togo() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<p><?php esc_html_e( 'L’Académie de la langue Éwé et l’Université du Bénin (Lomé) sont les principaux cadres de recherche.', 'gbecosmolingua-core' ); ?></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Page pays — Bénin.
 *
 * @return string
 */
function gbe_le_gbe_pays_benin_content() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Le Bénin concentre la plus grande diversité de parlers et de formes écrites gbe : Fon, Aja, Gen, Gun, Waci, Phla-Phera, Ifè, Kotafon… La campagne nationale d’alphabétisation (1975) a produit des syllabaires pour la plupart des variétés.', 'gbecosmolingua-core' ); ?></p>
	<h2><?php esc_html_e( 'Parlers recensés', 'gbecosmolingua-core' ); ?></h2>
	<?php echo gbe_outline( gbe_le_gbe_parlers_benin() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<p><?php esc_html_e( 'Le CENALA (Centre national de linguistique appliquée) mène des recherches intensives sur les parlers gbe.', 'gbecosmolingua-core' ); ?></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Page pays — Nigeria.
 *
 * @return string
 */
function gbe_le_gbe_pays_nigeria_content() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Au Nigeria, Gbe est langue minoritaire dans les États d’Ogun et de Lagos. Parlers Gun, Phelé, Alada, Weme et autres communautés gbe du delta.', 'gbecosmolingua-core' ); ?></p>
	<h2><?php esc_html_e( 'Parlers recensés', 'gbecosmolingua-core' ); ?></h2>
	<?php echo gbe_outline( gbe_le_gbe_parlers_nigeria() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<p><?php esc_html_e( 'Recherches à l’Université d’Ife, Ibadan, Lagos et État de Lagos. National Language Centre — coopération souhaitée avec Ghana, Togo et Bénin.', 'gbecosmolingua-core' ); ?></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Intro enrichie — carte interactive.
 *
 * @return string
 */
function gbe_le_gbe_carte_content() {
	return '<p>' . esc_html__( 'Explorez la répartition géographique des cinquante parlers gbe au Ghana, au Togo, au Bénin et au Nigeria — de l’Atlantique aux fleuves Volta et Ouémé. Une langue unique, quatre pays, cinq sections dialectales.', 'gbecosmolingua-core' ) . '</p>[gbe_carte_interactive]';
}

/**
 * Intro — section lexicologie.
 *
 * @return string
 */
function gbe_le_gbe_lexicologie_intro() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Gbe est une langue monosyllabique dont le lexique s’enrichit par suffixation, composition, redoublement, emprunts adaptés et collocations. Les potentialités créatives sont documentées dans les travaux de Pazzi (1976) et Capo.', 'gbecosmolingua-core' ); ?></p>
	<p><a href="/le-gbe/linguistique/potentialites-lexicales/"><?php esc_html_e( 'Potentialités lexicales de Gbe →', 'gbecosmolingua-core' ); ?></a> · <a href="/paremiologie/banque-numerique-proverbes/"><?php esc_html_e( 'Banque de proverbes →', 'gbecosmolingua-core' ); ?></a></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Intro enrichie — hub paremiologie.
 *
 * @return string
 */
function gbe_le_gbe_paremiologie_hub_content() {
	ob_start();
	?>
	<p><?php esc_html_e( 'Les proverbes (lododowo) condensent la sagesse populaire gbe. Bien des proverbes sont identiques d’une section dialectale à l’autre — comparables entre les recueils de Pazzi & Agban (Gen/Mina), Guillet (Fon) et Dzobo (Éwé). GbeCosmoLingua en documente le corpus, notamment 786 proverbes éwé numérisés.', 'gbecosmolingua-core' ); ?></p>
	<p><a href="/paremiologie/banque-numerique-proverbes/"><?php esc_html_e( 'Banque numérique de proverbes →', 'gbecosmolingua-core' ); ?></a> · <a href="/le-gbe/linguistique/potentialites-lexicales/"><?php esc_html_e( 'Potentialités lexicales →', 'gbecosmolingua-core' ); ?></a></p>
	<?php
	return (string) ob_get_clean();
}
