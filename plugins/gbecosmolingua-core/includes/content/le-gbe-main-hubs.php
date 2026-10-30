<?php
/**
 * Contenu éditorial — pages hub principales (Gbe, Linguistique, Cultures, Xótùtù, Onomastique).
 *
 * Synthèse des chapitres intégrés (Capo / Gbekɔbu) — sans données inventées.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page racine « Gbe » (/le-gbe/).
 *
 * @return string
 */
function gbe_le_gbe_hub_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Hub Gbe — synthèse d’après H. C. Capo (Gbekɔbu, 2014) : langue unique kwa (Niger-Congo), continuum dialectal au Ghana, Togo, Bénin et Nigeria.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_hub_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<p class="gbe-chapter-stats-source"><em><?php esc_html_e( 'Chiffre « ~4 M locuteurs » : estimation de H. C. Capo (Gbekɔbu, 2014), ch. 1 — Généralités.', 'gbecosmolingua-core' ); ?></em></p>
		<?php
		echo gbe_chapter_nav( gbe_le_gbe_hub_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Gbe désigne une langue unique de la branche kwa (Volta-Congo), parlée par environ quatre millions de locuteurs. Son territoire s’étend de l’océan Atlantique aux fleuves Volta et Ouémé ; on y dénombre une cinquantaine de parlers mutuellement intelligibles.', 'gbecosmolingua-core' ); ?></p>
			<p class="gbe-chapter-source-inline"><em><?php esc_html_e( 'Source : H. C. Capo (Gbekɔbu, 2014), ch. 1 — Généralités.', 'gbecosmolingua-core' ); ?></em></p>
			<p><?php esc_html_e( 'Linguistiquement, le continuum forme une seule langue avec cinq sections dialectales — Vhe, Gen, Ajé, Fon et Phla-Phera. La comparaison Swadesh entre Fon, Gen, Aja et Éwé donne de 82 % à 96 % de termes apparentés.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'GbeCosmoLingua documente ce continuum : inventaire des parlers, regroupement dialectologique, formes écrites, ressources linguistiques et patrimoine oral partagé.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="sections" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cinq sections dialectales', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_dialect_cards( gbe_le_gbe_inventaire_dialect_sections() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="rubriques" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Explorer le continuum', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_country_link_cards( gbe_le_gbe_hub_rubrique_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array( 'url' => '/le-gbe/le-continuum-gbe/inventaire-des-parlers/', 'label' => __( 'Inventaire des parlers', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/le-continuum-gbe/langue-unique/', 'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/linguistique/', 'label' => __( 'Linguistique', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/carte-interactive/', 'label' => __( 'Carte interactive', 'gbecosmolingua-core' ) ),
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
function gbe_le_gbe_hub_stats() {
	return array(
		array( 'value' => '~4 M', 'label' => __( 'Locuteurs', 'gbecosmolingua-core' ) ),
		array( 'value' => '50+', 'label' => __( 'Parlers recensés', 'gbecosmolingua-core' ) ),
		array( 'value' => '5', 'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ) ),
		array( 'value' => '4', 'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_hub_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'sections', 'label' => __( 'Sections', 'gbecosmolingua-core' ) ),
		array( 'id' => 'rubriques', 'label' => __( 'Rubriques', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{code: string, title: string, body: string, url: string, meta?: string}>
 */
function gbe_le_gbe_hub_rubrique_cards() {
	return array(
		array(
			'code'  => '01',
			'title' => __( 'Le continuum gbe', 'gbecosmolingua-core' ),
			'body'  => __( 'Inventaire, regroupement, unité linguistique, variétés écrites et pays.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/',
			'meta'  => __( 'Ch. 1, 7 et 9', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '02',
			'title' => __( 'Les langues', 'gbecosmolingua-core' ),
			'body'  => __( 'Fiches Éwé, Fon, Gen, Aja, Gun, Waci, Phla-Phera…', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/les-langues/',
			'meta'  => __( 'Formes écrites majeures', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '03',
			'title' => __( 'Linguistique', 'gbecosmolingua-core' ),
			'body'  => __( 'Travaux récents, dialectologie, potentialités lexicales, phonologie.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/linguistique/',
			'meta'  => __( 'Ch. 5, 6, 7 et 9', 'gbecosmolingua-core' ),
		),
		array(
			'code'  => '04',
			'title' => __( 'Peuples du continuum', 'gbecosmolingua-core' ),
			'body'  => __( 'Ethnonymes, communautés locutrices et désignations des parlers.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/peuples-du-continuum/',
		),
		array(
			'code'  => '05',
			'title' => __( 'Carte interactive', 'gbecosmolingua-core' ),
			'body'  => __( 'Répartition géographique des parlers gbe.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/carte-interactive/',
		),
		array(
			'code'  => '06',
			'title' => __( 'Présentation générale', 'gbecosmolingua-core' ),
			'body'  => __( 'Vue d’ensemble : aire, voisins linguistiques, unité et patrimoine oral.', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/presentation-generale/',
		),
	);
}

/**
 * Hub « Linguistique » (/le-gbe/linguistique/).
 *
 * @return string
 */
function gbe_le_gbe_linguistique_hub_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Hub linguistique — description scientifique du continuum gbe (travaux depuis 1966).', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_linguistique_hub_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_linguistique_hub_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-source-note"><em><?php esc_html_e( 'Chapitre 5 — Travaux scientifiques récents sur Gbe.', 'gbecosmolingua-core' ); ?></em></p>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Des monographies universitaires documentent la phonologie, la morpho-syntaxe et la lexicographie des principales sections du continuum. Quatre des cinq sections majeures disposent de dictionnaires bilingues ; la dialectologie repose sur les innovations phonologiques du proto-Gbe.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'GbeCosmoLingua centralise les ressources : travaux récents, potentialités lexicales, dialectologie, description phonologique et corpus numériques (proverbes, archives).', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="chapitres" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Chapitres de référence', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_linguistique_chapitre_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="themes" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Thèmes linguistiques', 'gbecosmolingua-core' ); ?></h2>
			<ul class="gbe-chapter-list">
				<li><a href="/le-gbe/linguistique/hounkpati-b-c-capo/"><?php esc_html_e( 'Hounkpati B. Christophe Capo — figure de référence', 'gbecosmolingua-core' ); ?></a></li>
				<li><a href="/le-gbe/linguistique/alphabet/"><?php esc_html_e( 'Alphabet', 'gbecosmolingua-core' ); ?></a> — <?php esc_html_e( 'orthographes et systèmes d’écriture', 'gbecosmolingua-core' ); ?></li>
				<li><a href="/le-gbe/linguistique/phonologie/"><?php esc_html_e( 'Phonologie', 'gbecosmolingua-core' ); ?></a> — <?php esc_html_e( 'tons et inventaires phonologiques', 'gbecosmolingua-core' ); ?></li>
				<li><a href="/le-gbe/linguistique/morphologie/"><?php esc_html_e( 'Morphologie', 'gbecosmolingua-core' ); ?></a> — <?php esc_html_e( 'dérivation et formation des mots', 'gbecosmolingua-core' ); ?></li>
				<li><a href="/le-gbe/linguistique/syntaxe/"><?php esc_html_e( 'Syntaxe', 'gbecosmolingua-core' ); ?></a> — <?php esc_html_e( 'structures phrastiques', 'gbecosmolingua-core' ); ?></li>
				<li><a href="/le-gbe/linguistique/lexicologie/"><?php esc_html_e( 'Lexicologie', 'gbecosmolingua-core' ); ?></a> — <?php esc_html_e( 'champs lexicaux et néologie', 'gbecosmolingua-core' ); ?></li>
				<li><a href="/le-gbe/linguistique/dialectologie/"><?php esc_html_e( 'Dialectologie', 'gbecosmolingua-core' ); ?></a> — <?php esc_html_e( 'cinq sections et validation Swadesh', 'gbecosmolingua-core' ); ?></li>
				<li><a href="/le-gbe/linguistique/corpus-numeriques/"><?php esc_html_e( 'Corpus numériques', 'gbecosmolingua-core' ); ?></a></li>
				<li><a href="/le-gbe/linguistique/bibliotheque/"><?php esc_html_e( 'Bibliothèque', 'gbecosmolingua-core' ); ?></a></li>
			</ul>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array( 'url' => '/le-gbe/linguistique/hounkpati-b-c-capo/', 'label' => __( 'H. B. C. Capo — auteur', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/linguistique/travaux-scientifiques-recents/', 'label' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/linguistique/potentialites-lexicales/', 'label' => __( 'Potentialités lexicales', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/linguistique/dialectologie/', 'label' => __( 'Dialectologie', 'gbecosmolingua-core' ) ),
				array( 'url' => '/paremiologie/banque-numerique-proverbes/', 'label' => __( 'Banque de proverbes', 'gbecosmolingua-core' ) ),
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
function gbe_le_gbe_linguistique_hub_stats() {
	return array(
		array( 'value' => '1966', 'label' => __( 'Monographies modernes', 'gbecosmolingua-core' ) ),
		array( 'value' => '770+', 'label' => __( 'Publications (Duthie, 1981)', 'gbecosmolingua-core' ) ),
		array( 'value' => '82–96%', 'label' => __( 'Swadesh inter-sections', 'gbecosmolingua-core' ) ),
		array( 'value' => '4', 'label' => __( 'Dictionnaires majeurs', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_linguistique_hub_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'chapitres', 'label' => __( 'Chapitres', 'gbecosmolingua-core' ) ),
		array( 'id' => 'themes', 'label' => __( 'Thèmes', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_linguistique_chapitre_cards() {
	return array(
		array(
			'tag'   => 'Ch. 5',
			'title' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ),
			'body'  => __( 'Cadres de recherche, monographies depuis 1966, lexicographie (Westermann, Kponton, Pazzi…) et synthèses (Duthie, colloque Porto-Novo 1977).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ch. 6',
			'title' => __( 'Potentialités lexicales', 'gbecosmolingua-core' ),
			'body'  => __( 'Suffixation, composition, emprunts et combinaisons — ressources internes et externes pour enrichir le lexique gbe.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ch. 7',
			'title' => __( 'Regroupement des parlers', 'gbecosmolingua-core' ),
			'body'  => __( 'Cinq sections dialectales sur la base d’innovations phonologiques non conditionnées (proto-Gbe).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Ch. 9',
			'title' => __( 'Gbe, langue unique', 'gbecosmolingua-core' ),
			'body'  => __( 'Arguments linguistiques, sociolinguistiques, littéraires et politiques — Swadesh 82–96 %, intercompréhension mutuelle.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Hub « Cultures Gbe » (/cultures-gbe/).
 *
 * @return string
 */
function gbe_cultures_gbe_hub_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Cultures gbe — patrimoine matériel et immatériel du continuum (Ghana, Togo, Bénin, Nigeria).', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_cultures_gbe_hub_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_cultures_gbe_hub_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Malgré la diversité dialectale, le patrimoine culturel gbe révèle des convergences profondes. Les productions orales — proverbes, comptines, berceuses, chants d’orchestres — circulent librement entre sections dialectales et témoignent d’expériences communes.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les anthroponymes (Fáyínnú, Alixonú, Tóvíyínkú…) et toponymes (Kóme, Lókosa, Atitongon, Se…) se retrouvent dans toute l’aire gbe. Cette mobilité culturelle confirme l’unité du continuum au-delà des frontières étatiques.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="oral" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Patrimoine oral partagé', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_list( gbe_cultures_gbe_oral_mobilite() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Sources : Pazzi & Agbano II (1969, Gen/Mina), Guillet (1971, Fon), Dzobo (1973, Éwé) — proverbes identiques d’une section à l’autre.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="rubriques" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Rubriques culturelles', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Architecture, artisanat, arts, musique, danse, gastronomie, croyances, fêtes, savoirs endogènes et patrimoines matériels/immateriels — explorez les sections ci-dessous.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array( 'url' => '/xotutu/', 'label' => __( 'Xótùtù — tradition orale', 'gbecosmolingua-core' ) ),
				array( 'url' => '/paremiologie/', 'label' => __( 'Paremiologie', 'gbecosmolingua-core' ) ),
				array( 'url' => '/xotutu/onomastique/', 'label' => __( 'Onomastique', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/', 'label' => __( 'Hub Gbe', 'gbecosmolingua-core' ) ),
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
function gbe_cultures_gbe_hub_stats() {
	return array(
		array( 'value' => '4', 'label' => __( 'Pays du continuum', 'gbecosmolingua-core' ) ),
		array( 'value' => '11', 'label' => __( 'Rubriques culturelles', 'gbecosmolingua-core' ) ),
		array( 'value' => '50+', 'label' => __( 'Parlers', 'gbecosmolingua-core' ) ),
		array( 'value' => '5', 'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_cultures_gbe_hub_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'oral', 'label' => __( 'Patrimoine oral', 'gbecosmolingua-core' ) ),
		array( 'id' => 'rubriques', 'label' => __( 'Rubriques', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return string[]
 */
function gbe_cultures_gbe_oral_mobilite() {
	return array(
		__( 'Proverbes communs aux sections Vhe, Gen, Ajá, Fon et Phla-Pherá', 'gbecosmolingua-core' ),
		__( 'Comptines d’enfants circulant entre communautés dialectales (Egblewogbe 1975, Ghana)', 'gbecosmolingua-core' ),
		__( 'Berceuses sans frontières — ex. aloré klóna aloré « une main lave l’autre »', 'gbecosmolingua-core' ),
		__( 'Chansons d’orchestres traditionnels et modernes (Tsáphɛ/Bénin, Awlan/Ghana ; gbetó dá en Fon, lonlon sénphé en Gen)', 'gbecosmolingua-core' ),
		__( 'Contes avec séquences chantées dans un autre parler gbe, sans traduction', 'gbecosmolingua-core' ),
	);
}

/**
 * Hub « Xótùtù » (/xotutu/).
 *
 * @return string
 */
function gbe_le_gbe_xotutu_hub_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Xótùtù — mémoire culturelle et tradition orale du continuum gbe.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_xotutu_hub_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_xotutu_hub_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Le Xótùtù est l’espace de mémoire, de création et de transmission intergénérationnelle des peuples gbe. Contes, proverbes (lododowo), comptines, chants et archives numériques y sont recensés et diffusés.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Le patrimoine oral gbe ignore largement les frontières dialectales : les mêmes proverbes, comptines et chansons circulent entre parlers Vhe, Gen, Ajá, Fon et Phla-Pherá — base d’une littérature écrite commune.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="genres" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Genres folkloriques', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_xotutu_genre_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="onomastique" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Onomastique et noms', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Anthroponymes et toponymes quasi identiques dans toute l’aire gbe — voir la rubrique Onomastique pour anthroponymie, toponymie, hydronymie, ethnonymie et théonymie.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array( 'url' => '/xotutu/genres-folkloriques/lododowo-proverbes/', 'label' => __( 'Proverbes (Lododowo)', 'gbecosmolingua-core' ) ),
				array( 'url' => '/paremiologie/banque-numerique-proverbes/', 'label' => __( 'Banque numérique', 'gbecosmolingua-core' ) ),
				array( 'url' => '/xotutu/onomastique/', 'label' => __( 'Onomastique', 'gbecosmolingua-core' ) ),
				array( 'url' => '/xotutu/archives-numeriques/', 'label' => __( 'Archives numériques', 'gbecosmolingua-core' ) ),
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
function gbe_xotutu_hub_stats() {
	return array(
		array( 'value' => '5', 'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ) ),
		array( 'value' => '786', 'label' => __( 'Proverbes éwé numérisés', 'gbecosmolingua-core' ) ),
		array( 'value' => '4', 'label' => __( 'Pays couverts', 'gbecosmolingua-core' ) ),
		array( 'value' => '5', 'label' => __( 'Rubriques onomastiques', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_xotutu_hub_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'genres', 'label' => __( 'Genres', 'gbecosmolingua-core' ) ),
		array( 'id' => 'onomastique', 'label' => __( 'Onomastique', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_xotutu_genre_cards() {
	return array(
		array(
			'tag'   => 'Lododowo',
			'title' => __( 'Proverbes', 'gbecosmolingua-core' ),
			'body'  => __( 'Sagesse populaire identique d’une section à l’autre — Pazzi & Agbano, Guillet, Dzobo.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Havo',
			'title' => __( 'Chants', 'gbecosmolingua-core' ),
			'body'  => __( 'Berceuses, chants d’orchestres traditionnels et modernes — mobilité dialectale.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Agbekɔ',
			'title' => __( 'Contes', 'gbecosmolingua-core' ),
			'body'  => __( 'Récits avec séquences chantées dans d’autres parlers gbe, sans traduction.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'Archives',
			'title' => __( 'Archives numériques', 'gbecosmolingua-core' ),
			'body'  => __( 'Audio, vidéo, manuscrits et corpus textuels du patrimoine oral gbe.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Hub « Onomastique » (/xotutu/onomastique/).
 *
 * @return string
 */
function gbe_xotutu_onomastique_hub_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Onomastique gbe — noms de personnes, de lieux, de peuples et de divinités (ch. 1 et 9).', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_onomastique_hub_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_onomastique_hub_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'L’onomastique gbe recense les noms propres — personnes, lieux, cours d’eau, peuples et divinités — partagés à travers le continuum dialectal.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les anthroponymes et toponymes sont quasi identiques chez les Vhe, Gen, Ajá, Fon et Phla-Pherá (ex. Fáyínnú, Alixonú ; Kóme, Lókosa, Atitongon, Se). Chaque parler se désigne par un suffixe -gbe ; la communauté locutrice par -vi, -no, -li ou -kpɔ (Wacigbe, Hwegbe, Gungbe…).', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="rubriques" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Cinq rubriques', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_ref_cards( gbe_onomastique_rubrique_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="ethnonymes" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Ethnonymes et désignations', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_list( gbe_onomastique_ethnonyme_notes() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array( 'url' => '/xotutu/onomastique/anthroponymie/', 'label' => __( 'Anthroponymie', 'gbecosmolingua-core' ) ),
				array( 'url' => '/xotutu/onomastique/toponymie/', 'label' => __( 'Toponymie', 'gbecosmolingua-core' ) ),
				array( 'url' => '/le-gbe/peuples-du-continuum/', 'label' => __( 'Peuples du continuum', 'gbecosmolingua-core' ) ),
				array( 'url' => '/xotutu/', 'label' => __( 'Hub Xótùtù', 'gbecosmolingua-core' ) ),
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
function gbe_onomastique_hub_stats() {
	return array(
		array( 'value' => '5', 'label' => __( 'Rubriques', 'gbecosmolingua-core' ) ),
		array( 'value' => '5', 'label' => __( 'Sections dialectales', 'gbecosmolingua-core' ) ),
		array( 'value' => '50+', 'label' => __( 'Parlers', 'gbecosmolingua-core' ) ),
		array( 'value' => '4', 'label' => __( 'Pays', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_onomastique_hub_nav() {
	return array(
		array( 'id' => 'presentation', 'label' => __( 'Présentation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'rubriques', 'label' => __( 'Rubriques', 'gbecosmolingua-core' ) ),
		array( 'id' => 'ethnonymes', 'label' => __( 'Ethnonymes', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_onomastique_rubrique_cards() {
	return array(
		array(
			'tag'   => '1',
			'title' => __( 'Anthroponymie', 'gbecosmolingua-core' ),
			'body'  => __( 'Prénoms, noms lignagers, initiatiques et circonstanciels — noms partagés entre sections.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '2',
			'title' => __( 'Toponymie', 'gbecosmolingua-core' ),
			'body'  => __( 'Villages, villes, lieux sacrés, montagnes — toponymes communs (Kóme, Lókosa, Atitongon…).', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '3',
			'title' => __( 'Hydronymie', 'gbecosmolingua-core' ),
			'body'  => __( 'Cours d’eau et plans d’eau — dont le fleuve Mono, frontière entre parlers transfrontaliers.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '4',
			'title' => __( 'Ethnonymie', 'gbecosmolingua-core' ),
			'body'  => __( 'Autodésignations et appellations des groupes — suffixes -gbe, -vi ; Mina, Popo, Danxomegbe.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '5',
			'title' => __( 'Théonymie', 'gbecosmolingua-core' ),
			'body'  => __( 'Noms des divinités et entités sacrées du panthéon gbe.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * @return string[]
 */
function gbe_onomastique_ethnonyme_notes() {
	return array(
		__( 'Suffixe -gbe pour le parler (Wacigbe, Gengbe, Fongbe…) ; -vi, -no, -li ou -kpɔ pour la communauté locutrice', 'gbecosmolingua-core' ),
		__( 'Peci → Gbingbe ; Anéxo, Gliji, Agói → Gengbe', 'gbecosmolingua-core' ),
		__( 'Mina et Popo : termes courants chez les non-locuteurs ; Danxomegbe couvre Kpase, Arohún et Agbome', 'gbecosmolingua-core' ),
		__( 'Idù, Ajá et Ifè : ethnonymes larges absents de l’inventaire des parlers (ch. 1)', 'gbecosmolingua-core' ),
	);
}
