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

	/**
	 * Register shortcodes.
	 */
	public static function init() {
		add_shortcode( 'gbe_carte_interactive', array( __CLASS__, 'carte_interactive' ) );
		add_shortcode( 'gbe_proverbes_list', array( __CLASS__, 'proverbes_list' ) );
		add_shortcode( 'gbe_proverbe_detail', array( __CLASS__, 'proverbe_detail' ) );
		add_shortcode( 'gbe_xotutu_list', array( __CLASS__, 'xotutu_list' ) );
		add_shortcode( 'gbe_bibliotheque', array( __CLASS__, 'bibliotheque' ) );
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
}
