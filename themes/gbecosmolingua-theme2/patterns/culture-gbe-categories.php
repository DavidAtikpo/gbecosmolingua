<?php
/**
 * Title: Cultures Gbe — Plan des rubriques
 * Slug: gbecosmolingua/culture-gbe-categories
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$sections = gbecosmolingua_culture_hub_sections();
$more     = gbecosmolingua_culture_hub_more_links();

ob_start();
?>
<nav id="gbe-culture-categories" class="gbe-section gbe-culture-sitemap alignwide" aria-label="<?php esc_attr_e( 'Rubriques Cultures Gbe', 'gbecosmolingua' ); ?>">
	<div class="gbe-culture-sitemap__grid">
		<?php foreach ( $sections as $section ) : ?>
			<div class="gbe-culture-sitemap__col">
				<h2 class="gbe-culture-sitemap__title">
					<a href="#<?php echo esc_attr( $section['id'] ); ?>"><?php echo esc_html( $section['title'] ); ?></a>
				</h2>
				<?php if ( ! empty( $section['items'] ) ) : ?>
					<ul class="gbe-culture-sitemap__list">
						<?php foreach ( $section['items'] as $item ) : ?>
							<li>
								<a href="<?php echo esc_url( gbecosmolingua_culture_page_url( $item['slug'] ) ); ?>">
									<?php echo esc_html( $item['label'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p class="gbe-culture-sitemap__teaser">
						<a href="<?php echo esc_url( gbecosmolingua_culture_page_url( $section['slug'] ) ); ?>">
							<?php esc_html_e( 'Découvrir →', 'gbecosmolingua' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<div class="gbe-culture-sitemap__col gbe-culture-sitemap__col--more">
			<p class="gbe-culture-sitemap__more-label">
				<a href="#gbe-culture-voir-plus"><?php esc_html_e( 'Voir plus', 'gbecosmolingua' ); ?></a>
			</p>
			<ul class="gbe-culture-sitemap__list gbe-culture-sitemap__list--more">
				<?php foreach ( $more as $link ) : ?>
					<li>
						<a href="<?php echo esc_url( gbecosmolingua_culture_page_url( $link['slug'] ) ); ?>">
							<?php echo esc_html( $link['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
