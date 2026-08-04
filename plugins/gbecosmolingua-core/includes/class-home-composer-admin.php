<?php
/**
 * Admin : composeur page d'accueil (structure fixe, contenu éditable).
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta et écran admin pour / (page accueil).
 */
class GBE_Home_Composer_Admin {

	const META_LAYOUT   = '_gbe_home_layout';
	const NONCE_ACTION  = 'gbe_save_home_composer';
	const NONCE_FIELD   = 'gbe_home_composer_nonce';
	const PAGE_SLUG     = 'accueil';

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_menu' ) );
		add_action( 'admin_post_gbe_save_home_composer', array( __CLASS__, 'handle_save' ) );
		add_action( 'load-post.php', array( __CLASS__, 'maybe_redirect_home_page_edit' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Menu admin.
	 */
	public static function register_admin_menu() {
		add_submenu_page(
			'gbecosmolingua',
			__( 'Composer accueil', 'gbecosmolingua-core' ),
			__( 'Composer accueil', 'gbecosmolingua-core' ),
			'edit_pages',
			'gbecosmolingua-home-composer',
			array( __CLASS__, 'render_screen' )
		);
	}

	/**
	 * @return WP_Post|null
	 */
	public static function get_home_page() {
		$page = get_page_by_path( self::PAGE_SLUG, OBJECT, 'page' );
		return $page instanceof WP_Post ? $page : null;
	}

	/**
	 * Données par défaut (contenu actuellement visible sur le public).
	 *
	 * @return array<string, mixed>
	 */
	public static function default_layout() {
		return array(
			'hero' => array(
				'title'   => 'Préserver, transmettre et faire rayonner le patrimoine Gbe.',
				'lead'    => 'GbeCosmoLingua est un observatoire international des langues et cultures gbe — du Togo au Nigeria, pour la recherche, la transmission et le dialogue interculturel.',
				'bg_id'   => 0,
				'buttons' => array(
					array(
						'text'    => 'Explorer le continuum Gbe',
						'url'     => '/le-gbe/',
						'outline' => false,
					),
					array(
						'text'    => 'Découvrir notre mission',
						'url'     => '/a-propos/',
						'outline' => true,
					),
				),
			),
			'stats' => array(
				'items' => array(
					array( 'stat' => 4, 'suffix' => '', 'grouped' => false, 'text' => '', 'label' => 'Pays', 'icon' => '🌍' ),
					array( 'stat' => 60, 'suffix' => '+', 'grouped' => false, 'text' => '', 'label' => 'Variétés linguistiques', 'icon' => '💬' ),
					array( 'stat' => 20, 'suffix' => '+', 'grouped' => false, 'text' => '', 'label' => 'Projets de recherche', 'icon' => '🔬' ),
					array( 'stat' => 5000, 'suffix' => '+', 'grouped' => true, 'text' => '', 'label' => 'Ressources numériques', 'icon' => '📚' ),
					array( 'stat' => 100, 'suffix' => '+', 'grouped' => false, 'text' => '', 'label' => 'Partenaires institutionnels', 'icon' => '🤝' ),
					array( 'stat' => 10000, 'suffix' => '+', 'grouped' => true, 'text' => '', 'label' => 'Membres de la communauté', 'icon' => '👥' ),
				),
			),
			'map' => array(
				'kicker'      => 'Continuum Gbe',
				'title'       => 'Un espace linguistique et culturel partagé',
				'text'        => 'Découvrez sur la carte interactive la richesse et la diversité des langues gbe à travers l\'Afrique de l\'Ouest.',
				'button_text' => 'Explorer la carte interactive',
				'button_url'  => '/le-gbe/carte-interactive/',
				'image_id'    => 0,
			),
			'langues' => array(
				'kicker'    => 'Langues du continuum',
				'title'     => 'Une diversité linguistique exceptionnelle',
				'link_text' => 'Voir toutes les langues →',
				'link_url'  => '/le-gbe/les-langues/',
				'items'     => array(
					array( 'title' => 'Éwé', 'region' => 'Togo · Ghana', 'url' => '/le-gbe/les-langues/ewe/', 'css_slug' => 'ewe', 'image_file' => 'lang-ewe.jpg' ),
					array( 'title' => 'Gen', 'region' => 'Togo · Ghana', 'url' => '/le-gbe/les-langues/gen-mina/', 'css_slug' => 'gen', 'image_file' => 'lang-gen.jpg' ),
					array( 'title' => 'Fon', 'region' => 'Bénin', 'url' => '/le-gbe/les-langues/fon/', 'css_slug' => 'fon', 'image_file' => 'lang-fon.jpg' ),
					array( 'title' => 'Aja', 'region' => 'Bénin', 'url' => '/le-gbe/les-langues/aja/', 'css_slug' => 'aja', 'image_file' => 'lang-aja.jpg' ),
					array( 'title' => 'Gun', 'region' => 'Bénin', 'url' => '/le-gbe/les-langues/gun/', 'css_slug' => 'gun', 'image_file' => 'lang-gun.jpg' ),
					array( 'title' => 'Phla-Phera', 'region' => 'Bénin · Nigeria', 'url' => '/le-gbe/les-langues/phla-phera/', 'css_slug' => 'phera', 'image_file' => 'lang-phera.jpg' ),
				),
			),
			'culture' => array(
				'kicker' => 'Patrimoine vivant',
				'title'  => 'NOTRE PATRIMOINE, NOTRE FIERTÉ',
				'items'  => array(
					array( 'icon' => '🏺', 'label' => 'Arts et artisanat', 'url' => '/cultures-gbe/arts/' ),
					array( 'icon' => '🥁', 'label' => 'Musique et danse', 'url' => '/cultures-gbe/musique/' ),
					array( 'icon' => '📖', 'label' => 'Littérature orale et écrite', 'url' => '/xotutu/' ),
					array( 'icon' => '💬', 'label' => 'Proverbes et expressions', 'url' => '/paremiologie/' ),
					array( 'icon' => '🕯', 'label' => 'Spiritualité et croyances', 'url' => '/cultures-gbe/croyances-et-cosmologies/' ),
					array( 'icon' => '🍲', 'label' => 'Gastronomie', 'url' => '/cultures-gbe/gastronomie/' ),
					array( 'icon' => '🏛', 'label' => 'Histoire et sociétés', 'url' => '/cultures-gbe/patrimoines-materiels/' ),
					array( 'icon' => '🎭', 'label' => 'Fêtes et cérémonies', 'url' => '/cultures-gbe/fetes-et-ceremonies/' ),
				),
			),
			'bibliotheque' => array(
				'kicker'      => 'Ressources documentaires',
				'title'       => 'BIBLIOTHÈQUE NUMÉRIQUE',
				'text'        => 'Livres, archives audio, vidéos, images et cartes : explorez les corpus documentaires du continuum gbe.',
				'button_text' => 'Accéder à la bibliothèque',
				'button_url'  => '/le-gbe/bibliotheque-linguistique/',
				'cards'       => array(
					array( 'title' => 'Livres & Manuscrits', 'subtitle' => 'Ouvrages & écrits', 'count' => '1 200+', 'image_file' => 'biblio-books.jpg' ),
					array( 'title' => 'Archives audio', 'subtitle' => 'Enregistrements oraux', 'count' => '1 500+', 'image_file' => 'biblio-audio.jpg' ),
					array( 'title' => 'Vidéos & Documentaires', 'subtitle' => 'Films & captations', 'count' => '800+', 'image_file' => 'biblio-video.jpg' ),
					array( 'title' => 'Photos & Images', 'subtitle' => 'Patrimoine visuel', 'count' => '2 500+', 'image_file' => 'biblio-photos.jpg' ),
					array( 'title' => 'Cartes & Atlas', 'subtitle' => 'Espaces gbe', 'count' => '150+', 'image_file' => 'biblio-maps.jpg' ),
				),
			),
			'xotutu' => array(
				'kicker'      => 'Patrimoine oral',
				'title'       => 'Xótùtù — Bibliothèque du savoir gbe',
				'text'        => 'Contes, chants, proverbes, archives sonores et audiovisuelles : explorez la tradition orale et les genres folkloriques du continuum gbe.',
				'button_text' => 'Entrer dans Xótùtù',
				'button_url'  => '/xotutu/',
			),
			'research' => array(
				'kicker'    => 'Construire l\'avenir',
				'title'     => 'PRÉSERVER & INNOVER',
				'text'      => 'Recherche linguistique, numérisation du patrimoine et outils collaboratifs au service des communautés gbe.',
				'link_text' => 'Découvrir la recherche →',
				'link_url'  => '/recherche-innovation/',
				'tiles'     => array(
					array( 'image_file' => 'research-map.jpg' ),
					array( 'image_file' => 'research-book.jpg' ),
					array( 'image_file' => 'research-code.jpg' ),
					array( 'image_file' => 'research-manuscript.jpg' ),
					array( 'image_file' => 'research-server.jpg' ),
					array( 'image_file' => 'research-audio.jpg' ),
				),
			),
			'actu' => array(
				'news_kicker'    => 'Veille',
				'news_title'     => 'Restez informé',
				'events_kicker'  => 'Agenda',
				'events_title'   => 'ÉVÉNEMENTS À VENIR',
				'news'           => array(
					array(
						'title'      => 'Nouveau dictionnaire Éwé-Français en ligne',
						'date'       => '12 juin 2026',
						'url'        => '/actualites/',
						'image_file' => 'news-01.jpg',
					),
					array(
						'title'      => 'Archives audio du Fon : 200 heures numérisées',
						'date'       => '28 mai 2026',
						'url'        => '/actualites/',
						'image_file' => 'news-02.jpg',
					),
					array(
						'title'      => 'Colloque international sur les langues gbe',
						'date'       => '15 avril 2026',
						'url'        => '/actualites/',
						'image_file' => 'news-03.jpg',
					),
				),
				'events' => array(
					array(
						'title' => 'Atelier de transcription Éwé',
						'day'   => '15',
						'month' => 'JUN',
						'meta'  => 'Lomé, Togo',
						'url'   => '/evenements/',
					),
					array(
						'title' => 'Conférence sur le patrimoine oral Fon',
						'day'   => '22',
						'month' => 'JUL',
						'meta'  => 'Cotonou, Bénin',
						'url'   => '/evenements/',
					),
					array(
						'title' => 'Rencontre diaspora gbe — Paris',
						'day'   => '08',
						'month' => 'SEP',
						'meta'  => 'Paris, France',
						'url'   => '/evenements/',
					),
				),
			),
			'gallery' => array(
				'kicker' => 'Immersion culturelle',
				'title'  => 'DÉCOUVREZ LES CULTURES GBE',
				'tiles'  => array(
					array( 'image_file' => 'gallery-01.jpg', 'span' => 2 ),
					array( 'image_file' => 'gallery-02.jpg' ),
					array( 'image_file' => 'gallery-03.jpg' ),
					array( 'image_file' => 'gallery-04.jpg' ),
					array( 'image_file' => 'gallery-05.jpg', 'span' => 2 ),
					array( 'image_file' => 'gallery-06.jpg' ),
					array( 'image_file' => 'gallery-07.jpg' ),
					array( 'image_file' => 'gallery-08.jpg', 'span' => 2 ),
					array( 'image_file' => 'gallery-09.jpg' ),
					array( 'image_file' => 'gallery-10.jpg' ),
					array( 'image_file' => 'gallery-11.jpg' ),
					array( 'image_file' => 'gallery-12.jpg' ),
				),
			),
			'testimonials' => array(
				'kicker' => 'Témoignages',
				'title'  => 'Une voix, une mission commune',
				'items'  => array(
					array(
						'quote'      => '« GbeCosmoLingua offre un espace unique pour documenter et partager la richesse de nos langues. »',
						'name'       => 'Dr Amivi K.',
						'role'       => 'Linguiste, Université de Lomé',
						'image_file' => 'avatar-01.jpg',
					),
					array(
						'quote'      => '« Une ressource précieuse pour transmettre le patrimoine oral aux jeunes générations. »',
						'name'       => 'M. Sèdjro D.',
						'role'       => 'Porteur de tradition',
						'image_file' => 'avatar-02.jpg',
					),
					array(
						'quote'      => '« Le pont entre recherche académique et communautés est essentiel pour la vitalité culturelle. »',
						'name'       => 'Prof. Mawuli T.',
						'role'       => 'Université partenaire',
						'image_file' => 'avatar-03.jpg',
					),
					array(
						'quote'      => '« Enfin une plateforme qui met en valeur la diversité gbe à l\'échelle internationale. »',
						'name'       => 'Evelyne V.',
						'role'       => 'Diaspora gbe',
						'image_file' => 'avatar-04.jpg',
					),
				),
			),
			'partners' => array(
				'title' => 'Nos partenaires institutionnels',
				'limit' => 8,
			),
			'cta' => array(
				'title'   => 'Ensemble, préservons et transmettons le patrimoine Gbe',
				'buttons' => array(
					array( 'text' => 'Nous soutenir', 'url' => '/nous-soutenir/', 'outline' => false ),
					array( 'text' => 'Devenir partenaire', 'url' => '/partenaires/', 'outline' => true ),
					array( 'text' => 'Explorer Xótùtù', 'url' => '/xotutu/', 'outline' => true ),
				),
			),
		);
	}

	/**
	 * Layout enregistré fusionné avec les défauts.
	 *
	 * @param int $page_id ID page accueil.
	 * @return array<string, mixed>
	 */
	public static function get_layout( $page_id = 0 ) {
		if ( ! $page_id ) {
			$page = self::get_home_page();
			$page_id = $page ? (int) $page->ID : 0;
		}

		$defaults = self::default_layout();
		if ( ! $page_id ) {
			return $defaults;
		}

		$saved = get_post_meta( $page_id, self::META_LAYOUT, true );
		if ( ! is_array( $saved ) || empty( $saved ) ) {
			return $defaults;
		}

		return self::merge_layout( $defaults, $saved );
	}

	/**
	 * @param array<string, mixed> $defaults Défauts.
	 * @param array<string, mixed> $saved    Données enregistrées.
	 * @return array<string, mixed>
	 */
	private static function merge_layout( $defaults, $saved ) {
		$out = $defaults;
		foreach ( $defaults as $key => $default_section ) {
			if ( ! isset( $saved[ $key ] ) || ! is_array( $saved[ $key ] ) ) {
				continue;
			}
			if ( ! is_array( $default_section ) ) {
				$out[ $key ] = $saved[ $key ];
				continue;
			}
			$out[ $key ] = array_replace_recursive( $default_section, $saved[ $key ] );
		}
		return $out;
	}

	/**
	 * Initialise les meta si vides (première utilisation).
	 */
	public static function maybe_seed_defaults() {
		$page = self::get_home_page();
		if ( ! $page ) {
			return;
		}
		$saved = get_post_meta( $page->ID, self::META_LAYOUT, true );
		if ( ! is_array( $saved ) || empty( $saved ) ) {
			update_post_meta( $page->ID, self::META_LAYOUT, self::default_layout() );
		}
	}

	/**
	 * Redirige Pages → Accueil vers le composeur.
	 */
	public static function maybe_redirect_home_page_edit() {
		global $pagenow;

		if ( 'post.php' !== $pagenow || ! isset( $_GET['post'] ) ) {
			return;
		}

		$post = get_post( absint( $_GET['post'] ) );
		if ( ! $post instanceof WP_Post || self::PAGE_SLUG !== $post->post_name ) {
			return;
		}

		wp_safe_redirect( admin_url( 'admin.php?page=gbecosmolingua-home-composer' ) );
		exit;
	}

	/**
	 * @param string $hook Hook admin.
	 */
	public static function enqueue_scripts( $hook ) {
		if ( 'gbecosmolingua_page_gbecosmolingua-home-composer' !== $hook ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script(
			'gbe-le-gbe-hub-admin',
			GBE_CORE_URL . 'assets/js/le-gbe-hub-admin.js',
			array( 'jquery' ),
			GBE_CORE_VERSION . '.1',
			true
		);
	}

	/**
	 * Enregistrement composeur accueil.
	 */
	public static function handle_save() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}
		if ( ! isset( $_POST[ self::NONCE_FIELD ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_FIELD ] ) ), self::NONCE_ACTION ) ) {
			wp_die( esc_html__( 'Session expirée. Réessayez.', 'gbecosmolingua-core' ) );
		}

