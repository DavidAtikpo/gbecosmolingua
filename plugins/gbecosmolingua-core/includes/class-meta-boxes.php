<?php
/**
 * Meta boxes for GbeCosmoLingua CPTs.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handles custom meta fields in the admin.
 */
class GBE_Meta_Boxes {

	/**
	 * Initialize hooks.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save_meta' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ) );
		add_filter( 'manage_membre_gbe_posts_columns', array( __CLASS__, 'membre_columns' ) );
		add_action( 'manage_membre_gbe_posts_custom_column', array( __CLASS__, 'membre_column_content' ), 10, 2 );
	}

	/**
	 * Enqueue admin styles.
	 */
	public static function enqueue_admin_styles( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}
		wp_enqueue_style(
			'gbe-admin',
			GBE_CORE_URL . 'assets/css/admin.css',
			array(),
			GBE_CORE_VERSION
		);
	}

	/**
	 * Scripts admin (médiathèque pour les photos membres).
	 *
	 * @param string $hook Current admin page.
	 */
	public static function enqueue_admin_scripts( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen || 'membre_gbe' !== $screen->post_type ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script(
			'gbe-membre-photo-admin',
			GBE_CORE_URL . 'assets/js/membre-photo-admin.js',
			array( 'jquery' ),
			GBE_CORE_VERSION,
			true
		);
	}

	/**
	 * Register meta boxes per post type.
	 */
	public static function add_meta_boxes() {
		add_meta_box(
			'gbe_proverbe_details',
			__( 'Détails du proverbe', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_proverbe_box' ),
			'proverbe',
			'normal',
			'high'
		);

		add_meta_box(
			'gbe_genre_oral_details',
			__( 'Archives Xótùtù', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_genre_oral_box' ),
			'genre_oral',
			'normal',
			'high'
		);

		add_meta_box(
			'gbe_partenaire_details',
			__( 'Informations partenaire', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_partenaire_box' ),
			'partenaire',
			'normal',
			'high'
		);

		add_meta_box(
			'gbe_membre_details',
			__( 'Informations du membre', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_membre_box' ),
			'membre_gbe',
			'normal',
			'high'
		);

		add_meta_box(
			'gbe_membre_photo_help',
			__( 'Photo du membre', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_membre_photo_help_box' ),
			'membre_gbe',
			'side',
			'high'
		);

		add_meta_box(
			'gbe_evenement_details',
			__( 'Détails de l\'événement', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_evenement_box' ),
			'evenement',
			'side',
			'default'
		);

		add_meta_box(
			'gbe_ressource_details',
			__( 'Fichier ressource', 'gbecosmolingua-core' ),
			array( __CLASS__, 'render_ressource_box' ),
			'ressource',
			'normal',
			'high'
		);
	}

	/**
	 * Render proverbe meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_proverbe_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$fields = array(
			'texte_original'         => __( 'Texte original', 'gbecosmolingua-core' ),
			'transcription'          => __( 'Transcription', 'gbecosmolingua-core' ),
			'traduction_fr'          => __( 'Traduction française', 'gbecosmolingua-core' ),
			'traduction_en'          => __( 'Traduction anglaise', 'gbecosmolingua-core' ),
			'traduction_es'          => __( 'Traduction espagnole', 'gbecosmolingua-core' ),
			'traduction_ru'          => __( 'Traduction russe', 'gbecosmolingua-core' ),
			'contexte'               => __( 'Contexte d\'emploi', 'gbecosmolingua-core' ),
			'commentaire_culturel'   => __( 'Commentaire culturel', 'gbecosmolingua-core' ),
			'analyse_linguistique'   => __( 'Analyse linguistique', 'gbecosmolingua-core' ),
			'analyse_pragmatique'    => __( 'Analyse pragmatique', 'gbecosmolingua-core' ),
			'analyse_ethnographique' => __( 'Analyse ethnographique', 'gbecosmolingua-core' ),
		);

		echo '<div class="gbe-meta-fields">';
		foreach ( $fields as $key => $label ) {
			$value = get_post_meta( $post->ID, '_gbe_' . $key, true );
			$is_long = in_array( $key, array( 'contexte', 'commentaire_culturel', 'analyse_linguistique', 'analyse_pragmatique', 'analyse_ethnographique' ), true );
			self::render_field( $key, $label, $value, $is_long );
		}
		echo '</div>';
	}

	/**
	 * Render genre oral meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_genre_oral_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$audio_id  = get_post_meta( $post->ID, '_gbe_audio_id', true );
		$video_id  = get_post_meta( $post->ID, '_gbe_video_id', true );
		$source    = get_post_meta( $post->ID, '_gbe_source', true );
		$transcript = get_post_meta( $post->ID, '_gbe_transcription_orale', true );

		?>
		<div class="gbe-meta-fields">
			<?php self::render_media_field( 'audio_id', __( 'Archive audio', 'gbecosmolingua-core' ), $audio_id ); ?>
			<?php self::render_media_field( 'video_id', __( 'Archive vidéo', 'gbecosmolingua-core' ), $video_id ); ?>
			<?php self::render_field( 'source', __( 'Source / informateur', 'gbecosmolingua-core' ), $source ); ?>
			<?php self::render_field( 'transcription_orale', __( 'Transcription', 'gbecosmolingua-core' ), $transcript, true ); ?>
		</div>
		<?php
	}

	/**
	 * Render partenaire meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_partenaire_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$url    = get_post_meta( $post->ID, '_gbe_url', true );
		$pays   = get_post_meta( $post->ID, '_gbe_pays', true );
		$contact = get_post_meta( $post->ID, '_gbe_contact', true );

		?>
		<div class="gbe-meta-fields">
			<?php self::render_field( 'url', __( 'Site web', 'gbecosmolingua-core' ), $url, false, 'url' ); ?>
			<?php self::render_field( 'pays', __( 'Pays', 'gbecosmolingua-core' ), $pays ); ?>
			<?php self::render_field( 'contact', __( 'Contact', 'gbecosmolingua-core' ), $contact ); ?>
		</div>
		<?php
	}

	/**
	 * Render membre meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_membre_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$fonction = get_post_meta( $post->ID, '_gbe_fonction', true );

		?>
		<div class="gbe-meta-fields">
			<?php self::render_field( 'fonction', __( 'Fonction / rôle', 'gbecosmolingua-core' ), $fonction ); ?>
			<p class="description">
				<?php esc_html_e( 'Exemple : Président-Fondateur, Vice-Président — Membre Fondateur…', 'gbecosmolingua-core' ); ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Photo du membre — sélecteur médiathèque WordPress.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_membre_photo_help_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$thumb_id   = (int) get_post_thumbnail_id( $post );
		$theme_path = (string) get_post_meta( $post->ID, '_gbe_photo_theme', true );
		$preview    = $thumb_id
			? wp_get_attachment_image( $thumb_id, 'medium', false, array( 'style' => 'max-width:100%;height:auto;border-radius:12px;' ) )
			: '';
		?>
		<div class="gbe-membre-photo-admin">
			<input type="hidden" id="gbe_membre_thumbnail_id" name="gbe_membre_thumbnail_id" value="<?php echo esc_attr( (string) $thumb_id ); ?>">
			<div class="gbe-membre-photo-admin__preview" id="gbe_membre_photo_preview">
				<?php
				if ( $preview ) {
					echo $preview; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} elseif ( '' !== $theme_path && class_exists( 'GBE_Membres_Photos' ) ) {
					$theme_url = GBE_Membres_Photos::resolve_theme_url( $theme_path );
					if ( '' !== $theme_url ) {
						printf(
							'<img src="%s" alt="" style="max-width:100%%;height:auto;border-radius:12px;" />',
							esc_url( $theme_url )
						);
						echo '<p class="description">' . esc_html__( 'Photo par défaut du thème (non enregistrée en médiathèque).', 'gbecosmolingua-core' ) . '</p>';
					}
				} else {
					echo '<p class="gbe-membre-photo-admin__empty"><em>' . esc_html__( 'Aucune photo.', 'gbecosmolingua-core' ) . '</em></p>';
				}
				?>
			</div>
			<p class="gbe-membre-photo-admin__actions">
				<button type="button" class="button button-primary gbe-membre-photo-select"><?php esc_html_e( 'Choisir / téléverser une photo', 'gbecosmolingua-core' ); ?></button>
				<button type="button" class="button gbe-membre-photo-remove" <?php disabled( $thumb_id <= 0 ); ?>><?php esc_html_e( 'Supprimer', 'gbecosmolingua-core' ); ?></button>
			</p>
			<p class="description"><?php esc_html_e( 'Portrait carré ou 3:4, min. 400×400 px. La photo choisie ici remplace celle du thème sur le site.', 'gbecosmolingua-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Colonnes admin liste des membres.
	 *
	 * @param array<string, string> $columns Colonnes.
	 * @return array<string, string>
	 */
	public static function membre_columns( $columns ) {
		$new = array();
		foreach ( $columns as $key => $label ) {
			if ( 'title' === $key ) {
				$new['gbe_membre_photo'] = __( 'Photo', 'gbecosmolingua-core' );
			}
			$new[ $key ] = $label;
			if ( 'title' === $key ) {
				$new['gbe_membre_fonction'] = __( 'Fonction', 'gbecosmolingua-core' );
			}
		}
		return $new;
	}

	/**
	 * Contenu colonnes admin membres.
	 *
	 * @param string $column  Colonne.
	 * @param int    $post_id ID post.
	 */
	public static function membre_column_content( $column, $post_id ) {
		if ( 'gbe_membre_photo' === $column ) {
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, array( 48, 48 ), array( 'style' => 'border-radius:50%;object-fit:cover;' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo '—';
			}
			return;
		}

		if ( 'gbe_membre_fonction' === $column ) {
			echo esc_html( (string) get_post_meta( $post_id, '_gbe_fonction', true ) );
		}
	}

	/**
	 * Render evenement meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_evenement_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$date  = get_post_meta( $post->ID, '_gbe_date', true );
		$lieu  = get_post_meta( $post->ID, '_gbe_lieu', true );
		$type  = get_post_meta( $post->ID, '_gbe_type_evenement', true );

		?>
		<p>
			<label for="gbe_date"><strong><?php esc_html_e( 'Date', 'gbecosmolingua-core' ); ?></strong></label><br>
			<input type="date" id="gbe_date" name="gbe_date" value="<?php echo esc_attr( $date ); ?>" class="widefat">
		</p>
		<p>
			<label for="gbe_lieu"><strong><?php esc_html_e( 'Lieu', 'gbecosmolingua-core' ); ?></strong></label><br>
			<input type="text" id="gbe_lieu" name="gbe_lieu" value="<?php echo esc_attr( $lieu ); ?>" class="widefat">
		</p>
		<p>
			<label for="gbe_type_evenement"><strong><?php esc_html_e( 'Type', 'gbecosmolingua-core' ); ?></strong></label><br>
			<select id="gbe_type_evenement" name="gbe_type_evenement" class="widefat">
				<?php
				$types = array( '', 'colloque', 'conference', 'seminaire', 'atelier', 'publication' );
				$labels = array(
					''            => __( '— Sélectionner —', 'gbecosmolingua-core' ),
					'colloque'    => __( 'Colloque', 'gbecosmolingua-core' ),
					'conference'  => __( 'Conférence', 'gbecosmolingua-core' ),
					'seminaire'   => __( 'Séminaire', 'gbecosmolingua-core' ),
					'atelier'     => __( 'Atelier', 'gbecosmolingua-core' ),
					'publication' => __( 'Publication', 'gbecosmolingua-core' ),
				);
				foreach ( $types as $t ) {
					printf(
						'<option value="%s" %s>%s</option>',
						esc_attr( $t ),
						selected( $type, $t, false ),
						esc_html( $labels[ $t ] )
					);
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * Render ressource meta box.
	 *
	 * @param WP_Post $post Current post.
	 */
	public static function render_ressource_box( $post ) {
		wp_nonce_field( 'gbe_save_meta', 'gbe_meta_nonce' );

		$file_id   = get_post_meta( $post->ID, '_gbe_fichier_id', true );
		$type_doc  = get_post_meta( $post->ID, '_gbe_type_document', true );
		$auteur    = get_post_meta( $post->ID, '_gbe_auteur', true );

		?>
		<div class="gbe-meta-fields">
			<?php self::render_media_field( 'fichier_id', __( 'Fichier', 'gbecosmolingua-core' ), $file_id ); ?>
			<p>
				<label for="gbe_type_document"><strong><?php esc_html_e( 'Type de document', 'gbecosmolingua-core' ); ?></strong></label><br>
				<select id="gbe_type_document" name="gbe_type_document" class="widefat">
					<?php
					$types = array( 'manuscrit', 'corpus', 'article', 'audio', 'video', 'lexique' );
					foreach ( $types as $t ) {
						printf(
							'<option value="%s" %s>%s</option>',
							esc_attr( $t ),
							selected( $type_doc, $t, false ),
							esc_html( ucfirst( $t ) )
						);
					}
					?>
				</select>
			</p>
			<?php self::render_field( 'auteur', __( 'Auteur / source', 'gbecosmolingua-core' ), $auteur ); ?>
		</div>
		<?php
	}

	/**
	 * Render a text field.
	 */
	private static function render_field( $key, $label, $value, $textarea = false, $type = 'text' ) {
		$name = 'gbe_' . $key;
		echo '<p class="gbe-field">';
		echo '<label for="' . esc_attr( $name ) . '"><strong>' . esc_html( $label ) . '</strong></label><br>';
		if ( $textarea ) {
			echo '<textarea id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" rows="4" class="widefat">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input type="' . esc_attr( $type ) . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" class="widefat">';
		}
		echo '</p>';
	}

	/**
	 * Render a media attachment field.
	 */
	private static function render_media_field( $key, $label, $attachment_id ) {
		$name = 'gbe_' . $key;
		$url  = $attachment_id ? wp_get_attachment_url( $attachment_id ) : '';
		?>
		<p class="gbe-field gbe-media-field">
			<label><strong><?php echo esc_html( $label ); ?></strong></label><br>
			<input type="hidden" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $attachment_id ); ?>">
			<span class="gbe-media-preview"><?php echo $url ? esc_html( basename( $url ) ) : esc_html__( 'Aucun fichier', 'gbecosmolingua-core' ); ?></span>
			<button type="button" class="button gbe-upload-media" data-target="<?php echo esc_attr( $name ); ?>"><?php esc_html_e( 'Choisir un fichier', 'gbecosmolingua-core' ); ?></button>
			<button type="button" class="button gbe-remove-media" data-target="<?php echo esc_attr( $name ); ?>"><?php esc_html_e( 'Retirer', 'gbecosmolingua-core' ); ?></button>
		</p>
		<?php
	}

	/**
	 * Save meta fields.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public static function save_meta( $post_id, $post ) {
		if ( ! isset( $_POST['gbe_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gbe_meta_nonce'] ) ), 'gbe_save_meta' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$allowed_types = array( 'proverbe', 'genre_oral', 'partenaire', 'membre_gbe', 'evenement', 'ressource' );
		if ( ! in_array( $post->post_type, $allowed_types, true ) ) {
			return;
		}

		$text_fields = array(
			'texte_original', 'transcription', 'traduction_fr', 'traduction_en',
			'traduction_es', 'traduction_ru', 'contexte', 'commentaire_culturel',
			'analyse_linguistique', 'analyse_pragmatique', 'analyse_ethnographique',
			'source', 'transcription_orale', 'url', 'pays', 'contact', 'fonction',
			'date', 'lieu', 'type_evenement', 'type_document', 'auteur',
		);

		foreach ( $text_fields as $field ) {
			$key = 'gbe_' . $field;
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, '_gbe_' . $field, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}

		$int_fields = array( 'audio_id', 'video_id', 'fichier_id' );
		foreach ( $int_fields as $field ) {
			$key = 'gbe_' . $field;
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, '_gbe_' . $field, absint( $_POST[ $key ] ) );
			}
		}

		if ( 'membre_gbe' === $post->post_type && isset( $_POST['gbe_membre_thumbnail_id'] ) ) {
			self::save_membre_thumbnail( $post_id, absint( wp_unslash( $_POST['gbe_membre_thumbnail_id'] ) ) );
		}
	}

	/**
	 * Enregistre la photo d’un membre (image mise en avant).
	 *
	 * @param int $post_id   ID membre.
	 * @param int $thumb_id  ID attachment ou 0 pour retirer.
	 */
	private static function save_membre_thumbnail( $post_id, $thumb_id ) {
		$post_id  = (int) $post_id;
		$thumb_id = (int) $thumb_id;

		if ( $post_id <= 0 ) {
			return;
		}

		if ( $thumb_id > 0 ) {
			set_post_thumbnail( $post_id, $thumb_id );
			delete_post_meta( $post_id, '_gbe_photo_theme' );
			delete_post_meta( $post_id, '_gbe_photo_theme_mtime' );
			return;
		}

		delete_post_thumbnail( $post_id );
	}
}

// Media uploader JS inline on admin footer.
add_action(
	'admin_footer',
	function () {
		$screen = get_current_screen();
		if ( ! $screen || 'post' !== $screen->base ) {
			return;
		}
		?>
		<script>
		jQuery(function($) {
			var frame;
			$(document).on('click', '.gbe-upload-media', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				if (frame) { frame.open(); return; }
				frame = wp.media({ title: 'Sélectionner un fichier', multiple: false });
				frame.on('select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					$('#' + target).val(attachment.id);
					$('#' + target).siblings('.gbe-media-preview').text(attachment.filename);
				});
				frame.open();
			});
			$(document).on('click', '.gbe-remove-media', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('#' + target).val('');
				$('#' + target).siblings('.gbe-media-preview').text('Aucun fichier');
			});
		});
		</script>
		<?php
	}
);
