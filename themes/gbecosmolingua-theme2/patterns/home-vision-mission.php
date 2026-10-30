<?php
/**
 * Title: Vision et mission
 * Slug: gbecosmolingua/home-vision-mission
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

if ( ! function_exists( 'gbe_home_vision_mission_section_html' ) ) {
	return;
}

$html = gbe_home_vision_mission_section_html();
if ( '' === trim( $html ) ) {
	return;
}
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
