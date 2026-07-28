<?php
/**
 * Title: Accueil — Carte interactive
 * Slug: gbecosmolingua/home-map
 * Categories: gbecosmolingua
 * Inserter: false
 */

$map_img_path = get_stylesheet_directory() . '/assets/images/home/map-preview.jpg';
$map_img_url  = file_exists( $map_img_path ) ? get_stylesheet_directory_uri() . '/assets/images/home/map-preview.jpg' : '';
$use_photo    = (bool) $map_img_url;
$visual_class = 'gbe-home-map__visual' . ( $use_photo ? ' gbe-home-map__visual--photo' : ' gbe-home-map__visual--live' );
$map_style    = $use_photo ? '--gbe-home-map-photo:url(' . esc_url( $map_img_url ) . ');' : '';
$carte_url    = home_url( '/le-gbe/carte-interactive/' );
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-home-map","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-home-map">
	<!-- wp:columns {"verticalAlignment":"center","className":"gbe-home-map__layout"} -->
	<div class="wp-block-columns are-vertically-aligned-center gbe-home-map__layout">
		<!-- wp:column {"width":"45%"} -->
		<div class="wp-block-column" style="flex-basis:45%">
			<!-- wp:paragraph {"className":"gbe-home-map__kicker"} -->
			<p class="gbe-home-map__kicker">Explorer le continuum Gbe</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Un espace linguistique et culturel partagé</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Découvrez sur la carte interactive la richesse et la diversité des langues gbe à travers l'Afrique de l'Ouest.</p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $carte_url ); ?>">Explorer la carte interactive →</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"55%"} -->
		<div class="wp-block-column" style="flex-basis:55%">
			<!-- wp:html -->
			<a class="<?php echo esc_attr( $visual_class ); ?>" href="<?php echo esc_url( $carte_url ); ?>" style="<?php echo esc_attr( $map_style ); ?>" aria-label="<?php esc_attr_e( 'Ouvrir la carte interactive du continuum gbe en Afrique de l\'Ouest', 'gbecosmolingua' ); ?>">
				<?php if ( ! $use_photo ) : ?>
				<div id="gbe-home-map-preview" class="gbe-home-map__leaflet" aria-hidden="true"></div>
				<?php endif; ?>
				<div class="gbe-home-map__overlay">
					<span class="gbe-home-map__glow gbe-home-map__glow--gh" aria-hidden="true"></span>
					<span class="gbe-home-map__glow gbe-home-map__glow--tg" aria-hidden="true"></span>
					<span class="gbe-home-map__glow gbe-home-map__glow--bj" aria-hidden="true"></span>
					<span class="gbe-home-map__glow gbe-home-map__glow--ng" aria-hidden="true"></span>
					<p class="gbe-home-map__pin gbe-home-map__pin--gh"><span>🇬🇭</span> Ghana</p>
					<p class="gbe-home-map__pin gbe-home-map__pin--tg"><span>🇹🇬</span> Togo</p>
					<p class="gbe-home-map__pin gbe-home-map__pin--bj"><span>🇧🇯</span> Bénin</p>
					<p class="gbe-home-map__pin gbe-home-map__pin--ng"><span>🇳🇬</span> Nigeria</p>
				</div>
			</a>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
