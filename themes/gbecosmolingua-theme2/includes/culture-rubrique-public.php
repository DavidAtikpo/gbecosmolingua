<?php
/**
 * Affichage public des rubriques Cultures Gbe (pages enfants).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page courante (requête ou globale).
 *
 * @param WP_Post|null $page Page explicite.
 * @return WP_Post|null
 */
function gbecosmolingua_culture_resolve_page( $page = null ) {
	if ( $page instanceof WP_Post ) {
		return $page;
	}
	if ( is_singular( 'page' ) ) {
		$queried = get_queried_object();
		if ( $queried instanceof WP_Post ) {
			return $queried;
		}
	}
	global $post;
	return ( $post instanceof WP_Post ) ? $post : null;
}

/**
 * Page courante sous Cultures Gbe ?
 *
 * @param WP_Post|null $post Page.
 * @return bool
 */
function gbecosmolingua_culture_is_rubrique_page( $post = null ) {
	$post = gbecosmolingua_culture_resolve_page( $post );
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}
	$ancestors = get_post_ancestors( $post );
	if ( empty( $ancestors ) ) {
		return false;
	}
	$root_id = end( $ancestors );
	$root    = get_post( (int) $root_id );
	return $root instanceof WP_Post && 'cultures-gbe' === $root->post_name;
}

/**
 * Fichier image theme pour une page Cultures Gbe.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_culture_page_image_file( $page = null ) {
	$page = gbecosmolingua_culture_resolve_page( $page );
	if ( ! $page instanceof WP_Post ) {
		return 'hero-culture.jpg';
	}

	$map = gbecosmolingua_culture_hub_thumb_map();
	if ( isset( $map[ $page->post_name ] ) && gbecosmolingua_culture_image( $map[ $page->post_name ] ) ) {
		return $map[ $page->post_name ];
	}

	$by_label = gbecosmolingua_culture_subtopic_thumb( $page->post_title, $page->post_name );
	if ( gbecosmolingua_culture_image( $by_label ) ) {
		return $by_label;
	}

	$parent = get_post( (int) $page->post_parent );
	if ( $parent instanceof WP_Post && 'cultures-gbe' !== $parent->post_name ) {
		return gbecosmolingua_culture_page_image_file( $parent );
	}

	if ( $parent instanceof WP_Post && isset( $map[ $parent->post_name ] ) && gbecosmolingua_culture_image( $map[ $parent->post_name ] ) ) {
		return $map[ $parent->post_name ];
	}

	return 'hero-culture.jpg';
}

/**
 * Style bannière rubrique.
 *
 * @param WP_Post|null $page Page.
 */
function gbecosmolingua_culture_rubrique_hero_style( $page = null ) {
	$page = gbecosmolingua_culture_resolve_page( $page );
	if ( $page instanceof WP_Post && has_post_thumbnail( $page->ID ) ) {
		$style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-culture-rubrique-hero-image' );
		if ( $style ) {
			return $style;
		}
	}
	return gbecosmolingua_culture_image_style(
		gbecosmolingua_culture_page_image_file( $page ),
		'--gbe-culture-rubrique-hero-image'
	);
}

/**
 * Style média section hub Cultures Gbe.
 *
 * @param array<string, mixed> $section Section.
 */
function gbecosmolingua_culture_section_media_style( $section ) {
	if ( ! empty( $section['page_id'] ) ) {
		$style = gbecosmolingua_public_featured_image_style( (int) $section['page_id'], '--gbe-culture-section-image' );
		if ( $style ) {
			return $style;
		}
	}

	$thumb = $section['thumb'] ?? '';
	if ( ! $thumb && ! empty( $section['slug'] ) ) {
		$map   = gbecosmolingua_culture_hub_thumb_map();
		$thumb = $map[ $section['slug'] ] ?? '';
	}

	if ( $thumb ) {
		return gbecosmolingua_culture_image_style( $thumb, '--gbe-culture-section-image' );
	}

	return '';
}

/**
 * Sous-thèmes d'une rubrique (enfants WordPress).
 *
 * @param WP_Post $page Page rubrique.
 * @return array<int, array{label: string, slug: string, child_slug: string, url: string}>
 */
