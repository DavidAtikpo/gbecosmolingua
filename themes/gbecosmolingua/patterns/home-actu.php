<?php
/**
 * Title: Accueil — Actualités et événements
 * Slug: gbecosmolingua/home-actu
 * Categories: gbecosmolingua
 * Inserter: false
 */
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-home-actu","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-home-actu">
	<!-- wp:columns {"className":"gbe-home-actu__columns"} -->
	<div class="wp-block-columns gbe-home-actu__columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:shortcode -->
			[gbe_actualites limit="3"]
			<!-- /wp:shortcode -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:shortcode -->
			[gbe_agenda limit="5"]
			<!-- /wp:shortcode -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
