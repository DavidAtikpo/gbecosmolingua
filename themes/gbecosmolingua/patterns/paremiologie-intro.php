<?php
/**
 * Title: Paremiologie — Introduction
 * Slug: gbecosmolingua/paremiologie-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = gbecosmolingua_public_hub_page( 'paremiologie' );
$html = gbecosmolingua_public_page_intro_html( $page );
if ( '' === $html ) {
	return;
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-paremiologie-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-paremiologie-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
