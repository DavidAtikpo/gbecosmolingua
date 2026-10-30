<?php
/**
 * Title: Onomastique — Sections thématiques
 * Slug: gbecosmolingua/onomastique-sections
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_onomastique_hub_sections();
if ( empty( $sections ) ) {
	$sections = gbecosmolingua_onomastique_hub_sections_fallback();
}

ob_start();
gbecosmolingua_onomastique_render_nav_tabs();
?>
<div class="gbe-culture-rubriques gbe-onomastique-rubriques">
<?php
foreach ( $sections as $index => $section ) {
	$thumb_style = gbecosmolingua_onomastique_section_media_style( $section );
	$page_url    = gbecosmolingua_onomastique_page_url( $section['slug'] );
	$reverse     = ( 1 === $index % 2 );
	$band_class  = 'gbe-culture-band';
	if ( 1 === $index % 2 ) {
		$band_class .= ' gbe-culture-band--alt';
	}

	$classes = 'gbe-culture-rubrique gbe-culture-rubrique--split';
	if ( $reverse ) {
		$classes .= ' gbe-culture-rubrique--reverse';
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
			<?php gbecosmolingua_onomastique_render_subtopics( $section ); ?>
		</div>
	</div>
	<?php
}
?>
</div>
<section class="gbe-onomastique-cta alignfull">
	<div class="gbe-onomastique-cta__inner">
		<h2><?php esc_html_e( 'Retour au patrimoine Xótùtù', 'gbecosmolingua' ); ?></h2>
		<p><?php esc_html_e( 'Genres folkloriques, archives numériques et questions terminologiques — explorez l\'ensemble du patrimoine oral gbe.', 'gbecosmolingua' ); ?></p>
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( home_url( '/xotutu/' ) ); ?>"><?php esc_html_e( 'Hub Xótùtù', 'gbecosmolingua' ); ?></a>
	</div>
</section>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
