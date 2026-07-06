<?php
/**
 * Contact and support forms for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handles public forms and submission storage.
 */
class GBE_Forms {

	/**
	 * Form definitions.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function get_form_types() {
		return array(
			'partenaire' => array(
				'title'  => __( 'Devenir partenaire', 'gbecosmolingua-core' ),
				'intro'  => __( 'Universités, institutions, associations, entreprises et collectivités.', 'gbecosmolingua-core' ),
				'fields' => array(
					'organisation' => array( 'label' => __( 'Organisation', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'type_org'     => array(
						'label'    => __( 'Type d\'organisation', 'gbecosmolingua-core' ),
						'type'     => 'select',
						'required' => true,
						'options'  => array(
							'universite'    => __( 'Université', 'gbecosmolingua-core' ),
							'association'   => __( 'Association', 'gbecosmolingua-core' ),
							'entreprise'    => __( 'Entreprise', 'gbecosmolingua-core' ),
							'collectivite'  => __( 'Collectivité', 'gbecosmolingua-core' ),
							'institution'   => __( 'Institution culturelle', 'gbecosmolingua-core' ),
							'autre'         => __( 'Autre', 'gbecosmolingua-core' ),
						),
					),
					'nom'          => array( 'label' => __( 'Nom du contact', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'email'        => array( 'label' => __( 'Email', 'gbecosmolingua-core' ), 'type' => 'email', 'required' => true ),
					'telephone'    => array( 'label' => __( 'Téléphone', 'gbecosmolingua-core' ), 'type' => 'tel', 'required' => false ),
					'message'      => array( 'label' => __( 'Message / projet de partenariat', 'gbecosmolingua-core' ), 'type' => 'textarea', 'required' => true ),
				),
			),
			'mecene' => array(
				'title'  => __( 'Devenir mécène', 'gbecosmolingua-core' ),
				'intro'  => __( 'Contribuez à la sauvegarde et à la promotion du patrimoine gbe.', 'gbecosmolingua-core' ),
				'fields' => array(
					'nom'          => array( 'label' => __( 'Nom / Organisation', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'email'        => array( 'label' => __( 'Email', 'gbecosmolingua-core' ), 'type' => 'email', 'required' => true ),
					'telephone'    => array( 'label' => __( 'Téléphone', 'gbecosmolingua-core' ), 'type' => 'tel', 'required' => false ),
					'engagement'   => array(
						'label'    => __( 'Type d\'engagement envisagé', 'gbecosmolingua-core' ),
						'type'     => 'select',
						'required' => true,
						'options'  => array(
							'financier'  => __( 'Soutien financier', 'gbecosmolingua-core' ),
							'equipement' => __( 'Don de matériel', 'gbecosmolingua-core' ),
							'expertise'  => __( 'Mise à disposition d\'expertise', 'gbecosmolingua-core' ),
							'autre'      => __( 'Autre', 'gbecosmolingua-core' ),
						),
					),
					'message'      => array( 'label' => __( 'Message', 'gbecosmolingua-core' ), 'type' => 'textarea', 'required' => true ),
				),
			),
			'projet' => array(
				'title'  => __( 'Proposer un projet', 'gbecosmolingua-core' ),
				'intro'  => __( 'Initiatives culturelles, éducatives ou scientifiques.', 'gbecosmolingua-core' ),
				'fields' => array(
					'titre_projet' => array( 'label' => __( 'Titre du projet', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'porteur'      => array( 'label' => __( 'Porteur du projet', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'email'        => array( 'label' => __( 'Email', 'gbecosmolingua-core' ), 'type' => 'email', 'required' => true ),
					'domaine'      => array(
						'label'    => __( 'Domaine', 'gbecosmolingua-core' ),
						'type'     => 'select',
						'required' => true,
						'options'  => array(
							'culture'     => __( 'Culture', 'gbecosmolingua-core' ),
							'education'   => __( 'Éducation', 'gbecosmolingua-core' ),
							'recherche'   => __( 'Recherche', 'gbecosmolingua-core' ),
							'patrimoine'  => __( 'Patrimoine', 'gbecosmolingua-core' ),
							'interculturel' => __( 'Interculturalité', 'gbecosmolingua-core' ),
						),
					),
					'description'  => array( 'label' => __( 'Description du projet', 'gbecosmolingua-core' ), 'type' => 'textarea', 'required' => true ),
				),
			),
			'stagiaire' => array(
				'title'  => __( 'Accueillir un stagiaire ou un chercheur', 'gbecosmolingua-core' ),
				'intro'  => __( 'Participez aux programmes de mobilité et de coopération internationale.', 'gbecosmolingua-core' ),
				'fields' => array(
					'organisation' => array( 'label' => __( 'Organisation d\'accueil', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'nom'          => array( 'label' => __( 'Nom du contact', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'email'        => array( 'label' => __( 'Email', 'gbecosmolingua-core' ), 'type' => 'email', 'required' => true ),
					'type_demande' => array(
						'label'    => __( 'Type de demande', 'gbecosmolingua-core' ),
						'type'     => 'select',
						'required' => true,
						'options'  => array(
							'accueil'  => __( 'Je peux accueillir', 'gbecosmolingua-core' ),
							'chercher' => __( 'Je cherche un accueil', 'gbecosmolingua-core' ),
						),
					),
					'message'      => array( 'label' => __( 'Précisions (dates, domaine, profil)', 'gbecosmolingua-core' ), 'type' => 'textarea', 'required' => true ),
				),
			),
			'don' => array(
				'title'  => __( 'Faire un don', 'gbecosmolingua-core' ),
				'intro'  => '',
				'fields' => array(
					'nom'     => array( 'label' => __( 'Nom', 'gbecosmolingua-core' ), 'type' => 'text', 'required' => true ),
					'email'   => array( 'label' => __( 'Email', 'gbecosmolingua-core' ), 'type' => 'email', 'required' => true ),
					'montant' => array(
						'label'    => __( 'Montant (EUR)', 'gbecosmolingua-core' ),
						'type'     => 'select',
						'required' => true,
						'options'  => array(
							'25'   => '25 €',
							'50'   => '50 €',
							'100'  => '100 €',
							'250'  => '250 €',
							'autre' => __( 'Autre montant', 'gbecosmolingua-core' ),
						),
					),
					'montant_libre' => array( 'label' => __( 'Montant libre (EUR)', 'gbecosmolingua-core' ), 'type' => 'number', 'required' => false ),
					'message' => array( 'label' => __( 'Message (optionnel)', 'gbecosmolingua-core' ), 'type' => 'textarea', 'required' => false ),
				),
			),
		);
	}

	/**
	 * Initialize hooks.
	 */
	public static function init() {
		add_shortcode( 'gbe_formulaire', array( __CLASS__, 'render_shortcode' ) );
		add_action( 'admin_post_gbe_submit_form', array( __CLASS__, 'handle_submit' ) );
		add_action( 'admin_post_nopriv_gbe_submit_form', array( __CLASS__, 'handle_submit' ) );
		add_action( 'init', array( __CLASS__, 'register_soumission_cpt' ) );
	}

