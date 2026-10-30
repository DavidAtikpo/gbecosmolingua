<?php
/**
 * Contenu éditorial — Gbe est une langue unique (chapitre 9).
 *
 * Argumentation pour l'unité linguistique du continuum gbe sous quatre angles.
 * Reconstitué pour GbeCosmoLingua à partir d'un document OCR (H. C. Capo / Gbekɔbu).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Gbe est une langue unique ».
 *
 * @return string
 */
function gbe_le_gbe_langue_unique_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Chapitre 9 — Gbe est une langue unique : critères d’identification et bases de la renaissance de Gbe.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_langue_unique_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_langue_unique_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Ce chapitre corrige l’usage vague des expressions « continuum dialectal », « complexe linguistique » ou « groupe de parlers » au profit de l’appellation « langue Gbe ». Tous les auteurs reconnaissent une entité kwa distincte ; la question est de savoir s’il s’agit d’une langue ou d’un groupe de langues.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Plutôt que de demander lequel de deux parlers est la « langue » et lequel le « dialecte », on tend à les identifier comme dialectes d’une même langue — avec la question du seuil de parenté. Le statut de Gbe est examiné sous quatre angles.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_langue_unique_angles(), '--angles' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="linguistique" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Angle linguistique', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'La distinction langue/dialecte repose sur l’axe historique : un dialecte se définit par ses innovations ; la langue, par les points communs dérivables d’une proto-langue. C’est sur cette base qu’ont été définies les sections Vhe, Gen, Ajé, Fon et Phla-Phera.', 'gbecosmolingua-core' ); ?></p>
			<h3><?php esc_html_e( 'Innovations partagées entre sections', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_innovations_partagees() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Westermann (1930), Cornevin (1962) et Pazzi (1979) insistent sur les ressemblances profondes. Parler de cinq sections reste utile ; parler de cinq langues distinctes ne se justifie pas.', 'gbecosmolingua-core' ); ?></p>
			</div>

			<h3><?php esc_html_e( 'Comparaison lexicostatistique (Swadesh)', 'gbecosmolingua-core' ); ?></h3>
			<p><?php esc_html_e( 'Comparaison des quatre formes écrites (Fon, Gen, Aja, Éwé) sur 100 mots Swadesh — seuil proposé : 80 % de termes apparentés pour une même langue.', 'gbecosmolingua-core' ); ?></p>
			<?php
			echo gbe_chapter_data_table( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				gbe_le_gbe_swadesh_comparaisons(),
				array(
					__( 'Paire de variétés', 'gbecosmolingua-core' ),
					__( 'Termes apparentés', 'gbecosmolingua-core' ),
				)
			);
			?>
			<p><?php esc_html_e( 'Le Fon écrit est légèrement plus éloigné ; le minimum (Fon–Gen ou Fon–Éwé) reste à 82 % — preuve que les formes les moins apparentées restent membres d’une même langue.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="sociolinguistique" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Angle sociolinguistique', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Une langue peut se définir comme un ensemble de parlers entre lesquels existe un certain degré d’intelligibilité mutuelle. Ce critère pose quatre problèmes connus :', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_problemes_intelligibilite() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			<h3><?php esc_html_e( 'Observations empiriques', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_langue_unique_intelligibilite_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			<h3><?php esc_html_e( 'Schéma de l’intelligibilité mutuelle', 'gbecosmolingua-core' ); ?></h3>
			<?php
			echo gbe_chapter_schema_box( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				gbe_le_gbe_intelligibilite_schema(),
				__( 'Schéma d’intelligibilité mutuelle entre sections Gbe', 'gbecosmolingua-core' )
			);
			?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Le parler Gen apparaît comme une « plaque tournante » dans le continuum. Du point de vue de l’intercompréhension, Gbe se prête à être traité comme une langue unique.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="litteraire" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Angle littéraire', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Dans le continuum Gbe, trois catégories de formes écrites se distinguent (repère : campagne d’alphabétisation 1975) :', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_langue_unique_ecriture_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			<h3><?php esc_html_e( 'Mobilité littéraire orale', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_mobilite_litteraire() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'Les productions orales sont convergentes et révèlent des expériences communes — base certaine pour une littérature écrite commune en orthographe uniforme standard de Gbe.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="politique" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Angle politique', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'On tend à faire coïncider les limites d’une langue avec celles d’un État — d’où « langue dahoméenne » (Fon) vs « langue Éwé » (Togo), en ignorant le Waci, l’Aja, le Gen, le Phla des deux côtés du fleuve Mono.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_country_cards( gbe_le_gbe_langue_unique_institutions() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'L’unité de la langue Gbe, parlée par des communautés du Ghana, du Togo, du Bénin et du Nigeria, doit être mise en exergue comme base de relations cordiales entre ces quatre États.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="conclusion" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Conclusion', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Quelle que soit la définition retenue de « langue », tout le continuum Gbe peut — et devrait — être traité comme une seule langue, avec ses dialectes (Vhe, Gen, Ajé, Fon, Phla-Phera). Il est possible et souhaitable d’avoir une orthographe uniforme standard de Gbe.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Les conditions objectives de la renaissance de Gbe existent déjà ; ce qui manque est un soutien politique et une conviction partagée. Il faut coordonner les efforts des chercheurs, favoriser les interactions entre populations locutrices, et engager la standardisation consciente de Gbe.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/',
					'label' => __( 'Regroupement des parlers', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/',
					'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ),
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
 * Statistiques clés du chapitre.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_langue_unique_stats() {
	return array(
		array(
			'value' => '4',
			'label' => __( 'Angles d’analyse', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '82%',
			'label' => __( 'Minimum Swadesh (Fon–Éwé)', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '4',
			'label' => __( 'États du continuum', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Navigation in-page.
 *
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_langue_unique_nav() {
	return array(
		array(
			'id'    => 'generalites',
			'label' => __( 'Généralités', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'linguistique',
			'label' => __( 'Linguistique', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'sociolinguistique',
			'label' => __( 'Sociolinguistique', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'litteraire',
			'label' => __( 'Littéraire', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'politique',
			'label' => __( 'Politique', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'conclusion',
			'label' => __( 'Conclusion', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes des quatre angles d’analyse.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_langue_unique_angles() {
	return array(
		array(
			'tag'   => '1',
			'title' => __( 'Linguistique', 'gbecosmolingua-core' ),
			'body'  => __( 'Innovations partagées, proto-Gbe et comparaison lexicostatistique Swadesh (seuil 80 %).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '2',
			'title' => __( 'Sociolinguistique', 'gbecosmolingua-core' ),
			'body'  => __( 'Intelligibilité mutuelle entre sections — le Gen comme plaque tournante du continuum.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '3',
			'title' => __( 'Littéraire', 'gbecosmolingua-core' ),
			'body'  => __( 'Formes écrites, production orale convergente et mobilité des genres traditionnels.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '4',
			'title' => __( 'Politique', 'gbecosmolingua-core' ),
			'body'  => __( 'Au-delà des frontières étatiques — coopération entre institutions linguistiques des quatre pays.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes observations d’intelligibilité.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_langue_unique_intelligibilite_cards() {
	return array(
		array(
			'tag'   => 'Waci',
			'title' => __( 'Kômé (Bénin)', 'gbecosmolingua-core' ),
			'body'  => __( 'Un locuteur Waci comprend parfaitement les autres Vhe, le Gen, en grande partie l’Ajá, le Phla et le Phelá du même district.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ajá',
			'title' => __( 'Dogbó', 'gbecosmolingua-core' ),
			'body'  => __( 'Comprend parfaitement tous les Ajá, le Gen, le Fon urbain, le Waci et le Tsáphɛ.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Phla',
			'title' => __( 'Phlagán (Grand Popo)', 'gbecosmolingua-core' ),
			'body'  => __( 'Comprend parfaitement le Gen, le Waci, le Fon urbain et le Phelá.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ayizɔ',
			'title' => __( 'Alada', 'gbecosmolingua-core' ),
			'body'  => __( 'Comprend le Tofin, le Fon urbain, le Gun et en grande partie le Gen.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Fon',
			'title' => __( 'Accra (Madina)', 'gbecosmolingua-core' ),
			'body'  => __( 'Des locuteurs Fon trouvant du travail à Madina parlent le Vhe urbain en deux semaines — l’absence d’intelligibilité perçue relève du manque de contact, non de la distance linguistique.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Gen',
			'title' => __( 'Plaque tournante', 'gbecosmolingua-core' ),
			'body'  => __( 'Tous les locuteurs Gbe de Madina comprennent le Gen — y compris Pecí, Towun, Phla et Maxí (sermons Pénoukou, 1975–1977).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes catégories de formes écrites.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_langue_unique_ecriture_cards() {
	return array(
		array(
			'tag'   => __( 'Établies', 'gbecosmolingua-core' ),
			'title' => __( 'Avant 1975', 'gbecosmolingua-core' ),
			'body'  => __( 'Éwé, Gen, Fon, Gun : littérature religieuse, ouvrages descriptifs et didactiques.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'En cours', 'gbecosmolingua-core' ),
			'title' => __( 'Aja & Waci', 'gbecosmolingua-core' ),
			'body'  => __( 'Certaine littérature écrite, système orthographique explicite avant 1975.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => __( 'Récentes', 'gbecosmolingua-core' ),
			'title' => __( 'Depuis 1975', 'gbecosmolingua-core' ),
			'body'  => __( 'Weme, Kotafon, Ayizo, Tèfin, Saxwe : syllabaire depuis 1975, ouvrages de référence en préparation.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Institutions par pays pour la coopération linguistique.
 *
 * @return array<int, array{code: string, title: string, body: string}>
 */
function gbe_le_gbe_langue_unique_institutions() {
	return array(
		array(
			'code'  => 'GH',
			'title' => __( 'Ghana', 'gbecosmolingua-core' ),
			'body'  => __( 'Bureau of Ghana Languages — promotion des langues nationales dont l’Éwé.', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'TG',
			'title' => __( 'Togo', 'gbecosmolingua-core' ),
			'body'  => __( 'Académie de la langue Éwé — langue nationale officielle.', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'BJ',
			'title' => __( 'Bénin', 'gbecosmolingua-core' ),
			'body'  => __( 'Centre national de linguistique appliquée (CENALA) — recherches sur les parlers gbe.', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => 'NG',
			'title' => __( 'Nigéria', 'gbecosmolingua-core' ),
			'body'  => __( 'National Language Centre — locuteurs Gbe des États d’Ogun et de Lagos.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Innovations phonologiques partagées entre sections.
 *
 * @return string[]
 */
function gbe_le_gbe_innovations_partagees() {
	return array(
		__( 'Fusion proto-Gbe */ɛ/ et */e/ en /e/ : Vhe (Kpándo), Gen et Ajá', 'gbecosmolingua-core' ),
		__( 'Fusion */t *th/ et */d *dh/ en /t/ et /d/ : Vhe, Gen et Ajá', 'gbecosmolingua-core' ),
		__( 'Fusion */ts *s/ et */dz *z/ en /s/ et /z/ : Ajá, Fon, Gen, Phla-Pherá (Phla) et certains Vhe (Adángbe)', 'gbecosmolingua-core' ),
		__( 'Palatalisation de /t d/ et /s z/ devant voyelles fermées d’avant : pas propre à l’Ajá (ex. Awlan)', 'gbecosmolingua-core' ),
	);
}

/**
 * Données du tableau — comparaisons Swadesh.
 *
 * @return array<int, array{paire: string, pourcentage: string}>
 */
function gbe_le_gbe_swadesh_comparaisons() {
	return array(
		array( 'paire' => 'Fon–Éwé', 'pourcentage' => '82 %' ),
		array( 'paire' => 'Fon–Aja', 'pourcentage' => '84 %' ),
		array( 'paire' => 'Fon–Gen', 'pourcentage' => '82 %' ),
		array( 'paire' => 'Éwé–Aja', 'pourcentage' => '96 %' ),
		array( 'paire' => 'Éwé–Gen', 'pourcentage' => '96 %' ),
		array( 'paire' => 'Aja–Gen', 'pourcentage' => '96 %' ),
	);
}

/**
 * Problèmes du critère d'intelligibilité mutuelle.
 *
 * @return string[]
 */
function gbe_le_gbe_problemes_intelligibilite() {
	return array(
		'Mesure objective et seuil de distinction dialecte/langue : problème technique non résolu',
		'Intelligibilité souvent fonction de la distance géographique, non linguistique ; non transitive (A↔B, B↔C n’implique pas A↔C)',
		'Intelligibilité parfois unidirectionnelle (exposition asymétrique entre parlers)',
		'Refus délibéré de reconnaître la compréhension (attitudes sociologiques, enquêtes de standardisation)',
	);
}

/**
 * Exemples de mobilité littéraire orale.
 *
 * @return string[]
 */
function gbe_le_gbe_mobilite_litteraire() {
	return array(
		__( 'Proverbes identiques (Pazzi & Agbano II 1969 — Gen/Mina ; Guillet 1971 — Fon ; Dzobo 1973 — Éwé)', 'gbecosmolingua-core' ),
		__( 'Anthroponymes et toponymes quasi identiques (Fáyínnú, Alixonú, Tóvíyínkú, Xomɛyan ; Kóme, Lókosa, Atitongon, Se…)', 'gbecosmolingua-core' ),
		__( 'Comptines circulant librement entre communautés dialectales (Egblewogbe 1975, Ghana)', 'gbecosmolingua-core' ),
		__( 'Berceuses et chansons populaires sans frontières — ex. aloré klóna aloré « une main lave l’autre »', 'gbecosmolingua-core' ),
		__( 'Chansons d’orchestres : nú nona amesí… (Tsáphɛ, Bénin) appréciée chez les Awlan (Ghana) ; gbetó dá (Fon), lonlon sénphé (Gen)', 'gbecosmolingua-core' ),
		__( 'Contes avec séquences chantées dans un autre parler Gbe, sans traduction ni problème de compréhension', 'gbecosmolingua-core' ),
	);
}

/**
 * Schéma ASCII de l'intelligibilité mutuelle.
 *
 * @return string
 */
function gbe_le_gbe_intelligibilite_schema() {
	return <<<'SCHEMA'
Tableau 48 — Intelligibilité mutuelle (sections Gbe)

        Ajá
       ↗ ↖
Vhe ←→ Gen ←→ Fon
       ↘ ↙
    Phla-Pherá

→  intelligibilité totale
--> intelligibilité appréciable
…> faible intelligibilité

Gen = plaque tournante du continuum.
SCHEMA;
}
