<?php
/**
 * Registre et rendu des hubs rubriques (Séjours, Partenaires, etc.).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Configurations des hubs.
 *
 * @return array<string, array<string, mixed>>
 */
function gbecosmolingua_hub_configs() {
	static $configs = null;
	if ( null !== $configs ) {
		return $configs;
	}

	$item = function ( $label, $parent, $child = '' ) {
		return array(
			'label'      => $label,
			'slug'       => $parent,
			'child_slug' => $child ? $child : sanitize_title( $label ),
		);
	};

	$configs = array(
		'sejours'     => array(
			'parent_slug'    => 'sejours-et-mobilite',
			'template'       => 'page-sejours-mobilite',
			'image_dir'      => 'sejours-mobilite',
			'main_class'     => 'gbe-main--sejours',
			'hero_image'     => 'hero-sejours.jpg',
			'hero_title'     => __( 'Séjours et Mobilité', 'gbecosmolingua' ),
			'hero_lead'      => __( 'Immersion linguistique, tourisme culturel responsable et mobilité universitaire au cœur des cultures gbe.', 'gbecosmolingua' ),
			'hero_primary'   => array(
				'label' => __( 'Programmes d\'immersion', 'gbecosmolingua' ),
				'url'   => '#gbe-hub-sejours-immersion-linguistique',
			),
			'hero_secondary' => array(
				'label' => __( 'Mobilité universitaire', 'gbecosmolingua' ),
				'url'   => 'sejours-et-mobilite/mobilite-universitaire/',
			),
			'intro'          => __( 'Découvrez les cultures gbe sur le terrain — séjours linguistiques, stages, programmes saisonniers et échanges avec les communautés locales.', 'gbecosmolingua' ),
			'hub_order'      => array(
				'immersion-linguistique',
				'tourisme-culturel',
				'mobilite-universitaire',
				'stages',
				'programmes-ete',
				'programmes-hiver',
			),
			'feature_slugs'  => array( 'stages', 'programmes-ete', 'programmes-hiver' ),
			'fallback'       => array(
				array(
					'id' => 'gbe-hub-sejours-immersion-linguistique', 'title' => __( 'Immersion linguistique', 'gbecosmolingua' ), 'slug' => 'immersion-linguistique',
					'thumb' => 'musique.jpg', 'mod' => 'immersion', 'layout' => 'split',
					'intro' => __( 'Français, éwé, gen/mina, fon — apprendre en contexte.', 'gbecosmolingua' ),
					'items' => array(
						$item( 'Français', 'immersion-linguistique', 'francais' ),
						$item( 'Éwé', 'immersion-linguistique', 'ewe' ),
						$item( 'Gen/Mina', 'immersion-linguistique', 'gen-mina' ),
						$item( 'Fon', 'immersion-linguistique', 'fon' ),
					),
				),
				array(
					'id' => 'gbe-hub-sejours-tourisme', 'title' => __( 'Tourisme culturel', 'gbecosmolingua' ), 'slug' => 'tourisme-culturel',
					'thumb' => 'danse.jpg', 'mod' => 'tourisme', 'layout' => 'split',
					'intro' => __( 'Circuits patrimoniaux et tourisme communautaire.', 'gbecosmolingua' ),
					'items' => array(
						$item( 'Circuits patrimoniaux', 'tourisme-culturel' ),
						$item( 'Tourisme communautaire', 'tourisme-culturel' ),
						$item( 'Écotourisme', 'tourisme-culturel' ),
						$item( 'Découverte des terroirs', 'tourisme-culturel' ),
					),
				),
				array(
					'id' => 'gbe-hub-sejours-mobilite', 'title' => __( 'Mobilité universitaire', 'gbecosmolingua' ), 'slug' => 'mobilite-universitaire',
					'thumb' => 'architecture.jpg', 'mod' => 'mobilite', 'layout' => 'split',
					'intro' => __( 'Orientation, réseaux partenaires et programmes de recherche.', 'gbecosmolingua' ),
					'items' => array(
						$item( 'Orientation universitaire', 'mobilite-universitaire' ),
						$item( 'Réseaux partenaires', 'mobilite-universitaire' ),
						$item( 'Programmes de recherche', 'mobilite-universitaire' ),
					),
				),
				array(
					'id' => 'gbe-hub-sejours-stages', 'title' => __( 'Stages', 'gbecosmolingua' ), 'slug' => 'stages',
					'thumb' => 'fetes.jpg', 'mod' => 'stages', 'layout' => 'feature',
					'intro' => __( 'Stages de terrain, de recherche et d\'immersion culturelle.', 'gbecosmolingua' ), 'items' => array(),
				),
				array(
					'id' => 'gbe-hub-sejours-ete', 'title' => __( 'Programmes d\'été', 'gbecosmolingua' ), 'slug' => 'programmes-ete',
					'thumb' => 'gastronomie.jpg', 'mod' => 'ete', 'layout' => 'feature',
					'intro' => __( 'Séjours estivaux d\'immersion linguistique et culturelle.', 'gbecosmolingua' ), 'items' => array(),
				),
				array(
					'id' => 'gbe-hub-sejours-hiver', 'title' => __( 'Programmes d\'hiver', 'gbecosmolingua' ), 'slug' => 'programmes-hiver',
					'thumb' => 'croyances-shrine.jpg', 'mod' => 'hiver', 'layout' => 'feature',
					'intro' => __( 'Programmes hivernaux d\'échanges et de formation.', 'gbecosmolingua' ), 'items' => array(),
				),
			),
			'cta'            => array(
				'title' => __( 'Préparer votre séjour', 'gbecosmolingua' ),
				'text'  => __( 'Contactez-nous pour construire un parcours d\'immersion adapté à votre projet.', 'gbecosmolingua' ),
				'url'   => home_url( '/nous-soutenir/proposer-un-projet/' ),
				'label' => __( 'Nous écrire', 'gbecosmolingua' ),
			),
		),
		'partenaires' => array(
			'parent_slug'    => 'partenaires',
			'template'       => 'page-partenaires',
			'image_dir'      => 'partenaires',
			'main_class'     => 'gbe-main--partenaires',
			'hero_title'     => __( 'Partenaires', 'gbecosmolingua' ),
			'hero_lead'      => __( 'Réseau international de coopération académique, culturelle et institutionnelle.', 'gbecosmolingua' ),
			'hero_primary'   => array(
				'label' => __( 'Annuaire des partenaires', 'gbecosmolingua' ),
				'url'   => '#gbe-hub-partenaires-annuaire',
			),
			'hero_secondary' => array(
				'label' => __( 'Devenir partenaire', 'gbecosmolingua' ),
				'url'   => 'nous-soutenir/devenir-partenaire/',
			),
			'intro'          => __( 'Universités, organisations internationales, fondations et diaspora — ensemble pour les langues et patrimoines gbe.', 'gbecosmolingua' ),
			'hub_order'      => array(
				'universites-laboratoires',
				'unesco',
				'oif',
				'cedeao-union-africaine',
				'ambassades-centres-culturels',
				'fondations',
				'diaspora-gbe',
			),
			'feature_slugs'  => array( 'unesco', 'oif', 'cedeao-union-africaine', 'fondations', 'diaspora-gbe' ),
			'annuaire'       => true,
			'fallback'       => array(),
			'cta'            => array(
				'title' => __( 'Rejoindre le réseau', 'gbecosmolingua' ),
				'text'  => __( 'Institution, laboratoire ou association : proposons une collaboration.', 'gbecosmolingua' ),
				'url'   => home_url( '/nous-soutenir/devenir-partenaire/' ),
				'label' => __( 'Devenir partenaire', 'gbecosmolingua' ),
			),
		),
		'soutenir'    => array(
			'parent_slug'    => 'nous-soutenir',
			'template'       => 'page-nous-soutenir',
			'image_dir'      => 'nous-soutenir',
			'main_class'     => 'gbe-main--soutenir',
			'hero_title'     => __( 'Nous Soutenir', 'gbecosmolingua' ),
			'hero_lead'      => __( 'Rejoignez le projet GbeCosmoLingua et contribuez à la préservation des langues et patrimoines gbe.', 'gbecosmolingua' ),
			'hero_primary'   => array(
				'label' => __( 'Faire un don', 'gbecosmolingua' ),
				'url'   => 'nous-soutenir/faire-un-don/',
			),
			'hero_secondary' => array(
				'label' => __( 'Adhérer', 'gbecosmolingua' ),
				'url'   => 'nous-soutenir/adherer/',
			),
			'intro'          => __( 'Adhésion, mécénat, dons, projets et accueil de chercheurs — chaque geste renforce la transmission du patrimoine gbe.', 'gbecosmolingua' ),
			'hub_order'      => array(
				'adherer',
				'devenir-partenaire',
				'devenir-mecene',
				'faire-un-don',
				'proposer-un-projet',
				'accueillir-un-chercheur',
			),
			'feature_slugs'  => array(
				'adherer',
				'devenir-partenaire',
				'devenir-mecene',
				'faire-un-don',
				'proposer-un-projet',
				'accueillir-un-chercheur',
			),
			'fallback'       => array(),
			'cta'            => array(
				'title' => __( 'Une question ?', 'gbecosmolingua' ),
				'text'  => __( 'Notre équipe vous accompagne pour trouver la formule de soutien adaptée.', 'gbecosmolingua' ),
				'url'   => home_url( '/nous-soutenir/adherer/' ),
				'label' => __( 'Contact', 'gbecosmolingua' ),
			),
		),
		'philosophie' => array(
			'parent_slug' => 'notre-philosophie',
			'template'    => 'page-philosophie',
			'image_dir'   => 'philosophie',
			'main_class'  => 'gbe-main--philosophie',
			'type'        => 'philosophie',
		),
	);

	return $configs;
}

