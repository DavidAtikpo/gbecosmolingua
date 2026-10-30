<?php
/**
 * Affichage public des pages hub — contenu enregistré par l'admin uniquement.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Slug de la page hub affichée.
 *
 * @return string
 */
function gbecosmolingua_hub_composer_current_slug() {
	if ( is_page() ) {
		global $post;
		if ( $post instanceof WP_Post && class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
			if ( in_array( $post->post_name, GBE_Le_Gbe_Hub_Admin::main_menu_slugs(), true ) ) {
				return $post->post_name;
			}
		}
	}
	return '';
}

/**
 * Page hub par slug.
 *
 * @param string $slug Slug page.
 * @return WP_Post|null
 */
function gbecosmolingua_hub_composer_page( $slug = '' ) {
	if ( '' === $slug ) {
		$slug = gbecosmolingua_hub_composer_current_slug();
	}
	if ( '' === $slug ) {
		return null;
	}
	if ( class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		return GBE_Le_Gbe_Hub_Admin::get_hub_page( $slug );
	}
	return gbecosmolingua_public_hub_page( $slug );
}

/**
 * Meta layout enregistrée pour une page hub.
 *
 * @param int $page_id ID page.
 * @return array{bands: array<int, array<string, mixed>>, more: array<int, array<string, mixed>>}
 */
function gbecosmolingua_hub_composer_layout( $page_id = 0 ) {
	if ( ! $page_id && class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		$page = gbecosmolingua_hub_composer_page();
		$page_id = $page ? (int) $page->ID : 0;
	}
	if ( ! $page_id || ! class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		return array(
			'bands' => array(),
			'more'  => array(),
		);
	}

	$layout = GBE_Le_Gbe_Hub_Admin::get_hub_page_layout( $page_id );
	return array(
		'bands' => ( isset( $layout['bands'] ) && is_array( $layout['bands'] ) ) ? $layout['bands'] : array(),
		'more'  => ( isset( $layout['more'] ) && is_array( $layout['more'] ) ) ? $layout['more'] : array(),
	);
}

/**
 * Diapositives hero enregistrées.
 *
 * @param string $slug Slug hub.
 * @return array<int, array{bg_id: int, title: string, lead: string, overlay: string}>
 */
function gbecosmolingua_hub_composer_hero_slides( $slug = '' ) {
	$page = gbecosmolingua_hub_composer_page( $slug );
	if ( ! $page || ! class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		return array();
	}

	return GBE_Le_Gbe_Hub_Admin::get_hub_hero_slides( (int) $page->ID );
}

/**
 * URL bouton d'une bande ou carte.
 *
 * @param array<string, mixed> $row Ligne layout.
 * @return string
 */
function gbecosmolingua_hub_composer_row_url( $row ) {
	if ( ! empty( $row['button_url'] ) ) {
		return esc_url( $row['button_url'] );
	}
	return '';
}

/**
 * Slug police effectif pour une section (section → page → thème).
 *
 * @param string $band_font Valeur section.
 * @param int    $page_id   ID page hub.
 * @return string
 */
function gbecosmolingua_hub_section_font_slug( $band_font, $page_id = 0 ) {
	$font = sanitize_key( (string) $band_font );

	if ( '' === $font && $page_id && class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		$font = sanitize_key( (string) get_post_meta( $page_id, GBE_Le_Gbe_Hub_Admin::META_SECTIONS_FONT, true ) );
	}

	if ( '' === $font || 'theme' === $font ) {
		return '';
	}

	if ( class_exists( 'GBE_Le_Gbe_Hub_Admin' ) && ! array_key_exists( $font, GBE_Le_Gbe_Hub_Admin::section_font_choices() ) ) {
		return '';
	}

	return $font;
}

/**
 * Classe CSS pour une police de section.
 *
 * @param string $font_slug Slug police.
 * @return string
 */
function gbecosmolingua_hub_section_font_class( $font_slug ) {
	if ( '' === $font_slug ) {
		return '';
	}
	return 'gbe-hub-font--' . sanitize_html_class( $font_slug );
}

/**
 * Affiche la bannière hub.
 *
 * @param string $slug Slug hub.
 */
