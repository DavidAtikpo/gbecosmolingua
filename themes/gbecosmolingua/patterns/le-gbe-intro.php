<?php
/**
 * Title: Le Gbe — Introduction
 * Slug: gbecosmolingua/le-gbe-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

ob_start();
gbecosmolingua_le_gbe_render_public_intro();
$html = ob_get_clean();
if ( '' === trim( $html ) ) {
	return;
}
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
