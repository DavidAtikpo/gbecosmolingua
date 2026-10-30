<?php
/**
 * Contenu éditorial — Peuples du continuum gbe.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML enrichi de la page « Peuples du continuum ».
 *
 * @return string
 */
function gbe_le_gbe_peuples_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Peuples et communautés du continuum gbe — identités sociologiques, ethnonymes, conscience dialectale et patrimoine partagé.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_peuples_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_peuples_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Chaque nom de parler désigne une communauté sociologique et sa langue. Le continuum gbe associe cinquante parlers à autant de groupes locuteurs — unies linguistiquement, diverses sociologiquement.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Des ethnonymes larges (Idu, Aja, Ifè) couvrent des ensembles vastes ; des termes comme Mina, Popo ou Danxomegbe sont courants chez les personnes extérieures au continuum. Les Gun et les Fon tendent à s’exclure sociologiquement, bien que linguistiquement proches.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Anthroponymes et toponymes (Lérimi, Agbessi, Kpémé, Lomé, Sémé…) se retrouvent dans toutes les sections — signe d’une histoire et d’une culture partagées malgré la diversité dialectale.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="identites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Identités et désignations', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'La terminologie gbe distingue le parler (-gbe) de la communauté locutrice (-vi, -no, -li, -kpɔ). Cette double désignation structure l’identité sociolinguistique du continuum.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_peuples_identite_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="conscience" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Conscience dialectale', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Chaque section dialectologique développe une conscience d’unité propre — de l’homogénéité quasi totale des Vhe et Gen à la diversité lexicale des Phla-Phera.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_peuples_conscience_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="patrimoine" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Patrimoine et mémoire collective', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Au-delà des frontières dialectales, les peuples gbe partagent des traditions orales, des systèmes de pensée et des réseaux de parenté — base d’une renaissance culturelle commune.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_peuples_patrimoine() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/histoire-et-migrations/',
					'label' => __( 'Histoire et migrations', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/presentation-generale/',
					'label' => __( 'Présentation générale', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/',
					'label' => __( 'Le continuum gbe', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/onomastique/noms-des-peuples/',
					'label' => __( 'Noms des peuples (onomastique)', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques page peuples.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_peuples_stats() {
	return array(
		array(
			'value' => '4M',
			'label' => __( 'Locuteurs (est.)', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '50+',
			'label' => __( 'Communautés locutrices', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page peuples.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_peuples_nav() {
	return array(
		array(
			'id'    => 'presentation',
			'label' => __( 'Présentation', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'identites',
			'label' => __( 'Identités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'conscience',
			'label' => __( 'Conscience', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'patrimoine',
			'label' => __( 'Patrimoine', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes identités et désignations.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_peuples_identite_cards() {
	return array(
		array(
			'tag'   => '-gbe',
			'title' => __( 'Suffixe du parler', 'gbecosmolingua-core' ),
			'body'  => __( 'Gungbe, Hwegbe, Wacigbe, Fongbe… — désigne la langue ou le parler de la communauté.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '-vi / -no',
			'title' => __( 'Suffixe de communauté', 'gbecosmolingua-core' ),
			'body'  => __( 'Désignations sociologiques des groupes locuteurs — -vi, -no, -li ou -kpɔ selon les traditions.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Extérieur',
			'title' => __( 'Ethnonymes externes', 'gbecosmolingua-core' ),
			'body'  => __( 'Mina, Popo, Danxomegbe — appellations courantes hors du continuum, parfois rejetées localement (Gun vs Fon).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes conscience dialectale par section.
 *
 * @return array<int, array{tag: string, title: string, body: string, examples: string}>
 */
function gbe_le_gbe_peuples_conscience_cards() {
	return array(
		array(
			'tag'      => 'Vhe',
			'title'    => __( 'Section Vhe', 'gbecosmolingua-core' ),
			'body'     => __( 'Unité ressentie — Awlan = dialecte prestigieux, base de l’Éwé standard.', 'gbecosmolingua-core' ),
			'examples' => 'Awlan, Waci, Peci',
		),
		array(
			'tag'      => 'Gen',
			'title'    => __( 'Section Gen', 'gbecosmolingua-core' ),
			'body'     => __( 'Haut prestige — tous les locuteurs disent parler Gengbe.', 'gbecosmolingua-core' ),
			'examples' => 'Gliji, Agwe, Anexo',
		),
		array(
			'tag'      => 'Ajé',
			'title'    => __( 'Section Ajé', 'gbecosmolingua-core' ),
			'body'     => __( 'Forte conscience d’unité entre Hwe, Dogbé et Stédé.', 'gbecosmolingua-core' ),
			'examples' => 'Hwe, Dogbé, Stédé, Sikpi',
		),
		array(
			'tag'      => 'Fon',
			'title'    => __( 'Section Fon', 'gbecosmolingua-core' ),
			'body'     => __( 'Homogène linguistiquement — entités sociologiques distinctes (Gun vs Fon).', 'gbecosmolingua-core' ),
			'examples' => 'Kpase, Gun, Agbome, Weme',
		),
		array(
			'tag'      => 'Phla-Phera',
			'title'    => __( 'Groupe Phla-Phera', 'gbecosmolingua-core' ),
			'body'     => __( 'Diversité lexicale, territoire non continu — pas de nom unique spontané.', 'gbecosmolingua-core' ),
			'examples' => 'Ayizo, Saxwe, Phelé, Phla',
		),
	);
}

/**
 * Éléments de patrimoine partagé.
 *
 * @return string[]
 */
function gbe_le_gbe_peuples_patrimoine() {
	return array(
		__( 'Anthroponymes royaux et calendaires communs (Abomey, Notsé, traditions fondateurs)', 'gbecosmolingua-core' ),
		__( 'Toponymes partagés : Lomé, Sémé, Kpémé, Agbessi, Lérimi…', 'gbecosmolingua-core' ),
		__( 'Patrimoine oral transfrontalier — proverbes, contes, chants d’orchestres', 'gbecosmolingua-core' ),
		__( 'Réseaux commerciaux et circulations historiques entre communautés gbe', 'gbecosmolingua-core' ),
	);
}
