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
		$already = (bool) get_option( self::OPTION_KEY );

		if ( ! $force && $already ) {
			self::seed_actualites();
			self::seed_evenements();
			self::seed_partenaires();
			self::seed_proverbes_extra();
			self::seed_xotutu_extra();
			self::seed_ressources_extra();

			return __( 'Contenu de démonstration complété : entrées ajoutées si manquantes.', 'gbecosmolingua-core' );
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

		self::seed_actualites();
		self::seed_evenements();
		self::seed_partenaires();
		self::seed_proverbes_extra();
		self::seed_xotutu_extra();
		self::seed_ressources_extra();

		return __( 'Contenu de démonstration créé : proverbes, archives Xótùtù, ressources, actualités, événements et partenaires.', 'gbecosmolingua-core' );
	}

	/**
	 * Additional sample proverbs.
	 */
	private static function seed_proverbes_extra() {
		$aja = get_term_by( 'name', 'Aja', 'langue_gbe' );
		$gen = get_term_by( 'name', 'Gen (Mina)', 'langue_gbe' );

		$items = array(
			array(
				'title'  => 'Dɔ wema ɖe dɔ wema ŋu',
				'langue' => $gen ? array( $gen->term_id ) : array(),
				'meta'   => array(
					'texte_original' => 'Dɔ wema ɖe dɔ wema ŋu',
					'traduction_fr'  => 'L\'amitié s\'appuie sur l\'amitié.',
					'contexte'       => 'Proverbe gen sur la réciprocité des relations humaines.',
				),
			),
			array(
				'title'  => 'Azan ɖo ɖokui ɖo',
				'langue' => $aja ? array( $aja->term_id ) : array(),
				'meta'   => array(
					'texte_original' => 'Azan ɖo ɖokui ɖo',
					'traduction_fr'  => 'Le chemin se suffit à lui-même.',
					'contexte'       => 'Expression aja sur l\'autonomie du parcours personnel.',
				),
			),
		);

		foreach ( $items as $item ) {
			if ( get_page_by_title( $item['title'], OBJECT, 'proverbe' ) ) {
				continue;
			}
			$id = wp_insert_post(
				array(
					'post_title'  => $item['title'],
					'post_type'   => 'proverbe',
					'post_status' => 'publish',
				)
			);
			if ( ! is_wp_error( $id ) && $id ) {
				foreach ( $item['meta'] as $key => $value ) {
					update_post_meta( $id, '_gbe_' . $key, $value );
				}
				if ( ! empty( $item['langue'] ) ) {
					wp_set_object_terms( $id, $item['langue'], 'langue_gbe' );
				}
			}
		}
	}

	/**
	 * Additional Xótùtù archives.
	 */
	private static function seed_xotutu_extra() {
		$egli = get_term_by( 'name', 'Ègli', 'genre_xotutu' );
		$havo = get_term_by( 'name', 'Hàwo', 'genre_xotutu' );

		$items = array(
			array(
				'title'   => 'Conte initiatique — archive de démonstration',
				'content' => 'Exemple de conte Ègli pour la bibliothèque Xótùtù.',
				'genre'   => $egli ? array( $egli->term_id ) : array(),
				'meta'    => array(
					'source'              => 'GbeCosmoLingua — démo',
					'transcription_orale' => 'Archive de conte traditionnel.',
				),
			),
			array(
				'title'   => 'Chant rituel — archive de démonstration',
				'content' => 'Exemple de chant Hàwo pour la bibliothèque Xótùtù.',
				'genre'   => $havo ? array( $havo->term_id ) : array(),
				'meta'    => array(
					'source'              => 'GbeCosmoLingua — démo',
					'transcription_orale' => 'Archive de chant traditionnel.',
				),
			),
		);

		foreach ( $items as $item ) {
			if ( get_page_by_title( $item['title'], OBJECT, 'genre_oral' ) ) {
				continue;
			}
			$id = wp_insert_post(
				array(
					'post_title'   => $item['title'],
					'post_content' => $item['content'],
					'post_type'    => 'genre_oral',
					'post_status'  => 'publish',
				)
			);
			if ( ! is_wp_error( $id ) && $id ) {
				foreach ( $item['meta'] as $key => $value ) {
					update_post_meta( $id, '_gbe_' . $key, $value );
				}
				if ( ! empty( $item['genre'] ) ) {
					wp_set_object_terms( $id, $item['genre'], 'genre_xotutu' );
				}
			}
		}
	}

	/**
	 * Additional library resources.
	 */
	private static function seed_ressources_extra() {
		$items = array(
			array(
				'title' => 'Introduction à la dialectologie gbe',
				'meta'  => array( 'type_document' => 'article', 'auteur' => 'GbeCosmoLingua' ),
			),
			array(
				'title' => 'Lexique comparatif éwé–fon',
				'meta'  => array( 'type_document' => 'lexique', 'auteur' => 'GbeCosmoLingua' ),
			),
			array(
				'title' => 'Atlas des migrations gbe',
				'meta'  => array( 'type_document' => 'corpus', 'auteur' => 'GbeCosmoLingua' ),
			),
		);

		foreach ( $items as $item ) {
			if ( get_page_by_title( $item['title'], OBJECT, 'ressource' ) ) {
				continue;
			}
			$id = wp_insert_post(
				array(
					'post_title'   => $item['title'],
					'post_content' => 'Ressource documentaire de démonstration.',
					'post_type'    => 'ressource',
					'post_status'  => 'publish',
				)
			);
			if ( ! is_wp_error( $id ) && $id ) {
				foreach ( $item['meta'] as $key => $value ) {
					update_post_meta( $id, '_gbe_' . $key, $value );
				}
			}
		}
	}

	/**
	 * Seed sample news posts.
	 */
	private static function seed_actualites() {
		$posts = array(
			array(
				'title'   => 'Lancement de l\'observatoire GbeCosmoLingua',
				'content' => '<p>GbeCosmoLingua inaugure son portail numérique dédié aux langues, cultures et patrimoines du continuum gbe. Cet observatoire international vise à documenter, préserver et valoriser un patrimoine linguistique et culturel d\'envergure mondiale.</p>',
				'excerpt' => 'Le portail numérique de l\'observatoire international est désormais en ligne.',
			),
			array(
				'title'   => 'Premier colloque sur la paremiologie gbe',
				'content' => '<p>Un colloque international réunira linguistes, anthropologues et porteurs de tradition pour explorer la sagesse populaire des peuples gbe à travers leurs proverbes et expressions sentencieuses.</p>',
				'excerpt' => 'Colloque international sur les proverbes et la sagesse populaire gbe.',
			),
			array(
				'title'   => 'Ouverture de la banque numérique Xótùtù',
				'content' => '<p>La bibliothèque numérique Xótùtù accueille ses premières archives sonores et textuelles de tradition orale. Contes, chants, proverbes et récits historiques seront progressivement enrichis.</p>',
				'excerpt' => 'Les premières archives de tradition orale sont accessibles en ligne.',
			),
		);

		foreach ( $posts as $post_data ) {
			if ( get_page_by_title( $post_data['title'], OBJECT, 'post' ) ) {
				continue;
			}

			wp_insert_post(
				array(
					'post_title'   => $post_data['title'],
					'post_content' => $post_data['content'],
					'post_excerpt' => $post_data['excerpt'],
					'post_type'    => 'post',
					'post_status'  => 'publish',
				)
			);
		}
	}

	/**
	 * Seed sample upcoming events.
	 */
	private static function seed_evenements() {
		$events = array(
			array(
				'title'   => 'Colloque international sur les langues gbe',
				'content' => 'Rencontre scientifique réunissant chercheurs du Togo, du Bénin, du Ghana et de la diaspora.',
				'date'    => '2026-09-15',
				'lieu'    => 'Lomé, Togo',
				'type'    => 'colloque',
			),
			array(
				'title'   => 'Conférence : le Xótùtù, mémoire culturelle des peuples gbe',
				'content' => 'Conférence publique sur la tradition orale et les archives numériques.',
				'date'    => '2026-10-20',
				'lieu'    => 'Cotonou, Bénin',
				'type'    => 'conference',
			),
			array(
				'title'   => 'Séminaire de paremiologie comparée',
				'content' => 'Atelier de travail sur les corpus proverbiaux éwé, fon et mina.',
				'date'    => '2026-11-05',
				'lieu'    => 'En ligne',
				'type'    => 'seminaire',
			),
			array(
				'title'   => 'Atelier d\'humanités numériques',
				'content' => 'Atelier sur la constitution de corpus et l\'annotation linguistique.',
				'date'    => '2026-12-01',
				'lieu'    => 'Porto-Novo, Bénin',
				'type'    => 'atelier',
			),
			array(
				'title'   => 'Journée des langues gbe — édition 2025',
				'content' => 'Événement passé de référence pour la mise en ligne du portail.',
				'date'    => '2025-06-21',
				'lieu'    => 'Lomé, Togo',
				'type'    => 'conference',
			),
		);

		foreach ( $events as $event ) {
			if ( get_page_by_title( $event['title'], OBJECT, 'evenement' ) ) {
				continue;
			}

			$id = wp_insert_post(
				array(
					'post_title'   => $event['title'],
					'post_content' => $event['content'],
					'post_type'    => 'evenement',
					'post_status'  => 'publish',
				)
			);

			if ( ! is_wp_error( $id ) && $id ) {
				update_post_meta( $id, '_gbe_date', $event['date'] );
				update_post_meta( $id, '_gbe_lieu', $event['lieu'] );
				update_post_meta( $id, '_gbe_type_evenement', $event['type'] );
			}
		}
	}

	/**
	 * Seed sample partners.
	 */
	private static function seed_partenaires() {
		$org_intl = get_term_by( 'name', 'Organisations internationales', 'type_partenaire' );
		$acad     = get_term_by( 'name', 'Institutions académiques', 'type_partenaire' );
		$cult     = get_term_by( 'name', 'Institutions culturelles', 'type_partenaire' );
		$diplo    = get_term_by( 'name', 'Institutions diplomatiques', 'type_partenaire' );

		$partners = array(
			array(
				'title' => 'UNESCO',
				'url'   => 'https://www.unesco.org',
				'pays'  => 'International',
				'type'  => $org_intl ? array( $org_intl->term_id ) : array(),
			),
			array(
				'title' => 'Organisation internationale de la Francophonie',
				'url'   => 'https://www.francophonie.org',
				'pays'  => 'International',
				'type'  => $org_intl ? array( $org_intl->term_id ) : array(),
			),
			array(
				'title' => 'Université de Lomé',
				'url'   => 'https://www.univ-lome.tg',
				'pays'  => 'Togo',
				'type'  => $acad ? array( $acad->term_id ) : array(),
			),
			array(
				'title' => 'Institut français du Bénin',
				'url'   => 'https://www.institutfrancais-benin.com',
				'pays'  => 'Bénin',
				'type'  => $cult ? array( $cult->term_id ) : array(),
			),
			array(
				'title' => 'CEDEAO',
				'url'   => 'https://www.ecowas.int',
				'pays'  => 'Afrique de l\'Ouest',
				'type'  => $org_intl ? array( $org_intl->term_id ) : array(),
			),
			array(
				'title' => 'Réseau Diaspora Gbe',
				'url'   => 'https://gbecosmolingua.org',
				'pays'  => 'International',
				'type'  => $diplo ? array( $diplo->term_id ) : array(),
			),
		);

		foreach ( $partners as $partner ) {
			if ( get_page_by_title( $partner['title'], OBJECT, 'partenaire' ) ) {
				continue;
			}

			$id = wp_insert_post(
				array(
					'post_title'  => $partner['title'],
					'post_type'   => 'partenaire',
					'post_status' => 'publish',
				)
			);

			if ( ! is_wp_error( $id ) && $id ) {
				update_post_meta( $id, '_gbe_url', $partner['url'] );
				update_post_meta( $id, '_gbe_pays', $partner['pays'] );
				if ( ! empty( $partner['type'] ) ) {
					wp_set_object_terms( $id, $partner['type'], 'type_partenaire' );
				}
			}
		}
	}
}
