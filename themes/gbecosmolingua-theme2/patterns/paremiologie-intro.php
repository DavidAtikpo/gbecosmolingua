<?php
/**
 * Title: Paremiologie — Introduction
 * Slug: gbecosmolingua/paremiologie-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = function_exists( 'gbecosmolingua_public_hub_page' ) ? gbecosmolingua_public_hub_page( 'paremiologie' ) : null;
$html = $page && function_exists( 'gbecosmolingua_public_page_intro_html' )
	? gbecosmolingua_public_page_intro_html( $page )
	: '';

if ( '' === trim( $html ) ) {
	$html = '<p>' . esc_html__( 'La paremiologie gbe recueille, analyse et compare les proverbes, dictons et formules sapientielles du continuum — du Togo au Nigeria. GbeCosmoLingua en documente le texte original, les transcriptions, les traductions et les contextes d\'emploi.', 'gbecosmolingua' ) . '</p>';
	$html .= '<p>' . esc_html__( 'Explorez la banque numérique, les corpus par variété linguistique et les axes de recherche comparée.', 'gbecosmolingua' ) . '</p>';
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-paremiologie-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-paremiologie-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
