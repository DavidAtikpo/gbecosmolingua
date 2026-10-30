<?php
/**
 * Contenu éditorial — travaux scientifiques récents sur Gbe.
 *
 * Reconstitué pour GbeCosmoLingua à partir d'un document OCR
 * (monographies universitaires depuis 1966).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Travaux scientifiques récents sur Gbe ».
 *
 * @return string
 */
function gbe_le_gbe_travaux_scientifiques_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Chapitre 5 — Travaux scientifiques récents sur Gbe : cadres de recherche, monographies, lexicographie et synthèses (depuis 1966).', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_travaux_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_travaux_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_le_gbe_capo_feature_card_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Après l’historique de Gbe sous plusieurs angles, il convient de faire le point des travaux récents les plus caractéristiques. Sont retenus ici surtout les monographies universitaires produites à partir de 1966, répondant — au moins minimalement — à une certaine rigueur scientifique.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Ce chapitre présente les cadres de recherche, puis certains travaux de description, de lexicographie et de synthèse, avant d’en tirer quelques conclusions pour la promotion de la langue.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="cadres" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cadres de recherche', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Dans les quatre pays où Gbe est langue du terroir, des universités et centres nationaux offrent des cadres pour la recherche.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_cards( gbe_le_gbe_travaux_cadres() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'S’y ajoutent la Société internationale de linguistique (SIL) et d’autres agences, ainsi que des universités étrangères (Europe, États-Unis, Canada) où de nombreuses thèses de doctorat sur les parlers Gbe sont soutenues — souvent par des chercheurs autochtones.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="institutions-reference" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Institutions et chercheurs de référence', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'GbeCosmoLingua recense les principaux cadres de recherche sur le continuum Gbe (Ghana, Togo, Bénin, Nigeria). Les recherches existent, mais elles sont dispersées entre universités, chercheurs et enquêtes de terrain.', 'gbecosmolingua-core' ); ?></p>

			<div class="gbe-chapter-disclaimer" role="note">
				<p><strong><?php esc_html_e( 'Note importante', 'gbecosmolingua-core' ); ?></strong> — <?php esc_html_e( 'Les institutions listées ci-dessous ne sont pas nécessairement partenaires officiels de GbeCosmoLingua. Il s’agit de repères scientifiques pour orienter la veille documentaire et les collaborations futures — pas d’un réseau partenaire formalisé.', 'gbecosmolingua-core' ); ?></p>
			</div>

			<?php echo gbe_chapter_institution_refs( gbe_le_gbe_travaux_institutions_reference() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			<h3><?php esc_html_e( 'Carte du continuum', 'gbecosmolingua-core' ); ?></h3>
			<p><?php esc_html_e( 'Les données Gbe sont réparties le long d’un arc Ghana → Togo → Bénin → Nigeria. GbeCosmoLingua vise à en devenir le point de consolidation, dans la continuité de la vision globale de Capo (cinq sections : Vhe, Gen, Aja, Fon, Phla-Pherá).', 'gbecosmolingua-core' ); ?></p>
			<?php
			echo gbe_chapter_schema_box( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				gbe_le_gbe_travaux_continuum_schema(),
				__( 'Répartition des recherches Gbe le long du continuum Ghana–Togo–Bénin–Nigeria', 'gbecosmolingua-core' )
			);
			?>

			<div class="gbe-chapter-callout gbe-chapter-callout--collab">
				<p><?php esc_html_e( 'Vous représentez l’une de ces institutions ou menez des recherches comparables sur le continuum Gbe ? Proposons une collaboration scientifique.', 'gbecosmolingua-core' ); ?></p>
				<p><a class="gbe-chapter-cta-link" href="<?php echo esc_url( home_url( '/nous-soutenir/devenir-partenaire/' ) ); ?>"><?php esc_html_e( 'Proposer une collaboration →', 'gbecosmolingua-core' ); ?></a></p>
			</div>
		</section>

		<section id="description" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Travaux de description', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Depuis 1966, de nombreuses thèses de maîtrise et de doctorat documentent un parler ou un aspect du continuum. Sélection chronologique annotée :', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_timeline( gbe_le_gbe_travaux_timeline() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Les auteurs de ces mémoires et thèses (en particulier les chercheurs autochtones) poursuivent leurs recherches. Lacune notable : dialectes Phla-Phera. La phonologie est relativement fournie ; la morpho-syntaxe vient en second ; la sémantique reste peu explorée malgré l’existence de dictionnaires.', 'gbecosmolingua-core' ); ?></p>
				<p><?php esc_html_e( 'Des recherches récentes mobilisent aussi la dialectométrie, la dialectologie et l’approche comparative de Capo — par exemple pour situer le Gengbe par rapport à l’Ewegbe. C’est le type de méthodologie que GbeCosmoLingua entend développer pour cartographier les variétés au sein du continuum.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="lexicographie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Travaux de lexicographie', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Outre les monographies descriptives, existent des dictionnaires bilingues Gbe–langue européenne, utiles comme point de départ pour un dictionnaire gbe moderne monolingue ou multilingue.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_travaux_dictionnaires() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'Quatre des cinq sections majeures du continuum sont ainsi représentées en lexicographie ; les dialectes Phla-Phera restent les moins documentés.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="syntheses" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Travaux d’ensemble et synthèses', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_travaux_syntheses() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'C’est au colloque de Porto-Novo (1977) que la suggestion du terme « Gbe » pour désigner l’ensemble du continuum dialectal fut faite en public. La bibliographie de Duthie (1981) consacre ce glossonyme.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="conclusions" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Conclusions', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Des chercheurs et des institutions éprouvés existent dans les quatre pays Gbe, malgré des conditions de travail inégales. Il existe des travaux scientifiques exploitables pour la promotion de Gbe. Beaucoup sont en français ou en anglais, et les chercheurs utilisant l’une tendent parfois à ignorer l’autre — d’où le besoin d’une concertation accrue et d’échanges constants.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Le Groupe de travail Gbe de la Société linguistique de l’Afrique occidentale (SLAO, 1980) visait précisément à combler ces lacunes et à renforcer les conditions objectives de promotion de la langue.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/linguistique/bibliotheque/',
					'label' => __( 'Bibliothèque linguistique', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/potentialites-lexicales/',
					'label' => __( 'Potentialités lexicales', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/hounkpati-b-c-capo/',
					'label' => __( 'Hounkpati B. C. Capo', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/nous-soutenir/devenir-partenaire/',
					'label' => __( 'Proposer une collaboration', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques clés du chapitre.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_travaux_stats() {
	return array(
		array(
			'value' => '1966',
			'label' => __( 'Début des monographies modernes', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '50+',
			'label' => __( 'Thèses et mémoires recensés', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '770+',
			'label' => __( 'Entrées bibliographiques (Duthie, 1981)', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Pays avec cadres universitaires', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '6',
			'label' => __( 'Institutions de référence recensées', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Ancres de navigation in-page.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_travaux_nav() {
	return array(
		array(
			'id'    => 'generalites',
			'label' => __( 'Généralités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'cadres',
			'label' => __( 'Cadres', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'institutions-reference',
			'label' => __( 'Institutions', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'description',
			'label' => __( 'Description', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'lexicographie',
			'label' => __( 'Lexicographie', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'syntheses',
			'label' => __( 'Synthèses', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'conclusions',
			'label' => __( 'Conclusions', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes cadres de recherche par pays.
 *
 * @return array<int, array{code: string, title: string, body: string}>
 */
function gbe_le_gbe_travaux_cadres() {
	return array(
		array(
			'code'  => 'GH',
			'title' => __( 'Ghana', 'gbecosmolingua-core' ),
			'body'  => __( 'Université du Ghana (Legon), Université du Cap Coast — département de linguistique, Language Centre, Institut d’études africaines. L’Éwé occupe une place centrale.', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'TG',
			'title' => __( 'Togo', 'gbecosmolingua-core' ),
			'body'  => __( 'Université du Bénin (Lomé), Institut national de la recherche scientifique — département de linguistique et langues africaines. L’Éwé est langue nationale officielle.', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'BJ',
			'title' => __( 'République du Bénin', 'gbecosmolingua-core' ),
			'body'  => __( 'Université nationale du Bénin, CENALA — linguistique et traditions orales. Projet Atlas et monographies sociolinguistiques par langue.', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'NG',
			'title' => __( 'Nigéria', 'gbecosmolingua-core' ),
			'body'  => __( 'Ife (État d’Ogun), Ibadan, Lagos — recherches historiques et linguistiques sur les locuteurs Gbe, langue minoritaire face au yoruba et à l’igbo.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Institutions scientifiques de référence (non partenaires officiels).
 *
 * @return array<int, array{
 *     priority: int,
 *     code: string,
 *     country: string,
 *     title: string,
 *     focus: string,
 *     researchers?: string[],
 *     langues?: string[],
 *     note?: string
 * }>
 */
function gbe_le_gbe_travaux_institutions_reference() {
	return array(
		array(
			'priority'    => 1,
			'code'        => 'GH',
			'country'     => __( 'Ghana', 'gbecosmolingua-core' ),
			'title'       => __( 'University of Ghana — Department of Linguistics', 'gbecosmolingua-core' ),
			'focus'       => __( 'Recherche sur l’Éwé et les langues Gbe : documentation, syntaxe, sémantique, lexicographie et linguistique anthropologique.', 'gbecosmolingua-core' ),
			'researchers' => array( 'Dr Mercy Bobuafor' ),
			'langues'     => array( 'Éwé', 'Gbe' ),
		),
		array(
			'priority'    => 1,
			'code'        => 'US',
			'country'     => __( 'États-Unis', 'gbecosmolingua-core' ),
			'title'       => __( 'University of Florida', 'gbecosmolingua-core' ),
			'focus'       => __( 'Description et documentation des langues Gbe ; syntaxe-sémantique ; langues Kwa d’Afrique de l’Ouest.', 'gbecosmolingua-core' ),
			'researchers' => array( 'Prof. James Essegbey' ),
			'langues'     => array( 'Éwé', 'Gen', 'Aja', 'Fon' ),
			'note'        => __( 'Interlocuteur scientifique potentiel pour un corpus comparatif Gbe.', 'gbecosmolingua-core' ),
		),
		array(
			'priority'    => 1,
			'code'        => 'TG',
			'country'     => __( 'Togo', 'gbecosmolingua-core' ),
			'title'       => __( 'Université de Lomé — tradition scientifique Capo', 'gbecosmolingua-core' ),
			'focus'       => __( 'Histoire importante des recherches Gbe ; publication de Renaissance du Gbe (Institut national des sciences de l’éducation, Université du Bénin, Lomé, 1986).', 'gbecosmolingua-core' ),
			'langues'     => array( 'Éwé', 'Gen' ),
			'note'        => __( 'Environnement académique togolais incontournable pour le continuum — lien historique avec les travaux de Capo.', 'gbecosmolingua-core' ),
		),
		array(
			'priority'    => 1,
			'code'        => 'BJ',
			'country'     => __( 'Bénin', 'gbecosmolingua-core' ),
			'title'       => __( 'Université d’Abomey-Calavi', 'gbecosmolingua-core' ),
			'focus'       => __( 'Travaux sur le Fon, l’Aja, le Gun et autres langues nationales ; linguistique africaine, dialectologie et sociolinguistique.', 'gbecosmolingua-core' ),
			'langues'     => array( 'Fon', 'Aja', 'Gun', 'Gen', 'Xwla', 'Ayizo' ),
		),
		array(
			'priority'    => 2,
			'code'        => 'NG',
			'country'     => __( 'Nigeria', 'gbecosmolingua-core' ),
			'title'       => __( 'University of Benin', 'gbecosmolingua-core' ),
			'focus'       => __( 'Travaux linguistiques sur les langues du sud du Nigeria, dans la zone orientale du continuum Gbe.', 'gbecosmolingua-core' ),
			'langues'     => array( 'Gbe' ),
			'note'        => __( 'Permet d’étendre l’observatoire au-delà de l’axe Togo–Bénin vers le Ghana et le Nigeria.', 'gbecosmolingua-core' ),
		),
		array(
			'priority'    => 2,
			'code'        => 'TG/BJ',
			'country'     => __( 'Togo · Bénin', 'gbecosmolingua-core' ),
			'title'       => __( 'SIL Togo-Bénin', 'gbecosmolingua-core' ),
			'focus'       => __( 'Enquêtes sociolinguistiques directement utiles au continuum Gbe (Xwla, Tofin, Ci, etc.) ; évaluation de l’extension des ressources Fon, Gen ou Gun à d’autres communautés.', 'gbecosmolingua-core' ),
			'langues'     => array( 'Xwla', 'Tofin', 'Ci', 'Fon', 'Gen', 'Gun' ),
			'note'        => __( 'Organisme de documentation — non universitaire, mais source précieuse pour GbeCosmoLingua.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Schéma ASCII du continuum Gbe.
 *
 * @return string
 */
function gbe_le_gbe_travaux_continuum_schema() {
	return "GHANA          Éwé ─────────┐\n"
		. "                              │\n"
		. "TOGO           Éwé – Gen ─────┤\n"
		. "                              ├──→  OBSERVATOIRE DU CONTINUUM GBE\n"
		. "BÉNIN          Aja – Fon – Gun – Xwla – Tofin – Ci …\n"
		. "                              │\n"
		. "NIGERIA        variétés Gbe ──┘";
}

/**
 * Frise chronologique des monographies.
 *
 * @return array<int, array{year: string, author: string, title: string, note?: string}>
 */
function gbe_le_gbe_travaux_timeline() {
	return array(
		array(
			'year'   => '1966',
			'author' => 'Gilbert Ansre',
			'title'  => 'Grammatical units of Ewe (Ph.D. Londres)',
			'note'   => __( 'Référence moderne après Westermann (1907)', 'gbecosmolingua-core' ),
		),
		array(
			'year'   => '1969',
			'author' => 'Olabiyi J. Yai',
			'title'  => 'Preliminary notes on the phonology of Fon (Ibadan)',
		),
		array(
			'year'   => '1971',
			'author' => 'Herbert Stahlke',
			'title'  => 'Topics in Ewe Phonology — parler Kpindo (UCLA)',
		),
		array(
			'year'   => '1972',
			'author' => 'George N. Clements',
			'title'  => 'The general syntax of Ewe (Londres)',
		),
		array(
			'year'   => '1973',
			'author' => 'K. N. Gbekɔbu',
			'title'  => 'Phonologie comparée Vhe / Gen — « Pour un alphabet commun »',
		),
		array(
			'year'   => '1978',
			'author' => 'A.K. Afeli',
			'title'  => 'Essai d’analyse phonologique de l’Éwéddomegbe (Paris III)',
		),
		array(
			'year'   => '1979',
			'author' => 'Marc-Laurent Hazoumé',
			'title'  => 'Description du Gun — phonologie, grammaire, orthographe (Paris V)',
		),
		array(
			'year'   => '1979',
			'author' => 'Jacques Rongier',
			'title'  => 'Description de l’Éwé (Paris VII)',
		),
		array(
			'year'   => '1980',
			'author' => 'Ayaba Jondoh',
			'title'  => 'Aspects de la syntaxe du Gengbe (Indiana)',
		),
		array(
			'year'   => '1980',
			'author' => 'Rémy Bonfante-Richard',
			'title'  => 'Systématique phonologique et grammaire du Gengbe (Paris V → Harmattan, 1981)',
		),
		array(
			'year'   => '1980',
			'author' => 'Albert B. Akoha',
			'title'  => 'Éléments d’une grammaire du Fongbe — morpho-syntaxe (Paris V)',
		),
		array(
			'year'   => '1981–83',
			'author' => __( 'Mémoires UNB', 'gbecosmolingua-core' ),
			'title'  => __( 'Phonologie Fon, Dogbé, Saxwe, comparaisons Kwa (Gbeto, da Cruz, Kinhou…)', 'gbecosmolingua-core' ),
		),
		array(
			'year'   => '1984',
			'author' => 'Comlan Tossa',
			'title'  => 'Éléments de phonologie du Saxwegbe',
		),
		array(
			'year'   => '1984',
			'author' => 'Taovi Tchitchi',
			'title'  => 'Systématique de l’Ajagbe — première monographie sur l’Ajagbe (Paris VII)',
		),
	);
}

/**
 * Cartes dictionnaires bilingues.
 *
 * @return array<int, array{tag: string, title: string, body: string, meta?: string}>
 */
function gbe_le_gbe_travaux_dictionnaires() {
	return array(
		array(
			'tag'   => 'Éwé',
			'title' => 'Westermann (1910)',
			'body'  => __( 'Ewe-German-English Dictionary — dictionnaire de référence historique, rééditions multiples.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Éwé',
			'title' => 'Adornu & Ardzena (1975)',
			'body'  => __( 'Dictionnaire Éwé–Français — Institut national de la recherche scientifique du Togo.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Fon',
			'title' => 'Kponton & Xwégbénu (1963)',
			'body'  => __( 'Dictionnaire Fon–Français, réédité ; complété par Rassidi, Dictionnaire français–Fon (1974).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Aja',
			'title' => 'Marguéleguy & catéchistes',
			'body'  => __( 'Éléments pour un dictionnaire aja–français ; mémoire Natabou (1979, Sarrebruck).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Gen',
			'title' => 'Roberto Pazzi (1981)',
			'body'  => __( 'Dictionnaire de la langue Gen — INSE, Université du Bénin.', 'gbecosmolingua-core' ),
			'meta'  => __( 'Quatre sections majeures du continuum couvertes', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes synthèses et ouvrages d’ensemble.
 *
 * @return array<int, array{tag: string, title: string, body: string, meta?: string}>
 */
function gbe_le_gbe_travaux_syntheses() {
	return array(
		array(
			'tag'   => __( 'Thésaurus', 'gbecosmolingua-core' ),
			'title' => 'R. Pazzi (1976)',
			'body'  => __( 'L’homme, le Bénin, Fon et son univers — étude lexicale et sémantique comparée Aja, Éwé, Fon, Gen.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Colloque', 'gbecosmolingua-core' ),
			'title' => 'Peuples du Golfe du Bénin (1984)',
			'body'  => __( 'Actes Porto-Novo (1977), Karthala — histoire, linguistique, littératures orales, sociologie, religions.', 'gbecosmolingua-core' ),
			'meta'  => __( 'Naissance publique du glossonyme « Gbe »', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Bibliographie', 'gbecosmolingua-core' ),
			'title' => 'Duthie & Vlaardingerbroek (1981)',
			'body'  => __( 'Bibliography of Gbe — plus de 770 entrées, index par dialecte (Bâle).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Comparatif', 'gbecosmolingua-core' ),
			'title' => 'K. N. Gbekɔbu (1981)',
			'body'  => __( 'A Diachronic Phonology of the Gbe Dialect Cluster — 18 parlers, proto-Gbe, orthographe uniforme (Ghana).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Thèses et monographies descriptives (sélection — liste simple legacy).
 *
 * @return string[]
 */
function gbe_le_gbe_these_description() {
	return array(
		'1966 — Gilbert Ansre (Ghana), Ph.D. Londres : Grammatical units of Ewe (référence moderne après Westermann, 1907).',
		'1969 — Olabiyi J. Yai (Bénin), thèse Ibadan : Preliminary notes on the phonology of Fon.',
		'1971 — Herbert Stahlke (USA), Ph.D. UCLA : Topics in Ewe Phonology (parler Kpindo, tons).',
		'1972 — George N. Clements (USA), Ph.D. Londres : The general syntax of Ewe.',
		'1973 — K. N. Gbekɔbu, mémoire de maîtrise (Bénin) : phonologie comparée Vhe / Gen ; chapitre « Pour un alphabet commun ».',
		'1978 — A.K. Afeli (Togo), thèse Paris III : Essai d’analyse phonologique de l’Éwéddomegbe (parler Vhe).',
		'1979 — Marc-Laurent Hazoumé (Bénin), thèse Paris V : Description du Gun (phonologie, grammaire, orthographe).',
		'1979 — Jacques Rongier (France), thèse Paris VII : Description de l’Éwé.',
		'1980 — Ayaba Jondoh (Togo), Ph.D. Indiana : Aspects de la syntaxe du Gengbe.',
		'1980 — Rémy Bonfante-Richard (France), thèse Paris V : Systématique phonologique et grammaire du Gengbe (publié Harmattan, 1981).',
		'1980 — Albert B. Akoha (Bénin), thèse Paris V : Éléments d’une grammaire du Fongbe (morpho-syntaxe).',
		'1981–1983 — Mémoires de maîtrise (Université du Bénin) : phonologie Fon, Dogbé, Saxwe, comparaisons Kwa, etc. (Gbeto, Houndekan, da Cruz, Kinhou, Atchoglo…).',
		'1984 — Comlan Tossa : Éléments de phonologie du Saxwegbe.',
		'1984 — Taovi Tchitchi, thèse Paris VII : Systématique de l’Ajagbe (première monographie scientifique sur l’Ajagbe).',
	);
}
