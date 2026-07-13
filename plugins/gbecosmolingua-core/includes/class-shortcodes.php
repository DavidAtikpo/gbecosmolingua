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
		add_shortcode( 'gbe_menu_principal', array( __CLASS__, 'menu_principal' ) );
	}

	/**
	 * Main navigation with dropdown submenus from the page tree.
	 */
	public static function menu_principal() {
		$rubrique_slugs = array(
			'le-gbe',
			'cultures-gbe',
			'xotutu',
			'paremiologie',
			'recherche-et-innovation',
			'sejours-et-mobilite',
			'sport-et-jeunesse',
			'partenaires',
			'nous-soutenir',
			'notre-philosophie',
		);

		ob_start();
		?>
		<nav class="gbe-main-menu" aria-label="<?php esc_attr_e( 'Menu principal', 'gbecosmolingua-core' ); ?>">
			<ul class="gbe-main-menu__list">
				<?php foreach ( $rubrique_slugs as $slug ) : ?>
					<?php echo self::render_menu_item( $slug ); ?>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render one top-level menu item with optional horizontal mega-submenu.
	 *
	 * @param string $slug Page slug.
	 */
	private static function render_menu_item( $slug ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page ) {
			return '';
		}

		$children = get_pages(
			array(
				'parent'      => $page->ID,
				'sort_column' => 'menu_order,post_title',
				'post_status' => 'publish',
			)
		);

		$has_children = ! empty( $children );
		$url          = get_permalink( $page );

		ob_start();
		?>
		<li class="gbe-main-menu__item<?php echo $has_children ? ' has-children' : ''; ?>">
			<a href="<?php echo esc_url( $url ); ?>" class="gbe-main-menu__link">
				<?php echo esc_html( $page->post_title ); ?>
			</a>
			<?php if ( $has_children ) : ?>
				<?php
				$visible_children = array_slice( $children, 0, self::MENU_COLUMN_LIMIT );
				$has_more_columns = count( $children ) > self::MENU_COLUMN_LIMIT;
				?>
				<div class="gbe-main-menu__panel" role="region" aria-label="<?php echo esc_attr( sprintf( __( 'Sous-menu %s', 'gbecosmolingua-core' ), $page->post_title ) ); ?>">
					<div class="gbe-main-menu__panel-inner">
						<?php foreach ( $visible_children as $child ) : ?>
							<?php echo self::render_menu_column( $child ); ?>
						<?php endforeach; ?>
						<?php if ( $has_more_columns ) : ?>
							<div class="gbe-main-menu__column gbe-main-menu__column--more">
								<p class="gbe-main-menu__column-title">
									<a href="<?php echo esc_url( $url ); ?>">
										<?php esc_html_e( 'Voir plus', 'gbecosmolingua-core' ); ?>
									</a>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</li>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render one horizontal submenu column (grand titre + sections).
	 *
	 * @param WP_Post $page Child page.
	 */
	private static function render_menu_column( $page ) {
		$grandchildren = get_pages(
			array(
				'parent'      => $page->ID,
				'sort_column' => 'menu_order,post_title',
				'post_status' => 'publish',
			)
		);

		$sections = array();
		if ( ! empty( $grandchildren ) ) {
			foreach ( $grandchildren as $grandchild ) {
				$sections[] = array(
					'label' => $grandchild->post_title,
					'url'   => get_permalink( $grandchild ),
				);
			}
		} else {
			$sections = self::get_page_section_labels( $page->post_content, get_permalink( $page ) );
		}

		$visible_sections = array_slice( $sections, 0, self::MENU_SECTION_LIMIT );
		$has_more_sections = count( $sections ) > self::MENU_SECTION_LIMIT;
		$page_url           = get_permalink( $page );

		ob_start();
		?>
		<div class="gbe-main-menu__column">
			<p class="gbe-main-menu__column-title">
				<a href="<?php echo esc_url( $page_url ); ?>">
					<?php echo esc_html( $page->post_title ); ?>
				</a>
			</p>
			<?php if ( ! empty( $visible_sections ) || $has_more_sections ) : ?>
				<ul class="gbe-main-menu__column-list">
					<?php foreach ( $visible_sections as $section ) : ?>
						<li class="gbe-main-menu__column-item">
							<?php if ( ! empty( $section['url'] ) ) : ?>
								<a href="<?php echo esc_url( $section['url'] ); ?>">
									<?php echo esc_html( $section['label'] ); ?>
								</a>
							<?php else : ?>
								<span><?php echo esc_html( $section['label'] ); ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
					<?php if ( $has_more_sections ) : ?>
						<li class="gbe-main-menu__column-item gbe-main-menu__column-item--more">
							<a href="<?php echo esc_url( $page_url ); ?>">
								<?php esc_html_e( 'Plus', 'gbecosmolingua-core' ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Extract section headings from page content (h3 or outline list).
	 *
	 * @param string $content Page HTML content.
	 * @param string $url     Parent page URL for section links.
	 * @return array<int, array{label: string, url: string}>
	 */
	private static function get_page_section_labels( $content, $url ) {
		$sections = array();

		if ( preg_match_all( '/<h3[^>]*>(.*?)<\/h3>/is', $content, $matches ) ) {
			foreach ( $matches[1] as $heading ) {
				$sections[] = array(
					'label' => wp_strip_all_tags( $heading ),
					'url'   => $url,
				);
			}
		}

		if ( empty( $sections ) && preg_match( '/<ul[^>]*>(.*?)<\/ul>/is', $content, $list_match ) ) {
			if ( preg_match_all( '/<li[^>]*>(.*?)<\/li>/is', $list_match[1], $items ) ) {
				foreach ( $items[1] as $item ) {
					$label = wp_strip_all_tags( $item );
					if ( '' !== $label ) {
						$sections[] = array(
							'label' => $label,
							'url'   => $url,
						);
					}
				}
			}
		}

		return $sections;
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
				'limit'  => 12,
			),
			$atts,
			'gbe_proverbes_list'
		);

		$langue_filter = isset( $_GET['langue_gbe'] ) ? sanitize_text_field( wp_unslash( $_GET['langue_gbe'] ) ) : $atts['langue'];
		$search        = isset( $_GET['gbe_q'] ) ? sanitize_text_field( wp_unslash( $_GET['gbe_q'] ) ) : '';

		$args = array(
			'post_type'      => 'proverbe',
			'posts_per_page' => (int) $atts['limit'],
			'post_status'    => 'publish',
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

		$query  = new WP_Query( $args );
		$langues = get_terms( array( 'taxonomy' => 'langue_gbe', 'hide_empty' => false ) );

		ob_start();
		?>
		<div class="gbe-proverbes-archive">
			<form class="gbe-filters" method="get" action="">
				<label for="gbe_q"><?php esc_html_e( 'Rechercher', 'gbecosmolingua-core' ); ?></label>
				<input type="search" id="gbe_q" name="gbe_q" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Mot-clé…', 'gbecosmolingua-core' ); ?>">

				<label for="langue_gbe"><?php esc_html_e( 'Langue', 'gbecosmolingua-core' ); ?></label>
				<select id="langue_gbe" name="langue_gbe">
					<option value=""><?php esc_html_e( 'Toutes les langues', 'gbecosmolingua-core' ); ?></option>
					<?php foreach ( $langues as $term ) : ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $langue_filter, $term->slug ); ?>>
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
						echo self::render_proverbe_card( get_the_ID() );
					endwhile;
					?>
				</div>
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
	 * Render a proverb card for archives.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function render_proverbe_card( $post_id ) {
		$texte = GBE_Frontend::get_meta( $post_id, 'texte_original' );
		$trad  = GBE_Frontend::get_meta( $post_id, 'traduction_fr' );
		$langues = get_the_terms( $post_id, 'langue_gbe' );

		ob_start();
		?>
		<article class="gbe-card gbe-card--proverbe">
			<?php if ( $langues && ! is_wp_error( $langues ) ) : ?>
				<div class="gbe-card__tags">
					<?php foreach ( $langues as $term ) : ?>
						<span class="gbe-tag"><?php echo esc_html( $term->name ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ( $texte ) : ?>
				<blockquote class="gbe-card__quote"><?php echo esc_html( $texte ); ?></blockquote>
			<?php endif; ?>
			<?php if ( $trad ) : ?>
				<p class="gbe-card__excerpt"><?php echo esc_html( wp_trim_words( $trad, 25 ) ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="gbe-card__link">
				<?php esc_html_e( 'Voir le proverbe', 'gbecosmolingua-core' ); ?> →
			</a>
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
