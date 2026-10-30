<?php
/**
 * Title: Paremiologie — Bannière
 * Slug: gbecosmolingua/paremiologie-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = function_exists( 'gbecosmolingua_public_hub_page' ) ? gbecosmolingua_public_hub_page( 'paremiologie' ) : null;

$title = $page ? $page->post_title : 'Paremiologie';
$lead  = $page && function_exists( 'gbecosmolingua_public_page_excerpt_text' )
	? gbecosmolingua_public_page_excerpt_text( $page )
	: __( 'Banque numérique de proverbes, corpus par variété et recherche paremiologique comparée au service du continuum gbe.', 'gbecosmolingua' );

if ( '' === trim( $lead ) ) {
	$lead = __( 'Banque numérique de proverbes, corpus par variété et recherche paremiologique comparée au service du continuum gbe.', 'gbecosmolingua' );
}

$hero_style = '';
if ( $page && function_exists( 'gbecosmolingua_public_featured_image_style' ) ) {
	$hero_style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-paremiologie-hero-image' );
}
if ( ! $hero_style && function_exists( 'gbecosmolingua_paremiologie_image_style' ) ) {
	$hero_style = gbecosmolingua_paremiologie_image_style( 'hero-proverbes.jpg', '--gbe-paremiologie-hero-image' );
}

$banque_url = function_exists( 'gbecosmolingua_paremiologie_page_url' )
	? gbecosmolingua_paremiologie_page_url( 'banque-numerique-proverbes' )
	: home_url( '/paremiologie/banque-numerique-proverbes/' );
$axes_url   = function_exists( 'gbecosmolingua_paremiologie_page_url' )
	? gbecosmolingua_paremiologie_page_url( 'axes-de-recherche' )
	: home_url( '/paremiologie/axes-de-recherche/' );
?>
<!-- wp:group {"align":"full","className":"gbe-paremiologie-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-paremiologie-hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-paremiologie-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-paremiologie-hero__title"><?php echo esc_html( $title ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-paremiologie-hero__lead"} -->
		<p class="has-text-align-center gbe-paremiologie-hero__lead"><?php echo esc_html( $lead ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-paremiologie-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-paremiologie-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $banque_url ); ?>"><?php esc_html_e( 'Explorer la banque de proverbes', 'gbecosmolingua' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $axes_url ); ?>"><?php esc_html_e( 'Axes de recherche', 'gbecosmolingua' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
