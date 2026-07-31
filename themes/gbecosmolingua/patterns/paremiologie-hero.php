<?php
/**
 * Title: Paremiologie — Bannière
 * Slug: gbecosmolingua/paremiologie-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = gbecosmolingua_public_hub_page( 'paremiologie' );
if ( ! $page ) {
	return;
}

$hero_style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-paremiologie-hero-image' );
$lead       = gbecosmolingua_public_page_excerpt_text( $page );
?>
<!-- wp:group {"align":"full","className":"gbe-paremiologie-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-paremiologie-hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-paremiologie-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-paremiologie-hero__title"><?php echo esc_html( $page->post_title ); ?></h1>
		<!-- /wp:heading -->

		<?php if ( $lead ) : ?>
		<!-- wp:paragraph {"align":"center","className":"gbe-paremiologie-hero__lead"} -->
		<p class="has-text-align-center gbe-paremiologie-hero__lead"><?php echo esc_html( $lead ); ?></p>
		<!-- /wp:paragraph -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
