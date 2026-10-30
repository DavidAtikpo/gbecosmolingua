<?php
/**
 * Contenu éditorial — thèse Gnanguenon (2014) sur la langue fon.
 *
 * Analyse syntaxique et sémantique du fɔn — phonologie, lexicographie, onomastique.
 * Synthèse pour GbeCosmoLingua à partir du document OCR de la thèse de doctorat
 * (Université de Cergy-Pontoise, 2014).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fiche langue Fon enrichie (thèse Gnanguenon).
 *
 * @return string
 */
function gbe_le_gbe_fon_langue_content() {
	$meta = gbe_le_gbe_langue_meta()['fon'];

	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Fiche langue — Fon (Danxomegbe), section Fon. Documentation enrichie par la thèse de Cossi Boniface GNANGUENON (2014), Université de Cergy-Pontoise.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_fon_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_langue_chapter_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="presentation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php echo esc_html( $meta['intro'] ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Langue historique du royaume du Dahomey — légèrement plus éloignée lexicalement des autres formes écrites (82 % Swadesh minimum avec l’Éwé). Fongbe = synonyme de Danxomegbe pour les locuteurs Fon.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="aire" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Aire et parlers', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['area'] ); ?></p>
			<?php
			echo gbe_chapter_parler_panels( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array(
					array(
						'code'    => 'Fon',
						'title'   => __( 'Parlers Fon', 'gbecosmolingua-core' ),
						'parlers' => $meta['parlers'],
					),
				)
			);
			?>
		</section>

		<section id="phonologie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Phonologie et section Fon', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['notes'] ); ?></p>
			<h3><?php esc_html_e( 'Innovations phonologiques de la section Fon', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_innovations_fono() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<h3><?php esc_html_e( 'Méthodologie : la commutation', 'gbecosmolingua-core' ); ?></h3>
			<p><?php esc_html_e( 'L’analyse phonologique suit la méthode de commutation (Martinet, Bonvini) : remplacer un segment par un autre dans une paire minimale pour dégager les phonèmes et leurs traits pertinents.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_fon_fonctions_phonologiques() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="ecriture" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Forme écrite et lexicographie', 'gbecosmolingua-core' ); ?></h2>
			<p><?php echo esc_html( $meta['ecrit'] ); ?></p>
			<p><?php esc_html_e( 'Historique : Père LABAT (1740), abbé COURDOUX (1879), Père SEGUROLA (1963), Kponton & Xwégbénu (1963), Rassidi (1974). La langue fon reste jeune à l’écrit : les premiers repères datés remontent au XVIIIe siècle.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_fon_ecriture_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="travaux" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Travaux de référence', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Peut-on pratiquer la morphologie dérivationnelle sur les noms de personnes en langue fon ? La thèse Gnanguenon (2014) explore la dérivation affixale à partir de l’onomastique royale, en vue d’un dictionnaire étymologique bilingue.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_fon_travaux_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<h3><?php esc_html_e( 'Structure de la thèse (6 parties)', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_fon_these_parties() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/le-continuum-gbe/regroupement-des-parlers/#fon',
					'label' => __( 'Section Fon (regroupement)', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/phonologie/',
					'label' => __( 'Phonologie du fon (détail)', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/morphologie/',
					'label' => __( 'Morphologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/les-langues/gun/',
					'label' => __( 'Fiche Gun (voisin)', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Statistiques fiche Fon.
 *
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_fon_stats() {
	return array(
		array(
			'value' => 'Fon',
			'label' => __( 'Section dialectale', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '5',
			'label' => __( 'Parlers principaux', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '82%',
			'label' => __( 'Swadesh min. (Éwé)', 'gbecosmolingua-core' ),
		),
		array(
			'value' => '1975',
			'label' => __( 'Syllabaire officiel', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes formes écrites Fon.
 *
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_fon_ecriture_cards() {
	return array(
		array(
			'tag'   => '1963',
			'title' => 'Kponton & Xwégbénu',
			'body'  => __( 'Dictionnaire fon–français — référence lexicographique majeure.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1974',
			'title' => 'Rassidi',
			'body'  => __( 'Dictionnaire complémentaire — consolidation de la lexicographie fongbè.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1975',
			'title' => __( 'Syllabaire', 'gbecosmolingua-core' ),
			'body'  => __( 'Alphabétisation nationale — loi fondamentale traduite en Fon.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Cartes travaux linguistiques sur le Fon.
 *
 * @return array<int, array{tag: string, title: string, body: string, meta?: string}>
 */
function gbe_le_gbe_fon_travaux_cards() {
	return array(
		array(
			'tag'   => '1740',
			'title' => __( 'Père LABAT', 'gbecosmolingua-core' ),
			'body'  => __( 'Premiers repères lexicographiques du fongbè — XVIIIe siècle.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '1976',
			'title' => 'R. Pazzi',
			'body'  => __( 'Monographie comparative — Fon au cœur de la section Fon.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '2014',
			'title' => 'C. B. Gnanguenon',
			'body'  => __( 'Analyse syntaxique et sémantique du fɔn — dictionnaire bilingue fon-français.', 'gbecosmolingua-core' ),
			'meta'  => __( 'Thèse Paris — onomastique et morphologie dérivationnelle', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Page phonologie — focus fon (partie I de la thèse).
 *
 * @return string
 */
function gbe_le_gbe_fon_phonologie_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Synthèse phonologique du fongbè — d’après GNANGUENON (2014), Partie I : La commutation. Méthode Bonvini / Guédou / Akoha.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_phonologie_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_phonologie_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="introduction" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Introduction', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Le fongbè présente un type phonologique où les monosyllabismes prédominent. La phonologie distingue phonématique (segmentale) et prosodie (tons, intonation).', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_fon_fonctions_phonologiques() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="consonnes" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Système consonantique (22 phonèmes)', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Sept ordres (labiales, apicales, alvéolaires, dorsales, vélaires, uvulaires, labio-vélaires) et quatre séries (sourdes, sonores, neutres, nasales).', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_schema_box( gbe_le_gbe_fon_consonant_table(), __( 'Inventaire consonantique fongbè', 'gbecosmolingua-core' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'Particularités : /ɖ/ rétroflexe, occlusives labio-vélaires /kp/ et /gb/, fricatives vélaires /x/ et /h/. Le statut de /p/ reste discuté (idéophones, emprunts).', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="voyelles" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Système vocalique (12 phonèmes)', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Sept voyelles orales et cinq nasales syllabiques, réparties en quatre degrés d’aperture.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_fon_voyelles() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="syllabes" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Structures syllabiques et tonalité', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Formes canoniques (Guédou) : monosyllabe V ou CV (morphèmes) ; dissyllabe VCV ou CVCV (lexèmes) ; trissyllabe CVCVCV. Pas de syllabe fermée CVC — structure ouverte.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_fon_exemples_syllabiques() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'Le fon est une langue tonale : ton haut, ton bas, ton moyen. Les traits tonals entrent dans l’inventaire des mots phonologiques (monèmes).', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="comparaison" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Comparaison et lexicologie', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Fon, Gen (Mina) et Gun appartiennent au groupe Gbe : systèmes phonétiques quasi identiques. Le Gen occupe une position centrale de communication.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Parties II–VI de la thèse Gnanguenon : lexicographie, onomastique royale, anthroponymes calendaires (366 noms), modélisation informatique pour dictionnaires électroniques.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/les-langues/fon/',
					'label' => __( 'Fiche langue Fon', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/morphologie/',
					'label' => __( 'Morphologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/dialectologie/',
					'label' => __( 'Dialectologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/xotutu/onomastique/',
					'label' => __( 'Onomastique', 'gbecosmolingua-core' ),
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
function gbe_le_gbe_phonologie_stats() {
	return array(
		array( 'value' => '22', 'label' => __( 'Phonèmes consonantiques', 'gbecosmolingua-core' ) ),
		array( 'value' => '12', 'label' => __( 'Phonèmes vocaliques', 'gbecosmolingua-core' ) ),
		array( 'value' => '3', 'label' => __( 'Niveaux tonals', 'gbecosmolingua-core' ) ),
		array( 'value' => '2014', 'label' => __( 'Thèse Gnanguenon', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_phonologie_nav() {
	return array(
		array( 'id' => 'introduction', 'label' => __( 'Introduction', 'gbecosmolingua-core' ) ),
		array( 'id' => 'consonnes', 'label' => __( 'Consonnes', 'gbecosmolingua-core' ) ),
		array( 'id' => 'voyelles', 'label' => __( 'Voyelles', 'gbecosmolingua-core' ) ),
		array( 'id' => 'syllabes', 'label' => __( 'Syllabes & tons', 'gbecosmolingua-core' ) ),
		array( 'id' => 'comparaison', 'label' => __( 'Comparaison', 'gbecosmolingua-core' ) ),
	);
}

/**
 * Page morphologie fon — dérivation et onomastique.
 *
 * @return string
 */
function gbe_le_gbe_fon_morphologie_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Morphologie et dérivation — GNANGUENON (2014), parties III–V.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_morphologie_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_morphologie_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="derivation" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Morphologie dérivationnelle', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'En fongbè, composition et dérivation forment noms et verbes. Les suffixes (-tɔ, -nɔ, -li, -vi…) ont souvent une existence lexicale propre, contrairement au modèle indo-européen.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_morphologie_suffixes_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="onomastique" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Onomastique royale', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Analyse morpholexicale et étymologique des noms des rois du royaume d’Abomey : Wegbaja, Akaba, Agaja, Gbèhanzin, Béhanzin, etc. Méthode matricielle de création de néonymes.', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_list( gbe_le_gbe_fon_these_parties() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="anthroponymie" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Anthroponymie événementielle et calendaire', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Noms liés à la vie, au sort, à la famille, à la fécondité ; noms des jours et mois fon (Alunon, Fɔnplɔn, etc.) ; 366 noms calendaires répertoriés — base du dictionnaire étymologique.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="numeration" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Numération', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Étude syntaxico-morphologique du système de numération : base quinaire (5) et décimale (10), avec formes tabulaires pour le comptage.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Problématique de recherche : peut-on pratiquer la morphologie dérivationnelle sur les noms de personnes en langue fon, en vue d’un dictionnaire étymologique bilingue ?', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/les-langues/fon/',
					'label' => __( 'Fiche langue Fon', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/phonologie/',
					'label' => __( 'Phonologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/lexicologie/',
					'label' => __( 'Lexicologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/xotutu/onomastique/anthroponymie/',
					'label' => __( 'Anthroponymie', 'gbecosmolingua-core' ),
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
function gbe_le_gbe_morphologie_stats() {
	return array(
		array( 'value' => '366', 'label' => __( 'Noms calendaires', 'gbecosmolingua-core' ) ),
		array( 'value' => '6', 'label' => __( 'Parties de thèse', 'gbecosmolingua-core' ) ),
		array( 'value' => '5+10', 'label' => __( 'Bases numérales', 'gbecosmolingua-core' ) ),
		array( 'value' => '2014', 'label' => __( 'Thèse Gnanguenon', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_morphologie_nav() {
	return array(
		array( 'id' => 'derivation', 'label' => __( 'Dérivation', 'gbecosmolingua-core' ) ),
		array( 'id' => 'onomastique', 'label' => __( 'Onomastique', 'gbecosmolingua-core' ) ),
		array( 'id' => 'anthroponymie', 'label' => __( 'Anthroponymie', 'gbecosmolingua-core' ) ),
		array( 'id' => 'numeration', 'label' => __( 'Numération', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_morphologie_suffixes_cards() {
	return array(
		array(
			'tag'   => '-tɔ',
			'title' => __( 'Suffixe agentif', 'gbecosmolingua-core' ),
			'body'  => __( 'Désigne l’homme, l’agent — existence lexicale propre en fongbè.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '-li',
			'title' => __( 'Suffixe possessif', 'gbecosmolingua-core' ),
			'body'  => __( 'Propriétaire, celui qui possède — dérivation productive.', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => '-vi',
			'title' => __( 'Suffixe communautaire', 'gbecosmolingua-core' ),
			'body'  => __( 'Communauté locutrice — lien avec l’ethnonymie gbe.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Fonctions phonologiques de base.
 *
 * @return string[]
 */
function gbe_le_gbe_fon_fonctions_phonologiques() {
	return array(
		'Distinctive — différencie les signifiants (paires minimales : agbà/agbɔ, lampe/rampe)',
		'Contrastive — variantes contextuelles d’un même phonème (axe syntagmatique)',
		'Expressive — hors système, état d’esprit du locuteur',
	);
}

/**
 * Parties de la thèse Gnanguenon.
 *
 * @return string[]
 */
function gbe_le_gbe_fon_these_parties() {
	return array(
		'I — Commutation et phonologie (8 chapitres)',
		'II — Lexicologie et lexicographie (France et Bénin)',
		'III–IV — Onomastique : noms des rois d’Abomey, structure du pouvoir, numération',
		'V — Anthroponymes événementiels et noms calendaires',
		'VI — Linguistique et TICE : dictionnairique, modélisation, logiciels',
	);
}

/**
 * Inventaire des voyelles fon.
 *
 * @return string[]
 */
function gbe_le_gbe_fon_voyelles() {
	return array(
		'Orales antérieures : /i/, /e/, /ɛ/',
		'Orale centrale : /a/',
		'Orales postérieures : /ɔ/, /o/, /u/',
		'Nasales : /ĩ/, /ɛ̃/, /ã/, /ɔ̃/, /ũ/',
	);
}

/**
 * Exemples syllabiques fon.
 *
 * @return string[]
 */
function gbe_le_gbe_fon_exemples_syllabiques() {
	return array(
		'Monosyllabe : à (tu), é (on), gbè (voix), céú (rapidement)',
		'Dissyllabe : àsá (cuisse), kánli (animal), cùkú (chien)',
		'Trissyllabe : zígígí (grand bruit), lògòzò (tortue)',
	);
}

/**
 * Tableau ASCII consonnes fon.
 *
 * @return string
 */
function gbe_le_gbe_fon_consonant_table() {
	return <<<'TABLE'
        p  b  f  v  t  d  ɖ  l  s  z  c  j  y
        k  g  kp gb w  x  h  m  n  ŋ(ny)
TABLE;
}
