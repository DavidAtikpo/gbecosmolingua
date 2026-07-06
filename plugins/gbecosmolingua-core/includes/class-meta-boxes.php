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

		$allowed_types = array( 'proverbe', 'genre_oral', 'partenaire', 'evenement', 'ressource' );
		if ( ! in_array( $post->post_type, $allowed_types, true ) ) {
			return;
		}

		$text_fields = array(
			'texte_original', 'transcription', 'traduction_fr', 'traduction_en',
			'traduction_es', 'traduction_ru', 'contexte', 'commentaire_culturel',
			'analyse_linguistique', 'analyse_pragmatique', 'analyse_ethnographique',
			'source', 'transcription_orale', 'url', 'pays', 'contact',
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
