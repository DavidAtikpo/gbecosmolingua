<?php
/**
 * Title: Xótùtù — Corps du hub
 * Slug: gbecosmolingua/xotutu-hub-main
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$collections = gbecosmolingua_xotutu_collections();
$genres      = gbecosmolingua_xotutu_genres_highlight();
$themes      = gbecosmolingua_xotutu_theme_pills();
$stats       = gbecosmolingua_xotutu_stats();
$featured    = gbecosmolingua_xotutu_featured_resource();
$biblio_url  = gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'bibliotheque-numerique-xotutu' );
$carte_url   = home_url( '/le-gbe/carte-interactive/' );
$contrib_url = home_url( '/nous-soutenir/proposer-un-projet/' );

ob_start();
?>
<div class="gbe-xotutu-hub">
	<?php gbecosmolingua_xotutu_render_search(); ?>

	<section class="gbe-xotutu-section gbe-xotutu-collections" id="gbe-xotutu-collections">
		<div class="gbe-xotutu-section__head">
			<h2><?php esc_html_e( 'Collections principales', 'gbecosmolingua' ); ?></h2>
			<a href="<?php echo esc_url( gbecosmolingua_xotutu_page_url( 'archives-numeriques' ) ); ?>"><?php esc_html_e( 'Voir toutes les collections →', 'gbecosmolingua' ); ?></a>
		</div>
		<div class="gbe-xotutu-collections__grid">
			<?php foreach ( $collections as $card ) : ?>
				<?php
				$style = gbecosmolingua_xotutu_image_style( $card['image'], '--gbe-xotutu-card-image' );
				?>
				<a class="gbe-xotutu-collection gbe-xotutu-collection--<?php echo esc_attr( $card['mod'] ); ?>" href="<?php echo esc_url( $card['url'] ); ?>" style="<?php echo esc_attr( $style ); ?>">
					<span class="gbe-xotutu-collection__icon" aria-hidden="true"><?php echo esc_html( $card['icon'] ); ?></span>
					<span class="gbe-xotutu-collection__title"><?php echo esc_html( $card['title'] ); ?></span>
					<span class="gbe-xotutu-collection__count"><?php echo esc_html( $card['count'] ); ?> <?php esc_html_e( 'ressources', 'gbecosmolingua' ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="gbe-xotutu-section gbe-xotutu-genres">
		<div class="gbe-xotutu-section__head">
			<h2><?php esc_html_e( 'Les grands genres folkloriques', 'gbecosmolingua' ); ?></h2>
			<a href="<?php echo esc_url( gbecosmolingua_xotutu_page_url( 'genres-folkloriques' ) ); ?>"><?php esc_html_e( 'Voir tous les genres →', 'gbecosmolingua' ); ?></a>
		</div>
		<div class="gbe-xotutu-genres__row">
			<?php foreach ( $genres as $genre ) : ?>
				<a class="gbe-xotutu-genre" href="<?php echo esc_url( $genre['url'] ); ?>">
					<span class="gbe-xotutu-genre__circle"><?php echo esc_html( mb_substr( $genre['title'], 0, 1 ) ); ?></span>
					<span class="gbe-xotutu-genre__title"><?php echo esc_html( $genre['title'] ); ?></span>
					<span class="gbe-xotutu-genre__subtitle"><?php echo esc_html( $genre['subtitle'] ); ?></span>
					<span class="gbe-xotutu-genre__count"><?php echo esc_html( $genre['count'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="gbe-xotutu-section gbe-xotutu-themes">
		<h2><?php esc_html_e( 'Explorer par thème', 'gbecosmolingua' ); ?></h2>
		<div class="gbe-xotutu-themes__scroll">
			<?php foreach ( $themes as $pill ) : ?>
				<a class="gbe-xotutu-theme-pill" href="<?php echo esc_url( $pill['url'] ); ?>"><?php echo esc_html( $pill['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="gbe-xotutu-section gbe-xotutu-split">
		<div class="gbe-xotutu-featured">
			<p class="gbe-xotutu-featured__kicker"><?php esc_html_e( 'Ressource du jour', 'gbecosmolingua' ); ?></p>
			<h3><?php echo esc_html( $featured['title'] ); ?></h3>
			<p class="gbe-xotutu-featured__meta"><?php echo esc_html( $featured['meta'] ); ?></p>
			<p class="gbe-xotutu-featured__excerpt"><?php echo esc_html( $featured['excerpt'] ); ?></p>
			<div class="gbe-xotutu-featured__tags">
				<?php if ( $featured['has_audio'] ) : ?>
					<span><?php esc_html_e( 'Audio', 'gbecosmolingua' ); ?></span>
				<?php endif; ?>
				<span><?php esc_html_e( 'Transcription', 'gbecosmolingua' ); ?></span>
				<span><?php esc_html_e( 'Traduction', 'gbecosmolingua' ); ?></span>
			</div>
			<a class="gbe-xotutu-featured__listen" href="<?php echo esc_url( $featured['url'] ); ?>"><?php esc_html_e( 'Écouter', 'gbecosmolingua' ); ?></a>
		</div>
		<div class="gbe-xotutu-biblio-preview">
			<div class="gbe-xotutu-section__head">
				<h3><?php esc_html_e( 'Bibliothèque numérique', 'gbecosmolingua' ); ?></h3>
				<a href="<?php echo esc_url( $biblio_url ); ?>"><?php esc_html_e( 'Voir toute la bibliothèque →', 'gbecosmolingua' ); ?></a>
			</div>
			<div class="gbe-xotutu-biblio-preview__tabs" role="tablist">
				<span class="is-active"><?php esc_html_e( 'Livres et manuscrits', 'gbecosmolingua' ); ?></span>
				<span><?php esc_html_e( 'Archives audio', 'gbecosmolingua' ); ?></span>
				<span><?php esc_html_e( 'Vidéos', 'gbecosmolingua' ); ?></span>
				<span><?php esc_html_e( 'Photos', 'gbecosmolingua' ); ?></span>
			</div>
			<div class="gbe-xotutu-biblio-preview__covers">
				<a href="<?php echo esc_url( $biblio_url ); ?>"><?php esc_html_e( 'Contes d\'Agandjin', 'gbecosmolingua' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/paremiologie/banque-numerique-proverbes/' ) ); ?>"><?php esc_html_e( 'Proverbes et dictons', 'gbecosmolingua' ); ?></a>
				<a href="<?php echo esc_url( gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'corpus-textuels' ) ); ?>"><?php esc_html_e( 'Corpus manuscrits', 'gbecosmolingua' ); ?></a>
			</div>
		</div>
	</section>

	<section class="gbe-xotutu-section gbe-xotutu-split gbe-xotutu-map-stats">
		<div class="gbe-xotutu-map">
			<h3><?php esc_html_e( 'Carte du patrimoine', 'gbecosmolingua' ); ?></h3>
			<p><?php esc_html_e( 'Explorez les contes, chants, sites sacrés et archives géolocalisés du continuum gbe.', 'gbecosmolingua' ); ?></p>
			<a class="gbe-xotutu-map__cta" href="<?php echo esc_url( $carte_url ); ?>"><?php esc_html_e( 'Explorer la carte interactive', 'gbecosmolingua' ); ?></a>
			<ul class="gbe-xotutu-map__legend">
				<li><?php esc_html_e( 'Contes', 'gbecosmolingua' ); ?></li>
				<li><?php esc_html_e( 'Chants', 'gbecosmolingua' ); ?></li>
				<li><?php esc_html_e( 'Proverbes', 'gbecosmolingua' ); ?></li>
				<li><?php esc_html_e( 'Sites sacrés', 'gbecosmolingua' ); ?></li>
			</ul>
		</div>
		<div class="gbe-xotutu-stats">
			<div class="gbe-xotutu-stats__grid">
				<?php foreach ( $stats as $stat ) : ?>
					<div class="gbe-xotutu-stats__item">
						<p class="gbe-xotutu-stats__value" <?php echo isset( $stat['stat'] ) ? 'data-gbe-stat="' . esc_attr( (string) $stat['stat'] ) . '" data-gbe-suffix="' . esc_attr( $stat['suffix'] ?? '' ) . '"' : ''; ?>>
							<?php echo esc_html( $stat['value'] ); ?>
						</p>
						<p class="gbe-xotutu-stats__label"><?php echo esc_html( $stat['label'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="gbe-xotutu-section gbe-xotutu-publications">
		<div class="gbe-xotutu-section__head">
			<h2><?php esc_html_e( 'Dernières publications', 'gbecosmolingua' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/actualites/' ) ); ?>"><?php esc_html_e( 'Voir toutes les publications →', 'gbecosmolingua' ); ?></a>
		</div>
		<?php echo do_shortcode( '[gbe_actualites limit="4"]' ); ?>
	</section>

	<section class="gbe-xotutu-contribute">
		<div class="gbe-xotutu-contribute__inner">
			<h2><?php esc_html_e( 'Contribuer au patrimoine gbe', 'gbecosmolingua' ); ?></h2>
			<p><?php esc_html_e( 'Vous possédez des chants, des contes ou des archives ? Partagez-les et participez à la préservation de notre héritage commun.', 'gbecosmolingua' ); ?></p>
			<a class="gbe-xotutu-contribute__btn" href="<?php echo esc_url( $contrib_url ); ?>"><?php esc_html_e( 'Déposer une ressource', 'gbecosmolingua' ); ?></a>
		</div>
	</section>
</div>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
