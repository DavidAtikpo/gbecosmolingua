<?php
/**
 * Contenu éditorial — dialectologie gbe.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML enrichi de la page « Dialectologie ».
 *
 * @return string
 */
function gbe_le_gbe_dialectologie_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Dialectologie du continuum gbe — méthodologie, regroupement des parlers et validation par intercompréhension.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_dialectologie_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_dialectologie_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'La dialectologie gbe repose sur l’inventaire des parlers, leur description phonologique et morphophonologique, puis un regroupement selon les degrés d’affinité historique.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les innovations phonologiques non conditionnées, interprétées depuis le proto-Gbe, constituent le critère le plus fiable — complétées par des critères morphophonologiques et sociolinguistiques.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="methodologie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Méthodologie', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_list( gbe_le_gbe_dialectologie_methodologie() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Limites entre sections : plusieurs innovations sont partagées ; Westermann (1930) notait déjà des phénomènes « à cheval » entre sections. Cela confirme l’unité de la langue Gbe plutôt que l’existence de langues séparées.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="sections" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cinq sections retenues', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_inventaire_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="validation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Validation dialectologique', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_dialectologie_validation_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/',
					'label' => __( 'Regroupement détaillé', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
					'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/phonologie/',
					'label' => __( 'Phonologie', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_dialectologie_stats() {
	return array(
		array( 'value' => '50+', 'label' => __( 'Parlers inventoriés', 'gbecosmolingua-core' ) ),
		array( 'value' => '5', 'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ) ),
		array( 'value' => '82–96%', 'label' => __( 'Swadesh inter-sections', 'gbecosmolingua-core' ) ),
		array( 'value' => '1930', 'label' => __( 'Westermann — référence', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_dialectologie_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'methodologie', 'label' => __( 'Méthode', 'gbecosmolingua-core' ) ),
		array( 'id' => 'sections', 'label' => __( 'Sections', 'gbecosmolingua-core' ) ),
		array( 'id' => 'validation', 'label' => __( 'Validation', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return string[]
 */
function gbe_le_gbe_dialectologie_methodologie() {
	return array(
		__( 'Inventaire des parlers de l’aire gbe (chapitre 1)', 'gbecosmolingua-core' ),
		__( 'Description de chaque parler (travaux universitaires, monographies)', 'gbecosmolingua-core' ),
		__( 'Regroupement en sections sur la base des innovations communes (chapitre 7)', 'gbecosmolingua-core' ),
		__( 'Validation par intercompréhension mutuelle et lexicostatistique (chapitre 9)', 'gbecosmolingua-core' ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_dialectologie_validation_cards() {
	return array(
		array(
			'tag'   => 'Swadesh',
			'title' => __( 'Lexicostatistique', 'gbecosmolingua-core' ),
			'body'  => __( 'Comparaison de 100 mots de base — de 82 % à 96 % de ressemblance entre Fon, Gen, Aja et Éwé.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Intercomp.',
			'title' => __( 'Intelligibilité mutuelle', 'gbecosmolingua-core' ),
			'body'  => __( 'Critère sociolinguistique complémentaire — quasi-totale dans Vhe et Gen, appréciable entre sections.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Proto-Gbe',
			'title' => __( 'Innovations phonologiques', 'gbecosmolingua-core' ),
			'body'  => __( 'Critère principal — innovations non conditionnées interprétées depuis la reconstruction du proto-Gbe.', 'gbecosmolingua-core' ),
		),
	);
}