	/**
	 * Register private CPT for form submissions.
	 */
	public static function register_soumission_cpt() {
		register_post_type(
			'gbe_soumission',
			array(
				'labels'              => array(
					'name'          => __( 'Soumissions', 'gbecosmolingua-core' ),
					'singular_name' => __( 'Soumission', 'gbecosmolingua-core' ),
					'menu_name'     => __( 'Soumissions', 'gbecosmolingua-core' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => 'gbecosmolingua',
				'capability_type'     => 'post',
				'capabilities'        => array(
					'create_posts' => false,
				),
				'map_meta_cap'        => true,
				'supports'            => array( 'title', 'editor' ),
				'menu_icon'           => 'dashicons-email-alt',
			)
		);
	}

	/**
	 * Shortcode renderer.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public static function render_shortcode( $atts ) {
		$atts = shortcode_atts( array( 'type' => 'partenaire' ), $atts, 'gbe_formulaire' );
		$type = sanitize_key( $atts['type'] );
		$forms = self::get_form_types();

		if ( ! isset( $forms[ $type ] ) ) {
			return '';
		}

		wp_enqueue_style( 'gbe-frontend' );

		$form   = $forms[ $type ];
		$sent   = isset( $_GET['gbe_sent'] ) && '1' === $_GET['gbe_sent'];
		$donation_link = isset( $_GET['gbe_donate'] ) ? esc_url_raw( wp_unslash( $_GET['gbe_donate'] ) ) : '';

		ob_start();

		if ( $sent && 'don' === $type && $donation_link ) {
			self::render_donation_success( $donation_link );
			return ob_get_clean();
		}

		if ( $sent ) {
			echo '<div class="gbe-form-notice gbe-form-notice--success" role="status">';
			echo esc_html__( 'Votre message a bien été envoyé. Merci pour votre soutien !', 'gbecosmolingua-core' );
			echo '</div>';
			return ob_get_clean();
		}

		$intro = 'don' === $type ? GBE_Settings::get( 'donation_info' ) : $form['intro'];

		?>
		<div class="gbe-form-wrapper gbe-form-wrapper--<?php echo esc_attr( $type ); ?>">
			<?php if ( $intro ) : ?>
				<p class="gbe-form-intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>

			<form class="gbe-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'gbe_submit_form_' . $type, 'gbe_form_nonce' ); ?>
				<input type="hidden" name="action" value="gbe_submit_form">
				<input type="hidden" name="gbe_form_type" value="<?php echo esc_attr( $type ); ?>">
				<input type="hidden" name="gbe_redirect" value="<?php echo esc_url( get_permalink() ); ?>">
				<div class="gbe-honeypot" aria-hidden="true">
					<label for="gbe_website"><?php esc_html_e( 'Ne pas remplir', 'gbecosmolingua-core' ); ?></label>
					<input type="text" name="gbe_website" id="gbe_website" tabindex="-1" autocomplete="off">
				</div>

				<?php foreach ( $form['fields'] as $key => $field ) : ?>
					<?php self::render_field( $key, $field, $type ); ?>
				<?php endforeach; ?>

				<p class="gbe-form-consent">
					<label>
						<input type="checkbox" name="gbe_consent" value="1" required>
						<?php esc_html_e( 'J\'accepte que mes données soient utilisées pour traiter ma demande.', 'gbecosmolingua-core' ); ?>
					</label>
				</p>

				<button type="submit" class="gbe-btn gbe-btn--submit">
					<?php echo 'don' === $type ? esc_html__( 'Continuer vers le don', 'gbecosmolingua-core' ) : esc_html__( 'Envoyer', 'gbecosmolingua-core' ); ?>
				</button>
			</form>
			<?php if ( 'don' === $type ) : ?>
			<script>
			(function(){
				var sel = document.getElementById('gbe_don_montant');
				var libre = document.querySelector('.gbe-field--montant-libre');
				if (!sel || !libre) return;
				function toggle(){ libre.classList.toggle('is-visible', sel.value === 'autre'); }
				sel.addEventListener('change', toggle);
				toggle();
			})();
			</script>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render a single form field.
	 *
	 * @param string               $key   Field key.
	 * @param array<string, mixed> $field Field config.
	 * @param string               $type  Form type.
	 */
	private static function render_field( $key, $field, $type ) {
		$id       = 'gbe_' . $type . '_' . $key;
		$required = ! empty( $field['required'] ) ? ' required' : '';
		$extra_class = 'montant_libre' === $key ? ' gbe-field--montant-libre' : '';

		echo '<p class="gbe-form-field' . esc_attr( $extra_class ) . '">';
		echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] );
		if ( ! empty( $field['required'] ) ) {
			echo ' <span class="gbe-required">*</span>';
		}
		echo '</label>';

		if ( 'select' === $field['type'] ) {
			echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '"' . $required . '>';
			foreach ( $field['options'] as $val => $label ) {
				printf( '<option value="%s">%s</option>', esc_attr( $val ), esc_html( $label ) );
			}
			echo '</select>';
		} elseif ( 'textarea' === $field['type'] ) {
			echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '" rows="5"' . $required . '></textarea>';
		} else {
			printf(
				'<input type="%s" id="%s" name="%s"%s>',
				esc_attr( $field['type'] ),
				esc_attr( $id ),
				esc_attr( $key ),
				$required
			);
		}
		echo '</p>';
	}

