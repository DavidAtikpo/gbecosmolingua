<?php
/**
 * Admin interface for GbeCosmoLingua Core.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin settings page and tools.
 */
class GBE_Admin {

	/**
	 * Initialize admin hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'admin_post_gbe_run_import', array( __CLASS__, 'handle_import' ) );
		add_action( 'admin_post_gbe_reset_import', array( __CLASS__, 'handle_reset' ) );
		add_action( 'admin_post_gbe_reset_templates', array( __CLASS__, 'handle_reset_templates' ) );
		add_action( 'admin_post_gbe_seed_demo', array( __CLASS__, 'handle_seed_demo' ) );
		add_action( 'admin_post_gbe_dedupe_pages', array( __CLASS__, 'handle_dedupe_pages' ) );
		add_action( 'admin_post_gbe_fix_permalinks', array( __CLASS__, 'handle_fix_permalinks' ) );
		add_filter( 'manage_gbe_soumission_posts_columns', array( __CLASS__, 'soumission_columns' ) );
		add_action( 'manage_gbe_soumission_posts_custom_column', array( __CLASS__, 'soumission_column_content' ), 10, 2 );
	}

	/**
	 * Add admin menu page.
	 */
	public static function add_menu() {
		add_menu_page(
			__( 'GbeCosmoLingua', 'gbecosmolingua-core' ),
			__( 'GbeCosmoLingua', 'gbecosmolingua-core' ),
			'manage_options',
			'gbecosmolingua',
			array( __CLASS__, 'render_page' ),
			'dashicons-admin-site-alt3',
			3
		);

		add_submenu_page(
			'gbecosmolingua',
			__( 'Configuration', 'gbecosmolingua-core' ),
			__( 'Configuration', 'gbecosmolingua-core' ),
			'manage_options',
			'gbecosmolingua',
			array( __CLASS__, 'render_page' )
		);

		add_submenu_page(
			'gbecosmolingua',
			__( 'Réglages', 'gbecosmolingua-core' ),
			__( 'Réglages', 'gbecosmolingua-core' ),
			'manage_options',
			'gbecosmolingua-settings',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	/**
	 * Render admin dashboard page.
	 */
	public static function render_page() {
		$imported = get_option( GBE_Page_Importer::OPTION_KEY );
		$theme    = wp_get_theme();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'GbeCosmoLingua — Configuration', 'gbecosmolingua-core' ); ?></h1>

			<div class="gbe-admin-notice">
				<p><strong><?php esc_html_e( 'Thème actif :', 'gbecosmolingua-core' ); ?></strong> <?php echo esc_html( $theme->get( 'Name' ) ); ?></p>
				<p><strong><?php esc_html_e( 'Plugin :', 'gbecosmolingua-core' ); ?></strong> <?php echo esc_html( GBE_CORE_VERSION ); ?></p>
				<p><strong><?php esc_html_e( 'Import des pages :', 'gbecosmolingua-core' ); ?></strong>
					<?php
					echo $imported
						? esc_html( sprintf( __( 'Effectué le %s', 'gbecosmolingua-core' ), wp_date( 'd/m/Y H:i', $imported ) ) )
						: esc_html__( 'Pas encore effectué', 'gbecosmolingua-core' );
					?>
				</p>
			</div>

			<h2><?php esc_html_e( 'Types de contenu disponibles', 'gbecosmolingua-core' ); ?></h2>
			<ul>
				<li><strong><?php esc_html_e( 'Proverbes', 'gbecosmolingua-core' ); ?></strong> — <?php esc_html_e( 'Banque paremiologique multilingue', 'gbecosmolingua-core' ); ?></li>
				<li><strong><?php esc_html_e( 'Xótùtù', 'gbecosmolingua-core' ); ?></strong> — <?php esc_html_e( 'Genres oraux avec archives audio/vidéo', 'gbecosmolingua-core' ); ?></li>
				<li><strong><?php esc_html_e( 'Partenaires', 'gbecosmolingua-core' ); ?></strong></li>
				<li><strong><?php esc_html_e( 'Événements', 'gbecosmolingua-core' ); ?></strong></li>
				<li><strong><?php esc_html_e( 'Ressources', 'gbecosmolingua-core' ); ?></strong></li>
			</ul>

			<h2><?php esc_html_e( 'Phase 6 — Accueil dynamique', 'gbecosmolingua-core' ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Actualités : articles WordPress — [gbe_actualites]', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Agenda : événements à venir — [gbe_agenda]', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Événements : [gbe_evenements_list] — archive /evenements/', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Annuaire partenaires : [gbe_partenaires_list]', 'gbecosmolingua-core' ); ?></li>
			</ul>

			<h2><?php esc_html_e( 'Phase 5 — Multilingue et formulaires', 'gbecosmolingua-core' ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Polylang : français, anglais, espagnol, russe', 'gbecosmolingua-core' ); ?> — <?php echo GBE_Polylang::is_active() ? '<strong style="color:green">' . esc_html__( 'Actif', 'gbecosmolingua-core' ) . '</strong>' : esc_html__( 'Non installé', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Formulaires Nous Soutenir (partenaire, mécène, projet, don, stagiaire)', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Soumissions consultables dans le menu Soumissions', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Shortcode sélecteur de langue : [gbe_lang_switcher]', 'gbecosmolingua-core' ); ?></li>
			</ul>

			<h2><?php esc_html_e( 'Phase 4 — Fonctionnalités', 'gbecosmolingua-core' ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Carte interactive Leaflet (page Carte interactive)', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Banque de proverbes filtrable', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Archives Xótùtù avec lecteur audio/vidéo', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Bibliothèque numérique', 'gbecosmolingua-core' ); ?></li>
			</ul>

			<h2><?php esc_html_e( 'Actions', 'gbecosmolingua-core' ); ?></h2>
			<div class="gbe-admin-actions" style="display:flex; flex-direction:column; gap:0.75rem; max-width:520px; margin-bottom:1rem;">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_run_import' ); ?>
					<input type="hidden" name="action" value="gbe_run_import">
					<?php submit_button( __( 'Importer / mettre à jour les pages', 'gbecosmolingua-core' ), 'primary', 'submit', false ); ?>
				</form>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_reset_templates' ); ?>
					<input type="hidden" name="action" value="gbe_reset_templates">
					<?php submit_button( __( 'Réinitialiser en-tête et pied de page', 'gbecosmolingua-core' ), 'primary', 'submit', false ); ?>
				</form>
				<p class="description" style="margin:0;">
					<?php esc_html_e( 'Recharge les fichiers en-tête et pied de page du thème.', 'gbecosmolingua-core' ); ?>
				</p>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_seed_demo' ); ?>
					<input type="hidden" name="action" value="gbe_seed_demo">
					<?php submit_button( __( 'Créer le contenu de démo', 'gbecosmolingua-core' ), 'secondary', 'submit', false ); ?>
				</form>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_fix_permalinks' ); ?>
					<input type="hidden" name="action" value="gbe_fix_permalinks">
					<?php submit_button( __( 'Réparer les permaliens (corriger les 404)', 'gbecosmolingua-core' ), 'primary', 'submit', false ); ?>
				</form>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_dedupe_pages' ); ?>
					<input type="hidden" name="action" value="gbe_dedupe_pages">
					<?php submit_button( __( 'Supprimer les pages en double', 'gbecosmolingua-core' ), 'secondary', 'submit', false ); ?>
				</form>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_reset_import' ); ?>
					<input type="hidden" name="action" value="gbe_reset_import">
					<?php submit_button( __( 'Réinitialiser le flag d\'import', 'gbecosmolingua-core' ), 'secondary', 'submit', false ); ?>
				</form>
			</div>

			<?php if ( isset( $_GET['gbe_message'] ) ) : ?>
				<div class="notice notice-success is-dismissible" style="margin-top:1rem;">
					<p><?php echo esc_html( sanitize_text_field( wp_unslash( $_GET['gbe_message'] ) ) ); ?></p>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Handle import action.
	 */
	public static function handle_import() {
		check_admin_referer( 'gbe_run_import' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		$force  = isset( $_POST['force'] ) && '1' === $_POST['force'];
		$result = GBE_Page_Importer::import( $force );
		GBE_Page_Importer::patch_phase4_shortcodes();
		GBE_Page_Importer::patch_phase5_forms();
		GBE_Page_Importer::patch_phase7_content();
		GBE_Page_Importer::restore_primary_menu();

		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( $result['message'] ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
	}

	/**
	 * Handle template parts reset.
	 */
	public static function handle_reset_templates() {
		check_admin_referer( 'gbe_reset_templates' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		$reset = GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::restore_primary_menu();

		if ( empty( $reset ) ) {
			$message = __( 'En-tête et pied de page réinitialisés depuis le thème.', 'gbecosmolingua-core' );
		} else {
			$message = sprintf(
				/* translators: %s: comma-separated template part names */
				__( 'Parties de modèles réinitialisées : %s.', 'gbecosmolingua-core' ),
				implode( ', ', $reset )
			);
		}

		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( $message ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
	}

	/**
	 * Handle reset import flag.
	 */
	public static function handle_reset() {
		check_admin_referer( 'gbe_reset_import' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		delete_option( GBE_Page_Importer::OPTION_KEY );
		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( __( 'Flag d\'import réinitialisé.', 'gbecosmolingua-core' ) ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
	}

	/**
	 * Handle demo content seeding.
	 */
	public static function handle_seed_demo() {
		check_admin_referer( 'gbe_seed_demo' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		GBE_Page_Importer::patch_phase4_shortcodes();
		GBE_Page_Importer::patch_phase5_forms();
		$message = GBE_Demo_Content::seed( true );

		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( $message ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
	}

	/**
	 * Fix permalinks and refresh header menu.
	 */
	public static function handle_fix_permalinks() {
		check_admin_referer( 'gbe_fix_permalinks' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		GBE_Page_Importer::import( true );
		GBE_Page_Importer::patch_phase7_content();
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		GBE_Page_Importer::restore_primary_menu();

		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( __( 'Permaliens réparés, pages importées et menu mis à jour.', 'gbecosmolingua-core' ) ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
	}

	/**
	 * Handle duplicate page cleanup.
	 */
	public static function handle_dedupe_pages() {
		check_admin_referer( 'gbe_dedupe_pages' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		$removed = GBE_Page_Importer::deduplicate_imported_pages();
		GBE_Page_Importer::restore_primary_menu();

		$message = sprintf(
			/* translators: %d: number of removed pages */
			__( 'Nettoyage terminé : %d page(s) en double supprimée(s).', 'gbecosmolingua-core' ),
			$removed
		);

		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( $message ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
	}

	/**
	 * Render settings subpage.
	 */
	public static function render_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'GbeCosmoLingua — Réglages', 'gbecosmolingua-core' ); ?></h1>
			<?php GBE_Settings::render_page(); ?>
		</div>
		<?php
	}

	/**
	 * Add columns to soumissions list.
	 *
	 * @param array<string, string> $columns Columns.
	 */
	public static function soumission_columns( $columns ) {
		$new = array();
		foreach ( $columns as $key => $label ) {
			$new[ $key ] = $label;
			if ( 'title' === $key ) {
				$new['gbe_type']  = __( 'Type', 'gbecosmolingua-core' );
				$new['gbe_email'] = __( 'Email', 'gbecosmolingua-core' );
			}
		}
		return $new;
	}

	/**
	 * Render custom soumission columns.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public static function soumission_column_content( $column, $post_id ) {
		$data = get_post_meta( $post_id, '_gbe_form_data', true );
		if ( ! is_array( $data ) ) {
			return;
		}
		if ( 'gbe_type' === $column ) {
			echo esc_html( get_post_meta( $post_id, '_gbe_form_type', true ) );
		}
		if ( 'gbe_email' === $column ) {
			echo esc_html( $data['email'] ?? '—' );
		}
	}
}
