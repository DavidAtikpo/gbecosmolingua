<?php
/**
 * Affichage public — pages chapitre Gbe (Linguistique, Continuum, etc.).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Configuration des sections chapitre sous Gbe.
 *
 * @return array<string, array<string, mixed>>
 */
function gbecosmolingua_le_gbe_chapter_sections() {
	return array(
		'linguistique'     => array(
			'parent_path' => 'le-gbe/linguistique',
			'back_label'  => __( '← Retour Linguistique', 'gbecosmolingua' ),
			'nav_aria'    => __( 'Rubriques linguistiques', 'gbecosmolingua' ),
			'slugs'       => array(
				'travaux-scientifiques-recents',
				'potentialites-lexicales',
				'dialectologie',
				'phonologie',
				'morphologie',
				'lexicologie',
				'hounkpati-b-c-capo',
			),
		),
		'le-continuum-gbe' => array(
			'parent_path' => 'le-gbe/le-continuum-gbe',
			'back_label'  => __( '← Retour Le continuum gbe', 'gbecosmolingua' ),
			'nav_aria'    => __( 'Rubriques du continuum', 'gbecosmolingua' ),
			'slugs'       => array(
				'inventaire-des-parlers',
				'regroupement-des-parlers',
				'langue-unique',
				'varietes-principales',
				'pays-et-territoires',
			),
		),
		'les-langues'      => array(
			'parent_path' => 'le-gbe/les-langues',
			'back_label'  => __( '← Retour Les langues', 'gbecosmolingua' ),
			'nav_aria'    => __( 'Fiches langues du continuum', 'gbecosmolingua' ),
			'slugs'       => array(
				'ewe',
				'gen-mina',
				'fon',
				'aja',
				'gun',
				'waci',
				'xwela',
				'xwla',
				'phla-phera',
				'autres-varietes',
			),
		),
	);
}

/**
 * Pages autonomes sous Gbe (hors sections chapitre).
 *
 * @return array<string, array<string, string>>
 */
function gbecosmolingua_le_gbe_standalone_pages() {
	return array(
		'peuples-du-continuum' => array(
			'lead'        => __( 'Identités sociologiques, ethnonymes et conscience dialectale des communautés locutrices du continuum gbe.', 'gbecosmolingua' ),
			'hero_image'  => 'hero-patrimoine.jpg',
			'hero_dir'    => 'home',
			'back_label'  => __( '← Retour Gbe', 'gbecosmolingua' ),
		),
	);
}

/**
 * Chemins des pages autonomes Gbe.
 *
 * @return string[]
 */
function gbecosmolingua_le_gbe_standalone_paths() {
	$paths = array();
	foreach ( array_keys( gbecosmolingua_le_gbe_standalone_pages() ) as $slug ) {
		$paths[] = 'le-gbe/' . $slug;
	}
	return $paths;
}

/**
 * Chapôs par défaut selon le slug de page.
 *
 * @return array<string, string>
 */
