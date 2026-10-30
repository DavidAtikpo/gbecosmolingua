<?php
/**
 * Shortcodes for GbeCosmoLingua front-end features.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

require_once GBE_CORE_PATH . 'includes/map-data.php';

/**
 * Registers and renders public shortcodes.
 */
class GBE_Shortcodes {

	/** Maximum de colonnes affichées dans un sous-menu. */
	const MENU_COLUMN_LIMIT = 7;

	/** Maximum de sections affichées sous un grand titre. */
	const MENU_SECTION_LIMIT = 7;

	/**
	 * Register shortcodes.
	 */
	public static function init() {
		add_shortcode( 'gbe_carte_interactive', array( __CLASS__, 'carte_interactive' ) );
		add_shortcode( 'gbe_proverbes_list', array( __CLASS__, 'proverbes_list' ) );
		add_shortcode( 'gbe_proverbe_detail', array( __CLASS__, 'proverbe_detail' ) );
		add_shortcode( 'gbe_xotutu_list', array( __CLASS__, 'xotutu_list' ) );
		add_shortcode( 'gbe_bibliotheque', array( __CLASS__, 'bibliotheque' ) );
		add_shortcode( 'gbe_actualites', array( __CLASS__, 'actualites' ) );
		add_shortcode( 'gbe_agenda', array( __CLASS__, 'agenda' ) );
		add_shortcode( 'gbe_partenaires', array( __CLASS__, 'partenaires' ) );
		add_shortcode( 'gbe_evenements_list', array( __CLASS__, 'evenements_list' ) );
		add_shortcode( 'gbe_partenaires_list', array( __CLASS__, 'partenaires_list' ) );
		add_shortcode( 'gbe_membres_fondateurs', array( __CLASS__, 'membres_fondateurs' ) );
		add_shortcode( 'gbe_membres', array( __CLASS__, 'membres' ) );
		add_shortcode( 'gbe_menu_principal', array( __CLASS__, 'menu_principal' ) );
		add_shortcode( 'gbe_site_logo', array( __CLASS__, 'site_logo' ) );
		add_shortcode( 'gbe_header_socials', array( __CLASS__, 'header_socials' ) );
		add_shortcode( 'gbe_header_contact', array( __CLASS__, 'header_contact' ) );
	}

	/**
	 * Site logo with dynamic theme URL (works on every machine).
	 *
	 * @param array<string, string> $atts Shortcode attributes.
	 */
	public static function site_logo( $atts ) {
		$atts = shortcode_atts(
			array(
				'width' => '40',
				'class' => 'gbe-site-brand__logo',
				'link'  => '1',
				'alt'   => 'GbeCosmoLingua',
			),
			$atts,
			'gbe_site_logo'
		);

		$logo_path = get_stylesheet_directory() . '/assets/images/gbecosmolingua-logo.png';
		if ( ! file_exists( $logo_path ) ) {
			return '';
		}

		$logo_url = get_stylesheet_directory_uri() . '/assets/images/gbecosmolingua-logo.png';
		$width    = max( 16, (int) $atts['width'] );
		$class    = esc_attr( trim( $atts['class'] ) );
		$alt      = esc_attr( $atts['alt'] );
		$with_link = ! in_array( (string) $atts['link'], array( '0', 'false', 'no' ), true );

		$img = sprintf(
			'<img src="%s" alt="%s" width="%d" height="%d" style="width:%dpx;height:auto" loading="eager" decoding="async" />',
			esc_url( $logo_url ),
			$alt,
			$width,
			$width,
			$width
		);

		$figure = sprintf(
			'<figure class="wp-block-image size-full is-resized %s">%s</figure>',
			$class,
			$with_link
				? sprintf( '<a href="%s">%s</a>', esc_url( home_url( '/' ) ), $img )
				: $img
		);

		return $figure;
	}

	/**
	 * Social network links for the header (left column).
	 */
	public static function header_socials() {
		$links = apply_filters(
			'gbe_header_social_links',
			array(
				array(
					'label'   => 'Facebook',
					'url'     => 'https://www.facebook.com/',
					'network' => 'facebook',
				),
				array(
					'label'   => 'X',
					'url'     => 'https://x.com/',
					'network' => 'x',
				),
				array(
					'label'   => 'Instagram',
					'url'     => 'https://www.instagram.com/',
					'network' => 'instagram',
				),
				array(
					'label'   => 'YouTube',
					'url'     => 'https://www.youtube.com/',
					'network' => 'youtube',
				),
			)
		);

		$items = '';
		foreach ( $links as $link ) {
			if ( empty( $link['url'] ) || empty( $link['label'] ) ) {
				continue;
			}
			$network = ! empty( $link['network'] ) ? sanitize_key( $link['network'] ) : 'link';
			$items  .= sprintf(
				'<li><a class="gbe-header__social-link gbe-header__social-link--%s" href="%s" target="_blank" rel="noopener noreferrer"><span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span></a></li>',
				esc_attr( $network ),
				esc_url( $link['url'] ),
				esc_html( $link['label'] ),
				esc_html( self::header_social_abbrev( $link['label'], $network ) )
			);
		}

		if ( '' === $items ) {
			return '';
		}

		return sprintf(
			'<nav class="gbe-header__socials" aria-label="%s"><ul class="gbe-header__socials-list">%s</ul></nav>',
			esc_attr__( 'Réseaux sociaux', 'gbecosmolingua-core' ),
			$items
		);
	}

	/**
	 * Short label shown on social icon buttons.
	 *
	 * @param string $label   Link label.
	 * @param string $network Network slug.
	 */
	private static function header_social_abbrev( $label, $network ) {
		$map = array(
			'facebook'  => 'f',
			'x'         => 'X',
			'twitter'   => 'X',
			'instagram' => 'in',
			'youtube'   => '▶',
			'linkedin'  => 'in',
		);
		if ( isset( $map[ $network ] ) ) {
			return $map[ $network ];
		}
		return mb_strtoupper( mb_substr( $label, 0, 1 ) );
	}

