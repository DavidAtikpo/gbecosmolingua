<?php
/**
 * Page importer and site configuration.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

require_once GBE_CORE_PATH . 'includes/pages-data.php';

/**
 * Imports pages, menu and WordPress settings.
 */
class GBE_Page_Importer {

	const OPTION_KEY = 'gbe_pages_imported';

	/**
	 * Run full import (idempotent).
	 *
	 * @param bool $force Re-import even if already done.
	 * @return array{created: int, skipped: int, menu: bool}
	 */
	public static function import( $force = false ) {
		if ( ! $force && get_option( self::OPTION_KEY ) ) {
			return array(
				'created' => 0,
				'skipped' => 0,
				'menu'    => true,
				'message' => __( 'Import déjà effectué.', 'gbecosmolingua-core' ),
			);
		}

		$created = 0;
		$skipped = 0;
		$page_ids = array();

		foreach ( gbe_get_pages_data() as $page_data ) {
			$result = self::create_page_tree( $page_data, 0, '', $force );
			$created += $result['created'];
			$skipped += $result['skipped'];
			if ( $result['id'] ) {
				$page_ids[ $page_data['slug'] ] = $result['id'];
			}
		}

		self::configure_reading_settings();
		self::configure_permalinks();
		self::create_navigation_menu( $page_ids );
		self::activate_theme_and_plugin();
		self::deduplicate_imported_pages();
		self::remove_obsolete_pages();

		update_option( self::OPTION_KEY, time() );

		return array(
			'created' => $created,
			'skipped' => $skipped,
			'menu'    => true,
			'message' => sprintf(
				/* translators: 1: created count, 2: skipped count */
				__( 'Import terminé : %1$d pages créées, %2$d existantes conservées.', 'gbecosmolingua-core' ),
				$created,
				$skipped
			),
		);
	}

	/**
	 * Create a page and its children recursively.
	 *
	 * @param array<string, mixed> $data        Page data.
	 * @param int                  $parent_id   Parent page ID.
	 * @param string               $parent_path     Parent path without leading slash.
	 * @param bool                 $update_existing Update content when page already exists.
	 * @return array{created: int, skipped: int, id: int}
	 */
	private static function create_page_tree( $data, $parent_id, $parent_path = '', $update_existing = false ) {
		$created = 0;
		$skipped = 0;

		$page_path = $parent_path ? $parent_path . '/' . $data['slug'] : $data['slug'];
		$existing  = get_page_by_path( $page_path, OBJECT, 'page' );

		if ( $existing ) {
			$page_id = (int) $existing->ID;
			if ( (int) $existing->post_parent !== (int) $parent_id ) {
				wp_update_post(
					array(
						'ID'          => $page_id,
						'post_parent' => (int) $parent_id,
					)
				);
			}
			if ( $update_existing ) {
				wp_update_post(
					array(
						'ID'           => $page_id,
						'post_title'   => $data['title'],
						'post_content' => $data['content'] ?? '',
						'menu_order'   => $data['menu_order'] ?? 0,
					)
				);
			}
			++$skipped;
		} else {
			$page_id = wp_insert_post(
				array(
					'post_title'   => $data['title'],
					'post_name'    => $data['slug'],
					'post_content' => $data['content'] ?? '',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_parent'  => $parent_id,
					'menu_order'   => $data['menu_order'] ?? 0,
				),
				true
			);

			if ( is_wp_error( $page_id ) ) {
				return array( 'created' => 0, 'skipped' => 0, 'id' => 0 );
			}
			++$created;
		}

		if ( ! empty( $data['children'] ) ) {
			foreach ( $data['children'] as $child ) {
				$child_result = self::create_page_tree( $child, $page_id, $page_path, $update_existing );
				$created     += $child_result['created'];
				$skipped     += $child_result['skipped'];
			}
		}

		return array(
			'created' => $created,
			'skipped' => $skipped,
			'id'      => (int) $page_id,
		);
	}

	/**
	 * Set static front page and blog settings.
	 */
	private static function configure_reading_settings() {
		$home = get_page_by_path( 'accueil' );
		if ( ! $home ) {
			$home_id = wp_insert_post(
				array(
					'post_title'  => 'Accueil',
					'post_name'   => 'accueil',
					'post_status' => 'publish',
					'post_type'   => 'page',
				)
			);
		} else {
			$home_id = $home->ID;
		}

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		update_option( 'blogname', 'GbeCosmoLingua' );
		update_option( 'blogdescription', 'Observatoire international des langues, cultures et patrimoines gbe' );
		update_option( 'WPLANG', 'fr_FR' );
	}

	/**
	 * Enable pretty permalinks required for /le-gbe/ style URLs.
	 */
	public static function configure_permalinks() {
		if ( get_option( 'permalink_structure' ) !== '/%postname%/' ) {
			update_option( 'permalink_structure', '/%postname%/' );
		}

		global $wp_rewrite;
		if ( isset( $wp_rewrite ) ) {
			$wp_rewrite->set_permalink_structure( '/%postname%/' );
			$wp_rewrite->init();
			$wp_rewrite->flush_rules( true );
		}

		if ( ! function_exists( 'save_mod_rewrite_rules' ) && defined( 'ABSPATH' ) ) {
			require_once ABSPATH . 'wp-admin/includes/misc.php';
		}

		if ( function_exists( 'save_mod_rewrite_rules' ) ) {
			save_mod_rewrite_rules();
		} else {
			flush_rewrite_rules( true );
		}
	}

