<?php
/**
 * Title: Cultures Gbe — Sections thématiques
 * Slug: gbecosmolingua/culture-gbe-sections
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_culture_hub_sections();

ob_start();
?>
<div class="gbe-culture-rubriques">
<?php
foreach ( $sections as $index => $section ) {
	$thumb_style = ! empty( $section['page_id'] )
		? gbecosmolingua_public_featured_image_style( (int) $section['page_id'], '--gbe-culture-section-image' )
		: '';
	$page_url    = gbecosmolingua_culture_page_url( $section['slug'] );
	$reverse     = ( 1 === $index % 2 );
	$is_banner   = ( isset( $section['layout'] ) && 'banner' === $section['layout'] );
	$band_class  = 'gbe-culture-band';
	if ( 1 === $index % 2 ) {
		$band_class .= ' gbe-culture-band--alt';
	}

	if ( $is_banner ) {
		?>
	<section id="<?php echo esc_attr( $section['id'] ); ?>" class="gbe-culture-rubrique gbe-culture-rubrique--banner alignfull" style="<?php echo esc_attr( $thumb_style ); ?>">
		<div class="gbe-culture-rubrique__banner-inner">
			<div class="gbe-culture-rubrique__content">
				<h2><?php echo esc_html( $section['title'] ); ?></h2>
				<p class="gbe-culture-rubrique__lead"><?php echo esc_html( $section['intro'] ); ?></p>
				<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( $page_url ); ?>">
					<?php
					printf(
						/* translators: %s: culture topic title */
						esc_html__( 'Explorer %s', 'gbecosmolingua' ),
						esc_html( $section['title'] )
					);
					?>
				</a>
			</div>
		</div>
	</section>
		<?php if ( ! empty( $section['items'] ) ) : ?>
	<div class="<?php echo esc_attr( $band_class ); ?>">
		<div class="gbe-culture-band__inner">
			<?php gbecosmolingua_culture_render_subtopics( $section ); ?>
		</div>
	</div>
		<?php endif; ?>
		<?php
		continue;
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
							/* translators: %s: culture topic title */
							esc_html__( 'Explorer %s', 'gbecosmolingua' ),
							esc_html( $section['title'] )
						);
						?>
					</a>
				</div>
			</section>
			<?php gbecosmolingua_culture_render_subtopics( $section ); ?>
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
