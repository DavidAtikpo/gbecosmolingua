<?php
/**
 * Affichage public page d'accueil — contenu composeur admin.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Layout accueil (meta admin ou défauts).
 *
 * @return array<string, mixed>
 */
function gbecosmolingua_home_composer_layout() {
	if ( class_exists( 'GBE_Home_Composer_Admin' ) ) {
		return GBE_Home_Composer_Admin::get_layout();
	}
	return array();
}

/**
 * URL absolue depuis chemin relatif ou URL complète.
 *
 * @param string $url Chemin ou URL.
 * @return string
 */
function gbecosmolingua_home_composer_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	if ( 0 === strpos( $url, 'http://' ) || 0 === strpos( $url, 'https://' ) || 0 === strpos( $url, '//' ) ) {
		return esc_url( $url );
	}
	return esc_url( home_url( '/' . ltrim( $url, '/' ) ) );
}

/**
 * Style inline background-image pour un item image.
 *
 * @param array<string, mixed> $item Données item.
 * @param string               $size  Taille WP.
 * @return string
 */
function gbecosmolingua_home_bg_style( $item, $size = 'large' ) {
	$url = gbecosmolingua_home_image_url( $item, $size );
	if ( ! $url ) {
		return '';
	}
	return 'background-image:url(' . esc_url( $url ) . ');background-size:cover;background-position:center;background-repeat:no-repeat;';
}

/**
 * Bannière accueil.
 */
function gbecosmolingua_home_render_hero() {
	$layout = gbecosmolingua_home_composer_layout();
	$hero   = $layout['hero'] ?? array();
	$title  = trim( (string) ( $hero['title'] ?? '' ) );
	$lead   = trim( (string) ( $hero['lead'] ?? '' ) );
	if ( '' === $title && '' === $lead ) {
		return;
	}

	$slides  = gbecosmolingua_home_hero_slides();
	$buttons = isset( $hero['buttons'] ) && is_array( $hero['buttons'] ) ? $hero['buttons'] : array();
	$multi   = count( $slides ) > 1;
	?>
	<div class="wp-block-group alignfull gbe-home-hero<?php echo $multi ? ' gbe-home-hero--slider' : ''; ?>"<?php echo $multi ? ' data-gbe-hero-interval="7000"' : ''; ?>>
		<?php if ( ! empty( $slides ) ) : ?>
			<div class="gbe-home-hero__slides" aria-hidden="true">
				<?php foreach ( $slides as $i => $slide ) : ?>
					<div
						class="gbe-home-hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>"
						data-gbe-transition="<?php echo esc_attr( $slide['transition'] ); ?>"
						style="background-image:url(<?php echo esc_url( $slide['url'] ); ?>);"
					></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<div class="gbe-home-hero__scrim" aria-hidden="true"></div>
		<div class="wp-block-group gbe-home-hero__inner">
			<?php if ( $title ) : ?>
				<h1 class="wp-block-heading gbe-home-hero__title"><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<?php if ( $lead ) : ?>
				<p class="gbe-home-hero__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $buttons ) ) : ?>
				<div class="wp-block-buttons gbe-home-hero__actions">
					<?php foreach ( $buttons as $btn ) : ?>
						<?php
						$text = trim( (string) ( $btn['text'] ?? '' ) );
						$href = gbecosmolingua_home_composer_url( $btn['url'] ?? '' );
						if ( '' === $text || '' === $href ) {
							continue;
						}
						$class = 'wp-block-button' . ( ! empty( $btn['outline'] ) ? ' is-style-outline' : '' );
						?>
						<div class="<?php echo esc_attr( $class ); ?>">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $href ); ?>"><?php echo esc_html( $text ); ?></a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $multi ) : ?>
			<div class="gbe-home-hero__nav" role="tablist" aria-label="<?php esc_attr_e( 'Diapositives du bandeau', 'gbecosmolingua' ); ?>">
				<?php foreach ( $slides as $i => $slide ) : ?>
					<button
						type="button"
						class="gbe-home-hero__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
						role="tab"
						aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
						aria-label="<?php echo esc_attr( $slide['label'] ); ?>"
						data-gbe-hero-index="<?php echo esc_attr( (string) $i ); ?>"
					></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Chiffres clés.
 */
