<?php
/**
 * Demo sample content for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Seeds example proverbs and oral entries for demonstration.
 */
class GBE_Demo_Content {

	const OPTION_KEY = 'gbe_demo_seeded';

	/**
	 * Insert demo content if not already done.
	 *
	 * @param bool $force Force re-seed.
	 * @return string Result message.
	 */
	public static function seed( $force = false ) {
		if ( ! $force && get_option( self::OPTION_KEY ) ) {
			return __( 'Le contenu de démonstration a déjà été créé.', 'gbecosmolingua-core' );
		}

		$ewe = get_term_by( 'name', 'Éwé', 'langue_gbe' );
		$fon = get_term_by( 'name', 'Fon', 'langue_gbe' );
		$lododowo = get_term_by( 'name', 'Lododowo', 'genre_xotutu' );

		$proverbes = array(
			array(
				'title'  => 'Agbefo kpoa ɖe ame ŋu',
				'langue' => $ewe ? array( $ewe->term_id ) : array(),
				'meta'   => array(
					'texte_original'       => 'Agbefo kpoa ɖe ame ŋu',
					'transcription'        => 'Agbefo kpoa ɖe ame ŋu',
					'traduction_fr'        => 'L\'argent s\'appuie sur les gens.',
					'traduction_en'        => 'Money relies on people.',
					'traduction_es'        => 'El dinero se apoya en las personas.',
					'traduction_ru'        => 'Деньги опираются на людей.',
					'contexte'             => 'Employé lors de discussions sur la solidarité communautaire et l\'économie du don.',
					'commentaire_culturel' => 'Ce lododowo éwé exprime l\'interdépendance entre richesse matérielle et lien social.',
				),
			),
			array(
				'title'  => 'Mɛ ji ɖo hɛn ɖo ɖokui',
				'langue' => $fon ? array( $fon->term_id ) : array(),
				'meta'   => array(
					'texte_original'       => 'Mɛ ji ɖo hɛn ɖo ɖokui',
					'transcription'        => 'Mɛ ji ɖo hɛn ɖo ɖokui',
					'traduction_fr'        => 'L\'eau ne se loue pas elle-même.',
					'traduction_en'        => 'Water does not rent itself out.',
					'traduction_es'        => 'El agua no se alquila a sí misma.',
					'traduction_ru'        => 'Вода не сдаёт себя внаём.',
					'contexte'             => 'Proverbe fon sur l\'autonomie et la dignité personnelle.',
					'commentaire_culturel' => 'Métaphore de l\'indépendance et du respect de soi dans la culture fon.',
				),
			),
		);

		foreach ( $proverbes as $p ) {
			$exists = get_page_by_title( $p['title'], OBJECT, 'proverbe' );
			if ( $exists ) {
				continue;
			}

			$id = wp_insert_post(
				array(
					'post_title'   => $p['title'],
					'post_type'    => 'proverbe',
					'post_status'  => 'publish',
					'post_content' => '',
				)
			);

			if ( ! is_wp_error( $id ) && $id ) {
				foreach ( $p['meta'] as $key => $value ) {
					update_post_meta( $id, '_gbe_' . $key, $value );
				}
				if ( ! empty( $p['langue'] ) ) {
					wp_set_object_terms( $id, $p['langue'], 'langue_gbe' );
				}
			}
		}

		$xotutu = array(
			'title'   => 'Exemple de lododowo éwé — transmission orale',
			'content' => 'Archive de démonstration pour la rubrique Xótùtù. Remplacez ce contenu par vos enregistrements audio et transcriptions.',
			'genre'   => $lododowo ? array( $lododowo->term_id ) : array(),
			'meta'    => array(
				'source'              => 'Démonstration GbeCosmoLingua',
				'transcription_orale' => 'Agbefo kpoa ɖe ame ŋu — L\'argent s\'appuie sur les gens.',
			),
		);

		if ( ! get_page_by_title( $xotutu['title'], OBJECT, 'genre_oral' ) ) {
			$id = wp_insert_post(
				array(
					'post_title'   => $xotutu['title'],
					'post_content' => $xotutu['content'],
					'post_type'    => 'genre_oral',
					'post_status'  => 'publish',
				)
			);
			if ( ! is_wp_error( $id ) && $id ) {
				foreach ( $xotutu['meta'] as $key => $value ) {
					update_post_meta( $id, '_gbe_' . $key, $value );
				}
				if ( ! empty( $xotutu['genre'] ) ) {
					wp_set_object_terms( $id, $xotutu['genre'], 'genre_xotutu' );
				}
			}
		}

		$ressource = array(
			'title'   => 'Corpus paremiologique éwé — échantillon',
			'content' => 'Document de démonstration pour la bibliothèque numérique.',
			'meta'    => array(
				'type_document' => 'corpus',
				'auteur'        => 'GbeCosmoLingua',
			),
		);

		if ( ! get_page_by_title( $ressource['title'], OBJECT, 'ressource' ) ) {
			$id = wp_insert_post(
				array(
					'post_title'   => $ressource['title'],
					'post_content' => $ressource['content'],
					'post_type'    => 'ressource',
					'post_status'  => 'publish',
				)
			);
			if ( ! is_wp_error( $id ) && $id ) {
				foreach ( $ressource['meta'] as $key => $value ) {
					update_post_meta( $id, '_gbe_' . $key, $value );
				}
			}
		}

		update_option( self::OPTION_KEY, time() );

		return __( 'Contenu de démonstration créé : 2 proverbes, 1 archive Xótùtù, 1 ressource.', 'gbecosmolingua-core' );
	}
}
