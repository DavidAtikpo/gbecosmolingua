<?php
/**
 * Contenu éditorial — lexicologie gbe.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML enrichi de la page « Lexicologie ».
 *
 * @return string
 */
function gbe_le_gbe_lexicologie_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Lexicologie de Gbe — champs lexicaux, néologie, terminologie culturelle et ressources corpus.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_lexicologie_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_lexicologie_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Gbe est une langue monosyllabique dont le lexique s’enrichit par suffixation, composition, redoublement, emprunts adaptés et collocations.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les potentialités créatives sont documentées dans les travaux de Pazzi (1976) et Capo — base de la néologie et de la terminologie culturelle du continuum.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="formation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Formation des mots', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_lexicologie_formation_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="champs" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Champs lexicaux et corpus', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_list( gbe_le_gbe_lexicologie_champs() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( '786 proverbes éwé numérisés dans la banque paremiologique — corpus lexicologique et culturel de référence pour le continuum.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="ressources" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Ressources et dictionnaires', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_lexicologie_ressources_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/linguistique/potentialites-lexicales/',
					'label' => __( 'Potentialités lexicales', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/morphologie/',
					'label' => __( 'Morphologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/paremiologie/banque-numerique-proverbes/',
					'label' => __( 'Banque de proverbes', 'gbecosmolingua-core' ),
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
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_lexicologie_stats() {
	return array(
		array( 'value' => '(C)V', 'label' => __( 'Structure monosyllabique', 'gbecosmolingua-core' ) ),
		array( 'value' => '786', 'label' => __( 'Proverbes éwé (corpus)', 'gbecosmolingua-core' ) ),
		array( 'value' => '12+', 'label' => __( 'Formes écrites', 'gbecosmolingua-core' ) ),
		array( 'value' => '1976', 'label' => __( 'Pazzi — référence', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_lexicologie_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'formation', 'label' => __( 'Formation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'champs', 'label' => __( 'Champs lexicaux', 'gbecosmolingua-core' ) ),
		array( 'id' => 'ressources', 'label' => __( 'Ressources', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_lexicologie_formation_cards() {
	return array(
		array(
			'tag'   => 'Interne',
			'title' => __( 'Ressources internes', 'gbecosmolingua-core' ),
			'body'  => __( 'Suffixation, redoublement, composition, collocations et séries verbales.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Externe',
			'title' => __( 'Emprunts adaptés', 'gbecosmolingua-core' ),
			'body'  => __( 'Portugais, français, akan, yoruba — intégration phonologique et tonale.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Créative',
			'title' => __( 'Combinaisons', 'gbecosmolingua-core' ),
			'body'  => __( 'Calques, paraphrases endogènes, extension de sens et symbolisme.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * @return string[]
 */
function gbe_le_gbe_lexicologie_champs() {
	return array(
		__( 'Terminologie culturelle et patrimoniale (artisanat, religion, royauté)', 'gbecosmolingua-core' ),
		__( 'Néologie technologique et administrative — adaptation au monde contemporain', 'gbecosmolingua-core' ),
		__( 'Paremiologie (lododowo) — proverbes identiques entre sections dialectales', 'gbecosmolingua-core' ),
		__( 'Onomastique — anthroponymes, toponymes, noms de divinités', 'gbecosmolingua-core' ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_lexicologie_ressources_cards() {
	return array(
		array(
			'tag'   => '1910',
			'title' => 'D. Westermann',
			'body'  => __( 'Dictionnaire Éwé — fondation lexicographique du continuum.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1963',
			'title' => 'Kponton & Xwégbénu',
			'body'  => __( 'Dictionnaire fon–français — lexicographie Fon.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1981',
			'title' => 'Duthie & Vlaardingerbroek',
			'body'  => __( 'Bibliographie gbe — 770+ entrées par domaine thématique.', 'gbecosmolingua-core' ),
		),
	);
}
