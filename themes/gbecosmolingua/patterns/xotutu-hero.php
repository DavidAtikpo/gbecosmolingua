<?php
/**
 * Title: Xótùtù — Bannière
 * Slug: gbecosmolingua/xotutu-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$hero_style = gbecosmolingua_xotutu_image_style( 'hero-orality.jpg', '--gbe-xotutu-hero-image' );
?>
<!-- wp:group {"align":"full","className":"gbe-xotutu-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-xotutu-hero" style="<?php echo esc_attr( $hero_style ); ?>">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-xotutu-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-xotutu-hero__title">Xótùtù</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-xotutu-hero__lead"} -->
		<p class="has-text-align-center gbe-xotutu-hero__lead">Bibliothèque numérique des savoirs, traditions orales et patrimoines culturels gbe.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-xotutu-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-xotutu-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="#gbe-xotutu-collections">Explorer les collections</a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( gbecosmolingua_xotutu_page_url( 'tradition-orale-patrimoines' ) ); ?>">À propos de Xótùtù</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
