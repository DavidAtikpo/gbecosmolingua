<?php
/**
 * Contenu éditorial — pays et territoires du continuum gbe.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Pays et territoires ».
 *
 * @return string
 */
function gbe_le_gbe_pays_territoires_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Répartition géographique — Le continuum gbe s’étend sur quatre États d’Afrique de l’Ouest, entre l’Atlantique et les fleuves Volta et Ouémé.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_pays_territoires_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_pays_territoires_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Le continuum gbe s’étend sur quatre États. Les frontières politiques ne coïncident pas avec les limites linguistiques : Waci, Gen, Phla et d’autres parlers sont parlés des deux côtés du fleuve Mono entre le Togo et le Bénin.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les locuteurs autochtones se concentrent dans les moitiés septentrionales de la Volta Region (Ghana), du Togo, de la République du Bénin, et en partie dans les États d’Ogun et de Lagos (Nigéria). On estime le nombre de locuteurs autochtones à environ quatre millions.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'L’unité de la langue Gbe à travers ces quatre pays appelle une coopération culturelle et linguistique — Ghana, Togo, Bénin, Nigeria.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="pays" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Les quatre pays', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Chaque fiche pays détaille la répartition des parlers, les cadres universitaires et les institutions linguistiques.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_link_cards( gbe_le_gbe_pays_territoires_country_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="repartition" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Répartition des parlers', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Inventaire dialectologique recensant une cinquantaine de parlers, classés par État — avec recoupements transfrontaliers pour Waci, Gen, Phla et autres variétés côtières.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_parler_panels( gbe_le_gbe_inventaire_parler_panels() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="frontieres" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Frontières et continuité', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Les limites étatiques découpent un espace linguistique continu. Trois zones illustrent cette tension entre géographie politique et réalité dialectale :', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_pays_territoires_frontieres(), '--refs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="institutions" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Institutions linguistiques', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Chaque pays dispose d’organismes de promotion, de standardisation ou de recherche sur les variétés gbe — bases d’une coopération régionale.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_cards( gbe_le_gbe_langue_unique_institutions() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="cooperation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Coopération et cartographie', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_list( gbe_le_gbe_pays_territoires_cooperation() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'La cartographie interactive du continuum permet de visualiser la répartition des parlers et des sections dialectologiques sur l’ensemble du territoire gbe.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/carte-interactive/',
					'label' => __( 'Carte interactive', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
					'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/les-langues/',
					'label' => __( 'Fiches langues', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques pays et territoires.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_pays_territoires_stats() {
	return array(
		array(
			'value' => '4',
			'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '50+',
			'label' => __( 'Parlers recensés', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4M',
			'label' => __( 'Locuteurs autochtones', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_pays_territoires_nav() {
	return array(
		array(
			'id'    => 'generalites',
			'label' => __( 'Généralités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'pays',
			'label' => __( 'Pays', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'repartition',
			'label' => __( 'Répartition', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'frontieres',
			'label' => __( 'Frontières', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'institutions',
			'label' => __( 'Institutions', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'cooperation',
			'label' => __( 'Coopération', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes pays cliquables (hub vers fiches).
 *
 * @return array<int, array{code: string, title: string, body: string, url: string, meta: string}>
 */
function gbe_le_gbe_pays_territoires_country_cards() {
	$gh_count = count( gbe_le_gbe_parlers_ghana() );
	$tg_count = count( gbe_le_gbe_parlers_togo() );
	$bj_count = count( gbe_le_gbe_parlers_benin() );
	$ng_count = count( gbe_le_gbe_parlers_nigeria() );

	return array(
		array(
			'code'  => 'GH',
			'title' => __( 'Ghana', 'gbecosmolingua-core' ),
			'body'  => __( 'Volta Region — Éwé standard (Awlan), langue véhiculaire et objet d’enseignement à l’Université du Ghana (Legon).', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/pays-et-territoires/ghana/',
			'meta'  => sprintf(
				/* translators: %d: number of speech varieties */
				_n( '%d parler recensé', '%d parlers recensés', $gh_count, 'gbecosmolingua-core' ),
				$gh_count
			),
		),
		array(
			'code'  => 'TG',
			'title' => __( 'Togo', 'gbecosmolingua-core' ),
			'body'  => __( 'Éwé langue nationale — parlers Vhe, Gen, Ajé et Fon. Académie de la langue Éwé, Université du Bénin (Lomé).', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/pays-et-territoires/togo/',
			'meta'  => sprintf(
				_n( '%d parler recensé', '%d parlers recensés', $tg_count, 'gbecosmolingua-core' ),
				$tg_count
			),
		),
		array(
			'code'  => 'BJ',
			'title' => __( 'Bénin', 'gbecosmolingua-core' ),
			'body'  => __( 'Plus grande diversité dialectale — Fon, Aja, Gen, Gun, Waci, Phla-Phera, Ifè, Kotafon… Campagne d’alphabétisation 1975.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/pays-et-territoires/benin/',
			'meta'  => sprintf(
				_n( '%d parler recensé', '%d parlers recensés', $bj_count, 'gbecosmolingua-core' ),
				$bj_count
			),
		),
		array(
			'code'  => 'NG',
			'title' => __( 'Nigéria', 'gbecosmolingua-core' ),
			'body'  => __( 'États d’Ogun et de Lagos — Gun, Phelé, Alada, Weme. Recherches à Ife, Ibadan et Lagos.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/pays-et-territoires/nigeria/',
			'meta'  => sprintf(
				_n( '%d parler recensé', '%d parlers recensés', $ng_count, 'gbecosmolingua-core' ),
				$ng_count
			),
		),
	);
}

/**
 * Cartes frontières et continuité linguistique.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_pays_territoires_frontieres() {
	return array(
		array(
			'tag'   => __( 'Mono', 'gbecosmolingua-core' ),
			'title' => __( 'Fleuve Mono (Togo – Bénin)', 'gbecosmolingua-core' ),
			'body'  => __( 'Waci, Gen et Phla sont parlés des deux côtés du fleuve — la frontière politique ne correspond pas aux limites dialectales.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Côte', 'gbecosmolingua-core' ),
			'title' => __( 'Bande littorale atlantique', 'gbecosmolingua-core' ),
			'body'  => __( 'Continuité des parlers Vhe et Gen du Ghana au Togo et au Bénin — intercompréhension quasi totale le long du littoral.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Est', 'gbecosmolingua-core' ),
			'title' => __( 'Bénin – Nigéria', 'gbecosmolingua-core' ),
			'body'  => __( 'Gun, Phelé et Alada chevauchent la frontière bénino-nigériane — communautés gbe du delta et de la lagune.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Unité', 'gbecosmolingua-core' ),
			'title' => __( 'Au-delà des États', 'gbecosmolingua-core' ),
			'body'  => __( '« Langue dahoméenne » (Fon) vs « langue Éwé » (Togo) illustrent le découpage politique — linguistiquement, Gbe forme une langue unique.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Axes de coopération régionale.
 *
 * @return string[]
 */
function gbe_le_gbe_pays_territoires_cooperation() {
	return array(
		__( 'Harmonisation des orthographes et syllabaires gbe (Fon, Éwé, Gen, Aja, Waci…)', 'gbecosmolingua-core' ),
		__( 'Échanges entre Bureau of Ghana Languages, Académie Éwé, CENALA et National Language Centre', 'gbecosmolingua-core' ),
		__( 'Colloques et publications conjoints — universités de Legon, Lomé, Abomey-Calavi, Ife, Ibadan', 'gbecosmolingua-core' ),
		__( 'Cartographie numérique du continuum pour la recherche et l’enseignement', 'gbecosmolingua-core' ),
		__( 'Valorisation des parlers transfrontaliers (Waci, Gen, Phla) dans les politiques linguistiques', 'gbecosmolingua-core' ),
	);
}
