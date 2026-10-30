<?php
/**
 * Helpers hub Linguistique (Gbe).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL page Linguistique.
 *
 * @param string $slug Slug sous-page optionnel.
 */
function gbecosmolingua_linguistique_page_url( $slug = '' ) {
	$path = 'le-gbe/linguistique';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * Image hub Linguistique.
 *
 * @param string $filename Nom de fichier.
 */
function gbecosmolingua_linguistique_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$dirs     = array( 'linguistique', 'le-gbe', 'culture-gbe' );

	foreach ( $dirs as $dir ) {
		$path = get_stylesheet_directory() . '/assets/images/' . $dir . '/' . $filename;
		if ( file_exists( $path ) ) {
			return get_stylesheet_directory_uri() . '/assets/images/' . $dir . '/' . $filename;
		}
	}

	return function_exists( 'gbecosmolingua_culture_image' ) ? gbecosmolingua_culture_image( $filename ) : '';
}

/**
 * Variable CSS image Linguistique.
 *
 * @param string $filename Fichier.
 * @param string $var_name Variable CSS.
 */
function gbecosmolingua_linguistique_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_linguistique_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * Item sous-thème.
 *
 * @param string $label Libellé.
 * @param string $slug  Slug page enfant.
 * @return array<string, string>
 */
function gbecosmolingua_linguistique_hub_item( $label, $slug ) {
	return array(
		'label' => $label,
		'slug'  => $slug,
		'url'   => gbecosmolingua_linguistique_page_url( $slug ),
	);
}

/**
 * Onglets de navigation rapide.
 *
 * @return array<int, array{label: string, id: string, url: string}>
 */
function gbecosmolingua_linguistique_nav_tabs() {
	return array(
		array(
			'label' => __( 'Écriture', 'gbecosmolingua' ),
			'id'    => 'gbe-linguistique-ecriture',
			'url'   => '#gbe-linguistique-ecriture',
		),
		array(
			'label' => __( 'Grammaire', 'gbecosmolingua' ),
			'id'    => 'gbe-linguistique-grammaire',
			'url'   => '#gbe-linguistique-grammaire',
		),
		array(
			'label' => __( 'Lexique', 'gbecosmolingua' ),
			'id'    => 'gbe-linguistique-lexique',
			'url'   => '#gbe-linguistique-lexique',
		),
		array(
			'label' => __( 'Ressources', 'gbecosmolingua' ),
			'id'    => 'gbe-linguistique-ressources',
			'url'   => '#gbe-linguistique-ressources',
		),
	);
}

/**
 * Sections hub (fallback).
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_linguistique_hub_sections_fallback() {
	$item = 'gbecosmolingua_linguistique_hub_item';

	return array(
		array(
			'id'    => 'gbe-linguistique-ecriture',
			'slug'  => 'ecriture',
			'title' => __( 'Écriture et phonologie', 'gbecosmolingua' ),
			'intro' => __( 'Orthographes, alphabets et inventaires phonologiques — travaux depuis Ansre (1966).', 'gbecosmolingua' ),
			'mod'   => 'ecriture',
			'image' => 'hero-village.jpg',
			'items' => array(
				$item( __( 'Alphabet', 'gbecosmolingua' ), 'alphabet' ),
				$item( __( 'Phonologie', 'gbecosmolingua' ), 'phonologie' ),
			),
		),
		array(
			'id'    => 'gbe-linguistique-grammaire',
			'slug'  => 'grammaire',
			'title' => __( 'Grammaire', 'gbecosmolingua' ),
			'intro' => __( 'Morphologie, dérivation et structures syntaxiques du continuum gbe.', 'gbecosmolingua' ),
			'mod'   => 'grammaire',
			'image' => 'architecture.jpg',
			'items' => array(
				$item( __( 'Morphologie', 'gbecosmolingua' ), 'morphologie' ),
				$item( __( 'Syntaxe', 'gbecosmolingua' ), 'syntaxe' ),
			),
		),
		array(
			'id'    => 'gbe-linguistique-lexique',
			'slug'  => 'lexique',
			'title' => __( 'Lexique et variation', 'gbecosmolingua' ),
			'intro' => __( 'Champs lexicaux, dialectologie (ch. 7) et Swadesh 82–96 % (ch. 9).', 'gbecosmolingua' ),
			'mod'   => 'lexique',
			'image' => 'musique.jpg',
			'items' => array(
				$item( __( 'Travaux scientifiques', 'gbecosmolingua' ), 'travaux-scientifiques-recents' ),
				$item( __( 'Potentialités lexicales', 'gbecosmolingua' ), 'potentialites-lexicales' ),
				$item( __( 'Dialectologie', 'gbecosmolingua' ), 'dialectologie' ),
				$item( __( 'Lexicologie', 'gbecosmolingua' ), 'lexicologie' ),
			),
		),
		array(
			'id'    => 'gbe-linguistique-ressources',
			'slug'  => 'ressources',
			'title' => __( 'Corpus et bibliothèque', 'gbecosmolingua' ),
			'intro' => __( 'Corpus numériques, banques de données et bibliothèque linguistique gbe.', 'gbecosmolingua' ),
			'mod'   => 'ressources',
			'image' => 'fetes.jpg',
			'items' => array(
				$item( __( 'Corpus numériques', 'gbecosmolingua' ), 'corpus-numeriques' ),
				$item( __( 'Bibliothèque', 'gbecosmolingua' ), 'bibliotheque' ),
			),
		),
	);
}

/**
 * Mappe une page enfant vers sa section thématique.
 *
 * @param string $slug Slug enfant.
 * @return string
 */
