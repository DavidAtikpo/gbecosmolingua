<?php
/**
 * Page auteur — Hounkpati B. Christophe Capo.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL de la fiche auteur.
 *
 * @return string
 */
function gbe_le_gbe_capo_author_page_url() {
	return home_url( '/le-gbe/linguistique/hounkpati-b-c-capo/' );
}

/**
 * Lien HTML vers la fiche auteur.
 *
 * @param string $label Libellé du lien (vide = citation courte).
 * @return string
 */
function gbe_le_gbe_capo_author_link_html( $label = '' ) {
	if ( '' === $label ) {
		$label = gbe_le_gbe_bibliography_capo_short();
	}

	return sprintf(
		'<a href="%1$s" class="gbe-author-link">%2$s</a>',
		esc_url( gbe_le_gbe_capo_author_page_url() ),
		esc_html( $label )
	);
}

/**
 * Balises HTML autorisées pour les liens auteur.
 *
 * @return array<string, array<string, bool>>
 */
function gbe_le_gbe_capo_author_kses() {
	return array(
		'a'      => array(
			'href'  => true,
			'class' => true,
		),
		'em'     => array(),
		'strong' => array(),
		'cite'   => array(),
	);
}

/**
 * Transforme les mentions textuelles de Capo / Gbekɔbu en liens.
 *
 * @param string $text Texte échappé ou brut.
 * @return string
 */
function gbe_le_gbe_linkify_capo_references( $text ) {
	$text = (string) $text;
	if ( '' === trim( $text ) || ! function_exists( 'gbe_le_gbe_capo_author_link_html' ) ) {
		return $text;
	}

	if ( str_contains( $text, 'gbe-author-link' ) ) {
		return $text;
	}

	$needles = array(
		'H. C. Capo (Gbekɔbu, 2014)',
		'H. C. Capo (K. N. Gbekɔbu)',
		'Hounkpati B. C. Capo',
		'Hounkpati B.C. Capo',
		'K. N. Gbekɔbu',
		'H. C. Capo',
		'Professeur Capo',
	);

	foreach ( $needles as $needle ) {
		if ( ! str_contains( $text, $needle ) ) {
			continue;
		}

		$link = gbe_le_gbe_capo_author_link_html( $needle );
		$text = str_replace( $needle, $link, $text );
	}

	return wp_kses( $text, gbe_le_gbe_capo_author_kses() );
}

/**
 * Publications principales (sélection).
 *
 * @return array<int, array{year: string, citation: string, note?: string}>
 */
