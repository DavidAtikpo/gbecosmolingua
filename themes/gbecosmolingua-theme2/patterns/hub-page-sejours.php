<?php
/**
 * Title: Hub — Séjours et Mobilité
 * Slug: gbecosmolingua/hub-page-sejours
 * Categories: gbecosmolingua
 * Inserter: false
 */
ob_start();
gbecosmolingua_hub_render_hero( 'sejours' );
gbecosmolingua_hub_render_pattern( 'sejours' );
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
