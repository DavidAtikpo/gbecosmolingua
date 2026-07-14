<?php
/**
 * Title: Bannière accueil
 * Slug: gbecosmolingua/home-hero
 * Categories: gbecosmolingua
 * Inserter: false
 */
?>
<!-- wp:group {"align":"full","className":"gbe-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull gbe-hero">
	<!-- wp:columns {"verticalAlignment":"center","className":"gbe-hero__layout"} -->
	<div class="wp-block-columns are-vertically-aligned-center gbe-hero__layout">
		<!-- wp:column {"verticalAlignment":"center","width":"34%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:34%">
			<!-- wp:shortcode -->
			[gbe_site_logo width="240" class="gbe-hero__logo" link="0"]
			<!-- /wp:shortcode -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"66%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66%">
			<!-- wp:paragraph {"className":"gbe-tagline"} -->
			<p class="gbe-tagline">Observatoire international</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1} -->
			<h1 class="wp-block-heading">Bienvenue à GbeCosmoLingua</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size">Un pont entre les langues, les cultures et les peuples du continuum gbe.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
