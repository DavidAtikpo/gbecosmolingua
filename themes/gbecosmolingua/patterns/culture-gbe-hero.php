<?php
/**
 * Title: Cultures Gbe — Bannière
 * Slug: gbecosmolingua/culture-gbe-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$hero_style = gbecosmolingua_culture_image_style( 'hero-culture.jpg', '--gbe-culture-hero-image' );
?>
<!-- wp:group {"align":"full","className":"gbe-culture-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-culture-hero" style="<?php echo esc_attr( $hero_style ); ?>">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-culture-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-culture-hero__title">Les Cultures Gbe</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-culture-hero__lead"} -->
		<p class="has-text-align-center gbe-culture-hero__lead">Un patrimoine vivant partagé par les peuples du Togo, du Bénin, du Ghana et du Nigeria — arts, rituels, savoirs et expressions culturelles en dialogue avec le monde.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-culture-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-culture-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="#gbe-culture-categories">Explorer les cultures</a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/xotutu/">Parcourir le patrimoine</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
