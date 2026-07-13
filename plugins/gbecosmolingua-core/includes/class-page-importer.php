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

		$position = 1;
		foreach ( $rubrique_slugs as $slug ) {
			$page = get_page_by_path( $slug );
			if ( ! $page ) {
				continue;
			}

			if ( ! self::menu_item_exists( $menu_id, $page->ID ) ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => $page->post_title,
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $page->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $position,
					)
				);
			}
			++$position;
		}

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
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
	 * Patch pages with phase 7 shortcodes and renamed paths.
	 */
	public static function patch_phase7_content() {
		$patches = array(
			'le-gbe/carte-interactive'                         => '<p>Explorez la répartition géographique des langues gbe, les zones culturelles, les routes migratoires historiques et les centres patrimoniaux.</p>[gbe_carte_interactive]',
			'le-gbe/bibliotheque-linguistique'                 => '<p>Bibliothèque numérique des langues et patrimoines gbe.</p>[gbe_bibliotheque]',
			'paremiologie/banque-numerique-proverbes'          => '<p>Pour chaque proverbe : texte original, transcription, traductions, contexte, commentaire culturel et analyses.</p>[gbe_proverbes_list limit="24"]',
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
		$links = array(
			array( 'Le Gbe', '/le-gbe/' ),
			array( 'Cultures Gbe', '/cultures-gbe/' ),
			array( 'Xótùtù', '/xotutu/' ),
			array( 'Paremiologie', '/paremiologie/' ),
			array( 'Recherche et Innovation', '/recherche-et-innovation/' ),
			array( 'Séjours et Mobilité', '/sejours-et-mobilite/' ),
			array( 'Sport et Jeunesse', '/sport-et-jeunesse/' ),
			array( 'Partenaires', '/partenaires/' ),
			array( 'Nous Soutenir', '/nous-soutenir/' ),
			array( 'Notre philosophie', '/notre-philosophie/' ),
		);

		$blocks = array();
		foreach ( $links as $link ) {
			$blocks[] = sprintf(
				'<!-- wp:navigation-link %s /-->',
				wp_json_encode(
					array(
						'label'          => $link[0],
						'url'            => $link[1],
						'kind'           => 'custom',
						'isTopLevelLink' => true,
					)
				)
			);
		}

		return implode( "\n", $blocks );
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
}