function gbecosmolingua_le_gbe_chapter_leads() {
	return array(
		'travaux-scientifiques-recents' => __( 'Monographies, thèses et lexicographie du continuum gbe depuis 1966 — cadres universitaires au Ghana, Togo, Bénin et Nigeria.', 'gbecosmolingua' ),
		'potentialites-lexicales'       => __( 'Ressources internes et externes pour l’enrichissement du vocabulaire gbe : dérivation, emprunts et combinaisons créatives.', 'gbecosmolingua' ),
		'dialectologie'                 => __( 'Variation dialectale, intelligibilité mutuelle et regroupement des parlers du continuum.', 'gbecosmolingua' ),
		'phonologie'                    => __( 'Inventaires phonologiques, tons et structures syllabiques — focus fongbè.', 'gbecosmolingua' ),
		'morphologie'                   => __( 'Dérivation, composition et onomastique dans les variétés gbe.', 'gbecosmolingua' ),
		'lexicologie'                   => __( 'Champs lexicaux, néologie et terminologie culturelle de Gbe.', 'gbecosmolingua' ),
		'hounkpati-b-c-capo'            => __( 'Linguiste béninois, professeur titulaire à l’UAC — classification du continuum gbe, phonologie comparée, Labo Gbe (Int.) et orthographe unifiée (GUSO).', 'gbecosmolingua' ),
		'inventaire-des-parlers'        => __( 'Cinquante parlers recensés sur quatre pays — territoire, locuteurs et diversité dialectale du continuum gbe.', 'gbecosmolingua' ),
		'regroupement-des-parlers'      => __( 'Cinq sections dialectologiques de Gbe : Vhe, Gen, Ajé, Fon et Phla-Phera — méthodologie et innovations phonologiques.', 'gbecosmolingua' ),
		'langue-unique'                 => __( 'Gbe comme langue unique : critères d’identification, intelligibilité mutuelle et bases de la renaissance linguistique.', 'gbecosmolingua' ),
		'varietes-principales'          => __( 'Variétés écrites et parlers de référence du continuum : Éwé, Fon, Gen, Aja et autres formes graphiques.', 'gbecosmolingua' ),
		'pays-et-territoires'           => __( 'Répartition géographique des parlers gbe au Ghana, Togo, Bénin et Nigeria.', 'gbecosmolingua' ),
		'ewe'                           => __( 'Éwé standard — section Vhe, Awlan et parlers voisins. Ghana et Togo.', 'gbecosmolingua' ),
		'gen-mina'                      => __( 'Gen (Mina) — Gliji, Agwe, Anexo. Section compacte, plaque tournante du continuum.', 'gbecosmolingua' ),
		'fon'                           => __( 'Fon (Danxomegbe) — langue historique du royaume du Dahomey, section Fon.', 'gbecosmolingua' ),
		'aja'                           => __( 'Aja (Ajatɔ) — Hwe, Dogbé, Stédé. Section Ajé, sud-ouest du Bénin.', 'gbecosmolingua' ),
		'gun'                           => __( 'Gun — Porto-Novo et lagune. Section Fon, proche du Fon, sociologiquement distinct.', 'gbecosmolingua' ),
		'waci'                          => __( 'Waci (Wacigbe) — dialecte Vhe transfrontalier Togo/Bénin, des deux côtés du Mono.', 'gbecosmolingua' ),
		'xwela'                         => __( 'Xwela (Phelé) — groupe Phla-Phera, côte béninoise.', 'gbecosmolingua' ),
		'xwla'                          => __( 'Xwla (Phla) — Togo et Bénin, proche du Phelé phonologiquement.', 'gbecosmolingua' ),
		'phla-phera'                    => __( 'Phla-Phera — groupe conventionnel : Tsapha, Kotafon, Ayizo, Alada…', 'gbecosmolingua' ),
		'autres-varietes'               => __( 'Ifè, Saxwe, Se, Kotafon, Tèfin, Weme, Movɔli et autres parlers du continuum.', 'gbecosmolingua' ),
		'le-continuum-gbe'              => __( 'Inventaire, regroupement dialectologique, unité linguistique et répartition géographique du continuum gbe.', 'gbecosmolingua' ),
		'les-langues'                   => __( 'Fiches des principales variétés du continuum — graphies, aires et patrimoine linguistique.', 'gbecosmolingua' ),
		'linguistique'                  => __( 'Description scientifique de Gbe — dialectologie, phonologie, morphologie et corpus numériques.', 'gbecosmolingua' ),
		'peuples-du-continuum'          => __( 'Identités sociologiques, ethnonymes et conscience dialectale des communautés locutrices du continuum gbe.', 'gbecosmolingua' ),
	);
}

/**
 * Contexte chapitre pour une page.
 *
 * @param WP_Post|null $page Page.
 * @return array<string, mixed>|null
 */
function gbecosmolingua_le_gbe_chapter_context( $page = null ) {
	if ( ! $page instanceof WP_Post ) {
		if ( ! is_singular( 'page' ) ) {
			return null;
		}
		$page = get_queried_object();
	}
	if ( ! $page instanceof WP_Post || 'page' !== $page->post_type ) {
		return null;
	}

	$sections = gbecosmolingua_le_gbe_chapter_sections();
	$standalone = gbecosmolingua_le_gbe_standalone_pages();

	$parent = get_post( (int) $page->post_parent );
	if ( ! $parent instanceof WP_Post ) {
		return null;
	}

	// Page autonome sous « le-gbe » (ex. peuples-du-continuum).
	if ( 'le-gbe' === $parent->post_name && isset( $standalone[ $page->post_name ] ) ) {
		return array(
			'section'       => 'standalone',
			'config'        => $standalone[ $page->post_name ],
			'parent'        => $parent,
			'root'          => $parent,
			'is_hub'        => false,
			'is_standalone' => true,
		);
	}

	// Hub de section : enfant direct de « le-gbe » (ex. le-continuum-gbe, les-langues).
	if ( 'le-gbe' === $parent->post_name && isset( $sections[ $page->post_name ] ) ) {
		return array(
			'section' => $page->post_name,
			'config'  => $sections[ $page->post_name ],
			'parent'  => $page,
			'root'    => $parent,
			'is_hub'  => true,
		);
	}

	$root = get_post( (int) $parent->post_parent );
	if ( ! $root instanceof WP_Post || 'le-gbe' !== $root->post_name ) {
		return null;
	}

	if ( ! isset( $sections[ $parent->post_name ] ) ) {
		return null;
	}

	$config = $sections[ $parent->post_name ];
	if ( ! empty( $config['slugs'] ) && ! in_array( $page->post_name, $config['slugs'], true ) ) {
		return null;
	}

	return array(
		'section' => $parent->post_name,
		'config'  => $config,
		'parent'  => $parent,
		'root'    => $root,
		'is_hub'  => false,
	);
}

