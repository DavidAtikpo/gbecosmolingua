<?php
/**
 * Title: Le Gbe — Bannière continuum
 * Slug: gbecosmolingua/le-gbe-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$hero_image = get_stylesheet_directory() . '/assets/images/le-gbe/hero-village.jpg';
$hero_url   = file_exists( $hero_image )
	? get_stylesheet_directory_uri() . '/assets/images/le-gbe/hero-village.jpg'
	: '';

$figure_image = get_stylesheet_directory() . '/assets/images/le-gbe/sculpture.jpg';
$figure_url   = file_exists( $figure_image )
	? get_stylesheet_directory_uri() . '/assets/images/le-gbe/sculpture.jpg'
	: '';

$hero_style = $hero_url
	? '--gbe-le-gbe-hero-image:url(' . esc_url( $hero_url ) . ');'
	: '';
?>
<!-- wp:group {"align":"full","className":"gbe-le-gbe-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-le-gbe-hero" style="<?php echo esc_attr( $hero_style ); ?>">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"}} -->
	<div class="wp-block-group">
		<!-- wp:columns {"verticalAlignment":"center","className":"gbe-le-gbe-hero__layout"} -->
		<div class="wp-block-columns are-vertically-aligned-center gbe-le-gbe-hero__layout">
			<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%">
				<!-- wp:heading {"level":1,"className":"gbe-le-gbe-hero__title"} -->
				<h1 class="wp-block-heading gbe-le-gbe-hero__title">Le Continuum Gbe</h1>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"className":"gbe-le-gbe-hero__lead"} -->
				<p class="gbe-le-gbe-hero__lead">Un patrimoine linguistique et culturel commun au Togo, au Bénin, au Ghana et au Nigeria.</p>
				<!-- /wp:paragraph -->

				<!-- wp:buttons {"className":"gbe-le-gbe-hero__actions"} -->
				<div class="wp-block-buttons gbe-le-gbe-hero__actions">
					<!-- wp:button {"className":"is-style-fill"} -->
					<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="/le-gbe/les-langues/">Explorer les langues</a></div>
					<!-- /wp:button -->

					<!-- wp:button {"className":"is-style-outline"} -->
					<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/le-gbe/carte-interactive/">Voir la carte interactive</a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
				<!-- wp:group {"className":"gbe-le-gbe-hero__figure-wrap"} -->
				<div class="wp-block-group gbe-le-gbe-hero__figure-wrap">
					<?php if ( $figure_url ) : ?>
					<!-- wp:image {"sizeSlug":"large","className":"gbe-le-gbe-hero__figure"} -->
					<figure class="wp-block-image size-large gbe-le-gbe-hero__figure"><img src="<?php echo esc_url( $figure_url ); ?>" alt="<?php echo esc_attr__( 'Sculpture traditionnelle gbe', 'gbecosmolingua' ); ?>"/></figure>
					<!-- /wp:image -->
					<?php else : ?>
					<!-- wp:group {"className":"gbe-le-gbe-hero__figure gbe-le-gbe-hero__figure--placeholder","layout":{"type":"constrained"}} -->
					<div class="wp-block-group gbe-le-gbe-hero__figure gbe-le-gbe-hero__figure--placeholder"></div>
					<!-- /wp:group -->
					<?php endif; ?>
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
