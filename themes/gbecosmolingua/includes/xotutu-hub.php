<?php
/**
 * Helpers hub Xótùtù.
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL sous-page Xótùtù.
 *
 * @param string $slug       Slug segment.
 * @param string $child_slug Slug enfant optionnel.
 */
function gbecosmolingua_xotutu_page_url( $slug = '', $child_slug = '' ) {
	$path = 'xotutu';
	if ( $slug ) {
		$path .= '/' . ltrim( (string) $slug, '/' );
	}
	if ( $child_slug ) {
		$path .= '/' . ltrim( (string) $child_slug, '/' );
	}
	return home_url( trailingslashit( $path ) );
}

/**
 * Image hub Xótùtù.
 *
 * @param string $filename Fichier dans assets/images/xotutu/.
 */
function gbecosmolingua_xotutu_image( $filename ) {
	$filename = ltrim( (string) $filename, '/' );
	$path     = get_stylesheet_directory() . '/assets/images/xotutu/' . $filename;
	if ( file_exists( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/xotutu/' . $filename;
	}
	return gbecosmolingua_culture_image( $filename );
}

/**
 * Style CSS variable pour image Xótùtù.
 *
 * @param string $filename Fichier.
 * @param string $var_name Variable CSS.
 */
function gbecosmolingua_xotutu_image_style( $filename, $var_name ) {
	$url = gbecosmolingua_xotutu_image( $filename );
	if ( ! $url ) {
		return '';
	}
	return $var_name . ':url(' . esc_url( $url ) . ');';
}

/**
 * Image de bannière Xótùtù (heroxotutu.png prioritaire).
 *
 * @param string $var_name Variable CSS.
 * @return string
 */
function gbecosmolingua_xotutu_hero_image_style( $var_name = '--gbe-xotutu-hero-image' ) {
	$candidates = array(
		'heroxotutu.png',
		'hero-orality.jpg',
	);

	foreach ( $candidates as $file ) {
		$style = gbecosmolingua_xotutu_image_style( $file, $var_name );
		if ( $style ) {
			return $style;
		}
	}

	$home_path = get_stylesheet_directory() . '/assets/images/home/heroxotutu.png';
	if ( file_exists( $home_path ) ) {
		return $var_name . ':url(' . esc_url( get_stylesheet_directory_uri() . '/assets/images/home/heroxotutu.png' ) . ');';
	}

	return '';
}

/**
 * Collections principales (maquette).
 *
 * @return array<int, array{title: string, count: string, icon: string, url: string, mod: string, image: string}>
 */
function gbecosmolingua_xotutu_collections() {
	return array(
		array(
			'title' => __( 'Littérature orale', 'gbecosmolingua' ),
			'count' => '1 328',
			'icon'  => '📖',
			'url'   => gbecosmolingua_xotutu_page_url( 'genres-folkloriques' ),
			'mod'   => 'oral',
			'image' => 'collection-oral.jpg',
		),
		array(
			'title' => __( 'Chants traditionnels', 'gbecosmolingua' ),
			'count' => '842',
			'icon'  => '🎵',
			'url'   => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'havo-chants' ),
			'mod'   => 'chants',
			'image' => 'collection-chants.jpg',
		),
		array(
			'title' => __( 'Archives audio', 'gbecosmolingua' ),
			'count' => '5 400',
			'icon'  => '🎙',
			'url'   => gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'archives-sonores' ),
			'mod'   => 'audio',
			'image' => 'collection-audio.jpg',
		),
		array(
			'title' => __( 'Vidéos', 'gbecosmolingua' ),
			'count' => '1 200',
			'icon'  => '🎬',
			'url'   => gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'archives-audiovisuelles' ),
			'mod'   => 'video',
			'image' => 'collection-video.jpg',
		),
		array(
			'title' => __( 'Photothèque', 'gbecosmolingua' ),
			'count' => '2 350',
			'icon'  => '📷',
			'url'   => gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'phototheque' ),
			'mod'   => 'photo',
			'image' => 'collection-photo.jpg',
		),
		array(
			'title' => __( 'Cartes et documents', 'gbecosmolingua' ),
			'count' => '680',
			'icon'  => '🗺',
			'url'   => gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'documents-historiques' ),
			'mod'   => 'docs',
			'image' => 'collection-docs.jpg',
		),
	);
}

/**
 * Genres folkloriques mis en avant (maquette).
 *
 * @return array<int, array{title: string, subtitle: string, count: string, url: string}>
 */
