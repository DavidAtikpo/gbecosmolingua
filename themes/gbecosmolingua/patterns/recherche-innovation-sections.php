<?php
/**
 * Title: Recherche et Innovation — Sections
 * Slug: gbecosmolingua/recherche-innovation-sections
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_recherche_hub_sections();
$featured = gbecosmolingua_recherche_featured_highlight();

ob_start();
gbecosmolingua_recherche_render_search();
?>
<div class="gbe-recherche-featured">
	<div class="gbe-recherche-featured__inner">
		<p class="gbe-recherche-featured__kicker"><?php esc_html_e( 'À la une', 'gbecosmolingua' ); ?></p>
		<h2><?php echo esc_html( $featured['title'] ); ?></h2>
		<p class="gbe-recherche-featured__meta"><?php echo esc_html( $featured['meta'] ); ?></p>
		<p><?php echo esc_html( $featured['excerpt'] ); ?></p>
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( $featured['url'] ); ?>"><?php esc_html_e( 'En savoir plus', 'gbecosmolingua' ); ?></a>
	</div>
</div>
<div class="gbe-culture-rubriques gbe-recherche-rubriques">
<?php
foreach ( $sections as $index => $section ) {
	$thumb_style = gbecosmolingua_recherche_image_style( $section['thumb'], '--gbe-culture-section-image' );
	$page_url    = gbecosmolingua_recherche_page_url( $section['slug'] );
	$reverse     = ( 1 === $index % 2 );
	$is_feature  = ( isset( $section['layout'] ) && 'feature' === $section['layout'] );
	$band_class  = 'gbe-culture-band';
	if ( 1 === $index % 2 ) {
		$band_class .= ' gbe-culture-band--alt';
	}

	$classes = 'gbe-culture-rubrique gbe-culture-rubrique--split';
	if ( $reverse ) {
		$classes .= ' gbe-culture-rubrique--reverse';
	}
	if ( $is_feature ) {
		$classes .= ' gbe-culture-rubrique--feature';
	}
	?>
	<div class="<?php echo esc_attr( $band_class ); ?>" id="<?php echo esc_attr( $section['id'] ); ?>">
		<div class="gbe-culture-band__inner">
			<section class="<?php echo esc_attr( $classes ); ?>">
				<div class="gbe-culture-rubrique__media gbe-culture-rubrique__media--<?php echo esc_attr( $section['mod'] ); ?>" style="<?php echo esc_attr( $thumb_style ); ?>" role="img" aria-label="<?php echo esc_attr( $section['title'] ); ?>"></div>
				<div class="gbe-culture-rubrique__content">
					<h2><?php echo esc_html( $section['title'] ); ?></h2>
					<p class="gbe-culture-rubrique__lead"><?php echo esc_html( $section['intro'] ); ?></p>
					<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( $page_url ); ?>">
						<?php
						printf(
							/* translators: %s: section title */
							esc_html__( 'Explorer %s', 'gbecosmolingua' ),
							esc_html( $section['title'] )
						);
						?>
					</a>
				</div>
			</section>
			<?php gbecosmolingua_recherche_render_subtopics( $section ); ?>
		</div>
	</div>
	<?php
}
?>
</div>
<section class="gbe-recherche-cta alignfull">
	<div class="gbe-recherche-cta__inner">
		<h2><?php esc_html_e( 'Devenir partenaire de recherche', 'gbecosmolingua' ); ?></h2>
		<p><?php esc_html_e( 'Universités, laboratoires et institutions : rejoignez le réseau GbeCosmoLingua.', 'gbecosmolingua' ); ?></p>
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( home_url( '/nous-soutenir/devenir-partenaire/' ) ); ?>"><?php esc_html_e( 'Proposer une collaboration', 'gbecosmolingua' ); ?></a>
	</div>
</section>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