function gbecosmolingua_hub_render_public_hero( $slug = '' ) {
	if ( '' === $slug ) {
		$slug = gbecosmolingua_hub_composer_current_slug();
	}

	$page   = gbecosmolingua_hub_composer_page( $slug );
	$slides = gbecosmolingua_hub_composer_hero_slides( $slug );
	$figure = 0;

	if ( $page && class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		$figure = (int) get_post_meta( $page->ID, GBE_Le_Gbe_Hub_Admin::META_HERO_FIGURE, true );
	}

	$page_title = $page ? $page->post_title : '';
	$figure_url = $figure ? wp_get_attachment_image_url( $figure, 'large' ) : '';

	if ( empty( $slides ) && ! $figure_url && '' === $page_title ) {
		return;
	}

	$is_carousel = count( $slides ) > 1;
	$hero_class  = 'wp-block-group alignfull gbe-le-gbe-hero gbe-hub-hero gbe-hub-hero--' . sanitize_html_class( $slug );
	if ( $is_carousel ) {
		$hero_class .= ' gbe-le-gbe-hero--carousel';
	} elseif ( ! empty( $slides ) ) {
		$url = wp_get_attachment_image_url( (int) $slides[0]['bg_id'], 'full' );
		if ( $url ) {
			$hero_class .= ' gbe-le-gbe-hero--carousel';
		}
	}

	$inline_style = '';
	if ( ! $is_carousel && ! empty( $slides[0]['bg_id'] ) ) {
		$url = wp_get_attachment_image_url( (int) $slides[0]['bg_id'], 'full' );
		if ( $url ) {
			$inline_style = '--gbe-le-gbe-hero-image:url(' . esc_url( $url ) . ');';
		}
	}
	?>
	<div class="<?php echo esc_attr( $hero_class ); ?>"<?php echo $inline_style ? ' style="' . esc_attr( $inline_style ) . '"' : ''; ?> data-interval="12000">
		<?php if ( $is_carousel ) : ?>
			<div class="gbe-le-gbe-hero__slides" aria-hidden="true">
				<?php foreach ( $slides as $i => $slide ) : ?>
					<?php
					$bg_url = wp_get_attachment_image_url( (int) $slide['bg_id'], 'full' );
					if ( ! $bg_url ) {
						continue;
					}
					$slide_class = 'gbe-le-gbe-hero__slide';
					if ( 0 === $i ) {
						$slide_class .= ' is-active';
					}
					$slide_class .= 'light' === $slide['overlay'] ? ' gbe-le-gbe-hero__slide--overlay-light' : ' gbe-le-gbe-hero__slide--overlay-dark';
					?>
					<div class="<?php echo esc_attr( $slide_class ); ?>">
						<div class="gbe-le-gbe-hero__slide-bg" style="<?php echo esc_attr( '--gbe-le-gbe-slide-image:url(' . esc_url( $bg_url ) . ');' ); ?>"></div>
						<div class="gbe-le-gbe-hero__slide-overlay"></div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="gbe-le-gbe-hero__inner">
			<div class="gbe-le-gbe-hero__layout wp-block-columns are-vertically-aligned-center">
				<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%">
					<?php if ( $is_carousel ) : ?>
						<div class="gbe-le-gbe-hero__text-slides">
							<?php foreach ( $slides as $i => $slide ) : ?>
								<?php
								$title = '' !== $slide['title'] ? $slide['title'] : $page_title;
								$class = 'gbe-le-gbe-hero__text-slide' . ( 0 === $i ? ' is-active' : '' );
								?>
								<div class="<?php echo esc_attr( $class ); ?>">
									<?php if ( $title ) : ?>
										<h1 class="wp-block-heading gbe-le-gbe-hero__title"><?php echo esc_html( $title ); ?></h1>
									<?php endif; ?>
									<?php if ( ! empty( $slide['lead'] ) ) : ?>
										<p class="gbe-le-gbe-hero__lead"><?php echo esc_html( $slide['lead'] ); ?></p>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
						<?php if ( count( $slides ) > 1 ) : ?>
							<div class="gbe-le-gbe-hero__dots" role="tablist" aria-label="<?php esc_attr_e( 'Diapositives', 'gbecosmolingua' ); ?>">
								<?php foreach ( $slides as $i => $slide ) : ?>
									<button type="button" class="gbe-le-gbe-hero__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Diapositive %d', 'gbecosmolingua' ), $i + 1 ) ); ?>"></button>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					<?php else : ?>
						<?php if ( $page_title ) : ?>
							<h1 class="wp-block-heading gbe-le-gbe-hero__title"><?php echo esc_html( $page_title ); ?></h1>
						<?php endif; ?>
						<?php if ( ! empty( $slides[0]['lead'] ) ) : ?>
							<p class="gbe-le-gbe-hero__lead"><?php echo esc_html( $slides[0]['lead'] ); ?></p>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
					<div class="wp-block-group gbe-le-gbe-hero__figure-wrap">
						<?php if ( $figure_url ) : ?>
							<figure class="wp-block-image size-large gbe-le-gbe-hero__figure">
								<img src="<?php echo esc_url( $figure_url ); ?>" alt="" />
							</figure>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Affiche l'intro (contenu éditeur WordPress).
 *
 * @param string $slug Slug hub.
 */
function gbecosmolingua_hub_render_public_intro( $slug = '' ) {
	$page = gbecosmolingua_hub_composer_page( $slug );
	$html = gbecosmolingua_public_page_intro_html( $page );
	if ( '' === $html ) {
		return;
	}
	$slug = $slug ?: gbecosmolingua_hub_composer_current_slug();
	?>
	<div class="wp-block-group alignwide gbe-section gbe-hub-intro gbe-hub-intro--<?php echo esc_attr( sanitize_html_class( $slug ) ); ?>">
		<?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php
}

/**
 * Affiche sections + bloc Voir plus.
 *
 * @param string $slug Slug hub.
 */
function gbecosmolingua_hub_render_public_sections( $slug = '' ) {
	if ( '' === $slug ) {
		$slug = gbecosmolingua_hub_composer_current_slug();
	}

	$page   = gbecosmolingua_hub_composer_page( $slug );
	$page_id = $page ? (int) $page->ID : 0;
	$layout = gbecosmolingua_hub_composer_layout( $page_id );
	$bands  = $layout['bands'];
	$more   = $layout['more'];

	if ( empty( $bands ) && empty( $more ) ) {
		return;
	}

	$hub_class = 'gbe-culture-rubriques gbe-le-gbe-rubriques gbe-hub-rubriques gbe-hub-rubriques--' . sanitize_html_class( $slug );
	$page_font = gbecosmolingua_hub_section_font_slug( '', $page_id );
	if ( $page_font ) {
		$hub_class .= ' ' . gbecosmolingua_hub_section_font_class( $page_font );
	}
	?>
	<div class="<?php echo esc_attr( $hub_class ); ?>">
		<?php
		foreach ( $bands as $index => $band ) {
			$title = trim( (string) ( $band['title'] ?? '' ) );
			$intro = trim( (string) ( $band['intro'] ?? '' ) );
			$uid   = sanitize_title( (string) ( $band['uid'] ?? 'section-' . $index ) );
			$image = (int) ( $band['image_id'] ?? 0 );

			if ( '' === $title && '' === $intro && ! $image && empty( $band['subcards'] ) ) {
				continue;
			}

			$style       = (string) ( $band['style'] ?? 'large-grid' );
			$show_large  = ( 'grid' !== $style );
			$is_feature  = ( 'large' === $style );
			$reverse     = ( 1 === $index % 2 );
			$thumb_style = gbecosmolingua_public_attachment_image_style( $image, '--gbe-culture-section-image' );
			$page_url    = gbecosmolingua_hub_composer_row_url( $band );
			$band_class  = 'gbe-culture-band' . ( 1 === $index % 2 ? ' gbe-culture-band--alt' : '' );
			$classes     = 'gbe-culture-rubrique gbe-culture-rubrique--split';
			if ( $reverse ) {
				$classes .= ' gbe-culture-rubrique--reverse';
			}
			if ( $is_feature ) {
				$classes .= ' gbe-culture-rubrique--feature';
			}
			$btn_label = ! empty( $band['button_text'] ) ? $band['button_text'] : __( 'Découvrir', 'gbecosmolingua' );
			$band_font = gbecosmolingua_hub_section_font_slug( $band['font'] ?? '', $page_id );
			if ( $band_font ) {
				$band_class .= ' ' . gbecosmolingua_hub_section_font_class( $band_font );
			}
			?>
			<div class="<?php echo esc_attr( $band_class ); ?>" id="gbe-hub-<?php echo esc_attr( $slug ); ?>-<?php echo esc_attr( $uid ); ?>">
				<div class="gbe-culture-band__inner">
					<?php if ( $show_large ) : ?>
					<section class="<?php echo esc_attr( $classes ); ?>">
						<?php if ( $thumb_style ) : ?>
							<div class="gbe-culture-rubrique__media gbe-culture-rubrique__media--<?php echo esc_attr( $uid ); ?>" style="<?php echo esc_attr( $thumb_style ); ?>" role="img" aria-label="<?php echo esc_attr( $title ); ?>"></div>
						<?php endif; ?>
						<div class="gbe-culture-rubrique__content">
							<?php if ( $title ) : ?>
								<h2><?php echo esc_html( $title ); ?></h2>
							<?php endif; ?>
							<?php if ( $intro ) : ?>
								<p class="gbe-culture-rubrique__lead"><?php echo esc_html( $intro ); ?></p>
							<?php endif; ?>
							<?php if ( $page_url ) : ?>
								<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( $page_url ); ?>"><?php echo esc_html( $btn_label ); ?></a>
							<?php endif; ?>
						</div>
					</section>
					<?php endif; ?>
					<?php if ( ! empty( $band['subcards'] ) && is_array( $band['subcards'] ) ) : ?>
						<div class="gbe-culture-subtopics">
							<div class="gbe-culture-subtopics__grid">
								<?php foreach ( $band['subcards'] as $sub ) : ?>
									<?php
									$sub_title = trim( (string) ( $sub['title'] ?? '' ) );
									$sub_intro = trim( (string) ( $sub['intro'] ?? '' ) );
									$sub_image = (int) ( $sub['image_id'] ?? 0 );
									if ( '' === $sub_title && '' === $sub_intro && ! $sub_image ) {
										continue;
									}
									$sub_style = gbecosmolingua_public_attachment_image_style( $sub_image, '--gbe-culture-section-image' );
									$sub_url   = gbecosmolingua_hub_composer_row_url( $sub );
									$sub_btn   = ! empty( $sub['button_text'] ) ? $sub['button_text'] : __( 'Découvrir', 'gbecosmolingua' );
									?>
									<article class="gbe-culture-subtopic">
										<?php if ( $sub_style ) : ?>
											<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $sub_style ); ?>"></div>
										<?php endif; ?>
										<div class="gbe-culture-subtopic__body">
											<?php if ( $sub_title ) : ?>
												<h3><?php echo esc_html( $sub_title ); ?></h3>
											<?php endif; ?>
											<?php if ( $sub_intro ) : ?>
												<p><?php echo esc_html( $sub_intro ); ?></p>
											<?php endif; ?>
											<?php if ( $sub_url ) : ?>
												<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $sub_url ); ?>"><?php echo esc_html( $sub_btn ); ?></a>
											<?php endif; ?>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}

		if ( ! empty( $more ) ) :
			?>
			<div class="gbe-culture-band gbe-le-gbe-voir-plus gbe-hub-voir-plus">
				<div class="gbe-culture-band__inner">
					<h2 class="gbe-le-gbe-voir-plus__title"><?php esc_html_e( 'Voir plus', 'gbecosmolingua' ); ?></h2>
					<div class="gbe-culture-subtopics__grid gbe-le-gbe-voir-plus__grid">
						<?php foreach ( $more as $row ) : ?>
							<?php
							$title = trim( (string) ( $row['title'] ?? '' ) );
							$intro = trim( (string) ( $row['intro'] ?? '' ) );
							$image = (int) ( $row['image_id'] ?? 0 );
							if ( '' === $title && '' === $intro && ! $image ) {
								continue;
							}
							$style = gbecosmolingua_public_attachment_image_style( $image, '--gbe-culture-section-image' );
							$url   = gbecosmolingua_hub_composer_row_url( $row );
							$btn   = ! empty( $row['button_text'] ) ? $row['button_text'] : __( 'Découvrir', 'gbecosmolingua' );
							?>
							<article class="gbe-culture-subtopic gbe-le-gbe-voir-plus__card">
								<?php if ( $style ) : ?>
									<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
								<?php endif; ?>
								<div class="gbe-culture-subtopic__body">
									<?php if ( $title ) : ?>
										<h3><?php echo esc_html( $title ); ?></h3>
									<?php endif; ?>
									<?php if ( $intro ) : ?>
										<p><?php echo esc_html( $intro ); ?></p>
									<?php endif; ?>
									<?php if ( $url ) : ?>
										<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $btn ); ?></a>
									<?php endif; ?>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php
}