function gbecosmolingua_xotutu_genres_highlight() {
	return array(
		array(
			'title'    => 'Àdzò',
			'subtitle' => __( 'Devinettes', 'gbecosmolingua' ),
			'count'    => '124',
			'url'      => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'adzo-devinettes' ),
		),
		array(
			'title'    => 'Ègli',
			'subtitle' => __( 'Contes', 'gbecosmolingua' ),
			'count'    => '386',
			'url'      => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'egli-contes' ),
		),
		array(
			'title'    => 'Àjèwǔ',
			'subtitle' => __( 'Proverbes et maximes', 'gbecosmolingua' ),
			'count'    => '512',
			'url'      => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'lododowo-proverbes' ),
		),
		array(
			'title'    => 'Èdù',
			'subtitle' => __( 'Messages divinatoires', 'gbecosmolingua' ),
			'count'    => '98',
			'url'      => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'edu-messages-divinatoires' ),
		),
		array(
			'title'    => 'Hàwò',
			'subtitle' => __( 'Chants', 'gbecosmolingua' ),
			'count'    => '842',
			'url'      => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'havo-chants' ),
		),
		array(
			'title'    => 'Àlòbalo',
			'subtitle' => __( 'Énigmes et paradoxes', 'gbecosmolingua' ),
			'count'    => '76',
			'url'      => gbecosmolingua_xotutu_page_url( 'genres-folkloriques', 'alobalo-enigmes' ),
		),
	);
}

/**
 * Thèmes terminologiques (explorer par thème).
 *
 * @return array<int, array{label: string, url: string}>
 */
function gbecosmolingua_xotutu_theme_pills() {
	$pills = array();
	$items = array(
		array( __( 'Anthroponymie', 'gbecosmolingua' ), 'onomastique', 'anthroponymie' ),
		array( __( 'Toponymie', 'gbecosmolingua' ), 'onomastique', 'toponymie' ),
		array( __( 'Ethnolinguistique', 'gbecosmolingua' ), 'questions-terminologiques', 'ethnolinguistique' ),
		array( __( 'Ethnopoétique', 'gbecosmolingua' ), 'questions-terminologiques', 'ethnopoetique' ),
		array( __( 'Littérature orale', 'gbecosmolingua' ), 'questions-terminologiques', 'litterature-orale' ),
		array( __( 'Patrimoine immatériel', 'gbecosmolingua' ), 'questions-terminologiques', 'patrimoine-immateriel' ),
		array( __( 'Performance orale', 'gbecosmolingua' ), 'questions-terminologiques', 'performance-orale' ),
		array( __( 'Tradition orale', 'gbecosmolingua' ), 'questions-terminologiques', 'tradition-orale' ),
		array( __( 'Spiritualités', 'gbecosmolingua' ), 'tradition-orale-patrimoines', '' ),
	);
	foreach ( $items as $row ) {
		$url = $row[2] ? gbecosmolingua_xotutu_page_url( $row[1], $row[2] ) : gbecosmolingua_xotutu_page_url( $row[1] );
		$pills[] = array(
			'label' => $row[0],
			'url'   => $url,
		);
	}
	return $pills;
}

/**
 * Statistiques patrimoine (maquette / dynamique partielle).
 *
 * @return array<int, array{value: string, label: string, stat?: int, suffix?: string}>
 */
function gbecosmolingua_xotutu_stats() {
	$oral_count = wp_count_posts( 'genre_oral' );
	$oral       = isset( $oral_count->publish ) ? (int) $oral_count->publish : 0;
	$ress_count = wp_count_posts( 'ressource' );
	$ress       = isset( $ress_count->publish ) ? (int) $ress_count->publish : 0;

	$docs = max( 18000, $oral + $ress + 120 );

	return array(
		array(
			'value'  => number_format_i18n( $docs ) . '+',
			'label'  => __( 'Documents', 'gbecosmolingua' ),
			'stat'   => $docs,
			'suffix' => '+',
		),
		array(
			'value' => '2 350+',
			'label' => __( 'Photos', 'gbecosmolingua' ),
			'stat'  => 2350,
			'suffix' => '+',
		),
		array(
			'value' => '5 400+',
			'label' => __( 'Enregistrements audio', 'gbecosmolingua' ),
			'stat'  => 5400,
			'suffix' => '+',
		),
		array(
			'value' => '350+',
			'label' => __( 'Chercheurs', 'gbecosmolingua' ),
			'stat'  => 350,
			'suffix' => '+',
		),
		array(
			'value' => '1 200+',
			'label' => __( 'Vidéos', 'gbecosmolingua' ),
			'stat'  => 1200,
			'suffix' => '+',
		),
		array(
			'value' => '68+',
			'label' => __( 'Contributeurs', 'gbecosmolingua' ),
			'stat'  => 68,
			'suffix' => '+',
		),
	);
}

