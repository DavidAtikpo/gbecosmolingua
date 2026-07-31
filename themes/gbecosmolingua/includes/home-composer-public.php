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

	$bg_id   = (int) ( $hero['bg_id'] ?? 0 );
	$hero_url = '';
	if ( $bg_id ) {
		$hero_url = wp_get_attachment_image_url( $bg_id, 'full' );
	}
	if ( ! $hero_url ) {
		$hero_path = get_stylesheet_directory() . '/assets/images/home/hero-patrimoine.jpg';
		if ( file_exists( $hero_path ) ) {
			$hero_url = get_stylesheet_directory_uri() . '/assets/images/home/hero-patrimoine.jpg';
		}
	}
	$hero_var = $hero_url ? '--gbe-home-hero-image:url(' . esc_url( $hero_url ) . ');' : '';
	$buttons  = isset( $hero['buttons'] ) && is_array( $hero['buttons'] ) ? $hero['buttons'] : array();
	?>
	<div class="wp-block-group alignfull gbe-home-hero" style="<?php echo esc_attr( $hero_var ); ?>">
		<div class="wp-block-group">
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
		<div class="wp-block-group">
			<div class="wp-block-group gbe-home-stats__grid">
				<?php foreach ( $items as $item ) : ?>
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

	$image_id = (int) ( $map['image_id'] ?? 0 );
	$map_url  = gbecosmolingua_home_composer_url( $map['button_url'] ?? '/le-gbe/carte-interactive/' );
	$map_img  = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
	if ( ! $map_img ) {
		$map_path = get_stylesheet_directory() . '/assets/images/home/map-preview.jpg';
		if ( file_exists( $map_path ) ) {
			$map_img = get_stylesheet_directory_uri() . '/assets/images/home/map-preview.jpg';
		}
	}
	$use_photo    = (bool) $map_img;
	$visual_class = 'gbe-home-map__visual' . ( $use_photo ? ' gbe-home-map__visual--photo' : ' gbe-home-map__visual--live' );
	$map_style    = $use_photo ? '--gbe-home-map-photo:url(' . esc_url( $map_img ) . ');' : '';
	?>
	<div class="wp-block-group alignwide gbe-section gbe-home-map">
		<div class="wp-block-columns are-vertically-aligned-center gbe-home-map__layout">
			<div class="wp-block-column" style="flex-basis:45%">
				<?php if ( ! empty( $map['kicker'] ) ) : ?>
					<p class="gbe-home-map__kicker"><?php echo esc_html( $map['kicker'] ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="wp-block-heading"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $map['text'] ) ) : ?>
					<p><?php echo esc_html( $map['text'] ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $map['button_text'] ) && $map_url ) : ?>
					<div class="wp-block-buttons">
						<div class="wp-block-button">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $map_url ); ?>"><?php echo esc_html( $map['button_text'] ); ?></a>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="wp-block-column" style="flex-basis:55%">
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
			<?php if ( ! empty( $langues['title'] ) ) : ?>
				<h2 class="wp-block-heading"><?php echo esc_html( $langues['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $langues['link_text'] ) && $link_url ) : ?>
				<p><a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $langues['link_text'] ); ?></a></p>
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
				$slug = sanitize_html_class( (string) ( $item['css_slug'] ?? 'lang' ) );
				?>
				<div class="wp-block-group gbe-home-lang gbe-home-lang--<?php echo esc_attr( $slug ); ?>">
					<h3 class="wp-block-heading">
						<?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a><?php else : ?><?php echo esc_html( $title ); ?><?php endif; ?>
					</h3>
					<?php if ( ! empty( $item['region'] ) ) : ?>
						<p><?php echo esc_html( $item['region'] ); ?></p>
					<?php endif; ?>
					<?php if ( $url ) : ?>
						<p><a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Découvrir →', 'gbecosmolingua' ); ?></a></p>
					<?php endif; ?>
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
		<div class="wp-block-group">
			<?php if ( ! empty( $culture['title'] ) ) : ?>
				<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html( $culture['title'] ); ?></h2>
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
						<p><?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a><?php else : ?><?php echo esc_html( $label ); ?><?php endif; ?></p>
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
		<div class="wp-block-group">
			<div class="wp-block-columns are-vertically-aligned-center">
				<div class="wp-block-column" style="flex-basis:42%">
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
				<div class="wp-block-column" style="flex-basis:58%">
					<div class="wp-block-group gbe-home-biblio__cards">
						<?php foreach ( $cards as $card ) : ?>
							<?php if ( empty( $card['title'] ) ) { continue; } ?>
							<div class="wp-block-group gbe-home-biblio__card">
								<p><strong><?php echo esc_html( $card['title'] ); ?></strong><br><?php echo esc_html( $card['subtitle'] ?? '' ); ?></p>
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
 * Galerie bandeau.
 */
function gbecosmolingua_home_render_gallery() {
	$layout = gbecosmolingua_home_composer_layout();
	$tiles  = $layout['gallery']['tiles'] ?? array();
	if ( empty( $tiles ) ) {
		return;
	}
	?>
	<div class="gbe-home-gallery__strip" aria-hidden="true">
		<?php foreach ( $tiles as $i => $tile ) : ?>
			<?php
			$image_id = (int) ( $tile['image_id'] ?? 0 );
			$style    = '';
			$class    = 'gbe-home-gallery__tile gbe-home-gallery__tile--' . ( $i + 1 );
			if ( $image_id ) {
				$url = wp_get_attachment_image_url( $image_id, 'medium_large' );
				if ( $url ) {
					$style = 'background-image:url(' . esc_url( $url ) . ');';
				}
			}
			?>
			<div class="<?php echo esc_attr( $class ); ?>"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>></div>
		<?php endforeach; ?>
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
		<?php if ( ! empty( $block['title'] ) ) : ?>
			<h2 class="wp-block-heading has-text-align-center"><?php echo esc_html( $block['title'] ); ?></h2>
		<?php endif; ?>
		<div class="wp-block-group gbe-home-testimonials__grid">
			<?php foreach ( $items as $item ) : ?>
				<?php if ( empty( $item['quote'] ) ) { continue; } ?>
				<div class="wp-block-group gbe-home-testimonial">
					<p><?php echo esc_html( $item['quote'] ); ?></p>
					<?php if ( ! empty( $item['name'] ) || ! empty( $item['role'] ) ) : ?>
						<p class="gbe-home-testimonial__meta"><strong><?php echo esc_html( $item['name'] ?? '' ); ?></strong><?php if ( ! empty( $item['role'] ) ) : ?> — <?php echo esc_html( $item['role'] ); ?><?php endif; ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
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
