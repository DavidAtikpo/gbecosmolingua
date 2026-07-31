<?php
/**
 * Title: Recherche et Innovation — Introduction
 * Slug: gbecosmolingua/recherche-innovation-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = gbecosmolingua_public_hub_page( 'recherche-et-innovation' );
$html = gbecosmolingua_public_page_intro_html( $page );
if ( '' === $html ) {
	return;
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-recherche-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-recherche-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
