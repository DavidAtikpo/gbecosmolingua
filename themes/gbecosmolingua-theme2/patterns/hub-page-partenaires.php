<?php
/**
 * Title: Hub — Partenaires
 * Slug: gbecosmolingua/hub-page-partenaires
 * Categories: gbecosmolingua
 * Inserter: false
 */
ob_start();
gbecosmolingua_hub_render_hero( 'partenaires' );
gbecosmolingua_hub_render_pattern( 'partenaires' );
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