function gbecosmolingua_linguistique_section_key_for_slug( $slug ) {
	$map = array(
		'alphabet'                      => 'ecriture',
		'phonologie'                    => 'ecriture',
		'morphologie'                   => 'grammaire',
		'syntaxe'                       => 'grammaire',
		'lexicologie'                   => 'lexique',
		'dialectologie'                 => 'lexique',
		'travaux-scientifiques-recents'  => 'lexique',
		'potentialites-lexicales'       => 'lexique',
		'corpus-numeriques'             => 'ressources',
		'bibliotheque'                  => 'ressources',
	);
	return $map[ $slug ] ?? 'ecriture';
}

/**
 * Sections hub depuis WordPress ou fallback.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_linguistique_hub_sections() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$parent = get_page_by_path( 'le-gbe/linguistique', OBJECT, 'page' );
	if ( ! $parent ) {
		$cache = gbecosmolingua_linguistique_hub_sections_fallback();
		return $cache;
	}

	$fallback = gbecosmolingua_linguistique_hub_sections_fallback();
	$by_id    = array();
	foreach ( $fallback as $section ) {
		$section['items']     = array();
		$by_id[ $section['id'] ] = $section;
	}

	$children = get_pages(
		array(
			'parent'      => (int) $parent->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	if ( $children ) {
		foreach ( $children as $child ) {
			$key = gbecosmolingua_linguistique_section_key_for_slug( $child->post_name );
			foreach ( $fallback as $section ) {
				if ( $section['slug'] === $key ) {
					$section_id = $section['id'];
					if ( ! isset( $by_id[ $section_id ] ) ) {
						continue;
					}
					$by_id[ $section_id ]['items'][] = array(
						'label' => $child->post_title,
						'slug'  => $child->post_name,
						'url'   => get_permalink( $child ),
					);
					break;
				}
			}
		}
	}

	$sections = array();
	foreach ( $fallback as $section ) {
		$merged = $by_id[ $section['id'] ];
		if ( empty( $merged['items'] ) ) {
			$merged['items'] = $section['items'];
		}
		$sections[] = $merged;
	}

	$cache = $sections;
	return $cache;
}

/**
 * Statistiques hub.
 *
 * @return array<int, array{value: string, label: string, stat?: int, suffix?: string}>
 */
function gbecosmolingua_linguistique_stats() {
	$parent = get_page_by_path( 'le-gbe/linguistique', OBJECT, 'page' );
	$topics = 8;
	if ( $parent ) {
		$count  = get_pages(
			array(
				'parent'      => (int) $parent->ID,
				'post_status' => 'publish',
			)
		);
		$topics = max( 8, count( $count ) );
	}

	return array(
		array(
			'value' => '1966',
			'label' => __( 'Monographies modernes', 'gbecosmolingua' ),
		),
		array(
			'value' => '770+',
			'label' => __( 'Publications (Duthie)', 'gbecosmolingua' ),
		),
		array(
			'value' => '82–96%',
			'label' => __( 'Swadesh inter-sections', 'gbecosmolingua' ),
		),
		array(
			'value' => '50+',
			'label' => __( 'Parlers inventoriés', 'gbecosmolingua' ),
		),
	);
}

/**
 * Style média section.
 *
 * @param array<string, mixed> $section Section.
 */
function gbecosmolingua_linguistique_section_media_style( $section ) {
	if ( ! empty( $section['image'] ) ) {
		return gbecosmolingua_linguistique_image_style( $section['image'], '--gbe-culture-section-image' );
	}
	return '';
}

/**
 * Chapô sous-thème.
 *
 * @param string $label Libellé.
 */
function gbecosmolingua_linguistique_subtopic_blurb( $label ) {
	return sprintf(
		/* translators: %s: topic label */
		__( 'Explorer « %s » dans la linguistique gbe.', 'gbecosmolingua' ),
		$label
	);
}

/**
 * Grille sous-thèmes.
 *
 * @param array<string, mixed> $section Section hub.
 */
function gbecosmolingua_linguistique_render_subtopics( $section ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	?>
	<div class="gbe-culture-subtopics" aria-labelledby="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
		<h3 class="gbe-culture-subtopics__heading" id="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
			<?php echo esc_html( $section['title'] ); ?>
		</h3>
		<div class="gbe-culture-subtopics__grid">
			<?php foreach ( $section['items'] as $item ) : ?>
				<?php
				$url   = ! empty( $item['url'] ) ? $item['url'] : gbecosmolingua_linguistique_page_url( $item['slug'] ?? '' );
				$style = gbecosmolingua_linguistique_image_style( $section['image'] ?? 'hero-village.jpg', '--gbe-culture-section-image' );
				$anchor = sanitize_title( $item['label'] );
				?>
				<article class="gbe-culture-subtopic" id="<?php echo esc_attr( $section['id'] . '-' . $anchor ); ?>">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( gbecosmolingua_linguistique_subtopic_blurb( $item['label'] ) ); ?></p>
						<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $url ); ?>">
							<?php esc_html_e( 'Découvrir', 'gbecosmolingua' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Onglets de navigation Linguistique.
 */
function gbecosmolingua_linguistique_render_nav_tabs() {
	$tabs = gbecosmolingua_linguistique_nav_tabs();
	if ( empty( $tabs ) ) {
		return;
	}
	?>
	<nav class="gbe-linguistique-nav" aria-label="<?php esc_attr_e( 'Rubriques linguistiques', 'gbecosmolingua' ); ?>">
		<?php foreach ( $tabs as $tab ) : ?>
			<a class="gbe-linguistique-nav__tab" href="<?php echo esc_attr( $tab['url'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php
}
