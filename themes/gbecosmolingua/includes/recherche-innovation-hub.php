<?php
/**
 * Helpers hub Recherche et Innovation.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL sous-page Recherche et Innovation.
 *
 * @param string $slug       Slug enfant.
 * @param string $child_slug   Slug petit-enfant.
 */
function gbecosmolingua_recherche_page_url( $slug = '', $child_slug = '' ) {
	$path = 'recherche-et-innovation';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * Image hub (dossier assets/images/recherche-innovation/).
 *
 * @param string $filename Nom de fichier.
 */
function gbecosmolingua_recherche_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$path     = get_stylesheet_directory() . '/assets/images/recherche-innovation/' . $filename;
	if ( file_exists( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/recherche-innovation/' . $filename;
	}
	return gbecosmolingua_culture_image( $filename );
}

/**
 * Variable CSS image.
 *
 * @param string $filename Fichier.
 * @param string $var_name Variable CSS.
 */
function gbecosmolingua_recherche_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_recherche_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * Rubriques sans grille sous-thèmes.
 *
 * @return string[]
 */
function gbecosmolingua_recherche_feature_slugs() {
	return array(
		'ressources-documentaires',
		'activites',
		'humanites-numeriques',
		'observatoire-documentaire',
	);
}

/**
 * Ordre d'affichage hub.
 *
 * @return string[]
 */
function gbecosmolingua_recherche_hub_order() {
	return array(
		'ressources-documentaires',
		'activites',
		'domaines-de-recherche',
		'humanites-numeriques',
		'observatoire-documentaire',
	);
}

/**
 * Vignettes par slug.
 *
 * @return array<string, string>
 */
function gbecosmolingua_recherche_thumb_map() {
	return array(
		'ressources-documentaires'  => 'arts-sculpture.jpg',
		'activites'                 => 'fetes.jpg',
		'domaines-de-recherche'     => 'musique.jpg',
		'humanites-numeriques'      => 'architecture.jpg',
		'observatoire-documentaire' => 'croyances-shrine.jpg',
	);
}

/**
 * Sous-thèmes depuis enfants WP.
 *
 * @param int    $parent_page_id ID parent.
 * @param string $parent_slug    Slug parent.
 */
function gbecosmolingua_recherche_topics_from_children( $parent_page_id, $parent_slug ) {
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
 * Repli statique des sections hub.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_recherche_hub_sections_fallback() {
	$item = function ( $label, $parent, $child = '' ) {
		return array(
			'label'      => $label,
			'slug'       => $parent,
			'child_slug' => $child ? $child : sanitize_title( $label ),
		);
	};

	return array(
		array(
			'id'     => 'gbe-recherche-ressources',
			'title'  => __( 'Ressources documentaires', 'gbecosmolingua' ),
			'slug'   => 'ressources-documentaires',
			'thumb'  => 'arts-sculpture.jpg',
			'mod'    => 'ressources',
			'layout' => 'feature',
			'intro'  => __( 'Bibliothèque numérique, corpus linguistiques et archives scientifiques du continuum gbe.', 'gbecosmolingua' ),
			'items'  => array(),
		),
		array(
			'id'     => 'gbe-recherche-activites',
			'title'  => __( 'Activités', 'gbecosmolingua' ),
			'slug'   => 'activites',
			'thumb'  => 'fetes.jpg',
			'mod'    => 'activites',
			'layout' => 'feature',
			'intro'  => __( 'Colloques, conférences, séminaires et publications de GbeCosmoLingua.', 'gbecosmolingua' ),
			'items'  => array(),
		),
		array(
			'id'     => 'gbe-recherche-domaines',
			'title'  => __( 'Domaines de recherche', 'gbecosmolingua' ),
			'slug'   => 'domaines-de-recherche',
			'thumb'  => 'musique.jpg',
			'mod'    => 'domaines',
			'layout' => 'split',
			'intro'  => __( 'Linguistique, anthropologie, ethnolinguistique, paremiologie et humanités numériques au service des études gbe.', 'gbecosmolingua' ),
			'items'  => array(
				$item( 'Linguistique', 'domaines-de-recherche', 'linguistique' ),
				$item( 'Anthropologie', 'domaines-de-recherche', 'anthropologie' ),
				$item( 'Ethnolinguistique', 'domaines-de-recherche', 'ethnolinguistique' ),
				$item( 'Paremiologie', 'domaines-de-recherche', 'paremiologie' ),
				$item( 'Onomastique', 'domaines-de-recherche', 'onomastique' ),
				$item( 'Traduction', 'domaines-de-recherche', 'traduction' ),
				$item( 'Interculturalité', 'domaines-de-recherche', 'interculturalite' ),
				$item( 'Humanités numériques', 'domaines-de-recherche', 'humanites-numeriques' ),
			),
		),
		array(
			'id'     => 'gbe-recherche-humnum',
			'title'  => __( 'Humanités numériques', 'gbecosmolingua' ),
			'slug'   => 'humanites-numeriques',
			'thumb'  => 'architecture.jpg',
			'mod'    => 'humnum',
			'layout' => 'feature',
			'intro'  => __( 'Corpus numériques, outils de recherche et méthodes appliquées aux patrimoines gbe.', 'gbecosmolingua' ),
			'items'  => array(),
		),
		array(
			'id'     => 'gbe-recherche-observatoire',
			'title'  => __( 'Observatoire documentaire', 'gbecosmolingua' ),
			'slug'   => 'observatoire-documentaire',
			'thumb'  => 'croyances-shrine.jpg',
			'mod'    => 'observatoire',
			'layout' => 'feature',
			'intro'  => __( 'Veille scientifique, base documentaire et ressources pour la recherche sur les langues et cultures gbe.', 'gbecosmolingua' ),
			'items'  => array(),
		),
	);
}

/**
 * Sections hub (WP + repli).
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_recherche_hub_sections() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$parent = get_page_by_path( 'recherche-et-innovation' );
	if ( ! $parent ) {
		$cache = gbecosmolingua_recherche_hub_sections_fallback();
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
		$cache = gbecosmolingua_recherche_hub_sections_fallback();
		return $cache;
	}

	$fallback   = gbecosmolingua_recherche_hub_sections_fallback();
	$fb_by_slug = array();
	foreach ( $fallback as $row ) {
		$fb_by_slug[ $row['slug'] ] = $row;
	}

	$thumbs  = gbecosmolingua_recherche_thumb_map();
	$feature = gbecosmolingua_recherche_feature_slugs();
	$by_slug = array();

	foreach ( $children as $child ) {
		$slug   = $child->post_name;
		$topics = gbecosmolingua_recherche_topics_from_children( (int) $child->ID, $slug );
		if ( empty( $topics ) ) {
			$topics = gbecosmolingua_culture_extract_topics( $child->post_content, $slug );
			foreach ( $topics as $i => $topic ) {
				$topics[ $i ]['child_slug'] = sanitize_title( $topic['label'] );
			}
		}

		$intro = gbecosmolingua_culture_extract_intro( $child->post_content );
		if ( '' === $intro && isset( $fb_by_slug[ $slug ] ) ) {
			$intro = $fb_by_slug[ $slug ]['intro'];
		}
		if ( '' === $intro ) {
			$intro = wp_trim_words( wp_strip_all_tags( $child->post_content ), 32, '…' );
		}
		if ( empty( $topics ) && isset( $fb_by_slug[ $slug ]['items'] ) ) {
			$topics = $fb_by_slug[ $slug ]['items'];
		}

		$layout = in_array( $slug, $feature, true ) ? 'feature' : 'split';

		$by_slug[ $slug ] = array(
			'id'     => 'gbe-recherche-' . sanitize_title( $slug ),
			'title'  => $child->post_title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'mod'    => $slug,
			'layout' => $layout,
			'intro'  => $intro,
			'items'  => $topics,
		);
	}

	$ordered = array();
	foreach ( gbecosmolingua_recherche_hub_order() as $slug ) {
		if ( isset( $by_slug[ $slug ] ) ) {
			$ordered[] = $by_slug[ $slug ];
			unset( $by_slug[ $slug ] );
		}
	}
	foreach ( $by_slug as $row ) {
		$ordered[] = $row;
	}

	$cache = ! empty( $ordered ) ? $ordered : gbecosmolingua_recherche_hub_sections_fallback();
	return $cache;
}

/**
 * Accroche sous-thème.
 *
 * @param string $label Libellé.
 */
function gbecosmolingua_recherche_subtopic_blurb( $label ) {
	return sprintf(
		/* translators: %s: research topic */
		__( 'Approfondir « %s » dans le programme de recherche gbe.', 'gbecosmolingua' ),
		$label
	);
}

/**
 * Événement ou actualité mise en avant.
 *
 * @return array{title: string, meta: string, excerpt: string, url: string}
 */
function gbecosmolingua_recherche_featured_highlight() {
	$query = new WP_Query(
		array(
			'post_type'      => 'evenement',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( $query->have_posts() ) {
		$query->the_post();
		$id   = get_the_ID();
		$data = array(
			'title'   => get_the_title(),
			'meta'    => __( 'Événement', 'gbecosmolingua' ),
			'excerpt' => has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 28, '…' ),
			'url'     => get_permalink( $id ),
		);
		wp_reset_postdata();
		return $data;
	}

	return array(
		'title'   => __( 'Colloques et séminaires gbe', 'gbecosmolingua' ),
		'meta'    => __( 'Agenda scientifique', 'gbecosmolingua' ),
		'excerpt' => __( 'Retrouvez conférences, colloques et publications du réseau GbeCosmoLingua.', 'gbecosmolingua' ),
		'url'     => gbecosmolingua_recherche_page_url( 'activites' ),
	);
}

/**
 * Barre de recherche documentaire.
 */
function gbecosmolingua_recherche_render_search() {
	$action = gbecosmolingua_recherche_page_url( 'ressources-documentaires' );
	?>
	<div class="gbe-recherche-search-wrap">
		<form class="gbe-recherche-search" method="get" action="<?php echo esc_url( $action ); ?>" role="search">
			<label class="screen-reader-text" for="gbe-recherche-search-input"><?php esc_html_e( 'Rechercher une ressource', 'gbecosmolingua' ); ?></label>
			<input id="gbe-recherche-search-input" class="gbe-recherche-search__input" type="search" name="gbe_q" value="" placeholder="<?php esc_attr_e( 'Rechercher un corpus, un article, une archive…', 'gbecosmolingua' ); ?>">
			<input type="hidden" name="gbe_tab" value="ressources">
			<button type="submit" class="gbe-recherche-search__submit"><?php esc_html_e( 'Rechercher', 'gbecosmolingua' ); ?></button>
			<a class="gbe-recherche-search__link" href="<?php echo esc_url( gbecosmolingua_recherche_page_url( 'observatoire-documentaire' ) ); ?>"><?php esc_html_e( 'Observatoire documentaire', 'gbecosmolingua' ); ?></a>
		</form>
	</div>
	<?php
}

/**
 * Grille sous-thèmes.
 *
 * @param array<string, mixed> $section Section.
 */
function gbecosmolingua_recherche_render_subtopics( $section ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	$thumbs = gbecosmolingua_recherche_thumb_map();
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
				$style  = gbecosmolingua_recherche_image_style( $file, '--gbe-culture-section-image' );
				if ( ! empty( $item['child_slug'] ) ) {
					$url = gbecosmolingua_recherche_page_url( $parent, $item['child_slug'] );
				} else {
					$url = gbecosmolingua_recherche_page_url( $parent );
				}
				$anchor = sanitize_title( $item['label'] );
				?>
				<article class="gbe-culture-subtopic" id="<?php echo esc_attr( $section['id'] . '-' . $anchor ); ?>">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( gbecosmolingua_recherche_subtopic_blurb( $item['label'] ) ); ?></p>
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