/**
 * Page courante chapitre Gbe ?
 *
 * @param WP_Post|null $post Page.
 * @return bool
 */
function gbecosmolingua_le_gbe_is_chapter_page( $post = null ) {
	return null !== gbecosmolingua_le_gbe_chapter_context( $post );
}

/**
 * Slugs de pages utilisant le modèle chapitre (toutes sections).
 *
 * @return string[]
 */
function gbecosmolingua_le_gbe_chapter_slugs() {
	$slugs = array();
	foreach ( gbecosmolingua_le_gbe_chapter_sections() as $section ) {
		if ( ! empty( $section['slugs'] ) ) {
			$slugs = array_merge( $slugs, $section['slugs'] );
		}
	}
	return array_values( array_unique( $slugs ) );
}

/**
 * Chemins complets des pages chapitre.
 *
 * @return string[]
 */
function gbecosmolingua_le_gbe_chapter_paths() {
	$paths = array();
	foreach ( gbecosmolingua_le_gbe_chapter_sections() as $section_key => $section ) {
		if ( ! empty( $section['parent_path'] ) ) {
			$paths[] = $section['parent_path'];
		}
		if ( empty( $section['slugs'] ) ) {
			continue;
		}
		foreach ( $section['slugs'] as $slug ) {
			$paths[] = $section['parent_path'] . '/' . $slug;
		}
	}
	return array_merge( $paths, gbecosmolingua_le_gbe_standalone_paths() );
}

