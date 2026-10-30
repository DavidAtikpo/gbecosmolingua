<?php
/**
 * Contenu éditorial — inventaire des parlers gbe (vue d'ensemble).
 *
 * Source : travaux de recherche sur le continuum gbe (inventaire dialectologique),
 * reconstitué pour GbeCosmoLingua à partir d'un document OCR.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Inventaire des parlers gbe ».
 *
 * @return string
 */
function gbe_le_gbe_inventaire_parlers_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Première partie — Gbe en histoire. Vue d’ensemble sur Gbe : généralités, inventaire des parlers et regroupement dialectologique.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_inventaire_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_inventaire_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'La communauté linguistique qui fait l’objet de ce corpus est un ensemble de parlers plus ou moins mutuellement intelligibles. Son territoire s’étend entre les cours inférieurs des fleuves Volta et Ouémé, de l’océan Atlantique au sud jusqu’en dessous de la latitude 10° Nord.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les locuteurs autochtones de Gbe se trouvent dans les moitiés septentrionales de la Volta Region (Ghana), du Togo, de la République du Bénin, et en partie dans les États d’Ogun et de Lagos (Nigéria). On estime le nombre de locuteurs autochtones à environ quatre millions.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Gbe est une langue kwa dont les voisines sont le yoruba, l’adja, l’akpafo, l’akan, le ga et le dangme. Des enclaves avatime, trolobi et aguna existent au sein des populations gbe. Toutes appartiennent à la famille Niger-Congo, mais à des branches différentes.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="inventaire" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Inventaire des parlers Gbe', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Au terme d’enquêtes auprès des populations concernées et à partir des travaux publiés sur l’aire gbe, on peut dénombrer une cinquantaine de parlers, répartis par État comme suit.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_parler_panels( gbe_le_gbe_inventaire_parler_panels() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="observations" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Quelques observations', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_inventaire_observations() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="regroupement" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Regroupement dialectologique', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'En tenant compte des réalités sociolinguistiques et en se fondant sur des données purement linguistiques, les parlers peuvent être regroupés provisoirement en cinq ensembles (voir chapitre 7 pour les bases détaillées) :', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_inventaire_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="ecriture" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Formes écrites', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'De ces parlers ont émergé une douzaine de formes écrites contemporaines :', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_inventaire_formes_ecrites() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'D’autres formes écrites sont en cours d’élaboration, notamment pour le Phelé, le Phla, etc. L’histoire de ces graphies et du glossonyme « Gbe » fait l’objet d’études approfondies dans la tradition linguistique gbe.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/',
					'label' => __( 'Regroupement des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
					'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/carte-interactive/',
					'label' => __( 'Carte interactive', 'gbecosmolingua-core' ),
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
 * Statistiques de l'inventaire.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_inventaire_stats() {
	return array(
		array(
			'value' => '50+',
			'label' => __( 'Parlers recensés', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4M',
			'label' => __( 'Locuteurs autochtones (est.)', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectologiques', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page inventaire.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_inventaire_nav() {
	return array(
		array(
			'id'    => 'generalites',
			'label' => __( 'Généralités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'inventaire',
			'label' => __( 'Inventaire', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'observations',
			'label' => __( 'Observations', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'regroupement',
			'label' => __( 'Regroupement', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'ecriture',
			'label' => __( 'Formes écrites', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Panneaux parlers par pays.
 *
 * @return array<int, array{code: string, title: string, parlers: string[]}>
 */
function gbe_le_gbe_inventaire_parler_panels() {
	return array(
		array(
			'code'    => 'GH',
			'title'   => __( 'Ghana', 'gbecosmolingua-core' ),
			'parlers' => gbe_le_gbe_parlers_ghana(),
		),
		array(
			'code'    => 'TG',
			'title'   => __( 'Togo', 'gbecosmolingua-core' ),
			'parlers' => gbe_le_gbe_parlers_togo(),
		),
		array(
			'code'    => 'BJ',
			'title'   => __( 'République du Bénin', 'gbecosmolingua-core' ),
			'parlers' => gbe_le_gbe_parlers_benin(),
		),
		array(
			'code'    => 'NG',
			'title'   => __( 'Nigéria', 'gbecosmolingua-core' ),
			'parlers' => gbe_le_gbe_parlers_nigeria(),
		),
	);
}

/**
 * Cartes observations sociolinguistiques.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_inventaire_observations() {
	return array(
		array(
			'tag'   => __( 'Suffixes', 'gbecosmolingua-core' ),
			'title' => __( 'Noms de parlers et de communautés', 'gbecosmolingua-core' ),
			'body'  => __( 'Chaque nom désigne une communauté sociologique et son parler. Pour le parler, on suffixe -gbe ; pour la communauté locutrice, on ajoute -vi, -no, -li ou -kpɔ (Gungbe, Hwegbe, Wacigbe…). Exceptions : Kogbe (non Kotafongbe), Movɔli, Agbomegbe ou Agbégbe.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Gengbe', 'gbecosmolingua-core' ),
			'title' => __( 'Peci, Anéxo, Gliji, Agói', 'gbecosmolingua-core' ),
			'body'  => __( 'Les gens de Peci disent parler Gbingbe. Ceux d’Anéxo, Gliji et Agói disent parler Gengbe — le Gen formant une section à part entière.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Ethnonymes', 'gbecosmolingua-core' ),
			'title' => __( 'Termes absents ou externes', 'gbecosmolingua-core' ),
			'body'  => __( 'Idù, Ajá et Ifè n’apparaissent pas dans l’inventaire (communautés vastes, peu identifiantes spontanément). Mina et Popo sont courants chez les non-locuteurs. Danxomegbe couvre Kpase, Arohún et Agbome.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes des cinq sections dialectologiques.
 *
 * @return array<int, array{tag: string, title: string, body: string, examples: string}>
 */
function gbe_le_gbe_inventaire_dialect_sections() {
	return array(
		array(
			'tag'       => 'Vhe',
			'title'     => __( 'Dialectes Vhe', 'gbecosmolingua-core' ),
			'body'      => __( '(i) Dialectes Vhe.', 'gbecosmolingua-core' ),
			'examples'  => 'Awlan, Peci, Hó, Waci, Adangbe, Avéno…',
		),
		array(
			'tag'       => 'Gen',
			'title'     => __( 'Dialectes Gen', 'gbecosmolingua-core' ),
			'body'      => __( '(ii) Dialectes Gen.', 'gbecosmolingua-core' ),
			'examples'  => 'Agói, Gliji, Anéxo',
		),
		array(
			'tag'       => 'Ajé',
			'title'     => __( 'Dialectes Ajé', 'gbecosmolingua-core' ),
			'body'      => __( '(iii) Dialectes Ajé.', 'gbecosmolingua-core' ),
			'examples'  => 'Dogbé, Hwe, Stédé, Sikpi',
		),
		array(
			'tag'       => 'Fon',
			'title'     => __( 'Dialectes Fon', 'gbecosmolingua-core' ),
			'body'      => __( '(iv) Dialectes Fon.', 'gbecosmolingua-core' ),
			'examples'  => 'Kpase, Agbome, Gun, Mina',
		),
		array(
			'tag'       => 'Phla-Phera',
			'title'     => __( 'Dialectes Phla-Phera', 'gbecosmolingua-core' ),
			'body'      => __( '(v) Dialectes Phla-Phera.', 'gbecosmolingua-core' ),
			'examples'  => 'Phla, Phelé, Ayizo, Tèfin, Toli, Tsapha',
		),
	);
}

/**
 * Cartes formes écrites.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_inventaire_formes_ecrites() {
	return array(
		array(
			'tag'   => __( 'Ghana / Togo', 'gbecosmolingua-core' ),
			'title' => 'Éwé / Ewe',
			'body'  => __( 'Au Togo et au Ghana : Éwé/Ewe, reposant sur Awlan mais comptant aussi des parlers voisins plus au nord.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Bénin', 'gbecosmolingua-core' ),
			'title' => __( 'Formes écrites béninoises', 'gbecosmolingua-core' ),
			'body'  => __( 'Fon (Kpase, Agbome), Aja (Dogbé, Hwe), Gen, Waci, Saxwe, Gun, Ifè, Kotafon, Tèfin, Weme, Ayizo. D’autres sont en préparation (Phelé, Phla…).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Parlers recensés au Ghana.
 *
 * @return string[]
 */
function gbe_le_gbe_parlers_ghana() {
	return array(
		'Tewun (Tongu)',
		'Awlan (Anlo)',
		'Awlangben',
		'Anféin',
		'Gbin',
		'Peci',
		'Kpindo',
		'Vhlin (Uli)',
		'Vé',
		'Avéno',
		'Wéoakpa',
		'Kpelen',
		'Fodome',
		'Dayin',
		'Hó',
		'Mafi',
		'Agavé',
		'Krimina',
	);
}

/**
 * Parlers recensés au Togo.
 *
 * @return string[]
 */
function gbe_le_gbe_parlers_togo() {
	return array(
		'Awlan',
		'Bo',
		'Agome',
		'Vo',
		'Waci',
		'Adangbe',
		'Trindji (Dangbe)',
		'Agu',
		'Wancé',
		'Vhucu',
		'Stédé',
		'Hwe',
		'Xwla (Phla)',
		'Fon',
		'Gen',
		'Anexo',
		'Gliji',
		'Agwe',
		'Kpesi',
	);
}

/**
 * Parlers recensés au Bénin.
 *
 * @return string[]
 */
function gbe_le_gbe_parlers_benin() {
	return array(
		'Waci',
		'Gen',
		'Agwe',
		'Phla',
		'Phelé',
		'Kotafon',
		'Saxwe',
		'Se',
		'Tsapha',
		'Sikpi',
		'Gbesi',
		'Dogbé',
		'Hwe',
		'Ci',
		'Ayizo',
		'Ifè',
		'Tèfin',
		'Kpase',
		'Arohún',
		'Maxi',
		'Agbome',
		'Weme',
		'Movɔli',
		'Gun',
		'Setto',
	);
}

/**
 * Parlers recensés au Nigéria.
 *
 * @return string[]
 */
function gbe_le_gbe_parlers_nigeria() {
	return array(
		'Alada',
		'Gun',
		'Phelé',
		'Asonté',
		'Weme',
		'Gbekon',
		'Savi',
	);
}
