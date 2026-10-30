<?php
/**
 * Title: Accueil — Bibliothèque numérique
 * Slug: gbecosmolingua/home-bibliotheque
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

ob_start();
gbecosmolingua_home_render_bibliotheque();
$html = ob_get_clean();
if ( '' === trim( $html ) ) {
	return;
}
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
