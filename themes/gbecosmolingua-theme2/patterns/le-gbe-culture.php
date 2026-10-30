<?php
/**
 * Title: Gbe — Patrimoine culturel
 * Slug: gbecosmolingua/le-gbe-culture
 * Categories: gbecosmolingua
 * Inserter: false
 *
 * @package GbeCosmoLingua
 */

$items = array(
	array(
		'icon'  => '🏺',
		'title' => 'Arts',
		'url'   => '/cultures-gbe/arts/',
		'desc'  => 'Sculpture, artisanat et création visuelle.',
	),
	array(
		'icon'  => '🥁',
		'title' => 'Musique',
		'url'   => '/cultures-gbe/musique/',
		'desc'  => 'Chants, instruments et musiques rituelles.',
	),
	array(
		'icon'  => '📖',
		'title' => 'Littérature',
		'url'   => '/xotutu/',
		'desc'  => 'Tradition orale et genres Xótùtù.',
	),
	array(
		'icon'  => '🕯',
		'title' => 'Spiritualités',
		'url'   => '/cultures-gbe/croyances-et-cosmologies/',
		'desc'  => 'Croyances, vodun et cosmologies.',
	),
	array(
		'icon'  => '🍲',
		'title' => 'Gastronomie',
		'url'   => '/cultures-gbe/gastronomie/',
		'desc'  => 'Saveurs et patrimoine alimentaire.',
	),
	array(
		'icon'  => '🎭',
		'title' => 'Fêtes',
		'url'   => '/cultures-gbe/fetes-et-ceremonies/',
		'desc'  => 'Cérémonies et célébrations communautaires.',
	),
);
?>
<!-- wp:group {"align":"wide","className":"gbe-section gbe-le-gbe-culture","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide gbe-section gbe-le-gbe-culture">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">Le patrimoine culturel</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"gbe-le-gbe-culture__grid","layout":{"type":"default"}} -->
	<div class="wp-block-group gbe-le-gbe-culture__grid">
		<?php foreach ( $items as $item ) : ?>
		<!-- wp:group {"className":"gbe-le-gbe-culture__item","layout":{"type":"constrained"}} -->
		<div class="wp-block-group gbe-le-gbe-culture__item">
			<!-- wp:paragraph {"className":"gbe-le-gbe-culture__icon"} -->
			<p class="gbe-le-gbe-culture__icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html( $item['desc'] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
