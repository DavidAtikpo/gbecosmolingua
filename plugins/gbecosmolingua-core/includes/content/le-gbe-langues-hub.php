<?php
/**
 * Contenu éditorial — hub « Les langues ».
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML enrichi du hub Les langues.
 *
 * @return string
 */
function gbe_le_gbe_langues_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Hub des langues gbe — fiches des principales variétés écrites, sections dialectologiques et ressources du continuum.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_langues_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_langues_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Les variétés ci-dessous sont les principales formes identifiées du continuum gbe. Chacune correspond à une section dialectale ou à un ensemble de parlers, avec sa graphie, son aire géographique et son patrimoine propre.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Linguistiquement, toutes appartiennent à la langue Gbe ; les différences portent surtout sur la phonologie, les préfixes nominaux et le lexique. GbeCosmoLingua propose une fiche détaillée pour chaque forme écrite majeure.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Entre 82 % et 96 % de ressemblance lexicale (liste Swadesh) relient les principales sections — base solide pour une orthographe standard commune.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="fiches" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Fiches langues', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Accédez aux fiches des principales variétés — graphie, aire, parlers de référence et notes dialectologiques.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_link_cards( gbe_le_gbe_langues_fiche_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="sections" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cinq sections dialectologiques', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Chaque fiche langue s’inscrit dans l’une des cinq sections reconnues par la dialectologie gbe moderne.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_inventaire_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="ressources" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Aller plus loin', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Complétez votre exploration du continuum par l’inventaire complet, la cartographie et la description scientifique.', 'gbecosmolingua-core' ); ?></p>
			<ul class="gbe-chapter-list">
				<li><a href="/le-gbe/le-continuum-gbe/inventaire-des-parlers/"><?php esc_html_e( 'Inventaire des cinquante parlers recensés', 'gbecosmolingua-core' ); ?></a></li>
				<li><a href="/le-gbe/le-continuum-gbe/regroupement-des-parlers/"><?php esc_html_e( 'Regroupement dialectologique en cinq sections', 'gbecosmolingua-core' ); ?></a></li>
				<li><a href="/le-gbe/le-continuum-gbe/langue-unique/"><?php esc_html_e( 'Gbe, une langue unique', 'gbecosmolingua-core' ); ?></a></li>
				<li><a href="/le-gbe/carte-interactive/"><?php esc_html_e( 'Cartographie interactive', 'gbecosmolingua-core' ); ?></a></li>
			</ul>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/varietes-principales/',
					'label' => __( 'Variétés principales', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/carte-interactive/',
					'label' => __( 'Carte interactive', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/dialectologie/',
					'label' => __( 'Dialectologie', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Alias historique.
 *
 * @return string
 */
function gbe_le_gbe_langues_hub_content() {
	return gbe_le_gbe_langues_content();
}

/**
 * Statistiques hub langues.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_langues_stats() {
	return array(
		array(
			'value' => '10',
			'label' => __( 'Fiches langues', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '12+',
			'label' => __( 'Formes écrites', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page hub langues.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_langues_nav() {
	return array(
		array(
			'id'    => 'presentation',
			'label' => __( 'Présentation', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'fiches',
			'label' => __( 'Fiches', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'sections',
			'label' => __( 'Sections', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'ressources',
			'label' => __( 'Ressources', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes cliquables vers les fiches langues.
 *
 * @return array<int, array{code: string, title: string, body: string, url: string, meta?: string}>
 */
function gbe_le_gbe_langues_fiche_cards() {
	return array(
		array(
			'code'  => 'Vhe',
			'title' => 'Éwé',
			'body'  => __( 'Section occidentale — Awlan, base de l’Éwé standard. Ghana et Togo.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/ewe/',
			'meta'  => __( 'Langue nationale au Togo', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Gen',
			'title' => 'Gen (Mina)',
			'body'  => __( 'Gliji, Agwe, Anexo — plaque tournante du continuum, Gengbe.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/gen-mina/',
			'meta'  => __( 'Togo · Bénin', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Fon',
			'title' => 'Fon',
			'body'  => __( 'Danxomegbe — Kpase, Agbome, langue dahoméenne historique.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/fon/',
			'meta'  => __( 'Bénin', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Ajé',
			'title' => 'Aja',
			'body'  => __( 'Dogbé, Hwe, Stédé — sud-ouest du Bénin, 96 % Swadesh avec Éwé.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/aja/',
			'meta'  => __( 'Bénin', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Fon',
			'title' => 'Gun',
			'body'  => __( 'Porto-Novo, lagune — proche du Fon, sociologiquement distinct.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/gun/',
			'meta'  => __( 'Bénin · Nigeria', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Vhe',
			'title' => 'Waci',
			'body'  => __( 'Kômé, Aného — transfrontalier Togo/Bénin, orthographe propre.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/waci/',
			'meta'  => __( 'Togo · Bénin', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Phla',
			'title' => 'Xwela',
			'body'  => __( 'Phelé — côte bénino-togolaise, graphie en cours d’élaboration.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/xwela/',
			'meta'  => __( 'Bénin · Togo', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Phla',
			'title' => 'Xwla',
			'body'  => __( 'Phla — parlers côtiers, proche du groupe Phelé-Phla.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/xwla/',
			'meta'  => __( 'Bénin · Togo', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'Phla',
			'title' => 'Phla-Phera',
			'body'  => __( 'Tsapha, Kotafon, Ayizo, Alada — groupe conventionnel Phla-Phera.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/phla-phera/',
			'meta'  => __( 'Bénin · Nigeria', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '…',
			'title' => __( 'Autres variétés', 'gbecosmolingua-core' ),
			'body'  => __( 'Ifè, Saxwe, Se, Kotafon, Tèfin, Weme et autres parlers complémentaires du continuum.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/autres-varietes/',
			'meta'  => __( 'Inventaire complet →', 'gbecosmolingua-core' ),
		),
	);
}