/**
 * Style bannière chapitre.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_le_gbe_chapter_hero_style( $page = null ) {
	if ( ! $page instanceof WP_Post ) {
		$page = get_queried_object();
	}

	$context = gbecosmolingua_le_gbe_chapter_context( $page );
	if ( $context && ! empty( $context['is_standalone'] ) ) {
		$dir  = $context['config']['hero_dir'] ?? 'home';
		$file = $context['config']['hero_image'] ?? '';
		if ( $file ) {
			$path = get_stylesheet_directory() . '/assets/images/' . $dir . '/' . $file;
			if ( file_exists( $path ) ) {
				return '--gbe-chapter-hero-image:url(' . esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $dir . '/' . $file ) . ');';
			}
		}
	}

	if ( $context && ! empty( $context['is_hub'] ) && 'le-continuum-gbe' === $context['section'] ) {
		$file = get_stylesheet_directory() . '/assets/images/home/map-preview.jpg';
		if ( file_exists( $file ) ) {
			return '--gbe-chapter-hero-image:url(' . esc_url( get_stylesheet_directory_uri() . '/assets/images/home/map-preview.jpg' ) . ');';
		}
	}

	if ( $context && ! empty( $context['is_hub'] ) && 'les-langues' === $context['section'] ) {
		$file = get_stylesheet_directory() . '/assets/images/home/lang-ewe.jpg';
		if ( file_exists( $file ) ) {
			return '--gbe-chapter-hero-image:url(' . esc_url( get_stylesheet_directory_uri() . '/assets/images/home/lang-ewe.jpg' ) . ');';
		}
	}

	if ( $context && 'les-langues' === $context['section'] && empty( $context['is_hub'] ) ) {
		$lang_map = array(
			'ewe'             => 'lang-ewe.jpg',
			'gen-mina'        => 'lang-gen.jpg',
			'fon'             => 'lang-fon.jpg',
			'aja'             => 'lang-aja.jpg',
			'gun'             => 'lang-gun.jpg',
			'phla-phera'      => 'lang-phera.jpg',
			'xwela'           => 'lang-phera.jpg',
			'xwla'            => 'lang-phera.jpg',
		);
		if ( isset( $lang_map[ $page->post_name ] ) ) {
			$file = get_stylesheet_directory() . '/assets/images/home/' . $lang_map[ $page->post_name ];
			if ( file_exists( $file ) ) {
				return '--gbe-chapter-hero-image:url(' . esc_url( get_stylesheet_directory_uri() . '/assets/images/home/' . $lang_map[ $page->post_name ] ) . ');';
			}
		}
	}

	if ( $page instanceof WP_Post && has_post_thumbnail( $page->ID ) ) {
		$style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-chapter-hero-image' );
		if ( $style ) {
			return $style;
		}
	}

	$dirs = array( 'le-gbe', 'linguistique', 'culture-gbe' );
	$files = array( 'map-preview.jpg', 'hero-patrimoine.jpg', 'hero-village.jpg', 'hero-culture.jpg' );
	foreach ( $dirs as $dir ) {
		foreach ( $files as $file ) {
			$path = get_stylesheet_directory() . '/assets/images/' . $dir . '/' . $file;
			if ( file_exists( $path ) ) {
				return '--gbe-chapter-hero-image:url(' . esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $dir . '/' . $file ) . ');';
			}
		}
	}

	return gbecosmolingua_linguistique_image_style( 'hero-village.jpg', '--gbe-chapter-hero-image' );
}

/**
 * HTML bannière chapitre.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_le_gbe_chapter_hero_html( $page = null ) {
	if ( ! $page instanceof WP_Post ) {
		$page = get_queried_object();
	}

	$context = gbecosmolingua_le_gbe_chapter_context( $page );
	if ( ! $context ) {
		return '';
	}

	$hero_style = gbecosmolingua_le_gbe_chapter_hero_style( $page );
	$leads      = gbecosmolingua_le_gbe_chapter_leads();
	$lead       = has_excerpt( $page ) ? get_the_excerpt( $page ) : ( $leads[ $page->post_name ] ?? ( $context['config']['lead'] ?? '' ) );
	$is_hub     = ! empty( $context['is_hub'] );
	$is_top     = $is_hub || ! empty( $context['is_standalone'] );
	$root       = $context['root'] ?? $context['parent'];

	ob_start();
	?>
	<div class="wp-block-group alignfull gbe-chapter-hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
		<div class="gbe-chapter-hero__inner">
			<p class="gbe-chapter-hero__kicker">
				<a href="<?php echo esc_url( home_url( '/le-gbe/' ) ); ?>"><?php esc_html_e( 'Gbe', 'gbecosmolingua' ); ?></a>
				<?php if ( ! $is_top ) : ?>
					<span aria-hidden="true"> · </span>
					<a href="<?php echo esc_url( get_permalink( $context['parent'] ) ); ?>"><?php echo esc_html( $context['parent']->post_title ); ?></a>
				<?php endif; ?>
			</p>
			<h1 class="gbe-chapter-hero__title"><?php echo esc_html( $page->post_title ); ?></h1>
			<?php if ( $lead ) : ?>
				<p class="gbe-chapter-hero__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Liens vers pages sœurs.
 *
 * @param WP_Post $page Page courante.
 * @return array<int, array{url: string, label: string, current: bool}>
 */
