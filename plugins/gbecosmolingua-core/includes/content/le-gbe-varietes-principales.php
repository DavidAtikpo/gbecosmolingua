<?php
/**
 * Contenu éditorial — variétés principales du continuum gbe.
 *
 * Formes écrites, sections dialectales et fiches langues de référence.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Variétés principales ».
 *
 * @return string
 */
function gbe_le_gbe_varietes_principales_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Formes écrites et variétés de référence — du continuum gbe sont nées une douzaine de graphies contemporaines, chacune ancrée dans une section dialectale.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_varietes_principales_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_varietes_principales_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Du continuum gbe sont nées une douzaine de formes écrites contemporaines. Chaque variété majeure correspond à une section dialectale ou à un ensemble de parlers proches, avec des degrés variables d’intercompréhension.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Linguistiquement, toutes appartiennent à la langue Gbe ; les différences portent surtout sur la phonologie, les préfixes nominaux et le lexique. Les formes écrites les plus développées — Éwé, Fon, Gen, Aja — servent de références pour la recherche et l’enseignement.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="ecriture" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Formes écrites principales', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Douze graphies contemporaines recensées, classées par section dialectale et degré de standardisation.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_varietes_ecriture_cards(), '--angles' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="chronologie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Chronologie des graphies', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Trois vagues d’élaboration orthographique, repère : campagne nationale d’alphabétisation de 1975 au Bénin.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_langue_unique_ecriture_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="sections" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cinq sections dialectales', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Chaque forme écrite s’inscrit dans l’une des cinq sections dialectologiques du continuum — voir le regroupement détaillé pour les innovations phonologiques.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_inventaire_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="fiches" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Fiches langues', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Documentation linguistique et culturelle des principales variétés — aire, parlers, forme écrite et notes dialectologiques.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_link_cards( gbe_le_gbe_varietes_fiches_links() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="standardisation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Proximité lexicale et standardisation', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Comparaison lexicostatistique (Swadesh, 100 mots) entre les quatre formes écrites majeures — seuil proposé : 80 % pour une même langue.', 'gbecosmolingua-core' ); ?></p>
			<?php
			echo gbe_chapter_data_table( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				gbe_le_gbe_swadesh_comparaisons(),
				array(
					__( 'Paire de variétés', 'gbecosmolingua-core' ),
					__( 'Termes apparentés', 'gbecosmolingua-core' ),
				)
			);
			?>
			<?php echo gbe_chapter_list( gbe_le_gbe_varietes_standardisation() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Le patrimoine oral circule librement entre sections — base d’une littérature écrite commune en orthographe uniforme standard de Gbe.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/les-langues/',
					'label' => __( 'Hub Les langues', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/',
					'label' => __( 'Regroupement des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
					'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques variétés principales.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_varietes_principales_stats() {
	return array(
		array(
			'value' => '12+',
			'label' => __( 'Formes écrites', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '10',
			'label' => __( 'Fiches langues', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '1975',
			'label' => __( 'Alphabétisation Bénin', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_varietes_principales_nav() {
	return array(
		array(
			'id'    => 'generalites',
			'label' => __( 'Généralités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'ecriture',
			'label' => __( 'Écriture', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'chronologie',
			'label' => __( 'Chronologie', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'sections',
			'label' => __( 'Sections', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'fiches',
			'label' => __( 'Fiches', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'standardisation',
			'label' => __( 'Standardisation', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes des formes écrites principales.
 *
 * @return array<int, array{tag: string, title: string, body: string, meta?: string}>
 */
function gbe_le_gbe_varietes_ecriture_cards() {
	return array(
		array(
			'tag'   => 'Vhe',
			'title' => 'Éwé / Ewe',
			'body'  => __( 'Ghana, Togo — basé sur Awlan et parlers voisins. Dictionnaires (Westermann 1910), langue nationale au Togo.', 'gbecosmolingua-core' ),
			'meta'  => __( 'Intercompréhension quasi totale dans la section', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Fon',
			'title' => 'Fon',
			'body'  => __( 'Bénin — Kpase, Agbome ; langue dahoméenne historique. Syllabaire depuis 1975, loi fondamentale traduite.', 'gbecosmolingua-core' ),
			'meta'  => __( '82 % Swadesh minimum avec Éwé', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ajé',
			'title' => 'Aja',
			'body'  => __( 'Bénin — Dogbé et Hwe. Syllabaire depuis la 2e vague d’alphabétisation (1975).', 'gbecosmolingua-core' ),
			'meta'  => __( '96 % de ressemblance lexicale avec Éwé et Gen', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Gen',
			'title' => 'Gen (Mina)',
			'body'  => __( 'Togo, Bénin — Gliji, Agwe, Anexo. Dictionnaire Pazzi (1981), plaque tournante du continuum.', 'gbecosmolingua-core' ),
			'meta'  => __( 'Tous les locuteurs disent parler Gengbe', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Fon',
			'title' => 'Gun',
			'body'  => __( 'Bénin, Nigeria — Porto-Novo, État d’Ogun. Coexiste sociologiquement avec le Fon écrit.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Vhe',
			'title' => 'Waci',
			'body'  => __( 'Bénin, Togo — des deux côtés du Mono. Système orthographique propre, ouvrages descriptifs.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Divers', 'gbecosmolingua-core' ),
			'title' => __( 'Autres graphies', 'gbecosmolingua-core' ),
			'body'  => __( 'Saxwe, Ifè, Kotafon, Tèfin, Weme, Ayizo — syllabaires depuis 1975 ; Phelé, Phla en cours d’élaboration.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Liens vers les fiches langues du hub.
 *
 * @return array<int, array{code: string, title: string, body: string, url: string, meta?: string}>
 */
function gbe_le_gbe_varietes_fiches_links() {
	return array(
		array(
			'code'  => 'Vhe',
			'title' => 'Éwé',
			'body'  => __( 'Section occidentale — Awlan, base de l’Éwé standard. Ghana et Togo.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/ewe/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Gen',
			'title' => 'Gen (Mina)',
			'body'  => __( 'Gliji, Agwe, Anexo — intercompréhension totale, Gengbe.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/gen-mina/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Fon',
			'title' => 'Fon',
			'body'  => __( 'Danxomegbe — Kpase, Agbome, royaume du Dahomey.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/fon/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Ajé',
			'title' => 'Aja',
			'body'  => __( 'Dogbé, Hwe, Stédé — sud-ouest du Bénin.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/aja/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Fon',
			'title' => 'Gun',
			'body'  => __( 'Porto-Novo, lagune — proche du Fon, sociologiquement distinct.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/gun/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Vhe',
			'title' => 'Waci',
			'body'  => __( 'Kômé, Aného — transfrontalier Togo/Bénin.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/waci/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Phla',
			'title' => 'Xwela / Xwla',
			'body'  => __( 'Phelé et Phla — côte bénino-togolaise, graphies en cours.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/xwela/',
			'meta'  => __( 'Fiche Xwela →', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Phla',
			'title' => 'Phla-Phera',
			'body'  => __( 'Tsapha, Kotafon, Ayizo, Alada — groupe conventionnel.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/phla-phera/',
			'meta'  => __( 'Fiche complète →', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Axes de standardisation de Gbe.
 *
 * @return string[]
 */
function gbe_le_gbe_varietes_standardisation() {
	return array(
		__( 'Harmonisation des orthographes entre Éwé, Fon, Gen et Aja — minimum Swadesh 82 %', 'gbecosmolingua-core' ),
		__( 'Le Gen comme plaque tournante pour l’intercompréhension entre sections', 'gbecosmolingua-core' ),
		__( 'Mobilité du patrimoine oral (proverbes, contes, chants) sans frontière dialectale', 'gbecosmolingua-core' ),
		__( 'Coordination CENALA, Académie Éwé et institutions régionales pour une graphie standard', 'gbecosmolingua-core' ),
	);
}
