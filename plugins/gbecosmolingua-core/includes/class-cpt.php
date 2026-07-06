<?php
/**
 * Custom Post Types for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers all custom post types and taxonomies.
 */
class GBE_CPT {

	/**
	 * Register hooks.
	 */
	public static function register() {
		add_action( 'init', array( __CLASS__, 'register_post_types' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ) );
	}

	/**
	 * Register custom post types.
	 */
	public static function register_post_types() {
		register_post_type(
			'proverbe',
			array(
				'labels'              => array(
					'name'               => __( 'Proverbes', 'gbecosmolingua-core' ),
					'singular_name'      => __( 'Proverbe', 'gbecosmolingua-core' ),
					'add_new'            => __( 'Ajouter un proverbe', 'gbecosmolingua-core' ),
					'add_new_item'       => __( 'Ajouter un nouveau proverbe', 'gbecosmolingua-core' ),
					'edit_item'          => __( 'Modifier le proverbe', 'gbecosmolingua-core' ),
					'search_items'       => __( 'Rechercher des proverbes', 'gbecosmolingua-core' ),
					'not_found'          => __( 'Aucun proverbe trouvé', 'gbecosmolingua-core' ),
					'menu_name'          => __( 'Proverbes', 'gbecosmolingua-core' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'proverbes' ),
				'menu_icon'           => 'dashicons-format-quote',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'show_in_rest'        => true,
			)
		);

		register_post_type(
			'genre_oral',
			array(
				'labels'              => array(
					'name'               => __( 'Genres oraux Xótùtù', 'gbecosmolingua-core' ),
					'singular_name'      => __( 'Genre oral', 'gbecosmolingua-core' ),
					'add_new'            => __( 'Ajouter un genre', 'gbecosmolingua-core' ),
					'add_new_item'       => __( 'Ajouter un genre oral', 'gbecosmolingua-core' ),
					'edit_item'          => __( 'Modifier le genre oral', 'gbecosmolingua-core' ),
					'search_items'       => __( 'Rechercher', 'gbecosmolingua-core' ),
					'menu_name'          => __( 'Xótùtù', 'gbecosmolingua-core' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'xotutu-archives' ),
				'menu_icon'           => 'dashicons-microphone',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'show_in_rest'        => true,
			)
		);

		register_post_type(
			'partenaire',
			array(
				'labels'              => array(
					'name'               => __( 'Partenaires', 'gbecosmolingua-core' ),
					'singular_name'      => __( 'Partenaire', 'gbecosmolingua-core' ),
					'add_new_item'       => __( 'Ajouter un partenaire', 'gbecosmolingua-core' ),
					'menu_name'          => __( 'Partenaires', 'gbecosmolingua-core' ),
				),
				'public'              => true,
				'has_archive'         => false,
				'rewrite'             => array( 'slug' => 'partenaire' ),
				'menu_icon'           => 'dashicons-groups',
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'show_in_rest'        => true,
			)
		);

		register_post_type(
			'evenement',
			array(
				'labels'              => array(
					'name'               => __( 'Événements', 'gbecosmolingua-core' ),
					'singular_name'      => __( 'Événement', 'gbecosmolingua-core' ),
					'add_new_item'       => __( 'Ajouter un événement', 'gbecosmolingua-core' ),
					'menu_name'          => __( 'Événements', 'gbecosmolingua-core' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'evenements' ),
				'menu_icon'           => 'dashicons-calendar-alt',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'show_in_rest'        => true,
			)
		);

		register_post_type(
			'ressource',
			array(
				'labels'              => array(
					'name'               => __( 'Ressources', 'gbecosmolingua-core' ),
					'singular_name'      => __( 'Ressource', 'gbecosmolingua-core' ),
					'add_new_item'       => __( 'Ajouter une ressource', 'gbecosmolingua-core' ),
					'menu_name'          => __( 'Ressources', 'gbecosmolingua-core' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'ressources' ),
				'menu_icon'           => 'dashicons-book-alt',
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'show_in_rest'        => true,
			)
		);
	}

	/**
	 * Register taxonomies.
	 */
	public static function register_taxonomies() {
		register_taxonomy(
			'langue_gbe',
			array( 'proverbe', 'genre_oral' ),
			array(
				'labels'            => array(
					'name'          => __( 'Langues gbe', 'gbecosmolingua-core' ),
					'singular_name' => __( 'Langue gbe', 'gbecosmolingua-core' ),
				),
				'public'            => true,
				'hierarchical'      => true,
				'rewrite'           => array( 'slug' => 'langue' ),
				'show_in_rest'      => true,
				'show_admin_column' => true,
			)
		);

		register_taxonomy(
			'genre_xotutu',
			array( 'genre_oral' ),
			array(
				'labels'            => array(
					'name'          => __( 'Genres Xótùtù', 'gbecosmolingua-core' ),
					'singular_name' => __( 'Genre Xótùtù', 'gbecosmolingua-core' ),
				),
				'public'            => true,
				'hierarchical'      => true,
				'rewrite'           => array( 'slug' => 'genre-xotutu' ),
				'show_in_rest'      => true,
				'show_admin_column' => true,
			)
		);

		register_taxonomy(
			'type_partenaire',
			array( 'partenaire' ),
			array(
				'labels'            => array(
					'name'          => __( 'Types de partenaire', 'gbecosmolingua-core' ),
					'singular_name' => __( 'Type de partenaire', 'gbecosmolingua-core' ),
				),
				'public'            => true,
				'hierarchical'      => true,
				'rewrite'           => array( 'slug' => 'type-partenaire' ),
				'show_in_rest'      => true,
				'show_admin_column' => true,
			)
		);

		self::insert_default_terms();
	}

	/**
	 * Insert default taxonomy terms on first run.
	 */
	private static function insert_default_terms() {
		if ( get_option( 'gbe_terms_inserted' ) ) {
			return;
		}

		$langues = array( 'Éwé', 'Gen (Mina)', 'Fon', 'Aja', 'Gun', 'Waci', 'Xwela', 'Xwla', 'Phla-Phera' );
		foreach ( $langues as $langue ) {
			if ( ! term_exists( $langue, 'langue_gbe' ) ) {
				wp_insert_term( $langue, 'langue_gbe' );
			}
		}

		$genres = array(
			'Lododowo',
			'Dzu lododowo',
			'Hake',
			'Halo hamelo',
			'Àlòbalo',
			'Nyàgblɔ̀ɖɛ',
			'Ègli',
			'Àdzò',
			'Xó',
			'Èdù',
			'ɖɛ̀wo',
			'Hàwo',
			'Tambours parlants',
		);
		foreach ( $genres as $genre ) {
			if ( ! term_exists( $genre, 'genre_xotutu' ) ) {
				wp_insert_term( $genre, 'genre_xotutu' );
			}
		}

		$types = array(
			'Institutions diplomatiques',
			'Institutions culturelles',
			'Institutions académiques',
			'Organisations internationales',
			'Réseaux pédagogiques',
		);
		foreach ( $types as $type ) {
			if ( ! term_exists( $type, 'type_partenaire' ) ) {
				wp_insert_term( $type, 'type_partenaire' );
			}
		}

		update_option( 'gbe_terms_inserted', true );
	}
}
