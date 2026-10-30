<?php
/**
 * Composants UI pour les pages chapitre Gbe / Linguistique.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Résout l’URI hiérarchique d’une page (slug hub ou objet WP_Post).
 *
 * @param string|WP_Post $page Slug, URI ou page.
 * @return string
 */
function gbe_le_gbe_resolve_page_uri( $page ) {
	if ( $page instanceof WP_Post ) {
		$uri = get_page_uri( $page );
		return is_string( $uri ) ? $uri : '';
	}

	$slug = trim( (string) $page, '/' );
	if ( str_contains( $slug, '/' ) ) {
		return $slug;
	}

	$slug_uri_map = array(
		'le-gbe'       => 'le-gbe',
		'linguistique' => 'le-gbe/linguistique',
		'cultures-gbe' => 'cultures-gbe',
		'xotutu'       => 'xotutu',
		'onomastique'  => 'xotutu/onomastique',
		'paremiologie' => 'paremiologie',
	);

	return $slug_uri_map[ $slug ] ?? $slug;
}

/**
 * Citation courte — H. C. Capo / Gbekɔbu (2014).
 *
 * @return string
 */
function gbe_le_gbe_bibliography_capo_short() {
	return __( 'H. C. Capo (Gbekɔbu, 2014)', 'gbecosmolingua-core' );
}

/**
 * Référence bibliographique complète — ouvrage principal du corpus Gbe.
 *
 * @return string
 */
function gbe_le_gbe_bibliography_capo_full() {
	return __( 'H. C. Capo (K. N. Gbekɔbu), Eʋegbe fe dzè kple Atadi alo Lododowo kple Adaganawo, 2014.', 'gbecosmolingua-core' );
}

/**
 * Référence chapitre Capo pour une URI de page.
 *
 * @param string $uri URI hiérarchique WordPress (ex. le-gbe/linguistique/dialectologie).
 * @return string
 */
