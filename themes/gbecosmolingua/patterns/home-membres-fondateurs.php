<?php
/**
 * Title: Accueil — Membres fondateurs
 * Slug: gbecosmolingua/home-membres-fondateurs
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

ob_start();
gbecosmolingua_home_render_membres_fondateurs();
$html = ob_get_clean();
if ( '' === trim( $html ) ) {
	return;
}
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
