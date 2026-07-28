<?php
/**
 * Title: Le Gbe — Publications et événements
 * Slug: gbecosmolingua/le-gbe-actu
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-le-gbe-actu","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-le-gbe-actu">
	<!-- wp:columns {"className":"gbe-le-gbe-actu__columns"} -->
	<div class="wp-block-columns gbe-le-gbe-actu__columns">
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
