<?php
/**
 * Title: Paremiologie — Sections thématiques
 * Slug: gbecosmolingua/paremiologie-sections
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_paremiologie_hub_sections();
if ( empty( $sections ) ) {
	$sections = gbecosmolingua_paremiologie_hub_sections_fallback();
}
$featured = gbecosmolingua_paremiologie_featured_proverbe();
$stats    = gbecosmolingua_paremiologie_stats();

ob_start();
gbecosmolingua_paremiologie_render_search();
?>
<section class="gbe-paremiologie-stats">
	<div class="gbe-paremiologie-stats__grid">
		<?php foreach ( $stats as $stat ) : ?>
			<div class="gbe-paremiologie-stats__item">
				<p class="gbe-paremiologie-stats__value" <?php echo isset( $stat['stat'] ) ? 'data-gbe-stat="' . esc_attr( (string) $stat['stat'] ) . '" data-gbe-suffix="' . esc_attr( $stat['suffix'] ?? '' ) . '"' : ''; ?>>
					<?php echo esc_html( $stat['value'] ); ?>
				</p>
				<p class="gbe-paremiologie-stats__label"><?php echo esc_html( $stat['label'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php
if ( $featured ) :
	?>
<div class="gbe-paremiologie-featured">
	<div class="gbe-paremiologie-featured__inner">
		<p class="gbe-paremiologie-featured__kicker"><?php esc_html_e( 'Proverbe à la une', 'gbecosmolingua' ); ?></p>
		<h2><?php echo esc_html( $featured['title'] ); ?></h2>
		<p class="gbe-paremiologie-featured__meta"><?php echo esc_html( $featured['meta'] ); ?></p>
		<p><?php echo esc_html( $featured['excerpt'] ); ?></p>
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( $featured['url'] ); ?>"><?php esc_html_e( 'Lire la fiche', 'gbecosmolingua' ); ?></a>
	</div>
</div>
	<?php
endif;
?>
<div class="gbe-culture-rubriques gbe-paremiologie-rubriques">
<?php
foreach ( $sections as $index => $section ) {
	$thumb_style = gbecosmolingua_paremiologie_section_media_style( $section );
	$page_url    = gbecosmolingua_paremiologie_page_url( $section['slug'] );
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
			<?php gbecosmolingua_paremiologie_render_subtopics( $section ); ?>
		</div>
	</div>
	<?php
}
?>
</div>
<section class="gbe-paremiologie-cta alignfull">
	<div class="gbe-paremiologie-cta__inner">
		<h2><?php esc_html_e( 'Rejoindre la recherche paremiologique', 'gbecosmolingua' ); ?></h2>
		<p><?php esc_html_e( 'Colloques, séminaires et publications — découvrez les activités scientifiques de GbeCosmoLingua.', 'gbecosmolingua' ); ?></p>
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( home_url( '/recherche-et-innovation/activites/' ) ); ?>"><?php esc_html_e( 'Voir les activités', 'gbecosmolingua' ); ?></a>
	</div>
</section>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