function gbe_le_gbe_capo_publications() {
	return array(
		array(
			'year'     => '1982',
			'citation' => 'Hounkpati B.C. Capo, « Le Gbe est une langue unique », Africa, Journal of the International African Institute, Londres.',
		),
		array(
			'year'     => '1988',
			'citation' => 'Hounkpati B.C. Capo, Renaissance du Gbe (réflexions critiques et constructives sur L’Eve, le Fon, le Gen, l’Aja, le Gun, etc.), Hamburg : Helmut Buske Verlag.',
			'note'     => __( 'Première publication intégrale du classement interne des langues Gbe.', 'gbecosmolingua-core' ),
		),
		array(
			'year'     => '1989',
			'citation' => 'Hounkpati B.C. Capo, Linguistique constructive en Afrique noire, Hamburg : Helmut Buske Verlag.',
		),
		array(
			'year'     => '1989',
			'citation' => 'Hounkpati B.C. Capo, Précis phonologique du gbe : une perspective comparative, Afrikanistische Arbeitspapiere, n° 19, Cologne.',
		),
		array(
			'year'     => '1991',
			'citation' => 'Hounkpati B.C. Capo, A Comparative Phonology of Gbe, Publications in African Languages and Linguistics, 14, Berlin/New York : Foris ; Garome : Labo Gbe (Int.).',
		),
		array(
			'year'     => '1998',
			'citation' => 'Hounkpati B.C. Capo, A classification of the languages of Benin, Florida Hills : Vivlia.',
		),
		array(
			'year'     => '2000',
			'citation' => 'Hounkpati B.C. Capo, The New Ewe Orthography: Based on the Gbe Uniform Standard Orthography (GUSO), Cape Town : CASAS.',
			'note'     => __( 'Orthographe uniforme standard du Gbe (GUSO).', 'gbecosmolingua-core' ),
		),
		array(
			'year'     => '2002',
			'citation' => 'Hounkpati B.C. Capo, « The pan-dialectal approach to orthographic conventions : the case of the Gbe languages of West Africa », in Kwesi Kwaa Prah (éd.), Writing African, Cape Town : CASAS.',
		),
		array(
			'year'     => '2005',
			'citation' => 'Hounkpati B.C. Capo et al., L’orthographe harmonisée des langues Gbe du Ghana, du Togo, du Benin et du Nigeria, Cape Town : CASAS.',
		),
		array(
			'year'     => '2009',
			'citation' => 'Hounkpati B.C. Capo, Flavien Gbéto et Adrien Huannou, Langues africaines dans l’enseignement au Bénin : problèmes et perspectives, Cape Town : CASAS ; Garome : Labo Gbe.',
		),
		array(
			'year'     => '2014',
			'citation' => 'H. C. Capo (K. N. Gbekɔbu), Eʋegbe fe dzè kple Atadi alo Lododowo kple Adaganawo.',
			'note'     => __( 'Ouvrage de référence pour le corpus Le Gbe sur GbeCosmoLingua.', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * URL de l’article Wikipédia (source biographique).
 *
 * @return string
 */
function gbe_le_gbe_capo_wikipedia_url() {
	return 'https://fr.wikipedia.org/wiki/Hounkpati_B_Christophe_Capo';
}

/**
 * URL de la licence Creative Commons.
 *
 * @return string
 */
function gbe_le_gbe_capo_wikipedia_license_url() {
	return 'https://creativecommons.org/licenses/by-sa/4.0/deed.fr';
}

/**
 * Bloc d’attribution Wikipédia (CC BY-SA 4.0).
 *
 * @return string
 */
function gbe_le_gbe_capo_wikipedia_attribution_html() {
	$wiki_url     = gbe_le_gbe_capo_wikipedia_url();
	$license_url  = gbe_le_gbe_capo_wikipedia_license_url();
	$article_name = 'Hounkpati B Christophe Capo';

	ob_start();
	?>
	<aside id="sources" class="gbe-author-wikipedia" aria-label="<?php esc_attr_e( 'Sources et licence', 'gbecosmolingua-core' ); ?>">
		<p class="gbe-author-wikipedia__kicker"><?php esc_html_e( 'Sources', 'gbecosmolingua-core' ); ?></p>
		<p>
			<?php
			printf(
				/* translators: %s: Wikipedia article title */
				esc_html__( 'Les sections Biographie, Œuvre et Publications reprennent et adaptent des éléments de l’article Wikipédia « %s ».', 'gbecosmolingua-core' ),
				esc_html( $article_name )
			);
			?>
		</p>
		<p class="gbe-author-wikipedia__license">
			<?php esc_html_e( 'Contenu disponible sous licence Creative Commons Attribution — Partage dans les Mêmes Conditions 4.0 International (CC BY-SA 4.0).', 'gbecosmolingua-core' ); ?>
		</p>
		<p class="gbe-author-wikipedia__actions">
			<a href="<?php echo esc_url( $wiki_url ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Article Wikipédia →', 'gbecosmolingua-core' ); ?>
			</a>
			<span aria-hidden="true"> · </span>
			<a href="<?php echo esc_url( $license_url ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Licence CC BY-SA 4.0 →', 'gbecosmolingua-core' ); ?>
			</a>
		</p>
	</aside>
	<?php
	return (string) ob_get_clean();
}

/**
 * Notices d'autorité et liens externes.
 *
 * @return array<int, array{label: string, url: string, desc?: string}>
 */
function gbe_le_gbe_capo_authority_links() {
	return array(
		array(
			'label' => __( 'Wikipédia — Hounkpati B Christophe Capo', 'gbecosmolingua-core' ),
			'url'   => gbe_le_gbe_capo_wikipedia_url(),
			'desc'  => __( 'Source principale de la biographie et des publications listées', 'gbecosmolingua-core' ),
		),
		array(
			'label' => 'Library of Congress (LCCN)',
			'url'   => 'https://lccn.loc.gov/',
			'desc'  => __( 'Notice d’autorité — lien externe', 'gbecosmolingua-core' ),
		),
		array(
			'label' => 'BnF — données d’autorité',
			'url'   => 'https://data.bnf.fr/',
			'desc'  => __( 'Notice d’autorité — lien externe', 'gbecosmolingua-core' ),
		),
		array(
			'label' => 'VIAF',
			'url'   => 'https://viaf.org/',
			'desc'  => __( 'Notice d’autorité — lien externe', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Ajoute des liens auteur dans le HTML des chapitres (notes, bibliographie, hero).
 *
 * @param string $html HTML page.
 * @return string
 */
function gbe_le_gbe_linkify_capo_references_in_html( $html ) {
	if ( '' === trim( $html ) || str_contains( $html, 'gbe-author-page' ) ) {
		return $html;
	}

	$html = (string) preg_replace_callback(
		'/(<p class="gbe-le-gbe-hero__source">\s*<cite>)(.*?)(<\/cite>\s*<\/p>)/s',
		static function ( $matches ) {
			return $matches[1] . gbe_le_gbe_linkify_capo_references( $matches[2] ) . $matches[3];
		},
		$html
	);

	return (string) preg_replace_callback(
		'/(<(?:p|cite)[^>]*class="[^"]*(?:gbe-source-note|gbe-chapter-stats-source|gbe-chapter-source-inline|gbe-chapter-bibliography)[^"]*"[^>]*>)(.*?)(<\/(?:p|cite)>)/s',
		static function ( $matches ) {
			return $matches[1] . gbe_le_gbe_linkify_capo_references( $matches[2] ) . $matches[3];
		},
		$html
	);
}

/**
 * Apports majeurs (piliers) pour la fiche auteur.
 *
 * @return array<int, array{title: string, body: string}>
 */
function gbe_le_gbe_capo_oeuvre_pillars() {
	return array(
		array(
			'title' => __( 'Classification interne', 'gbecosmolingua-core' ),
			'body'  => __( 'Regroupement rigoureux du continuum en cinq sections — Vhe, Gen, Ajé, Fon et Phla-Phera.', 'gbecosmolingua-core' ),
		),
		array(
			'title' => __( 'Phonologie comparée', 'gbecosmolingua-core' ),
			'body'  => __( 'Reconstruction du proto-Gbe et monographies comparatives depuis les années 1970.', 'gbecosmolingua-core' ),
		),
		array(
			'title' => __( 'Standardisation', 'gbecosmolingua-core' ),
			'body'  => __( 'Orthographe uniforme (GUSO), harmonisation graphique et fondation du Labo Gbe (Int.).', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Liens internes GbeCosmoLingua.
 *
 * @return array<int, array{label: string, url: string, desc: string}>
 */
function gbe_le_gbe_capo_internal_links() {
	return array(
		array(
			'label' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/linguistique/travaux-scientifiques-recents/',
			'desc'  => __( 'Monographies et cadres de recherche depuis 1966', 'gbecosmolingua-core' ),
		),
		array(
			'label' => __( 'Bibliothèque linguistique', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/linguistique/bibliotheque/',
			'desc'  => __( 'Ressources documentaires du continuum gbe', 'gbecosmolingua-core' ),
		),
		array(
			'label' => __( 'Gbe, une langue unique', 'gbecosmolingua-core' ),
			'url'   => '/le-gbe/le-continuum-gbe/langue-unique/',
			'desc'  => __( 'Unité linguistique et renaissance du gbe', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * HTML de la page auteur.
 *
 * @return string
 */
function gbe_le_gbe_capo_auteur_content() {
	$pub_count = count( gbe_le_gbe_capo_publications() );

	ob_start();
	?>
	<div class="gbe-chapter gbe-author-page">
		<nav class="gbe-author-nav" aria-label="<?php esc_attr_e( 'Sections de la fiche auteur', 'gbecosmolingua-core' ); ?>">
			<?php foreach ( gbe_le_gbe_capo_nav() as $anchor ) : ?>
				<a class="gbe-author-nav__link" href="#<?php echo esc_attr( $anchor['id'] ); ?>"><?php echo esc_html( $anchor['label'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<header class="gbe-author-hero-card">
			<p class="gbe-author-hero-card__kicker"><?php esc_html_e( 'Figure de référence', 'gbecosmolingua-core' ); ?></p>
			<p class="gbe-author-hero-card__aka"><em><?php esc_html_e( 'Également publié sous K. N. Gbekɔbu', 'gbecosmolingua-core' ); ?></em></p>
			<p class="gbe-author-hero-card__role"><?php esc_html_e( 'Professeur titulaire de linguistique — Université d’Abomey-Calavi (Bénin)', 'gbecosmolingua-core' ); ?></p>
			<ul class="gbe-author-hero-card__facts">
				<li><?php esc_html_e( 'Né le 1er janvier 1953', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Professeur titulaire (CAMES, 1993)', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Chevalier (1995) · Officier (2008) — Ordre national du Bénin', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Directeur adjoint — École doctorale pluridisciplinaire, FLASH-UAC', 'gbecosmolingua-core' ); ?></li>
			</ul>
			<p class="gbe-author-hero-card__source">
				<?php esc_html_e( 'Données biographiques d’après', 'gbecosmolingua-core' ); ?>
				<a href="<?php echo esc_url( gbe_le_gbe_capo_wikipedia_url() ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Wikipédia', 'gbecosmolingua-core' ); ?></a>.
			</p>
		</header>

		<section id="presentation" class="gbe-author-section">
			<header class="gbe-author-section__head">
				<h2 class="gbe-author-section__title"><?php esc_html_e( 'Présentation', 'gbecosmolingua-core' ); ?></h2>
			</header>
			<div class="gbe-author-lead-card">
				<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Hounkpati B. Christophe Capo est l’une des figures centrales de la linguistique gbe contemporaine. Ses travaux ont contribué à réhabiliter le continuum dialectal gbe — autrefois décrit sous l’étiquette « langues Aja-Éwé du Golfe du Bénin » — en proposant une classification interne rigoureuse, une reconstruction phonologique du proto-Gbe et des propositions d’orthographe unifiée.', 'gbecosmolingua-core' ); ?></p>
				<p><?php esc_html_e( 'GbeCosmoLingua s’appuie notamment sur son ouvrage Eʋegbe fe dzè kple Atadi alo Lododowo kple Adaganawo (2014), publié sous le pseudonyme K. N. Gbekɔbu, pour la documentation des chapitres Le Gbe.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="biographie" class="gbe-author-section">
			<header class="gbe-author-section__head">
				<h2 class="gbe-author-section__title"><?php esc_html_e( 'Biographie', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-author-section__source">
					<em>
						<?php esc_html_e( 'Source :', 'gbecosmolingua-core' ); ?>
						<a href="<?php echo esc_url( gbe_le_gbe_capo_wikipedia_url() ); ?>" target="_blank" rel="noopener noreferrer">Wikipédia</a>
						<?php esc_html_e( '(CC BY-SA 4.0).', 'gbecosmolingua-core' ); ?>
					</em>
				</p>
			</header>
			<div class="gbe-author-prose">
				<p><?php esc_html_e( 'Titulaire d’une licence des lettres (1974) et d’une maîtrise de linguistique (1977) de l’Université nationale du Bénin (UNB), Hounkpati B. Christophe Capo obtient un master of arts (1977) et un Ph.D. en linguistique à l’Université du Ghana (1981). Il enseigne et collabore avec plusieurs universités de la sous-région ouest-africaine, notamment à Benin City et à Ilorin (Nigeria) dès 1978.', 'gbecosmolingua-core' ); ?></p>
				<p><?php esc_html_e( 'Recruté comme professeur assistant à l’UNB en 1986, il accède aux grades de maître-assistant (1988), maître de conférences (1989) et professeur titulaire (1993) dans le cadre du CAMES. Secrétaire permanent par intérim du Conseil scientifique de l’UNB (1994–1999), il est décoré chevalier de l’Ordre national du Bénin en 1995, puis officier en 2008.', 'gbecosmolingua-core' ); ?></p>
				<p><?php esc_html_e( 'À la rentrée 2012-2013, il est nommé doyen de la Faculté des lettres, arts et sciences humaines d’Aplahoué (Département du Couffo), entité de l’Université d’Abomey-Calavi. Il a mené des activités de recherche et d’enseignement dans de nombreuses institutions en Afrique, en Europe et en Amérique du Nord.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="oeuvre" class="gbe-author-section gbe-author-section--highlight">
			<header class="gbe-author-section__head">
				<h2 class="gbe-author-section__title"><?php esc_html_e( 'Œuvre et apports au continuum Gbe', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-author-section__source">
					<em>
						<?php esc_html_e( 'Synthèse d’après', 'gbecosmolingua-core' ); ?>
						<a href="<?php echo esc_url( gbe_le_gbe_capo_wikipedia_url() ); ?>" target="_blank" rel="noopener noreferrer">Wikipédia</a>.
					</em>
				</p>
			</header>
			<div class="gbe-author-pillars">
				<?php foreach ( gbe_le_gbe_capo_oeuvre_pillars() as $pillar ) : ?>
					<article class="gbe-author-pillar">
						<h3 class="gbe-author-pillar__title"><?php echo esc_html( $pillar['title'] ); ?></h3>
						<p class="gbe-author-pillar__body"><?php echo esc_html( $pillar['body'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="gbe-author-prose">
				<p><?php esc_html_e( 'Dès les années 1970, le professeur Capo mène des recherches comparatives approfondies sur les langues gbe. Dans Renaissance du Gbe (1988), il publie pour la première fois l’ensemble du classement interne. A Comparative Phonology of Gbe (1991) consolide la perspective comparée.', 'gbecosmolingua-core' ); ?></p>
				<p><?php esc_html_e( 'Il fonde et anime le Labo Gbe (Int.) — Laboratoire de recherche sur les langues Gbe — à Gadomè, avec un centre de documentation et la revue Etudes Gbe – Gbe Studies.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<section id="publications" class="gbe-author-section">
			<header class="gbe-author-section__head">
				<h2 class="gbe-author-section__title"><?php esc_html_e( 'Publications principales', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-author-section__meta">
					<span class="gbe-author-section__count"><?php echo esc_html( (string) $pub_count ); ?></span>
					<?php esc_html_e( 'ouvrages et articles de référence', 'gbecosmolingua-core' ); ?>
				</p>
				<p class="gbe-author-section__source">
					<em>
						<?php esc_html_e( 'Liste établie d’après', 'gbecosmolingua-core' ); ?>
						<a href="<?php echo esc_url( gbe_le_gbe_capo_wikipedia_url() ); ?>" target="_blank" rel="noopener noreferrer">Wikipédia</a>.
					</em>
				</p>
			</header>
			<ol class="gbe-author-timeline">
				<?php foreach ( gbe_le_gbe_capo_publications() as $pub ) : ?>
					<li class="gbe-author-timeline__item">
						<div class="gbe-author-timeline__marker">
							<span class="gbe-author-timeline__year"><?php echo esc_html( $pub['year'] ); ?></span>
						</div>
						<div class="gbe-author-timeline__body">
							<cite class="gbe-author-timeline__cite"><?php echo esc_html( $pub['citation'] ); ?></cite>
							<?php if ( ! empty( $pub['note'] ) ) : ?>
								<p class="gbe-author-timeline__note"><em><?php echo esc_html( $pub['note'] ); ?></em></p>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</section>

		<section id="liens" class="gbe-author-section">
			<header class="gbe-author-section__head">
				<h2 class="gbe-author-section__title"><?php esc_html_e( 'Ressources et notices', 'gbecosmolingua-core' ); ?></h2>
			</header>
			<div class="gbe-author-links-grid">
				<?php foreach ( gbe_le_gbe_capo_internal_links() as $link ) : ?>
					<a class="gbe-author-link-card" href="<?php echo esc_url( home_url( $link['url'] ) ); ?>">
						<span class="gbe-author-link-card__label"><?php echo esc_html( $link['label'] ); ?></span>
						<span class="gbe-author-link-card__desc"><?php echo esc_html( $link['desc'] ); ?></span>
					</a>
				<?php endforeach; ?>
				<?php foreach ( gbe_le_gbe_capo_authority_links() as $link ) : ?>
					<a class="gbe-author-link-card gbe-author-link-card--external<?php echo str_contains( $link['url'], 'wikipedia.org' ) ? ' gbe-author-link-card--wiki' : ''; ?>" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
						<span class="gbe-author-link-card__label"><?php echo esc_html( $link['label'] ); ?></span>
						<span class="gbe-author-link-card__desc"><?php echo esc_html( $link['desc'] ?? __( 'Lien externe', 'gbecosmolingua-core' ) ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</section>

		<?php echo gbe_le_gbe_capo_wikipedia_attribution_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/linguistique/travaux-scientifiques-recents/',
					'label' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/dialectologie/',
					'label' => __( 'Dialectologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/bibliotheque/',
					'label' => __( 'Bibliothèque', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_capo_nav() {
	return array(
		array(
			'id'    => 'presentation',
			'label' => __( 'Présentation', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'biographie',
			'label' => __( 'Biographie', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'oeuvre',
			'label' => __( 'Œuvre', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'publications',
			'label' => __( 'Publications', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'liens',
			'label' => __( 'Ressources', 'gbecosmolingua-core' ),
		),
		array(
			'id'    => 'sources',
			'label' => __( 'Sources', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Encart « figure de référence » pour Travaux scientifiques.
 *
 * @return string
 */
function gbe_le_gbe_capo_feature_card_html() {
	ob_start();
	?>
	<aside class="gbe-author-feature" aria-label="<?php esc_attr_e( 'Figure de référence', 'gbecosmolingua-core' ); ?>">
		<p class="gbe-author-feature__kicker"><?php esc_html_e( 'Figure de référence', 'gbecosmolingua-core' ); ?></p>
		<h2 class="gbe-author-feature__title"><?php esc_html_e( 'Hounkpati B. Christophe Capo', 'gbecosmolingua-core' ); ?></h2>
		<p><?php esc_html_e( 'Professeur titulaire à l’UAC, pionnier de la linguistique comparée gbe : classification interne du continuum, phonologie comparée, orthographe unifiée (GUSO) et fondation du Labo Gbe (Int.).', 'gbecosmolingua-core' ); ?></p>
		<p><a class="gbe-chapter-footer__link" href="<?php echo esc_url( gbe_le_gbe_capo_author_page_url() ); ?>"><?php esc_html_e( 'Biographie, œuvre et publications →', 'gbecosmolingua-core' ); ?></a></p>
	</aside>
	<?php
	return (string) ob_get_clean();
}
