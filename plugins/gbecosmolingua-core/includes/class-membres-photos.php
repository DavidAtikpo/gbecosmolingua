<?php
/**
 * Photos des membres fondateurs (import depuis le thème actif).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * Catalogue et import des portraits membres.
 */
class GBE_Membres_Photos {

	/**
	 * Données canoniques des membres fondateurs.
	 *
	 * @return array<int, array{slug: string, title: string, fonction: string, order: int, photo: string}>
	 */
	public static function get_fondateurs_catalog() {
		return array(
			array(
				'slug'     => 'patrice-houinato',
				'title'    => 'Patrice HOUINATO',
				'fonction' => 'Président-Fondateur',
				'order'    => 1,
				'photo'    => 'assets/images/membres/patrice-houinato.jpg',
			),
			array(
				'slug'     => 'ben-anitcheou',
				'title'    => 'Ben ANITCHEOU',
				'fonction' => 'Vice-Président — Membre Fondateur',
				'order'    => 2,
				'photo'    => 'assets/images/membres/ben-anitcheou.jpg',
			),
			array(
				'slug'     => 'moise-koevi-kinvi',
				'title'    => 'Moïse Koévi KINVI',
				'fonction' => 'Secrétaire Général — Membre Fondateur',
				'order'    => 3,
				'photo'    => 'assets/images/membres/moise-koevi-kinvi.jpg',
			),
			array(
				'slug'     => 'bernardin-kodjo-nsougan',
				'title'    => 'Bernardin Kodjo N’SOUGAN',
				'fonction' => 'Secrétaire Général Adjoint — Membre Fondateur',
				'order'    => 4,
				'photo'    => 'assets/images/membres/bernardin-kodjo-nsougan.jpg',
			),
			array(
				'slug'     => 'david-kudzo-atikpo',
				'title'    => 'David Kudzo ATIKPO',
				'fonction' => 'Responsable de la Commission scientifique et numérique — Membre Fondateur',
				'order'    => 5,
				'photo'    => 'assets/images/membres/david-kudzo-atikpo.jpg',
			),
		);
	}

	/**
	 * Chemin absolu d’un fichier relatif au thème actif.
	 *
	 * @param string $relative_path Chemin relatif (ex. assets/images/membres/foo.jpg).
	 * @return string Chemin absolu ou chaîne vide.
	 */
	public static function resolve_theme_file( $relative_path ) {
		$relative_path = ltrim( (string) $relative_path, '/' );
		if ( '' === $relative_path ) {
			return '';
		}

		$candidates = array(
			get_stylesheet_directory() . '/' . $relative_path,
			get_template_directory() . '/' . $relative_path,
		);

		foreach ( $candidates as $path ) {
			if ( is_readable( $path ) ) {
				return $path;
			}
		}

		return '';
	}

	/**
	 * URL publique d’un fichier relatif au thème actif.
	 *
	 * @param string $relative_path Chemin relatif.
	 * @return string
	 */
	public static function resolve_theme_url( $relative_path ) {
		$relative_path = ltrim( (string) $relative_path, '/' );
		if ( '' === $relative_path ) {
			return '';
		}

		$stylesheet_path = get_stylesheet_directory() . '/' . $relative_path;
		if ( is_readable( $stylesheet_path ) ) {
			return get_stylesheet_directory_uri() . '/' . $relative_path;
		}

		$template_path = get_template_directory() . '/' . $relative_path;
		if ( is_readable( $template_path ) ) {
			return get_template_directory_uri() . '/' . $relative_path;
		}

		return '';
	}

	/**
	 * Assigne la langue par défaut (Polylang) à un membre.
	 *
	 * @param int $post_id ID membre.
	 */
	public static function assign_default_language( $post_id ) {
		$post_id = (int) $post_id;
		if ( $post_id <= 0 || ! function_exists( 'pll_set_post_language' ) ) {
			return;
		}

		$lang = function_exists( 'pll_default_language' ) ? pll_default_language( 'slug' ) : 'fr';
		if ( ! is_string( $lang ) || '' === $lang ) {
			$lang = 'fr';
		}

		pll_set_post_language( $post_id, $lang );
	}

