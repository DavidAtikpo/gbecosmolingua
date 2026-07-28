<?php
/**
 * Title: Hub — Notre philosophie
 * Slug: gbecosmolingua/hub-page-philosophie
 * Categories: gbecosmolingua
 * Inserter: false
 */
ob_start();
gbecosmolingua_hub_render_pattern( 'philosophie' );
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