/**
 * Ressource mise en avant (dernier genre oral publié ou repli démo).
 *
 * @return array{title: string, meta: string, excerpt: string, url: string, has_audio: bool}
 */
function gbecosmolingua_xotutu_featured_resource() {
	$query = new WP_Query(
		array(
			'post_type'      => 'genre_oral',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( $query->have_posts() ) {
		$query->the_post();
		$id     = get_the_ID();
		$genres = get_the_terms( $id, 'genre_xotutu' );
		$meta   = 'Xótùtù';
		if ( $genres && ! is_wp_error( $genres ) ) {
			$meta = $genres[0]->name;
		}
		$audio = class_exists( 'GBE_Frontend' ) ? GBE_Frontend::get_meta( $id, 'audio_id' ) : '';
		$data  = array(
			'title'     => get_the_title(),
			'meta'      => $meta,
			'excerpt'   => has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 28, '…' ),
			'url'       => get_permalink( $id ),
			'has_audio' => (bool) $audio,
		);
		wp_reset_postdata();
		return $data;
	}

	return array(
		'title'     => __( 'Le Lièvre et la Tortue', 'gbecosmolingua' ),
		'meta'      => 'Fon · ' . __( 'Conte traditionnel', 'gbecosmolingua' ),
		'excerpt'   => __( 'Un classique du répertoire narratif gbe, transmis de génération en génération — audio, transcription et traduction disponibles dans la bibliothèque numérique.', 'gbecosmolingua' ),
		'url'       => gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'bibliotheque-numerique-xotutu' ),
		'has_audio' => true,
	);
}

/**
 * Barre de recherche hub.
 */
function gbecosmolingua_xotutu_render_search() {
	$archive = get_post_type_archive_link( 'genre_oral' );
	if ( ! $archive ) {
		$archive = gbecosmolingua_xotutu_page_url( 'archives-numeriques', 'bibliotheque-numerique-xotutu' );
	}
	$q = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
	?>
	<div class="gbe-xotutu-search-wrap">
		<form class="gbe-xotutu-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
			<input type="hidden" name="post_type" value="genre_oral">
			<label class="screen-reader-text" for="gbe-xotutu-search-input"><?php esc_html_e( 'Rechercher dans Xótùtù', 'gbecosmolingua' ); ?></label>
			<input id="gbe-xotutu-search-input" class="gbe-xotutu-search__input" type="search" name="s" value="<?php echo esc_attr( $q ); ?>" placeholder="<?php esc_attr_e( 'Rechercher un conte, un proverbe, une chanson, un lieu…', 'gbecosmolingua' ); ?>">
			<button type="submit" class="gbe-xotutu-search__submit"><?php esc_html_e( 'Rechercher', 'gbecosmolingua' ); ?></button>
			<a class="gbe-xotutu-search__advanced" href="<?php echo esc_url( $archive ); ?>"><?php esc_html_e( 'Recherche avancée', 'gbecosmolingua' ); ?></a>
		</form>
		<div class="gbe-xotutu-filters" aria-label="<?php esc_attr_e( 'Filtres', 'gbecosmolingua' ); ?>">
			<span class="gbe-xotutu-filters__item"><?php esc_html_e( 'Langue', 'gbecosmolingua' ); ?></span>
			<span class="gbe-xotutu-filters__item"><?php esc_html_e( 'Pays', 'gbecosmolingua' ); ?></span>
			<span class="gbe-xotutu-filters__item"><?php esc_html_e( 'Type de document', 'gbecosmolingua' ); ?></span>
			<span class="gbe-xotutu-filters__item"><?php esc_html_e( 'Auteur', 'gbecosmolingua' ); ?></span>
			<span class="gbe-xotutu-filters__item"><?php esc_html_e( 'Période', 'gbecosmolingua' ); ?></span>
			<span class="gbe-xotutu-filters__item"><?php esc_html_e( 'Région', 'gbecosmolingua' ); ?></span>
			<button type="button" class="gbe-xotutu-filters__reset" disabled><?php esc_html_e( 'Réinitialiser', 'gbecosmolingua' ); ?></button>
		</div>
	</div>
	<?php
}
