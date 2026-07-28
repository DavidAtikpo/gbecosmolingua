<?php
/**
 * Title: Accueil — Bannière patrimoine
 * Slug: gbecosmolingua/home-hero
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$hero_path = get_stylesheet_directory() . '/assets/images/home/hero-patrimoine.jpg';
$hero_url  = file_exists( $hero_path ) ? get_stylesheet_directory_uri() . '/assets/images/home/hero-patrimoine.jpg' : '';
$hero_var  = $hero_url ? '--gbe-home-hero-image:url(' . esc_url( $hero_url ) . ');' : '';
?>
<!-- wp:group {"align":"full","className":"gbe-home-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull gbe-home-hero" style="<?php echo esc_attr( $hero_var ); ?>">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"1140px"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":1,"className":"gbe-home-hero__title"} -->
		<h1 class="wp-block-heading gbe-home-hero__title">Préserver, transmettre et faire rayonner le patrimoine Gbe.</h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"gbe-home-hero__lead"} -->
		<p class="gbe-home-hero__lead">GbeCosmoLingua rassemble langues, cultures et savoirs du continuum gbe au Togo, au Bénin, au Ghana et au Nigeria — pour la recherche, la transmission et le dialogue interculturel.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"className":"gbe-home-hero__actions"} -->
		<div class="wp-block-buttons gbe-home-hero__actions">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/nous-soutenir/">Rejoindre la communauté Gbe</a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/le-gbe/">Découvrir le continuum</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