/**
 * @param string $parent_slug Slug racine.
 * @param string $slug        Enfant.
 * @param string $child_slug  Petit-enfant.
 */
function gbecosmolingua_hub_page_url( $parent_slug, $slug = '', $child_slug = '' ) {
	$path = $parent_slug;
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

function gbecosmolingua_hub_image( $dir, $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$rel      = trim( $dir, '/' ) . '/' . $filename;
	$path     = get_stylesheet_directory() . '/assets/images/' . $rel;
	if ( file_exists( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/' . $rel;
	}
	return gbecosmolingua_culture_image( $filename );
}

function gbecosmolingua_hub_image_style( $dir, $filename, $var = '--gbe-hub-hero-image' ) {
	$url = gbecosmolingua_hub_image( $dir, $filename );
	if ( ! $url ) {
		return '';
	}
	return $var . ':url(' . esc_url( $url ) . ');';
}

function gbecosmolingua_hub_build_fallback_from_config( $hub_key ) {
	return array();
}

function gbecosmolingua_hub_sections( $hub_key ) {
	$configs = gbecosmolingua_hub_configs();
	if ( ! isset( $configs[ $hub_key ] ) ) {
		return array();
	}
	$config = $configs[ $hub_key ];
	$parent = get_page_by_path( $config['parent_slug'] );
	if ( ! $parent ) {
		return array();
	}

	$children = get_pages(
		array(
			'parent'      => $parent->ID,
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
		)
	);

	if ( empty( $children ) ) {
		return array();
	}

	$feature = isset( $config['feature_slugs'] ) ? $config['feature_slugs'] : array();
	$by_slug = array();
	foreach ( $children as $child ) {
		$slug   = $child->post_name;
		$topics = array();
		$kids   = get_pages(
			array(
				'parent'      => $child->ID,
				'sort_column' => 'menu_order,post_title',
				'post_status' => 'publish',
			)
		);
		foreach ( $kids as $kid ) {
			$topics[] = array(
				'label'      => $kid->post_title,
				'slug'       => $slug,
				'child_slug' => $kid->post_name,
				'page_id'    => $kid->ID,
			);
		}
		if ( empty( $topics ) ) {
			$topics = gbecosmolingua_culture_extract_topics( $child->post_content, $slug );
			foreach ( $topics as $i => $topic ) {
				$topics[ $i ]['child_slug'] = sanitize_title( $topic['label'] );
			}
		}

		$intro = gbecosmolingua_culture_extract_intro( $child->post_content );
		if ( '' === $intro ) {
			$intro = wp_trim_words( wp_strip_all_tags( $child->post_content ), 32, '…' );
		}

		$by_slug[ $slug ] = array(
			'id'      => 'gbe-hub-' . sanitize_title( $hub_key . '-' . $slug ),
			'page_id' => (int) $child->ID,
			'title'   => $child->post_title,
			'slug'    => $slug,
			'thumb'   => '',
			'mod'     => $slug,
			'layout'  => in_array( $slug, $feature, true ) ? 'feature' : 'split',
			'intro'   => $intro,
			'items'   => $topics,
		);
	}

	$ordered = array();
	foreach ( $config['hub_order'] as $slug ) {
		if ( isset( $by_slug[ $slug ] ) ) {
			$ordered[] = $by_slug[ $slug ];
			unset( $by_slug[ $slug ] );
		}
	}
	foreach ( $by_slug as $row ) {
		$ordered[] = $row;
	}

	return $ordered;
}

function gbecosmolingua_hub_resolve_url( $url ) {
	if ( 0 === strpos( $url, 'http' ) || 0 === strpos( $url, '#' ) ) {
		return $url;
	}
	return home_url( '/' . ltrim( $url, '/' ) );
}

function gbecosmolingua_hub_render_hero( $hub_key ) {
	$c    = gbecosmolingua_hub_configs()[ $hub_key ];
	$page = gbecosmolingua_public_hub_page( $c['parent_slug'] );
	if ( ! $page ) {
		return;
	}

	$style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-hub-hero-image' );
	$lead  = gbecosmolingua_public_page_excerpt_text( $page );
	?>
	<div class="wp-block-group alignfull gbe-hub-hero gbe-hub-hero--<?php echo esc_attr( $hub_key ); ?>"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
		<div class="gbe-hub-hero__inner">
			<h1 class="gbe-hub-hero__title"><?php echo esc_html( $page->post_title ); ?></h1>
			<?php if ( $lead ) : ?>
				<p class="gbe-hub-hero__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

function gbecosmolingua_hub_render_subtopics( $section, $hub_key, $parent_slug ) {
	if ( empty( $section['items'] ) ) {
		return;
	}
	$dir = gbecosmolingua_hub_configs()[ $hub_key ]['image_dir'];
	?>
	<div class="gbe-culture-subtopics">
		<h3 class="gbe-culture-subtopics__heading"><?php echo esc_html( $section['title'] ); ?></h3>
		<div class="gbe-culture-subtopics__grid">
			<?php foreach ( $section['items'] as $item ) : ?>
				<?php
				$style = ! empty( $item['page_id'] )
					? gbecosmolingua_public_featured_image_style( (int) $item['page_id'], '--gbe-culture-section-image' )
					: '';
				if ( ! empty( $item['child_slug'] ) ) {
					$url = gbecosmolingua_hub_page_url( $parent_slug, $item['slug'], $item['child_slug'] );
				} else {
					$url = gbecosmolingua_hub_page_url( $parent_slug, $item['slug'] ?: $section['slug'] );
				}
				?>
				<article class="gbe-culture-subtopic">
					<?php if ( $style ) : ?>
					<div class="gbe-culture-subtopic__media" style="<?php echo esc_attr( $style ); ?>"></div>
					<?php endif; ?>
					<div class="gbe-culture-subtopic__body">
						<h4><?php echo esc_html( $item['label'] ); ?></h4>
						<p><?php echo esc_html( sprintf( __( 'Découvrir « %s ».', 'gbecosmolingua' ), $item['label'] ) ); ?></p>
						<a class="gbe-culture-rubrique__btn gbe-culture-rubrique__btn--sm" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Découvrir', 'gbecosmolingua' ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

function gbecosmolingua_hub_render_body( $hub_key ) {
	$c           = gbecosmolingua_hub_configs()[ $hub_key ];
	$parent_slug = $c['parent_slug'];
	$sections    = gbecosmolingua_hub_sections( $hub_key );
	$image_dir   = $c['image_dir'];

	if ( ! empty( $c['annuaire'] ) ) {
		?>
		<section class="gbe-hub-annuaire alignwide" id="gbe-hub-partenaires-annuaire">
			<h2><?php esc_html_e( 'Annuaire des partenaires', 'gbecosmolingua' ); ?></h2>
			<?php echo do_shortcode( '[gbe_partenaires_list limit="48"]' ); ?>
		</section>
		<?php
	}
	?>
	<div class="gbe-culture-rubriques gbe-hub-rubriques gbe-hub-rubriques--<?php echo esc_attr( $hub_key ); ?>">
	<?php
	foreach ( $sections as $index => $section ) {
		$thumb_style = ! empty( $section['page_id'] )
			? gbecosmolingua_public_featured_image_style( (int) $section['page_id'], '--gbe-culture-section-image' )
			: '';
		$page_url    = gbecosmolingua_hub_page_url( $parent_slug, $section['slug'] );
		$reverse     = ( 1 === $index % 2 );
		$is_feature  = ( isset( $section['layout'] ) && 'feature' === $section['layout'] );
		$band_class  = 'gbe-culture-band' . ( 1 === $index % 2 ? ' gbe-culture-band--alt' : '' );
		$classes     = 'gbe-culture-rubrique gbe-culture-rubrique--split' . ( $reverse ? ' gbe-culture-rubrique--reverse' : '' ) . ( $is_feature ? ' gbe-culture-rubrique--feature' : '' );
		?>
		<div class="<?php echo esc_attr( $band_class ); ?>" id="<?php echo esc_attr( $section['id'] ); ?>">
			<div class="gbe-culture-band__inner">
				<section class="<?php echo esc_attr( $classes ); ?>">
					<?php if ( $thumb_style ) : ?>
					<div class="gbe-culture-rubrique__media gbe-culture-rubrique__media--<?php echo esc_attr( $section['mod'] ); ?>" style="<?php echo esc_attr( $thumb_style ); ?>"></div>
					<?php endif; ?>
					<div class="gbe-culture-rubrique__content">
						<h2><?php echo esc_html( $section['title'] ); ?></h2>
						<p class="gbe-culture-rubrique__lead"><?php echo esc_html( $section['intro'] ); ?></p>
						<a class="gbe-culture-rubrique__btn" href="<?php echo esc_url( $page_url ); ?>">
							<?php
							printf(
								esc_html__( 'Explorer %s', 'gbecosmolingua' ),
								esc_html( $section['title'] )
							);
							?>
						</a>
					</div>
				</section>
				<?php gbecosmolingua_hub_render_subtopics( $section, $hub_key, $parent_slug ); ?>
			</div>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}

function gbecosmolingua_hub_render_philosophie() {
	$page = gbecosmolingua_public_hub_page( 'notre-philosophie' );
	if ( ! $page ) {
		return;
	}

	$style = gbecosmolingua_public_featured_image_style( $page->ID, '--gbe-hub-hero-image' );
	$lead  = gbecosmolingua_public_page_excerpt_text( $page );
	$content = gbecosmolingua_public_page_intro_html( $page );
	?>
	<div class="wp-block-group alignfull gbe-hub-hero gbe-hub-hero--philosophie"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
		<div class="gbe-hub-hero__inner">
			<h1 class="gbe-hub-hero__title"><?php echo esc_html( $page->post_title ); ?></h1>
			<?php if ( $lead ) : ?>
				<p class="gbe-hub-hero__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
			<div class="gbe-hub-hero__actions">
				<a class="gbe-hub-hero__btn gbe-hub-hero__btn--outline" href="#philosophie"><?php esc_html_e( 'Philosophie', 'gbecosmolingua' ); ?></a>
				<a class="gbe-hub-hero__btn gbe-hub-hero__btn--outline" href="#objet"><?php esc_html_e( 'Objet', 'gbecosmolingua' ); ?></a>
				<a class="gbe-hub-hero__btn gbe-hub-hero__btn--fill" href="#missions"><?php esc_html_e( 'Missions', 'gbecosmolingua' ); ?></a>
				<a class="gbe-hub-hero__btn gbe-hub-hero__btn--outline" href="#fondateurs"><?php esc_html_e( 'Fondateurs', 'gbecosmolingua' ); ?></a>
			</div>
		</div>
	</div>
	<?php if ( $content ) : ?>
	<div class="gbe-philosophie-content alignwide">
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php endif; ?>
	<?php
}

function gbecosmolingua_hub_render_pattern( $hub_key ) {
	if ( 'philosophie' === $hub_key ) {
		gbecosmolingua_hub_render_philosophie();
		return;
	}
	?>
	<?php
	$page = gbecosmolingua_public_hub_page( gbecosmolingua_hub_configs()[ $hub_key ]['parent_slug'] );
	$intro = gbecosmolingua_public_page_intro_html( $page );
	if ( $intro ) :
		?>
	<div class="gbe-section gbe-hub-intro alignwide">
		<?php echo $intro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
		<?php
	endif;
	gbecosmolingua_hub_render_body( $hub_key );
}

/**
 * Slugs des 9 rubriques du menu principal (fallback si le plugin n'est pas chargé).
 *
 * @return string[]
 */
function gbecosmolingua_main_menu_slugs() {
	if ( class_exists( 'GBE_Le_Gbe_Hub_Admin' ) ) {
		return GBE_Le_Gbe_Hub_Admin::main_menu_slugs();
	}

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
 * Page hub du menu principal ?
 *
 * @param WP_Post|null $post Page courante.
 * @return bool
 */
function gbecosmolingua_is_main_menu_hub_page( $post = null ) {
	if ( ! is_page() ) {
		return false;
	}

	if ( ! $post instanceof WP_Post ) {
		global $post;
	}

	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	return in_array( $post->post_name, gbecosmolingua_main_menu_slugs(), true );
}
