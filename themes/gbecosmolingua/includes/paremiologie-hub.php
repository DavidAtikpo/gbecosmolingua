<?php
/**
 * Helpers hub Paremiologie.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL sous-page Paremiologie.
 *
 * @param string $slug       Slug page enfant.
 * @param string $child_slug Slug petit-enfant optionnel.
 */
function gbecosmolingua_paremiologie_page_url( $slug = '', $child_slug = '' ) {
	$path = 'paremiologie';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * Image hub Paremiologie.
 *
 * @param string $filename Fichier dans assets/images/paremiologie/.
 */
function gbecosmolingua_paremiologie_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$path     = get_stylesheet_directory() . '/assets/images/paremiologie/' . $filename;
	if ( file_exists( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/paremiologie/' . $filename;
	}
	return gbecosmolingua_culture_image( $filename );
}

/**
 * Variable CSS pour image Paremiologie.
 *
 * @param string $filename Fichier.
 * @param string $var_name Variable CSS.
 */
function gbecosmolingua_paremiologie_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_paremiologie_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * Slugs des pages corpus (enfants directs).
 *
 * @return string[]
 */
function gbecosmolingua_paremiologie_corpus_slugs() {
	return array(
		'corpus-ewe',
		'corpus-gen-mina',
		'corpus-fon',
		'corpus-aja',
		'corpus-gun',
	);
}

/**
 * Rubrique banque (carte unique sans sous-grille).
 *
 * @return string[]
 */
function gbecosmolingua_paremiologie_feature_slugs() {
	return array( 'banque-numerique-proverbes' );
}

/**
 * Ordre des rubriques sur le hub.
 *
 * @return string[]
 */
function gbecosmolingua_paremiologie_hub_order() {
	return array(
		'banque-numerique-proverbes',
		'gbe-paremiologie-corpus-group',
		'comparaisons-interculturelles',
		'axes-de-recherche',
	);
}

/**
 * Item sous-thème hub.
 *
 * @param string $label       Libellé.
 * @param string $parent_slug Slug page parente sous paremiologie/.
 * @param string $child_slug  Slug enfant optionnel.
 */
function gbecosmolingua_paremiologie_hub_item( $label, $parent_slug, $child_slug = '' ) {
	if ( ! $child_slug ) {
		$child_slug = sanitize_title( $label );
	}
	return array(
		'label'      => $label,
		'slug'       => $parent_slug,
		'child_slug' => $child_slug,
	);
}

/**
 * Sous-thèmes depuis pages enfants WordPress.
 *
 * @param int    $parent_page_id ID parent.
 * @param string $parent_slug    Slug parent.
 */
function gbecosmolingua_paremiologie_topics_from_children( $parent_page_id, $parent_slug ) {
	$topics   = array();
	$children = get_pages(
		array(
			'parent'      => $parent_page_id,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);
	foreach ( $children as $child ) {
		$topics[] = array(
			'label'      => $child->post_title,
			'slug'       => $parent_slug,
			'child_slug' => $child->post_name,
		);
	}
	return $topics;
}

/**
 * Vignettes par rubrique.
 *
 * @return array<string, string>
 */
function gbecosmolingua_paremiologie_thumb_map() {
	return array(
		'banque-numerique-proverbes'    => 'arts-sculpture.jpg',
		'gbe-paremiologie-corpus-group' => 'arts-artisanat.jpg',
		'corpus-ewe'                    => 'musique.jpg',
		'corpus-gen-mina'               => 'danse.jpg',
		'corpus-fon'                    => 'fetes.jpg',
		'corpus-aja'                    => 'gastronomie.jpg',
		'corpus-gun'                    => 'architecture.jpg',
		'comparaisons-interculturelles' => 'croyances-shrine.jpg',
		'axes-de-recherche'             => 'architecture.jpg',
	);
}

/**
 * Données de repli hub.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_paremiologie_hub_sections_fallback() {
	$item = function ( $label, $slug, $child = '' ) {
		if ( $child ) {
			return gbecosmolingua_paremiologie_hub_item( $label, $slug, $child );
		}
		return array(
			'label'      => $label,
			'slug'       => $slug,
			'child_slug' => '',
		);
	};

	$corpus_items = array(
		$item( 'Corpus éwé', 'corpus-ewe' ),
		$item( 'Corpus Gen/Mina', 'corpus-gen-mina' ),
		$item( 'Corpus fon', 'corpus-fon' ),
		$item( 'Corpus aja', 'corpus-aja' ),
		$item( 'Corpus gun', 'corpus-gun' ),
	);

	return array(
		array(
			'id'     => 'gbe-paremiologie-banque',
			'title'  => __( 'Banque numérique de proverbes', 'gbecosmolingua' ),
			'slug'   => 'banque-numerique-proverbes',
			'thumb'  => 'arts-sculpture.jpg',
			'mod'    => 'banque',
			'layout' => 'feature',
			'intro'  => __( 'Texte original, transcriptions, traductions, contexte d\'emploi et analyses linguistiques pour chaque entrée paremiologique.', 'gbecosmolingua' ),
			'items'  => array(),
		),
		array(
			'id'     => 'gbe-paremiologie-corpus-group',
			'title'  => __( 'Corpus par variété', 'gbecosmolingua' ),
			'slug'   => 'corpus-ewe',
			'thumb'  => 'arts-artisanat.jpg',
			'mod'    => 'corpus',
			'layout' => 'split',
			'intro'  => __( 'Corpus paremiologiques documentés par variété du continuum gbe : lododowo, proverbes, dictons et traditions sapientielles.', 'gbecosmolingua' ),
			'items'  => $corpus_items,
		),
		array(
			'id'     => 'gbe-paremiologie-comparaisons',
			'title'  => __( 'Comparaisons interculturelles', 'gbecosmolingua' ),
			'slug'   => 'comparaisons-interculturelles',
			'thumb'  => 'croyances-shrine.jpg',
			'mod'    => 'comparaisons',
			'layout' => 'split',
			'intro'  => __( 'Approches comparées entre paremiologies gbe et autres traditions linguistiques.', 'gbecosmolingua' ),
			'items'  => array(
				$item( 'Gbe – Français', 'comparaisons-interculturelles', 'gbe-francais' ),
				$item( 'Gbe – Espagnol', 'comparaisons-interculturelles', 'gbe-espagnol' ),
				$item( 'Gbe – Russe', 'comparaisons-interculturelles', 'gbe-russe' ),
				$item( 'Gbe – Anglais', 'comparaisons-interculturelles', 'gbe-anglais' ),
			),
		),
		array(
			'id'     => 'gbe-paremiologie-axes',
			'title'  => __( 'Axes de recherche', 'gbecosmolingua' ),
			'slug'   => 'axes-de-recherche',
			'thumb'  => 'architecture.jpg',
			'mod'    => 'axes',
			'layout' => 'split',
			'intro'  => __( 'Paremiologie comparée, cosmovisions, traduction et imaginaires culturels au sein de GbeCosmoLingua.', 'gbecosmolingua' ),
			'items'  => array(
				$item( 'Paremiologie comparée', 'axes-de-recherche', 'paremiologie-comparee' ),
				$item( 'Cosmovisions', 'axes-de-recherche', 'cosmovisions' ),
				$item( 'Imaginaires culturels', 'axes-de-recherche', 'imaginaires-culturels' ),
				$item( 'Traduction des proverbes', 'axes-de-recherche', 'traduction-des-proverbes' ),
				$item( 'Paremacie interculturelle', 'axes-de-recherche', 'paremacie-interculturelle' ),
			),
		),
	);
}

/**
 * Sections du hub (pages WP + repli).
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_paremiologie_hub_sections() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$parent = get_page_by_path( 'paremiologie' );
	if ( ! $parent ) {
		$cache = gbecosmolingua_paremiologie_hub_sections_fallback();
		return $cache;
	}

	$children = get_pages(
		array(
			'parent'      => $parent->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	if ( empty( $children ) ) {
		$cache = gbecosmolingua_paremiologie_hub_sections_fallback();
		return $cache;
	}

	$fallback       = gbecosmolingua_paremiologie_hub_sections_fallback();
	$fallback_by_id = array();
	foreach ( $fallback as $row ) {
		$fallback_by_id[ $row['id'] ] = $row;
	}

	$thumbs       = gbecosmolingua_paremiologie_thumb_map();
	$corpus_slugs = gbecosmolingua_paremiologie_corpus_slugs();
	$feature      = gbecosmolingua_paremiologie_feature_slugs();
	$sections     = array();
	$corpus_items = array();

	foreach ( $children as $child ) {
		$slug = $child->post_name;
		if ( in_array( $slug, $corpus_slugs, true ) ) {
			$corpus_items[] = array(
				'label'      => $child->post_title,
				'slug'       => $slug,
				'child_slug' => '',
			);
			continue;
		}

		$topics = gbecosmolingua_paremiologie_topics_from_children( (int) $child->ID, $slug );
		if ( empty( $topics ) ) {
			$topics = gbecosmolingua_culture_extract_topics( $child->post_content, $slug );
			foreach ( $topics as $i => $topic ) {
				$topics[ $i ]['child_slug'] = sanitize_title( $topic['label'] );
			}
		}

		$intro = gbecosmolingua_culture_extract_intro( $child->post_content );
		if ( '' === $intro ) {
			$intro = wp_trim_words( wp_strip_all_tags( $child->post_content ), 32, '…' );
		}

		$layout            = in_array( $slug, $feature, true ) ? 'feature' : 'split';
		$sections[ $slug ] = array(
			'id'     => 'gbe-paremiologie-' . sanitize_title( $slug ),
			'title'  => $child->post_title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'mod'    => $slug,
			'layout' => $layout,
			'intro'  => $intro,
			'items'  => $topics,
		);
	}

	if ( ! empty( $corpus_items ) ) {
		$fb = $fallback_by_id['gbe-paremiologie-corpus-group'] ?? null;
		$sections['gbe-paremiologie-corpus-group'] = array(
			'id'     => 'gbe-paremiologie-corpus-group',
			'title'  => $fb ? $fb['title'] : __( 'Corpus par variété', 'gbecosmolingua' ),
			'slug'   => $corpus_items[0]['slug'],
			'thumb'  => 'arts-artisanat.jpg',
			'mod'    => 'corpus',
			'layout' => 'split',
			'intro'  => $fb ? $fb['intro'] : '',
			'items'  => $corpus_items,
		);
	}

	$ordered = array();
	foreach ( gbecosmolingua_paremiologie_hub_order() as $key ) {
		if ( isset( $sections[ $key ] ) ) {
			$ordered[] = $sections[ $key ];
			unset( $sections[ $key ] );
		}
	}
	foreach ( $sections as $row ) {
		$ordered[] = $row;
	}

	$cache = ! empty( $ordered ) ? $ordered : gbecosmolingua_paremiologie_hub_sections_fallback();
	return $cache;
}

/**
 * Accroche carte sous-thème.
 *
 * @param string $label Libellé.
 */
function gbecosmolingua_paremiologie_subtopic_blurb( $label ) {
	return sprintf(
		/* translators: %s: sub-topic name */
		__( 'Explorer « %s » dans la paremiologie gbe.', 'gbecosmolingua' ),
		$label
	);
}

/**
 * Proverbe mis en avant.
 *
 * @return array{title: string, meta: string, excerpt: string, url: string}
 */
function gbecosmolingua_paremiologie_featured_proverbe() {
	$query = new WP_Query(
		array(
			'post_type'      => 'proverbe',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( $query->have_posts() ) {
		$query->the_post();
		$id      = get_the_ID();
		$langues = get_the_terms( $id, 'langue_gbe' );
		$meta    = __( 'Proverbe gbe', 'gbecosmolingua' );
		if ( $langues && ! is_wp_error( $langues ) ) {
			$meta = $langues[0]->name;
		}
		$data = array(
			'title'   => get_the_title(),
			'meta'    => $meta,
			'excerpt' => has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 24, '…' ),
			'url'     => get_permalink( $id ),
		);
		wp_reset_postdata();
		return $data;
	}

	return array(
		'title'   => __( 'La sagesse du terroir', 'gbecosmolingua' ),
		'meta'    => 'Fon · ' . __( 'Lododowo', 'gbecosmolingua' ),
		'excerpt' => __( 'Découvrez la banque numérique : transcriptions, traductions et commentaires culturels des proverbes du continuum gbe.', 'gbecosmolingua' ),
		'url'     => gbecosmolingua_paremiologie_page_url( 'banque-numerique-proverbes' ),
	);
}

/**
 * Barre de recherche (banque de proverbes).
 */
function gbecosmolingua_paremiologie_render_search() {
	$action = gbecosmolingua_paremiologie_page_url( 'banque-numerique-proverbes' );
	$q      = isset( $_GET['gbe_q'] ) ? sanitize_text_field( wp_unslash( $_GET['gbe_q'] ) ) : '';
	?>
	<div class="gbe-paremiologie-search-wrap">
		<form class="gbe-paremiologie-search" method="get" action="<?php echo esc_url( $action ); ?>" role="search">
			<label class="screen-reader-text" for="gbe-paremiologie-search-input"><?php esc_html_e( 'Rechercher un proverbe', 'gbecosmolingua' ); ?></label>
			<input id="gbe-paremiologie-search-input" class="gbe-paremiologie-search__input" type="search" name="gbe_q" value="<?php echo esc_attr( $q ); ?>" placeholder="<?php esc_attr_e( 'Rechercher un proverbe, une langue, un thème…', 'gbecosmolingua' ); ?>">
			<button type="submit" class="gbe-paremiologie-search__submit"><?php esc_html_e( 'Rechercher', 'gbecosmolingua' ); ?></button>
		</form>
	</div>
	<?php
}

/**
 * Grille sous-thèmes.
 *
 * @param array<string, mixed> $section Section hub.
 */
function gbecosmolingua_paremiologie_render_subtopics( $section ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	$thumbs = gbecosmolingua_paremiologie_thumb_map();
	?>
	<div class="gbe-culture-subtopics" aria-labelledby="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
		<h3 class="gbe-culture-subtopics__heading" id="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
			<?php echo esc_html( $section['title'] ); ?>
		</h3>
		<div class="gbe-culture-subtopics__grid">
			<?php foreach ( $section['items'] as $item ) : ?>
				<?php
				$parent = $item['slug'];
				$file   = isset( $thumbs[ $parent ] ) ? $thumbs[ $parent ] : 'arts-sculpture.jpg';
				$style  = gbecosmolingua_paremiologie_image_style( $file, '--gbe-culture-section-image' );
				if ( empty( $item['child_slug'] ) ) {
					$url = gbecosmolingua_paremiologie_page_url( $parent );
				} else {
					$url = gbecosmolingua_paremiologie_page_url( $parent, $item['child_slug'] );
				}
				$anchor = sanitize_title( $item['label'] );
				?>
				<article class="gbe-culture-subtopic" id="<?php echo esc_attr( $section['id'] . '-' . $anchor ); ?>">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( gbecosmolingua_paremiologie_subtopic_blurb( $item['label'] ) ); ?></p>
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
