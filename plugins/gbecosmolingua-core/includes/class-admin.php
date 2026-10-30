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
		add_action( 'admin_post_gbe_sync_membres_photos', array( __CLASS__, 'handle_sync_membres_photos' ) );
		add_action( 'admin_post_gbe_import_proverbes_ewe', array( __CLASS__, 'handle_import_proverbes_ewe' ) );
		add_action( 'admin_post_gbe_dedupe_pages', array( __CLASS__, 'handle_dedupe_pages' ) );
		add_action( 'admin_post_gbe_fix_permalinks', array( __CLASS__, 'handle_fix_permalinks' ) );
		add_action( 'admin_post_gbe_force_sync', array( __CLASS__, 'handle_force_sync' ) );
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

			<?php self::render_deploy_status(); ?>

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
				<li><strong><?php esc_html_e( 'Membres', 'gbecosmolingua-core' ); ?></strong> — <?php esc_html_e( 'Membres fondateurs et équipe (photo via image mise en avant)', 'gbecosmolingua-core' ); ?></li>
				<li><strong><?php esc_html_e( 'Ressources', 'gbecosmolingua-core' ); ?></strong></li>
			</ul>

			<h2><?php esc_html_e( 'Phase 6 — Accueil dynamique', 'gbecosmolingua-core' ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Actualités : articles WordPress — [gbe_actualites]', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Agenda : événements à venir — [gbe_agenda]', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Événements : [gbe_evenements_list] — archive /evenements/', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Annuaire partenaires : [gbe_partenaires_list]', 'gbecosmolingua-core' ); ?></li>
				<li><?php esc_html_e( 'Membres fondateurs : [gbe_membres_fondateurs] — CPT Membres (photo = image mise en avant)', 'gbecosmolingua-core' ); ?></li>
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
					<?php wp_nonce_field( 'gbe_force_sync' ); ?>
					<input type="hidden" name="action" value="gbe_force_sync">
					<?php submit_button( __( 'Forcer la synchronisation du contenu (production)', 'gbecosmolingua-core' ), 'primary', 'submit', false ); ?>
				</form>
				<p class="description" style="margin:0;">
					<?php esc_html_e( 'Écrit tous les textes des pages Gbe en base, assigne les modèles chapitre et recharge en-tête/pied de page. À utiliser après un upload FTP sur Hostinger.', 'gbecosmolingua-core' ); ?>
				</p>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_run_import' ); ?>
					<input type="hidden" name="action" value="gbe_run_import">
					<?php submit_button( __( 'Importer / mettre à jour les pages', 'gbecosmolingua-core' ), 'secondary', 'submit', false ); ?>
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
					<?php wp_nonce_field( 'gbe_sync_membres_photos' ); ?>
					<input type="hidden" name="action" value="gbe_sync_membres_photos">
					<?php submit_button( __( 'Synchroniser les photos des fondateurs', 'gbecosmolingua-core' ), 'secondary', 'submit', false ); ?>
					<label style="display:block;margin:0.35rem 0 0;">
						<input type="checkbox" name="force" value="1">
						<?php esc_html_e( 'Forcer le remplacement des photos déjà importées depuis le thème', 'gbecosmolingua-core' ); ?>
					</label>
				</form>
				<p class="description" style="margin:0;">
					<?php esc_html_e( 'Importe les portraits depuis themes/gbecosmolingua/assets/images/membres/ vers les fiches Membres.', 'gbecosmolingua-core' ); ?>
				</p>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'gbe_import_proverbes_ewe' ); ?>
					<input type="hidden" name="action" value="gbe_import_proverbes_ewe">
					<?php
					$corpus_count = GBE_Proverbes_Importer::data_count();
					$imported_at  = get_option( GBE_Proverbes_Importer::OPTION_KEY );
					submit_button(
						sprintf(
							/* translators: %d: number of proverbs in JSON file */
							__( 'Importer le corpus éwé (%d proverbes)', 'gbecosmolingua-core' ),
							$corpus_count
						),
						'primary',
						'submit',
						false
					);
					?>
					<label style="display:block;margin:0.35rem 0 0;">
						<input type="checkbox" name="force" value="1">
						<?php esc_html_e( 'Forcer la mise à jour des entrées déjà importées', 'gbecosmolingua-core' ); ?>
					</label>
				</form>
				<p class="description" style="margin:0;">
					<?php
					if ( $imported_at ) {
						echo esc_html(
							sprintf(
								/* translators: %s: formatted date */
								__( 'Dernier import éwé : %s', 'gbecosmolingua-core' ),
								wp_date( 'd/m/Y H:i', (int) $imported_at )
							)
						);
					} else {
						esc_html_e( 'Corpus Spieth (1906), Gbekɔbu (2014) et Anibri (2003) — 786 entrées.', 'gbecosmolingua-core' );
					}
					?>
				</p>

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
	 * État du déploiement (plugin + thème + contenu en base).
	 *
	 * @return array<string, mixed>
	 */
	public static function get_deploy_status() {
		$theme     = wp_get_theme();
		$stylesheet = $theme->get_stylesheet();
		$theme_dir = get_stylesheet_directory();

		$sample = get_page_by_path( 'le-gbe/les-langues', OBJECT, 'page' );
		$sample_ok = false;
		$sample_tpl = '';
		if ( $sample instanceof WP_Post ) {
			$sample_tpl = (string) get_page_template_slug( $sample->ID );
			$sample_ok  = str_contains( $sample->post_content, 'gbe-chapter' )
				|| 'page-le-gbe-chapter' === $sample_tpl
				|| function_exists( 'gbe_le_gbe_chapter_runtime_content' );
		}

		$db_version = (string) get_option( 'gbe_core_version', '0' );

		return array(
			'plugin_code'    => GBE_CORE_VERSION,
			'plugin_db'      => $db_version,
			'plugin_synced'  => version_compare( $db_version, GBE_CORE_VERSION, '>=' ),
			'theme_name'     => $theme->get( 'Name' ),
			'theme_slug'     => $stylesheet,
			'theme_ok'       => in_array( $stylesheet, array( 'gbecosmolingua', 'gbecosmolingua-theme2' ), true ),
			'chapter_php'    => is_readable( $theme_dir . '/includes/le-gbe-chapter.php' ),
			'chapter_tpl'    => is_readable( $theme_dir . '/templates/page-le-gbe-chapter.html' ),
			'chapter_css'    => is_readable( $theme_dir . '/assets/css/le-gbe-chapter.css' ),
			'runtime_fn'     => function_exists( 'gbe_le_gbe_langues_content' ),
			'shortcode_fn'   => function_exists( 'gbecosmolingua_le_gbe_chapter_body_html' ),
			'sample_page'    => $sample instanceof WP_Post,
			'sample_tpl'     => $sample_tpl ?: __( '(modèle par défaut)', 'gbecosmolingua-core' ),
			'sample_ok'      => $sample_ok,
			'langues_hub_fn' => function_exists( 'gbe_le_gbe_langues_content' ),
		);
	}

	/**
	 * Affiche le diagnostic déploiement en haut de la page admin.
	 */
	public static function render_deploy_status() {
		$s = self::get_deploy_status();
		$all_ok = $s['plugin_synced'] && $s['theme_ok'] && $s['chapter_php'] && $s['chapter_tpl'] && $s['runtime_fn'] && $s['shortcode_fn'];

		$box_style = $all_ok
			? 'border-left:4px solid #00a32a;background:#edfaef;padding:1rem 1.25rem;margin:1rem 0;'
			: 'border-left:4px solid #d63638;background:#fcf0f1;padding:1rem 1.25rem;margin:1rem 0;';
		?>
		<div class="gbe-deploy-status" style="<?php echo esc_attr( $box_style ); ?>">
			<h2 style="margin-top:0;"><?php esc_html_e( 'État du déploiement', 'gbecosmolingua-core' ); ?></h2>
			<table class="widefat striped" style="max-width:720px;background:#fff;">
				<tbody>
					<tr>
						<td><strong><?php esc_html_e( 'Plugin (fichiers)', 'gbecosmolingua-core' ); ?></strong></td>
						<td><?php echo esc_html( $s['plugin_code'] ); ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Plugin (base de données)', 'gbecosmolingua-core' ); ?></strong></td>
						<td><?php echo esc_html( $s['plugin_db'] ); ?><?php echo $s['plugin_synced'] ? ' ✓' : ' — ' . esc_html__( 'contenu pas encore synchronisé', 'gbecosmolingua-core' ); ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Thème actif', 'gbecosmolingua-core' ); ?></strong></td>
						<td><?php echo esc_html( $s['theme_name'] . ' (' . $s['theme_slug'] . ')' ); ?><?php echo $s['theme_ok'] ? ' ✓' : ' ✗'; ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Fichier le-gbe-chapter.php', 'gbecosmolingua-core' ); ?></strong></td>
						<td><?php echo $s['chapter_php'] ? esc_html__( 'Présent', 'gbecosmolingua-core' ) . ' ✓' : esc_html__( 'Absent — uploadez le thème actif (gbecosmolingua ou gbecosmolingua-theme2)', 'gbecosmolingua-core' ) . ' ✗'; ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Modèle page-le-gbe-chapter.html', 'gbecosmolingua-core' ); ?></strong></td>
						<td><?php echo $s['chapter_tpl'] ? esc_html__( 'Présent', 'gbecosmolingua-core' ) . ' ✓' : esc_html__( 'Absent', 'gbecosmolingua-core' ) . ' ✗'; ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Page test /le-gbe/les-langues/', 'gbecosmolingua-core' ); ?></strong></td>
						<td>
							<?php
							if ( ! $s['sample_page'] ) {
								esc_html_e( 'Page introuvable', 'gbecosmolingua-core' );
							} else {
								echo esc_html( sprintf(
									/* translators: 1: page template slug */
									__( 'Modèle : %s', 'gbecosmolingua-core' ),
									$s['sample_tpl']
								) );
							}
							?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php if ( ! $all_ok ) : ?>
				<p style="margin-bottom:0;">
					<strong><?php esc_html_e( 'Les textes n’apparaissent en ligne que si le plugin ET le thème sont à jour, puis si vous cliquez « Forcer la synchronisation du contenu » ci-dessous.', 'gbecosmolingua-core' ); ?></strong>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Synchronisation complète après déploiement FTP (Hostinger).
	 */
	public static function handle_force_sync() {
		check_admin_referer( 'gbe_force_sync' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'gbecosmolingua_le_gbe_chapter_tpl5_%'" );

		GBE_Page_Importer::import( true );
		GBE_Page_Importer::patch_phase4_shortcodes();
		GBE_Page_Importer::patch_phase5_forms();
		GBE_Page_Importer::patch_phase7_content();
		GBE_Page_Importer::patch_culture_subpages();
		GBE_Page_Importer::patch_le_gbe_subpages();
		GBE_Page_Importer::patch_linguistique_subpages();
		GBE_Page_Importer::patch_paremiologie_subpages();
		GBE_Page_Importer::patch_onomastique_subpages();
		GBE_Page_Importer::patch_recherche_innovation_subpages();
		GBE_Page_Importer::patch_site_hubs_subpages();
		GBE_Page_Importer::patch_membres_fondateurs();
		GBE_Page_Importer::patch_mission_statuts();
		GBE_Page_Importer::patch_capo_auteur_page();
		GBE_Page_Importer::patch_le_gbe_chapter_templates();
		GBE_Page_Importer::patch_gbe_naming();
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::restore_primary_menu();
		GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		GBE_Home_Composer_Admin::maybe_seed_defaults();
		update_option( 'gbe_core_version', GBE_CORE_VERSION );
		flush_rewrite_rules();

		wp_safe_redirect(
			add_query_arg(
				'gbe_message',
				rawurlencode( __( 'Synchronisation terminée : pages, modèles chapitre, en-tête et pied de page mis à jour.', 'gbecosmolingua-core' ) ),
				admin_url( 'admin.php?page=gbecosmolingua' )
			)
		);
		exit;
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
		GBE_Page_Importer::patch_culture_subpages();
		GBE_Page_Importer::patch_le_gbe_subpages();
		GBE_Page_Importer::patch_linguistique_subpages();
		GBE_Page_Importer::patch_paremiologie_subpages();
		GBE_Page_Importer::patch_onomastique_subpages();
		GBE_Page_Importer::patch_recherche_innovation_subpages();
		GBE_Page_Importer::patch_site_hubs_subpages();
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

		$reset_parts = GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		$reset_tpl   = GBE_Page_Importer::reset_theme_templates(
			array(
				'front-page',
				'page-le-gbe',
				'page-cultures-gbe',
				'page-xotutu',
				'page-onomastique',
				'page-linguistique',
				'page-paremiologie',
				'page-recherche-innovation',
				'page-sejours-mobilite',
				'page-partenaires',
				'page-nous-soutenir',
				'page-philosophie',
			)
		);
		$reset       = array_merge( $reset_parts, $reset_tpl );
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::restore_primary_menu();

		if ( empty( $reset ) ) {
			$message = __( 'En-tête, pied de page et page d\'accueil rechargés depuis le thème.', 'gbecosmolingua-core' );
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
	 * Import Ewe proverbs corpus.
	 */
	public static function handle_import_proverbes_ewe() {
		check_admin_referer( 'gbe_import_proverbes_ewe' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		$force   = isset( $_POST['force'] ) && '1' === $_POST['force'];
		$message = GBE_Proverbes_Importer::import( $force );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'        => 'gbecosmolingua',
					'gbe_message' => rawurlencode( $message ),
				),
				admin_url( 'admin.php' )
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
	 * Synchronise les photos des membres fondateurs depuis le thème.
	 */
	public static function handle_sync_membres_photos() {
		check_admin_referer( 'gbe_sync_membres_photos' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		if ( class_exists( 'GBE_Demo_Content' ) ) {
			GBE_Demo_Content::seed_membres_fondateurs();
		}

		$force   = ! empty( $_POST['force'] );
		$count   = class_exists( 'GBE_Membres_Photos' ) ? GBE_Membres_Photos::sync_fondateurs_photos( $force ) : 0;
		$message = sprintf(
			/* translators: %d: number of photos synced */
			_n(
				'%d photo de fondateur synchronisée.',
				'%d photos de fondateurs synchronisées.',
				$count,
				'gbecosmolingua-core'
			),
			$count
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
	 * Fix permalinks and refresh header menu.
	 */
	public static function handle_fix_permalinks() {
		check_admin_referer( 'gbe_fix_permalinks' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		GBE_Page_Importer::import( true );
		GBE_Page_Importer::patch_phase7_content();
		GBE_Page_Importer::patch_culture_subpages();
		GBE_Page_Importer::patch_le_gbe_subpages();
		GBE_Page_Importer::patch_linguistique_subpages();
		GBE_Page_Importer::patch_paremiologie_subpages();
		GBE_Page_Importer::patch_onomastique_subpages();
		GBE_Page_Importer::patch_recherche_innovation_subpages();
		GBE_Page_Importer::patch_site_hubs_subpages();
		GBE_Page_Importer::configure_permalinks();
		GBE_Page_Importer::reset_theme_template_parts( array( 'header', 'footer' ) );
		GBE_Page_Importer::reset_theme_templates( array( 'front-page', 'page-le-gbe', 'page-cultures-gbe' ) );
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
