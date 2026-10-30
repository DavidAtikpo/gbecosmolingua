<?php
/**
 * Title: Onomastique — Introduction
 * Slug: gbecosmolingua/onomastique-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = get_page_by_path( 'xotutu/onomastique', OBJECT, 'page' );
$html = $page && function_exists( 'gbecosmolingua_public_page_intro_html' )
	? gbecosmolingua_public_page_intro_html( $page )
	: '';

if ( '' === trim( $html ) ) {
	$html = '<p>' . esc_html__( 'L\'onomastique gbe recense et analyse les noms de personnes, de lieux, de cours d\'eau, de peuples et de divinités. GbeCosmoLingua en documente la forme, la signification, les contextes d\'usage et les réseaux de parenté onomastique.', 'gbecosmolingua' ) . '</p>';
	$html .= '<p>' . esc_html__( 'Parcourez les cinq rubriques : anthroponymie, toponymie, hydronymie, ethnonymie et théonymie.', 'gbecosmolingua' ) . '</p>';
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-onomastique-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-onomastique-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