function gbecosmolingua_home_render_stats() {
	$layout = gbecosmolingua_home_composer_layout();
	$items  = $layout['stats']['items'] ?? array();
	if ( empty( $items ) ) {
		return;
	}
	?>
	<div class="wp-block-group alignfull gbe-home-stats">
		<div class="wp-block-group gbe-home-stats__grid">
			<?php foreach ( $items as $i => $item ) : ?>
				<?php
				$label = trim( (string) ( $item['label'] ?? '' ) );
				if ( '' === $label ) {
					continue;
				}
				$text    = trim( (string) ( $item['text'] ?? '' ) );
				$stat    = isset( $item['stat'] ) ? (int) $item['stat'] : 0;
				$suffix  = (string) ( $item['suffix'] ?? '' );
				$grouped = ! empty( $item['grouped'] );
				?>
				<div class="wp-block-group gbe-home-stats__item">
					<?php if ( '' !== $text ) : ?>
						<p class="gbe-home-stats__value" data-gbe-text="<?php echo esc_attr( $text ); ?>"><?php echo esc_html( $text ); ?></p>
					<?php else : ?>
						<p class="gbe-home-stats__value"
							data-gbe-stat="<?php echo esc_attr( (string) $stat ); ?>"
							<?php if ( $suffix ) : ?> data-gbe-suffix="<?php echo esc_attr( $suffix ); ?>"<?php endif; ?>
							<?php if ( $grouped ) : ?> data-gbe-grouped="1"<?php endif; ?>
							aria-label="<?php echo esc_attr( $stat . $suffix ); ?>">0<?php echo esc_html( $suffix ); ?></p>
					<?php endif; ?>
					<p class="gbe-home-stats__label"><?php echo esc_html( $label ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Carte interactive.
 */
function gbecosmolingua_home_render_map() {
	$layout = gbecosmolingua_home_composer_layout();
	$map    = $layout['map'] ?? array();
	$title  = trim( (string) ( $map['title'] ?? '' ) );
	if ( '' === $title && empty( $map['kicker'] ) && empty( $map['text'] ) ) {
		return;
	}

	$map_url = gbecosmolingua_home_composer_url( $map['button_url'] ?? '/le-gbe/carte-interactive/' );
	$map_img = gbecosmolingua_home_image_url( array(
		'image_id'   => (int) ( $map['image_id'] ?? 0 ),
		'image_file' => 'map-preview.jpg',
	) );
	$use_photo    = (bool) $map_img;
	$visual_class = 'gbe-home-map__visual' . ( $use_photo ? ' gbe-home-map__visual--photo' : ' gbe-home-map__visual--live' );
	$map_style    = $use_photo ? '--gbe-home-map-photo:url(' . esc_url( $map_img ) . ');' : '';
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-map">
		<div class="wp-block-columns are-vertically-aligned-center gbe-home-map__layout">
			<div class="wp-block-column gbe-home-map__copy">
				<?php if ( ! empty( $map['kicker'] ) ) : ?>
					<p class="gbe-home-map__kicker"><?php echo esc_html( $map['kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="wp-block-heading gbe-home-map__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $map['text'] ) ) : ?>
					<p class="gbe-home-map__text"><?php echo esc_html( $map['text'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $map['button_text'] ) && $map_url ) : ?>
					<div class="wp-block-buttons">
						<div class="wp-block-button">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $map_url ); ?>"><?php echo esc_html( $map['button_text'] ); ?></a>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="wp-block-column gbe-home-map__media">
				<a class="<?php echo esc_attr( $visual_class ); ?>" href="<?php echo esc_url( $map_url ); ?>" style="<?php echo esc_attr( $map_style ); ?>" aria-label="<?php esc_attr_e( 'Ouvrir la carte interactive du continuum gbe en Afrique de l\'Ouest', 'gbecosmolingua' ); ?>">
					<?php if ( ! $use_photo ) : ?>
						<div id="gbe-home-map-preview" class="gbe-home-map__leaflet" aria-hidden="true"></div>
					<?php endif; ?>
					<div class="gbe-home-map__overlay">
						<span class="gbe-home-map__glow gbe-home-map__glow--gh" aria-hidden="true"></span>
						<span class="gbe-home-map__glow gbe-home-map__glow--tg" aria-hidden="true"></span>
						<span class="gbe-home-map__glow gbe-home-map__glow--bj" aria-hidden="true"></span>
						<span class="gbe-home-map__glow gbe-home-map__glow--ng" aria-hidden="true"></span>
						<p class="gbe-home-map__pin gbe-home-map__pin--gh"><span>🇬🇭</span> Ghana</p>
						<p class="gbe-home-map__pin gbe-home-map__pin--tg"><span>🇹🇬</span> Togo</p>
						<p class="gbe-home-map__pin gbe-home-map__pin--bj"><span>🇧🇯</span> Bénin</p>
						<p class="gbe-home-map__pin gbe-home-map__pin--ng"><span>🇳🇬</span> Nigeria</p>
					</div>
				</a>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Langues gbe.
 */
function gbecosmolingua_home_render_langues() {
	$layout  = gbecosmolingua_home_composer_layout();
	$langues = $layout['langues'] ?? array();
	$items   = $langues['items'] ?? array();
	if ( empty( $items ) && empty( $langues['title'] ) ) {
		return;
	}
	$link_url = gbecosmolingua_home_composer_url( $langues['link_url'] ?? '' );
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-langues">
		<div class="wp-block-group gbe-home-section-head">
			<?php if ( ! empty( $langues['kicker'] ) ) : ?>
				<p class="gbe-home-section-kicker"><?php echo esc_html( $langues['kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $langues['title'] ) ) : ?>
				<h2 class="wp-block-heading"><?php echo esc_html( $langues['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $langues['link_text'] ) && $link_url ) : ?>
				<p class="gbe-home-section-link"><a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $langues['link_text'] ); ?></a></p>
			<?php endif; ?>
		</div>
		<div class="wp-block-group gbe-home-langues__grid">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$title = trim( (string) ( $item['title'] ?? '' ) );
				$url   = gbecosmolingua_home_composer_url( $item['url'] ?? '' );
				if ( '' === $title ) {
					continue;
				}
				$slug  = sanitize_html_class( (string) ( $item['css_slug'] ?? 'lang' ) );
				$style = gbecosmolingua_home_bg_style( $item, 'medium_large' );
				$class = 'wp-block-group gbe-home-lang gbe-home-lang--' . $slug;
				?>
				<div class="<?php echo esc_attr( $class ); ?>"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
					<div class="gbe-home-lang__shade"></div>
					<div class="gbe-home-lang__body">
						<h3 class="wp-block-heading">
							<?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a><?php else : ?><?php echo esc_html( $title ); ?><?php endif; ?>
						</h3>
						<?php if ( ! empty( $item['region'] ) ) : ?>
							<p class="gbe-home-lang__region"><?php echo esc_html( $item['region'] ); ?></p>
						<?php endif; ?>
						<?php if ( $url ) : ?>
							<p class="gbe-home-lang__cta"><a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Découvrir', 'gbecosmolingua' ); ?></a></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Patrimoine culturel.
 */
function gbecosmolingua_home_render_culture() {
	$layout  = gbecosmolingua_home_composer_layout();
	$culture = $layout['culture'] ?? array();
	$items   = $culture['items'] ?? array();
	if ( empty( $items ) ) {
		return;
	}
	?>
	<div class="wp-block-group alignfull gbe-home-culture-band">
		<div class="wp-block-group gbe-home-culture-band__inner">
			<?php if ( ! empty( $culture['kicker'] ) ) : ?>
				<p class="gbe-home-section-kicker has-text-align-center"><?php echo esc_html( $culture['kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $culture['title'] ) ) : ?>
				<h2 class="wp-block-heading has-text-align-center gbe-home-culture-band__title"><?php echo esc_html( $culture['title'] ); ?></h2>
			<?php endif; ?>
			<div class="wp-block-group gbe-home-culture__grid">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$label = trim( (string) ( $item['label'] ?? '' ) );
					$url   = gbecosmolingua_home_composer_url( $item['url'] ?? '' );
					if ( '' === $label ) {
						continue;
					}
					?>
					<div class="wp-block-group gbe-home-culture__item">
						<?php if ( ! empty( $item['icon'] ) ) : ?>
							<p class="gbe-home-culture__icon" aria-hidden="true"><?php echo esc_html( $item['icon'] ); ?></p>
						<?php endif; ?>
						<p class="gbe-home-culture__label"><?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a><?php else : ?><?php echo esc_html( $label ); ?><?php endif; ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Bibliothèque numérique.
 */
function gbecosmolingua_home_render_bibliotheque() {
	$layout = gbecosmolingua_home_composer_layout();
	$biblio = $layout['bibliotheque'] ?? array();
	$cards  = $biblio['cards'] ?? array();
	if ( empty( $biblio['title'] ) && empty( $cards ) ) {
		return;
	}
	$btn_url = gbecosmolingua_home_composer_url( $biblio['button_url'] ?? '' );
	?>
	<div class="wp-block-group alignfull gbe-home-biblio">
		<div class="wp-block-group gbe-home-biblio__inner">
			<div class="wp-block-columns are-vertically-aligned-center gbe-home-biblio__layout">
				<div class="wp-block-column gbe-home-biblio__copy">
					<?php if ( ! empty( $biblio['kicker'] ) ) : ?>
						<p class="gbe-home-biblio__kicker"><?php echo esc_html( $biblio['kicker'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $biblio['title'] ) ) : ?>
						<h2 class="wp-block-heading"><?php echo esc_html( $biblio['title'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $biblio['text'] ) ) : ?>
						<p><?php echo esc_html( $biblio['text'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $biblio['button_text'] ) && $btn_url ) : ?>
						<div class="wp-block-buttons">
							<div class="wp-block-button is-style-outline">
								<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $biblio['button_text'] ); ?></a>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="wp-block-column gbe-home-biblio__cards-wrap">
					<div class="wp-block-group gbe-home-biblio__cards">
						<?php foreach ( $cards as $card ) : ?>
							<?php if ( empty( $card['title'] ) ) { continue; } ?>
							<?php $style = gbecosmolingua_home_bg_style( $card, 'medium' ); ?>
							<div class="wp-block-group gbe-home-biblio__card"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
								<div class="gbe-home-biblio__card-shade"></div>
								<div class="gbe-home-biblio__card-body">
									<?php if ( ! empty( $card['count'] ) ) : ?>
										<p class="gbe-home-biblio__count"><?php echo esc_html( $card['count'] ); ?></p>
									<?php endif; ?>
									<p class="gbe-home-biblio__card-title"><?php echo esc_html( $card['title'] ); ?></p>
									<?php if ( ! empty( $card['subtitle'] ) ) : ?>
										<p class="gbe-home-biblio__card-sub"><?php echo esc_html( $card['subtitle'] ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Recherche et innovation.
 */
function gbecosmolingua_home_render_research() {
	$layout   = gbecosmolingua_home_composer_layout();
	$research = $layout['research'] ?? array();
	$tiles    = $research['tiles'] ?? array();
	if ( empty( $research['title'] ) && empty( $tiles ) ) {
		return;
	}
	$link_url = gbecosmolingua_home_composer_url( $research['link_url'] ?? '' );
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-research">
		<div class="gbe-home-section-head gbe-home-research__head">
			<?php if ( ! empty( $research['kicker'] ) ) : ?>
				<p class="gbe-home-section-kicker"><?php echo esc_html( $research['kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $research['title'] ) ) : ?>
				<h2 class="wp-block-heading"><?php echo esc_html( $research['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $research['text'] ) ) : ?>
				<p class="gbe-home-research__text"><?php echo esc_html( $research['text'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $research['link_text'] ) && $link_url ) : ?>
				<p class="gbe-home-section-link"><a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $research['link_text'] ); ?></a></p>
			<?php endif; ?>
		</div>
		<div class="gbe-home-research__grid">
			<?php foreach ( $tiles as $i => $tile ) : ?>
				<?php
				$style = gbecosmolingua_home_bg_style( $tile, 'medium' );
				$class = 'gbe-home-research__tile gbe-home-research__tile--' . ( $i + 1 );
				?>
				<div class="<?php echo esc_attr( $class ); ?>"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?> aria-hidden="true"></div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Actualités et événements.
 */
function gbecosmolingua_home_render_actu() {
	$layout = gbecosmolingua_home_composer_layout();
	$actu   = $layout['actu'] ?? array();
	$news   = $actu['news'] ?? array();
	$events = $actu['events'] ?? array();
	if ( empty( $news ) && empty( $events ) ) {
		return;
	}
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-actu">
		<div class="gbe-home-actu__columns">
			<div class="gbe-home-actu__col gbe-home-actu__col--news">
				<?php if ( ! empty( $actu['news_kicker'] ) ) : ?>
					<p class="gbe-home-section-kicker"><?php echo esc_html( $actu['news_kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $actu['news_title'] ) ) : ?>
					<h2 class="wp-block-heading gbe-home-actu__title"><?php echo esc_html( $actu['news_title'] ); ?></h2>
				<?php endif; ?>
				<div class="gbe-home-actu__news-list">
					<?php foreach ( $news as $item ) : ?>
						<?php
						$title = trim( (string) ( $item['title'] ?? '' ) );
						if ( '' === $title ) {
							continue;
						}
						$url   = gbecosmolingua_home_composer_url( $item['url'] ?? '' );
						$style = gbecosmolingua_home_bg_style( $item, 'medium' );
						?>
						<article class="gbe-home-actu__news-card">
							<div class="gbe-home-actu__news-thumb"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>></div>
							<div class="gbe-home-actu__news-body">
								<?php if ( ! empty( $item['date'] ) ) : ?>
									<p class="gbe-home-actu__date"><?php echo esc_html( $item['date'] ); ?></p>
								<?php endif; ?>
								<h3 class="gbe-home-actu__news-heading">
									<?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a><?php else : ?><?php echo esc_html( $title ); ?><?php endif; ?>
								</h3>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="gbe-home-actu__col gbe-home-actu__col--events">
				<?php if ( ! empty( $actu['events_kicker'] ) ) : ?>
					<p class="gbe-home-section-kicker"><?php echo esc_html( $actu['events_kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $actu['events_title'] ) ) : ?>
					<h2 class="wp-block-heading gbe-home-actu__title"><?php echo esc_html( $actu['events_title'] ); ?></h2>
				<?php endif; ?>
				<div class="gbe-home-actu__events-list">
					<?php foreach ( $events as $item ) : ?>
						<?php
						$title = trim( (string) ( $item['title'] ?? '' ) );
						if ( '' === $title ) {
							continue;
						}
						$url = gbecosmolingua_home_composer_url( $item['url'] ?? '' );
						?>
						<article class="gbe-home-actu__event">
							<?php if ( ! empty( $item['day'] ) || ! empty( $item['month'] ) ) : ?>
								<div class="gbe-home-actu__event-date" aria-hidden="true">
									<span class="gbe-home-actu__event-day"><?php echo esc_html( $item['day'] ?? '' ); ?></span>
									<span class="gbe-home-actu__event-month"><?php echo esc_html( $item['month'] ?? '' ); ?></span>
								</div>
							<?php endif; ?>
							<div class="gbe-home-actu__event-body">
								<h3 class="gbe-home-actu__event-heading">
									<?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a><?php else : ?><?php echo esc_html( $title ); ?><?php endif; ?>
								</h3>
								<?php if ( ! empty( $item['meta'] ) ) : ?>
									<p class="gbe-home-actu__event-meta"><?php echo esc_html( $item['meta'] ); ?></p>
								<?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Galerie bandeau.
 */
function gbecosmolingua_home_render_gallery() {
	$layout = gbecosmolingua_home_composer_layout();
	$block  = $layout['gallery'] ?? array();
	$tiles  = $block['tiles'] ?? array();
	if ( empty( $tiles ) ) {
		return;
	}
	?>
	<div class="wp-block-group alignfull gbe-home-gallery">
		<div class="wp-block-group gbe-home-gallery__head">
			<?php if ( ! empty( $block['kicker'] ) ) : ?>
				<p class="gbe-home-section-kicker has-text-align-center"><?php echo esc_html( $block['kicker'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $block['title'] ) ) : ?>
				<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html( $block['title'] ); ?></h2>
			<?php endif; ?>
		</div>
		<div class="gbe-home-gallery__strip" aria-hidden="true">
			<?php foreach ( $tiles as $i => $tile ) : ?>
				<?php
				$style = gbecosmolingua_home_bg_style( $tile, 'medium_large' );
				$class = 'gbe-home-gallery__tile gbe-home-gallery__tile--' . ( $i + 1 );
				$span  = ! empty( $tile['span'] ) ? ' gbe-home-gallery__tile--span-' . (int) $tile['span'] : '';
				?>
				<div class="<?php echo esc_attr( $class . $span ); ?>"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>></div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Témoignages.
 */
function gbecosmolingua_home_render_testimonials() {
	$layout = gbecosmolingua_home_composer_layout();
	$block  = $layout['testimonials'] ?? array();
	$items  = $block['items'] ?? array();
	if ( empty( $items ) ) {
		return;
	}
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-testimonials">
		<?php if ( ! empty( $block['kicker'] ) ) : ?>
			<p class="gbe-home-section-kicker has-text-align-center"><?php echo esc_html( $block['kicker'] ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $block['title'] ) ) : ?>
			<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html( $block['title'] ); ?></h2>
		<?php endif; ?>
		<div class="wp-block-group gbe-home-testimonials__grid">
			<?php foreach ( $items as $item ) : ?>
				<?php if ( empty( $item['quote'] ) ) { continue; } ?>
				<?php $avatar_style = gbecosmolingua_home_bg_style( $item, 'thumbnail' ); ?>
				<div class="wp-block-group gbe-home-testimonial">
					<?php if ( $avatar_style ) : ?>
						<div class="gbe-home-testimonial__avatar" style="<?php echo esc_attr( $avatar_style ); ?>"></div>
					<?php endif; ?>
					<p class="gbe-home-testimonial__quote"><?php echo esc_html( $item['quote'] ); ?></p>
					<?php if ( ! empty( $item['name'] ) || ! empty( $item['role'] ) ) : ?>
						<p class="gbe-home-testimonial__meta">
							<strong><?php echo esc_html( $item['name'] ?? '' ); ?></strong>
							<?php if ( ! empty( $item['role'] ) ) : ?><span><?php echo esc_html( $item['role'] ); ?></span><?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Mise en avant Xótùtù (patrimoine oral).
 */
function gbecosmolingua_home_render_xotutu() {
	$layout = gbecosmolingua_home_composer_layout();
	$block  = $layout['xotutu'] ?? array();
	$title  = trim( (string) ( $block['title'] ?? '' ) );
	if ( '' === $title && empty( $block['text'] ) ) {
		return;
	}

	$hub_url    = gbecosmolingua_home_composer_url( $block['button_url'] ?? '/xotutu/' );
	$genres     = function_exists( 'gbecosmolingua_xotutu_genres_highlight' ) ? gbecosmolingua_xotutu_genres_highlight() : array();
	$featured   = function_exists( 'gbecosmolingua_xotutu_featured_resource' ) ? gbecosmolingua_xotutu_featured_resource() : array();
	$collections = function_exists( 'gbecosmolingua_xotutu_collections' ) ? array_slice( gbecosmolingua_xotutu_collections(), 0, 3 ) : array();
	$hero_style = function_exists( 'gbecosmolingua_xotutu_hero_image_style' )
		? gbecosmolingua_xotutu_hero_image_style( '--gbe-home-xotutu-image' )
		: '';
	?>
	<div class="wp-block-group alignfull gbe-home-xotutu" style="<?php echo esc_attr( $hero_style ); ?>">
		<div class="wp-block-group gbe-home-xotutu__inner">
			<div class="gbe-home-xotutu__layout">
				<div class="gbe-home-xotutu__copy">
					<?php if ( ! empty( $block['kicker'] ) ) : ?>
						<p class="gbe-home-section-kicker"><?php echo esc_html( $block['kicker'] ); ?></p>
					<?php endif; ?>
					<?php if ( $title ) : ?>
						<h2 class="wp-block-heading"><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $block['text'] ) ) : ?>
						<p class="gbe-home-xotutu__text"><?php echo esc_html( $block['text'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $block['button_text'] ) && $hub_url ) : ?>
						<div class="wp-block-buttons">
							<div class="wp-block-button">
								<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $hub_url ); ?>"><?php echo esc_html( $block['button_text'] ); ?></a>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $featured['title'] ) ) : ?>
						<div class="gbe-home-xotutu__featured">
							<p class="gbe-home-xotutu__featured-kicker"><?php esc_html_e( 'Ressource du jour', 'gbecosmolingua' ); ?></p>
							<h3><?php echo esc_html( $featured['title'] ); ?></h3>
							<?php if ( ! empty( $featured['meta'] ) ) : ?>
								<p class="gbe-home-xotutu__featured-meta"><?php echo esc_html( $featured['meta'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $featured['excerpt'] ) ) : ?>
								<p><?php echo esc_html( $featured['excerpt'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $featured['url'] ) ) : ?>
								<p><a href="<?php echo esc_url( $featured['url'] ); ?>"><?php esc_html_e( 'Écouter →', 'gbecosmolingua' ); ?></a></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="gbe-home-xotutu__aside">
					<?php if ( ! empty( $genres ) ) : ?>
						<h3 class="gbe-home-xotutu__genres-title"><?php esc_html_e( 'Genres folkloriques', 'gbecosmolingua' ); ?></h3>
						<div class="gbe-home-xotutu__genres">
							<?php foreach ( $genres as $genre ) : ?>
								<a class="gbe-home-xotutu__genre" href="<?php echo esc_url( $genre['url'] ); ?>">
									<span class="gbe-home-xotutu__genre-letter"><?php echo esc_html( mb_substr( $genre['title'], 0, 1 ) ); ?></span>
									<span class="gbe-home-xotutu__genre-name"><?php echo esc_html( $genre['title'] ); ?></span>
									<span class="gbe-home-xotutu__genre-sub"><?php echo esc_html( $genre['subtitle'] ); ?></span>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $collections ) ) : ?>
						<div class="gbe-home-xotutu__collections">
							<?php foreach ( $collections as $card ) : ?>
								<a class="gbe-home-xotutu__collection" href="<?php echo esc_url( $card['url'] ); ?>">
									<span aria-hidden="true"><?php echo esc_html( $card['icon'] ); ?></span>
									<span><?php echo esc_html( $card['title'] ); ?></span>
									<strong><?php echo esc_html( $card['count'] ); ?></strong>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Partenaires.
 */
function gbecosmolingua_home_render_partners() {
	$layout   = gbecosmolingua_home_composer_layout();
	$partners = $layout['partners'] ?? array();
	$title    = trim( (string) ( $partners['title'] ?? '' ) );
	$limit    = isset( $partners['limit'] ) ? max( 1, min( 24, (int) $partners['limit'] ) ) : 8;
	if ( '' === $title ) {
		return;
	}
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-partners">
		<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html( $title ); ?></h2>
		<?php echo do_shortcode( '[gbe_partenaires limit="' . $limit . '"]' ); ?>
	</div>
	<?php
}

/**
 * Appel à l'action.
 */
function gbecosmolingua_home_render_cta() {
	$layout  = gbecosmolingua_home_composer_layout();
	$cta     = $layout['cta'] ?? array();
	$title   = trim( (string) ( $cta['title'] ?? '' ) );
	$buttons = $cta['buttons'] ?? array();
	if ( '' === $title && empty( $buttons ) ) {
		return;
	}
	?>
	<div class="wp-block-group alignfull gbe-home-cta">
		<div class="wp-block-group">
			<?php if ( $title ) : ?>
				<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $buttons ) ) : ?>
				<div class="wp-block-buttons">
					<?php foreach ( $buttons as $btn ) : ?>
						<?php
						$text = trim( (string) ( $btn['text'] ?? '' ) );
						$href = gbecosmolingua_home_composer_url( $btn['url'] ?? '' );
						if ( '' === $text || '' === $href ) {
							continue;
						}
						$class = 'wp-block-button' . ( ! empty( $btn['outline'] ) ? ' is-style-outline' : '' );
						?>
						<div class="<?php echo esc_attr( $class ); ?>">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $href ); ?>"><?php echo esc_html( $text ); ?></a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
