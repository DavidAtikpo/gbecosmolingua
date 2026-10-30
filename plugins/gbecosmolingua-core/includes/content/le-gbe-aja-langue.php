<?php
/**
 * Contenu éditorial — fiche langue Aja (section Ajé).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML enrichi de la fiche « Aja ».
 *
 * @return string
 */
function gbe_le_gbe_aja_langue_content() {
	$meta = gbe_le_gbe_langue_meta()['aja'];

	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Fiche langue — Aja (Ajatɔ), section dialectale Ajé du continuum gbe. Graphie basée sur Dogbé et Hwe.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_aja_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_aja_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php echo esc_html( $meta['intro'] ); ?></p>
			<p><?php esc_html_e( 'L’Aja fait partie de la section Ajé avec une forte conscience d’unité linguistique — Pazzi parle de « langue Ajatɔ » (hors Saxwe et Se). Intercompréhension totale entre Hwe, Dogbé et Stédé ; quasi-totale avec Sikpi.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( '96 % de ressemblance lexicale (Swadesh) avec l’Éwé et le Gen — l’une des variétés les plus proches du noyau central du continuum.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="aire" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Aire et parlers', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['area'] ); ?></p>
			<?php
			echo gbe_chapter_parler_panels( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array(
					array(
						'code'    => 'Ajé',
						'title'   => __( 'Parlers Aja', 'gbecosmolingua-core' ),
						'parlers' => $meta['parlers'],
					),
				)
			);
			?>
			<p><?php esc_html_e( 'Territoire côtier du sud-ouest béninois — Dogbo, Grand-Popo, région monoéenne — en contact avec Waci, Gen et Phla-Phera.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="phonologie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Phonologie et section Ajé', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['notes'] ); ?></p>
			<h3><?php esc_html_e( 'Innovations phonologiques de la section Ajé', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_innovations_aje() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="ecriture" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Forme écrite', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['ecrit'] ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_aja_ecriture_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="travaux" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Travaux de référence', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_aja_travaux_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php
			echo gbe_chapter_timeline( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array(
					array(
						'year'   => '1979',
						'author' => 'Natabou',
						'title'  => __( 'Mémoire dictionnaire aja–français', 'gbecosmolingua-core' ),
						'note'   => __( 'Sarrebruck — complète Marguéleguy & catéchistes.', 'gbecosmolingua-core' ),
					),
					array(
						'year'   => '1981–83',
						'author' => __( 'Mémoires UNB', 'gbecosmolingua-core' ),
						'title'  => __( 'Phonologie Dogbé — comparaisons Kwa', 'gbecosmolingua-core' ),
					),
					array(
						'year'   => '1984',
						'author' => 'Taovi Tchitchi',
						'title'  => __( 'Systématique de l’Ajagbe — première monographie (Paris VII)', 'gbecosmolingua-core' ),
					),
				)
			);
			?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/#aje',
					'label' => __( 'Section Ajé (regroupement)', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/varietes-principales/',
					'label' => __( 'Variétés principales', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/paremiologie/corpus-aja/',
					'label' => __( 'Corpus paremiologique Aja', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/travaux-scientifiques-recents/',
					'label' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques fiche Aja.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_aja_stats() {
	return array(
		array(
			'value' => 'Ajé',
			'label' => __( 'Section dialectale', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Parlers principaux', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '96%',
			'label' => __( 'Swadesh (Éwé / Gen)', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '1975',
			'label' => __( 'Syllabaire officiel', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page fiche Aja.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_aja_nav() {
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
 * Cartes formes écrites Aja.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_aja_ecriture_cards() {
	return array(
		array(
			'tag'   => 'Dogbé',
			'title' => __( 'Base orthographique', 'gbecosmolingua-core' ),
			'body'  => __( 'L’Aja écrit repose principalement sur le parler Dogbé — référence pour la standardisation graphique.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Hwe',
			'title' => __( 'Co-référence', 'gbecosmolingua-core' ),
			'body'  => __( 'Le parler Hwe complète la base de l’orthographe aja aux côtés de Dogbé.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1975',
			'title' => __( 'Alphabétisation', 'gbecosmolingua-core' ),
			'body'  => __( 'Syllabaire produit lors de la 2e vague de la campagne nationale d’alphabétisation au Bénin.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes travaux linguistiques sur l’Aja.
 *
 * @return array<int, array{tag: string, title: string, body: string, meta?: string}>
 */
function gbe_le_gbe_aja_travaux_cards() {
	return array(
		array(
			'tag'   => '1976',
			'title' => 'R. Pazzi',
			'body'  => __( 'L’homme, le Bénin, Fon et son univers — comparaison lexicale Aja, Éwé, Fon, Gen.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1979',
			'title' => 'Marguéleguy & Natabou',
			'body'  => __( 'Éléments pour un dictionnaire aja–français — fondations lexicographiques.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1984',
			'title' => 'Taovi Tchitchi',
			'body'  => __( 'Systématique de l’Ajagbe — première monographie scientifique (thèse Paris VII).', 'gbecosmolingua-core' ),
			'meta'  => __( 'Première monographie sur l’Ajagbe', 'gbecosmolingua-core' ),
		),
	);
}
