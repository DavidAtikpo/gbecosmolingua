<?php
/**
 * Title: Le Gbe — Sections thématiques
 * Slug: gbecosmolingua/le-gbe-sections
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_le_gbe_hub_sections();
$more     = gbecosmolingua_le_gbe_hub_more_sections();

ob_start();
?>
<div class="gbe-culture-rubriques gbe-le-gbe-rubriques">
<?php
foreach ( $sections as $index => $section ) {
	$thumb_style = gbecosmolingua_le_gbe_image_style( $section['thumb'], '--gbe-culture-section-image' );
	$page_url    = gbecosmolingua_le_gbe_page_url( $section['slug'] );
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
			<?php gbecosmolingua_le_gbe_render_subtopics( $section ); ?>
		</div>
	</div>
	<?php
}

if ( ! empty( $more ) ) {
	?>
	<div class="gbe-culture-band gbe-le-gbe-voir-plus">
		<div class="gbe-culture-band__inner">
			<h2 class="gbe-le-gbe-voir-plus__title"><?php esc_html_e( 'Voir plus', 'gbecosmolingua' ); ?></h2>
			<div class="gbe-culture-subtopics__grid gbe-le-gbe-voir-plus__grid">
				<?php foreach ( $more as $row ) : ?>
					<?php
					$style = gbecosmolingua_le_gbe_image_style( $row['thumb'], '--gbe-culture-section-image' );
					?>
					<article class="gbe-culture-subtopic gbe-le-gbe-voir-plus__card">
						<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
						<div class="gbe-culture-subtopic__body">
							<h3><?php echo esc_html( $row['title'] ); ?></h3>
							<p><?php echo esc_html( $row['intro'] ); ?></p>
							<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $row['url'] ); ?>">
								<?php esc_html_e( 'Découvrir', 'gbecosmolingua' ); ?>
							</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php
}
?>
</div>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
