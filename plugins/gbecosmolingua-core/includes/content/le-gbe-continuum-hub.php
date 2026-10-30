<?php
/**
 * Contenu éditorial — hub « Le continuum gbe ».
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML enrichi du hub continuum gbe.
 *
 * @return string
 */
function gbe_le_gbe_continuum_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Hub du continuum gbe — inventaire, classification dialectologique, unité linguistique, variétés écrites et répartition géographique.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_continuum_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_continuum_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Le continuum gbe désigne l’ensemble des parlers apparentés parlés entre l’océan Atlantique et les fleuves Volta et Ouémé. Linguistiquement, il constitue une langue unique avec ses dialectes ; sociologiquement, chaque parler identifie aussi une communauté (-vi, -no, -li, -kpɔ).', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'GbeCosmoLingua documente ce continuum à travers cinq rubriques complémentaires : recensement des parlers, regroupement dialectologique, arguments d’unité linguistique, formes écrites majeures et cartographie par pays.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Les travaux de H. C. Capo (Gbekɔbu) proposent un regroupement rigoureux en cinq sections — Vhe, Gen, Ajé, Fon et Phla-Phera — sur la base d’innovations phonologiques et morphophonologiques interprétées depuis le proto-Gbe.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="sections" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cinq sections dialectologiques', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Le regroupement repose sur des innovations phonologiques non conditionnées, complétées par des critères morphophonologiques et sociolinguistiques.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_inventaire_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="rubriques" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Rubriques du continuum', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Explorez chaque angle du continuum gbe — de l’inventaire des cinquante parlers à la répartition par pays.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_link_cards( gbe_le_gbe_continuum_rubrique_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="methodologie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Méthodologie', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'La dialectologie gbe suit une progression rigoureuse : inventaire des parlers, description phonologique, regroupement par innovations communes, validation par intercompréhension mutuelle et lexicostatistique (liste Swadesh).', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_continuum_methodologie() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/les-langues/',
					'label' => __( 'Fiches langues', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/carte-interactive/',
					'label' => __( 'Carte interactive', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/dialectologie/',
					'label' => __( 'Dialectologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/presentation-generale/',
					'label' => __( 'Présentation générale', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques hub continuum.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_continuum_stats() {
	return array(
		array(
			'value' => '50+',
			'label' => __( 'Parlers recensés', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '12+',
			'label' => __( 'Formes écrites', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page hub continuum.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_continuum_nav() {
	return array(
		array(
			'id'    => 'presentation',
			'label' => __( 'Présentation', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'sections',
			'label' => __( 'Sections', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'rubriques',
			'label' => __( 'Rubriques', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'methodologie',
			'label' => __( 'Méthode', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes cliquables vers les rubriques du continuum.
 *
 * @return array<int, array{code: string, title: string, body: string, url: string, meta?: string}>
 */
function gbe_le_gbe_continuum_rubrique_cards() {
	return array(
		array(
			'code'  => '01',
			'title' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
			'body'  => __( 'Cinquante parlers recensés par pays — territoire, locuteurs et diversité dialectale.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
			'meta'  => __( 'Ghana, Togo, Bénin, Nigeria', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '02',
			'title' => __( 'Regroupement des parlers', 'gbecosmolingua-core' ),
			'body'  => __( 'Cinq sections dialectales — méthodologie et innovations phonologiques depuis le proto-Gbe.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/',
			'meta'  => __( 'Vhe, Gen, Ajé, Fon, Phla-Phera', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '03',
			'title' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
			'body'  => __( 'Arguments linguistiques, sociolinguistiques et littéraires pour l’unité du continuum.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
			'meta'  => __( '82–96 % Swadesh inter-sections', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '04',
			'title' => __( 'Variétés principales', 'gbecosmolingua-core' ),
			'body'  => __( 'Formes écrites et parlers de référence — Éwé, Fon, Gen, Aja et autres graphies.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/varietes-principales/',
			'meta'  => __( 'Liens vers les fiches langues', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '05',
			'title' => __( 'Pays et territoires', 'gbecosmolingua-core' ),
			'body'  => __( 'Répartition géographique des parlers gbe — fiches par pays.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/pays-et-territoires/',
			'meta'  => __( 'Ghana · Togo · Bénin · Nigeria', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Étapes méthodologiques du continuum.
 *
 * @return string[]
 */
function gbe_le_gbe_continuum_methodologie() {
	return array(
		__( 'Inventaire des parlers de l’aire gbe (enquêtes de terrain et travaux publiés)', 'gbecosmolingua-core' ),
		__( 'Description phonologique et morphophonologique de chaque parler', 'gbecosmolingua-core' ),
		__( 'Regroupement en sections sur la base des innovations communes (proto-Gbe)', 'gbecosmolingua-core' ),
		__( 'Validation par intercompréhension mutuelle et lexicostatistique (Swadesh)', 'gbecosmolingua-core' ),
		__( 'Documentation des formes écrites et standardisation graphique', 'gbecosmolingua-core' ),
	);
}