	/**
	 * Contact link for the header (right of search).
	 *
	 * @param array<string, string> $atts Shortcode attributes.
	 */
	public static function header_contact( $atts ) {
		$atts = shortcode_atts(
			array(
				'url'   => '',
				'label' => __( 'Contact', 'gbecosmolingua-core' ),
			),
			$atts,
			'gbe_header_contact'
		);

		$url = $atts['url'] ? $atts['url'] : home_url( '/nous-soutenir/' );
		$url = apply_filters( 'gbe_header_contact_url', $url );

		return sprintf(
			'<a class="gbe-header__contact" href="%s">%s</a>',
			esc_url( $url ),
			esc_html( $atts['label'] )
		);
	}

	/**
	 * Main navigation — top-level links only (sous-rubriques sur les pages).
	 */
	public static function menu_principal() {
		$menu_items = function_exists( 'gbe_get_primary_menu_items' )
			? gbe_get_primary_menu_items()
			: array();

		ob_start();
		?>
		<nav class="gbe-main-menu" aria-label="<?php esc_attr_e( 'Menu principal', 'gbecosmolingua-core' ); ?>">
			<ul class="gbe-main-menu__list">
				<?php foreach ( $menu_items as $item ) : ?>
					<?php echo self::render_menu_item( $item ); ?>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render one top-level menu item (lien direct, sans panneau déroulant).
	 *
	 * @param array<string, string>|string $item Entrée menu ou chemin page (legacy).
	 */
	private static function render_menu_item( $item ) {
		if ( is_string( $item ) ) {
			$item = array(
				'type' => 'page',
				'path' => $item,
			);
		}

		$resolved = function_exists( 'gbe_resolve_primary_menu_item' )
			? gbe_resolve_primary_menu_item( $item )
			: null;

		if ( ! $resolved ) {
			return '';
		}

		ob_start();
		?>
		<li class="gbe-main-menu__item">
			<a href="<?php echo esc_url( $resolved['url'] ); ?>" class="gbe-main-menu__link">
				<?php echo esc_html( $resolved['label'] ); ?>
			</a>
		</li>
		<?php
		return ob_get_clean();
	}

	/**
	 * Interactive map shortcode.
	 */
	public static function carte_interactive() {
		wp_enqueue_style( 'leaflet' );
		wp_enqueue_style( 'gbe-frontend' );
		wp_enqueue_script( 'leaflet' );
		wp_enqueue_script( 'gbe-map' );
		wp_localize_script( 'gbe-map', 'gbeMapData', gbe_get_map_data() );

		ob_start();
		?>
		<div class="gbe-map-wrapper">
			<div class="gbe-map-legend">
				<span class="gbe-legend-item gbe-legend-item--langue"><?php esc_html_e( 'Variétés linguistiques', 'gbecosmolingua-core' ); ?></span>
				<span class="gbe-legend-item gbe-legend-item--patrimoine"><?php esc_html_e( 'Centres patrimoniaux', 'gbecosmolingua-core' ); ?></span>
				<span class="gbe-legend-item gbe-legend-item--migration"><?php esc_html_e( 'Routes migratoires', 'gbecosmolingua-core' ); ?></span>
			</div>
			<div id="gbe-map" class="gbe-map" role="application" aria-label="<?php esc_attr_e( 'Carte du continuum gbe', 'gbecosmolingua-core' ); ?>"></div>
			<p class="gbe-map-note"><?php esc_html_e( 'Répartition géographique des langues gbe, zones culturelles et centres patrimoniaux au Togo, au Bénin, au Ghana et au Nigeria.', 'gbecosmolingua-core' ); ?></p>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Filterable proverbs list.
	 *
	 * @param array<string, string> $atts Shortcode attributes.
	 */
	public static function proverbes_list( $atts ) {
		$atts = shortcode_atts(
			array(
				'langue' => '',
				'limit'  => 24,
			),
			$atts,
			'gbe_proverbes_list'
		);

		$langue_filter = isset( $_GET['langue_gbe'] ) ? sanitize_text_field( wp_unslash( $_GET['langue_gbe'] ) ) : $atts['langue'];
		$search        = isset( $_GET['gbe_q'] ) ? sanitize_text_field( wp_unslash( $_GET['gbe_q'] ) ) : '';
		$paged         = isset( $_GET['gbe_page'] ) ? max( 1, (int) $_GET['gbe_page'] ) : 1;
		$per_page      = max( 6, min( 48, (int) $atts['limit'] ) );

		$args = array(
			'post_type'      => 'proverbe',
			'posts_per_page' => $per_page,
			'post_status'    => 'publish',
			'paged'          => $paged,
		);

		if ( $search ) {
			$args['s'] = $search;
		}

		if ( $langue_filter ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'langue_gbe',
					'field'    => 'slug',
					'terms'    => $langue_filter,
				),
			);
		}

		$query   = new WP_Query( $args );
		$langues = get_terms( array( 'taxonomy' => 'langue_gbe', 'hide_empty' => false ) );
		$total   = (int) $query->found_posts;
		$pages   = max( 1, (int) $query->max_num_pages );
		$from    = $total ? ( ( $paged - 1 ) * $per_page ) + 1 : 0;
		$to      = min( $total, $paged * $per_page );

		ob_start();
		?>
		<div class="gbe-proverbes-archive">
			<div class="gbe-proverbes-archive__head">
				<p class="gbe-proverbes-archive__summary">
					<?php if ( $total ) : ?>
						<?php
						printf(
							/* translators: 1: first result number, 2: last result number, 3: total results */
							esc_html__( 'Affichage de %1$s–%2$s sur %3$s proverbes', 'gbecosmolingua-core' ),
							number_format_i18n( $from ),
							number_format_i18n( $to ),
							number_format_i18n( $total )
						);
						?>
					<?php else : ?>
						<?php esc_html_e( 'Aucun proverbe ne correspond à votre recherche.', 'gbecosmolingua-core' ); ?>
					<?php endif; ?>
				</p>
			</div>

			<form class="gbe-filters gbe-filters--proverbes" method="get" action="">
				<div class="gbe-filters__field gbe-filters__field--search">
					<label for="gbe_q"><?php esc_html_e( 'Rechercher', 'gbecosmolingua-core' ); ?></label>
					<input type="search" id="gbe_q" name="gbe_q" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Mot-clé, proverbe, traduction…', 'gbecosmolingua-core' ); ?>">
				</div>

				<div class="gbe-filters__field gbe-filters__field--lang">
					<label for="langue_gbe"><?php esc_html_e( 'Langue', 'gbecosmolingua-core' ); ?></label>
					<select id="langue_gbe" name="langue_gbe">
						<option value=""><?php esc_html_e( 'Toutes les langues', 'gbecosmolingua-core' ); ?></option>
						<?php foreach ( $langues as $term ) : ?>
							<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $langue_filter, $term->slug ); ?>>
								<?php echo esc_html( $term->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="gbe-filters__actions">
					<button type="submit" class="gbe-btn gbe-btn--primary"><?php esc_html_e( 'Filtrer', 'gbecosmolingua-core' ); ?></button>
					<?php if ( $search || $langue_filter ) : ?>
						<a class="gbe-filters__reset" href="<?php echo esc_url( remove_query_arg( array( 'gbe_q', 'langue_gbe', 'gbe_page' ) ) ); ?>">
							<?php esc_html_e( 'Réinitialiser', 'gbecosmolingua-core' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</form>

			<?php if ( $query->have_posts() ) : ?>
				<div class="gbe-cards-grid gbe-cards-grid--proverbes">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo self::render_proverbe_card( get_the_ID() );
					endwhile;
					?>
				</div>

				<?php if ( $pages > 1 ) : ?>
					<?php
					$pagination_base = array();
					if ( $search ) {
						$pagination_base['gbe_q'] = $search;
					}
					if ( $langue_filter ) {
						$pagination_base['langue_gbe'] = $langue_filter;
					}
					?>
					<nav class="gbe-proverbes-pagination" aria-label="<?php esc_attr_e( 'Pagination des proverbes', 'gbecosmolingua-core' ); ?>">
						<?php if ( $paged > 1 ) : ?>
							<a class="gbe-proverbes-pagination__link gbe-proverbes-pagination__link--prev" href="<?php echo esc_url( add_query_arg( array_merge( $pagination_base, array( 'gbe_page' => $paged - 1 ) ) ) ); ?>">
								<?php esc_html_e( '← Page précédente', 'gbecosmolingua-core' ); ?>
							</a>
						<?php endif; ?>
						<span class="gbe-proverbes-pagination__status">
							<?php
							printf(
								/* translators: 1: current page, 2: total pages */
								esc_html__( 'Page %1$s sur %2$s', 'gbecosmolingua-core' ),
								number_format_i18n( $paged ),
								number_format_i18n( $pages )
							);
							?>
						</span>
						<?php if ( $paged < $pages ) : ?>
							<a class="gbe-proverbes-pagination__link gbe-proverbes-pagination__link--next" href="<?php echo esc_url( add_query_arg( array_merge( $pagination_base, array( 'gbe_page' => $paged + 1 ) ) ) ); ?>">
								<?php esc_html_e( 'Page suivante →', 'gbecosmolingua-core' ); ?>
							</a>
						<?php endif; ?>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucun proverbe trouvé. Ajoutez des entrées depuis l\'administration WordPress.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Single proverbe detail shortcode.
	 */
	public static function proverbe_detail() {
		if ( ! is_singular( 'proverbe' ) ) {
			return '';
		}
		return self::render_proverbe_detail( get_the_ID(), true );
	}

	/**
	 * Render proverb detail block.
	 *
	 * @param int  $post_id Post ID.
	 * @param bool $wrap    Wrap in container div.
	 */
	public static function render_proverbe_detail( $post_id, $wrap = true ) {
		$fields = array(
			'texte_original'       => __( 'Texte original', 'gbecosmolingua-core' ),
			'transcription'        => __( 'Transcription', 'gbecosmolingua-core' ),
			'traduction_fr'        => __( 'Traduction française', 'gbecosmolingua-core' ),
			'traduction_en'        => __( 'Traduction anglaise', 'gbecosmolingua-core' ),
			'traduction_es'        => __( 'Traduction espagnole', 'gbecosmolingua-core' ),
			'traduction_ru'        => __( 'Traduction russe', 'gbecosmolingua-core' ),
			'contexte'             => __( 'Contexte d\'emploi', 'gbecosmolingua-core' ),
			'commentaire_culturel' => __( 'Commentaire culturel', 'gbecosmolingua-core' ),
		);

		$analyses = array(
			'analyse_linguistique'   => __( 'Analyse linguistique', 'gbecosmolingua-core' ),
			'analyse_pragmatique'    => __( 'Analyse pragmatique', 'gbecosmolingua-core' ),
			'analyse_ethnographique' => __( 'Analyse ethnographique', 'gbecosmolingua-core' ),
		);

		$langues = get_the_terms( $post_id, 'langue_gbe' );

		ob_start();
		if ( $wrap ) {
			echo '<div class="gbe-proverbe-detail">';
		} else {
			echo '<aside class="gbe-proverbe-detail gbe-proverbe-detail--appended">';
		}

		if ( $langues && ! is_wp_error( $langues ) ) {
			echo '<p class="gbe-meta-tags">';
			foreach ( $langues as $term ) {
				printf( '<span class="gbe-tag">%s</span>', esc_html( $term->name ) );
			}
			echo '</p>';
		}

		foreach ( $fields as $key => $label ) {
			$value = GBE_Frontend::get_meta( $post_id, $key );
			if ( $value ) {
				printf( '<div class="gbe-field-block"><h3>%s</h3><p>%s</p></div>', esc_html( $label ), nl2br( esc_html( $value ) ) );
			}
		}

		$has_analyses = false;
		foreach ( $analyses as $key => $label ) {
			if ( GBE_Frontend::get_meta( $post_id, $key ) ) {
				$has_analyses = true;
				break;
			}
		}

		if ( $has_analyses ) {
			echo '<div class="gbe-analyses"><h3>' . esc_html__( 'Analyses', 'gbecosmolingua-core' ) . '</h3>';
			foreach ( $analyses as $key => $label ) {
				$value = GBE_Frontend::get_meta( $post_id, $key );
				if ( $value ) {
					printf( '<div class="gbe-field-block"><h4>%s</h4><p>%s</p></div>', esc_html( $label ), nl2br( esc_html( $value ) ) );
				}
			}
			echo '</div>';
		}

		echo $wrap ? '</div>' : '</aside>';
		return ob_get_clean();
	}

	/**
	 * Contexte d'import générique (identique sur tout un corpus) — ne pas l'afficher en carte.
	 *
	 * @param string $contexte Texte contexte.
	 * @return bool
	 */
	private static function is_generic_proverbe_contexte( $contexte ) {
		$contexte = trim( (string) $contexte );
		if ( '' === $contexte ) {
			return true;
		}

		$needles = array(
			'Corpus éwé',
			'Corpus ewe',
			'Lododowo / Adoglo',
			'Gbekɔbu',
			'sources complémentaires',
		);

		foreach ( $needles as $needle ) {
			if ( false !== stripos( $contexte, $needle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Sous-titre carte proverbe (traduction ou contexte utile).
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	private static function proverbe_card_subtitle( $post_id ) {
		$trad = trim( (string) GBE_Frontend::get_meta( $post_id, 'traduction_fr' ) );
		if ( '' !== $trad ) {
			return wp_trim_words( $trad, 22, '…' );
		}

		$commentaire = trim( (string) GBE_Frontend::get_meta( $post_id, 'commentaire_culturel' ) );
		if ( '' !== $commentaire ) {
			return wp_trim_words( $commentaire, 18, '…' );
		}

		$contexte = trim( (string) GBE_Frontend::get_meta( $post_id, 'contexte' ) );
		if ( '' !== $contexte && ! self::is_generic_proverbe_contexte( $contexte ) ) {
			return wp_trim_words( $contexte, 18, '…' );
		}

		return '';
	}

	/**
	 * Render a proverb card for archives.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function render_proverbe_card( $post_id ) {
		$texte = GBE_Frontend::get_meta( $post_id, 'texte_original' );
		if ( ! $texte ) {
			$texte = get_the_title( $post_id );
		}
		$langues  = get_the_terms( $post_id, 'langue_gbe' );
		$url      = get_permalink( $post_id );
		$subtitle = self::proverbe_card_subtitle( $post_id );

		ob_start();
		?>
		<article class="gbe-proverbe-card">
			<div class="gbe-proverbe-card__body">
				<?php if ( $langues && ! is_wp_error( $langues ) ) : ?>
					<div class="gbe-proverbe-card__tags">
						<?php foreach ( $langues as $term ) : ?>
							<span class="gbe-proverbe-card__tag"><?php echo esc_html( $term->name ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $texte ) : ?>
					<blockquote class="gbe-proverbe-card__quote" cite="<?php echo esc_url( $url ); ?>">
						<p>
							<a class="gbe-proverbe-card__quote-link" href="<?php echo esc_url( $url ); ?>">
								<?php echo esc_html( $texte ); ?>
							</a>
						</p>
					</blockquote>
				<?php endif; ?>

				<?php if ( $subtitle ) : ?>
					<p class="gbe-proverbe-card__excerpt"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>

			<footer class="gbe-proverbe-card__footer">
				<a class="gbe-proverbe-card__cta" href="<?php echo esc_url( $url ); ?>">
					<?php esc_html_e( 'Lire la fiche', 'gbecosmolingua-core' ); ?> →
				</a>
			</footer>
		</article>
		<?php
		return ob_get_clean();
	}

	/**
	 * Xótùtù oral genres list.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function xotutu_list( $atts ) {
		$atts = shortcode_atts(
			array(
				'genre' => '',
				'limit' => 12,
			),
			$atts,
			'gbe_xotutu_list'
		);

		$genre_filter = isset( $_GET['genre_xotutu'] ) ? sanitize_text_field( wp_unslash( $_GET['genre_xotutu'] ) ) : $atts['genre'];

		$args = array(
			'post_type'      => 'genre_oral',
			'posts_per_page' => (int) $atts['limit'],
			'post_status'    => 'publish',
		);

		if ( $genre_filter ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'genre_xotutu',
					'field'    => 'slug',
					'terms'    => $genre_filter,
				),
			);
		}

		$query  = new WP_Query( $args );
		$genres = get_terms( array( 'taxonomy' => 'genre_xotutu', 'hide_empty' => false ) );

		ob_start();
		?>
		<div class="gbe-xotutu-archive">
			<form class="gbe-filters" method="get" action="">
				<label for="genre_xotutu"><?php esc_html_e( 'Genre oral', 'gbecosmolingua-core' ); ?></label>
				<select id="genre_xotutu" name="genre_xotutu">
					<option value=""><?php esc_html_e( 'Tous les genres', 'gbecosmolingua-core' ); ?></option>
					<?php foreach ( $genres as $term ) : ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $genre_filter, $term->slug ); ?>>
							<?php echo esc_html( $term->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<button type="submit" class="gbe-btn"><?php esc_html_e( 'Filtrer', 'gbecosmolingua-core' ); ?></button>
			</form>

			<?php if ( $query->have_posts() ) : ?>
				<div class="gbe-cards-grid">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo self::render_xotutu_card( get_the_ID() );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucune archive disponible pour le moment.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render Xótùtù card.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function render_xotutu_card( $post_id ) {
		$genres = get_the_terms( $post_id, 'genre_xotutu' );
		$audio  = GBE_Frontend::get_meta( $post_id, 'audio_id' );
		$has_media = $audio || GBE_Frontend::get_meta( $post_id, 'video_id' );

		ob_start();
		?>
		<article class="gbe-card gbe-card--xotutu">
			<?php if ( $genres && ! is_wp_error( $genres ) ) : ?>
				<div class="gbe-card__tags">
					<?php foreach ( $genres as $term ) : ?>
						<span class="gbe-tag gbe-tag--genre"><?php echo esc_html( $term->name ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<h3 class="gbe-card__title"><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
			<?php if ( has_excerpt( $post_id ) ) : ?>
				<p class="gbe-card__excerpt"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>
			<?php endif; ?>
			<?php if ( $has_media ) : ?>
				<span class="gbe-badge"><?php esc_html_e( 'Audio / Vidéo disponible', 'gbecosmolingua-core' ); ?></span>
			<?php endif; ?>
		</article>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render genre oral detail.
	 *
	 * @param int  $post_id Post ID.
	 * @param bool $wrap    Wrap in container.
	 */
	public static function render_genre_oral_detail( $post_id, $wrap = true ) {
		$audio_id = GBE_Frontend::get_meta( $post_id, 'audio_id' );
		$video_id = GBE_Frontend::get_meta( $post_id, 'video_id' );
		$source   = GBE_Frontend::get_meta( $post_id, 'source' );
		$trans    = GBE_Frontend::get_meta( $post_id, 'transcription_orale' );

		ob_start();
		echo $wrap ? '<div class="gbe-xotutu-detail">' : '<aside class="gbe-xotutu-detail gbe-xotutu-detail--appended">';

		if ( $audio_id ) {
			echo '<div class="gbe-media-block"><h3>' . esc_html__( 'Archive audio', 'gbecosmolingua-core' ) . '</h3>';
			echo wp_audio_shortcode( array( 'src' => wp_get_attachment_url( $audio_id ) ) );
			echo '</div>';
		}

		if ( $video_id ) {
			$url = wp_get_attachment_url( $video_id );
			echo '<div class="gbe-media-block"><h3>' . esc_html__( 'Archive vidéo', 'gbecosmolingua-core' ) . '</h3>';
			echo wp_video_shortcode( array( 'src' => $url ) );
			echo '</div>';
		}

		if ( $source ) {
			printf( '<p class="gbe-source"><strong>%s</strong> %s</p>', esc_html__( 'Source :', 'gbecosmolingua-core' ), esc_html( $source ) );
		}

		if ( $trans ) {
			printf( '<div class="gbe-field-block"><h3>%s</h3><p>%s</p></div>', esc_html__( 'Transcription', 'gbecosmolingua-core' ), nl2br( esc_html( $trans ) ) );
		}

		echo $wrap ? '</div>' : '</aside>';
		return ob_get_clean();
	}

	/**
	 * Digital library: ressources + optional xotutu tab.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function bibliotheque( $atts ) {
		$atts = shortcode_atts(
			array(
				'type'  => 'all',
				'limit' => 20,
			),
			$atts,
			'gbe_bibliotheque'
		);

		$tab = isset( $_GET['gbe_tab'] ) ? sanitize_text_field( wp_unslash( $_GET['gbe_tab'] ) ) : 'ressources';

		ob_start();
		?>
		<div class="gbe-bibliotheque">
			<nav class="gbe-tabs" aria-label="<?php esc_attr_e( 'Sections bibliothèque', 'gbecosmolingua-core' ); ?>">
				<a href="?gbe_tab=ressources" class="gbe-tab <?php echo 'ressources' === $tab ? 'is-active' : ''; ?>">
					<?php esc_html_e( 'Ressources documentaires', 'gbecosmolingua-core' ); ?>
				</a>
				<a href="?gbe_tab=xotutu" class="gbe-tab <?php echo 'xotutu' === $tab ? 'is-active' : ''; ?>">
					<?php esc_html_e( 'Archives Xótùtù', 'gbecosmolingua-core' ); ?>
				</a>
			</nav>

			<?php
			if ( 'xotutu' === $tab ) {
				echo self::xotutu_list( array( 'limit' => $atts['limit'] ) );
			} else {
				echo self::render_ressources_list( (int) $atts['limit'] );
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render resources list.
	 *
	 * @param int $limit Posts per page.
	 */
	public static function render_ressources_list( $limit = 20 ) {
		$type_filter = isset( $_GET['type_doc'] ) ? sanitize_text_field( wp_unslash( $_GET['type_doc'] ) ) : '';

		$args = array(
			'post_type'      => 'ressource',
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
		);

		if ( $type_filter ) {
			$args['meta_query'] = array(
				array(
					'key'   => '_gbe_type_document',
					'value' => $type_filter,
				),
			);
		}

		$query = new WP_Query( $args );
		$types = array( 'manuscrit', 'corpus', 'article', 'audio', 'video', 'lexique' );

		ob_start();
		?>
		<div class="gbe-ressources-archive">
			<form class="gbe-filters" method="get" action="">
				<input type="hidden" name="gbe_tab" value="ressources">
				<label for="type_doc"><?php esc_html_e( 'Type', 'gbecosmolingua-core' ); ?></label>
				<select id="type_doc" name="type_doc">
					<option value=""><?php esc_html_e( 'Tous les types', 'gbecosmolingua-core' ); ?></option>
					<?php foreach ( $types as $t ) : ?>
						<option value="<?php echo esc_attr( $t ); ?>" <?php selected( $type_filter, $t ); ?>><?php echo esc_html( ucfirst( $t ) ); ?></option>
					<?php endforeach; ?>
				</select>
				<button type="submit" class="gbe-btn"><?php esc_html_e( 'Filtrer', 'gbecosmolingua-core' ); ?></button>
			</form>

			<?php if ( $query->have_posts() ) : ?>
				<ul class="gbe-ressources-list">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						$post_id  = get_the_ID();
						$type_doc = GBE_Frontend::get_meta( $post_id, 'type_document' );
						$file_id  = GBE_Frontend::get_meta( $post_id, 'fichier_id' );
						$auteur   = GBE_Frontend::get_meta( $post_id, 'auteur' );
						$file_url = $file_id ? wp_get_attachment_url( $file_id ) : '';
						?>
						<li class="gbe-ressource-item">
							<div class="gbe-ressource-item__main">
								<strong><?php the_title(); ?></strong>
								<?php if ( $type_doc ) : ?>
									<span class="gbe-tag"><?php echo esc_html( ucfirst( $type_doc ) ); ?></span>
								<?php endif; ?>
								<?php if ( $auteur ) : ?>
									<span class="gbe-ressource-auteur"><?php echo esc_html( $auteur ); ?></span>
								<?php endif; ?>
							</div>
							<?php if ( $file_url ) : ?>
								<a href="<?php echo esc_url( $file_url ); ?>" class="gbe-btn gbe-btn--small" download>
									<?php esc_html_e( 'Télécharger', 'gbecosmolingua-core' ); ?>
								</a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>" class="gbe-btn gbe-btn--small">
									<?php esc_html_e( 'Consulter', 'gbecosmolingua-core' ); ?>
								</a>
							<?php endif; ?>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucune ressource disponible pour le moment.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Latest news posts for the homepage.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function actualites( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit' => 3,
			),
			$atts,
			'gbe_actualites'
		);

		$query = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => (int) $atts['limit'],
				'post_status'    => 'publish',
			)
		);

		$blog_url = get_option( 'page_for_posts' ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : home_url( '/' );

		ob_start();
		?>
		<div class="gbe-home-block gbe-home-actualites">
			<div class="gbe-home-block__header">
				<h2 class="gbe-home-block__title"><?php esc_html_e( 'Actualités', 'gbecosmolingua-core' ); ?></h2>
				<a href="<?php echo esc_url( $blog_url ); ?>" class="gbe-home-block__more">
					<?php esc_html_e( 'Toutes les actualités', 'gbecosmolingua-core' ); ?> →
				</a>
			</div>

			<?php if ( $query->have_posts() ) : ?>
				<div class="gbe-actualites-grid">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo self::render_actualite_card( get_the_ID() );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucune actualité publiée pour le moment.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render a news card.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function render_actualite_card( $post_id ) {
		$date = get_the_date( '', $post_id );

		ob_start();
		?>
		<article class="gbe-card gbe-card--actualite">
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="gbe-card__thumb">
					<?php echo get_the_post_thumbnail( $post_id, 'medium_large', array( 'loading' => 'lazy' ) ); ?>
				</a>
			<?php endif; ?>
			<time class="gbe-card__date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
				<?php echo esc_html( $date ); ?>
			</time>
			<h3 class="gbe-card__title">
				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a>
			</h3>
			<?php if ( has_excerpt( $post_id ) ) : ?>
				<p class="gbe-card__excerpt"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="gbe-card__link">
				<?php esc_html_e( 'Lire la suite', 'gbecosmolingua-core' ); ?> →
			</a>
		</article>
		<?php
		return ob_get_clean();
	}

	/**
	 * Upcoming events agenda for the homepage.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function agenda( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit' => 5,
			),
			$atts,
			'gbe_agenda'
		);

		$today = gmdate( 'Y-m-d' );

		$query = new WP_Query(
			array(
				'post_type'      => 'evenement',
				'posts_per_page' => (int) $atts['limit'],
				'post_status'    => 'publish',
				'meta_key'       => '_gbe_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => '_gbe_date',
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
			)
		);

		$archive_url = get_post_type_archive_link( 'evenement' );

		ob_start();
		?>
		<div class="gbe-home-block gbe-home-agenda">
			<div class="gbe-home-block__header">
				<h2 class="gbe-home-block__title"><?php esc_html_e( 'Agenda', 'gbecosmolingua-core' ); ?></h2>
				<?php if ( $archive_url ) : ?>
					<a href="<?php echo esc_url( $archive_url ); ?>" class="gbe-home-block__more">
						<?php esc_html_e( 'Tous les événements', 'gbecosmolingua-core' ); ?> →
					</a>
				<?php endif; ?>
			</div>

			<?php if ( $query->have_posts() ) : ?>
				<ol class="gbe-agenda-list">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo self::render_agenda_item( get_the_ID() );
					endwhile;
					?>
				</ol>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucun événement à venir pour le moment.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render a single agenda row.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function render_agenda_item( $post_id ) {
		$date_raw = GBE_Frontend::get_meta( $post_id, 'date' );
		$lieu     = GBE_Frontend::get_meta( $post_id, 'lieu' );
		$type     = GBE_Frontend::get_meta( $post_id, 'type_evenement' );

		$day   = '';
		$month = '';
		if ( $date_raw ) {
			$timestamp = strtotime( $date_raw );
			if ( $timestamp ) {
				$day   = date_i18n( 'd', $timestamp );
				$month = date_i18n( 'M', $timestamp );
			}
		}

		ob_start();
		?>
		<li class="gbe-agenda-item">
			<?php if ( $date_raw ) : ?>
				<div class="gbe-agenda-item__date" aria-label="<?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $date_raw ) ) ); ?>">
					<span class="gbe-agenda-item__day"><?php echo esc_html( $day ); ?></span>
					<span class="gbe-agenda-item__month"><?php echo esc_html( $month ); ?></span>
				</div>
			<?php endif; ?>
			<div class="gbe-agenda-item__body">
				<?php if ( $type ) : ?>
					<span class="gbe-tag gbe-tag--event"><?php echo esc_html( self::get_event_type_label( $type ) ); ?></span>
				<?php endif; ?>
				<h3 class="gbe-agenda-item__title">
					<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a>
				</h3>
				<?php if ( $lieu ) : ?>
					<p class="gbe-agenda-item__lieu"><?php echo esc_html( $lieu ); ?></p>
				<?php endif; ?>
			</div>
		</li>
		<?php
		return ob_get_clean();
	}

	/**
	 * Partner logos grid for the homepage.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function partenaires( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit' => 12,
				'class' => '',
			),
			$atts,
			'gbe_partenaires'
		);

		$query = new WP_Query(
			array(
				'post_type'      => 'partenaire',
				'posts_per_page' => (int) $atts['limit'],
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		ob_start();
		?>
		<div class="gbe-home-block gbe-home-partenaires <?php echo esc_attr( $atts['class'] ); ?>">
			<div class="gbe-home-block__header">
				<h2 class="gbe-home-block__title"><?php esc_html_e( 'Partenaires', 'gbecosmolingua-core' ); ?></h2>
				<a href="<?php echo esc_url( home_url( '/partenaires/' ) ); ?>" class="gbe-home-block__more">
					<?php esc_html_e( 'Notre réseau', 'gbecosmolingua-core' ); ?> →
				</a>
			</div>

			<?php if ( $query->have_posts() ) : ?>
				<div class="gbe-partenaires-grid">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo self::render_partenaire_card( get_the_ID() );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucun partenaire publié pour le moment.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render a partner card.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function render_partenaire_card( $post_id ) {
		$url    = GBE_Frontend::get_meta( $post_id, 'url' );
		$types  = get_the_terms( $post_id, 'type_partenaire' );
		$title  = get_the_title( $post_id );
		$link   = $url ? $url : get_permalink( $post_id );
		$target = $url ? ' target="_blank" rel="noopener noreferrer"' : '';

		ob_start();
		?>
		<article class="gbe-partenaire-card">
			<a href="<?php echo esc_url( $link ); ?>" class="gbe-partenaire-card__link"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php if ( has_post_thumbnail( $post_id ) ) : ?>
					<?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'gbe-partenaire-card__logo', 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<span class="gbe-partenaire-card__name"><?php echo esc_html( $title ); ?></span>
				<?php endif; ?>
			</a>
			<?php if ( $types && ! is_wp_error( $types ) ) : ?>
				<span class="gbe-partenaire-card__type"><?php echo esc_html( $types[0]->name ); ?></span>
			<?php endif; ?>
		</article>
		<?php
		return ob_get_clean();
	}

	/**
	 * Human-readable event type label.
	 *
	 * @param string $type Event type slug.
	 */
	/**
	 * Full partners directory.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function partenaires_list( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit' => 48,
				'class' => 'gbe-partenaires-directory',
			),
			$atts,
			'gbe_partenaires_list'
		);

		return self::partenaires( $atts );
	}

	/**
	 * Membres fondateurs (alias du shortcode membres).
	 *
	 * @param array<string, string> $atts Attributes.
	 * @return string
	 */
	public static function membres_fondateurs( $atts ) {
		if ( ! is_array( $atts ) ) {
			$atts = array();
		}
		$atts['groupe'] = 'fondateur';
		if ( empty( $atts['title'] ) ) {
			$atts['title'] = __( 'Membres fondateurs', 'gbecosmolingua-core' );
		}

		return self::membres( $atts );
	}

	/**
	 * Grille de membres GbeCosmoLingua.
	 *
	 * @param array<string, string> $atts Attributes.
	 * @return string
	 */
	public static function membres( $atts ) {
		$atts = shortcode_atts(
			array(
				'groupe'     => 'fondateur',
				'limit'      => 24,
				'title'      => '',
				'show_title' => '1',
				'class'      => '',
			),
			$atts,
			'gbe_membres'
		);

		$args = array(
			'post_type'      => 'membre_gbe',
			'posts_per_page' => (int) $atts['limit'],
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);

		$groupe = sanitize_title( (string) $atts['groupe'] );
		if ( '' !== $groupe ) {
			$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'groupe_membre',
					'field'    => 'slug',
					'terms'    => $groupe,
				),
			);
		}

		$query = self::query_membres( $args, $groupe );

		ob_start();
		$section_class = trim( 'gbe-membres-section ' . (string) $atts['class'] );
		?>
		<section class="<?php echo esc_attr( $section_class ); ?>">
			<?php if ( '0' !== (string) $atts['show_title'] && '' !== trim( (string) $atts['title'] ) ) : ?>
				<h2 class="gbe-membres-section__title"><?php echo esc_html( (string) $atts['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( $query->have_posts() ) : ?>
				<div class="gbe-membres-grid">
					<?php
					while ( $query->have_posts() ) {
						$query->the_post();
						echo self::render_membre_card( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					wp_reset_postdata();
					?>
				</div>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucun membre publié pour le moment.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
		</section>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * Requête membres avec repli si le groupe ou Polylang filtre à vide.
	 *
	 * @param array<string, mixed> $args   Arguments WP_Query.
	 * @param string               $groupe Slug groupe demandé.
	 * @return WP_Query
	 */
	private static function query_membres( $args, $groupe = '' ) {
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			return $query;
		}

		if ( '' !== $groupe && class_exists( 'GBE_Demo_Content' ) ) {
			GBE_Demo_Content::seed_membres_fondateurs();
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				return $query;
			}
		}

		if ( '' !== $groupe ) {
			unset( $args['tax_query'] );
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				return $query;
			}
		}

		$args['suppress_filters'] = true;
		if ( '' !== $groupe ) {
			$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'groupe_membre',
					'field'    => 'slug',
					'terms'    => $groupe,
				),
			);
		}

		return new WP_Query( $args );
	}

	/**
	 * Carte membre individuelle.
	 *
	 * @param int $post_id ID membre.
	 * @return string
	 */
	public static function render_membre_card( $post_id ) {
		$post_id  = (int) $post_id;
		$name     = get_the_title( $post_id );
		$fonction = trim( (string) get_post_meta( $post_id, '_gbe_fonction', true ) );
		$bio      = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '';

		$photo_url = class_exists( 'GBE_Membres_Photos' )
			? GBE_Membres_Photos::get_membre_photo_url( $post_id )
			: '';

		ob_start();
		?>
		<article class="gbe-membre-card">
			<div class="gbe-membre-card__photo" aria-hidden="true">
				<?php if ( has_post_thumbnail( $post_id ) ) : ?>
					<?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'gbe-membre-card__img', 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php elseif ( '' !== $photo_url ) : ?>
					<img class="gbe-membre-card__img" src="<?php echo esc_url( $photo_url ); ?>" alt="" loading="lazy" width="132" height="132" />
				<?php else : ?>
					<span class="gbe-membre-card__placeholder"><?php echo esc_html( self::membre_initials( $name ) ); ?></span>
				<?php endif; ?>
			</div>
			<h3 class="gbe-membre-card__name"><?php echo esc_html( $name ); ?></h3>
			<?php if ( '' !== $fonction ) : ?>
				<p class="gbe-membre-card__role"><?php echo esc_html( $fonction ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $bio ) : ?>
				<p class="gbe-membre-card__bio"><?php echo esc_html( $bio ); ?></p>
			<?php endif; ?>
		</article>
		<?php
		return (string) ob_get_clean();
	}

	/**
	 * Initiales pour avatar placeholder.
	 *
	 * @param string $name Nom complet.
	 * @return string
	 */
	private static function membre_initials( $name ) {
		$parts = preg_split( '/\s+/', trim( (string) $name ) ) ?: array();
		$initials = '';
		foreach ( array_slice( $parts, 0, 2 ) as $part ) {
			if ( '' !== $part ) {
				$initials .= mb_strtoupper( mb_substr( $part, 0, 1 ) );
			}
		}
		return '' !== $initials ? $initials : '?';
	}

	/**
	 * Events list for archives and activity pages.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function evenements_list( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit'  => 24,
				'periode' => 'all',
			),
			$atts,
			'gbe_evenements_list'
		);

		$periode = isset( $_GET['gbe_periode'] ) ? sanitize_text_field( wp_unslash( $_GET['gbe_periode'] ) ) : $atts['periode'];
		$today   = gmdate( 'Y-m-d' );

		$args = array(
			'post_type'      => 'evenement',
			'posts_per_page' => (int) $atts['limit'],
			'post_status'    => 'publish',
			'meta_key'       => '_gbe_date',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
		);

		if ( 'upcoming' === $periode ) {
			$args['meta_query'] = array(
				array(
					'key'     => '_gbe_date',
					'value'   => $today,
					'compare' => '>=',
					'type'    => 'DATE',
				),
			);
		} elseif ( 'past' === $periode ) {
			$args['order'] = 'DESC';
			$args['meta_query'] = array(
				array(
					'key'     => '_gbe_date',
					'value'   => $today,
					'compare' => '<',
					'type'    => 'DATE',
				),
			);
		}

		$query = new WP_Query( $args );

		ob_start();
		?>
		<div class="gbe-evenements-archive">
			<form class="gbe-filters" method="get" action="">
				<label for="gbe_periode"><?php esc_html_e( 'Période', 'gbecosmolingua-core' ); ?></label>
				<select id="gbe_periode" name="gbe_periode">
					<option value="all" <?php selected( $periode, 'all' ); ?>><?php esc_html_e( 'Tous les événements', 'gbecosmolingua-core' ); ?></option>
					<option value="upcoming" <?php selected( $periode, 'upcoming' ); ?>><?php esc_html_e( 'À venir', 'gbecosmolingua-core' ); ?></option>
					<option value="past" <?php selected( $periode, 'past' ); ?>><?php esc_html_e( 'Passés', 'gbecosmolingua-core' ); ?></option>
				</select>
				<button type="submit" class="gbe-btn"><?php esc_html_e( 'Filtrer', 'gbecosmolingua-core' ); ?></button>
			</form>

			<?php if ( $query->have_posts() ) : ?>
				<ol class="gbe-agenda-list gbe-agenda-list--full">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo self::render_agenda_item( get_the_ID() );
					endwhile;
					?>
				</ol>
			<?php else : ?>
				<p class="gbe-empty"><?php esc_html_e( 'Aucun événement trouvé.', 'gbecosmolingua-core' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render event detail block.
	 *
	 * @param int  $post_id Post ID.
	 * @param bool $wrap    Wrap in container.
	 */
	public static function render_evenement_detail( $post_id, $wrap = true ) {
		$date  = GBE_Frontend::get_meta( $post_id, 'date' );
		$lieu  = GBE_Frontend::get_meta( $post_id, 'lieu' );
		$type  = GBE_Frontend::get_meta( $post_id, 'type_evenement' );
		$label = $date ? date_i18n( get_option( 'date_format' ), strtotime( $date ) ) : '';

		ob_start();
		echo $wrap ? '<aside class="gbe-evenement-detail">' : '<aside class="gbe-evenement-detail gbe-evenement-detail--appended">';

		if ( $type ) {
			printf( '<p><span class="gbe-tag gbe-tag--event">%s</span></p>', esc_html( self::get_event_type_label( $type ) ) );
		}
		if ( $label ) {
			printf( '<p class="gbe-evenement-detail__date"><strong>%s</strong> %s</p>', esc_html__( 'Date :', 'gbecosmolingua-core' ), esc_html( $label ) );
		}
		if ( $lieu ) {
			printf( '<p class="gbe-evenement-detail__lieu"><strong>%s</strong> %s</p>', esc_html__( 'Lieu :', 'gbecosmolingua-core' ), esc_html( $lieu ) );
		}

		echo '</aside>';
		return ob_get_clean();
	}

	/**
	 * Render partner detail block.
	 *
	 * @param int  $post_id Post ID.
	 * @param bool $wrap    Wrap in container.
	 */
	public static function render_partenaire_detail( $post_id, $wrap = true ) {
		$url     = GBE_Frontend::get_meta( $post_id, 'url' );
		$pays    = GBE_Frontend::get_meta( $post_id, 'pays' );
		$contact = GBE_Frontend::get_meta( $post_id, 'contact' );
		$types   = get_the_terms( $post_id, 'type_partenaire' );

		ob_start();
		echo $wrap ? '<aside class="gbe-partenaire-detail">' : '<aside class="gbe-partenaire-detail gbe-partenaire-detail--appended">';

		if ( $types && ! is_wp_error( $types ) ) {
			echo '<p class="gbe-meta-tags">';
			foreach ( $types as $term ) {
				printf( '<span class="gbe-tag">%s</span>', esc_html( $term->name ) );
			}
			echo '</p>';
		}
		if ( $pays ) {
			printf( '<p><strong>%s</strong> %s</p>', esc_html__( 'Pays :', 'gbecosmolingua-core' ), esc_html( $pays ) );
		}
		if ( $url ) {
			printf( '<p><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></p>', esc_url( $url ), esc_html__( 'Site web du partenaire', 'gbecosmolingua-core' ) );
		}
		if ( $contact ) {
			printf( '<p><strong>%s</strong> %s</p>', esc_html__( 'Contact :', 'gbecosmolingua-core' ), esc_html( $contact ) );
		}

		echo '</aside>';
		return ob_get_clean();
	}

	private static function get_event_type_label( $type ) {
		$labels = array(
			'colloque'    => __( 'Colloque', 'gbecosmolingua-core' ),
			'conference'  => __( 'Conférence', 'gbecosmolingua-core' ),
			'seminaire'   => __( 'Séminaire', 'gbecosmolingua-core' ),
			'atelier'     => __( 'Atelier', 'gbecosmolingua-core' ),
			'publication' => __( 'Publication', 'gbecosmolingua-core' ),
		);

		return isset( $labels[ $type ] ) ? $labels[ $type ] : ucfirst( $type );
	}
}
