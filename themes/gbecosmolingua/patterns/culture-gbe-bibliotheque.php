<?php
/**
 * Title: Cultures Gbe — Bibliothèque
 * Slug: gbecosmolingua/culture-gbe-bibliotheque
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$items = array(
	array( 'icon' => '📚', 'label' => 'Livres', 'path' => '/bibliotheque/' ),
	array( 'icon' => '🎧', 'label' => 'Archives audio', 'path' => '/bibliotheque/' ),
	array( 'icon' => '🎬', 'label' => 'Vidéos', 'path' => '/bibliotheque/' ),
	array( 'icon' => '📄', 'label' => 'Articles scientifiques', 'path' => '/recherches/' ),
	array( 'icon' => '🖼', 'label' => 'Expositions virtuelles', 'path' => '/bibliotheque/' ),
);

ob_start();
?>
<div class="gbe-section gbe-culture-bibliotheque alignwide">
	<h2 class="has-text-align-center">Bibliothèque culturelle</h2>
	<p class="gbe-culture-block__intro has-text-align-center">Livres, archives, vidéos et ressources numériques pour approfondir les cultures gbe.</p>
	<div class="gbe-culture-bibliotheque__grid">
		<?php foreach ( $items as $item ) : ?>
			<div class="gbe-culture-bibliotheque__item">
				<span class="gbe-culture-bibliotheque__icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></span>
				<span class="gbe-culture-bibliotheque__label"><?php echo esc_html( $item['label'] ); ?></span>
				<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( home_url( $item['path'] ) ); ?>">
					<?php esc_html_e( 'Accéder', 'gbecosmolingua' ); ?>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="has-text-align-center gbe-culture-galerie-agenda__cta">
		<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( home_url( '/bibliotheque/' ) ); ?>">
			<?php esc_html_e( 'Voir toute la bibliothèque', 'gbecosmolingua' ); ?>
		</a>
	</p>
</div>
<?php
$html = ob_get_clean();
?>
<!-- wp:html -->
<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<!-- /wp:html -->
