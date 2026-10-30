<?php
/**
 * Admin: images and hero text for the public Gbe hub (/le-gbe/).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta boxes and saves for page le-gbe and hub subpages.
 */
class GBE_Le_Gbe_Hub_Admin {

	const META_HERO_BG       = '_gbe_le_gbe_hero_bg_id';
	const META_HERO_FIGURE   = '_gbe_le_gbe_hero_figure_id';
	const META_HERO_LEAD     = '_gbe_le_gbe_hero_lead';
	const META_HERO_OVERLAY  = '_gbe_le_gbe_hero_overlay';
	const META_HERO_SLIDES   = '_gbe_le_gbe_hero_slides';
	const META_PAGE_BANDS   = '_gbe_le_gbe_page_bands';
	const META_PAGE_SUBCARDS = '_gbe_le_gbe_page_subcards';
	const META_PAGE_LAYOUT  = '_gbe_hub_page_layout';
	const META_PAGE_LAYOUT_LEGACY = '_gbe_le_gbe_page_layout';
	const META_SECTIONS_FONT      = '_gbe_hub_sections_font';
	const NONCE_ACTION      = 'gbe_le_gbe_hub_save';
	const NONCE_FIELD       = 'gbe_le_gbe_hub_nonce';

	/**
	 * Slugs des pages = onglets du menu principal (barre verte).
	 *
	 * @return string[]
	 */
	public static function main_menu_slugs() {
		return array(
			'le-gbe',
			'linguistique',
			'cultures-gbe',
			'xotutu',
			'onomastique',
			'paremiologie',
			'nous-soutenir',
			'notre-philosophie',
		);
	}

	/**
	 * Polices disponibles pour les sections hub.
	 *
	 * @return array<string, string>
	 */
	public static function section_font_choices() {
		return array(
			''        => __( 'Héritée (page ou thème)', 'gbecosmolingua-core' ),
			'theme'   => __( 'Thème — par défaut', 'gbecosmolingua-core' ),
			'serif'   => __( 'Serif — Georgia', 'gbecosmolingua-core' ),
			'sans'    => __( 'Sans-serif — moderne', 'gbecosmolingua-core' ),
			'display' => __( 'Display — titres accentués', 'gbecosmolingua-core' ),
		);
	}