function gbecosmolingua_culture_rubrique_subtopics( $page ) {
	$topics   = array();
	$children = get_pages(
		array(
			'parent'      => (int) $page->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	foreach ( $children as $child ) {
		$topics[] = array(
			'label'      => $child->post_title,
			'slug'       => $page->post_name,
			'child_slug' => $child->post_name,
			'url'        => get_permalink( $child ),
		);
	}

	if ( ! empty( $topics ) ) {
		return $topics;
	}

	return gbecosmolingua_culture_extract_topics( $page->post_content, $page->post_name );
}

/**
 * HTML bannière d'une page rubrique Cultures Gbe.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_culture_rubrique_hero_html( $page = null ) {
	$page = gbecosmolingua_culture_resolve_page( $page );
	if ( ! $page instanceof WP_Post || ! gbecosmolingua_culture_is_rubrique_page( $page ) ) {
		return '';
	}

	$hero_style = gbecosmolingua_culture_rubrique_hero_style( $page );
	$lead       = gbecosmolingua_public_page_excerpt_text( $page );
	$parent     = get_post( (int) $page->post_parent );
	$kicker_url = $parent ? get_permalink( $parent ) : home_url( '/cultures-gbe/' );
	$kicker     = $parent ? $parent->post_title : __( 'Cultures Gbe', 'gbecosmolingua' );

	ob_start();
	?>
	<div class="wp-block-group alignfull gbe-culture-rubrique-hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
		<div class="wp-block-group">
			<p class="has-text-align-center gbe-culture-rubrique-hero__kicker"><a href="<?php echo esc_url( $kicker_url ); ?>"><?php echo esc_html( $kicker ); ?></a></p>
			<h1 class="wp-block-heading has-text-align-center gbe-culture-rubrique-hero__title"><?php echo esc_html( $page->post_title ); ?></h1>
			<?php if ( $lead ) : ?>
				<p class="has-text-align-center gbe-culture-rubrique-hero__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * HTML contenu d'une page rubrique Cultures Gbe.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_culture_rubrique_body_html( $page = null ) {
	$page = gbecosmolingua_culture_resolve_page( $page );
	if ( ! $page instanceof WP_Post || ! gbecosmolingua_culture_is_rubrique_page( $page ) ) {
		return '';
	}

	$html    = gbecosmolingua_public_page_intro_html( $page );
	$items   = gbecosmolingua_culture_rubrique_subtopics( $page );
	$section = array(
		'id'    => 'gbe-culture-rubrique-' . sanitize_title( $page->post_name ),
		'slug'  => $page->post_name,
		'items' => $items,
	);

	ob_start();
	if ( $html ) {
		?>
		<div class="wp-block-group alignwide gbe-section gbe-culture-rubrique-intro">
			<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}
	if ( ! empty( $items ) ) {
		?>
		<div class="gbe-culture-band gbe-culture-rubrique-band alignwide">
			<div class="gbe-culture-band__inner">
				<?php gbecosmolingua_culture_render_rubrique_subtopics( $page, $section ); ?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="gbe-culture-rubrique-back alignwide">
		<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( home_url( '/cultures-gbe/' ) ); ?>">
			<?php esc_html_e( '← Retour Cultures Gbe', 'gbecosmolingua' ); ?>
		</a>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Shortcode : bannière rubrique Cultures Gbe.
 *
 * @return string
 */
function gbecosmolingua_shortcode_culture_rubrique_hero() {
	return gbecosmolingua_culture_rubrique_hero_html();
}

/**
 * Shortcode : contenu rubrique Cultures Gbe.
 *
 * @return string
 */
function gbecosmolingua_shortcode_culture_rubrique_body() {
	return gbecosmolingua_culture_rubrique_body_html();
}

/**
 * Affiche la grille sous-thèmes pour une page rubrique.
 *
 * @param WP_Post              $page    Page.
 * @param array<string, mixed> $section Section-like data.
 */
function gbecosmolingua_culture_render_rubrique_subtopics( $page, $section ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	?>
	<div class="gbe-culture-subtopics" aria-labelledby="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
		<h2 class="gbe-culture-subtopics__heading" id="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
			<?php echo esc_html( $page->post_title ); ?>
		</h2>
		<div class="gbe-culture-subtopics__grid">
			<?php foreach ( $section['items'] as $item ) : ?>
				<?php
				$file  = gbecosmolingua_culture_subtopic_thumb( $item['label'], $section['slug'] );
				$style = gbecosmolingua_culture_image_style( $file, '--gbe-culture-section-image' );
				$url   = gbecosmolingua_culture_topic_url( $item );
				?>
				<article class="gbe-culture-subtopic">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h3><?php echo esc_html( $item['label'] ); ?></h3>
						<p><?php echo esc_html( gbecosmolingua_culture_subtopic_blurb( $item['label'] ) ); ?></p>
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