function gbecosmolingua_le_gbe_chapter_sibling_links( $page ) {
	$context = gbecosmolingua_le_gbe_chapter_context( $page );
	if ( ! $context || ! empty( $context['is_standalone'] ) ) {
		return array();
	}

	$config   = $context['config'];
	$section  = ! empty( $context['is_hub'] ) ? $context['parent'] : $context['parent'];
	$siblings = array();
	$children = get_pages(
		array(
			'parent'      => (int) $section->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	foreach ( $children as $child ) {
		if ( ! empty( $config['slugs'] ) && ! in_array( $child->post_name, $config['slugs'], true ) ) {
			continue;
		}
		$siblings[] = array(
			'url'     => get_permalink( $child ),
			'label'   => $child->post_title,
			'current' => (int) $child->ID === (int) $page->ID,
		);
	}

	return $siblings;
}

/**
 * HTML corps chapitre.
 *
 * @param WP_Post|null $page Page.
 * @return string
 */
function gbecosmolingua_le_gbe_chapter_body_html( $page = null ) {
	if ( ! $page instanceof WP_Post ) {
		$page = get_queried_object();
	}

	$context = gbecosmolingua_le_gbe_chapter_context( $page );
	if ( ! $context ) {
		return '';
	}

	$config   = $context['config'];
	$siblings = gbecosmolingua_le_gbe_chapter_sibling_links( $page );
	$is_hub   = ! empty( $context['is_hub'] );
	$is_standalone = ! empty( $context['is_standalone'] );
	if ( $is_hub || $is_standalone ) {
		$back_url   = home_url( '/le-gbe/' );
		$back_label = $is_standalone && ! empty( $context['config']['back_label'] )
			? $context['config']['back_label']
			: __( '← Retour Gbe', 'gbecosmolingua' );
	} else {
		$back_url   = home_url( trailingslashit( $config['parent_path'] ) );
		$back_label = $config['back_label'];
	}

	ob_start();
	?>
	<div class="gbe-chapter-wrap">
		<?php if ( ! empty( $siblings ) ) : ?>
			<nav class="gbe-chapter-siblings" aria-label="<?php echo esc_attr( $config['nav_aria'] ); ?>"><?php
			foreach ( $siblings as $sibling ) {
				$class   = 'gbe-chapter-siblings__tab' . ( $sibling['current'] ? ' is-active' : '' );
				$current = $sibling['current'] ? ' aria-current="page"' : '';
				echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $sibling['url'] ) . '"' . $current . '>';
				echo esc_html( $sibling['label'] );
				echo '</a>';
			}
			?></nav>
		<?php endif; ?>

		<article class="gbe-chapter-article alignwide">
			<?php
			$content = '';
			if ( function_exists( 'gbe_le_gbe_chapter_runtime_content' ) ) {
				$content = gbe_le_gbe_chapter_runtime_content( $page );
			}
			if ( ! $content ) {
				$content = $page->post_content;
			}
			$content = do_shortcode( $content );
			$content = wptexturize( $content );
			$content = convert_smilies( $content );
			$content = wp_filter_content_tags( $content );
			echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</article>

		<div class="gbe-chapter-back alignwide">
			<a class="gbe-chapter-back__btn" href="<?php echo esc_url( $back_url ); ?>">
				<?php echo esc_html( $back_label ); ?>
			</a>
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Shortcode bannière chapitre.
 *
 * @return string
 */
function gbecosmolingua_shortcode_le_gbe_chapter_hero() {
	return gbecosmolingua_le_gbe_chapter_hero_html();
}

/**
 * Shortcode corps chapitre.
 *
 * @return string
 */
function gbecosmolingua_shortcode_le_gbe_chapter_body() {
	return gbecosmolingua_le_gbe_chapter_body_html();
}

/**
 * Enregistre les shortcodes chapitre.
 */
function gbecosmolingua_register_le_gbe_chapter_shortcodes() {
	add_shortcode( 'gbe_le_gbe_chapter_hero', 'gbecosmolingua_shortcode_le_gbe_chapter_hero' );
	add_shortcode( 'gbe_le_gbe_chapter_body', 'gbecosmolingua_shortcode_le_gbe_chapter_body' );
}
add_action( 'init', 'gbecosmolingua_register_le_gbe_chapter_shortcodes' );

/**
 * Évite wpautop() du bloc core/shortcode sur les chapitres Gbe (HTML déjà structuré).
 *
 * @param string|null $pre_render Sortie anticipée.
 * @param array       $block        Bloc Gutenberg.
 * @return string|null
 */
function gbecosmolingua_pre_render_le_gbe_chapter_shortcode_block( $pre_render, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/shortcode' ) {
		return $pre_render;
	}

	$inner = '';
	if ( ! empty( $block['innerContent'] ) && is_array( $block['innerContent'] ) ) {
		$inner = implode( '', $block['innerContent'] );
	}
	if ( '' === trim( $inner ) && ! empty( $block['innerHTML'] ) ) {
		$inner = (string) $block['innerHTML'];
	}

	$inner = trim( $inner );

	if ( '[gbe_le_gbe_chapter_hero]' === $inner ) {
		return gbecosmolingua_shortcode_le_gbe_chapter_hero();
	}
	if ( '[gbe_le_gbe_chapter_body]' === $inner ) {
		return gbecosmolingua_shortcode_le_gbe_chapter_body();
	}

	// do_shortcode() développe le modèle avant do_blocks() ; core/shortcode applique wpautop() ensuite.
	if ( str_contains( $inner, 'gbe-chapter-wrap' ) || str_contains( $inner, 'gbe-chapter-hero__inner' ) ) {
		return $inner;
	}

	return $pre_render;
}
add_filter( 'pre_render_block', 'gbecosmolingua_pre_render_le_gbe_chapter_shortcode_block', 10, 2 );

/**
 * Assigne le modèle chapitre aux pages Gbe configurées.
 */
function gbecosmolingua_assign_le_gbe_chapter_templates() {
	$flag = 'gbecosmolingua_le_gbe_chapter_tpl5_' . GBECOSMOLINGUA_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}

	foreach ( gbecosmolingua_le_gbe_chapter_paths() as $path ) {
		$page = get_page_by_path( $path, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-le-gbe-chapter' );
		}
	}

	update_option( $flag, 1 );
}
add_action( 'init', 'gbecosmolingua_assign_le_gbe_chapter_templates', 26 );