	/**
	 * @param string $font Slug police.
	 * @return string
	 */
	public static function sanitize_section_font( $font ) {
		$font = sanitize_key( (string) $font );
		return array_key_exists( $font, self::section_font_choices() ) ? $font : '';
	}

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_menu' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ), 10, 2 );
		add_action( 'add_meta_boxes_page', array( __CLASS__, 'register_meta_boxes_legacy' ), 10, 1 );
		add_action( 'save_post_page', array( __CLASS__, 'save_page' ), 10, 2 );
		add_action( 'admin_post_gbe_save_le_gbe_composer', array( __CLASS__, 'handle_composer_save' ) );
		add_action( 'admin_post_gbe_save_hub_composer', array( __CLASS__, 'handle_composer_save' ) );
		add_action( 'admin_post_gbe_clear_le_gbe_composer', array( __CLASS__, 'handle_composer_clear' ) );
		add_action( 'admin_post_gbe_clear_hub_composer', array( __CLASS__, 'handle_composer_clear' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_assets' ) );
		add_action( 'load-post.php', array( __CLASS__, 'maybe_redirect_hub_page_edit_to_composer' ) );
		add_action( 'load-post.php', array( __CLASS__, 'prepare_hub_page_block_editor' ) );
		add_action( 'load-post-new.php', array( __CLASS__, 'prepare_hub_page_block_editor' ) );
		add_action( 'admin_init', array( __CLASS__, 'maybe_clear_hub_layout_from_page_edit' ) );
		add_action( 'admin_notices', array( __CLASS__, 'render_hub_page_save_notice' ) );
		add_filter( 'use_block_editor_for_post', array( __CLASS__, 'force_block_editor_for_hub_pages' ), 1000, 2 );
		add_filter( 'replace_editor', array( __CLASS__, 'prevent_classic_editor_replace_for_hub_pages' ), 1000, 2 );
		add_filter( 'classic_editor_enabled_editors_for_post', array( __CLASS__, 'classic_editor_settings_for_hub_pages' ), 1000, 2 );
	}

	/**
	 * Page racine hub par slug.
	 *
	 * @param string $slug Slug page.
	 * @return WP_Post|null
	 */
	public static function get_hub_page( $slug ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		return $page instanceof WP_Post ? $page : null;
	}

	/**
	 * Page racine Gbe.
	 *
	 * @return WP_Post|null
	 */
	public static function get_le_gbe_page() {
		return self::get_hub_page( 'le-gbe' );
	}

	/**
	 * Menu : composeur hub + raccourci pages menu.
	 */
	public static function register_admin_menu() {
		add_submenu_page(
			'gbecosmolingua',
			__( 'Composer pages hub', 'gbecosmolingua-core' ),
			__( 'Composer pages hub', 'gbecosmolingua-core' ),
			'edit_pages',
			'gbecosmolingua-hub-composer',
			array( __CLASS__, 'render_hub_composer_index' )
		);

		add_submenu_page(
			null,
			__( 'Composer une page hub', 'gbecosmolingua-core' ),
			__( 'Composer une page hub', 'gbecosmolingua-core' ),
			'edit_pages',
			'gbecosmolingua-hub-composer-edit',
			array( __CLASS__, 'render_hub_composer_screen' )
		);

		add_submenu_page(
			'gbecosmolingua',
			__( 'Pages du menu principal', 'gbecosmolingua-core' ),
			__( 'Pages du menu principal', 'gbecosmolingua-core' ),
			'edit_pages',
			'gbecosmolingua-main-menu-pages',
			array( __CLASS__, 'render_main_menu_admin_screen' )
		);

		add_submenu_page(
			null,
			__( 'Composer Gbe', 'gbecosmolingua-core' ),
			__( 'Composer Gbe', 'gbecosmolingua-core' ),
			'edit_pages',
			'gbecosmolingua-le-gbe-composer',
			array( __CLASS__, 'redirect_le_gbe_composer_legacy' )
		);
	}

	/**
	 * URL composeur pour une page hub.
	 *
	 * @param string $slug Slug page.
	 * @return string
	 */
	public static function get_hub_composer_url( $slug ) {
		return add_query_arg(
			'hub',
			sanitize_title( $slug ),
			admin_url( 'admin.php?page=gbecosmolingua-hub-composer-edit' )
		);
	}

	/**
	 * URL édition intro Gutenberg (sans bannière / cartes).
	 *
	 * @param WP_Post $page Page hub.
	 * @return string
	 */
	public static function get_hub_intro_edit_url( $page ) {
		return add_query_arg( 'gbe_hub_intro', '1', get_edit_post_link( $page->ID, 'raw' ) );
	}

	/**
	 * Mode « intro seule » dans Pages (Gutenberg).
	 */
	private static function is_hub_intro_edit_request() {
		return is_admin() && isset( $_GET['gbe_hub_intro'] ) && '1' === (string) wp_unslash( $_GET['gbe_hub_intro'] );
	}

	/**
	 * Pages hub : rediriger Pages → Modifier vers le composeur (sauf intro Gutenberg).
	 */
	public static function maybe_redirect_hub_page_edit_to_composer() {
		global $pagenow;

		if ( 'post.php' !== $pagenow || ! isset( $_GET['post'] ) ) {
			return;
		}
		if ( self::is_hub_intro_edit_request() ) {
			return;
		}

		$post = get_post( absint( $_GET['post'] ) );
		if ( ! $post instanceof WP_Post || ! self::is_main_menu_root_page( $post ) ) {
			return;
		}

		wp_safe_redirect( self::get_hub_composer_url( $post->post_name ) );
		exit;
	}

	/**
	 * @deprecated Redirige vers le composeur Gbe.
	 */
	public static function redirect_le_gbe_composer_legacy() {
		wp_safe_redirect( self::get_hub_composer_url( 'le-gbe' ) );
		exit;
	}

	/**
	 * Liste des 9 pages hub composables.
	 */
	public static function render_hub_composer_index() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Composer les pages du menu', 'gbecosmolingua-core' ); ?></h1>
			<p class="description"><?php esc_html_e( 'Bannière, cartes et sections pour chaque onglet du menu. L’intro se modifie séparément en Gutenberg.', 'gbecosmolingua-core' ); ?></p>
			<?php if ( class_exists( 'GBE_Home_Composer_Admin' ) ) : ?>
				<div class="notice notice-info inline" style="margin:1rem 0;padding:0.75rem 1rem;max-width:960px;">
					<p>
						<strong><?php esc_html_e( 'Page d’accueil', 'gbecosmolingua-core' ); ?></strong> —
						<a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=gbecosmolingua-home-composer' ) ); ?>"><?php esc_html_e( 'Composer l’accueil', 'gbecosmolingua-core' ); ?></a>
						<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir l’accueil public', 'gbecosmolingua-core' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<table class="widefat striped" style="max-width:960px;margin-top:1rem;">
				<thead><tr><th><?php esc_html_e( 'Page', 'gbecosmolingua-core' ); ?></th><th></th></tr></thead>
				<tbody>
				<?php foreach ( self::main_menu_slugs() as $slug ) : ?>
					<?php
					$page = self::get_hub_page( $slug );
					if ( ! $page ) {
						continue;
					}
					$edit = self::get_hub_composer_url( $slug );
					$intro = self::get_hub_intro_edit_url( $page );
					$view = get_permalink( $page );
					?>
					<tr>
						<td><strong><?php echo esc_html( $page->post_title ); ?></strong><br><code><?php echo esc_html( $slug ); ?></code></td>
						<td>
							<a class="button button-primary" href="<?php echo esc_url( $edit ); ?>"><?php esc_html_e( 'Composer', 'gbecosmolingua-core' ); ?></a>
							<a class="button" href="<?php echo esc_url( $intro ); ?>"><?php esc_html_e( 'Intro (Gutenberg)', 'gbecosmolingua-core' ); ?></a>
							<?php if ( $view ) : ?>
								<a class="button" href="<?php echo esc_url( $view ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir', 'gbecosmolingua-core' ); ?></a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Écran composeur (?hub=slug) — bannière + cartes, sans éditeur WordPress classique.
	 */
	public static function render_hub_composer_screen() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		$slug = isset( $_GET['hub'] ) ? sanitize_title( wp_unslash( $_GET['hub'] ) ) : 'le-gbe';
		if ( ! in_array( $slug, self::main_menu_slugs(), true ) ) {
			$slug = 'le-gbe';
		}

		$page = self::get_hub_page( $slug );
		if ( ! $page ) {
			echo '<div class="wrap"><h1>' . esc_html__( 'Composer page hub', 'gbecosmolingua-core' ) . '</h1>';
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Page introuvable. Lancez l’import des pages.', 'gbecosmolingua-core' ) . '</p></div></div>';
			return;
		}

		if ( isset( $_GET['updated'] ) || ( isset( $_GET['message'] ) && 'gbe_hub_saved' === $_GET['message'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Modifications enregistrées.', 'gbecosmolingua-core' ) . '</p></div>';
		}

		$preview = get_permalink( $page );
		$index   = admin_url( 'admin.php?page=gbecosmolingua-hub-composer' );
		$intro   = self::get_hub_intro_edit_url( $page );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( sprintf( __( 'Composer : %s', 'gbecosmolingua-core' ), $page->post_title ) ); ?></h1>
			<p class="description"><?php esc_html_e( 'Bannière et cartes : ici. Texte d’intro sous la bannière : bouton « Intro (Gutenberg) ».', 'gbecosmolingua-core' ); ?></p>
			<p>
				<a class="button" href="<?php echo esc_url( $index ); ?>"><?php esc_html_e( '← Toutes les pages hub', 'gbecosmolingua-core' ); ?></a>
				<a class="button button-primary" href="<?php echo esc_url( $preview ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir la page publique', 'gbecosmolingua-core' ); ?></a>
				<a class="button" href="<?php echo esc_url( $intro ); ?>"><?php esc_html_e( 'Intro (Gutenberg)', 'gbecosmolingua-core' ); ?></a>
			</p>

			<form id="gbe-hub-composer-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="gbe_save_hub_composer" />
				<input type="hidden" name="gbe_hub_composer_page_id" value="<?php echo esc_attr( (string) $page->ID ); ?>" />
				<input type="hidden" name="gbe_hub_composer_slug" value="<?php echo esc_attr( $slug ); ?>" />
				<?php wp_nonce_field( 'gbe_save_hub_composer', 'gbe_hub_composer_nonce' ); ?>

				<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
					<h2 class="hndle" style="padding:0;margin:0 0 1rem;"><?php esc_html_e( 'Bannière', 'gbecosmolingua-core' ); ?></h2>
					<?php self::render_hub_root_box( $page ); ?>
				</div>

				<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
					<h2 class="hndle" style="padding:0;margin:0 0 1rem;"><?php esc_html_e( 'Cartes et sections', 'gbecosmolingua-core' ); ?></h2>
					<?php self::render_hub_page_bands_box( $page ); ?>
				</div>

				<?php submit_button( __( 'Enregistrer', 'gbecosmolingua-core' ), 'primary', 'submit', true, array( 'style' => 'margin-top:1rem;' ) ); ?>
			</form>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:1rem;" onsubmit="return confirm('<?php echo esc_js( __( 'Supprimer toutes les cartes enregistrées sur cette page ?', 'gbecosmolingua-core' ) ); ?>');">
				<input type="hidden" name="action" value="gbe_clear_hub_composer" />
				<input type="hidden" name="gbe_hub_composer_page_id" value="<?php echo esc_attr( (string) $page->ID ); ?>" />
				<input type="hidden" name="gbe_hub_composer_slug" value="<?php echo esc_attr( $slug ); ?>" />
				<?php wp_nonce_field( 'gbe_clear_hub_composer', 'gbe_hub_composer_clear_nonce' ); ?>
				<?php submit_button( __( 'Vider toutes les cartes', 'gbecosmolingua-core' ), 'delete', 'submit', false ); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Force Gutenberg sur les pages hub (priorité haute).
	 *
	 * @param bool    $use_block_editor Utiliser Gutenberg.
	 * @param WP_Post $post             Page.
	 * @return bool
	 */
	public static function force_block_editor_for_hub_pages( $use_block_editor, $post ) {
		if ( $post instanceof WP_Post && 'page' === $post->post_type && self::is_main_menu_root_page( $post ) && self::is_hub_intro_edit_request() ) {
			return true;
		}
		return $use_block_editor;
	}

	/**
	 * Empêche le remplacement par l’éditeur classique.
	 *
	 * @param bool    $replace Remplacer l’éditeur.
	 * @param WP_Post $post    Page.
	 * @return bool
	 */
	public static function prevent_classic_editor_replace_for_hub_pages( $replace, $post ) {
		if ( $post instanceof WP_Post && 'page' === $post->post_type && self::is_main_menu_root_page( $post ) && self::is_hub_intro_edit_request() ) {
			return false;
		}
		return $replace;
	}

	/**
	 * Plugin Classic Editor : Gutenberg uniquement sur les pages hub.
	 *
	 * @param array<string, bool> $editors  Éditeurs autorisés.
	 * @param WP_Post             $post     Page.
	 * @return array<string, bool>
	 */
	public static function classic_editor_settings_for_hub_pages( $editors, $post ) {
		if ( $post instanceof WP_Post && 'page' === $post->post_type && self::is_main_menu_root_page( $post ) && self::is_hub_intro_edit_request() ) {
			return array(
				'block_editor'   => true,
				'classic_editor' => false,
			);
		}
		return $editors;
	}

	/**
	 * Supprime le souvenir « éditeur classique » laissé par une ancienne version.
	 */
	public static function prepare_hub_page_block_editor() {
		global $post;

		$target = null;
		if ( $post instanceof WP_Post ) {
			$target = $post;
		} elseif ( isset( $_GET['post'] ) ) {
			$target = get_post( absint( $_GET['post'] ) );
		}

		if ( ! $target instanceof WP_Post || 'page' !== $target->post_type || ! self::is_main_menu_root_page( $target ) || ! self::is_hub_intro_edit_request() ) {
			return;
		}

		delete_post_meta( $target->ID, 'classic-editor-remember' );

		$user_id = get_current_user_id();
		if ( $user_id ) {
			delete_user_meta( $user_id, 'classic-editor-remember' );
			delete_user_meta( $user_id, 'wp_classic-editor-settings' );
		}
	}

	/**
	 * Scripts médias / composeur dans l’éditeur de blocs.
	 */
	public static function enqueue_block_editor_assets() {
		global $post;
		if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
			return;
		}
		if ( self::is_hub_section_page( $post ) ) {
			self::enqueue_hub_admin_assets( $post );
		}
	}

	/**
	 * @param WP_Post $post Page.
	 */
	private static function enqueue_hub_admin_assets( $post ) {
		wp_enqueue_media();
		if ( self::is_main_menu_root_page( $post ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		wp_enqueue_script(
			'gbe-le-gbe-hub-admin',
			GBE_CORE_URL . 'assets/js/le-gbe-hub-admin.js',
			self::is_main_menu_root_page( $post ) ? array( 'jquery', 'jquery-ui-sortable' ) : array( 'jquery' ),
			GBE_CORE_VERSION . '.6',
			true
		);

		if ( self::is_main_menu_root_page( $post ) ) {
			wp_enqueue_script(
				'gbe-le-gbe-layout-editor',
				GBE_CORE_URL . 'assets/js/le-gbe-layout-editor.js',
				array( 'jquery', 'jquery-ui-sortable', 'gbe-le-gbe-hub-admin' ),
				GBE_CORE_VERSION . '.6',
				true
			);
		}
	}

	/**
	 * Rappel sous le titre sur l’écran Pages → page hub.
	 *
	 * @param WP_Post $post Page.
	 */
	public static function render_hub_page_edit_guidance( $post ) {
		if ( ! $post instanceof WP_Post || 'page' !== $post->post_type || ! self::is_main_menu_root_page( $post ) || ! self::is_hub_intro_edit_request() ) {
			return;
		}

		$composer = self::get_hub_composer_url( $post->post_name );
		$public   = get_permalink( $post );
		?>
		<div class="notice notice-info inline" style="margin:0;padding:0.5rem 0;">
			<p style="margin-top:0;"><strong><?php esc_html_e( 'Intro sous la bannière', 'gbecosmolingua-core' ); ?></strong></p>
			<p><?php esc_html_e( 'Utilisez l’éditeur de blocs ci-dessous pour le texte d’intro. Bannière et cartes se modifient dans le composeur hub.', 'gbecosmolingua-core' ); ?></p>
			<p style="margin:0.75rem 0 0;">
				<a class="button button-secondary" href="<?php echo esc_url( $composer ); ?>"><?php esc_html_e( '← Retour au composeur', 'gbecosmolingua-core' ); ?></a>
				<?php if ( $public ) : ?>
					<a class="button button-secondary" href="<?php echo esc_url( $public ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir la page publique', 'gbecosmolingua-core' ); ?></a>
				<?php endif; ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Message après enregistrement depuis l’ancien flux composeur.
	 */
	public static function render_hub_page_save_notice() {
		global $post, $pagenow;

		if ( 'post.php' !== $pagenow || ! $post instanceof WP_Post || ! self::is_main_menu_root_page( $post ) ) {
			return;
		}
		if ( ! isset( $_GET['message'] ) || 'gbe_hub_saved' !== $_GET['message'] ) {
			return;
		}
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Contenu de la page hub enregistré.', 'gbecosmolingua-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Vide les cartes depuis un lien sur l’écran Pages (hors formulaire #post).
	 */
	public static function maybe_clear_hub_layout_from_page_edit() {
		if ( ! is_admin() || ! isset( $_GET['gbe_clear_hub_layout'] ) ) {
			return;
		}

		$page_id = absint( $_GET['gbe_clear_hub_layout'] );
		if ( ! $page_id || ! current_user_can( 'edit_page', $page_id ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		check_admin_referer( 'gbe_clear_hub_layout_' . $page_id );

		$page = get_post( $page_id );
		if ( ! $page instanceof WP_Post || 'page' !== $page->post_type || ! self::is_main_menu_root_page( $page ) ) {
			wp_die( esc_html__( 'Page hub invalide.', 'gbecosmolingua-core' ) );
		}

		update_post_meta( $page_id, self::META_PAGE_LAYOUT, array(
			'bands' => array(),
			'more'  => array(),
		) );
		delete_post_meta( $page_id, self::META_PAGE_BANDS );
		delete_post_meta( $page_id, self::META_PAGE_SUBCARDS );

		wp_safe_redirect( add_query_arg( 'updated', '1', self::get_hub_composer_url( $page->post_name ) ) );
		exit;
	}

	/**
	 * Menu rapide : toutes les sous-pages Gbe (sans chercher dans 240 pages).
	 */
	public static function register_admin_menu_legacy() {
		// Conservé pour compatibilité — remplacé par register_admin_menu().
	}

	/**
	 * Enregistrement depuis l’écran Composer Gbe.
	 */
	public static function handle_composer_save() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}
		if ( ! isset( $_POST['gbe_le_gbe_composer_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gbe_le_gbe_composer_nonce'] ) ), 'gbe_save_le_gbe_composer' ) ) {
			if ( isset( $_POST['gbe_hub_composer_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gbe_hub_composer_nonce'] ) ), 'gbe_save_hub_composer' ) ) {
				$page_id = isset( $_POST['gbe_hub_composer_page_id'] ) ? absint( $_POST['gbe_hub_composer_page_id'] ) : 0;
				$slug    = isset( $_POST['gbe_hub_composer_slug'] ) ? sanitize_title( wp_unslash( $_POST['gbe_hub_composer_slug'] ) ) : 'le-gbe';
				$page    = get_post( $page_id );
				if ( ! $page instanceof WP_Post || 'page' !== $page->post_type || ! in_array( $page->post_name, self::main_menu_slugs(), true ) ) {
					wp_die( esc_html__( 'Page hub invalide.', 'gbecosmolingua-core' ) );
				}
				self::save_page( $page_id, $page );
				wp_safe_redirect( add_query_arg( 'updated', '1', self::get_hub_composer_url( $slug ) ) );
				exit;
			}
			wp_die( esc_html__( 'Session expirée. Réessayez.', 'gbecosmolingua-core' ) );
		}

		$page_id = isset( $_POST['gbe_le_gbe_composer_page_id'] ) ? absint( $_POST['gbe_le_gbe_composer_page_id'] ) : 0;
		$page    = get_post( $page_id );
		if ( ! $page instanceof WP_Post || 'page' !== $page->post_type || ! in_array( $page->post_name, self::main_menu_slugs(), true ) ) {
			wp_die( esc_html__( 'Page hub invalide.', 'gbecosmolingua-core' ) );
		}

		self::save_page( $page_id, $page );

		wp_safe_redirect( add_query_arg( 'updated', '1', self::get_hub_composer_url( $page->post_name ) ) );
		exit;
	}

	/**
	 * Vide le contenu composé de /le-gbe/ (cartes + Voir plus).
	 */
	public static function handle_composer_clear() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}
		if ( ! isset( $_POST['gbe_le_gbe_composer_clear_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gbe_le_gbe_composer_clear_nonce'] ) ), 'gbe_clear_le_gbe_composer' ) ) {
			if ( isset( $_POST['gbe_hub_composer_clear_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gbe_hub_composer_clear_nonce'] ) ), 'gbe_clear_hub_composer' ) ) {
				$page_id = isset( $_POST['gbe_hub_composer_page_id'] ) ? absint( $_POST['gbe_hub_composer_page_id'] ) : 0;
				$slug    = isset( $_POST['gbe_hub_composer_slug'] ) ? sanitize_title( wp_unslash( $_POST['gbe_hub_composer_slug'] ) ) : 'le-gbe';
				$page    = get_post( $page_id );
				if ( ! $page instanceof WP_Post || 'page' !== $page->post_type || ! in_array( $page->post_name, self::main_menu_slugs(), true ) ) {
					wp_die( esc_html__( 'Page hub invalide.', 'gbecosmolingua-core' ) );
				}
				update_post_meta( $page_id, self::META_PAGE_LAYOUT, array( 'bands' => array(), 'more' => array() ) );
				delete_post_meta( $page_id, self::META_PAGE_BANDS );
				delete_post_meta( $page_id, self::META_PAGE_SUBCARDS );
				wp_safe_redirect( add_query_arg( 'updated', '1', self::get_hub_composer_url( $slug ) ) );
				exit;
			}
			wp_die( esc_html__( 'Session expirée. Réessayez.', 'gbecosmolingua-core' ) );
		}

		$page_id = isset( $_POST['gbe_le_gbe_composer_page_id'] ) ? absint( $_POST['gbe_le_gbe_composer_page_id'] ) : 0;
		$page    = get_post( $page_id );
		if ( ! $page instanceof WP_Post || 'page' !== $page->post_type || ! in_array( $page->post_name, self::main_menu_slugs(), true ) ) {
			wp_die( esc_html__( 'Page hub invalide.', 'gbecosmolingua-core' ) );
		}

		update_post_meta( $page_id, self::META_PAGE_LAYOUT, array(
			'bands' => array(),
			'more'  => array(),
		) );
		delete_post_meta( $page_id, self::META_PAGE_BANDS );
		delete_post_meta( $page_id, self::META_PAGE_SUBCARDS );

		wp_safe_redirect( add_query_arg( 'updated', '1', self::get_hub_composer_url( $page->post_name ) ) );
		exit;
	}


	/**
	 * Les 9 onglets du menu : raccourci vers le composeur hub.
	 */
	public static function render_main_menu_admin_screen() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Pages du menu principal', 'gbecosmolingua-core' ); ?></h1>
			<p class="description">
				<?php esc_html_e( 'Les 9 onglets du menu se composent dans « Composer pages hub ». L’intro se modifie en Gutenberg.', 'gbecosmolingua-core' ); ?>
			</p>
			<?php if ( class_exists( 'GBE_Home_Composer_Admin' ) ) : ?>
				<div class="gbe-main-menu-hub-block" style="margin:1.5rem 0;padding:1rem;background:#fff;border:1px solid #c3c4c7;border-radius:4px;max-width:960px;">
					<h2 style="margin-top:0;"><?php esc_html_e( 'Page d’accueil', 'gbecosmolingua-core' ); ?></h2>
					<p class="description"><?php esc_html_e( 'Bannière, chiffres, carte, langues, culture, bibliothèque, galerie, témoignages, partenaires et CTA.', 'gbecosmolingua-core' ); ?></p>
					<p>
						<a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=gbecosmolingua-home-composer' ) ); ?>"><?php esc_html_e( 'Composer l’accueil', 'gbecosmolingua-core' ); ?></a>
						<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir la page publique', 'gbecosmolingua-core' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<?php
			foreach ( self::main_menu_slugs() as $slug ) {
				$page = get_page_by_path( $slug, OBJECT, 'page' );
				if ( ! $page ) {
					continue;
				}
				self::render_main_menu_hub_block( $page );
			}
			?>
		</div>
		<?php
	}

	/**
	 * @param WP_Post $page Page racine (onglet menu).
	 */
	private static function render_main_menu_hub_block( $page ) {
		$public    = get_permalink( $page );
		$composer  = self::get_hub_composer_url( $page->post_name );
		$intro     = self::get_hub_intro_edit_url( $page );
		?>
		<div class="gbe-main-menu-hub-block" style="margin:1.5rem 0;padding:1rem;background:#fff;border:1px solid #c3c4c7;border-radius:4px;max-width:960px;">
			<h2 style="margin-top:0;"><?php echo esc_html( $page->post_title ); ?></h2>
			<p class="description"><?php esc_html_e( 'Bannière et cartes : composeur. Intro : Gutenberg.', 'gbecosmolingua-core' ); ?></p>
			<p>
				<a class="button button-primary" href="<?php echo esc_url( $composer ); ?>"><?php esc_html_e( 'Composer la page', 'gbecosmolingua-core' ); ?></a>
				<a class="button" href="<?php echo esc_url( $intro ); ?>"><?php esc_html_e( 'Intro (Gutenberg)', 'gbecosmolingua-core' ); ?></a>
				<a class="button" href="<?php echo esc_url( $public ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir la page publique', 'gbecosmolingua-core' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * @deprecated Utiliser render_main_menu_admin_screen.
	 */
	public static function render_subpages_admin_screen() {
		self::render_main_menu_admin_screen();
	}

	/**
	 * Tables Gbe : bandes principales + « Voir plus » (même page /le-gbe/).
	 *
	 * @param WP_Post[] $sections Enfants directs de la page Gbe.
	 */
	private static function render_le_gbe_hub_sections_tables( $sections ) {
		$by_slug = array();
		foreach ( $sections as $section ) {
			$by_slug[ $section->post_name ] = $section;
		}

		$bands = array();
		foreach ( gbecosmolingua_le_gbe_hub_order() as $slug ) {
			if ( isset( $by_slug[ $slug ] ) ) {
				$bands[] = $by_slug[ $slug ];
				unset( $by_slug[ $slug ] );
			}
		}

		$more = array();
		if ( function_exists( 'gbecosmolingua_le_gbe_hub_more_slugs' ) ) {
			foreach ( gbecosmolingua_le_gbe_hub_more_slugs() as $slug ) {
				if ( isset( $by_slug[ $slug ] ) ) {
					$more[] = $by_slug[ $slug ];
					unset( $by_slug[ $slug ] );
				}
			}
		}

		$rest = array_values( $by_slug );

		echo '<div class="notice notice-info inline" style="margin:1rem 0;padding:0.75rem 1rem;max-width:960px;"><p>';
		echo esc_html__( 'Tout ce qui s’affiche sous la bannière sur /le-gbe/ se modifie ici, bande par bande — pas dans le grand champ « Contenu » de la page Gbe (réservé à l’intro sous la bannière).', 'gbecosmolingua-core' );
		echo '</p></div>';

		echo '<p><strong>' . esc_html__( 'Grandes bandes (Bibliothèque, Carte, Corpus…)', 'gbecosmolingua-core' ) . '</strong></p>';
		echo '<p class="description">' . esc_html__( 'Ordre identique à la page publique. Modifier → titre, premier paragraphe = texte de la bande, image mise en avant = photo.', 'gbecosmolingua-core' ) . '</p>';
		if ( empty( $bands ) ) {
			echo '<p class="description">' . esc_html__( 'Aucune bande reconnue (vérifiez les permaliens des pages enfants).', 'gbecosmolingua-core' ) . '</p>';
		} else {
			self::render_sections_table( $bands );
		}

		if ( ! empty( $more ) ) {
			echo '<p style="margin-top:1.25rem;"><strong>' . esc_html__( 'Bloc « Voir plus » (bas de /le-gbe/)', 'gbecosmolingua-core' ) . '</strong></p>';
			self::render_sections_table( $more );
		}

		if ( ! empty( $rest ) ) {
			echo '<p style="margin-top:1.25rem;"><strong>' . esc_html__( 'Autres pages enfants (non listées sur le hub)', 'gbecosmolingua-core' ) . '</strong></p>';
			self::render_sections_table( $rest );
		}
	}

	/**
	 * @param WP_Post[] $sections Pages.
	 */
	private static function render_sections_table( $sections ) {
		echo '<table class="widefat striped" style="max-width:960px;"><thead><tr><th>' . esc_html__( 'Bloc sur la page publique', 'gbecosmolingua-core' ) . '</th><th>' . esc_html__( 'Image', 'gbecosmolingua-core' ) . '</th><th></th></tr></thead><tbody>';
		foreach ( $sections as $section ) {
			self::render_subpages_table_row( $section, 0 );
		}
		echo '</tbody></table>';
	}

	/**
	 * @param WP_Post $page  Page.
	 * @param int     $depth Nesting (0 = rubrique principale).
	 */
	private static function render_subpages_table_row( $page, $depth ) {
		$edit = get_edit_post_link( $page->ID, 'raw' );
		$view = get_permalink( $page->ID );
		$pad  = $depth ? 'padding-left:2rem;' : '';
		$img  = has_post_thumbnail( $page )
			? get_the_post_thumbnail( $page, array( 80, 80 ) )
			: '<span class="description">' . esc_html__( 'Aucune', 'gbecosmolingua-core' ) . '</span>';

		echo '<tr><td style="' . esc_attr( $pad ) . '"><strong>' . esc_html( $page->post_title ) . '</strong>';
		echo '<br><code style="font-size:11px;">' . esc_html( get_page_uri( $page ) ) . '</code></td>';
		echo '<td>' . $img . '</td>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<td><a class="button button-primary button-small" href="' . esc_url( $edit ) . '">' . esc_html__( 'Modifier ce bloc', 'gbecosmolingua-core' ) . '</a> ';
		if ( $view ) {
			echo '<a class="button button-small" href="' . esc_url( $view ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Voir', 'gbecosmolingua-core' ) . '</a>';
		}
		echo '</td></tr>';
	}

	/**
	 * @param string  $post_type Post type.
	 * @param WP_Post $post      Page.
	 */
	public static function register_meta_boxes( $post_type, $post ) {
		if ( 'page' !== $post_type || ! $post instanceof WP_Post ) {
			return;
		}

		self::register_meta_boxes_for_post( $post );
	}

	/**
	 * @param WP_Post $post Page.
	 */
	public static function register_meta_boxes_legacy( $post ) {
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		self::register_meta_boxes_for_post( $post );
	}

	/**
	 * @param WP_Post $post Page.
	 */
	private static function register_meta_boxes_for_post( $post ) {
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		if ( self::is_main_menu_root_page( $post ) ) {
			if ( self::is_hub_intro_edit_request() ) {
				add_meta_box(
					'gbe_hub_edit_guidance',
					__( 'Aide — intro hub', 'gbecosmolingua-core' ),
					array( __CLASS__, 'render_hub_page_edit_guidance' ),
					'page',
					'side',
					'high'
				);
			}
			return;
		}

		if ( self::is_hub_section_page( $post ) ) {
			add_meta_box(
				'gbe_le_gbe_hub_band_image',
				__( 'Photo de la bande sur la page publique', 'gbecosmolingua-core' ),
				array( __CLASS__, 'render_subpage_box' ),
				'page',
				'side',
				'high'
			);
		}
	}

	/**
	 * Page racine = un onglet du menu principal.
	 *
	 * @param WP_Post $post Page.
	 */
	private static function is_main_menu_root_page( $post ) {
		return in_array( $post->post_name, self::main_menu_slugs(), true );
	}

	/**
	 * Section affichée sur la page hub (enfant direct d’un onglet menu).
	 *
	 * @param WP_Post $post Page.
	 */
	private static function is_hub_section_page( $post ) {
		if ( self::is_main_menu_root_page( $post ) ) {
			return false;
		}
		$parent = get_post( (int) $post->post_parent );
		return $parent instanceof WP_Post && in_array( $parent->post_name, self::main_menu_slugs(), true );
	}

	/**
	 * @deprecated
	 */
	private static function is_le_gbe_hub_root( $post ) {
		return self::is_main_menu_root_page( $post );
	}

	/**
	 * @deprecated
	 */
	private static function is_le_gbe_hub_subpage( $post ) {
		return self::is_hub_section_page( $post );
	}

	/**
	 * @param WP_Post $post Page.
	 */
	public static function render_hub_root_box( $post ) {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );

		$bg_id       = (int) get_post_meta( $post->ID, self::META_HERO_BG, true );
		$figure_id   = (int) get_post_meta( $post->ID, self::META_HERO_FIGURE, true );
		$hero_lead   = (string) get_post_meta( $post->ID, self::META_HERO_LEAD, true );
		$hero_overlay = (string) get_post_meta( $post->ID, self::META_HERO_OVERLAY, true );
		if ( 'light' !== $hero_overlay && 'dark' !== $hero_overlay ) {
			$hero_overlay = 'dark';
		}
		$preview    = get_permalink( $post );
		if ( ! $preview ) {
			$preview = home_url( '/' . $post->post_name . '/' );
		}

		?>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( $preview ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Voir la page publique', 'gbecosmolingua-core' ); ?>
			</a>
		</p>
		<p class="description">
			<?php esc_html_e( 'Images et textes de la bannière. L’intro se modifie via « Intro (Gutenberg) ».', 'gbecosmolingua-core' ); ?>
		</p>

		<?php
		$page_font = (string) get_post_meta( $post->ID, self::META_SECTIONS_FONT, true );
		?>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="gbe_hub_sections_font"><?php esc_html_e( 'Police des sections (défaut)', 'gbecosmolingua-core' ); ?></label></th>
				<td>
					<select name="gbe_hub_sections_font" id="gbe_hub_sections_font">
						<?php foreach ( self::section_font_choices() as $slug => $label ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $page_font, $slug ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e( 'S’applique à toutes les cartes sauf si une section a sa propre police.', 'gbecosmolingua-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Photo à droite (bannière)', 'gbecosmolingua-core' ); ?></th>
				<td>
					<?php self::render_media_field( 'gbe_le_gbe_hero_figure_id', $figure_id ); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="gbe_le_gbe_hero_overlay"><?php esc_html_e( 'Fond par défaut', 'gbecosmolingua-core' ); ?></label></th>
				<td>
					<select name="gbe_le_gbe_hero_overlay" id="gbe_le_gbe_hero_overlay">
						<option value="dark" <?php selected( $hero_overlay, 'dark' ); ?>><?php esc_html_e( 'Sombre (texte clair)', 'gbecosmolingua-core' ); ?></option>
						<option value="light" <?php selected( $hero_overlay, 'light' ); ?>><?php esc_html_e( 'Clair (texte foncé)', 'gbecosmolingua-core' ); ?></option>
					</select>
					<p class="description"><?php esc_html_e( 'Chaque diapositive peut aussi avoir son propre réglage.', 'gbecosmolingua-core' ); ?></p>
				</td>
			</tr>
		</table>
		<?php self::render_hero_slides_editor( $post, $hero_overlay ); ?>
		<?php
	}

	/**
	 * Diapositives hero pour l’admin (repli sur champs legacy).
	 *
	 * @param WP_Post $post Page Gbe.
	 * @return array<int, array{bg_id: int, title: string, lead: string, overlay: string}>
	 */
	private static function hero_slides_for_edit( $post ) {
		$raw     = get_post_meta( $post->ID, self::META_HERO_SLIDES, true );
		$default = get_post_meta( $post->ID, self::META_HERO_OVERLAY, true );
		if ( 'light' !== $default && 'dark' !== $default ) {
			$default = 'dark';
		}
		$slides = array();

		if ( is_array( $raw ) && ! empty( $raw ) ) {
			foreach ( $raw as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$overlay = $row['overlay'] ?? $default;
				if ( 'light' !== $overlay && 'dark' !== $overlay ) {
					$overlay = $default;
				}
				$slides[] = array(
					'bg_id'   => isset( $row['bg_id'] ) ? absint( $row['bg_id'] ) : 0,
					'title'   => (string) ( $row['title'] ?? '' ),
					'lead'    => (string) ( $row['lead'] ?? '' ),
					'overlay' => $overlay,
				);
			}
		}

		if ( empty( $slides ) ) {
			$slides[] = array(
				'bg_id'   => (int) get_post_meta( $post->ID, self::META_HERO_BG, true ),
				'title'   => $post->post_title,
				'lead'    => (string) get_post_meta( $post->ID, self::META_HERO_LEAD, true ),
				'overlay' => $default,
			);
		}

		return $slides;
	}

	/**
	 * Éditeur des diapositives hero Gbe.
	 *
	 * @param WP_Post $post           Page.
	 * @param string  $default_overlay Overlay par défaut.
	 */
	private static function render_hero_slides_editor( $post, $default_overlay ) {
		$slides = self::hero_slides_for_edit( $post );
		?>
		<h3><?php esc_html_e( 'Diapositives bannière (fond + textes)', 'gbecosmolingua-core' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Ajoutez plusieurs images : le fond et les textes changent ensemble sur /le-gbe/. Une seule diapositive = bannière fixe avec animations au survol.', 'gbecosmolingua-core' ); ?></p>
		<div id="gbe-le-gbe-hero-slides" class="gbe-le-gbe-hero-slides">
			<?php foreach ( $slides as $i => $slide ) : ?>
				<?php self::render_hero_slide_row( $i, $slide, $default_overlay ); ?>
			<?php endforeach; ?>
		</div>
		<p>
			<button type="button" class="button" id="gbe-le-gbe-add-hero-slide"><?php esc_html_e( 'Ajouter une diapositive', 'gbecosmolingua-core' ); ?></button>
		</p>
		<script type="text/html" id="tmpl-gbe-le-gbe-hero-slide">
			<?php self::render_hero_slide_row( '__INDEX__', array( 'bg_id' => 0, 'title' => '', 'lead' => '', 'overlay' => $default_overlay ), $default_overlay ); ?>
		</script>
		<?php
	}

	/**
	 * Une ligne diapositive hero.
	 *
	 * @param int|string $index           Index ou placeholder.
	 * @param array      $slide           Données.
	 * @param string     $default_overlay Overlay par défaut.
	 */
	private static function render_hero_slide_row( $index, $slide, $default_overlay ) {
		$bg_id   = (int) ( $slide['bg_id'] ?? 0 );
		$overlay = $slide['overlay'] ?? $default_overlay;
		if ( 'light' !== $overlay && 'dark' !== $overlay ) {
			$overlay = $default_overlay;
		}
		$input_id = is_numeric( $index ) ? 'gbe_hero_slide_bg_' . $index : 'gbe_hero_slide_bg___INDEX__';
		$name     = is_numeric( $index ) ? 'gbe_le_gbe_hero_slides[' . $index . ']' : 'gbe_le_gbe_hero_slides[__INDEX__]';
		?>
		<fieldset class="gbe-le-gbe-hero-slide" style="margin:0 0 1rem;padding:1rem;border:1px solid #c3c4c7;border-radius:4px;background:#f6f7f7;">
			<legend style="font-weight:600;">
				<span class="gbe-le-gbe-hero-slide__label"><?php echo esc_html( is_numeric( $index ) ? sprintf( __( 'Diapositive %d', 'gbecosmolingua-core' ), $index + 1 ) : __( 'Diapositive', 'gbecosmolingua-core' ) ); ?></span>
				<button type="button" class="button-link gbe-le-gbe-remove-hero-slide" style="margin-left:0.5rem;color:#b32d2e;"><?php esc_html_e( 'Supprimer', 'gbecosmolingua-core' ); ?></button>
			</legend>
			<table class="form-table" role="presentation" style="margin-top:0;">
				<tr>
					<th scope="row"><?php esc_html_e( 'Image de fond', 'gbecosmolingua-core' ); ?></th>
					<td>
						<input type="hidden" name="<?php echo esc_attr( $name ); ?>[bg_id]" id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( (string) $bg_id ); ?>" />
						<div class="gbe-le-gbe-media-preview" style="margin-bottom:0.5rem;">
							<?php
							if ( $bg_id ) {
								echo wp_get_attachment_image( $bg_id, 'medium' );
							} else {
								echo '<span class="description">' . esc_html__( 'Aucune image', 'gbecosmolingua-core' ) . '</span>';
							}
							?>
						</div>
						<button type="button" class="button gbe-le-gbe-pick-media" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Choisir dans Médias', 'gbecosmolingua-core' ); ?></button>
						<button type="button" class="button gbe-le-gbe-clear-media" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Retirer', 'gbecosmolingua-core' ); ?></button>
					</td>
				</tr>
				<tr>
					<th scope="row"><label><?php esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></label></th>
					<td><input type="text" class="large-text" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( $slide['title'] ?? '' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label><?php esc_html_e( 'Texte sous le titre', 'gbecosmolingua-core' ); ?></label></th>
					<td><textarea class="large-text" rows="2" name="<?php echo esc_attr( $name ); ?>[lead]"><?php echo esc_textarea( $slide['lead'] ?? '' ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label><?php esc_html_e( 'Fond', 'gbecosmolingua-core' ); ?></label></th>
					<td>
						<select name="<?php echo esc_attr( $name ); ?>[overlay]">
							<option value="" <?php selected( $overlay, $default_overlay ); ?>><?php esc_html_e( 'Par défaut', 'gbecosmolingua-core' ); ?></option>
							<option value="dark" <?php selected( 'dark', $overlay ); ?>><?php esc_html_e( 'Sombre (texte clair)', 'gbecosmolingua-core' ); ?></option>
							<option value="light" <?php selected( 'light', $overlay ); ?>><?php esc_html_e( 'Clair (texte foncé)', 'gbecosmolingua-core' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php
	}

	/**
	 * Définition des grandes cartes visibles sur /le-gbe/.
	 *
	 * @return array<int, array{slug: string, title: string, intro: string}>
	 */
	public static function le_gbe_page_band_definitions() {
		return array(
			array(
				'slug'  => 'bibliotheque-linguistique',
				'title' => 'Bibliothèque',
				'intro' => 'Bibliothèque numérique des langues et patrimoines gbe.',
			),
			array(
				'slug'  => 'carte-interactive',
				'title' => 'Carte interactive',
				'intro' => 'Répartition géographique des langues, zones culturelles et routes migratoires.',
			),
			array(
				'slug'  => 'corpus-numeriques',
				'title' => 'Corpus numériques',
				'intro' => 'Proverbes, archives orales et ressources documentaires de GbeCosmoLingua.',
			),
			array(
				'slug'  => 'histoire-et-migrations',
				'title' => 'Histoire et migrations',
				'intro' => 'Récits fondateurs, royaumes et circulations des peuples gbe.',
			),
			array(
				'slug'  => 'le-continuum-gbe',
				'title' => 'Le continuum gbe',
				'intro' => 'Variétés principales et aires géographiques du continuum.',
			),
			array(
				'slug'  => 'les-langues',
				'title' => 'Les langues',
				'intro' => 'Documentation des variétés principales du continuum gbe.',
			),
			array(
				'slug'  => 'linguistique',
				'title' => 'Linguistique',
				'intro' => 'Ressources pour l\'étude scientifique des variétés gbe.',
			),
		);
	}

	/**
	 * Cartes enregistrées + valeurs par défaut.
	 *
	 * @param int $page_id Page Gbe.
	 * @return array<string, array{title: string, intro: string, image_id: int}>
	 */
	public static function get_le_gbe_page_bands( $page_id ) {
		$saved = get_post_meta( $page_id, self::META_PAGE_BANDS, true );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}

		$bands = array();
		foreach ( self::le_gbe_page_band_definitions() as $def ) {
			$slug = $def['slug'];
			$row  = isset( $saved[ $slug ] ) && is_array( $saved[ $slug ] ) ? $saved[ $slug ] : array();
			$bands[ $slug ] = array(
				'title'    => (string) ( $row['title'] ?? $def['title'] ),
				'intro'    => (string) ( $row['intro'] ?? $def['intro'] ),
				'image_id' => (int) ( $row['image_id'] ?? 0 ),
			);
		}

		return $bands;
	}

	/**
	 * Petites cartes en grille sous une grande bande (ex. Éwé, Fon sous Les langues).
	 *
	 * @return array<string, array<int, array{child_slug: string, title: string, intro: string}>>
	 */
	public static function le_gbe_page_subcard_definitions() {
		$intro = static function ( $title ) {
			return sprintf(
				/* translators: %s: card title */
				__( 'Approfondir « %s » dans le continuum linguistique gbe.', 'gbecosmolingua-core' ),
				$title
			);
		};

		return array(
			'histoire-et-migrations' => array(
				array( 'child_slug' => 'les-recits-fondateurs', 'title' => 'Les récits fondateurs', 'intro' => $intro( 'Les récits fondateurs' ) ),
				array( 'child_slug' => 'royaumes-et-formations-politiques', 'title' => 'Royaumes et formations politiques', 'intro' => $intro( 'Royaumes et formations politiques' ) ),
				array( 'child_slug' => 'migrations-et-echanges', 'title' => 'Migrations et échanges', 'intro' => $intro( 'Migrations et échanges' ) ),
			),
			'le-continuum-gbe'         => array(
				array( 'child_slug' => 'varietes-principales', 'title' => 'Variétés principales', 'intro' => $intro( 'Variétés principales' ) ),
				array( 'child_slug' => 'pays-et-territoires', 'title' => 'Pays et territoires', 'intro' => $intro( 'Pays et territoires' ) ),
			),
			'les-langues'              => array(
				array( 'child_slug' => 'ewe', 'title' => 'Éwé', 'intro' => $intro( 'Éwé' ) ),
				array( 'child_slug' => 'gen-mina', 'title' => 'Gen (Mina)', 'intro' => $intro( 'Gen (Mina)' ) ),
				array( 'child_slug' => 'fon', 'title' => 'Fon', 'intro' => $intro( 'Fon' ) ),
				array( 'child_slug' => 'aja', 'title' => 'Aja', 'intro' => $intro( 'Aja' ) ),
				array( 'child_slug' => 'gun', 'title' => 'Gun', 'intro' => $intro( 'Gun' ) ),
				array( 'child_slug' => 'phla-phera', 'title' => 'Phla-Phera', 'intro' => $intro( 'Phla-Phera' ) ),
				array( 'child_slug' => 'autres-varietes', 'title' => 'Autres variétés', 'intro' => $intro( 'Autres variétés' ) ),
			),
			'linguistique'             => array(
				array( 'child_slug' => 'alphabet', 'title' => 'Alphabet', 'intro' => $intro( 'Alphabet' ) ),
				array( 'child_slug' => 'phonologie', 'title' => 'Phonologie', 'intro' => $intro( 'Phonologie' ) ),
				array( 'child_slug' => 'morphologie', 'title' => 'Morphologie', 'intro' => $intro( 'Morphologie' ) ),
				array( 'child_slug' => 'syntaxe', 'title' => 'Syntaxe', 'intro' => $intro( 'Syntaxe' ) ),
				array( 'child_slug' => 'lexicologie', 'title' => 'Lexicologie', 'intro' => $intro( 'Lexicologie' ) ),
				array( 'child_slug' => 'dialectologie', 'title' => 'Dialectologie', 'intro' => $intro( 'Dialectologie' ) ),
				array( 'child_slug' => 'corpus-numeriques', 'title' => 'Corpus numériques', 'intro' => $intro( 'Corpus numériques' ) ),
				array( 'child_slug' => 'bibliotheque', 'title' => 'Bibliothèque', 'intro' => $intro( 'Bibliothèque' ) ),
			),
		);
	}

	/**
	 * @param int $page_id Page Gbe.
	 * @return array<string, array<int, array{child_slug: string, title: string, intro: string, image_id: int}>>
	 */
	public static function get_le_gbe_page_subcards( $page_id ) {
		$saved = get_post_meta( $page_id, self::META_PAGE_SUBCARDS, true );
		if ( ! is_array( $saved ) ) {
			$saved = array();
		}

		$groups = array();
		foreach ( self::le_gbe_page_subcard_definitions() as $band_slug => $cards ) {
			$groups[ $band_slug ] = array();
			foreach ( $cards as $index => $def ) {
				$key = $def['child_slug'];
				$row = isset( $saved[ $band_slug ][ $key ] ) && is_array( $saved[ $band_slug ][ $key ] )
					? $saved[ $band_slug ][ $key ]
					: array();
				$groups[ $band_slug ][] = array(
					'child_slug' => $def['child_slug'],
					'title'      => (string) ( $row['title'] ?? $def['title'] ),
					'intro'      => (string) ( $row['intro'] ?? $def['intro'] ),
					'image_id'   => (int) ( $row['image_id'] ?? 0 ),
				);
			}
		}

		return $groups;
	}

	/**
	 * Titres des grandes bandes pour regrouper les petites cartes.
	 *
	 * @return array<string, string>
	 */
	private static function le_gbe_band_titles_by_slug() {
		$titles = array();
		foreach ( self::le_gbe_page_band_definitions() as $def ) {
			$titles[ $def['slug'] ] = $def['title'];
		}
		return $titles;
	}

	/**
	 * Mise en page libre : sections ordonnées avec petites cartes optionnelles.
	 *
	 * @param int $page_id Page Gbe.
	 * @return array{bands: array<int, array<string, mixed>>}
	 */
	public static function get_hub_page_layout( $page_id ) {
		$saved = get_post_meta( $page_id, self::META_PAGE_LAYOUT, true );
		if ( ! is_array( $saved ) ) {
			$saved = get_post_meta( $page_id, self::META_PAGE_LAYOUT_LEGACY, true );
		}
		if ( is_array( $saved ) ) {
			return array(
				'bands' => ( isset( $saved['bands'] ) && is_array( $saved['bands'] ) ) ? $saved['bands'] : array(),
				'more'  => ( isset( $saved['more'] ) && is_array( $saved['more'] ) ) ? $saved['more'] : array(),
			);
		}

		return array(
			'bands' => array(),
			'more'  => array(),
		);
	}

	/**
	 * @param int $page_id Page Gbe.
	 * @return array{bands: array<int, array<string, mixed>>, more: array<int, array<string, mixed>>}
	 */
	public static function get_le_gbe_page_layout( $page_id ) {
		return self::get_hub_page_layout( $page_id );
	}

	/**
	 * Diapositives hero enregistrées (public).
	 *
	 * @param int $page_id ID page hub.
	 * @return array<int, array{bg_id: int, title: string, lead: string, overlay: string}>
	 */
	public static function get_hub_hero_slides( $page_id ) {
		$post = get_post( $page_id );
		if ( ! $post instanceof WP_Post ) {
			return array();
		}

		return self::hero_slides_for_edit( $post );
	}

	/**
	 * Reprend les images/textes enregistrés avant le composeur libre.
	 *
	 * @param int                  $page_id Page Gbe.
	 * @param array<string, mixed> $layout  Layout.
	 * @return array<string, mixed>
	 */
	private static function merge_legacy_le_gbe_meta_into_layout( $page_id, $layout ) {
		$parent_slug = 'le-gbe';
		$old_bands    = get_post_meta( $page_id, self::META_PAGE_BANDS, true );
		$old_subcards = get_post_meta( $page_id, self::META_PAGE_SUBCARDS, true );

		if ( ! is_array( $old_bands ) ) {
			$old_bands = array();
		}
		if ( ! is_array( $old_subcards ) ) {
			$old_subcards = array();
		}

		foreach ( $layout['bands'] as $index => $band ) {
			$uid = $band['uid'] ?? '';
			if ( $uid && isset( $old_bands[ $uid ] ) && is_array( $old_bands[ $uid ] ) ) {
				$row = $old_bands[ $uid ];
				if ( ! empty( $row['title'] ) ) {
					$layout['bands'][ $index ]['title'] = $row['title'];
				}
				if ( ! empty( $row['intro'] ) ) {
					$layout['bands'][ $index ]['intro'] = $row['intro'];
				}
				if ( ! empty( $row['image_id'] ) ) {
					$layout['bands'][ $index ]['image_id'] = (int) $row['image_id'];
				}
			}

			if ( empty( $layout['bands'][ $index ]['image_id'] ) && $uid ) {
				$child = get_page_by_path( trim( $parent_slug, '/' ) . '/' . $uid, OBJECT, 'page' );
				if ( $child && has_post_thumbnail( $child ) ) {
					$layout['bands'][ $index ]['image_id'] = (int) get_post_thumbnail_id( $child );
				}
			}

			if ( empty( $layout['bands'][ $index ]['subcards'] ) ) {
				continue;
			}

			foreach ( $layout['bands'][ $index ]['subcards'] as $sub_index => $sub ) {
				$child_slug = $sub['child_slug'] ?? '';
				if ( $uid && $child_slug && isset( $old_subcards[ $uid ][ $child_slug ] ) ) {
					$row = $old_subcards[ $uid ][ $child_slug ];
					if ( ! empty( $row['title'] ) ) {
						$layout['bands'][ $index ]['subcards'][ $sub_index ]['title'] = $row['title'];
					}
					if ( ! empty( $row['intro'] ) ) {
						$layout['bands'][ $index ]['subcards'][ $sub_index ]['intro'] = $row['intro'];
					}
					if ( ! empty( $row['image_id'] ) ) {
						$layout['bands'][ $index ]['subcards'][ $sub_index ]['image_id'] = (int) $row['image_id'];
					}
				}

				if ( empty( $layout['bands'][ $index ]['subcards'][ $sub_index ]['image_id'] ) && $uid && $child_slug ) {
					$child = get_page_by_path( trim( $parent_slug, '/' ) . '/' . $uid . '/' . $child_slug, OBJECT, 'page' );
					if ( $child && has_post_thumbnail( $child ) ) {
						$layout['bands'][ $index ]['subcards'][ $sub_index ]['image_id'] = (int) get_post_thumbnail_id( $child );
					}
				}
			}
		}

		if ( ! empty( $layout['more'] ) && is_array( $layout['more'] ) ) {
			foreach ( $layout['more'] as $index => $card ) {
				$slug = $card['slug'] ?? '';
				if ( empty( $card['image_id'] ) && $slug ) {
					$child = get_page_by_path( trim( $parent_slug, '/' ) . '/' . $slug, OBJECT, 'page' );
					if ( $child && has_post_thumbnail( $child ) ) {
						$layout['more'][ $index ]['image_id'] = (int) get_post_thumbnail_id( $child );
					}
				}
			}
		}

		return $layout;
	}

	/**
	 * Cartes du bloc « Voir plus » en bas de /le-gbe/.
	 *
	 * @return array<int, array{slug: string, title: string, intro: string}>
	 */
	public static function le_gbe_page_more_definitions() {
		return array(
			array(
				'slug'  => 'presentation-generale',
				'title' => 'Présentation générale',
				'intro' => 'Le gbe : une langue, plusieurs variétés. Présentation du continuum linguistique et de sa vitalité contemporaine.',
			),
			array(
				'slug'  => 'peuples-du-continuum',
				'title' => 'Peuples du continuum',
				'intro' => 'Les peuples gbe partagent une histoire, des traditions et des systèmes de pensée communs.',
			),
		);
	}

	/**
	 * Complète une mise en page sauvegardée (petites cartes + Voir plus).
	 *
	 * @param array<string, mixed> $layout Layout.
	 * @return array<string, mixed>
	 */
	private static function ensure_layout_complete( $layout ) {
		return $layout;
	}

	/**
	 * Layout par défaut (7 grandes bandes + petites cartes connues).
	 *
	 * @return array{bands: array<int, array<string, mixed>>}
	 */
	public static function le_gbe_default_page_layout() {
		return array(
			'bands' => array(),
			'more'  => array(),
		);
	}

	/**
	 * Éditeur visuel : sections + cartes, ordre libre.
	 *
	 * @param WP_Post $post Page hub.
	 */
	public static function render_hub_page_bands_box( $post ) {
		self::render_le_gbe_page_bands_box( $post );
	}

	/**
	 * @param WP_Post $post Page hub.
	 */
	public static function render_le_gbe_page_bands_box( $post ) {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );

		$layout = self::get_hub_page_layout( $post->ID );
		?>
		<style>
			.gbe-le-gbe-band{border:1px solid #c3c4c7;background:#fff;margin:0 0 1rem;padding:1rem;border-radius:4px}
			.gbe-le-gbe-band-handle,.gbe-le-gbe-subcard-handle{cursor:move;color:#646970;margin-right:0.5rem}
			.gbe-le-gbe-sort-placeholder{border:2px dashed #2271b1;min-height:80px;margin-bottom:1rem;background:#f0f6fc}
			.gbe-le-gbe-subcard{border:1px solid #dcdcde;background:#f6f7f7;margin:0.5rem 0;padding:0.75rem;border-radius:4px}
			.gbe-le-gbe-band-toolbar{display:flex;gap:0.5rem;align-items:center;margin-bottom:0.75rem}
		</style>
		<p class="description">
			<?php esc_html_e( 'Ajoutez des sections, glissez pour changer l’ordre, choisissez la disposition. Tout le contenu visible sous le hero se gère ici.', 'gbecosmolingua-core' ); ?>
		</p>
		<div id="gbe-le-gbe-bands-list">
			<?php foreach ( $layout['bands'] as $band ) : ?>
				<?php self::render_layout_band_row( $band ); ?>
			<?php endforeach; ?>
		</div>
		<p>
			<button type="button" class="button button-primary" id="gbe-le-gbe-add-band">
				<?php esc_html_e( '+ Ajouter une section', 'gbecosmolingua-core' ); ?>
			</button>
		</p>

		<hr style="margin:2rem 0;" />
		<h3><?php esc_html_e( 'Bloc « Voir plus » (bas de page)', 'gbecosmolingua-core' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Cartes supplémentaires affichées tout en bas de la page, sous toutes les sections.', 'gbecosmolingua-core' ); ?></p>
		<div id="gbe-le-gbe-more-list">
			<?php foreach ( (array) ( $layout['more'] ?? array() ) as $more_card ) : ?>
				<?php self::render_layout_more_card_row( $more_card ); ?>
			<?php endforeach; ?>
		</div>
		<p>
			<button type="button" class="button" id="gbe-le-gbe-add-more-card">
				<?php esc_html_e( '+ Ajouter une carte « Voir plus »', 'gbecosmolingua-core' ); ?>
			</button>
		</p>

		<script type="text/html" id="gbe-le-gbe-band-template">
			<?php self::render_layout_band_row( self::empty_layout_band() ); ?>
		</script>
		<script type="text/html" id="gbe-le-gbe-subcard-template">
			<?php self::render_layout_subcard_row( self::empty_layout_subcard() ); ?>
		</script>
		<script type="text/html" id="gbe-le-gbe-more-card-template">
			<?php self::render_layout_more_card_row( self::empty_layout_more_card() ); ?>
		</script>
		<p style="margin-top:2rem;">
			<a class="button button-link-delete" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'gbe_clear_hub_layout', $post->ID, admin_url( 'admin.php' ) ), 'gbe_clear_hub_layout_' . $post->ID ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Supprimer toutes les cartes enregistrées sur cette page ?', 'gbecosmolingua-core' ) ); ?>');">
				<?php esc_html_e( 'Vider toutes les cartes', 'gbecosmolingua-core' ); ?>
			</a>
		</p>
		<?php
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function empty_layout_more_card() {
		return array(
			'slug'        => '',
			'title'       => '',
			'intro'       => '',
			'image_id'    => 0,
			'button_text' => __( 'Découvrir', 'gbecosmolingua-core' ),
			'button_url'  => '',
		);
	}

	/**
	 * @param array<string, mixed> $card Carte « Voir plus ».
	 */
	private static function render_layout_more_card_row( $card ) {
		?>
		<div class="gbe-le-gbe-more-card gbe-le-gbe-subcard">
			<div class="gbe-le-gbe-band-toolbar">
				<span class="gbe-le-gbe-more-card-handle dashicons dashicons-move"></span>
				<strong><?php esc_html_e( 'Carte « Voir plus »', 'gbecosmolingua-core' ); ?></strong>
				<button type="button" class="button-link-delete gbe-le-gbe-remove-more-card"><?php esc_html_e( 'Supprimer', 'gbecosmolingua-core' ); ?></button>
			</div>
			<table class="form-table" role="presentation" style="margin:0;">
				<tr>
					<th scope="row"><?php esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></th>
					<td><input type="text" class="large-text" data-more-field="title" value="<?php echo esc_attr( $card['title'] ?? '' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Texte', 'gbecosmolingua-core' ); ?></th>
					<td><textarea class="large-text" rows="2" data-more-field="intro"><?php echo esc_textarea( $card['intro'] ?? '' ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Image', 'gbecosmolingua-core' ); ?></th>
					<td><?php self::render_media_field_data( 'more', 'image_id', (int) ( $card['image_id'] ?? 0 ) ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Bouton', 'gbecosmolingua-core' ); ?></th>
					<td>
						<input type="text" class="regular-text" data-more-field="button_text" value="<?php echo esc_attr( $card['button_text'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Découvrir', 'gbecosmolingua-core' ); ?>" />
						<input type="url" class="large-text" data-more-field="button_url" value="<?php echo esc_attr( $card['button_url'] ?? '' ); ?>" placeholder="https://" style="margin-top:0.35rem;" />
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Identifiant (slug)', 'gbecosmolingua-core' ); ?></th>
					<td>
						<input type="text" class="regular-text" data-more-field="slug" value="<?php echo esc_attr( $card['slug'] ?? '' ); ?>" placeholder="presentation-generale" />
						<p class="description"><?php esc_html_e( 'Optionnel. Sert au lien par défaut (/le-gbe/slug/).', 'gbecosmolingua-core' ); ?></p>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function empty_layout_band() {
		return array(
			'uid'         => 'section-' . wp_generate_password( 6, false, false ),
			'title'       => '',
			'intro'       => '',
			'image_id'    => 0,
			'style'       => 'large-grid',
			'image_side'  => 'left',
			'button_text' => '',
			'button_url'  => '',
			'font'        => '',
			'subcards'    => array(),
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function empty_layout_subcard() {
		return array(
			'title'       => '',
			'intro'       => '',
			'image_id'    => 0,
			'button_text' => __( 'Découvrir', 'gbecosmolingua-core' ),
			'button_url'  => '',
		);
	}

	/**
	 * @param array<string, mixed> $band Band data.
	 */
	private static function render_layout_band_row( $band ) {
		$uid = isset( $band['uid'] ) ? (string) $band['uid'] : 'section';
		?>
		<div class="gbe-le-gbe-band">
			<div class="gbe-le-gbe-band-toolbar">
				<span class="gbe-le-gbe-band-handle dashicons dashicons-move" title="<?php esc_attr_e( 'Glisser pour réordonner', 'gbecosmolingua-core' ); ?>"></span>
				<strong><?php esc_html_e( 'Section', 'gbecosmolingua-core' ); ?></strong>
				<button type="button" class="button-link-delete gbe-le-gbe-remove-band"><?php esc_html_e( 'Supprimer', 'gbecosmolingua-core' ); ?></button>
			</div>
			<input type="hidden" data-band-field="uid" value="<?php echo esc_attr( $uid ); ?>" />
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></th>
					<td><input type="text" class="large-text" data-band-field="title" value="<?php echo esc_attr( $band['title'] ?? '' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Texte', 'gbecosmolingua-core' ); ?></th>
					<td><textarea class="large-text" rows="3" data-band-field="intro"><?php echo esc_textarea( $band['intro'] ?? '' ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label for="gbe_band_font_<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Police', 'gbecosmolingua-core' ); ?></label></th>
					<td>
						<select data-band-field="font" id="gbe_band_font_<?php echo esc_attr( $uid ); ?>">
							<?php foreach ( self::section_font_choices() as $slug => $label ) : ?>
								<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $band['font'] ?? '', $slug ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Disposition', 'gbecosmolingua-core' ); ?></th>
					<td>
						<select data-band-field="style">
							<option value="large" <?php selected( $band['style'] ?? '', 'large' ); ?>><?php esc_html_e( 'Grande carte seule (image + texte)', 'gbecosmolingua-core' ); ?></option>
							<option value="large-grid" <?php selected( $band['style'] ?? 'large-grid', 'large-grid' ); ?>><?php esc_html_e( 'Grande carte + petites cartes en dessous', 'gbecosmolingua-core' ); ?></option>
							<option value="grid" <?php selected( $band['style'] ?? '', 'grid' ); ?>><?php esc_html_e( 'Petites cartes seulement (grille)', 'gbecosmolingua-core' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Image à gauche ou à droite', 'gbecosmolingua-core' ); ?></th>
					<td>
						<select data-band-field="image_side">
							<option value="left" <?php selected( $band['image_side'] ?? 'left', 'left' ); ?>><?php esc_html_e( 'Image à gauche', 'gbecosmolingua-core' ); ?></option>
							<option value="right" <?php selected( $band['image_side'] ?? '', 'right' ); ?>><?php esc_html_e( 'Image à droite', 'gbecosmolingua-core' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Image grande carte', 'gbecosmolingua-core' ); ?></th>
					<td><?php self::render_media_field_data( 'band', 'image_id', (int) ( $band['image_id'] ?? 0 ), $uid ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Bouton (texte)', 'gbecosmolingua-core' ); ?></th>
					<td><input type="text" class="regular-text" data-band-field="button_text" value="<?php echo esc_attr( $band['button_text'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Explorer…', 'gbecosmolingua-core' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Bouton (lien)', 'gbecosmolingua-core' ); ?></th>
					<td><input type="url" class="large-text" data-band-field="button_url" value="<?php echo esc_attr( $band['button_url'] ?? '' ); ?>" placeholder="https://" /></td>
				</tr>
			</table>
			<h4><?php esc_html_e( 'Petites cartes dans cette section', 'gbecosmolingua-core' ); ?></h4>
			<div class="gbe-le-gbe-subcards-list">
				<?php foreach ( (array) ( $band['subcards'] ?? array() ) as $sub ) : ?>
					<?php self::render_layout_subcard_row( $sub ); ?>
				<?php endforeach; ?>
			</div>
			<p><button type="button" class="button gbe-le-gbe-add-subcard"><?php esc_html_e( '+ Ajouter une petite carte', 'gbecosmolingua-core' ); ?></button></p>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $sub Subcard.
	 */
	private static function render_layout_subcard_row( $sub ) {
		?>
		<div class="gbe-le-gbe-subcard">
			<div class="gbe-le-gbe-band-toolbar">
				<span class="gbe-le-gbe-subcard-handle dashicons dashicons-move"></span>
				<strong><?php esc_html_e( 'Petite carte', 'gbecosmolingua-core' ); ?></strong>
				<button type="button" class="button-link-delete gbe-le-gbe-remove-subcard"><?php esc_html_e( 'Supprimer', 'gbecosmolingua-core' ); ?></button>
			</div>
			<table class="form-table" role="presentation" style="margin:0;">
				<tr>
					<th scope="row"><?php esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></th>
					<td><input type="text" class="large-text" data-sub-field="title" value="<?php echo esc_attr( $sub['title'] ?? '' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Texte', 'gbecosmolingua-core' ); ?></th>
					<td><textarea class="large-text" rows="2" data-sub-field="intro"><?php echo esc_textarea( $sub['intro'] ?? '' ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Image', 'gbecosmolingua-core' ); ?></th>
					<td><?php self::render_media_field_data( 'sub', 'image_id', (int) ( $sub['image_id'] ?? 0 ) ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Bouton', 'gbecosmolingua-core' ); ?></th>
					<td>
						<input type="text" class="regular-text" data-sub-field="button_text" value="<?php echo esc_attr( $sub['button_text'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Découvrir', 'gbecosmolingua-core' ); ?>" />
						<input type="url" class="large-text" data-sub-field="button_url" value="<?php echo esc_attr( $sub['button_url'] ?? '' ); ?>" placeholder="https://" style="margin-top:0.35rem;" />
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Champ média avec data-band-field / data-sub-field (noms fixés en JS).
	 *
	 * @param string $scope band|sub.
	 * @param string $field Field key.
	 * @param int    $attachment_id Attachment.
	 * @param string $uid_suffix Unique suffix for input id.
	 */
	private static function render_media_field_data( $scope, $field, $attachment_id, $uid_suffix = '' ) {
		$input_id = 'gbe_media_' . $scope . '_' . $field . '_' . wp_generate_password( 8, false, false );
		if ( $uid_suffix ) {
			$input_id = 'gbe_media_band_' . sanitize_key( $uid_suffix ) . '_' . $field;
		}
		$preview = $attachment_id ? wp_get_attachment_image( $attachment_id, 'medium' ) : '';
		if ( 'band' === $scope ) {
			$data = 'data-band-field="' . esc_attr( $field ) . '"';
		} elseif ( 'more' === $scope ) {
			$data = 'data-more-field="' . esc_attr( $field ) . '"';
		} else {
			$data = 'data-sub-field="' . esc_attr( $field ) . '"';
		}
		?>
		<input type="hidden" <?php echo $data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( (string) $attachment_id ); ?>" />
		<div class="gbe-le-gbe-media-preview" style="margin-bottom:0.5rem;"><?php echo $preview ? $preview : '<span class="description">' . esc_html__( 'Aucune image', 'gbecosmolingua-core' ) . '</span>'; ?></div>
		<button type="button" class="button gbe-le-gbe-pick-media" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Choisir dans Médias', 'gbecosmolingua-core' ); ?></button>
		<button type="button" class="button gbe-le-gbe-clear-media" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Retirer', 'gbecosmolingua-core' ); ?></button>
		<?php
	}

	/**
	 * @param WP_Post $post Page.
	 */
	public static function render_subpage_box( $post ) {
		$parent   = get_post( (int) $post->post_parent );
		$hub_link = ( $parent instanceof WP_Post ) ? get_permalink( $parent ) : home_url( '/' );
		echo '<p class="description">' . esc_html__( 'Le contenu de /le-gbe/ se compose sur la page « Gbe » → section « Composer la page /le-gbe/ ».', 'gbecosmolingua-core' ) . '</p>';
		echo '<p><a href="' . esc_url( $hub_link ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Aperçu page publique', 'gbecosmolingua-core' ) . '</a></p>';
	}

	/**
	 * @param WP_Post $hub Gbe page.
	 */
	private static function render_subpages_list( $hub ) {
		$children = get_pages(
			array(
				'parent'      => $hub->ID,
				'sort_column' => 'menu_order,post_title',
				'post_status' => 'publish,draft',
			)
		);

		if ( empty( $children ) ) {
			echo '<p class="description">' . esc_html__( 'Aucune sous-page. Lancez l’import des pages.', 'gbecosmolingua-core' ) . '</p>';
			return;
		}

		echo '<ul style="margin:0; list-style:disc; padding-left:1.25rem;">';
		foreach ( $children as $child ) {
			$edit = get_edit_post_link( $child->ID, 'raw' );
			$thumb = has_post_thumbnail( $child ) ? ' ✓ ' . __( 'image', 'gbecosmolingua-core' ) : '';
			echo '<li><a href="' . esc_url( $edit ) . '">' . esc_html( $child->post_title ) . '</a>' . esc_html( $thumb ) . '</li>';
		}
		echo '</ul>';
	}

	/**
	 * @param string $input_name Field name.
	 * @param int    $attachment_id Attachment ID.
	 */
	private static function render_media_field( $input_name, $attachment_id, $input_id = '' ) {
		if ( '' === $input_id ) {
			$input_id = $input_name;
		}
		$input_id = preg_replace( '/[^a-zA-Z0-9_-]/', '_', $input_id );
		$preview = '';
		if ( $attachment_id ) {
			$preview = wp_get_attachment_image( $attachment_id, 'medium' );
		}
		?>
		<input type="hidden" name="<?php echo esc_attr( $input_name ); ?>" id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( (string) $attachment_id ); ?>" />
		<div class="gbe-le-gbe-media-preview" style="margin-bottom:0.5rem;"><?php echo $preview ? $preview : '<span class="description">' . esc_html__( 'Aucune image', 'gbecosmolingua-core' ) . '</span>'; ?></div>
		<button type="button" class="button gbe-le-gbe-pick-media" data-target="<?php echo esc_attr( $input_id ); ?>">
			<?php esc_html_e( 'Choisir dans Médias', 'gbecosmolingua-core' ); ?>
		</button>
		<button type="button" class="button gbe-le-gbe-clear-media" data-target="<?php echo esc_attr( $input_id ); ?>">
			<?php esc_html_e( 'Retirer', 'gbecosmolingua-core' ); ?>
		</button>
		<?php
	}

	/**
	 * @param string $hook Admin hook.
	 */
	public static function enqueue_scripts( $hook ) {
		$post = null;

		$composer_edit_hooks = array(
			'gbecosmolingua_page_gbecosmolingua-hub-composer-edit',
			'admin_page_gbecosmolingua-hub-composer-edit',
		);

		if ( in_array( $hook, $composer_edit_hooks, true ) ) {
			$slug = isset( $_GET['hub'] ) ? sanitize_title( wp_unslash( $_GET['hub'] ) ) : 'le-gbe';
			$post = self::get_hub_page( $slug );
		} elseif ( 'gbecosmolingua_page_gbecosmolingua-le-gbe-composer' === $hook ) {
			$post = self::get_le_gbe_page();
		} elseif ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			global $post;
			if ( $post instanceof WP_Post && self::is_main_menu_root_page( $post ) && ! self::is_hub_intro_edit_request() ) {
				return;
			}
		} else {
			return;
		}

		if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
			return;
		}

		if ( ! self::is_main_menu_root_page( $post ) && ! self::is_hub_section_page( $post ) ) {
			return;
		}

		self::enqueue_hub_admin_assets( $post );
	}

	/**
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post.
	 */
	public static function save_page( $post_id, $post ) {
		if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
			return;
		}
		if ( ! isset( $_POST[ self::NONCE_FIELD ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_FIELD ] ) ), self::NONCE_ACTION ) ) {
			$composer_ok = isset( $_POST['gbe_hub_composer_nonce'] ) && wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['gbe_hub_composer_nonce'] ) ),
				'gbe_save_hub_composer'
			);
			if ( ! $composer_ok ) {
				return;
			}
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( self::is_main_menu_root_page( $post ) && isset( $_POST['gbe_le_gbe_layout']['bands'] ) && is_array( $_POST['gbe_le_gbe_layout']['bands'] ) ) {
			$raw   = wp_unslash( $_POST['gbe_le_gbe_layout']['bands'] );
			$bands = array();
			foreach ( $raw as $band_raw ) {
				if ( ! is_array( $band_raw ) ) {
					continue;
				}
				$subcards = array();
				if ( ! empty( $band_raw['subcards'] ) && is_array( $band_raw['subcards'] ) ) {
					foreach ( $band_raw['subcards'] as $sub_raw ) {
						if ( ! is_array( $sub_raw ) ) {
							continue;
						}
						$subcards[] = array(
							'title'       => sanitize_text_field( $sub_raw['title'] ?? '' ),
							'intro'       => sanitize_textarea_field( $sub_raw['intro'] ?? '' ),
							'image_id'    => isset( $sub_raw['image_id'] ) ? absint( $sub_raw['image_id'] ) : 0,
							'button_text' => sanitize_text_field( $sub_raw['button_text'] ?? '' ),
							'button_url'  => esc_url_raw( $sub_raw['button_url'] ?? '' ),
						);
					}
				}
				$bands[] = array(
					'uid'         => sanitize_title( $band_raw['uid'] ?? 'section-' . count( $bands ) ),
					'title'       => sanitize_text_field( $band_raw['title'] ?? '' ),
					'intro'       => sanitize_textarea_field( $band_raw['intro'] ?? '' ),
					'image_id'    => isset( $band_raw['image_id'] ) ? absint( $band_raw['image_id'] ) : 0,
					'style'       => in_array( $band_raw['style'] ?? '', array( 'large', 'large-grid', 'grid' ), true ) ? $band_raw['style'] : 'large-grid',
					'image_side'  => ( isset( $band_raw['image_side'] ) && 'right' === $band_raw['image_side'] ) ? 'right' : 'left',
					'button_text' => sanitize_text_field( $band_raw['button_text'] ?? '' ),
					'button_url'  => esc_url_raw( $band_raw['button_url'] ?? '' ),
					'font'        => self::sanitize_section_font( $band_raw['font'] ?? '' ),
					'subcards'    => $subcards,
				);
			}
			$more = array();
			if ( ! empty( $_POST['gbe_le_gbe_layout']['more'] ) && is_array( $_POST['gbe_le_gbe_layout']['more'] ) ) {
				foreach ( wp_unslash( $_POST['gbe_le_gbe_layout']['more'] ) as $more_raw ) {
					if ( ! is_array( $more_raw ) ) {
						continue;
					}
					$more[] = array(
						'slug'        => sanitize_title( $more_raw['slug'] ?? '' ),
						'title'       => sanitize_text_field( $more_raw['title'] ?? '' ),
						'intro'       => sanitize_textarea_field( $more_raw['intro'] ?? '' ),
						'image_id'    => isset( $more_raw['image_id'] ) ? absint( $more_raw['image_id'] ) : 0,
						'button_text' => sanitize_text_field( $more_raw['button_text'] ?? '' ),
						'button_url'  => esc_url_raw( $more_raw['button_url'] ?? '' ),
					);
				}
			}
			update_post_meta( $post_id, self::META_PAGE_LAYOUT, array(
				'bands' => $bands,
				'more'  => $more,
			) );
		}

		if ( ! self::is_main_menu_root_page( $post ) ) {
			return;
		}

		if ( isset( $_POST['gbe_hub_sections_font'] ) ) {
			update_post_meta(
				$post_id,
				self::META_SECTIONS_FONT,
				self::sanitize_section_font( wp_unslash( $_POST['gbe_hub_sections_font'] ) )
			);
		}

		$bg     = isset( $_POST['gbe_le_gbe_hero_bg_id'] ) ? absint( $_POST['gbe_le_gbe_hero_bg_id'] ) : 0;
		$figure = isset( $_POST['gbe_le_gbe_hero_figure_id'] ) ? absint( $_POST['gbe_le_gbe_hero_figure_id'] ) : 0;
		$lead   = isset( $_POST['gbe_le_gbe_hero_lead'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gbe_le_gbe_hero_lead'] ) ) : '';

		if ( self::is_main_menu_root_page( $post ) ) {
			$overlay = isset( $_POST['gbe_le_gbe_hero_overlay'] ) ? sanitize_text_field( wp_unslash( $_POST['gbe_le_gbe_hero_overlay'] ) ) : 'dark';
			if ( 'light' !== $overlay ) {
				$overlay = 'dark';
			}
			update_post_meta( $post_id, self::META_HERO_OVERLAY, $overlay );

			$slides = array();
			if ( ! empty( $_POST['gbe_le_gbe_hero_slides'] ) && is_array( $_POST['gbe_le_gbe_hero_slides'] ) ) {
				foreach ( wp_unslash( $_POST['gbe_le_gbe_hero_slides'] ) as $row ) {
					if ( ! is_array( $row ) ) {
						continue;
					}
					$slide_overlay = sanitize_text_field( $row['overlay'] ?? '' );
					if ( 'light' !== $slide_overlay && 'dark' !== $slide_overlay ) {
						$slide_overlay = $overlay;
					}
					$slides[] = array(
						'bg_id'   => isset( $row['bg_id'] ) ? absint( $row['bg_id'] ) : 0,
						'title'   => sanitize_text_field( $row['title'] ?? '' ),
						'lead'    => sanitize_textarea_field( $row['lead'] ?? '' ),
						'overlay' => $slide_overlay,
					);
				}
			}
			update_post_meta( $post_id, self::META_HERO_SLIDES, $slides );

			if ( ! empty( $slides ) ) {
				$bg   = (int) ( $slides[0]['bg_id'] ?? 0 );
				$lead = (string) ( $slides[0]['lead'] ?? '' );
			}
		}

		update_post_meta( $post_id, self::META_HERO_BG, $bg );
		update_post_meta( $post_id, self::META_HERO_FIGURE, $figure );
		update_post_meta( $post_id, self::META_HERO_LEAD, $lead );
	}
}
