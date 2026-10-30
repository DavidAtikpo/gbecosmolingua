<?php
/**
 * Title: Accueil — Carte interactive
 * Slug: gbecosmolingua/home-map
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

ob_start();
gbecosmolingua_home_render_map();
$html = ob_get_clean();
if ( '' === trim( $html ) ) {
	return;
}
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
