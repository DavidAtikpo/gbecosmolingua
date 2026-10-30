<?php
/**
 * Title: Cultures Gbe — Introduction
 * Slug: gbecosmolingua/culture-gbe-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = gbecosmolingua_public_hub_page( 'cultures-gbe' );
$html = gbecosmolingua_public_page_intro_html( $page );
if ( '' === trim( $html ) ) {
	$html  = '<p>' . esc_html__( 'Malgré la diversité dialectale, le patrimoine culturel gbe révèle des convergences profondes : proverbes, comptines, chants et traditions orales circulent entre sections dialectales.', 'gbecosmolingua' ) . '</p>';
	$html .= '<p>' . esc_html__( 'Explorez architecture, artisanat, arts, musique, danse, gastronomie, croyances et patrimoines matériels/immateriels.', 'gbecosmolingua' ) . '</p>';
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-culture-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-culture-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
