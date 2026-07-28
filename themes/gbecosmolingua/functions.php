<?php
/**
 * GbeCosmoLingua theme functions.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

define( 'GBECOSMOLINGUA_VERSION', '1.11.0' );

require_once get_stylesheet_directory() . '/includes/xotutu-hub.php';
require_once get_stylesheet_directory() . '/includes/paremiologie-hub.php';
require_once get_stylesheet_directory() . '/includes/recherche-innovation-hub.php';
require_once get_stylesheet_directory() . '/includes/hub-registry.php';

/**
 * Enqueue parent and child theme styles.
 */
function gbecosmolingua_enqueue_styles() {
	wp_enqueue_style(
		'twentytwentyfive-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
	);

	wp_enqueue_style(
		'gbecosmolingua-style',
		get_stylesheet_uri(),
		array( 'twentytwentyfive-style' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-custom',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		array( 'gbecosmolingua-style' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-culture-gbe',
		get_stylesheet_directory_uri() . '/assets/css/culture-gbe.css',
		array( 'gbecosmolingua-custom' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-xotutu-hub',
		get_stylesheet_directory_uri() . '/assets/css/xotutu-hub.css',
		array( 'gbecosmolingua-custom' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-paremiologie-hub',
		get_stylesheet_directory_uri() . '/assets/css/paremiologie-hub.css',
		array( 'gbecosmolingua-custom', 'gbecosmolingua-culture-gbe' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-recherche-hub',
		get_stylesheet_directory_uri() . '/assets/css/recherche-innovation-hub.css',
		array( 'gbecosmolingua-custom', 'gbecosmolingua-culture-gbe' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-site-hubs',
		get_stylesheet_directory_uri() . '/assets/css/site-hubs.css',
		array( 'gbecosmolingua-custom', 'gbecosmolingua-culture-gbe' ),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'gbecosmolingua_enqueue_styles' );

/**
 * Ajuste dynamiquement l'espace sous l'en-tête fixe.
 */
function gbecosmolingua_enqueue_header_offset_script() {
	wp_enqueue_script(
		'gbecosmolingua-header-offset',
		get_stylesheet_directory_uri() . '/assets/js/header-offset.js',
		array(),
		GBECOSMOLINGUA_VERSION,
		true
	);

	wp_enqueue_script(
		'gbecosmolingua-header-search',
		get_stylesheet_directory_uri() . '/assets/js/header-search-placeholder.js',
		array(),
		GBECOSMOLINGUA_VERSION,
		true
	);

	wp_enqueue_script(
		'gbecosmolingua-header-mobile',
		get_stylesheet_directory_uri() . '/assets/js/header-mobile.js',
		array(),
		GBECOSMOLINGUA_VERSION,
		true
	);

	wp_enqueue_script(
		'gbecosmolingua-home-stats',
		get_stylesheet_directory_uri() . '/assets/js/home-stats-counter.js',
		array(),
		GBECOSMOLINGUA_VERSION,
		true
	);

	if ( is_front_page() && ! file_exists( get_stylesheet_directory() . '/assets/images/home/map-preview.jpg' ) ) {
		wp_enqueue_style(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
			array(),
			'1.9.4'
		);
		wp_enqueue_script(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
			array(),
			'1.9.4',
			true
		);
		wp_enqueue_script(
			'gbecosmolingua-home-map',
			get_stylesheet_directory_uri() . '/assets/js/home-map-preview.js',
			array( 'leaflet' ),
			GBECOSMOLINGUA_VERSION,
			true
		);
	}

	wp_localize_script(
		'gbecosmolingua-header-search',
		'gbeHeaderSearch',
		array(
			'phrases' => array(
				__( 'Rechercher sur le site…', 'gbecosmolingua' ),
				__( 'Un proverbe gbe…', 'gbecosmolingua' ),
				__( 'Xótùtù, récits oraux…', 'gbecosmolingua' ),
				__( 'Langues et cultures…', 'gbecosmolingua' ),
				__( 'Partenaires, événements…', 'gbecosmolingua' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'gbecosmolingua_enqueue_header_offset_script' );

/**
 * Assigne le modèle « Hub Le Gbe » à la page le-gbe après mise à jour du thème.
 */
function gbecosmolingua_assign_le_gbe_page_template() {
	$flag = 'gbecosmolingua_le_gbe_template_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	$page = get_page_by_path( 'le-gbe' );
	if ( $page ) {
		update_post_meta( $page->ID, '_wp_page_template', 'page-le-gbe' );
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_le_gbe_page_template', 25 );

/**
 * Assigne le modèle hub à la page xotutu après mise à jour du thème.
 */
function gbecosmolingua_assign_xotutu_page_template() {
	$flag = 'gbecosmolingua_xotutu_template_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	$page = get_page_by_path( 'xotutu' );
	if ( $page ) {
		update_post_meta( $page->ID, '_wp_page_template', 'page-xotutu' );
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_xotutu_page_template', 25 );

/**
 * Assigne le modèle hub à la page paremiologie.
 */
function gbecosmolingua_assign_paremiologie_page_template() {
	$flag = 'gbecosmolingua_paremiologie_template_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	$page = get_page_by_path( 'paremiologie' );
	if ( $page ) {
		update_post_meta( $page->ID, '_wp_page_template', 'page-paremiologie' );
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_paremiologie_page_template', 25 );

/**
 * Assigne le modèle hub à la page recherche-et-innovation.
 */
function gbecosmolingua_assign_recherche_page_template() {
	$flag = 'gbecosmolingua_recherche_template_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	$page = get_page_by_path( 'recherche-et-innovation' );
	if ( $page ) {
		update_post_meta( $page->ID, '_wp_page_template', 'page-recherche-innovation' );
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_recherche_page_template', 25 );

/**
 * Assigne les modèles hub (Séjours, Partenaires, etc.).
 */
function gbecosmolingua_assign_site_hub_page_templates() {
	$flag = 'gbecosmolingua_site_hubs_tpl_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	foreach ( gbecosmolingua_hub_configs() as $config ) {
		if ( empty( $config['template'] ) || empty( $config['parent_slug'] ) ) {
			continue;
		}
		$page = get_page_by_path( $config['parent_slug'] );
		if ( $page ) {
			update_post_meta( $page->ID, '_wp_page_template', $config['template'] );
		}
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_site_hub_page_templates', 25 );

/**
 * URL d'une image du hub Cultures Gbe (vide si le fichier n'existe pas).
 *
 * @param string $filename Nom de fichier dans assets/images/culture-gbe/.
 */
function gbecosmolingua_culture_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$path     = get_stylesheet_directory() . '/assets/images/culture-gbe/' . $filename;
	if ( ! file_exists( $path ) ) {
		return '';
	}
	return get_stylesheet_directory_uri() . '/assets/images/culture-gbe/' . $filename;
}

/**
 * Variable CSS inline pour une image culture (ex. --gbe-culture-hero-image:url(...)).
 *
 * @param string $filename Nom de fichier.
 * @param string $var_name Nom de la variable CSS sans espaces.
 */
function gbecosmolingua_culture_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_culture_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * URL d'une sous-page Cultures Gbe.
 *
 * @param string $slug       Slug rubrique (ex. arts, architecture).
 * @param string $child_slug Slug sous-thème (ex. sculpture).
 */
function gbecosmolingua_culture_page_url( $slug = '', $child_slug = '' ) {
	$path = 'cultures-gbe';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * URL d'un sous-thème (carte hub).
 *
 * @param array{label: string, slug: string, child_slug?: string} $item Item hub.
 */
function gbecosmolingua_culture_topic_url( $item ) {
	if ( ! empty( $item['child_slug'] ) ) {
		return gbecosmolingua_culture_page_url( $item['slug'], $item['child_slug'] );
	}
	return gbecosmolingua_culture_page_url( $item['slug'] );
}

/**
 * Construit un item de sous-thème pour le hub.
 *
 * @param string $label       Titre.
 * @param string $parent_slug Slug rubrique parente.
 * @param string $child_slug  Slug page enfant (optionnel).
 * @return array{label: string, slug: string, child_slug: string}
 */
function gbecosmolingua_culture_hub_item( $label, $parent_slug, $child_slug = '' ) {
	if ( ! $child_slug ) {
		$child_slug = sanitize_title( $label );
	}
	return array(
		'label'      => $label,
		'slug'       => $parent_slug,
		'child_slug' => $child_slug,
	);
}

/**
 * Sous-thèmes depuis les pages enfants WordPress.
 *
 * @param int    $parent_page_id ID rubrique.
 * @param string $parent_slug    Slug rubrique.
 * @return array<int, array{label: string, slug: string, child_slug: string}>
 */
function gbecosmolingua_culture_topics_from_children( $parent_page_id, $parent_slug ) {
	$topics  = array();
	$children = get_pages(
		array(
			'parent'      => $parent_page_id,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);
	foreach ( $children as $child ) {
		$topics[] = array(
			'label'      => $child->post_title,
			'slug'       => $parent_slug,
			'child_slug' => $child->post_name,
		);
	}
	return $topics;
}

/**
 * Images par défaut pour chaque rubrique Cultures Gbe.
 *
 * @return array<string, string>
 */
function gbecosmolingua_culture_hub_thumb_map() {
	return array(
		'architecture'              => 'architecture.jpg',
		'artisanat'                 => 'arts-artisanat.jpg',
		'arts'                      => 'arts-sculpture.jpg',
		'croyances-et-cosmologies'  => 'croyances-shrine.jpg',
		'danse'                     => 'danse.jpg',
		'fetes-et-ceremonies'       => 'fetes.jpg',
		'gastronomie'               => 'gastronomie.jpg',
		'musique'                   => 'musique.jpg',
		'savoirs-endogenes'         => 'architecture.jpg',
		'patrimoines-materiels'     => 'arts-sculpture.jpg',
		'patrimoines-immateriels'   => 'croyances-shrine.jpg',
	);
}

/**
 * Ordre d'affichage des rubriques sur le hub (aligné menu).
 *
 * @return string[]
 */
function gbecosmolingua_culture_hub_order() {
	return array(
		'architecture',
		'artisanat',
		'arts',
		'croyances-et-cosmologies',
		'danse',
		'fetes-et-ceremonies',
		'gastronomie',
		'musique',
		'savoirs-endogenes',
		'patrimoines-materiels',
		'patrimoines-immateriels',
	);
}

/**
 * Sous-thèmes extraits du contenu d'une page (listes / h3).
 *
 * @param string $content HTML.
 * @param string $slug    Slug page pour les liens.
 * @return array<int, array{label: string, slug: string}>
 */
function gbecosmolingua_culture_extract_topics( $content, $slug ) {
	$topics = array();

	if ( preg_match_all( '/<h3[^>]*>(.*?)<\/h3>/is', $content, $matches ) ) {
		foreach ( $matches[1] as $heading ) {
			$label = wp_strip_all_tags( $heading );
			if ( '' !== $label ) {
				$topics[] = gbecosmolingua_culture_hub_item( $label, $slug );
			}
		}
	}

	if ( empty( $topics ) && preg_match_all( '/<ul[^>]*>(.*?)<\/ul>/is', $content, $lists ) ) {
		foreach ( $lists[1] as $list_inner ) {
			if ( preg_match_all( '/<li[^>]*>(.*?)<\/li>/is', $list_inner, $items ) ) {
				foreach ( $items[1] as $item ) {
					$label = wp_strip_all_tags( $item );
					if ( '' !== $label ) {
						$topics[] = gbecosmolingua_culture_hub_item( $label, $slug );
					}
				}
			}
		}
	}

	return $topics;
}

/**
 * Intro courte depuis le premier paragraphe (hors citation).
 *
 * @param string $content HTML.
 */
function gbecosmolingua_culture_extract_intro( $content ) {
	$stripped = preg_replace( '/<blockquote[^>]*>.*?<\/blockquote>/is', '', $content );
	if ( preg_match( '/<p[^>]*>(.*?)<\/p>/is', $stripped, $match ) ) {
		$text = wp_strip_all_tags( $match[1] );
		if ( '' !== $text ) {
			return $text;
		}
	}
	return '';
}

/**
 * Données de repli si les pages WP ne sont pas encore importées.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_culture_hub_sections_fallback() {
	$map = function ( $id, $title, $slug, $mod, $intro, $items ) {
		$thumbs = gbecosmolingua_culture_hub_thumb_map();
		return array(
			'id'     => $id,
			'title'  => $title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'mod'    => $mod,
			'layout' => 'danse' === $slug ? 'banner' : 'split',
			'intro'  => $intro,
			'items'  => $items,
		);
	};

	$item = function ( $label, $slug ) {
		return gbecosmolingua_culture_hub_item( $label, $slug );
	};

	return array(
		$map(
			'gbe-culture-architecture',
			'Architecture',
			'architecture',
			'architecture',
			'Architecture vernaculaire, habitat traditionnel et espaces sacrés des peuples gbe.',
			array(
				$item( 'Architecture vernaculaire', 'architecture' ),
				$item( 'Habitat traditionnel', 'architecture' ),
				$item( 'Espaces sacrés', 'architecture' ),
			)
		),
		$map(
			'gbe-culture-artisanat',
			'Artisanat',
			'artisanat',
			'artisanat',
			'Techniques artisanales et savoir-faire traditionnels des peuples gbe.',
			array(
				$item( 'Techniques artisanales', 'artisanat' ),
				$item( 'Savoir-faire traditionnels', 'artisanat' ),
				$item( 'Transmission intergénérationnelle', 'artisanat' ),
			)
		),
		$map(
			'gbe-culture-arts',
			'Arts',
			'arts',
			'arts',
			'Sculpture, artisanat, tissage, poterie et arts décoratifs.',
			array(
				$item( 'Sculpture', 'arts' ),
				$item( 'Artisanat', 'artisanat' ),
				$item( 'Tissage', 'arts' ),
				$item( 'Poterie', 'arts' ),
				$item( 'Arts décoratifs', 'arts' ),
			)
		),
		$map(
			'gbe-culture-croyances',
			'Croyances et cosmologies',
			'croyances-et-cosmologies',
			'croyances',
			'Spiritualités, cultes et représentations du monde dans les cultures gbe.',
			array(
				$item( 'Vodun', 'croyances-et-cosmologies' ),
				$item( 'Cultes ancestraux', 'croyances-et-cosmologies' ),
				$item( 'Cosmologies africaines', 'croyances-et-cosmologies' ),
				$item( 'Religions et spiritualités', 'croyances-et-cosmologies' ),
				$item( 'Symboles et représentations', 'croyances-et-cosmologies' ),
			)
		),
		$map(
			'gbe-culture-danse',
			'Danse',
			'danse',
			'danse',
			'Danses cérémonielles, festives et rituelles — expression du corps et de la mémoire collective.',
			array(
				$item( 'Danses cérémonielles', 'danse' ),
				$item( 'Danses festives', 'danse' ),
				$item( 'Danses rituelles', 'danse' ),
			)
		),
		$map(
			'gbe-culture-fetes',
			'Fêtes et cérémonies',
			'fetes-et-ceremonies',
			'fetes',
			'Rites de passage et célébrations communautaires.',
			array(
				$item( 'Naissance', 'fetes-et-ceremonies' ),
				$item( 'Initiation', 'fetes-et-ceremonies' ),
				$item( 'Mariage', 'fetes-et-ceremonies' ),
				$item( 'Funérailles', 'fetes-et-ceremonies' ),
				$item( 'Fêtes communautaires', 'fetes-et-ceremonies' ),
			)
		),
		$map(
			'gbe-culture-gastronomie',
			'Gastronomie',
			'gastronomie',
			'gastronomie',
			'Cuisine traditionnelle et patrimoine alimentaire.',
			array(
				$item( 'Cuisine traditionnelle', 'gastronomie' ),
				$item( 'Produits du terroir', 'gastronomie' ),
				$item( 'Patrimoine alimentaire', 'gastronomie' ),
			)
		),
		$map(
			'gbe-culture-musique',
			'Musique',
			'musique',
			'musique',
			'Chants, musiques rituelles et instruments — la dimension sonore du patrimoine gbe.',
			array(
				$item( 'Chants traditionnels', 'musique' ),
				$item( 'Musiques rituelles', 'musique' ),
				$item( 'Instruments de musique', 'musique' ),
			)
		),
		$map(
			'gbe-culture-savoirs-endogenes',
			'Savoirs endogènes',
			'savoirs-endogenes',
			'savoirs',
			'Médecine, pharmacopée, agriculture et savoirs écologiques locaux.',
			array(
				$item( 'Médecine traditionnelle', 'savoirs-endogenes' ),
				$item( 'Pharmacopée', 'savoirs-endogenes' ),
				$item( 'Agriculture traditionnelle', 'savoirs-endogenes' ),
				$item( 'Gestion de l\'environnement', 'savoirs-endogenes' ),
				$item( 'Techniques artisanales', 'savoirs-endogenes' ),
			)
		),
		$map(
			'gbe-culture-patrimoines-materiels',
			'Patrimoines matériels',
			'patrimoines-materiels',
			'patrimoines-materiels',
			'Sites, monuments, objets et témoignages matériels des cultures gbe.',
			array(
				$item( 'Sites et monuments', 'patrimoines-materiels' ),
				$item( 'Objets patrimoniaux', 'patrimoines-materiels' ),
				$item( 'Conservation et restauration', 'patrimoines-materiels' ),
			)
		),
		$map(
			'gbe-culture-patrimoines-immateriels',
			'Patrimoines immatériels',
			'patrimoines-immateriels',
			'patrimoines-immateriels',
			'Traditions orales, savoir-faire, rituels et expressions vivantes.',
			array(
				$item( 'Traditions orales', 'patrimoines-immateriels' ),
				$item( 'Savoir-faire', 'patrimoines-immateriels' ),
				$item( 'Rituels et pratiques vivantes', 'patrimoines-immateriels' ),
			)
		),
	);
}

/**
 * Rubriques du hub Cultures Gbe (pages enfants + repli statique).
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_culture_hub_sections() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$parent = get_page_by_path( 'cultures-gbe' );
	if ( ! $parent ) {
		$cache = gbecosmolingua_culture_hub_sections_fallback();
		return $cache;
	}

	$children = get_pages(
		array(
			'parent'      => $parent->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	if ( empty( $children ) ) {
		$cache = gbecosmolingua_culture_hub_sections_fallback();
		return $cache;
	}

	$thumbs   = gbecosmolingua_culture_hub_thumb_map();
	$fallback = gbecosmolingua_culture_hub_sections_fallback();
	$fallback_by_slug = array();
	foreach ( $fallback as $row ) {
		$fallback_by_slug[ $row['slug'] ] = $row;
	}

	$by_slug = array();
	foreach ( $children as $child ) {
		$slug   = $child->post_name;
		$topics = gbecosmolingua_culture_topics_from_children( (int) $child->ID, $slug );
		$intro  = gbecosmolingua_culture_extract_intro( $child->post_content );
		if ( '' === $intro && isset( $fallback_by_slug[ $slug ] ) ) {
			$intro = $fallback_by_slug[ $slug ]['intro'];
		}
		if ( '' === $intro ) {
			$intro = wp_trim_words( wp_strip_all_tags( $child->post_content ), 32, '…' );
		}
		if ( empty( $topics ) && isset( $fallback_by_slug[ $slug ] ) ) {
			$topics = $fallback_by_slug[ $slug ]['items'];
		}

		$mod = $slug;
		if ( false !== strpos( $slug, 'croyances' ) ) {
			$mod = 'croyances';
		} elseif ( false !== strpos( $slug, 'fetes' ) ) {
			$mod = 'fetes';
		} elseif ( false !== strpos( $slug, 'savoirs' ) ) {
			$mod = 'savoirs';
		}

		$by_slug[ $slug ] = array(
			'id'     => 'gbe-culture-' . sanitize_title( $slug ),
			'title'  => $child->post_title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'mod'    => $mod,
			'layout' => 'danse' === $slug ? 'banner' : 'split',
			'intro'  => $intro,
			'items'  => $topics,
		);
	}

	$ordered = array();
	foreach ( gbecosmolingua_culture_hub_order() as $slug ) {
		if ( isset( $by_slug[ $slug ] ) ) {
			$ordered[] = $by_slug[ $slug ];
			unset( $by_slug[ $slug ] );
		}
	}
	foreach ( $by_slug as $row ) {
		$ordered[] = $row;
	}

	$cache = ! empty( $ordered ) ? $ordered : gbecosmolingua_culture_hub_sections_fallback();
	return $cache;
}

/**
 * @deprecated Toutes les rubriques sont dans gbecosmolingua_culture_hub_sections().
 * @return array<int, array{label: string, slug: string}>
 */
function gbecosmolingua_culture_hub_more_links() {
	return array();
}

/**
 * Image suggérée pour un sous-thème (fichier dans assets/images/culture-gbe/).
 *
 * @param string $label       Libellé du sous-thème.
 * @param string $parent_slug Slug de la rubrique parente.
 */
function gbecosmolingua_culture_subtopic_thumb( $label, $parent_slug ) {
	$by_label = array(
		'Architecture vernaculaire'     => 'architecture.jpg',
		'Habitat traditionnel'          => 'architecture.jpg',
		'Espaces sacrés'                => 'croyances-shrine.jpg',
		'Sculpture'                     => 'arts-sculpture.jpg',
		'Artisanat'                     => 'arts-artisanat.jpg',
		'Tissage'                       => 'arts-tissage.jpg',
		'Poterie'                       => 'arts-poterie.jpg',
		'Arts décoratifs'               => 'arts-sculpture.jpg',
		'Vodun'                         => 'croyances-shrine.jpg',
		'Cultes ancestraux'             => 'croyances-shrine.jpg',
		'Cosmologies africaines'        => 'croyances-shrine.jpg',
		'Religions et spiritualités'    => 'croyances-shrine.jpg',
		'Symboles et représentations'   => 'croyances-shrine.jpg',
		'Danses cérémonielles'          => 'danse.jpg',
		'Danses festives'               => 'danse.jpg',
		'Danses rituelles'              => 'danse.jpg',
		'Naissance'                     => 'fetes.jpg',
		'Initiation'                    => 'fetes.jpg',
		'Mariage'                       => 'fetes.jpg',
		'Funérailles'                   => 'fetes.jpg',
		'Fêtes communautaires'          => 'fetes.jpg',
		'Cuisine traditionnelle'        => 'gastronomie.jpg',
		'Produits du terroir'           => 'gastronomie.jpg',
		'Patrimoine alimentaire'        => 'gastronomie.jpg',
		'Chants traditionnels'          => 'musique.jpg',
		'Musiques rituelles'            => 'musique.jpg',
		'Instruments de musique'        => 'musique.jpg',
	);

	if ( isset( $by_label[ $label ] ) ) {
		return $by_label[ $label ];
	}

	$parent_thumbs = gbecosmolingua_culture_hub_thumb_map();
	return isset( $parent_thumbs[ $parent_slug ] ) ? $parent_thumbs[ $parent_slug ] : 'arts-sculpture.jpg';
}

/**
 * Phrase d'accroche pour une carte sous-thème.
 *
 * @param string $label Libellé.
 */
function gbecosmolingua_culture_subtopic_blurb( $label ) {
	return sprintf(
		/* translators: %s: cultural sub-topic name */
		__( 'Approfondir « %s » dans le patrimoine vivant des cultures gbe.', 'gbecosmolingua' ),
		$label
	);
}

/**
 * Affiche la grille de cartes pour les sous-thèmes d'une rubrique.
 *
 * @param array<string, mixed> $section Section hub.
 */
function gbecosmolingua_culture_render_subtopics( $section ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	?>
	<div class="gbe-culture-subtopics" aria-labelledby="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
		<h3 class="gbe-culture-subtopics__heading" id="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
			<?php echo esc_html( $section['title'] ); ?>
		</h3>
		<div class="gbe-culture-subtopics__grid">
			<?php foreach ( $section['items'] as $item ) : ?>
				<?php
				$file  = gbecosmolingua_culture_subtopic_thumb( $item['label'], $section['slug'] );
				$style = gbecosmolingua_culture_image_style( $file, '--gbe-culture-section-image' );
				$url   = gbecosmolingua_culture_topic_url( $item );
				$anchor = sanitize_title( $item['label'] );
				?>
				<article class="gbe-culture-subtopic" id="<?php echo esc_attr( $section['id'] . '-' . $anchor ); ?>">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( gbecosmolingua_culture_subtopic_blurb( $item['label'] ) ); ?></p>
						<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $url ); ?>">
							<?php esc_html_e( 'Découvrir', 'gbecosmolingua' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * URL d'une image du hub Le Gbe (dossier le-gbe, repli culture-gbe).
 *
 * @param string $filename Nom de fichier.
 */
function gbecosmolingua_le_gbe_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$path     = get_stylesheet_directory() . '/assets/images/le-gbe/' . $filename;
	if ( file_exists( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/le-gbe/' . $filename;
	}
	return gbecosmolingua_culture_image( $filename );
}

/**
 * Variable CSS inline pour une image Le Gbe.
 *
 * @param string $filename Nom de fichier.
 * @param string $var_name Nom de la variable CSS.
 */
function gbecosmolingua_le_gbe_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_le_gbe_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * URL d'une sous-page Le Gbe.
 *
 * @param string $slug       Slug rubrique (ex. les-langues).
 * @param string $child_slug Slug enfant (ex. ewe).
 */
function gbecosmolingua_le_gbe_page_url( $slug = '', $child_slug = '' ) {
	$path = 'le-gbe';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * URL d'un sous-thème Le Gbe (carte hub).
 *
 * @param array{label: string, slug: string, child_slug?: string} $item Item hub.
 */
function gbecosmolingua_le_gbe_topic_url( $item ) {
	if ( ! empty( $item['child_slug'] ) ) {
		return gbecosmolingua_le_gbe_page_url( $item['slug'], $item['child_slug'] );
	}
	return gbecosmolingua_le_gbe_page_url( $item['slug'] );
}

/**
 * Item sous-thème Le Gbe.
 *
 * @param string $label       Titre.
 * @param string $parent_slug Slug rubrique parente.
 * @param string $child_slug  Slug page enfant.
 * @return array{label: string, slug: string, child_slug: string}
 */
function gbecosmolingua_le_gbe_hub_item( $label, $parent_slug, $child_slug = '' ) {
	if ( ! $child_slug ) {
		$child_slug = sanitize_title( $label );
	}
	return array(
		'label'      => $label,
		'slug'       => $parent_slug,
		'child_slug' => $child_slug,
	);
}

/**
 * Sous-thèmes depuis les pages enfants WordPress (Le Gbe).
 *
 * @param int    $parent_page_id ID rubrique.
 * @param string $parent_slug    Slug rubrique.
 * @return array<int, array{label: string, slug: string, child_slug: string}>
 */
function gbecosmolingua_le_gbe_topics_from_children( $parent_page_id, $parent_slug ) {
	$topics   = array();
	$children = get_pages(
		array(
			'parent'      => $parent_page_id,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);
	foreach ( $children as $child ) {
		$topics[] = array(
			'label'      => $child->post_title,
			'slug'       => $parent_slug,
			'child_slug' => $child->post_name,
		);
	}
	return $topics;
}

/**
 * Images par défaut pour les rubriques Le Gbe.
 *
 * @return array<string, string>
 */
function gbecosmolingua_le_gbe_hub_thumb_map() {
	return array(
		'bibliotheque-linguistique' => 'arts-sculpture.jpg',
		'carte-interactive'         => 'architecture.jpg',
		'corpus-numeriques'         => 'musique.jpg',
		'histoire-et-migrations'    => 'fetes.jpg',
		'le-continuum-gbe'          => 'architecture.jpg',
		'les-langues'               => 'arts-artisanat.jpg',
		'linguistique'              => 'gastronomie.jpg',
		'presentation-generale'     => 'architecture.jpg',
		'peuples-du-continuum'      => 'danse.jpg',
	);
}

/**
 * Ordre d'affichage des rubriques sur le hub Le Gbe (aligné menu).
 *
 * @return string[]
 */
function gbecosmolingua_le_gbe_hub_order() {
	return array(
		'bibliotheque-linguistique',
		'carte-interactive',
		'corpus-numeriques',
		'histoire-et-migrations',
		'le-continuum-gbe',
		'les-langues',
		'linguistique',
	);
}

/**
 * Rubriques « Voir plus » sur le hub Le Gbe.
 *
 * @return string[]
 */
function gbecosmolingua_le_gbe_hub_more_slugs() {
	return array(
		'presentation-generale',
		'peuples-du-continuum',
	);
}

/**
 * Rubriques sans grille de sous-thèmes (carte unique).
 *
 * @return string[]
 */
function gbecosmolingua_le_gbe_hub_feature_slugs() {
	return array(
		'bibliotheque-linguistique',
		'carte-interactive',
		'corpus-numeriques',
	);
}

/**
 * Données de repli pour le hub Le Gbe.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_le_gbe_hub_sections_fallback() {
	$thumbs = gbecosmolingua_le_gbe_hub_thumb_map();
	$map    = function ( $id, $title, $slug, $intro, $items, $layout = 'split' ) use ( $thumbs ) {
		return array(
			'id'     => $id,
			'title'  => $title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'mod'    => $slug,
			'layout' => $layout,
			'intro'  => $intro,
			'items'  => $items,
		);
	};
	$item   = function ( $label, $slug, $child_slug = '' ) {
		return gbecosmolingua_le_gbe_hub_item( $label, $slug, $child_slug ?: sanitize_title( $label ) );
	};

	return array(
		$map(
			'gbe-le-gbe-bibliotheque',
			'Bibliothèque',
			'bibliotheque-linguistique',
			'Bibliothèque numérique des langues et patrimoines gbe.',
			array(),
			'feature'
		),
		$map(
			'gbe-le-gbe-carte',
			'Carte interactive',
			'carte-interactive',
			'Répartition géographique des langues, zones culturelles et routes migratoires.',
			array(),
			'feature'
		),
		$map(
			'gbe-le-gbe-corpus',
			'Corpus numériques',
			'corpus-numeriques',
			'Proverbes, archives orales et ressources documentaires de GbeCosmoLingua.',
			array(),
			'feature'
		),
		$map(
			'gbe-le-gbe-histoire',
			'Histoire et migrations',
			'histoire-et-migrations',
			'Récits fondateurs, royaumes et circulations des peuples gbe.',
			array(
				$item( 'Les récits fondateurs', 'histoire-et-migrations', 'les-recits-fondateurs' ),
				$item( 'Royaumes et formations politiques', 'histoire-et-migrations', 'royaumes-et-formations-politiques' ),
				$item( 'Migrations et échanges', 'histoire-et-migrations', 'migrations-et-echanges' ),
			)
		),
		$map(
			'gbe-le-gbe-continuum',
			'Le continuum gbe',
			'le-continuum-gbe',
			'Variétés principales et aires géographiques du continuum.',
			array(
				$item( 'Variétés principales', 'le-continuum-gbe', 'varietes-principales' ),
				$item( 'Pays et territoires', 'le-continuum-gbe', 'pays-et-territoires' ),
			)
		),
		$map(
			'gbe-le-gbe-langues',
			'Les langues',
			'les-langues',
			'Documentation des variétés principales du continuum gbe.',
			array(
				$item( 'Éwé', 'les-langues', 'ewe' ),
				$item( 'Gen (Mina)', 'les-langues', 'gen-mina' ),
				$item( 'Fon', 'les-langues', 'fon' ),
				$item( 'Aja', 'les-langues', 'aja' ),
				$item( 'Gun', 'les-langues', 'gun' ),
				$item( 'Phla-Phera', 'les-langues', 'phla-phera' ),
				$item( 'Autres variétés', 'les-langues', 'autres-varietes' ),
			)
		),
		$map(
			'gbe-le-gbe-linguistique',
			'Linguistique',
			'linguistique',
			'Ressources pour l\'étude scientifique des variétés gbe.',
			array(
				$item( 'Alphabet', 'linguistique', 'alphabet' ),
				$item( 'Phonologie', 'linguistique', 'phonologie' ),
				$item( 'Morphologie', 'linguistique', 'morphologie' ),
				$item( 'Syntaxe', 'linguistique', 'syntaxe' ),
				$item( 'Lexicologie', 'linguistique', 'lexicologie' ),
				$item( 'Dialectologie', 'linguistique', 'dialectologie' ),
			)
		),
	);
}

/**
 * Rubriques du hub Le Gbe.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_le_gbe_hub_sections() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$parent = get_page_by_path( 'le-gbe' );
	if ( ! $parent ) {
		$cache = gbecosmolingua_le_gbe_hub_sections_fallback();
		return $cache;
	}

	$children = get_pages(
		array(
			'parent'      => $parent->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	if ( empty( $children ) ) {
		$cache = gbecosmolingua_le_gbe_hub_sections_fallback();
		return $cache;
	}

	$thumbs           = gbecosmolingua_le_gbe_hub_thumb_map();
	$fallback         = gbecosmolingua_le_gbe_hub_sections_fallback();
	$fallback_by_slug = array();
	foreach ( $fallback as $row ) {
		$fallback_by_slug[ $row['slug'] ] = $row;
	}

	$feature_slugs = gbecosmolingua_le_gbe_hub_feature_slugs();
	$more_slugs    = gbecosmolingua_le_gbe_hub_more_slugs();
	$by_slug       = array();

	foreach ( $children as $child ) {
		$slug = $child->post_name;
		if ( in_array( $slug, $more_slugs, true ) ) {
			continue;
		}

		$topics = gbecosmolingua_le_gbe_topics_from_children( (int) $child->ID, $slug );
		$intro  = gbecosmolingua_culture_extract_intro( $child->post_content );
		if ( '' === $intro && isset( $fallback_by_slug[ $slug ] ) ) {
			$intro = $fallback_by_slug[ $slug ]['intro'];
		}
		if ( '' === $intro ) {
			$intro = wp_trim_words( wp_strip_all_tags( $child->post_content ), 32, '…' );
		}
		if ( empty( $topics ) && isset( $fallback_by_slug[ $slug ] ) ) {
			$topics = $fallback_by_slug[ $slug ]['items'];
		}

		$layout = in_array( $slug, $feature_slugs, true ) ? 'feature' : 'split';
		if ( isset( $fallback_by_slug[ $slug ]['layout'] ) && 'feature' === $fallback_by_slug[ $slug ]['layout'] ) {
			$layout = 'feature';
		}

		$by_slug[ $slug ] = array(
			'id'     => 'gbe-le-gbe-' . sanitize_title( $slug ),
			'title'  => $child->post_title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'mod'    => $slug,
			'layout' => $layout,
			'intro'  => $intro,
			'items'  => $topics,
		);
	}

	$ordered = array();
	foreach ( gbecosmolingua_le_gbe_hub_order() as $slug ) {
		if ( isset( $by_slug[ $slug ] ) ) {
			$ordered[] = $by_slug[ $slug ];
			unset( $by_slug[ $slug ] );
		}
	}
	foreach ( $by_slug as $row ) {
		$ordered[] = $row;
	}

	$cache = ! empty( $ordered ) ? $ordered : gbecosmolingua_le_gbe_hub_sections_fallback();
	return $cache;
}

/**
 * Rubriques « Voir plus » (Le Gbe).
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_le_gbe_hub_more_sections() {
	$parent = get_page_by_path( 'le-gbe' );
	if ( ! $parent ) {
		return array();
	}

	$thumbs = gbecosmolingua_le_gbe_hub_thumb_map();
	$rows   = array();
	foreach ( gbecosmolingua_le_gbe_hub_more_slugs() as $slug ) {
		$page = get_page_by_path( 'le-gbe/' . $slug, OBJECT, 'page' );
		if ( ! $page ) {
			continue;
		}
		$intro = gbecosmolingua_culture_extract_intro( $page->post_content );
		if ( '' === $intro ) {
			$intro = wp_trim_words( wp_strip_all_tags( $page->post_content ), 28, '…' );
		}
		$rows[] = array(
			'id'     => 'gbe-le-gbe-more-' . sanitize_title( $slug ),
			'title'  => $page->post_title,
			'slug'   => $slug,
			'thumb'  => isset( $thumbs[ $slug ] ) ? $thumbs[ $slug ] : 'arts-sculpture.jpg',
			'intro'  => $intro,
			'url'    => gbecosmolingua_le_gbe_page_url( $slug ),
		);
	}
	return $rows;
}

/**
 * Image suggérée pour un sous-thème Le Gbe.
 *
 * @param string $label       Libellé.
 * @param string $parent_slug Slug rubrique.
 */
function gbecosmolingua_le_gbe_subtopic_thumb( $label, $parent_slug ) {
	$by_label = array(
		'Éwé'                               => 'arts-artisanat.jpg',
		'Gen (Mina)'                        => 'arts-artisanat.jpg',
		'Fon'                               => 'arts-sculpture.jpg',
		'Aja'                               => 'danse.jpg',
		'Gun'                               => 'musique.jpg',
		'Phla-Phera'                        => 'fetes.jpg',
		'Autres variétés'                   => 'architecture.jpg',
		'Les récits fondateurs'             => 'fetes.jpg',
		'Royaumes et formations politiques' => 'architecture.jpg',
		'Migrations et échanges'            => 'danse.jpg',
		'Variétés principales'              => 'arts-artisanat.jpg',
		'Pays et territoires'               => 'architecture.jpg',
		'Alphabet'                          => 'arts-sculpture.jpg',
		'Phonologie'                        => 'musique.jpg',
		'Morphologie'                       => 'gastronomie.jpg',
		'Syntaxe'                           => 'architecture.jpg',
		'Lexicologie'                       => 'arts-artisanat.jpg',
		'Dialectologie'                     => 'danse.jpg',
	);

	if ( isset( $by_label[ $label ] ) ) {
		return $by_label[ $label ];
	}

	$parent_thumbs = gbecosmolingua_le_gbe_hub_thumb_map();
	return isset( $parent_thumbs[ $parent_slug ] ) ? $parent_thumbs[ $parent_slug ] : 'arts-sculpture.jpg';
}

/**
 * Phrase d'accroche sous-thème Le Gbe.
 *
 * @param string $label Libellé.
 */
function gbecosmolingua_le_gbe_subtopic_blurb( $label ) {
	return sprintf(
		/* translators: %s: sub-topic name */
		__( 'Approfondir « %s » dans le continuum linguistique gbe.', 'gbecosmolingua' ),
		$label
	);
}

/**
 * Grille de sous-thèmes Le Gbe.
 *
 * @param array<string, mixed> $section Section hub.
 */
function gbecosmolingua_le_gbe_render_subtopics( $section ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	?>
	<div class="gbe-culture-subtopics" aria-labelledby="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
		<h3 class="gbe-culture-subtopics__heading" id="<?php echo esc_attr( $section['id'] . '-subtopics' ); ?>">
			<?php echo esc_html( $section['title'] ); ?>
		</h3>
		<div class="gbe-culture-subtopics__grid">
			<?php foreach ( $section['items'] as $item ) : ?>
				<?php
				$file   = gbecosmolingua_le_gbe_subtopic_thumb( $item['label'], $section['slug'] );
				$style  = gbecosmolingua_le_gbe_image_style( $file, '--gbe-culture-section-image' );
				$url    = gbecosmolingua_le_gbe_topic_url( $item );
				$anchor = sanitize_title( $item['label'] );
				?>
				<article class="gbe-culture-subtopic" id="<?php echo esc_attr( $section['id'] . '-' . $anchor ); ?>">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( gbecosmolingua_le_gbe_subtopic_blurb( $item['label'] ) ); ?></p>
						<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $url ); ?>">
							<?php esc_html_e( 'Découvrir', 'gbecosmolingua' ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Assigne le modèle hub à la page cultures-gbe après mise à jour du thème.
 */
function gbecosmolingua_assign_cultures_gbe_page_template() {
	$flag = 'gbecosmolingua_cultures_gbe_template_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	$page = get_page_by_path( 'cultures-gbe' );
	if ( $page ) {
		update_post_meta( $page->ID, '_wp_page_template', 'page-cultures-gbe' );
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_cultures_gbe_page_template', 25 );

/**
 * Register block pattern category.
 */
function gbecosmolingua_register_pattern_category() {
	register_block_pattern_category(
		'gbecosmolingua',
		array(
			'label' => __( 'GbeCosmoLingua', 'gbecosmolingua' ),
		)
	);
}
add_action( 'init', 'gbecosmolingua_register_pattern_category' );

/**
 * Register navigation menu locations.
 */
function gbecosmolingua_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'gbecosmolingua' ),
			'footer'  => __( 'Menu pied de page', 'gbecosmolingua' ),
		)
	);
}
add_action( 'after_setup_theme', 'gbecosmolingua_register_menus' );

/**
 * Theme supports.
 */
function gbecosmolingua_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );
}
add_action( 'after_setup_theme', 'gbecosmolingua_theme_setup' );

/**
 * Favicon du site (onglet navigateur) — fallback si aucune icône n'est définie dans le customizer.
 */
function gbecosmolingua_site_favicon() {
	if ( has_site_icon() ) {
		return;
	}

	$icon_url = get_stylesheet_directory_uri() . '/assets/images/gbecosmolingua-logo.png';
	printf(
		'<link rel="icon" href="%s" sizes="any">' . "\n",
		esc_url( $icon_url )
	);
}
add_action( 'wp_head', 'gbecosmolingua_site_favicon', 5 );
add_action( 'admin_head', 'gbecosmolingua_site_favicon', 5 );
add_action( 'login_head', 'gbecosmolingua_site_favicon', 5 );

/**
 * Enqueue admin branding styles.
 */
function gbecosmolingua_admin_branding_assets() {
	wp_enqueue_style(
		'gbecosmolingua-admin',
		get_stylesheet_directory_uri() . '/assets/css/admin.css',
		array( 'wp-admin', 'common', 'forms' ),
		GBECOSMOLINGUA_VERSION
	);

	wp_enqueue_style(
		'gbecosmolingua-editor-admin',
		get_stylesheet_directory_uri() . '/assets/css/editor-admin.css',
		array( 'gbecosmolingua-admin' ),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'gbecosmolingua_admin_branding_assets', 100 );

/**
 * Enqueue login page branding styles.
 */
function gbecosmolingua_login_branding_assets() {
	wp_enqueue_style(
		'gbecosmolingua-admin',
		get_stylesheet_directory_uri() . '/assets/css/admin.css',
		array(),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'login_enqueue_scripts', 'gbecosmolingua_login_branding_assets' );

/**
 * Enqueue editor branding in block editor context.
 */
function gbecosmolingua_block_editor_branding() {
	wp_enqueue_style(
		'gbecosmolingua-editor-admin',
		get_stylesheet_directory_uri() . '/assets/css/editor-admin.css',
		array( 'wp-edit-blocks' ),
		GBECOSMOLINGUA_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'gbecosmolingua_block_editor_branding' );

/**
 * Login page logo link and title.
 *
 * @return string
 */
function gbecosmolingua_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'gbecosmolingua_login_logo_url' );

/**
 * @return string
 */
function gbecosmolingua_login_logo_title() {
	return 'GbeCosmoLingua';
}
add_filter( 'login_headertext', 'gbecosmolingua_login_logo_title' );

/**
 * Replace WordPress logo in admin bar with GbeCosmoLingua branding.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
 */
function gbecosmolingua_admin_bar_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );

	$wp_admin_bar->add_node(
		array(
			'id'    => 'gbe-logo',
			'title' => sprintf(
				'<span class="gbe-admin-bar-logo__icon" aria-hidden="true"></span> <span class="ab-label">%s</span>',
				esc_html__( 'GbeCosmoLingua', 'gbecosmolingua' )
			),
			'href'  => admin_url(),
			'meta'  => array(
				'class' => 'gbe-admin-bar-logo',
				'title' => __( 'Tableau de bord GbeCosmoLingua', 'gbecosmolingua' ),
			),
		)
	);
}
add_action( 'admin_bar_menu', 'gbecosmolingua_admin_bar_logo', 11 );

/**
 * Custom admin footer text.
 *
 * @return string
 */
function gbecosmolingua_admin_footer_text() {
	return __( 'GbeCosmoLingua — Observatoire des langues, cultures et patrimoines gbe', 'gbecosmolingua' );
}
add_filter( 'admin_footer_text', 'gbecosmolingua_admin_footer_text' );
