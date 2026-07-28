<?php
/**
 * Title: Cultures Gbe — Galerie et agenda
 * Slug: gbecosmolingua/culture-gbe-galerie-agenda
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$gallery_tiles = array( 'galerie-1.jpg', 'galerie-2.jpg', 'galerie-3.jpg', 'galerie-4.jpg', 'galerie-5.jpg' );

ob_start();
?>
<div class="gbe-section gbe-culture-galerie-agenda alignwide">
	<div class="gbe-culture-galerie-agenda__col">
		<h2>Galerie culturelle</h2>
		<p class="gbe-culture-block__intro">Images, objets et scènes du patrimoine gbe à travers le continuum.</p>
		<div class="gbe-culture-galerie__grid">
			<?php foreach ( $gallery_tiles as $i => $file ) : ?>
				<?php $style = gbecosmolingua_culture_image_style( $file, '--gbe-culture-thumb' ); ?>
				<div class="gbe-culture-galerie__tile gbe-culture-galerie__tile--<?php echo (int) ( $i + 1 ); ?>" style="<?php echo esc_attr( $style ); ?>"></div>
			<?php endforeach; ?>
		</div>
		<p class="gbe-culture-galerie-agenda__cta">
			<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( home_url( '/bibliotheque/' ) ); ?>">
				<?php esc_html_e( 'Parcourir la galerie', 'gbecosmolingua' ); ?>
			</a>
		</p>
	</div>
	<div class="gbe-culture-galerie-agenda__col gbe-culture-galerie-agenda__col--agenda">
		<h2>Événements culturels</h2>
		<p class="gbe-culture-block__intro"><?php esc_html_e( 'Festivals, rencontres et célébrations à venir.', 'gbecosmolingua' ); ?></p>
		<?php echo do_shortcode( '[gbe_agenda limit="3"]' ); ?>
		<p class="gbe-culture-galerie-agenda__cta">
			<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( get_post_type_archive_link( 'evenement' ) ?: home_url( '/evenements/' ) ); ?>">
				<?php esc_html_e( 'Voir tout l\'agenda', 'gbecosmolingua' ); ?>
			</a>
		</p>
	</div>
</div>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
