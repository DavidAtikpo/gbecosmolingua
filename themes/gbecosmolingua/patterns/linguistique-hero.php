<?php
/**
 * Title: Linguistique — Bannière
 * Slug: gbecosmolingua/linguistique-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$page = get_page_by_path( 'le-gbe/linguistique', OBJECT, 'page' );

$title = $page ? $page->post_title : 'Linguistique';
$lead  = $page && function_exists( 'gbecosmolingua_public_page_excerpt_text' )
	? gbecosmolingua_public_page_excerpt_text( $page )
	: __( 'Alphabet, phonologie, morphologie, syntaxe, lexicologie, dialectologie — ressources scientifiques pour l\'étude des variétés gbe.', 'gbecosmolingua' );

if ( '' === trim( $lead ) ) {
	$lead = __( 'Alphabet, phonologie, morphologie, syntaxe, lexicologie, dialectologie — ressources scientifiques pour l\'étude des variétés gbe.', 'gbecosmolingua' );
}

$hero_style = '';
if ( $page && function_exists( 'gbecosmolingua_public_featured_image_style' ) ) {
	$hero_style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-linguistique-hero-image' );
}
if ( ! $hero_style && function_exists( 'gbecosmolingua_linguistique_image_style' ) ) {
	$hero_style = gbecosmolingua_linguistique_image_style( 'hero-village.jpg', '--gbe-linguistique-hero-image' );
}

$alphabet_url = gbecosmolingua_linguistique_page_url( 'alphabet' );
$biblio_url   = gbecosmolingua_linguistique_page_url( 'bibliotheque' );
?>
<!-- wp:group {"align":"full","className":"gbe-linguistique-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-linguistique-hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"920px"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"align":"center","className":"gbe-linguistique-hero__kicker"} -->
		<p class="has-text-align-center gbe-linguistique-hero__kicker"><a href="<?php echo esc_url( home_url( '/le-gbe/' ) ); ?>"><?php esc_html_e( 'Gbe', 'gbecosmolingua' ); ?></a></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"className":"gbe-linguistique-hero__title","textAlign":"center"} -->
		<h1 class="wp-block-heading has-text-align-center gbe-linguistique-hero__title"><?php echo esc_html( $title ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"gbe-linguistique-hero__lead"} -->
		<p class="has-text-align-center gbe-linguistique-hero__lead"><?php echo esc_html( $lead ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-linguistique-hero__actions","layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons gbe-linguistique-hero__actions">
			<!-- wp:button {"className":"is-style-fill"} -->
			<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $alphabet_url ); ?>"><?php esc_html_e( 'Alphabet et phonologie', 'gbecosmolingua' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $biblio_url ); ?>"><?php esc_html_e( 'Bibliothèque', 'gbecosmolingua' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