		$page_id = isset( $_POST['gbe_home_composer_page_id'] ) ? absint( $_POST['gbe_home_composer_page_id'] ) : 0;
		$page    = get_post( $page_id );
		if ( ! $page instanceof WP_Post || self::PAGE_SLUG !== $page->post_name ) {
			wp_die( esc_html__( 'Page accueil invalide.', 'gbecosmolingua-core' ) );
		}

		$raw = isset( $_POST['gbe_home_layout'] ) && is_array( $_POST['gbe_home_layout'] )
			? wp_unslash( $_POST['gbe_home_layout'] )
			: array();

		update_post_meta( $page_id, self::META_LAYOUT, self::sanitize_layout( $raw ) );

		wp_safe_redirect( add_query_arg( 'updated', '1', admin_url( 'admin.php?page=gbecosmolingua-home-composer' ) ) );
		exit;
	}

	/**
	 * @param array<string, mixed> $raw Données POST.
	 * @return array<string, mixed>
	 */
	private static function sanitize_layout( $raw ) {
		$defaults = self::default_layout();
		$out      = $defaults;

		if ( isset( $raw['hero'] ) && is_array( $raw['hero'] ) ) {
			$h = $raw['hero'];
			$out['hero']['title'] = sanitize_text_field( $h['title'] ?? $defaults['hero']['title'] );
			$out['hero']['lead']  = sanitize_textarea_field( $h['lead'] ?? $defaults['hero']['lead'] );
			$out['hero']['bg_id'] = isset( $h['bg_id'] ) ? absint( $h['bg_id'] ) : 0;
			$out['hero']['buttons'] = array();
			if ( ! empty( $h['buttons'] ) && is_array( $h['buttons'] ) ) {
				foreach ( $h['buttons'] as $btn ) {
					if ( ! is_array( $btn ) ) {
						continue;
					}
					$text = sanitize_text_field( $btn['text'] ?? '' );
					if ( '' === $text ) {
						continue;
					}
					$out['hero']['buttons'][] = array(
						'text'    => $text,
						'url'     => esc_url_raw( $btn['url'] ?? '' ),
						'outline' => ! empty( $btn['outline'] ),
					);
				}
			}
		}

		if ( isset( $raw['stats']['items'] ) && is_array( $raw['stats']['items'] ) ) {
			$out['stats']['items'] = array();
			foreach ( $raw['stats']['items'] as $item ) {
				if ( ! is_array( $item ) ) {
					continue;
				}
				$out['stats']['items'][] = array(
					'stat'    => isset( $item['stat'] ) && '' !== (string) $item['stat'] ? absint( $item['stat'] ) : 0,
					'suffix'  => sanitize_text_field( $item['suffix'] ?? '' ),
					'grouped' => ! empty( $item['grouped'] ),
					'text'    => sanitize_text_field( $item['text'] ?? '' ),
					'label'   => sanitize_text_field( $item['label'] ?? '' ),
				);
			}
		}

		if ( isset( $raw['map'] ) && is_array( $raw['map'] ) ) {
			$m = $raw['map'];
			$out['map'] = array(
				'kicker'      => sanitize_text_field( $m['kicker'] ?? '' ),
				'title'       => sanitize_text_field( $m['title'] ?? '' ),
				'text'        => sanitize_textarea_field( $m['text'] ?? '' ),
				'button_text' => sanitize_text_field( $m['button_text'] ?? '' ),
				'button_url'  => esc_url_raw( $m['button_url'] ?? '' ),
				'image_id'    => isset( $m['image_id'] ) ? absint( $m['image_id'] ) : 0,
			);
		}

		if ( isset( $raw['langues'] ) && is_array( $raw['langues'] ) ) {
			$l = $raw['langues'];
			$out['langues']['title']     = sanitize_text_field( $l['title'] ?? '' );
			$out['langues']['link_text'] = sanitize_text_field( $l['link_text'] ?? '' );
			$out['langues']['link_url']  = esc_url_raw( $l['link_url'] ?? '' );
			$out['langues']['items']     = array();
			if ( ! empty( $l['items'] ) && is_array( $l['items'] ) ) {
				foreach ( $l['items'] as $item ) {
					if ( ! is_array( $item ) ) {
						continue;
					}
					$title = sanitize_text_field( $item['title'] ?? '' );
					if ( '' === $title ) {
						continue;
					}
					$out['langues']['items'][] = array(
						'title'    => $title,
						'region'   => sanitize_text_field( $item['region'] ?? '' ),
						'url'      => esc_url_raw( $item['url'] ?? '' ),
						'css_slug' => sanitize_title( $item['css_slug'] ?? 'lang' ),
					);
				}
			}
		}

		if ( isset( $raw['culture'] ) && is_array( $raw['culture'] ) ) {
			$c = $raw['culture'];
			$out['culture']['title'] = sanitize_text_field( $c['title'] ?? '' );
			$out['culture']['items'] = array();
			if ( ! empty( $c['items'] ) && is_array( $c['items'] ) ) {
				foreach ( $c['items'] as $item ) {
					if ( ! is_array( $item ) ) {
						continue;
					}
					$label = sanitize_text_field( $item['label'] ?? '' );
					if ( '' === $label ) {
						continue;
					}
					$out['culture']['items'][] = array(
						'icon'  => sanitize_text_field( $item['icon'] ?? '' ),
						'label' => $label,
						'url'   => esc_url_raw( $item['url'] ?? '' ),
					);
				}
			}
		}

		if ( isset( $raw['bibliotheque'] ) && is_array( $raw['bibliotheque'] ) ) {
			$b = $raw['bibliotheque'];
			$out['bibliotheque']['title']       = sanitize_text_field( $b['title'] ?? '' );
			$out['bibliotheque']['text']        = sanitize_textarea_field( $b['text'] ?? '' );
			$out['bibliotheque']['button_text'] = sanitize_text_field( $b['button_text'] ?? '' );
			$out['bibliotheque']['button_url']  = esc_url_raw( $b['button_url'] ?? '' );
			$out['bibliotheque']['cards']       = array();
			if ( ! empty( $b['cards'] ) && is_array( $b['cards'] ) ) {
				foreach ( $b['cards'] as $card ) {
					if ( ! is_array( $card ) ) {
						continue;
					}
					$out['bibliotheque']['cards'][] = array(
						'title'    => sanitize_text_field( $card['title'] ?? '' ),
						'subtitle' => sanitize_text_field( $card['subtitle'] ?? '' ),
					);
				}
			}
		}

		if ( isset( $raw['gallery']['tiles'] ) && is_array( $raw['gallery']['tiles'] ) ) {
			$out['gallery']['tiles'] = array();
			foreach ( $raw['gallery']['tiles'] as $tile ) {
				$out['gallery']['tiles'][] = array(
					'image_id' => is_array( $tile ) && isset( $tile['image_id'] ) ? absint( $tile['image_id'] ) : 0,
				);
			}
		}

		if ( isset( $raw['testimonials'] ) && is_array( $raw['testimonials'] ) ) {
			$t = $raw['testimonials'];
			$out['testimonials']['title'] = sanitize_text_field( $t['title'] ?? '' );
			$out['testimonials']['items'] = array();
			if ( ! empty( $t['items'] ) && is_array( $t['items'] ) ) {
				foreach ( $t['items'] as $item ) {
					if ( ! is_array( $item ) ) {
						continue;
					}
					$quote = sanitize_textarea_field( $item['quote'] ?? '' );
					if ( '' === $quote ) {
						continue;
					}
					$out['testimonials']['items'][] = array(
						'quote' => $quote,
						'name'  => sanitize_text_field( $item['name'] ?? '' ),
						'role'  => sanitize_text_field( $item['role'] ?? '' ),
					);
				}
			}
		}

		if ( isset( $raw['partners'] ) && is_array( $raw['partners'] ) ) {
			$p = $raw['partners'];
			$out['partners'] = array(
				'title' => sanitize_text_field( $p['title'] ?? '' ),
				'limit' => isset( $p['limit'] ) ? max( 1, min( 24, absint( $p['limit'] ) ) ) : 8,
			);
		}

		if ( isset( $raw['cta'] ) && is_array( $raw['cta'] ) ) {
			$c = $raw['cta'];
			$out['cta']['title'] = sanitize_text_field( $c['title'] ?? '' );
			$out['cta']['buttons'] = array();
			if ( ! empty( $c['buttons'] ) && is_array( $c['buttons'] ) ) {
				foreach ( $c['buttons'] as $btn ) {
					if ( ! is_array( $btn ) ) {
						continue;
					}
					$text = sanitize_text_field( $btn['text'] ?? '' );
					if ( '' === $text ) {
						continue;
					}
					$out['cta']['buttons'][] = array(
						'text'    => $text,
						'url'     => esc_url_raw( $btn['url'] ?? '' ),
						'outline' => ! empty( $btn['outline'] ),
					);
				}
			}
		}

		return $out;
	}

	/**
	 * Écran composeur accueil.
	 */
	public static function render_screen() {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Accès refusé.', 'gbecosmolingua-core' ) );
		}

		$page = self::get_home_page();
		if ( ! $page ) {
			echo '<div class="wrap"><h1>' . esc_html__( 'Composer accueil', 'gbecosmolingua-core' ) . '</h1>';
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Page « accueil » introuvable.', 'gbecosmolingua-core' ) . '</p></div></div>';
			return;
		}

		if ( isset( $_GET['updated'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Page d\'accueil enregistrée.', 'gbecosmolingua-core' ) . '</p></div>';
		}

		$layout  = self::get_layout( $page->ID );
		$preview = home_url( '/' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Composer la page d\'accueil', 'gbecosmolingua-core' ); ?></h1>
			<p class="description"><?php esc_html_e( 'Structure identique au site public : bannière, chiffres, carte, langues, culture, bibliothèque, galerie, témoignages, partenaires et appel à l’action.', 'gbecosmolingua-core' ); ?></p>
			<p>
				<a class="button button-primary" href="<?php echo esc_url( $preview ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Voir la page publique', 'gbecosmolingua-core' ); ?></a>
			</p>

			<form id="gbe-home-composer-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="gbe_save_home_composer" />
				<input type="hidden" name="gbe_home_composer_page_id" value="<?php echo esc_attr( (string) $page->ID ); ?>" />
				<?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>

				<?php self::render_section_hero( $layout['hero'] ); ?>
				<?php self::render_section_stats( $layout['stats']['items'] ); ?>
				<?php self::render_section_map( $layout['map'] ); ?>
				<?php self::render_section_langues( $layout['langues'] ); ?>
				<?php self::render_section_culture( $layout['culture'] ); ?>
				<?php self::render_section_bibliotheque( $layout['bibliotheque'] ); ?>
				<?php self::render_section_gallery( $layout['gallery']['tiles'] ); ?>
				<?php self::render_section_testimonials( $layout['testimonials'] ); ?>
				<?php self::render_section_partners( $layout['partners'] ); ?>
				<?php self::render_section_cta( $layout['cta'] ); ?>

				<?php submit_button( __( 'Enregistrer la page d\'accueil', 'gbecosmolingua-core' ) ); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $hero Données hero.
	 */
	private static function render_section_hero( $hero ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Bannière', 'gbecosmolingua-core' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="gbe_home_hero_title"><?php esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></label></th>
					<td><input type="text" class="large-text" id="gbe_home_hero_title" name="gbe_home_layout[hero][title]" value="<?php echo esc_attr( $hero['title'] ?? '' ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="gbe_home_hero_lead"><?php esc_html_e( 'Texte', 'gbecosmolingua-core' ); ?></label></th>
					<td><textarea class="large-text" rows="3" id="gbe_home_hero_lead" name="gbe_home_layout[hero][lead]"><?php echo esc_textarea( $hero['lead'] ?? '' ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Image de fond', 'gbecosmolingua-core' ); ?></th>
					<td><?php self::render_media_field( 'gbe_home_layout[hero][bg_id]', (int) ( $hero['bg_id'] ?? 0 ), 'gbe_home_hero_bg' ); ?></td>
				</tr>
			</table>
			<h3><?php esc_html_e( 'Boutons', 'gbecosmolingua-core' ); ?></h3>
			<?php
			$buttons = $hero['buttons'] ?? array();
			for ( $i = 0; $i < max( 2, count( $buttons ) ); $i++ ) {
				$btn = $buttons[ $i ] ?? array( 'text' => '', 'url' => '', 'outline' => false );
				?>
				<fieldset style="margin:0 0 1rem;padding:0.75rem;border:1px solid #c3c4c7;border-radius:4px;">
					<legend><?php echo esc_html( sprintf( __( 'Bouton %d', 'gbecosmolingua-core' ), $i + 1 ) ); ?></legend>
					<p>
						<input type="text" class="regular-text" name="gbe_home_layout[hero][buttons][<?php echo esc_attr( (string) $i ); ?>][text]" value="<?php echo esc_attr( $btn['text'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'Libellé', 'gbecosmolingua-core' ); ?>" />
						<input type="text" class="regular-text" name="gbe_home_layout[hero][buttons][<?php echo esc_attr( (string) $i ); ?>][url]" value="<?php echo esc_attr( $btn['url'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'URL', 'gbecosmolingua-core' ); ?>" />
						<label><input type="checkbox" name="gbe_home_layout[hero][buttons][<?php echo esc_attr( (string) $i ); ?>][outline]" value="1" <?php checked( ! empty( $btn['outline'] ) ); ?> /> <? esc_html_e( 'Style contour', 'gbecosmolingua-core' ); ?></label>
					</p>
				</fieldset>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * @param array<int, array<string, mixed>> $items Chiffres.
	 */
	private static function render_section_stats( $items ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Chiffres clés', 'gbecosmolingua-core' ); ?></h2>
			<table class="widefat striped">
				<thead><tr><th><? esc_html_e( 'Valeur', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Suffixe', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Texte fixe', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Libellé', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Groupé', 'gbecosmolingua-core' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $items as $i => $item ) : ?>
					<tr>
						<td><input type="number" min="0" name="gbe_home_layout[stats][items][<?php echo esc_attr( (string) $i ); ?>][stat]" value="<?php echo esc_attr( (string) ( $item['stat'] ?? '' ) ); ?>" style="width:5rem;" /></td>
						<td><input type="text" name="gbe_home_layout[stats][items][<?php echo esc_attr( (string) $i ); ?>][suffix]" value="<?php echo esc_attr( $item['suffix'] ?? '' ); ?>" style="width:4rem;" /></td>
						<td><input type="text" name="gbe_home_layout[stats][items][<?php echo esc_attr( (string) $i ); ?>][text]" value="<?php echo esc_attr( $item['text'] ?? '' ); ?>" placeholder="24/7" /></td>
						<td><input type="text" class="regular-text" name="gbe_home_layout[stats][items][<?php echo esc_attr( (string) $i ); ?>][label]" value="<?php echo esc_attr( $item['label'] ?? '' ); ?>" /></td>
						<td><input type="checkbox" name="gbe_home_layout[stats][items][<?php echo esc_attr( (string) $i ); ?>][grouped]" value="1" <?php checked( ! empty( $item['grouped'] ) ); ?> /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="description"><? esc_html_e( 'Laissez « Valeur » vide et remplissez « Texte fixe » pour un affichage littéral (ex. 24/7).', 'gbecosmolingua-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $map Section carte.
	 */
	private static function render_section_map( $map ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Carte interactive', 'gbecosmolingua-core' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr><th scope="row"><label><? esc_html_e( 'Sur-titre', 'gbecosmolingua-core' ); ?></label></th><td><input type="text" class="large-text" name="gbe_home_layout[map][kicker]" value="<?php echo esc_attr( $map['kicker'] ?? '' ); ?>" /></td></tr>
				<tr><th scope="row"><label><? esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></label></th><td><input type="text" class="large-text" name="gbe_home_layout[map][title]" value="<?php echo esc_attr( $map['title'] ?? '' ); ?>" /></td></tr>
				<tr><th scope="row"><label><? esc_html_e( 'Texte', 'gbecosmolingua-core' ); ?></label></th><td><textarea class="large-text" rows="2" name="gbe_home_layout[map][text]"><?php echo esc_textarea( $map['text'] ?? '' ); ?></textarea></td></tr>
				<tr><th scope="row"><label><? esc_html_e( 'Bouton', 'gbecosmolingua-core' ); ?></label></th><td><input type="text" class="regular-text" name="gbe_home_layout[map][button_text]" value="<?php echo esc_attr( $map['button_text'] ?? '' ); ?>" /> <input type="text" class="regular-text" name="gbe_home_layout[map][button_url]" value="<?php echo esc_attr( $map['button_url'] ?? '' ); ?>" placeholder="URL" /></td></tr>
				<tr><th scope="row"><? esc_html_e( 'Image (optionnelle)', 'gbecosmolingua-core' ); ?></th><td><?php self::render_media_field( 'gbe_home_layout[map][image_id]', (int) ( $map['image_id'] ?? 0 ), 'gbe_home_map_img' ); ?></td></tr>
			</table>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $langues Section langues.
	 */
	private static function render_section_langues( $langues ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Langues gbe', 'gbecosmolingua-core' ); ?></h2>
			<p><input type="text" class="large-text" name="gbe_home_layout[langues][title]" value="<?php echo esc_attr( $langues['title'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'Titre de section', 'gbecosmolingua-core' ); ?>" /></p>
			<p><input type="text" class="regular-text" name="gbe_home_layout[langues][link_text]" value="<?php echo esc_attr( $langues['link_text'] ?? '' ); ?>" /> <input type="text" class="regular-text" name="gbe_home_layout[langues][link_url]" value="<?php echo esc_attr( $langues['link_url'] ?? '' ); ?>" placeholder="URL lien" /></p>
			<table class="widefat striped">
				<thead><tr><th><? esc_html_e( 'Langue', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Région', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'URL', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Classe CSS', 'gbecosmolingua-core' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( ( $langues['items'] ?? array() ) as $i => $item ) : ?>
					<tr>
						<td><input type="text" name="gbe_home_layout[langues][items][<?php echo esc_attr( (string) $i ); ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" /></td>
						<td><input type="text" name="gbe_home_layout[langues][items][<?php echo esc_attr( (string) $i ); ?>][region]" value="<?php echo esc_attr( $item['region'] ?? '' ); ?>" /></td>
						<td><input type="text" class="regular-text" name="gbe_home_layout[langues][items][<?php echo esc_attr( (string) $i ); ?>][url]" value="<?php echo esc_attr( $item['url'] ?? '' ); ?>" /></td>
						<td><input type="text" name="gbe_home_layout[langues][items][<?php echo esc_attr( (string) $i ); ?>][css_slug]" value="<?php echo esc_attr( $item['css_slug'] ?? '' ); ?>" /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $culture Section culture.
	 */
	private static function render_section_culture( $culture ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Patrimoine culturel', 'gbecosmolingua-core' ); ?></h2>
			<p><input type="text" class="large-text" name="gbe_home_layout[culture][title]" value="<?php echo esc_attr( $culture['title'] ?? '' ); ?>" /></p>
			<table class="widefat striped">
				<thead><tr><th><? esc_html_e( 'Icône', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Libellé', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'URL', 'gbecosmolingua-core' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( ( $culture['items'] ?? array() ) as $i => $item ) : ?>
					<tr>
						<td><input type="text" name="gbe_home_layout[culture][items][<?php echo esc_attr( (string) $i ); ?>][icon]" value="<?php echo esc_attr( $item['icon'] ?? '' ); ?>" style="width:4rem;" /></td>
						<td><input type="text" class="regular-text" name="gbe_home_layout[culture][items][<?php echo esc_attr( (string) $i ); ?>][label]" value="<?php echo esc_attr( $item['label'] ?? '' ); ?>" /></td>
						<td><input type="text" class="regular-text" name="gbe_home_layout[culture][items][<?php echo esc_attr( (string) $i ); ?>][url]" value="<?php echo esc_attr( $item['url'] ?? '' ); ?>" /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $biblio Section bibliothèque.
	 */
	private static function render_section_bibliotheque( $biblio ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Bibliothèque numérique', 'gbecosmolingua-core' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr><th scope="row"><label><? esc_html_e( 'Titre', 'gbecosmolingua-core' ); ?></label></th><td><input type="text" class="large-text" name="gbe_home_layout[bibliotheque][title]" value="<?php echo esc_attr( $biblio['title'] ?? '' ); ?>" /></td></tr>
				<tr><th scope="row"><label><? esc_html_e( 'Texte', 'gbecosmolingua-core' ); ?></label></th><td><textarea class="large-text" rows="2" name="gbe_home_layout[bibliotheque][text]"><?php echo esc_textarea( $biblio['text'] ?? '' ); ?></textarea></td></tr>
				<tr><th scope="row"><label><? esc_html_e( 'Bouton', 'gbecosmolingua-core' ); ?></label></th><td><input type="text" class="regular-text" name="gbe_home_layout[bibliotheque][button_text]" value="<?php echo esc_attr( $biblio['button_text'] ?? '' ); ?>" /> <input type="text" class="regular-text" name="gbe_home_layout[bibliotheque][button_url]" value="<?php echo esc_attr( $biblio['button_url'] ?? '' ); ?>" /></td></tr>
			</table>
			<table class="widefat striped">
				<thead><tr><th><? esc_html_e( 'Carte', 'gbecosmolingua-core' ); ?></th><th><? esc_html_e( 'Sous-titre', 'gbecosmolingua-core' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( ( $biblio['cards'] ?? array() ) as $i => $card ) : ?>
					<tr>
						<td><input type="text" name="gbe_home_layout[bibliotheque][cards][<?php echo esc_attr( (string) $i ); ?>][title]" value="<?php echo esc_attr( $card['title'] ?? '' ); ?>" /></td>
						<td><input type="text" class="regular-text" name="gbe_home_layout[bibliotheque][cards][<?php echo esc_attr( (string) $i ); ?>][subtitle]" value="<?php echo esc_attr( $card['subtitle'] ?? '' ); ?>" /></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * @param array<int, array<string, mixed>> $tiles Tuiles galerie.
	 */
	private static function render_section_gallery( $tiles ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Galerie (bandeau)', 'gbecosmolingua-core' ); ?></h2>
			<p class="description"><? esc_html_e( 'Six visuels. Sans image, le dégradé du thème est utilisé.', 'gbecosmolingua-core' ); ?></p>
			<?php foreach ( $tiles as $i => $tile ) : ?>
				<p><strong><?php echo esc_html( sprintf( __( 'Tuile %d', 'gbecosmolingua-core' ), $i + 1 ) ); ?></strong>
				<?php self::render_media_field( 'gbe_home_layout[gallery][tiles][' . $i . '][image_id]', (int) ( $tile['image_id'] ?? 0 ), 'gbe_home_gallery_' . $i ); ?>
				</p>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $testimonials Témoignages.
	 */
	private static function render_section_testimonials( $testimonials ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Témoignages', 'gbecosmolingua-core' ); ?></h2>
			<p><input type="text" class="large-text" name="gbe_home_layout[testimonials][title]" value="<?php echo esc_attr( $testimonials['title'] ?? '' ); ?>" /></p>
			<?php foreach ( ( $testimonials['items'] ?? array() ) as $i => $item ) : ?>
				<fieldset style="margin:0 0 1rem;padding:0.75rem;border:1px solid #c3c4c7;border-radius:4px;">
					<legend><?php echo esc_html( sprintf( __( 'Témoignage %d', 'gbecosmolingua-core' ), $i + 1 ) ); ?></legend>
					<p><textarea class="large-text" rows="2" name="gbe_home_layout[testimonials][items][<?php echo esc_attr( (string) $i ); ?>][quote]"><?php echo esc_textarea( $item['quote'] ?? '' ); ?></textarea></p>
					<p>
						<input type="text" class="regular-text" name="gbe_home_layout[testimonials][items][<?php echo esc_attr( (string) $i ); ?>][name]" value="<?php echo esc_attr( $item['name'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'Nom', 'gbecosmolingua-core' ); ?>" />
						<input type="text" class="regular-text" name="gbe_home_layout[testimonials][items][<?php echo esc_attr( (string) $i ); ?>][role]" value="<?php echo esc_attr( $item['role'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'Fonction', 'gbecosmolingua-core' ); ?>" />
					</p>
				</fieldset>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $partners Partenaires.
	 */
	private static function render_section_partners( $partners ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Partenaires', 'gbecosmolingua-core' ); ?></h2>
			<p>
				<input type="text" class="large-text" name="gbe_home_layout[partners][title]" value="<?php echo esc_attr( $partners['title'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'Titre', 'gbecosmolingua-core' ); ?>" />
				<label style="margin-left:1rem;"><? esc_html_e( 'Nombre affiché', 'gbecosmolingua-core' ); ?>
					<input type="number" min="1" max="24" name="gbe_home_layout[partners][limit]" value="<?php echo esc_attr( (string) ( $partners['limit'] ?? 8 ) ); ?>" style="width:4rem;" />
				</label>
			</p>
			<p class="description"><? esc_html_e( 'Liste alimentée par le shortcode partenaires (CPT Partenaires).', 'gbecosmolingua-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * @param array<string, mixed> $cta Appel à l'action.
	 */
	private static function render_section_cta( $cta ) {
		?>
		<div class="postbox" style="margin-top:1.5rem;padding:1rem 1.25rem;max-width:1200px;">
			<h2><?php esc_html_e( 'Appel à l\'action (bas de page)', 'gbecosmolingua-core' ); ?></h2>
			<p><input type="text" class="large-text" name="gbe_home_layout[cta][title]" value="<?php echo esc_attr( $cta['title'] ?? '' ); ?>" /></p>
			<?php
			$buttons = $cta['buttons'] ?? array();
			for ( $i = 0; $i < max( 3, count( $buttons ) ); $i++ ) {
				$btn = $buttons[ $i ] ?? array( 'text' => '', 'url' => '', 'outline' => false );
				?>
				<p>
					<input type="text" class="regular-text" name="gbe_home_layout[cta][buttons][<?php echo esc_attr( (string) $i ); ?>][text]" value="<?php echo esc_attr( $btn['text'] ?? '' ); ?>" placeholder="<? esc_attr_e( 'Libellé', 'gbecosmolingua-core' ); ?>" />
					<input type="text" class="regular-text" name="gbe_home_layout[cta][buttons][<?php echo esc_attr( (string) $i ); ?>][url]" value="<?php echo esc_attr( $btn['url'] ?? '' ); ?>" placeholder="URL" />
					<label><input type="checkbox" name="gbe_home_layout[cta][buttons][<?php echo esc_attr( (string) $i ); ?>][outline]" value="1" <?php checked( ! empty( $btn['outline'] ) ); ?> /> <? esc_html_e( 'Contour', 'gbecosmolingua-core' ); ?></label>
				</p>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * @param string $input_name Nom du champ.
	 * @param int    $attachment_id ID média.
	 * @param string $input_id ID HTML.
	 */
	private static function render_media_field( $input_name, $attachment_id, $input_id = '' ) {
		if ( '' === $input_id ) {
			$input_id = sanitize_html_class( str_replace( array( '[', ']' ), '-', $input_name ) );
		}
		?>
		<input type="hidden" name="<?php echo esc_attr( $input_name ); ?>" id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( (string) $attachment_id ); ?>" />
		<div class="gbe-le-gbe-media-preview" style="margin-bottom:0.5rem;">
			<?php
			if ( $attachment_id ) {
				echo wp_get_attachment_image( $attachment_id, 'medium' );
			} else {
				echo '<span class="description">' . esc_html__( 'Aucune image', 'gbecosmolingua-core' ) . '</span>';
			}
			?>
		</div>
		<button type="button" class="button gbe-le-gbe-pick-media" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Choisir dans Médias', 'gbecosmolingua-core' ); ?></button>
		<button type="button" class="button gbe-le-gbe-clear-media" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Retirer', 'gbecosmolingua-core' ); ?></button>
		<?php
	}
}
