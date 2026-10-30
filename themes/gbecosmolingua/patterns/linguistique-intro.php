<?php
/**
 * Title: Linguistique — Introduction
 * Slug: gbecosmolingua/linguistique-intro
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = get_page_by_path( 'le-gbe/linguistique', OBJECT, 'page' );
$html = $page && function_exists( 'gbecosmolingua_public_page_intro_html' )
	? gbecosmolingua_public_page_intro_html( $page )
	: '';

if ( '' === trim( $html ) ) {
	$html = '<p>' . esc_html__( 'La linguistique gbe documente les systèmes d\'écriture, les structures phonologiques et grammaticales, la variation dialectale et les corpus numériques du continuum — du Togo au Nigeria.', 'gbecosmolingua' ) . '</p>';
	$html .= '<p>' . esc_html__( 'Explorez huit thèmes : alphabet, phonologie, morphologie, syntaxe, lexicologie, dialectologie, corpus numériques et bibliothèque.', 'gbecosmolingua' ) . '</p>';
}

$wrapped = gbecosmolingua_hub_chapter_body_html( $html, 'linguistique' );
if ( $wrapped !== $html ) {
	?>
<!-- wp:html -->
<?php echo $wrapped; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
	<?php
	return;
}
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-linguistique-intro","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide gbe-section gbe-linguistique-intro">
	<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
<!-- /wp:group -->