	/**
	 * Render post-donation success with payment link.
	 *
	 * @param string $link Payment URL.
	 */
	private static function render_donation_success( $link ) {
		?>
		<div class="gbe-form-notice gbe-form-notice--success gbe-donation-success">
			<h3><?php esc_html_e( 'Merci pour votre générosité !', 'gbecosmolingua-core' ); ?></h3>
			<p><?php esc_html_e( 'Votre intention de don a été enregistrée. Finalisez votre contribution via le lien ci-dessous.', 'gbecosmolingua-core' ); ?></p>
			<a href="<?php echo esc_url( $link ); ?>" class="gbe-btn gbe-btn--donate" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Procéder au paiement', 'gbecosmolingua-core' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Handle form submission.
	 */
	public static function handle_submit() {
		$type = isset( $_POST['gbe_form_type'] ) ? sanitize_key( wp_unslash( $_POST['gbe_form_type'] ) ) : '';
		$forms = self::get_form_types();

		if ( ! $type || ! isset( $forms[ $type ] ) ) {
			wp_die( esc_html__( 'Formulaire invalide.', 'gbecosmolingua-core' ) );
		}

		if ( ! isset( $_POST['gbe_form_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gbe_form_nonce'] ) ), 'gbe_submit_form_' . $type ) ) {
			wp_die( esc_html__( 'Vérification de sécurité échouée.', 'gbecosmolingua-core' ) );
		}