	/**
	 * Nombre de membres publiés dans un groupe.
	 *
	 * @param string $groupe_slug Slug du groupe.
	 * @return int
	 */
	public static function count_published_in_group( $groupe_slug ) {
		$groupe_slug = sanitize_title( (string) $groupe_slug );
		if ( '' === $groupe_slug ) {
			return 0;
		}

		$query = new WP_Query(
			array(
				'post_type'              => 'membre_gbe',
				'post_status'            => 'publish',
				'posts_per_page'         => 1,
				'fields'                 => 'ids',
				'no_found_rows'          => false,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'groupe_membre',
						'field'    => 'slug',
						'terms'    => $groupe_slug,
					),
				),
			)
		);

		return (int) $query->found_posts;
	}

	/**
	 * Trouve un membre par slug ou titre.
	 *
	 * @param string $slug  Slug attendu.
	 * @param string $title Titre attendu.
	 * @return int ID post ou 0.
	 */
	public static function find_membre_post_id( $slug, $title ) {
		$slug = sanitize_title( (string) $slug );
		if ( '' !== $slug ) {
			$posts = get_posts(
				array(
					'post_type'              => 'membre_gbe',
					'name'                   => $slug,
					'posts_per_page'         => 1,
					'post_status'            => 'any',
					'fields'                 => 'ids',
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
				)
			);
			if ( ! empty( $posts[0] ) ) {
				return (int) $posts[0];
			}
		}

		$by_title = get_page_by_title( (string) $title, OBJECT, 'membre_gbe' );
		if ( $by_title instanceof WP_Post ) {
			return (int) $by_title->ID;
		}

		return 0;
	}

	/**
	 * Importe une image du thème comme image mise en avant.
	 *
	 * @param int    $post_id       ID membre.
	 * @param string $relative_path Chemin relatif dans le thème.
	 * @param string $title         Titre pour la pièce jointe.
	 * @param bool   $force         Remplacer une miniature existante si le fichier thème a changé.
	 * @return int ID attachment ou 0.
	 */
	public static function attach_theme_photo( $post_id, $relative_path, $title = '', $force = false ) {
		$post_id = (int) $post_id;
		if ( $post_id <= 0 ) {
			return 0;
		}

		$relative_path = ltrim( (string) $relative_path, '/' );
		$absolute_path = self::resolve_theme_file( $relative_path );
		if ( '' === $absolute_path ) {
			return 0;
		}

		if ( has_post_thumbnail( $post_id ) && ! $force ) {
			return (int) get_post_thumbnail_id( $post_id );
		}

		$file_mtime = (string) filemtime( $absolute_path );

		$attach_id = self::import_file_as_attachment( $absolute_path, $title, $post_id );
		if ( $attach_id <= 0 ) {
			return 0;
		}

		set_post_thumbnail( $post_id, $attach_id );
		update_post_meta( $post_id, '_gbe_photo_theme', $relative_path );
		update_post_meta( $post_id, '_gbe_photo_theme_mtime', $file_mtime );

		return $attach_id;
	}

	/**
	 * Copie un fichier local dans uploads et crée la pièce jointe.
	 *
	 * @param string $absolute_path Chemin source.
	 * @param string $title         Titre.
	 * @param int    $parent_id     Post parent.
	 * @return int
	 */
	private static function import_file_as_attachment( $absolute_path, $title, $parent_id = 0 ) {
		if ( ! is_readable( $absolute_path ) ) {
			return 0;
		}

		$filename = basename( $absolute_path );
		$contents = file_get_contents( $absolute_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		if ( false === $contents ) {
			return 0;
		}

		$upload = wp_upload_bits( $filename, null, $contents );
		if ( ! empty( $upload['error'] ) ) {
			return 0;
		}

		$filetype = wp_check_filetype( $filename, null );
		$attachment = array(
			'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
			'post_title'     => '' !== trim( (string) $title ) ? (string) $title : preg_replace( '/\.[^.]+$/', '', $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		$attach_id = wp_insert_attachment( $attachment, $upload['file'], (int) $parent_id );
		if ( is_wp_error( $attach_id ) || ! $attach_id ) {
			return 0;
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';

		$metadata = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
		if ( ! empty( $metadata ) ) {
			wp_update_attachment_metadata( $attach_id, $metadata );
		}

		return (int) $attach_id;
	}

	/**
	 * Synchronise les photos des fondateurs depuis le thème.
	 *
	 * @param bool $force Remplacer les miniatures déjà importées depuis le thème.
	 * @return int Nombre de photos attachées.
	 */
	public static function sync_fondateurs_photos( $force = false ) {
		$attached = 0;

		foreach ( self::get_fondateurs_catalog() as $membre ) {
			$post_id = self::find_membre_post_id( $membre['slug'], $membre['title'] );
			if ( $post_id <= 0 ) {
				continue;
			}

			$result = self::attach_theme_photo( $post_id, $membre['photo'], $membre['title'], $force );
			if ( $result > 0 ) {
				++$attached;
			}
		}

		return $attached;
	}

	/**
	 * URL de photo pour affichage (miniature WP ou fallback thème).
	 *
	 * @param int $post_id ID membre.
	 * @return string
	 */
	public static function get_membre_photo_url( $post_id ) {
		$post_id = (int) $post_id;
		if ( $post_id <= 0 ) {
			return '';
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$url = get_the_post_thumbnail_url( $post_id, 'medium' );
			return is_string( $url ) ? $url : '';
		}

		$theme_path = (string) get_post_meta( $post_id, '_gbe_photo_theme', true );
		if ( '' !== $theme_path ) {
			return self::resolve_theme_url( $theme_path );
		}

		return '';
	}
}
