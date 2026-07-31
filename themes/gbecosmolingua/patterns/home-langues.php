<?php
/**
 * Title: Accueil — Langues gbe
 * Slug: gbecosmolingua/home-langues
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

ob_start();
gbecosmolingua_home_render_langues();
$html = ob_get_clean();
if ( '' === trim( $html ) ) {
	return;
}
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
