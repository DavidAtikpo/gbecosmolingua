<?php
/**
 * Title: Cultures Gbe — Introduction
 * Slug: gbecosmolingua/culture-gbe-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = gbecosmolingua_public_hub_page( 'cultures-gbe' );
$html = gbecosmolingua_public_page_intro_html( $page );
if ( '' === $html ) {
	return;
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-culture-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-culture-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
