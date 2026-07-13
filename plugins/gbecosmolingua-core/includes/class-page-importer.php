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
			$result = self::create_page_tree( $page_data, 0 );
			$created += $result['created'];
			$skipped += $result['skipped'];
			if ( $result['id'] ) {
				$page_ids[ $page_data['slug'] ] = $result['id'];
			}
		}

		self::configure_reading_settings();
		self::create_navigation_menu( $page_ids );
		self::activate_theme_and_plugin();

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
	 * @param array<string, mixed> $data      Page data.
	 * @param int                  $parent_id Parent page ID.
	 * @return array{created: int, skipped: int, id: int}
	 */
	private static function create_page_tree( $data, $parent_id ) {
		$created = 0;
		$skipped = 0;

		$existing = get_page_by_path( $data['slug'], OBJECT, 'page' );
		if ( $existing ) {
			$page_id = $existing->ID;
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
				$child_result = self::create_page_tree( $child, $page_id );
				$created += $child_result['created'];
				$skipped += $child_result['skipped'];
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
			'recherche-et-formation',
			'sejours-et-mobilite',
			'sport-et-interculturalite',
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
