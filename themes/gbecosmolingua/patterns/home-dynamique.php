<?php
/**
 * Title: Sections dynamiques accueil
 * Slug: gbecosmolingua/home-dynamique
 * Categories: gbecosmolingua
 * Inserter: false
 */
?>
<!-- wp:group {"className":"gbe-section gbe-section--dynamique","layout":{"type":"constrained"}} -->
<div class="wp-block-group gbe-section gbe-section--dynamique">
	<!-- wp:shortcode -->
	[gbe_actualites limit="3"]
	<!-- /wp:shortcode -->

	<!-- wp:shortcode -->
	[gbe_agenda limit="5"]
	<!-- /wp:shortcode -->

	<!-- wp:shortcode -->
	[gbe_partenaires limit="8"]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
