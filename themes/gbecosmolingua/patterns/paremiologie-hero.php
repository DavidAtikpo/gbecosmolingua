<?php
/**
 * Title: Paremiologie — Bannière
 * Slug: gbecosmolingua/paremiologie-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$hero_style = gbecosmolingua_paremiologie_image_style( 'hero-proverbes.jpg', '--gbe-paremiologie-hero-image' );
?>
<!-- wp:group {"align":"full","className":"gbe-paremiologie-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-paremiologie-hero" style="<?php echo esc_attr( $hero_style ); ?>">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-paremiologie-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-paremiologie-hero__title">Paremiologie</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-paremiologie-hero__lead"} -->
		<p class="has-text-align-center gbe-paremiologie-hero__lead">Sagesse populaire, visions du monde et paremiologie comparée des peuples gbe.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-paremiologie-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-paremiologie-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="#gbe-paremiologie-banque">Explorer la banque</a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( gbecosmolingua_paremiologie_page_url( 'axes-de-recherche' ) ); ?>">Axes de recherche</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
