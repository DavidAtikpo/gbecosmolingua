<?php
/**
 * Import du corpus de proverbes éwé.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Charge les proverbes éwé depuis data/proverbes-ewe.json.
 */
class GBE_Proverbes_Importer {

	const DATA_FILE  = GBE_CORE_PATH . 'data/proverbes-ewe.json';
	const OPTION_KEY = 'gbe_proverbes_ewe_imported';

	/**
	 * Importe ou met à jour le corpus.
	 *
	 * @param bool $force Réimporter même si déjà fait.
	 * @return string Message résumé.
	 */
	public static function import( $force = false ) {
		if ( ! file_exists( self::DATA_FILE ) ) {
			return __( 'Fichier de données introuvable : plugins/gbecosmolingua-core/data/proverbes-ewe.json', 'gbecosmolingua-core' );
		}

		$raw = file_get_contents( self::DATA_FILE );
		$data = json_decode( $raw, true );
		if ( ! is_array( $data ) ) {
			return __( 'Fichier JSON invalide pour les proverbes éwé.', 'gbecosmolingua-core' );
		}

		$ewe_term = get_term_by( 'name', 'Éwé', 'langue_gbe' );
		if ( ! $ewe_term ) {
			wp_insert_term( 'Éwé', 'langue_gbe' );
			$ewe_term = get_term_by( 'name', 'Éwé', 'langue_gbe' );
		}

		$created = 0;
		$updated = 0;
		$skipped = 0;

		foreach ( $data as $item ) {
			if ( empty( $item['text'] ) || empty( $item['num'] ) ) {
				++$skipped;
				continue;
			}

			$num        = (int) $item['num'];
			$source_key = isset( $item['source_key'] ) ? sanitize_key( $item['source_key'] ) : 'corpus';
			$existing   = self::find_existing( $num, $source_key );

			if ( $existing && ! $force ) {
				++$skipped;
				continue;
			}

			$title = wp_strip_all_tags( (string) $item['text'] );
			$post  = array(
				'post_title'   => $title,
				'post_type'    => 'proverbe',
				'post_status'  => 'publish',
				'post_content' => '',
			);

			if ( $existing ) {
				$post['ID'] = $existing;
				$post_id    = wp_update_post( $post, true );
				if ( ! is_wp_error( $post_id ) ) {
					++$updated;
				} else {
					++$skipped;
					continue;
				}
			} else {
				$post_id = wp_insert_post( $post, true );
				if ( is_wp_error( $post_id ) || ! $post_id ) {
					++$skipped;
					continue;
				}
				++$created;
			}

			update_post_meta( $post_id, '_gbe_texte_original', $title );
			update_post_meta( $post_id, '_gbe_transcription', $title );
			update_post_meta( $post_id, '_gbe_numero_corpus', $num );
			update_post_meta( $post_id, '_gbe_source_key', $source_key );

			if ( ! empty( $item['source'] ) ) {
				update_post_meta( $post_id, '_gbe_contexte', sanitize_textarea_field( $item['source'] ) );
			}

			if ( $ewe_term && ! is_wp_error( $ewe_term ) ) {
				wp_set_object_terms( $post_id, array( (int) $ewe_term->term_id ), 'langue_gbe', false );
			}
		}

		update_option( self::OPTION_KEY, time() );

		return sprintf(
			/* translators: 1: created, 2: updated, 3: skipped */
			__( 'Corpus éwé : %1$d créés, %2$d mis à jour, %3$d ignorés.', 'gbecosmolingua-core' ),
			$created,
			$updated,
			$skipped
		);
	}

	/**
	 * Compte les entrées dans le fichier JSON.
	 *
	 * @return int
	 */
	public static function data_count() {
		if ( ! file_exists( self::DATA_FILE ) ) {
			return 0;
		}
		$data = json_decode( file_get_contents( self::DATA_FILE ), true );
		return is_array( $data ) ? count( $data ) : 0;
	}

	/**
	 * Trouve un proverbe existant par numéro de corpus et source.
	 *
	 * @param int    $num        Numéro dans le corpus.
	 * @param string $source_key Clé source (spieth_1906, etc.).
	 * @return int Post ID ou 0.
	 */
	private static function find_existing( $num, $source_key ) {
		$query = new WP_Query(
			array(
				'post_type'              => 'proverbe',
				'post_status'            => 'any',
				'posts_per_page'         => 1,
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'meta_query'             => array(
					'relation' => 'AND',
					array(
						'key'   => '_gbe_numero_corpus',
						'value' => $num,
					),
					array(
						'key'   => '_gbe_source_key',
						'value' => $source_key,
					),
				),
			)
		);

		if ( empty( $query->posts[0] ) ) {
			return 0;
		}

		return (int) $query->posts[0];
	}
}