		if ( ! empty( $_POST['gbe_website'] ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		if ( empty( $_POST['gbe_consent'] ) ) {
			wp_die( esc_html__( 'Veuillez accepter le traitement de vos données.', 'gbecosmolingua-core' ) );
		}

		$data = array();
		foreach ( $forms[ $type ]['fields'] as $key => $field ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				if ( ! empty( $field['required'] ) ) {
					wp_die( esc_html__( 'Champs obligatoires manquants.', 'gbecosmolingua-core' ) );
				}
				continue;
			}
			$value = wp_unslash( $_POST[ $key ] );
			$data[ $key ] = 'textarea' === $field['type']
				? sanitize_textarea_field( $value )
				: sanitize_text_field( $value );
		}

		if ( ! empty( $data['email'] ) && ! is_email( $data['email'] ) ) {
			wp_die( esc_html__( 'Adresse email invalide.', 'gbecosmolingua-core' ) );
		}

		$amount = 0;
		if ( 'don' === $type ) {
			$amount = ( isset( $data['montant'] ) && 'autre' === $data['montant'] && ! empty( $data['montant_libre'] ) )
				? (float) $data['montant_libre']
				: (float) ( $data['montant'] ?? 0 );
			if ( $amount <= 0 ) {
				wp_die( esc_html__( 'Montant invalide.', 'gbecosmolingua-core' ) );
			}
		}

		$title = sprintf( '[%s] %s', $forms[ $type ]['title'], $data['nom'] ?? $data['organisation'] ?? $data['titre_projet'] ?? $data['email'] ?? '' );

		$body_lines = array();
		foreach ( $data as $key => $value ) {
			$label = $forms[ $type ]['fields'][ $key ]['label'] ?? $key;
			if ( 'select' === ( $forms[ $type ]['fields'][ $key ]['type'] ?? '' ) && isset( $forms[ $type ]['fields'][ $key ]['options'][ $value ] ) ) {
				$value = $forms[ $type ]['fields'][ $key ]['options'][ $value ];
			}
			$body_lines[] = $label . ' : ' . $value;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_content' => implode( "\n", $body_lines ),
				'post_type'    => 'gbe_soumission',
				'post_status'  => 'publish',
			)
		);

		if ( ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_gbe_form_type', $type );
			update_post_meta( $post_id, '_gbe_form_data', $data );
			if ( $amount > 0 ) {
				update_post_meta( $post_id, '_gbe_donation_amount', $amount );
			}
		}

		$to      = GBE_Settings::get( 'notification_email' );
		$subject = sprintf( '[GbeCosmoLingua] %s', $title );
		$message = implode( "\n", $body_lines ) . "\n\n---\n" . home_url();
		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		if ( ! empty( $data['email'] ) ) {
			$headers[] = 'Reply-To: ' . $data['email'];
		}
		wp_mail( $to, $subject, $message, $headers );

		$redirect = isset( $_POST['gbe_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['gbe_redirect'] ) ) : home_url();
		$args     = array( 'gbe_sent' => '1' );

		if ( 'don' === $type && $amount > 0 ) {
			$donate_link = GBE_Settings::get_donation_link( $amount );
			if ( $donate_link ) {
				$args['gbe_donate'] = $donate_link;
			}
		}

		wp_safe_redirect( add_query_arg( $args, $redirect ) );
		exit;
	}
}
