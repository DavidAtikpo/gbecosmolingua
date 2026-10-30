<?php
/**
 * Helpers hub Onomastique (Xótùtù).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL page Onomastique.
 *
 * @param string $slug            Slug rubrique (anthroponymie…).
 * @param string $child_slug      Slug intermédiaire optionnel.
 * @param string $grandchild_slug Slug feuille optionnel.
 */
function gbecosmolingua_onomastique_page_url( $slug = '', $child_slug = '', $grandchild_slug = '' ) {
	$path = 'xotutu/onomastique';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	if ( $grandchild_slug ) {
		$path .= '/' . ltrim( (string) $grandchild_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * Image hub (dossier xotutu).
 *
 * @param string $filename Nom de fichier.
 */
function gbecosmolingua_onomastique_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$path     = get_stylesheet_directory() . '/assets/images/xotutu/' . $filename;
	if ( file_exists( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/xotutu/' . $filename;
	}
	return '';
}

/**
 * Variable CSS image Onomastique.
 *
 * @param string $filename Fichier.
 * @param string $var_name Variable CSS.
 */
function gbecosmolingua_onomastique_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_onomastique_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * Onglets de navigation rapide.
 *
 * @return array<int, array{label: string, id: string, url: string}>
 */
function gbecosmolingua_onomastique_nav_tabs() {
	return array(
		array(
			'label' => __( 'Anthroponymie', 'gbecosmolingua' ),
			'id'    => 'gbe-onomastique-anthroponymie',
			'url'   => gbecosmolingua_onomastique_page_url( 'anthroponymie' ),
		),
		array(
			'label' => __( 'Toponymie', 'gbecosmolingua' ),
			'id'    => 'gbe-onomastique-toponymie',
			'url'   => gbecosmolingua_onomastique_page_url( 'toponymie' ),
		),
		array(
			'label' => __( 'Hydronymie', 'gbecosmolingua' ),
			'id'    => 'gbe-onomastique-hydronymie',
			'url'   => gbecosmolingua_onomastique_page_url( 'hydronymie' ),
		),
		array(
			'label' => __( 'Ethnonymie', 'gbecosmolingua' ),
			'id'    => 'gbe-onomastique-ethnonymie',
			'url'   => gbecosmolingua_onomastique_page_url( 'ethnonymie' ),
		),
		array(
			'label' => __( 'Théonymie', 'gbecosmolingua' ),
			'id'    => 'gbe-onomastique-theonymie',
			'url'   => gbecosmolingua_onomastique_page_url( 'theonymie' ),
		),
	);
}

/**
 * Item sous-thème pour le hub.
 *
 * @param string $label           Libellé.
 * @param string $slug            Rubrique.
 * @param string $child_slug      Enfant optionnel.
 * @param string $grandchild_slug Petit-enfant optionnel.
 * @return array<string, string>
 */
function gbecosmolingua_onomastique_hub_item( $label, $slug, $child_slug = '', $grandchild_slug = '' ) {
	return array(
		'label'           => $label,
		'slug'            => $slug,
		'child_slug'      => $child_slug,
		'grandchild_slug' => $grandchild_slug,
		'url'             => gbecosmolingua_onomastique_page_url( $slug, $child_slug, $grandchild_slug ),
	);
}

/**
 * Sous-thèmes aplatis depuis les pages WordPress.
 *
 * @param int    $parent_page_id ID page rubrique.
 * @param string $base_path      Chemin sans domaine.
 * @return array<int, array<string, string>>
 */
function gbecosmolingua_onomastique_topics_from_children( $parent_page_id, $base_path ) {
	$topics = array();
	$kids   = get_pages(
		array(
			'parent'      => (int) $parent_page_id,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	foreach ( $kids as $kid ) {
		$kid_path = trim( $base_path . '/' . $kid->post_name, '/' );
		$leaves   = get_pages(
			array(
				'parent'      => (int) $kid->ID,
				'sort_column' => 'menu_order,post_title',
				'post_status' => 'publish',
			)
		);

		if ( $leaves ) {
			foreach ( $leaves as $leaf ) {
				$topics[] = array(
					'label' => $leaf->post_title,
					'url'   => home_url( trailingslashit( $kid_path . '/' . $leaf->post_name ) ),
				);
			}
		} else {
			$topics[] = array(
				'label' => $kid->post_title,
				'url'   => home_url( trailingslashit( $kid_path ) ),
			);
		}
	}

	return $topics;
}

/**
 * Sections hub (fallback).
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_onomastique_hub_sections_fallback() {
	$item = 'gbecosmolingua_onomastique_hub_item';

	return array(
		array(
			'id'     => 'gbe-onomastique-anthroponymie',
			'slug'   => 'anthroponymie',
			'title'  => __( 'Anthroponymie', 'gbecosmolingua' ),
			'intro'  => __( 'Noms de personnes partagés entre sections — Fáyínnú, Alixonú, Tóvíyínkú, Xomɛyan…', 'gbecosmolingua' ),
			'mod'    => 'anthroponymie',
			'image'  => 'hero-orality.jpg',
			'items'  => array(
				$item( __( 'Prénoms', 'gbecosmolingua' ), 'anthroponymie', 'noms-de-personnes', 'prenoms' ),
				$item( __( 'Noms lignagers', 'gbecosmolingua' ), 'anthroponymie', 'noms-de-personnes', 'noms-lignagers' ),
				$item( __( 'Noms initiatiques', 'gbecosmolingua' ), 'anthroponymie', 'noms-de-personnes', 'noms-initiatiques' ),
				$item( __( 'Noms circonstanciels', 'gbecosmolingua' ), 'anthroponymie', 'noms-de-personnes', 'noms-circonstanciels' ),
			),
		),
		array(
			'id'     => 'gbe-onomastique-toponymie',
			'slug'   => 'toponymie',
			'title'  => __( 'Toponymie', 'gbecosmolingua' ),
			'intro'  => __( 'Toponymes communs — Kóme, Lókosa, Atitongon, Se… (Vhe, Gen, Ajá, Fon, Phla-Pherá).', 'gbecosmolingua' ),
			'mod'    => 'toponymie',
			'image'  => 'collection-docs.jpg',
			'items'  => array(
				$item( __( 'Villages', 'gbecosmolingua' ), 'toponymie', 'noms-de-lieux', 'villages' ),
				$item( __( 'Villes', 'gbecosmolingua' ), 'toponymie', 'noms-de-lieux', 'villes' ),
				$item( __( 'Lieux sacrés', 'gbecosmolingua' ), 'toponymie', 'noms-de-lieux', 'lieux-sacres' ),
				$item( __( 'Montagnes', 'gbecosmolingua' ), 'toponymie', 'noms-de-lieux', 'montagnes' ),
				$item( __( 'Rivières', 'gbecosmolingua' ), 'toponymie', 'noms-de-lieux', 'rivieres' ),
			),
		),
		array(
			'id'     => 'gbe-onomastique-hydronymie',
			'slug'   => 'hydronymie',
			'title'  => __( 'Hydronymie', 'gbecosmolingua' ),
			'intro'  => __( 'Dénominations des cours d\'eau, rivières et plans d\'eau.', 'gbecosmolingua' ),
			'mod'    => 'hydronymie',
			'image'  => 'collection-photo.jpg',
			'items'  => array(
				$item( __( 'Cours d\'eau', 'gbecosmolingua' ), 'hydronymie', 'cours-deau' ),
			),
		),
		array(
			'id'     => 'gbe-onomastique-ethnonymie',
			'slug'   => 'ethnonymie',
			'title'  => __( 'Ethnonymie', 'gbecosmolingua' ),
			'intro'  => __( 'Autodésignations — suffixes -gbe (parler), -vi/-no/-li (communauté) ; Mina, Popo, Danxomegbe.', 'gbecosmolingua' ),
			'mod'    => 'ethnonymie',
			'image'  => 'collection-oral.jpg',
			'items'  => array(
				$item( __( 'Noms des peuples', 'gbecosmolingua' ), 'ethnonymie', 'noms-des-peuples' ),
			),
		),
		array(
			'id'     => 'gbe-onomastique-theonymie',
			'slug'   => 'theonymie',
			'title'  => __( 'Théonymie', 'gbecosmolingua' ),
			'intro'  => __( 'Noms des divinités et entités sacrées du panthéon gbe.', 'gbecosmolingua' ),
			'mod'    => 'theonymie',
			'image'  => 'collection-chants.jpg',
			'items'  => array(
				$item( __( 'Noms des divinités', 'gbecosmolingua' ), 'theonymie', 'noms-des-divinites' ),
			),
		),
	);
}

/**
 * Sections hub depuis WordPress ou fallback.
 *
 * @return array<int, array<string, mixed>>
 */
function gbecosmolingua_onomastique_hub_sections() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$parent = get_page_by_path( 'xotutu/onomastique', OBJECT, 'page' );
	if ( ! $parent ) {
		$cache = gbecosmolingua_onomastique_hub_sections_fallback();
		return $cache;
	}

	$fallback = gbecosmolingua_onomastique_hub_sections_fallback();
	$by_slug  = array();
	foreach ( $fallback as $section ) {
		$by_slug[ $section['slug'] ] = $section;
	}

	$sections = array();
	$children = get_pages(
		array(
			'parent'      => (int) $parent->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	foreach ( $children as $child ) {
		$slug = $child->post_name;
		if ( ! isset( $by_slug[ $slug ] ) ) {
			continue;
		}
		$section           = $by_slug[ $slug ];
		$section['title']  = $child->post_title;
		$section['intro']  = gbecosmolingua_public_page_excerpt_text( $child ) ?: $section['intro'];
		$topics            = gbecosmolingua_onomastique_topics_from_children( (int) $child->ID, 'xotutu/onomastique/' . $slug );
		if ( $topics ) {
			$section['items'] = $topics;
		}
		$sections[] = $section;
	}

	if ( empty( $sections ) ) {
		$cache = $fallback;
		return $cache;
	}

	$cache = $sections;
	return $cache;
}

/**
 * Style média section.
 *
 * @param array<string, mixed> $section Section.
 */
function gbecosmolingua_onomastique_section_media_style( $section ) {
	if ( ! empty( $section['image'] ) ) {
		return gbecosmolingua_onomastique_image_style( $section['image'], '--gbe-culture-section-image' );
	}
	return '';
}

/**
 * Chapô sous-thème.
 *
 * @param string $label Libellé.
 */
function gbecosmolingua_onomastique_subtopic_blurb( $label ) {
	return sprintf(
		/* translators: %s: topic label */
		__( 'Explorer « %s » dans l\'onomastique gbe.', 'gbecosmolingua' ),
		$label
	);
}

/**
 * Grille sous-thèmes.
 *
 * @param array<string, mixed> $section Section hub.
 */
function gbecosmolingua_onomastique_render_subtopics( $section ) {
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
				$url = ! empty( $item['url'] )
					? $item['url']
					: gbecosmolingua_onomastique_page_url(
						$item['slug'] ?? $section['slug'],
						$item['child_slug'] ?? '',
						$item['grandchild_slug'] ?? ''
					);
				$style  = gbecosmolingua_onomastique_image_style( $section['image'] ?? 'hero-orality.jpg', '--gbe-culture-section-image' );
				$anchor = sanitize_title( $item['label'] );
				?>
				<article class="gbe-culture-subtopic" id="<?php echo esc_attr( $section['id'] . '-' . $anchor ); ?>">
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( gbecosmolingua_onomastique_subtopic_blurb( $item['label'] ) ); ?></p>
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
 * Onglets de navigation Onomastique.
 */
function gbecosmolingua_onomastique_render_nav_tabs() {
	$tabs = gbecosmolingua_onomastique_nav_tabs();
	if ( empty( $tabs ) ) {
		return;
	}
	?>
	<nav class="gbe-onomastique-nav" aria-label="<?php esc_attr_e( 'Rubriques onomastiques', 'gbecosmolingua' ); ?>">
		<?php foreach ( $tabs as $tab ) : ?>
			<a class="gbe-onomastique-nav__tab" href="#<?php echo esc_attr( $tab['id'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php
}
