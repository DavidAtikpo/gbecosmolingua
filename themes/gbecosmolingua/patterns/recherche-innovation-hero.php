<?php
/**
 * Title: Recherche et Innovation — Bannière
 * Slug: gbecosmolingua/recherche-innovation-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$hero_style = gbecosmolingua_recherche_image_style( 'hero-recherche.jpg', '--gbe-recherche-hero-image' );
?>
<!-- wp:group {"align":"full","className":"gbe-recherche-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-recherche-hero" style="<?php echo esc_attr( $hero_style ); ?>">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-recherche-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-recherche-hero__title">Recherche et Innovation</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-recherche-hero__lead"} -->
		<p class="has-text-align-center gbe-recherche-hero__lead">Centre international d'études gbe : recherche scientifique, innovation et coopération internationale.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-recherche-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-recherche-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="#gbe-recherche-ressources">Ressources documentaires</a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( gbecosmolingua_recherche_page_url( 'activites' ) ); ?>">Agenda des activités</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
