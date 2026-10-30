<?php
/**
 * Contenu éditorial — regroupement des parlers gbe (chapitre 7).
 *
 * Classification dialectologique en cinq sections : Vhe, Gen, Ajé, Fon, Phla-Phera.
 * Reconstitué pour GbeCosmoLingua à partir d'un document OCR (H. C. Capo / Gbekɔbu).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Regroupement des parlers gbe ».
 *
 * @return string
 */
function gbe_le_gbe_regroupement_parlers_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Chapitre 7 — Un regroupement des parlers Gbe : méthodologie dialectologique et cinq sections du continuum.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_regroupement_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_regroupement_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Si l’on en est à parler de la renaissance du Gbe, c’est que l’on dispose de données plus précises sur le continuum. Ce chapitre pose le problème de la viabilité des formes écrites actuelles et propose un regroupement linguistique rigoureux.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les grandes lignes du regroupement figurent déjà à la fin du chapitre premier ; ici sont explicitées la méthodologie et les bases phonologiques.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="antecedents" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Notes sur les tentatives antérieures', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Les études antérieures reconnaissaient des parlers apparentés, mais les classifications restaient vagues — surtout géographiques, avec des critères d’intelligibilité plutôt que strictement linguistiques.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_regroupement_antecedents() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'D’où l’insuffisance de ces tentatives pour un regroupement dialectologique rigoureux — et la nécessité d’une méthode fondée sur les innovations phonologiques.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="methodologie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Méthodologie de regroupement', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Une classification linguistique doit partir de l’inventaire des parlers, les décrire, puis les regrouper selon leurs degrés d’affinité et leur histoire commune.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_regroupement_niveaux_analyse(), '--angles' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'Cette étude privilégie les innovations phonologiques non conditionnées, complétées par les conditionnées et morphophonologiques, interprétées à partir de la reconstruction du proto-Gbe. La syntaxe et la sociolinguistique sont prises en compte marginalement.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="sections" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Regroupement proposé : cinq sections', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Chaque section est définie par des innovations phonologiques partagées et un noyau de parlers mutuellement intelligibles.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_dialect_detail_panels( gbe_le_gbe_regroupement_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="schema" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Schéma du regroupement', 'gbecosmolingua-core' ); ?></h2>
			<?php
			echo gbe_chapter_schema_box( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				gbe_le_gbe_regroupement_schema(),
				__( 'Arbre dialectologique du continuum Gbe', 'gbecosmolingua-core' )
			);
			?>
		</section>

		<section id="conclusion" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Conclusion', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_regroupement_conclusions(), '--refs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'La différence avec Pazzi (1979) relève de divergences méthodologiques : son regroupement part de l’histoire des populations ; celui-ci part de l’histoire des parlers eux-mêmes. Ce regroupement est linguistiquement justifié et complète l’inventaire du chapitre 1.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
					'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/dialectologie/',
					'label' => __( 'Dialectologie', 'gbecosmolingua-core' ),
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
 * Statistiques du regroupement.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_regroupement_stats() {
	return array(
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'Niveaux d’analyse', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '50+',
			'label' => __( 'Parlers classés', 'gbecosmolingua-core' ),
		),
		array(
			'value' => 'Proto',
			'label' => __( 'Base : proto-Gbe', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_regroupement_nav() {
	return array(
		array(
			'id'    => 'generalites',
			'label' => __( 'Généralités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'antecedents',
			'label' => __( 'Antécédents', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'methodologie',
			'label' => __( 'Méthodologie', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'sections',
			'label' => __( 'Sections', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'schema',
			'label' => __( 'Schéma', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'conclusion',
			'label' => __( 'Conclusion', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes classifications antérieures.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_regroupement_antecedents() {
	return array(
		array(
			'tag'   => '1890',
			'title' => 'Ellis',
			'body'  => __( 'Cinq « dialectes principaux » : Maxi, Fon, Phla, Anfoin, Awlan.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1978',
			'title' => 'Mamattah',
			'body'  => __( 'Huit variantes principales : Aja, Gen, Gun, Phelé, Fon, Waci, Vhemeawo, Awlan-Towun-awo.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1952',
			'title' => 'Westermann & Bryan ; de Lavergne de Tressan',
			'body'  => __( 'Isolent Gen, Fon, Awlan, Gun et Aja sans regroupement en sections.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1961',
			'title' => 'Ansre (d’après Westermann 1930)',
			'body'  => __( 'Trois sections : occidentale (dialectes de l’intérieur + Awlan), centrale (Waci, Gen, Aja), orientale (Gun, Fon, Maxi).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1951',
			'title' => 'Riehstein',
			'body'  => __( 'Awlangbe ; Gengbe ou Mina ; Fongbe (Fon proprement dit + Gun ou Alada).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Quatre niveaux d’analyse des innovations.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_regroupement_niveaux_analyse() {
	return array(
		array(
			'tag'   => 'i',
			'title' => __( 'Vocabulaire', 'gbecosmolingua-core' ),
			'body'  => __( 'Niveau le plus changeant — difficile à mesurer objectivement pour le regroupement.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'ii',
			'title' => __( 'Syntaxe', 'gbecosmolingua-core' ),
			'body'  => __( 'Structures universelles — peu révélatrice des affinités dialectales.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'iii',
			'title' => __( 'Morphologie', 'gbecosmolingua-core' ),
			'body'  => __( 'Utile via la morphophonologie — complément de la phonologie.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'iv',
			'title' => __( 'Phonologie', 'gbecosmolingua-core' ),
			'body'  => __( 'Innovations non conditionnées = indices les plus sûrs pour l’histoire commune — privilégiées ici.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Panneaux des cinq sections dialectologiques.
 *
 * @return array<int, array{tag: string, title: string, innovations: string[], parlers: string[], body: string}>
 */
function gbe_le_gbe_regroupement_dialect_sections() {
	return array(
		array(
			'tag'          => 'Vhe',
			'title'        => __( 'Dialectes Vhe', 'gbecosmolingua-core' ),
			'innovations'  => gbe_le_gbe_innovations_vhe(),
			'parlers'      => gbe_le_gbe_section_vhe(),
			'body'         => __( 'Intercompréhension quasi totale entre locuteurs. Awlan = dialecte prestigieux, base de l’Éwé standard. Waci écrit coexiste avec l’Éwé écrit. Adangbe est un dialecte Vhe (Sprigge 1967), distinct du Dangme (langue non gbe).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'          => 'Gen',
			'title'        => __( 'Dialectes Gen', 'gbecosmolingua-core' ),
			'innovations'  => gbe_le_gbe_innovations_gen(),
			'parlers'      => gbe_le_gbe_section_gen(),
			'body'         => __( 'Gliji, Agói et Anéxo : intercompréhension à 100 % ; les locuteurs ne disent que parler Gengbe. Le Gen mérite sa place à part dans le continuum (innovation /p/, entre autres).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'          => 'Ajé',
			'title'        => __( 'Dialectes Ajé', 'gbecosmolingua-core' ),
			'innovations'  => gbe_le_gbe_innovations_aje(),
			'parlers'      => gbe_le_gbe_section_aje(),
			'body'         => __( 'Hwe, Dogbé, Stédé : intercompréhension totale ; quasi-totale avec Sikpi (palatalisation moins développée). L’Aja écrit repose sur Dogbé et Hwe, mais semble s’étendre à Sa et Raxé (non-Aja).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'          => 'Fon',
			'title'        => __( 'Dialectes Fon', 'gbecosmolingua-core' ),
			'innovations'  => gbe_le_gbe_innovations_fono(),
			'parlers'      => gbe_le_gbe_section_fono(),
			'body'         => __( 'Kpase, Arohún, Agbome, Gun, Maxi, Weme : intercompréhension quasi totale. Gun écrit coexiste avec Fon écrit. Les Gun tendent à refuser l’appellation Fon (Fongbe = Danxomegbe) pour des raisons historiques et sociologiques.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'          => 'Phla-Phera',
			'title'        => __( 'Dialectes Phla-Phera', 'gbecosmolingua-core' ),
			'innovations'  => gbe_le_gbe_innovations_phla_phera(),
			'parlers'      => gbe_le_gbe_section_phla_phera(),
			'body'         => __( 'Tsapha, Kotafon, Ayizo, Toli, Alada : intercompréhension appréciable mais unité moins compacte. Groupe conventionnel (territoire non continu) ; différences lexicales sensibles, moins phonologiques. Aladagbe se distingue nettement des Fon (préfixes nominaux).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes de conclusion par section.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_regroupement_conclusions() {
	return array(
		array(
			'tag'   => 'Vhe',
			'title' => __( 'Unité ressentie', 'gbecosmolingua-core' ),
			'body'  => __( 'Unité subjective forte — Awlan prestigieux, base de l’Éwé standard (cf. Pazzi sur la « langue Éwè »).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Gen',
			'title' => __( 'Haut prestige', 'gbecosmolingua-core' ),
			'body'  => __( 'Prestige dans toute l’aire gbe ; locuteurs d’Awlan d’Atsukophé, Ga de Gliji, Fante d’Anéxo se disent Gengbe (cf. Pazzi).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ajé',
			'title' => __( 'Conscience d’unité', 'gbecosmolingua-core' ),
			'body'  => __( 'Correspond à la « langue Aja » de Pazzi, qui semble inclure Raxé et Se.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Fon',
			'title' => __( 'Homogène', 'gbecosmolingua-core' ),
			'body'  => __( 'Relativement homogène ; Gun et Weme tendent à s’exclure en faisant de Fongbe un synonyme de Danxomegbe.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Phla-Phera',
			'title' => __( 'Label conventionnel', 'gbecosmolingua-core' ),
			'body'  => __( 'Nom purement conventionnel — Pazzi (1979) parle plutôt des langues Ayizo, Sahwe (Tsaphè) et Xweda (Phelé).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Innovations phonologiques des dialectes Vhe.
 *
 * @return string[]
 */
function gbe_le_gbe_innovations_vhe() {
	return array(
		__( 'Fricatives bilabiales /f/ et /v/ à partir des fricatives labio-vélaires du proto-Gbe', 'gbecosmolingua-core' ),
		__( 'Convergence des voyelles */ɛ/ et */e/ en /e/, /ɛ/ ou /ə/ selon le dialecte', 'gbecosmolingua-core' ),
		__( 'Sonantes vélaires [ɣ] et [ŋ] à partir de */w/ et */Hw/', 'gbecosmolingua-core' ),
		__( 'Convergence de */Hw/ et */w/ en /w/', 'gbecosmolingua-core' ),
		__( 'Développement des aspirées */th/ et */dh/ en occlusives /t/ et /d/', 'gbecosmolingua-core' ),
		__( 'Au plus deux préfixes nominaux : /à-/ et /è-/, /è-/ ou /é-/', 'gbecosmolingua-core' ),
	);
}

/**
 * Innovations phonologiques des dialectes Gen.
 *
 * @return string[]
 */
function gbe_le_gbe_innovations_gen() {
	return array(
		__( 'Occlusive bilabiale /p/ à partir de */Xw/ du proto-Gbe', 'gbecosmolingua-core' ),
		__( 'Développement de */Hw/ en /w/ ou /Rw/ selon les voyelles', 'gbecosmolingua-core' ),
		__( 'Innovation de [ŋ] et [ɣ] à partir de */w/', 'gbecosmolingua-core' ),
		__( 'Simplification des affriquées */ts/ et */dz/ en fricatives /s/ et /z/', 'gbecosmolingua-core' ),
		__( 'Convergence des aspirées et occlusives laminales en /t/ et /d/', 'gbecosmolingua-core' ),
		__( 'Séquences */ty/, */ky/ et */dy/, */gy/ développées en /c/ et /j/', 'gbecosmolingua-core' ),
		__( 'Convergence */ɛ/ et */e/ en /e/', 'gbecosmolingua-core' ),
		__( 'Préfixes nominaux : /à-/ et facultativement /è-/', 'gbecosmolingua-core' ),
	);
}

/**
 * Innovations phonologiques des dialectes Ajé.
 *
 * @return string[]
 */
function gbe_le_gbe_innovations_aje() {
	return array(
		__( 'Convergence */ts/, */s/ et */dz/, */z/ en /s/ et /z/', 'gbecosmolingua-core' ),
		__( 'Développement de */th/ et */dh/ en /t/ et /d/', 'gbecosmolingua-core' ),
		__( 'Séquences */ky/, */ty/ et */gy/, */dy/ en /c/ et /j/', 'gbecosmolingua-core' ),
		__( 'Palatalisation de /t/ et /d/ devant voyelles fermées en /c/ et /j/', 'gbecosmolingua-core' ),
		__( 'Variantes chuintantes [ʃ] et [ʒ] de /s/ et /z/ devant voyelles fermées', 'gbecosmolingua-core' ),
		__( 'Convergence */Hw/ et */w/ en /w/ ; [ŋ], [ŋw] et [ɣ] à partir de */w/', 'gbecosmolingua-core' ),
		__( 'Convergence */ɛ/ et */e/ en /e/', 'gbecosmolingua-core' ),
		__( 'Préfixes nominaux : /à-/ et /è-/', 'gbecosmolingua-core' ),
	);
}

/**
 * Innovations phonologiques des dialectes Fon.
 *
 * @return string[]
 */
function gbe_le_gbe_innovations_fono() {
	return array(
		__( 'Convergence */ts/, */th/, */s/ et */dz/, */dh/, */z/ en /s/ et /z/', 'gbecosmolingua-core' ),
		__( 'Développement de /c/ et /j/ à partir de */ky/, */ty/ et */gy/, */dy/', 'gbecosmolingua-core' ),
		__( 'Convergence */Rw/ et */Hw/ en /Rw/', 'gbecosmolingua-core' ),
		__( 'Maintien de l’opposition */ɛ/ vs */e/ du proto-Gbe', 'gbecosmolingua-core' ),
		__( 'Préfixes nominaux : /a-/ et /e-/ ou /o-/ selon le dialecte', 'gbecosmolingua-core' ),
	);
}

/**
 * Innovations phonologiques des dialectes Phla-Phera.
 *
 * @return string[]
 */
function gbe_le_gbe_innovations_phla_phera() {
	return array(
		__( 'Évolution */ts/ et */dz/ en /s/ et /z/', 'gbecosmolingua-core' ),
		__( 'Développement de */th/ et */dh/ vers /s/, /z/ ou /t/, /d/', 'gbecosmolingua-core' ),
		__( 'Convergence */Rw/ et */Hw/ en /Rw/', 'gbecosmolingua-core' ),
		__( 'Maintien de l’opposition */ɛ/ vs */e/', 'gbecosmolingua-core' ),
		__( 'Au moins trois préfixes nominaux : /à-/ (commun), puis /ò-/, /í-/, /è-/…', 'gbecosmolingua-core' ),
	);
}

/**
 * Parlers de la section Vhe.
 *
 * @return string[]
 */
function gbe_le_gbe_section_vhe() {
	return array(
		'Awlan',
		'Awlangben',
		'Gbin',
		'Peci',
		'Kpindo',
		'Dayin',
		'Vé',
		'Avéno',
		'Tewun',
		'Vhlin',
		'Fodome',
		'Kpelen',
		'Agu',
		'Vo',
		'Hó',
		'Waci',
		'Wancé',
		'Adangbe',
	);
}

/**
 * Parlers de la section Gen.
 *
 * @return string[]
 */
function gbe_le_gbe_section_gen() {
	return array(
		'Gliji',
		'Anéxo',
		'Agói',
	);
}

/**
 * Parlers de la section Ajé.
 *
 * @return string[]
 */
function gbe_le_gbe_section_aje() {
	return array(
		'Hwe',
		'Dogbé',
		'Stédé',
		'Sikpi (quasi-total)',
	);
}

/**
 * Parlers de la section Fon.
 *
 * @return string[]
 */
function gbe_le_gbe_section_fono() {
	return array(
		'Kpase',
		'Arohún',
		'Agbome',
		'Gun',
		'Maxi',
		'Weme',
	);
}

/**
 * Parlers de la section Phla-Phera.
 *
 * @return string[]
 */
function gbe_le_gbe_section_phla_phera() {
	return array(
		'Tsapha',
		'Kotafon',
		'Ayizo',
		'Toli',
		'Tofin',
		'Phelé',
		'Phla',
		'Alada',
	);
}

/**
 * Schéma ASCII du regroupement dialectal.
 *
 * @return string
 */
function gbe_le_gbe_regroupement_schema() {
	return <<<'SCHEMA'
Tableau 20 — Un regroupement des parlers Gbe

GBE
 ├── Vhe : Towun, Awlan, Gbin, Peci, Kpando, Vhlin, Hó, Avéno, Vo,
 │         Kpelen, Vé, Dayin, Agu, Fodome, Wancé, Waci, Adangbe
 ├── Gen : Gliji, Anéxo, Agói
 ├── Ajá : Dogbé, Stédé, Hwe, Sikpi
 ├── Fon : Arohún, Kpase, Agbome, Maxi, Gun, Weme
 └── Phla-Pheré : Alada, Toli, Tofin, Phelé, Phla, Ayizo, Kotafon, Tsapha
SCHEMA;
}