	/**
	 * Create primary navigation menu with all rubriques.
	 *
	 * @param array<string, int> $page_ids Top-level page IDs keyed by slug.
	 */
	private static function create_navigation_menu( $page_ids ) {
		$menu_name = 'Menu principal GbeCosmoLingua';
		$menu      = wp_get_nav_menu_object( $menu_name );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $menu_name );
		} else {
			$menu_id = $menu->term_id;
		}

		self::sync_primary_menu_items( $menu_id );

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	/**
	 * Synchronise le menu WP avec gbe_get_primary_menu_items().
	 *
	 * @param int $menu_id ID du menu.
	 */
	public static function sync_primary_menu_items( $menu_id ) {
		$menu_items = function_exists( 'gbe_get_primary_menu_items' )
			? gbe_get_primary_menu_items()
			: array();

		$desired_keys = array();
		$position     = 1;

		foreach ( $menu_items as $item ) {
			$type = $item['type'] ?? '';

			if ( 'page' === $type && ! empty( $item['path'] ) ) {
				$page = get_page_by_path( $item['path'], OBJECT, 'page' );
				if ( ! $page ) {
					continue;
				}

				$key = 'page:' . $item['path'];
				$desired_keys[] = $key;

				$existing_id = self::get_menu_item_id_for_page( $menu_id, (int) $page->ID );
				wp_update_nav_menu_item(
					$menu_id,
					$existing_id ? $existing_id : 0,
					array(
						'menu-item-title'     => $page->post_title,
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $page->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $position,
					)
				);
				++$position;
				continue;
			}

			if ( 'url' !== $type || empty( $item['url'] ) || empty( $item['label'] ) ) {
				continue;
			}

			$slug           = ! empty( $item['slug'] ) ? $item['slug'] : md5( (string) $item['url'] );
			$key            = 'url:' . $slug;
			$desired_keys[] = $key;
			$url            = $item['url'];

			$existing_id = self::get_menu_item_id_for_custom_url( $menu_id, $url );
			wp_update_nav_menu_item(
				$menu_id,
				$existing_id ? $existing_id : 0,
				array(
					'menu-item-title'  => $item['label'],
					'menu-item-url'    => $url,
					'menu-item-type'   => 'custom',
					'menu-item-status' => 'publish',
					'menu-item-position' => $position,
				)
			);
			++$position;
		}

		self::remove_obsolete_primary_menu_items( $menu_id, $desired_keys );
	}

	/**
	 * Retire du menu les entrées de premier niveau qui ne sont plus souhaitées.
	 *
	 * @param int      $menu_id      ID menu.
	 * @param string[] $desired_keys Clés attendues (page:path ou url:slug).
	 */
	private static function remove_obsolete_primary_menu_items( $menu_id, $desired_keys ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( ! $items ) {
			return;
		}

		$desired_keys = array_flip( $desired_keys );

		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent > 0 ) {
				continue;
			}

			$key = '';
			if ( 'post_type' === $item->type && 'page' === $item->object ) {
				$page = get_post( (int) $item->object_id );
				if ( $page instanceof WP_Post ) {
					$path = self::get_page_full_path( $page );
					$key  = 'page:' . $path;
				}
			} elseif ( 'custom' === $item->type ) {
				$key = 'url:' . md5( (string) $item->url );
				foreach ( gbe_get_primary_menu_items() as $menu_item ) {
					if ( 'url' !== ( $menu_item['type'] ?? '' ) || empty( $menu_item['url'] ) ) {
						continue;
					}
					if ( untrailingslashit( (string) $menu_item['url'] ) === untrailingslashit( (string) $item->url ) ) {
						$key = 'url:' . ( ! empty( $menu_item['slug'] ) ? $menu_item['slug'] : md5( (string) $menu_item['url'] ) );
						break;
					}
				}
			}

			if ( '' === $key || ! isset( $desired_keys[ $key ] ) ) {
				wp_delete_post( $item->ID, true );
			}
		}
	}

	/**
	 * ID d'un item custom par URL.
	 *
	 * @param int    $menu_id ID menu.
	 * @param string $url     URL.
	 */
	private static function get_menu_item_id_for_custom_url( $menu_id, $url ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( ! $items ) {
			return 0;
		}

		$url = untrailingslashit( $url );
		foreach ( $items as $item ) {
			if ( 'custom' === $item->type && untrailingslashit( (string) $item->url ) === $url ) {
				return (int) $item->ID;
			}
		}

		return 0;
	}

	/**
	 * Check if a page is already in the menu.
	 */
	private static function menu_item_exists( $menu_id, $page_id ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( ! $items ) {
			return false;
		}
		foreach ( $items as $item ) {
			if ( (int) $item->object_id === (int) $page_id ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get nav menu item ID for a page.
	 */
	private static function get_menu_item_id_for_page( $menu_id, $page_id ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( ! $items ) {
			return 0;
		}
		foreach ( $items as $item ) {
			if ( (int) $item->object_id === (int) $page_id ) {
				return (int) $item->ID;
			}
		}
		return 0;
	}

	/**
	 * Activate child theme if available.
	 */
	private static function activate_theme_and_plugin() {
		$theme = 'gbecosmolingua';
		if ( wp_get_theme( $theme )->exists() ) {
			switch_theme( $theme );
		}
	}

	/**
	 * Patch existing pages with phase 4 shortcodes.
	 */
	public static function patch_phase4_shortcodes() {
		$patches = array(
			'le-gbe/carte-interactive'       => '<p>Explorez la répartition géographique des langues gbe, les zones culturelles, les routes migratoires historiques et les centres patrimoniaux.</p>[gbe_carte_interactive]',
			'paremiologie/banque-numerique-proverbes' => '<p>Pour chaque proverbe : texte original, transcription, traductions (français, espagnol, anglais, russe), contexte d\'emploi, commentaire culturel, analyses linguistique, pragmatique et ethnographique.</p>[gbe_proverbes_list limit="24"]',
			'xotutu/bibliotheque-numerique-xotutu'    => '<p>Archives audio, vidéo, témoignages, manuscrits et corpus numériques de la tradition orale gbe.</p>[gbe_xotutu_list limit="24"]',
			'recherche-et-formation/ressources-documentaires' => '<p>Bibliothèque numérique, base documentaire, corpus linguistiques, archives scientifiques et base de données paremiologiques.</p>[gbe_bibliotheque]',
		);

		foreach ( $patches as $path => $content ) {
			$page = get_page_by_path( $path );
			if ( $page && false === strpos( $page->post_content, '[gbe_' ) ) {
				wp_update_post(
					array(
						'ID'           => $page->ID,
						'post_content' => $content,
					)
				);
			}
		}
	}

	/**
	 * Patch Nous Soutenir pages with contact forms.
	 */
	public static function patch_phase5_forms() {
		$patches = array(
			'nous-soutenir/devenir-partenaire'  => '[gbe_formulaire type="partenaire"]',
			'nous-soutenir/devenir-mecene'      => '[gbe_formulaire type="mecene"]',
			'nous-soutenir/proposer-un-projet'  => '[gbe_formulaire type="projet"]',
			'nous-soutenir/faire-un-don'        => '[gbe_formulaire type="don"]',
			'nous-soutenir/accueillir-un-stagiaire' => '[gbe_formulaire type="stagiaire"]',
		);

		foreach ( $patches as $path => $content ) {
			$page = get_page_by_path( $path );
			if ( $page && false === strpos( $page->post_content, '[gbe_formulaire' ) ) {
				wp_update_post(
					array(
						'ID'           => $page->ID,
						'post_content' => $content,
					)
				);
			}
		}
	}

	/**
	 * Remove submenu items from primary navigation (header cleanup).
	 */
	public static function simplify_primary_menu() {
		$menu = wp_get_nav_menu_object( 'Menu principal GbeCosmoLingua' );
		if ( ! $menu ) {
			return;
		}

		$items = wp_get_nav_menu_items( $menu->term_id );
		if ( ! $items ) {
			return;
		}

		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent > 0 ) {
				wp_delete_post( $item->ID, true );
			}
		}
	}

	/**
	 * Re-add missing top-level rubriques to the primary menu.
	 */
	public static function restore_primary_menu() {
		self::create_navigation_menu( array() );
		self::simplify_primary_menu();
		self::deduplicate_primary_menu();
		self::fix_fse_navigation_posts();
		self::refresh_fse_navigation_posts();
		self::deduplicate_imported_pages();
		self::remove_obsolete_pages();
		self::configure_permalinks();
	}

	/**
	 * Collect canonical page paths from the import tree.
	 *
	 * @param array<int, array<string, mixed>> $pages       Page tree.
	 * @param string                           $parent_path Parent path prefix.
	 * @return string[]
	 */
	public static function collect_canonical_paths( $pages, $parent_path = '' ) {
		$paths = array( 'accueil' );

		foreach ( $pages as $page ) {
			$path = $parent_path ? $parent_path . '/' . $page['slug'] : $page['slug'];
			$paths[] = $path;

			if ( ! empty( $page['children'] ) ) {
				$paths = array_merge( $paths, self::collect_canonical_paths( $page['children'], $path ) );
			}
		}

		return $paths;
	}

	/**
	 * Get the hierarchical URI for a page (e.g. le-gbe/carte-interactive).
	 *
	 * @param WP_Post $page Page object.
	 * @return string
	 */
	public static function get_page_full_path( $page ) {
		$uri = get_page_uri( $page );
		return is_string( $uri ) ? trim( $uri, '/' ) : '';
	}

	/**
	 * Remove duplicate imported pages and WordPress auto-suffixed copies (-2, -3).
	 *
	 * @return int Number of pages removed.
	 */
	public static function deduplicate_imported_pages() {
		$canonical_paths = self::collect_canonical_paths( gbe_get_pages_data() );
		$removed         = 0;
		$keeper_ids      = array();
		$canonical_slugs = array();

		foreach ( $canonical_paths as $path ) {
			$canonical_slugs[] = basename( $path );
			$keeper            = get_page_by_path( $path, OBJECT, 'page' );
			if ( $keeper ) {
				$keeper_ids[ (int) $keeper->ID ] = $path;
			}
		}

		$canonical_slugs = array_unique( $canonical_slugs );

		$all_pages = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => -1,
				'orderby'        => 'ID',
				'order'          => 'ASC',
			)
		);

		$seen_paths = array();

		foreach ( $all_pages as $page ) {
			$full_path = self::get_page_full_path( $page );
			$is_suffix = (bool) preg_match( '/-\d+$/', $page->post_name );

			if ( in_array( $full_path, $canonical_paths, true ) ) {
				if ( isset( $seen_paths[ $full_path ] ) ) {
					wp_delete_post( $page->ID, true );
					++$removed;
					continue;
				}

				$seen_paths[ $full_path ] = (int) $page->ID;

				if ( isset( $keeper_ids[ (int) $page->ID ] ) ) {
					continue;
				}

				$expected = get_page_by_path( $full_path, OBJECT, 'page' );
				if ( $expected && (int) $expected->ID !== (int) $page->ID ) {
					wp_delete_post( $page->ID, true );
					++$removed;
				}
				continue;
			}

			$should_remove = false;

			if ( $is_suffix ) {
				$base_path = $full_path ? preg_replace( '/-\d+$/', '', $full_path ) : preg_replace( '/-\d+$/', '', $page->post_name );

				if ( in_array( $base_path, $canonical_paths, true ) || self::path_starts_with_canonical( $base_path, $canonical_paths ) ) {
					$should_remove = true;
				}
			}

			if ( ! $should_remove && in_array( $page->post_name, $canonical_slugs, true ) ) {
				foreach ( $canonical_paths as $canonical_path ) {
					if ( basename( $canonical_path ) !== $page->post_name ) {
						continue;
					}

					if ( get_page_by_path( $canonical_path, OBJECT, 'page' ) ) {
						$should_remove = true;
						break;
					}
				}
			}

			if ( $should_remove ) {
				wp_delete_post( $page->ID, true );
				++$removed;
			}
		}

		clean_post_cache( 0 );

		return $removed;
	}

	/**
	 * Trash legacy pages replaced by the new information architecture.
	 *
	 * @return int Number of pages removed.
	 */
	public static function remove_obsolete_pages() {
		$obsolete = array(
			'recherche-et-formation',
			'sport-et-interculturalite',
			'le-gbe/une-langue-plusieurs-varietes',
			'le-gbe/histoire-et-origine',
			'le-gbe/ressources-linguistiques',
			'nous-soutenir/accueillir-un-stagiaire',
			'xotutu/genres-litterature-orale-ewe',
			'xotutu/tambours-parlants',
			'cultures-gbe/comprendre-la-culture',
			'cultures-gbe/litterature',
			'cultures-gbe/musique-et-danse',
			'cultures-gbe/architecture-et-habitat',
			'cultures-gbe/sciences-et-savoirs-endogenes',
			'cultures-gbe/spiritualites-et-croyances',
			'partenaires/institutions-diplomatiques',
			'partenaires/institutions-culturelles',
			'partenaires/institutions-academiques',
			'partenaires/organisations-internationales',
			'partenaires/reseaux-pedagogiques',
			'sejours-et-mobilite/sejours-linguistiques',
			'sejours-et-mobilite/immersion-culturelle',
			'sejours-et-mobilite/mobilite-academique',
			'sejours-et-mobilite/tourisme-culturel-responsable',
			'sport-et-interculturalite/football-et-interculturalite',
			'sport-et-interculturalite/partenariats-sportifs',
			'sport-et-interculturalite/valeurs-sport',
		);

		$removed = 0;
		foreach ( $obsolete as $path ) {
			$page = get_page_by_path( $path, OBJECT, 'page' );
			if ( $page ) {
				wp_delete_post( $page->ID, true );
				++$removed;
			}
		}

		return $removed;
	}

	/**
	 * Crée les sous-pages Cultures Gbe (thèmes du hub).
	 *
	 * @return int Nombre de pages créées.
	 */
	public static function patch_culture_subpages() {
		$parent = get_page_by_path( 'cultures-gbe', OBJECT, 'page' );
		if ( ! $parent ) {
			return 0;
		}

		$created = 0;
		foreach ( gbe_get_cultures_gbe_children() as $rubrique ) {
			$parent_path = 'cultures-gbe/' . $rubrique['slug'];
			$rubrique_page = get_page_by_path( $parent_path, OBJECT, 'page' );
			if ( ! $rubrique_page ) {
				continue;
			}

			wp_update_post(
				array(
					'ID'           => (int) $rubrique_page->ID,
					'post_content' => $rubrique['content'] ?? '',
				)
			);

			if ( empty( $rubrique['children'] ) ) {
				continue;
			}

			foreach ( $rubrique['children'] as $sub ) {
				$result   = self::create_page_tree( $sub, (int) $rubrique_page->ID, $parent_path, true );
				$created += $result['created'];
			}
		}

		return $created;
	}

	/**
	 * Crée les sous-pages Recherche et Innovation.
	 *
	 * @return int Nombre de pages créées.
	 */
	public static function patch_recherche_innovation_subpages() {
		$parent = get_page_by_path( 'recherche-et-innovation', OBJECT, 'page' );
		if ( ! $parent ) {
			return 0;
		}

		$created = 0;
		foreach ( gbe_get_recherche_innovation_children() as $rubrique ) {
			$parent_path   = 'recherche-et-innovation/' . $rubrique['slug'];
			$rubrique_page = get_page_by_path( $parent_path, OBJECT, 'page' );
			if ( ! $rubrique_page ) {
				continue;
			}

			wp_update_post(
				array(
					'ID'           => (int) $rubrique_page->ID,
					'post_content' => $rubrique['content'] ?? '',
				)
			);

			if ( empty( $rubrique['children'] ) ) {
				continue;
			}

			foreach ( $rubrique['children'] as $sub ) {
				$result   = self::create_page_tree( $sub, (int) $rubrique_page->ID, $parent_path, true );
				$created += $result['created'];
			}
		}

		return $created;
	}

	/**
	 * Sous-pages Séjours et Partenaires.
	 *
	 * @return int
	 */
	public static function patch_site_hubs_subpages() {
		$created = 0;
		$trees   = array(
			array( 'sejours-et-mobilite', 'gbe_get_sejours_mobilite_children' ),
			array( 'partenaires', 'gbe_get_partenaires_children' ),
		);
		foreach ( $trees as $tree ) {
			$parent = get_page_by_path( $tree[0], OBJECT, 'page' );
			if ( ! $parent || ! function_exists( $tree[1] ) ) {
				continue;
			}
			foreach ( call_user_func( $tree[1] ) as $rubrique ) {
				$parent_path   = $tree[0] . '/' . $rubrique['slug'];
				$rubrique_page = get_page_by_path( $parent_path, OBJECT, 'page' );
				if ( ! $rubrique_page ) {
					continue;
				}
				wp_update_post(
					array(
						'ID'           => (int) $rubrique_page->ID,
						'post_content' => $rubrique['content'] ?? '',
					)
				);
				if ( empty( $rubrique['children'] ) ) {
					continue;
				}
				foreach ( $rubrique['children'] as $sub ) {
					$result   = self::create_page_tree( $sub, (int) $rubrique_page->ID, $parent_path, true );
					$created += $result['created'];
				}
			}
		}
		return $created;
	}

	/**
	 * Crée ou met à jour les sous-pages Onomastique (Xótùtù).
	 *
	 * @return int Nombre de pages créées.
	 */
	public static function patch_onomastique_subpages() {
		$parent = get_page_by_path( 'xotutu/onomastique', OBJECT, 'page' );
		if ( ! $parent ) {
			return 0;
		}

		wp_update_post(
			array(
				'ID'           => (int) $parent->ID,
				'post_content' => gbe_xotutu_onomastique_hub_content(),
			)
		);

		$created = 0;
		foreach ( gbe_get_onomastique_pages() as $rubrique ) {
			$parent_path   = 'xotutu/onomastique/' . $rubrique['slug'];
			$rubrique_page = get_page_by_path( $parent_path, OBJECT, 'page' );
			if ( ! $rubrique_page ) {
				$result   = self::create_page_tree( $rubrique, (int) $parent->ID, 'xotutu/onomastique', true );
				$created += $result['created'];
				continue;
			}

			wp_update_post(
				array(
					'ID'           => (int) $rubrique_page->ID,
					'post_content' => $rubrique['content'] ?? '',
				)
			);

			if ( empty( $rubrique['children'] ) ) {
				continue;
			}

			foreach ( $rubrique['children'] as $sub ) {
				$result   = self::create_page_tree( $sub, (int) $rubrique_page->ID, $parent_path, true );
				$created += $result['created'];
			}
		}

		return $created;
	}

	/**
	 * Crée ou met à jour les sous-pages Linguistique (Gbe).
	 *
	 * @return int Nombre de pages créées.
	 */
	public static function patch_linguistique_subpages() {
		$parent = get_page_by_path( 'le-gbe/linguistique', OBJECT, 'page' );
		if ( ! $parent ) {
			return 0;
		}

		wp_update_post(
			array(
				'ID'           => (int) $parent->ID,
				'post_content' => gbe_intro( 'Ressources linguistiques pour l\'étude scientifique des variétés gbe : alphabet, phonologie, morphologie, syntaxe, lexicologie, dialectologie, corpus et bibliothèque.' ),
			)
		);

		$created = 0;
		foreach ( gbe_get_linguistique_pages() as $page_def ) {
			$result   = self::create_page_tree( $page_def, (int) $parent->ID, 'le-gbe/linguistique', true );
			$created += $result['created'];
		}

		return $created;
	}

	/**
	 * Crée les sous-pages Paremiologie (corpus, comparaisons, axes).
	 *
	 * @return int Nombre de pages créées.
	 */
	public static function patch_paremiologie_subpages() {
		$parent = get_page_by_path( 'paremiologie', OBJECT, 'page' );
		if ( ! $parent ) {
			return 0;
		}

		$created = 0;
		foreach ( gbe_get_paremiologie_children() as $rubrique ) {
			$parent_path   = 'paremiologie/' . $rubrique['slug'];
			$rubrique_page = get_page_by_path( $parent_path, OBJECT, 'page' );
			if ( ! $rubrique_page ) {
				continue;
			}

			wp_update_post(
				array(
					'ID'           => (int) $rubrique_page->ID,
					'post_content' => $rubrique['content'] ?? '',
				)
			);

			if ( empty( $rubrique['children'] ) ) {
				continue;
			}

			foreach ( $rubrique['children'] as $sub ) {
				$result   = self::create_page_tree( $sub, (int) $rubrique_page->ID, $parent_path, true );
				$created += $result['created'];
			}
		}

		return $created;
	}

	/**
	 * Crée les sous-pages Gbe (thèmes du hub).
	 *
	 * @return int Nombre de pages créées.
	 */
	public static function patch_le_gbe_subpages() {
		$parent = get_page_by_path( 'le-gbe', OBJECT, 'page' );
		if ( ! $parent ) {
			return 0;
		}

		wp_update_post(
			array(
				'ID'           => (int) $parent->ID,
				'post_content' => gbe_le_gbe_hub_content(),
			)
		);

		$created = 0;
		foreach ( gbe_get_le_gbe_children() as $rubrique ) {
			$parent_path   = 'le-gbe/' . $rubrique['slug'];
			$rubrique_page = get_page_by_path( $parent_path, OBJECT, 'page' );
			if ( ! $rubrique_page ) {
				continue;
			}

			wp_update_post(
				array(
					'ID'           => (int) $rubrique_page->ID,
					'post_content' => $rubrique['content'] ?? '',
				)
			);

			if ( empty( $rubrique['children'] ) ) {
				continue;
			}

			foreach ( $rubrique['children'] as $sub ) {
				$result   = self::create_page_tree( $sub, (int) $rubrique_page->ID, $parent_path, true );
				$created += $result['created'];
			}
		}

		return $created;
	}

	/**
	 * Patch pages with phase 7 shortcodes and renamed paths.
	 */
	public static function patch_phase7_content() {
		$langue_patches = array();
		if ( function_exists( 'gbe_le_gbe_langue_chapter_callbacks' ) ) {
			foreach ( gbe_le_gbe_langue_chapter_callbacks() as $path => $callback ) {
				if ( is_callable( $callback ) ) {
					$langue_patches[ $path ] = (string) call_user_func( $callback );
				}
			}
		}

		$linguistique_patches = array();
		if ( function_exists( 'gbe_le_gbe_linguistique_chapter_callbacks' ) ) {
			foreach ( gbe_le_gbe_linguistique_chapter_callbacks() as $path => $callback ) {
				if ( is_callable( $callback ) ) {
					$linguistique_patches[ $path ] = (string) call_user_func( $callback );
				}
			}
		}

		$patches = array_merge(
			array(
			'le-gbe'                                             => gbe_le_gbe_hub_content(),
			'le-gbe/presentation-generale'                       => gbe_le_gbe_presentation_generale_content(),
			'le-gbe/peuples-du-continuum'                        => gbe_le_gbe_peuples_content(),
			'le-gbe/le-continuum-gbe'                            => gbe_le_gbe_continuum_content(),
			'le-gbe/le-continuum-gbe/inventaire-des-parlers'     => gbe_le_gbe_inventaire_parlers_content(),
			'le-gbe/le-continuum-gbe/regroupement-des-parlers'   => gbe_le_gbe_regroupement_parlers_content(),
			'le-gbe/le-continuum-gbe/langue-unique'              => gbe_le_gbe_langue_unique_content(),
			'le-gbe/le-continuum-gbe/varietes-principales'       => gbe_le_gbe_varietes_principales_content(),
			'le-gbe/le-continuum-gbe/pays-et-territoires'        => gbe_le_gbe_pays_territoires_content(),
			'le-gbe/le-continuum-gbe/pays-et-territoires/ghana'  => gbe_le_gbe_pays_ghana_content(),
			'le-gbe/le-continuum-gbe/pays-et-territoires/togo'   => gbe_le_gbe_pays_togo_content(),
			'le-gbe/le-continuum-gbe/pays-et-territoires/benin'  => gbe_le_gbe_pays_benin_content(),
			'le-gbe/le-continuum-gbe/pays-et-territoires/nigeria' => gbe_le_gbe_pays_nigeria_content(),
			'le-gbe/les-langues'                                 => gbe_le_gbe_langues_content(),
			'le-gbe/linguistique'                                => gbe_le_gbe_linguistique_hub_content(),
			'le-gbe/carte-interactive'                           => gbe_le_gbe_carte_content(),
			'le-gbe/bibliotheque-linguistique'                 => '<p>Bibliothèque numérique des langues et patrimoines gbe.</p>[gbe_bibliotheque]',
			'paremiologie/banque-numerique-proverbes'          => '<p>Pour chaque proverbe : texte original, transcription, traductions, contexte, commentaire culturel et analyses.</p>[gbe_proverbes_list limit="24"]',
			'paremiologie'                                     => gbe_le_gbe_paremiologie_hub_content(),
			'xotutu'                                           => gbe_le_gbe_xotutu_hub_content(),
			'xotutu/onomastique'                               => gbe_xotutu_onomastique_hub_content(),
			'cultures-gbe'                                     => gbe_cultures_gbe_hub_content(),
			'xotutu/archives-numeriques/bibliotheque-numerique-xotutu' => '<p>Archives audio, vidéo, témoignages, manuscrits et corpus numériques de la tradition orale gbe.</p>[gbe_xotutu_list limit="24"]',
			'recherche-et-innovation/ressources-documentaires' => '<p>Bibliothèque numérique, corpus linguistiques et archives scientifiques.</p>[gbe_bibliotheque]',
			'recherche-et-innovation/activites'                => '<p>Colloques, conférences, séminaires et publications de GbeCosmoLingua.</p>[gbe_evenements_list limit="24"]',
			'partenaires'                                      => '<p>Réseau international de coopération académique, culturelle et institutionnelle.</p>[gbe_partenaires_list limit="48"]',
			'nous-soutenir/devenir-partenaire'                 => '[gbe_formulaire type="partenaire"]',
			'nous-soutenir/devenir-mecene'                     => '[gbe_formulaire type="mecene"]',
			'nous-soutenir/proposer-un-projet'                 => '[gbe_formulaire type="projet"]',
			'nous-soutenir/faire-un-don'                       => '[gbe_formulaire type="don"]',
			'nous-soutenir/accueillir-un-chercheur'            => '[gbe_formulaire type="stagiaire"]',
			'nous-soutenir/adherer'                            => '<p>Rejoignez la communauté GbeCosmoLingua en tant que membre associé.</p>[gbe_formulaire type="partenaire"]',
			),
			$langue_patches,
			$linguistique_patches
		);

		foreach ( $patches as $path => $content ) {
			$page = get_page_by_path( $path, OBJECT, 'page' );
			if ( $page ) {
				wp_update_post(
					array(
						'ID'           => $page->ID,
						'post_content' => $content,
					)
				);
			}
		}

		self::patch_le_gbe_chapter_templates();
		self::patch_gbe_naming();
		self::patch_home_hero();
	}

	/**
	 * Met à jour le bandeau accueil (titre + chapô centrés sur Gbe).
	 */
	public static function patch_home_hero() {
		if ( ! class_exists( 'GBE_Home_Composer_Admin' ) ) {
			return;
		}

		$home = GBE_Home_Composer_Admin::get_home_page();
		if ( ! $home instanceof WP_Post ) {
			return;
		}

		$defaults = GBE_Home_Composer_Admin::default_layout();
		$layout   = get_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, true );

		if ( ! is_array( $layout ) || empty( $layout ) ) {
			update_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, $defaults );
			return;
		}

		if ( ! isset( $layout['hero'] ) || ! is_array( $layout['hero'] ) ) {
			$layout['hero'] = $defaults['hero'];
		} else {
			$layout['hero']['title'] = $defaults['hero']['title'];
			$layout['hero']['lead']  = $defaults['hero']['lead'];
		}

		update_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, $layout );
	}

	/**
	 * Crée ou met à jour la fiche auteur H. B. C. Capo.
	 */
	public static function patch_capo_auteur_page() {
		if ( ! function_exists( 'gbe_le_gbe_capo_auteur_content' ) ) {
			require_once GBE_CORE_PATH . 'includes/content/le-gbe-capo-auteur.php';
		}

		$parent = get_page_by_path( 'le-gbe/linguistique', OBJECT, 'page' );
		if ( ! $parent instanceof WP_Post ) {
			return;
		}

		$path    = 'le-gbe/linguistique/hounkpati-b-c-capo';
		$content = gbe_le_gbe_capo_auteur_content();
		$page    = get_page_by_path( $path, OBJECT, 'page' );

		if ( $page instanceof WP_Post ) {
			wp_update_post(
				array(
					'ID'           => $page->ID,
					'post_title'   => 'Hounkpati B. Christophe Capo',
					'post_content' => $content,
				)
			);
			update_post_meta( $page->ID, '_wp_page_template', 'page-le-gbe-chapter' );
			return;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => 'Hounkpati B. Christophe Capo',
				'post_name'    => 'hounkpati-b-c-capo',
				'post_content' => $content,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_parent'  => (int) $parent->ID,
			)
		);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( (int) $page_id, '_wp_page_template', 'page-le-gbe-chapter' );
		}
	}

	/**
	 * Met à jour la page Notre philosophie avec l'objet et les missions statutaires.
	 */
	public static function patch_mission_statuts() {
		if ( ! function_exists( 'gbe_philosophie_page_content' ) ) {
			require_once GBE_CORE_PATH . 'includes/content/gbe-mission-statuts.php';
		}

		$page = get_page_by_path( 'notre-philosophie', OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			return;
		}

		$content = gbe_philosophie_page_content();
		if ( trim( wp_strip_all_tags( $page->post_content ) ) === trim( wp_strip_all_tags( $content ) ) ) {
			return;
		}

		wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_content' => $content,
			)
		);

		if ( class_exists( 'GBE_Home_Composer_Admin' ) ) {
			$home = GBE_Home_Composer_Admin::get_home_page();
			if ( $home instanceof WP_Post ) {
				$layout = get_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, true );
				if ( is_array( $layout ) && ! empty( $layout['hero']['buttons'] ) && is_array( $layout['hero']['buttons'] ) ) {
					$changed = false;
					foreach ( $layout['hero']['buttons'] as $index => $button ) {
						if ( ! is_array( $button ) ) {
							continue;
						}
						$text = isset( $button['text'] ) ? (string) $button['text'] : '';
						if ( str_contains( mb_strtolower( $text ), 'mission' ) ) {
							$layout['hero']['buttons'][ $index ]['url'] = '/notre-philosophie/#missions';
							$changed                                   = true;
						}
					}
					if ( $changed ) {
						update_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, $layout );
					}
				}
			}
		}
	}

	/**
	 * Seed founding members and add shortcode to Notre philosophie.
	 */
	public static function patch_membres_fondateurs() {
		if ( class_exists( 'GBE_Demo_Content' ) ) {
			GBE_Demo_Content::seed_membres_fondateurs();
		}

		if ( class_exists( 'GBE_Membres_Photos' ) ) {
			GBE_Membres_Photos::sync_fondateurs_photos();
		}

		$page = get_page_by_path( 'notre-philosophie', OBJECT, 'page' );
		if ( ! $page instanceof WP_Post ) {
			return;
		}

		if ( str_contains( $page->post_content, '[gbe_membres_fondateurs' ) ) {
			return;
		}

		$content = trim( $page->post_content ) . "\n[gbe_membres_fondateurs]";

		wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_content' => $content,
			)
		);
	}

	/**
	 * Corrige les libellés « Le Gbe » / « le Gbe » en « Gbe » dans la base.
	 */
	public static function patch_gbe_naming() {
		global $wpdb;

		if ( class_exists( 'GBE_Home_Composer_Admin' ) ) {
			$home = GBE_Home_Composer_Admin::get_home_page();
			if ( $home instanceof WP_Post ) {
				$layout = get_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, true );
				if ( is_array( $layout ) && ! empty( $layout ) ) {
					$normalized = gbe_normalize_gbe_wording_deep( $layout );
					if ( $normalized !== $layout ) {
						update_post_meta( $home->ID, GBE_Home_Composer_Admin::META_LAYOUT, $normalized );
					}
				}
			}
		}

		$hub = get_page_by_path( 'le-gbe', OBJECT, 'page' );
		if ( $hub instanceof WP_Post && class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
			foreach ( array( GBE_Le_Gbe_Hub_Admin::META_PAGE_LAYOUT, GBE_Le_Gbe_Hub_Admin::META_PAGE_LAYOUT_LEGACY, GBE_Le_Gbe_Hub_Admin::META_HERO_LEAD, GBE_Le_Gbe_Hub_Admin::META_HERO_SLIDES, GBE_Le_Gbe_Hub_Admin::META_PAGE_BANDS, GBE_Le_Gbe_Hub_Admin::META_PAGE_SUBCARDS ) as $meta_key ) {
				$value = get_post_meta( $hub->ID, $meta_key, true );
				if ( empty( $value ) ) {
					continue;
				}
				$normalized = gbe_normalize_gbe_wording_deep( $value );
				if ( $normalized !== $value ) {
					update_post_meta( $hub->ID, $meta_key, $normalized );
				}
			}
		}

		$page_ids = $wpdb->get_col(
			"SELECT ID FROM {$wpdb->posts}
			WHERE post_type IN ('page', 'nav_menu_item')
			AND post_status != 'trash'
			AND (
				post_title LIKE '%Le Gbe%'
				OR post_title LIKE '%le Gbe%'
				OR post_content LIKE '%Le Gbe%'
				OR post_content LIKE '%le Gbe%'
				OR post_content LIKE '%du Gbe%'
			)"
		);

		foreach ( $page_ids as $page_id ) {
			$post = get_post( (int) $page_id );
			if ( ! $post instanceof WP_Post ) {
				continue;
			}

			$update = array( 'ID' => (int) $post->ID );
			$dirty  = false;

			$new_title = gbe_normalize_gbe_wording( $post->post_title );
			if ( $new_title !== $post->post_title ) {
				$update['post_title'] = $new_title;
				$dirty                = true;
			}

			$new_content = gbe_normalize_gbe_wording( $post->post_content );
			if ( $new_content !== $post->post_content ) {
				$update['post_content'] = $new_content;
				$dirty                  = true;
			}

			if ( $dirty ) {
				wp_update_post( $update );
			}
		}
	}

	/**
	 * Assigne le modèle « chapitre » aux pages linguistique enrichies.
	 */
	public static function patch_le_gbe_chapter_templates() {
		if ( ! function_exists( 'gbecosmolingua_le_gbe_chapter_paths' ) ) {
			return;
		}

		foreach ( gbecosmolingua_le_gbe_chapter_paths() as $path ) {
			$page = get_page_by_path( $path, OBJECT, 'page' );
			if ( $page instanceof WP_Post ) {
				update_post_meta( $page->ID, '_wp_page_template', 'page-le-gbe-chapter' );
			}
		}
	}

	/**
	 * Whether a path matches or nests under a canonical import path.
	 *
	 * @param string   $path            Candidate path.
	 * @param string[] $canonical_paths Canonical paths.
	 */
	private static function path_starts_with_canonical( $path, $canonical_paths ) {
		foreach ( $canonical_paths as $canonical ) {
			if ( $path === $canonical || 0 === strpos( $path, $canonical . '-' ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Remove duplicate items from the classic primary menu.
	 */
	public static function deduplicate_primary_menu() {
		$menu = wp_get_nav_menu_object( 'Menu principal GbeCosmoLingua' );
		if ( ! $menu ) {
			return;
		}

		$items = wp_get_nav_menu_items( $menu->term_id );
		if ( ! $items ) {
			return;
		}

		$seen = array();
		foreach ( $items as $item ) {
			$key = (int) $item->object_id . ':' . (int) $item->menu_item_parent;
			if ( isset( $seen[ $key ] ) ) {
				wp_delete_post( $item->ID, true );
				continue;
			}
			$seen[ $key ] = true;
		}
	}

	/**
	 * Replace page-list navigations (auto submenus) with top-level links only.
	 */
	public static function fix_fse_navigation_posts() {
		$nav_posts = get_posts(
			array(
				'post_type'      => 'wp_navigation',
				'posts_per_page' => -1,
				'post_status'    => array( 'publish', 'draft' ),
			)
		);

		$content = self::get_top_level_navigation_block_content();

		foreach ( $nav_posts as $nav_post ) {
			if ( false !== strpos( $nav_post->post_content, 'page-list' ) ) {
				wp_update_post(
					array(
						'ID'           => $nav_post->ID,
						'post_content' => $content,
					)
				);
			}
		}
	}

	/**
	 * Block markup for a flat (no submenu) header navigation.
	 *
	 * @return string
	 */
	public static function get_top_level_navigation_block_content() {
		$menu_items = function_exists( 'gbe_get_primary_menu_items' )
			? gbe_get_primary_menu_items()
			: array();

		$blocks = array();
		foreach ( $menu_items as $item ) {
			$resolved = function_exists( 'gbe_resolve_primary_menu_item' )
				? gbe_resolve_primary_menu_item( $item )
				: null;
			if ( ! $resolved ) {
				continue;
			}

			$blocks[] = sprintf(
				'<!-- wp:navigation-link %s /-->',
				wp_json_encode(
					array(
						'label'          => $resolved['label'],
						'url'            => $resolved['url'],
						'kind'           => 'custom',
						'isTopLevelLink' => true,
					)
				)
			);
		}

		return implode( "\n", $blocks );
	}

	/**
	 * Met à jour toutes les navigations FSE avec le menu plat courant.
	 */
	public static function refresh_fse_navigation_posts() {
		$content = self::get_top_level_navigation_block_content();

		$nav_posts = get_posts(
			array(
				'post_type'      => 'wp_navigation',
				'posts_per_page' => -1,
				'post_status'    => array( 'publish', 'draft' ),
			)
		);

		foreach ( $nav_posts as $nav_post ) {
			if ( $nav_post->post_content === $content ) {
				continue;
			}

			wp_update_post(
				array(
					'ID'           => $nav_post->ID,
					'post_content' => $content,
				)
			);
		}
	}

	/**
	 * Restore header/footer template parts from theme files (removes DB customizations).
	 *
	 * @param string[] $slugs Template part slugs.
	 * @return string[] Reset slugs.
	 */
	public static function reset_theme_template_parts( $slugs = array( 'header', 'footer' ) ) {
		if ( ! function_exists( 'get_block_template' ) ) {
			return array();
		}

		$theme_slug = get_stylesheet();
		$reset      = array();

		foreach ( $slugs as $slug ) {
			$template_id = $theme_slug . '//' . $slug;
			$template    = get_block_template( $template_id, 'wp_template_part' );

			if ( ! $template || empty( $template->wp_id ) ) {
				continue;
			}

			if ( 'custom' === $template->source ) {
				wp_delete_post( (int) $template->wp_id, true );
				$reset[] = $slug;
			}
		}

		if ( ! empty( $reset ) && function_exists( 'wp_clean_theme_json_cache' ) ) {
			wp_clean_theme_json_cache();
		}

		return $reset;
	}

	/**
	 * Remove customized block templates so theme files are used again (e.g. front-page hero).
	 *
	 * @param string[] $slugs Template slugs without extension.
	 * @return string[] Reset slugs.
	 */
	public static function reset_theme_templates( $slugs = array( 'front-page' ) ) {
		if ( ! function_exists( 'get_block_template' ) ) {
			return array();
		}

		$theme_slug = get_stylesheet();
		$reset      = array();

		foreach ( $slugs as $slug ) {
			$template_id = $theme_slug . '//' . $slug;
			$template    = get_block_template( $template_id, 'wp_template' );

			if ( ! $template || empty( $template->wp_id ) ) {
				continue;
			}

			if ( 'custom' === $template->source ) {
				wp_delete_post( (int) $template->wp_id, true );
				$reset[] = $slug;
			}
		}

		if ( ! empty( $reset ) && function_exists( 'wp_clean_theme_json_cache' ) ) {
			wp_clean_theme_json_cache();
		}

		return $reset;
	}
}
