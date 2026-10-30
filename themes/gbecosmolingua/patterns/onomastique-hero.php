<?php
/**
 * Title: Onomastique — Bannière
 * Slug: gbecosmolingua/onomastique-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = get_page_by_path( 'xotutu/onomastique', OBJECT, 'page' );

$title = $page ? $page->post_title : 'Onomastique';
$lead  = $page && function_exists( 'gbecosmolingua_public_page_excerpt_text' )
	? gbecosmolingua_public_page_excerpt_text( $page )
	: __( 'Anthroponymie, toponymie, hydronymie, ethnonymie et théonymie : les systèmes de dénomination des peuples, lieux, eaux et divinités du continuum gbe.', 'gbecosmolingua' );

if ( '' === trim( $lead ) ) {
	$lead = __( 'Anthroponymie, toponymie, hydronymie, ethnonymie et théonymie : les systèmes de dénomination des peuples, lieux, eaux et divinités du continuum gbe.', 'gbecosmolingua' );
}

$hero_style = '';
if ( $page && function_exists( 'gbecosmolingua_public_featured_image_style' ) ) {
	$hero_style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-onomastique-hero-image' );
}
if ( ! $hero_style && function_exists( 'gbecosmolingua_xotutu_image_style' ) ) {
	$hero_style = gbecosmolingua_xotutu_image_style( 'hero-orality.jpg', '--gbe-onomastique-hero-image' );
}

$anthro_url = function_exists( 'gbecosmolingua_onomastique_page_url' )
	? gbecosmolingua_onomastique_page_url( 'anthroponymie' )
	: home_url( '/xotutu/onomastique/anthroponymie/' );
$topo_url   = function_exists( 'gbecosmolingua_onomastique_page_url' )
	? gbecosmolingua_onomastique_page_url( 'toponymie' )
	: home_url( '/xotutu/onomastique/toponymie/' );
?>
<!-- wp:group {"align":"full","className":"gbe-onomastique-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-onomastique-hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"align":"center","className":"gbe-onomastique-hero__kicker"} -->
		<p class="has-text-align-center gbe-onomastique-hero__kicker"><a href="<?php echo esc_url( home_url( '/xotutu/' ) ); ?>"><?php esc_html_e( 'Xótùtù', 'gbecosmolingua' ); ?></a></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"className":"gbe-onomastique-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-onomastique-hero__title"><?php echo esc_html( $title ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-onomastique-hero__lead"} -->
		<p class="has-text-align-center gbe-onomastique-hero__lead"><?php echo esc_html( $lead ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-onomastique-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-onomastique-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $anthro_url ); ?>"><?php esc_html_e( 'Anthroponymie', 'gbecosmolingua' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $topo_url ); ?>"><?php esc_html_e( 'Toponymie', 'gbecosmolingua' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