function gbe_le_gbe_page_chapter_ref( $uri ) {
	$uri = trim( (string) $uri, '/' );
	$map = array(
		'le-gbe'                                             => __( 'synthèse, ch. 1', 'gbecosmolingua-core' ),
		'le-gbe/presentation-generale'                       => __( 'ch. 1 et 9', 'gbecosmolingua-core' ),
		'le-gbe/peuples-du-continuum'                        => __( 'ch. 1 et 9', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe'                            => __( 'ch. 1, 7 et 9', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/inventaire-des-parlers'     => __( 'ch. 1 — Généralités', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/regroupement-des-parlers'   => __( 'ch. 7', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/langue-unique'              => __( 'ch. 9', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/varietes-principales'       => __( 'ch. 1 et 9', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/pays-et-territoires'        => __( 'ch. 1', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/pays-et-territoires/ghana'  => __( 'ch. 1', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/pays-et-territoires/togo'  => __( 'ch. 1', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/pays-et-territoires/benin'  => __( 'ch. 1', 'gbecosmolingua-core' ),
		'le-gbe/le-continuum-gbe/pays-et-territoires/nigeria' => __( 'ch. 1', 'gbecosmolingua-core' ),
		'le-gbe/les-langues'                                 => __( 'ch. 1, 7 et 9', 'gbecosmolingua-core' ),
		'le-gbe/linguistique'                                => __( 'ch. 5 à 9', 'gbecosmolingua-core' ),
		'le-gbe/linguistique/travaux-scientifiques-recents'  => __( 'ch. 5', 'gbecosmolingua-core' ),
		'le-gbe/linguistique/hounkpati-b-c-capo'             => '',
		'le-gbe/linguistique/potentialites-lexicales'        => __( 'ch. 6', 'gbecosmolingua-core' ),
		'le-gbe/linguistique/dialectologie'                  => __( 'ch. 7 et 9', 'gbecosmolingua-core' ),
		'le-gbe/linguistique/lexicologie'                    => __( 'ch. 6', 'gbecosmolingua-core' ),
		'le-gbe/carte-interactive'                           => __( 'ch. 1', 'gbecosmolingua-core' ),
		'cultures-gbe'                                       => __( 'ch. 1 et 9', 'gbecosmolingua-core' ),
		'xotutu'                                             => __( 'ch. 1 et 9', 'gbecosmolingua-core' ),
		'xotutu/onomastique'                                 => __( 'ch. 1 et 9', 'gbecosmolingua-core' ),
		'paremiologie'                                       => __( 'ch. 6 et corpus éwé', 'gbecosmolingua-core' ),
	);

	if ( isset( $map[ $uri ] ) ) {
		return $map[ $uri ];
	}

	if ( str_starts_with( $uri, 'le-gbe/les-langues/' ) ) {
		return __( 'ch. 1, 7 et 9', 'gbecosmolingua-core' );
	}

	if ( str_contains( $uri, 'linguistique/phonologie' ) || str_contains( $uri, 'linguistique/morphologie' ) ) {
		return __( 'GNANGUENON (2014) ; Capo (2014)', 'gbecosmolingua-core' );
	}

	return '';
}

/**
 * Bibliographie de pied de page selon la page.
 *
 * @param string $uri URI page.
 * @return array<int, string>
 */
function gbe_le_gbe_bibliography_for_uri( $uri ) {
	$uri     = trim( (string) $uri, '/' );
	$sources = array();

	if (
		str_contains( $uri, 'les-langues/fon' )
		|| str_contains( $uri, 'linguistique/phonologie' )
		|| str_contains( $uri, 'linguistique/morphologie' )
	) {
		$sources[] = __( 'Cossi Boniface GNANGUENON, Description du fongbè…, thèse de doctorat, Université de Cergy-Pontoise, 2014.', 'gbecosmolingua-core' );
	}

	if ( str_contains( $uri, 'paremiologie' ) || str_contains( $uri, 'proverbes' ) ) {
		$sources[] = __( 'Corpus éwé — K. N. Gbekɔbu (2014) ; Benedicta Esi Anibri, Lãwo fe gbe : Lododo tso Lãwo ŋu, 2003.', 'gbecosmolingua-core' );
	}

	$sources[] = gbe_le_gbe_bibliography_capo_full();

	return array_values( array_unique( $sources ) );
}

/**
 * Source affichée sous le chapô hero d’un hub.
 *
 * @param string $slug Slug page hub.
 * @return string
 */
function gbe_le_gbe_hero_lead_source_text( $slug ) {
	$uri = gbe_le_gbe_resolve_page_uri( $slug );
	if ( '' === $uri ) {
		return '';
	}

	$chapter = gbe_le_gbe_page_chapter_ref( $uri );
	if ( '' === $chapter ) {
		return sprintf(
			/* translators: %s: author short citation */
			__( 'Source : %s.', 'gbecosmolingua-core' ),
			gbe_le_gbe_bibliography_capo_short()
		);
	}

	return sprintf(
		/* translators: 1: author short citation, 2: chapter reference */
		__( 'Source : %1$s, %2$s.', 'gbecosmolingua-core' ),
		gbe_le_gbe_bibliography_capo_short(),
		$chapter
	);
}

/**
 * Note de source en tête de chapitre (contexte + auteur).
 *
 * @param string $context     Description de la page.
 * @param string $chapter_ref Référence chapitre (optionnel).
 * @return string
 */
function gbe_chapter_source_note( $context, $chapter_ref = '' ) {
	$author_link = function_exists( 'gbe_le_gbe_capo_author_link_html' )
		? gbe_le_gbe_capo_author_link_html()
		: esc_html( gbe_le_gbe_bibliography_capo_short() );

	ob_start();
	?>
	<p class="gbe-source-note"><em>
		<?php
		echo esc_html( $context );
		echo ' — ';
		esc_html_e( 'Source :', 'gbecosmolingua-core' );
		echo ' ';
		echo wp_kses( $author_link, function_exists( 'gbe_le_gbe_capo_author_kses' ) ? gbe_le_gbe_capo_author_kses() : array( 'a' => array( 'href' => true, 'class' => true ) ) );
		if ( '' !== $chapter_ref ) {
			echo esc_html( ', ' . $chapter_ref );
		}
		echo '.';
		?>
	</em></p>
	<?php
	return (string) ob_get_clean();
}

/**
 * Bloc bibliographie en pied de chapitre.
 *
 * @param array<int, string> $sources Entrées bibliographiques.
 * @return string
 */
function gbe_chapter_bibliography_footer( $sources = array() ) {
	if ( empty( $sources ) ) {
		$sources = array( gbe_le_gbe_bibliography_capo_full() );
	}

	ob_start();
	?>
	<aside class="gbe-chapter-bibliography" aria-label="<?php esc_attr_e( 'Références', 'gbecosmolingua-core' ); ?>">
		<p class="gbe-chapter-bibliography__label"><?php esc_html_e( 'Références', 'gbecosmolingua-core' ); ?></p>
		<ul class="gbe-chapter-bibliography__list">
			<?php foreach ( $sources as $source ) : ?>
				<li><cite><?php
				if ( function_exists( 'gbe_le_gbe_linkify_capo_references' ) ) {
					echo wp_kses( gbe_le_gbe_linkify_capo_references( $source ), gbe_le_gbe_capo_author_kses() );
				} else {
					echo esc_html( $source );
				}
				?></cite></li>
			<?php endforeach; ?>
		</ul>
	</aside>
	<?php
	return (string) ob_get_clean();
}

/**
 * Complète les notes de source sans auteur explicite.
 *
 * @param string $html HTML chapitre.
 * @param string $uri  URI page.
 * @return string
 */
function gbe_le_gbe_enhance_source_notes( $html, $uri = '' ) {
	if ( ! str_contains( $html, 'gbe-source-note' ) ) {
		return $html;
	}

	$chapter_ref = gbe_le_gbe_page_chapter_ref( $uri );
	$author      = gbe_le_gbe_bibliography_capo_short();

	return (string) preg_replace_callback(
		'/<p class="gbe-source-note"><em>(.*?)<\/em><\/p>/s',
		static function ( $matches ) use ( $chapter_ref, $author ) {
			$text = html_entity_decode( wp_strip_all_tags( $matches[1] ), ENT_QUOTES, 'UTF-8' );

			if ( preg_match( '/Capo|Gbekɔbu|GNANGUENON|Spieth|Anibri|Pazzi/i', $text ) ) {
				return $matches[0];
			}

			if ( '' !== $chapter_ref ) {
				$text .= ' — ' . sprintf(
					/* translators: 1: author, 2: chapter */
					__( 'Source : %1$s, %2$s.', 'gbecosmolingua-core' ),
					$author,
					$chapter_ref
				);
			} else {
				$text .= ' — ' . sprintf(
					/* translators: %s: author */
					__( 'Source : %s.', 'gbecosmolingua-core' ),
					$author
				);
			}

			return '<p class="gbe-source-note"><em>' . wp_kses( gbe_le_gbe_linkify_capo_references( $text ), gbe_le_gbe_capo_author_kses() ) . '</em></p>';
		},
		$html
	);
}

/**
 * Ajoute note de source, bibliographie et attributions manquantes.
 *
 * @param string         $html HTML page.
 * @param string|WP_Post $page URI ou objet page.
 * @return string
 */
function gbe_le_gbe_enrich_chapter_html( $html, $page = '' ) {
	$html = (string) $html;
	if ( '' === trim( $html ) ) {
		return $html;
	}

	$uri = gbe_le_gbe_resolve_page_uri( $page );
	if ( '' === $uri && $page instanceof WP_Post ) {
		$uri = get_page_uri( $page );
	}
	$uri = is_string( $uri ) ? $uri : '';

	if ( str_contains( $uri, 'hounkpati-b-c-capo' ) ) {
		return $html;
	}

	$is_chapter = str_contains( $html, 'gbe-chapter' );
	$is_le_gbe  = str_starts_with( $uri, 'le-gbe' )
		|| in_array( $uri, array( 'cultures-gbe', 'xotutu', 'paremiologie' ), true )
		|| str_starts_with( $uri, 'xotutu/' );

	if ( ! $is_chapter && ! $is_le_gbe ) {
		return $html;
	}

	if ( $is_chapter && ! str_contains( $html, 'gbe-source-note' ) ) {
		$chapter_ref = gbe_le_gbe_page_chapter_ref( $uri );
		$context     = $chapter_ref
			? sprintf(
				/* translators: %s: chapter reference */
				__( 'Page documentée d’après %s', 'gbecosmolingua-core' ),
				$chapter_ref
			)
			: __( 'Page documentée d’après le corpus Gbe', 'gbecosmolingua-core' );
		$note        = gbe_chapter_source_note( $context, $chapter_ref );
		$html        = preg_replace( '/(<div class="gbe-chapter"[^>]*>)/', '$1' . $note, $html, 1 ) ?? $html;
	} elseif ( $is_le_gbe && ! str_contains( $html, 'gbe-source-note' ) ) {
		$chapter_ref = gbe_le_gbe_page_chapter_ref( $uri );
		$context     = $chapter_ref
			? sprintf(
				/* translators: %s: chapter reference */
				__( 'Page documentée d’après %s', 'gbecosmolingua-core' ),
				$chapter_ref
			)
			: __( 'Page documentée d’après le corpus Gbe', 'gbecosmolingua-core' );
		$html        = gbe_chapter_source_note( $context, $chapter_ref ) . $html;
	} else {
		$html = gbe_le_gbe_enhance_source_notes( $html, $uri );
	}

	if ( ! str_contains( $html, 'gbe-chapter-bibliography' ) ) {
		$footer = gbe_chapter_bibliography_footer( gbe_le_gbe_bibliography_for_uri( $uri ) );
		if ( $is_chapter ) {
			if ( str_contains( $html, 'gbe-chapter-footer' ) ) {
				$html = str_replace( '<footer class="gbe-chapter-footer"', $footer . '<footer class="gbe-chapter-footer"', $html );
			} else {
				$html = preg_replace( '/(<div class="gbe-chapter"[^>]*>.*?)(<\/div>\s*)$/s', '$1' . $footer . '$2', $html, 1 ) ?? ( $html . $footer );
			}
		} else {
			$html .= $footer;
		}
	}

	if ( function_exists( 'gbe_le_gbe_linkify_capo_references_in_html' ) ) {
		$html = gbe_le_gbe_linkify_capo_references_in_html( $html );
	}

	return $html;
}

/**
 * Bandeau statistiques chapitre.
 *
 * @param array<int, array{value: string, label: string}> $items Stats.
 * @return string
 */
function gbe_chapter_stats( $items ) {
	if ( empty( $items ) ) {
		return '';
	}
	ob_start();
	?>
	<div class="gbe-chapter-stats">
		<div class="gbe-chapter-stats__grid">
			<?php foreach ( $items as $item ) : ?>
				<div class="gbe-chapter-stats__item">
					<p class="gbe-chapter-stats__value"><?php echo esc_html( $item['value'] ); ?></p>
					<p class="gbe-chapter-stats__label"><?php echo esc_html( $item['label'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Navigation ancres in-page.
 *
 * @param array<int, array{id: string, label: string}> $anchors Ancres.
 * @return string
 */
function gbe_chapter_nav( $anchors ) {
	if ( empty( $anchors ) ) {
		return '';
	}

	ob_start();
	echo '<nav class="gbe-chapter-nav" aria-label="' . esc_attr__( 'Sections du chapitre', 'gbecosmolingua-core' ) . '">';
	foreach ( $anchors as $anchor ) {
		echo '<a class="gbe-chapter-nav__tab" href="#' . esc_attr( $anchor['id'] ) . '">' . esc_html( $anchor['label'] ) . '</a>';
	}
	echo '</nav>';

	return (string) ob_get_clean();
}

/**
 * Cartes pays / institutions.
 *
 * @param array<int, array{code: string, title: string, body: string}> $cards Cartes.
 * @return string
 */
function gbe_chapter_country_cards( $cards ) {
	if ( empty( $cards ) ) {
		return '';
	}
	ob_start();
	echo '<div class="gbe-chapter-cards gbe-chapter-cards--countries">';
	foreach ( $cards as $card ) {
		echo '<article class="gbe-chapter-card gbe-chapter-card--country">';
		echo '<span class="gbe-chapter-card__badge" aria-hidden="true">' . esc_html( $card['code'] ) . '</span>';
		echo '<h3 class="gbe-chapter-card__title">' . esc_html( $card['title'] ) . '</h3>';
		echo '<p class="gbe-chapter-card__body">' . esc_html( $card['body'] ) . '</p>';
		echo '</article>';
	}
	echo '</div>';
	return (string) ob_get_clean();
}

/**
 * Cartes pays cliquables (hub vers fiches détaillées).
 *
 * @param array<int, array{code: string, title: string, body: string, url: string, meta?: string}> $cards Cartes.
 * @return string
 */
function gbe_chapter_country_link_cards( $cards ) {
	if ( empty( $cards ) ) {
		return '';
	}

	ob_start();
	echo '<div class="gbe-chapter-cards gbe-chapter-cards--countries gbe-chapter-cards--country-links">';
	foreach ( $cards as $card ) {
		echo '<a class="gbe-chapter-card gbe-chapter-card--country gbe-chapter-card--link" href="' . esc_url( $card['url'] ) . '">';
		echo '<span class="gbe-chapter-card__badge" aria-hidden="true">' . esc_html( $card['code'] ) . '</span>';
		echo '<h3 class="gbe-chapter-card__title">' . esc_html( $card['title'] ) . '</h3>';
		echo '<p class="gbe-chapter-card__body">' . esc_html( $card['body'] ) . '</p>';
		if ( ! empty( $card['meta'] ) ) {
			echo '<p class="gbe-chapter-card__meta">' . esc_html( $card['meta'] ) . '</p>';
		}
		echo '<span class="gbe-chapter-card__cta">' . esc_html__( 'Voir la fiche →', 'gbecosmolingua-core' ) . '</span>';
		echo '</a>';
	}
	echo '</div>';

	return (string) ob_get_clean();
}

/**
 * Frise chronologique des travaux.
 *
 * @param array<int, array{year: string, author: string, title: string, note?: string}> $entries Entrées.
 * @return string
 */
function gbe_chapter_timeline( $entries ) {
	if ( empty( $entries ) ) {
		return '';
	}
	ob_start();
	?>
	<ol class="gbe-chapter-timeline"><?php
	foreach ( $entries as $entry ) {
		echo '<li class="gbe-chapter-timeline__item">';
		echo '<span class="gbe-chapter-timeline__year">' . esc_html( $entry['year'] ) . '</span>';
		echo '<div class="gbe-chapter-timeline__body">';
		echo '<p class="gbe-chapter-timeline__author">' . esc_html( $entry['author'] ) . '</p>';
		echo '<p class="gbe-chapter-timeline__title">' . esc_html( $entry['title'] ) . '</p>';
		if ( ! empty( $entry['note'] ) ) {
			echo '<p class="gbe-chapter-timeline__note">' . esc_html( $entry['note'] ) . '</p>';
		}
		echo '</div></li>';
	}
	?></ol>
	<?php
	return (string) ob_get_clean();
}

/**
 * Cartes références (dictionnaires, synthèses).
 *
 * @param array<int, array{tag: string, title: string, body: string, meta?: string}> $refs      Références.
 * @param string                                                                      $modifier  Modificateur CSS (ex. --refs, --angles).
 * @return string
 */
function gbe_chapter_ref_cards( $refs, $modifier = '--refs' ) {
	if ( empty( $refs ) ) {
		return '';
	}

	$class = 'gbe-chapter-cards gbe-chapter-cards' . $modifier;

	ob_start();
	echo '<div class="' . esc_attr( $class ) . '">';
	foreach ( $refs as $ref ) {
		echo '<article class="gbe-chapter-card gbe-chapter-card--ref">';
		echo '<span class="gbe-chapter-card__tag">' . esc_html( $ref['tag'] ) . '</span>';
		echo '<h3 class="gbe-chapter-card__title">' . esc_html( $ref['title'] ) . '</h3>';
		echo '<p class="gbe-chapter-card__body">' . esc_html( $ref['body'] ) . '</p>';
		if ( ! empty( $ref['meta'] ) ) {
			echo '<p class="gbe-chapter-card__meta">' . esc_html( $ref['meta'] ) . '</p>';
		}
		echo '</article>';
	}
	echo '</div>';

	return (string) ob_get_clean();
}

/**
 * Grille de parlers par pays.
 *
 * @param array<int, array{code: string, title: string, parlers: string[]}> $panels Panneaux.
 * @return string
 */
function gbe_chapter_parler_panels( $panels ) {
	if ( empty( $panels ) ) {
		return '';
	}

	ob_start();
	echo '<div class="gbe-chapter-parlers">';
	foreach ( $panels as $panel ) {
		$count = count( $panel['parlers'] );
		echo '<section class="gbe-chapter-parlers__panel" id="' . esc_attr( sanitize_title( $panel['title'] ) ) . '">';
		echo '<header class="gbe-chapter-parlers__head">';
		echo '<span class="gbe-chapter-card__badge">' . esc_html( $panel['code'] ) . '</span>';
		echo '<h3 class="gbe-chapter-parlers__title">' . esc_html( $panel['title'] ) . '</h3>';
		echo '<span class="gbe-chapter-parlers__count">' . esc_html( sprintf( _n( '%d parler', '%d parlers', $count, 'gbecosmolingua-core' ), $count ) ) . '</span>';
		echo '</header>';
		echo '<ul class="gbe-chapter-parlers__chips">';
		foreach ( $panel['parlers'] as $parler ) {
			echo '<li class="gbe-chapter-parler-chip">' . esc_html( $parler ) . '</li>';
		}
		echo '</ul></section>';
	}
	echo '</div>';

	return (string) ob_get_clean();
}

/**
 * Cartes des sections dialectologiques.
 *
 * @param array<int, array{tag: string, title: string, body: string, examples?: string}> $sections Sections.
 * @return string
 */
function gbe_chapter_dialect_cards( $sections ) {
	if ( empty( $sections ) ) {
		return '';
	}

	ob_start();
	echo '<div class="gbe-chapter-cards gbe-chapter-cards--dialects">';
	foreach ( $sections as $section ) {
		echo '<article class="gbe-chapter-card gbe-chapter-card--dialect">';
		echo '<span class="gbe-chapter-card__tag">' . esc_html( $section['tag'] ) . '</span>';
		echo '<h3 class="gbe-chapter-card__title">' . esc_html( $section['title'] ) . '</h3>';
		echo '<p class="gbe-chapter-card__body">' . esc_html( $section['body'] ) . '</p>';
		if ( ! empty( $section['examples'] ) ) {
			echo '<p class="gbe-chapter-card__meta">' . esc_html( $section['examples'] ) . '</p>';
		}
		echo '</article>';
	}
	echo '</div>';

	return (string) ob_get_clean();
}

/**
 * Panneaux détaillés des sections dialectologiques (innovations + parlers).
 *
 * @param array<int, array{tag: string, title: string, innovations: string[], parlers: string[], body: string}> $sections Sections.
 * @return string
 */
function gbe_chapter_dialect_detail_panels( $sections ) {
	if ( empty( $sections ) ) {
		return '';
	}

	ob_start();
	echo '<div class="gbe-chapter-dialects">';
	foreach ( $sections as $section ) {
		$count   = count( $section['parlers'] );
		$panel_id = sanitize_title( $section['tag'] );

		echo '<section class="gbe-chapter-dialects__panel" id="' . esc_attr( $panel_id ) . '">';
		echo '<header class="gbe-chapter-dialects__head">';
		echo '<span class="gbe-chapter-card__badge">' . esc_html( $section['tag'] ) . '</span>';
		echo '<h3 class="gbe-chapter-dialects__title">' . esc_html( $section['title'] ) . '</h3>';
		echo '<span class="gbe-chapter-dialects__count">' . esc_html( sprintf( _n( '%d parler', '%d parlers', $count, 'gbecosmolingua-core' ), $count ) ) . '</span>';
		echo '</header>';

		if ( ! empty( $section['innovations'] ) ) {
			echo '<h4 class="gbe-chapter-dialects__subtitle">' . esc_html__( 'Innovations phonologiques', 'gbecosmolingua-core' ) . '</h4>';
			echo gbe_chapter_list( $section['innovations'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $section['parlers'] ) ) {
			echo '<p class="gbe-chapter-dialects__parlers-label">' . esc_html__( 'Parlers', 'gbecosmolingua-core' ) . '</p>';
			echo '<ul class="gbe-chapter-parlers__chips">';
			foreach ( $section['parlers'] as $parler ) {
				echo '<li class="gbe-chapter-parler-chip">' . esc_html( $parler ) . '</li>';
			}
			echo '</ul>';
		}

		if ( ! empty( $section['body'] ) ) {
			echo '<p class="gbe-chapter-dialects__body">' . esc_html( $section['body'] ) . '</p>';
		}

		echo '</section>';
	}
	echo '</div>';

	return (string) ob_get_clean();
}

/**
 * Tableau de données (ex. Swadesh).
 *
 * @param array<int, array<string, string>> $rows    Lignes.
 * @param array<int, string>                $headers En-têtes.
 * @return string
 */
function gbe_chapter_data_table( $rows, $headers ) {
	if ( empty( $rows ) || empty( $headers ) ) {
		return '';
	}

	$keys = array_keys( $rows[0] );

	ob_start();
	echo '<div class="gbe-chapter-table-wrap"><table class="gbe-chapter-table"><thead><tr>';
	foreach ( $headers as $header ) {
		echo '<th>' . esc_html( $header ) . '</th>';
	}
	echo '</tr></thead><tbody>';
	foreach ( $rows as $row ) {
		echo '<tr>';
		foreach ( $keys as $key ) {
			echo '<td>' . esc_html( $row[ $key ] ?? '' ) . '</td>';
		}
		echo '</tr>';
	}
	echo '</tbody></table></div>';

	return (string) ob_get_clean();
}

/**
 * Encadré schéma / arbre dialectologique.
 *
 * @param string $schema Texte ASCII.
 * @param string $label  Label accessibilité.
 * @return string
 */
function gbe_chapter_schema_box( $schema, $label = '' ) {
	if ( '' === trim( $schema ) ) {
		return '';
	}
	if ( '' === $label ) {
		$label = __( 'Schéma', 'gbecosmolingua-core' );
	}

	ob_start();
	echo '<div class="gbe-chapter-schema" role="img" aria-label="' . esc_attr( $label ) . '">';
	echo '<pre>' . esc_html( $schema ) . '</pre>';
	echo '</div>';

	return (string) ob_get_clean();
}

/**
 * Liste à puces stylisée (remplace gbe_outline dans les chapitres).
 *
 * @param string[] $items Éléments.
 * @return string
 */
function gbe_chapter_list( $items ) {
	if ( empty( $items ) ) {
		return '';
	}

	ob_start();
	echo '<ul class="gbe-chapter-list">';
	foreach ( $items as $item ) {
		echo '<li>' . esc_html( $item ) . '</li>';
	}
	echo '</ul>';

	return (string) ob_get_clean();
}

/**
 * Cartes d’institutions scientifiques de référence (pas des partenaires officiels).
 *
 * @param array<int, array{
 *     priority: int,
 *     code: string,
 *     country: string,
 *     title: string,
 *     focus: string,
 *     researchers?: string[],
 *     langues?: string[],
 *     note?: string
 * }> $institutions Institutions.
 * @return string
 */
function gbe_chapter_institution_refs( $institutions ) {
	if ( empty( $institutions ) ) {
		return '';
	}

	$groups = array(
		1 => array(),
		2 => array(),
	);
	foreach ( $institutions as $institution ) {
		$priority = isset( $institution['priority'] ) ? (int) $institution['priority'] : 2;
		if ( ! isset( $groups[ $priority ] ) ) {
			$priority = 2;
		}
		$groups[ $priority ][] = $institution;
	}

	$group_labels = array(
		1 => __( 'Priorité 1 — interlocuteurs scientifiques directs', 'gbecosmolingua-core' ),
		2 => __( 'Priorité 2 — documentation et extension du continuum', 'gbecosmolingua-core' ),
	);

	ob_start();
	?>
	<div class="gbe-chapter-institutions">
		<?php foreach ( array( 1, 2 ) as $priority ) : ?>
			<?php if ( empty( $groups[ $priority ] ) ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<div class="gbe-chapter-institutions__group">
				<h3 class="gbe-chapter-institutions__group-title">
					<span class="gbe-chapter-institutions__priority gbe-chapter-institutions__priority--<?php echo (int) $priority; ?>">
						<?php echo esc_html( sprintf( 'P%d', $priority ) ); ?>
					</span>
					<?php echo esc_html( $group_labels[ $priority ] ); ?>
				</h3>
				<div class="gbe-chapter-institutions__grid">
					<?php foreach ( $groups[ $priority ] as $institution ) : ?>
						<article class="gbe-chapter-institution">
							<header class="gbe-chapter-institution__head">
								<span class="gbe-chapter-card__badge" aria-hidden="true"><?php echo esc_html( $institution['code'] ); ?></span>
								<div>
									<p class="gbe-chapter-institution__country"><?php echo esc_html( $institution['country'] ); ?></p>
									<h4 class="gbe-chapter-institution__title"><?php echo esc_html( $institution['title'] ); ?></h4>
								</div>
							</header>
							<p class="gbe-chapter-institution__focus"><?php echo esc_html( $institution['focus'] ); ?></p>
							<?php if ( ! empty( $institution['researchers'] ) ) : ?>
								<p class="gbe-chapter-institution__researchers">
									<strong><?php esc_html_e( 'Chercheurs repères :', 'gbecosmolingua-core' ); ?></strong>
									<?php echo esc_html( implode( ', ', $institution['researchers'] ) ); ?>
								</p>
							<?php endif; ?>
							<?php if ( ! empty( $institution['langues'] ) ) : ?>
								<ul class="gbe-chapter-institution__langues" aria-label="<?php esc_attr_e( 'Langues Gbe concernées', 'gbecosmolingua-core' ); ?>">
									<?php foreach ( $institution['langues'] as $langue ) : ?>
										<li><?php echo esc_html( $langue ); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<?php if ( ! empty( $institution['note'] ) ) : ?>
								<p class="gbe-chapter-institution__note"><?php echo esc_html( $institution['note'] ); ?></p>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Pied de chapitre avec liens connexes.
 *
 * @param array<int, array{url: string, label: string}> $links Liens.
 * @return string
 */
function gbe_chapter_footer_links( $links ) {
	if ( empty( $links ) ) {
		return '';
	}
	ob_start();
	?>
	<footer class="gbe-chapter-footer">
		<p class="gbe-chapter-footer__label"><?php esc_html_e( 'Poursuivre la lecture', 'gbecosmolingua-core' ); ?></p>
		<div class="gbe-chapter-footer__links">
			<?php foreach ( $links as $link ) : ?>
				<a class="gbe-chapter-footer__link" href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</footer>
	<?php
	return (string) ob_get_clean();
}

/**
 * Contenu chapitre généré à l'exécution (contourne wpautop en base de données).
 *
 * @param WP_Post|null $page Page WordPress.
 * @return string
 */
function gbe_le_gbe_chapter_runtime_content( $page ) {
	if ( ! $page instanceof WP_Post ) {
		return '';
	}

	$uri = get_page_uri( $page );
	if ( ! is_string( $uri ) || '' === $uri ) {
		return '';
	}

	$callbacks = gbe_le_gbe_langue_chapter_callbacks();
	if ( isset( $callbacks[ $uri ] ) && is_callable( $callbacks[ $uri ] ) ) {
		return (string) call_user_func( $callbacks[ $uri ] );
	}

	$callbacks = gbe_le_gbe_linguistique_chapter_callbacks();
	if ( isset( $callbacks[ $uri ] ) && is_callable( $callbacks[ $uri ] ) ) {
		return (string) call_user_func( $callbacks[ $uri ] );
	}

	$callbacks = array(
		'le-gbe/le-continuum-gbe'                            => 'gbe_le_gbe_continuum_content',
		'le-gbe/les-langues'                                 => 'gbe_le_gbe_langues_content',
		'le-gbe/peuples-du-continuum'                        => 'gbe_le_gbe_peuples_content',
		'le-gbe/le-continuum-gbe/inventaire-des-parlers'     => 'gbe_le_gbe_inventaire_parlers_content',
		'le-gbe/le-continuum-gbe/langue-unique'              => 'gbe_le_gbe_langue_unique_content',
		'le-gbe/le-continuum-gbe/pays-et-territoires'        => 'gbe_le_gbe_pays_territoires_content',
		'le-gbe/le-continuum-gbe/regroupement-des-parlers'   => 'gbe_le_gbe_regroupement_parlers_content',
		'le-gbe/le-continuum-gbe/varietes-principales'      => 'gbe_le_gbe_varietes_principales_content',
	);

	if ( ! isset( $callbacks[ $uri ] ) || ! is_callable( $callbacks[ $uri ] ) ) {
		return '';
	}

	return (string) call_user_func( $callbacks[ $uri ] );
}
