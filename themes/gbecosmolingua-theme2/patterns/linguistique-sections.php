<?php
/**
 * Title: Linguistique — Sections thématiques
 * Slug: gbecosmolingua/linguistique-sections
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_linguistique_hub_sections();
if ( empty( $sections ) ) {
	$sections = gbecosmolingua_linguistique_hub_sections_fallback();
}
$stats = gbecosmolingua_linguistique_stats();

ob_start();
gbecosmolingua_linguistique_render_nav_tabs();
?>
<section class="gbe-linguistique-stats">
	<div class="gbe-linguistique-stats__grid">
		<?php foreach ( $stats as $stat ) : ?>
			<div class="gbe-linguistique-stats__item">
				<p class="gbe-linguistique-stats__value" <?php echo isset( $stat['stat'] ) ? 'data-gbe-stat="' . esc_attr( (string) $stat['stat'] ) . '" data-gbe-suffix="' . esc_attr( $stat['suffix'] ?? '' ) . '"' : ''; ?>>
					<?php echo esc_html( $stat['value'] ); ?>
				</p>
				<p class="gbe-linguistique-stats__label"><?php echo esc_html( $stat['label'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<div class="gbe-culture-rubriques gbe-linguistique-rubriques">
<?php
foreach ( $sections as $index => $section ) {
	$thumb_style = gbecosmolingua_linguistique_section_media_style( $section );
	$page_url    = gbecosmolingua_linguistique_page_url( $section['items'][0]['slug'] ?? '' );
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
			<?php gbecosmolingua_linguistique_render_subtopics( $section ); ?>
		</div>
	</div>
	<?php
}
?>
</div>
<section class="gbe-linguistique-cta alignfull">
	<div class="gbe-linguistique-cta__inner">
		<h2><?php esc_html_e( 'Carte interactive des langues gbe', 'gbecosmolingua' ); ?></h2>
		<p><?php esc_html_e( 'Visualisez la répartition des variétés linguistiques, les aires culturelles et les centres patrimoniaux du continuum.', 'gbecosmolingua' ); ?></p>
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( home_url( '/le-gbe/carte-interactive/' ) ); ?>"><?php esc_html_e( 'Ouvrir la carte', 'gbecosmolingua' ); ?></a>
	</div>
</section>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
