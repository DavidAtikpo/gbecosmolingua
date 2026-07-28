<?php
/**
 * Title: Hub — Nous Soutenir
 * Slug: gbecosmolingua/hub-page-soutenir
 * Categories: gbecosmolingua
 * Inserter: false
 */
ob_start();
gbecosmolingua_hub_render_hero( 'soutenir' );
gbecosmolingua_hub_render_pattern( 'soutenir' );
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
