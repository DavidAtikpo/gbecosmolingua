<?php
/**
 * Page structure and content for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

require_once GBE_CORE_PATH . 'includes/content/gbe-mission-statuts.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-capo-auteur.php';
require_once GBE_CORE_PATH . 'includes/le-gbe-chapter-ui.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-inventaire-parlers.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-travaux-scientifiques.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-potentialites-lexicales.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-dialectologie.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-lexicologie.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-linguistique-chapter.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-regroupement-parlers.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-langue-unique.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-pays-territoires.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-varietes-principales.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-continuum-hub.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-langues-hub.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-peuples-continuum.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-aja-langue.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-langues-chapter.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-main-hubs.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-pages-content.php';
require_once GBE_CORE_PATH . 'includes/content/le-gbe-fon-these-gnanguenon.php';
require_once GBE_CORE_PATH . 'includes/pages-helpers.php';

/**
 * Returns the full page tree for import.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_pages_data() {
	return array(
		array(
			'title'      => 'Notre philosophie',
			'slug'       => 'notre-philosophie',
			'content'    => gbe_philosophie_page_content(),
			'menu_order' => 99,
		),
		array(
			'title'    => 'Gbe',
			'slug'     => 'le-gbe',
			'content'  => gbe_le_gbe_hub_content(),
			'children' => gbe_get_le_gbe_children(),
		),
		array(
			'title'    => 'Cultures Gbe',
			'slug'     => 'cultures-gbe',
			'content'  => gbe_cultures_gbe_hub_content(),
			'children' => gbe_get_cultures_gbe_children(),
		),
		array(
			'title'    => 'Xótùtù',
			'slug'     => 'xotutu',
			'content'  => gbe_le_gbe_xotutu_hub_content(),
			'children' => array(
				array(
					'title'   => 'Tradition orale et patrimoines immatériels',
					'slug'    => 'tradition-orale-patrimoines',
					'content' => gbe_intro( 'Le Xótùtù comme espace de mémoire, de création et de transmission intergénérationnelle.' ),
				),
				array(
					'title'    => 'Questions terminologiques',
					'slug'     => 'questions-terminologiques',
					'content'  => gbe_intro( 'Clarification des concepts clés pour l\'étude de la tradition orale gbe.' ),
					'children' => gbe_get_terminologie_pages(),
				),
				array(
					'title'    => 'Les grands genres folkloriques',
					'slug'     => 'genres-folkloriques',
					'content'  => gbe_intro( 'Classification des genres de la littérature et de la performance orale gbe.' ),
					'children' => gbe_get_genres_folkloriques_pages(),
				),
				array(
					'title'    => 'Onomastique',
					'slug'     => 'onomastique',
					'content'  => gbe_xotutu_onomastique_hub_content(),
					'children' => gbe_get_onomastique_pages(),
				),
				array(
					'title'    => 'Archives numériques',
					'slug'     => 'archives-numeriques',
					'content'  => gbe_intro( 'Conservation et diffusion numérique du patrimoine oral et documentaire gbe.' ),
					'children' => gbe_get_archives_pages(),
				),
			),
		),
		array(
			'title'    => 'Paremiologie',
			'slug'     => 'paremiologie',
			'content'  => gbe_le_gbe_paremiologie_hub_content(),
			'children' => gbe_get_paremiologie_children(),
		),
		array(
			'title'    => 'Recherche et Innovation',
			'slug'     => 'recherche-et-innovation',
			'content'  => gbe_intro( 'Centre international d\'études gbe : recherche linguistique, numérisation du patrimoine, reconstruction du proto-Gbe et coopération entre Ghana, Togo, Bénin et Nigeria.' ) .
				'<p><a href="/le-gbe/linguistique/travaux-scientifiques-recents/">Travaux scientifiques →</a> · <a href="/le-gbe/linguistique/potentialites-lexicales/">Potentialités lexicales →</a></p>',
			'children' => gbe_get_recherche_innovation_children(),
		),
		array(
			'title'    => 'Séjours et Mobilité',
			'slug'     => 'sejours-et-mobilite',
			'content'  => gbe_intro( 'Découvrir les cultures gbe sur le terrain : immersion linguistique, tourisme culturel et mobilité universitaire.' ),
			'children' => gbe_get_sejours_mobilite_children(),
		),
		array(
			'title'    => 'Sport et Jeunesse',
			'slug'     => 'sport-et-jeunesse',
			'content'  => gbe_intro( 'Sport, jeunesse et échanges interculturels au service du dialogue entre les peuples.' ),
			'children' => array(
				array( 'title' => 'Football', 'slug' => 'football', 'content' => gbe_outline( array( 'Camps d\'été', 'Camps d\'hiver', 'Échanges Afrique–Europe' ) ) ),
				array( 'title' => 'Échanges interculturels', 'slug' => 'echanges-interculturels', 'content' => gbe_intro( 'Programmes d\'échange entre jeunes des cultures gbe et partenaires internationaux.' ) ),
				array( 'title' => 'Formation', 'slug' => 'formation-jeunesse', 'content' => gbe_intro( 'Formation des jeunes par le sport et la culture.' ) ),
				array( 'title' => 'Leadership', 'slug' => 'leadership', 'content' => gbe_outline( array( 'Respect', 'Solidarité', 'Leadership', 'Diversité culturelle' ) ) ),
			),
		),
		array(
			'title'    => 'Partenaires',
			'slug'     => 'partenaires',
			'content'  => '<p>Réseau international de coopération académique, culturelle et institutionnelle.</p>[gbe_partenaires_list limit="48"]',
			'children' => gbe_get_partenaires_children(),
		),
		array(
			'title'    => 'Nous Soutenir',
			'slug'     => 'nous-soutenir',
			'content'  => gbe_intro( 'Rejoignez le projet GbeCosmoLingua et contribuez à la préservation des langues et patrimoines gbe.' ),
			'children' => array(
				array( 'title' => 'Adhérer', 'slug' => 'adherer', 'content' => '<p>Rejoignez la communauté GbeCosmoLingua en tant que membre associé.</p>[gbe_formulaire type="partenaire"]' ),
				array( 'title' => 'Devenir partenaire', 'slug' => 'devenir-partenaire', 'content' => '[gbe_formulaire type="partenaire"]' ),
				array( 'title' => 'Devenir mécène', 'slug' => 'devenir-mecene', 'content' => '[gbe_formulaire type="mecene"]' ),
				array( 'title' => 'Faire un don', 'slug' => 'faire-un-don', 'content' => '[gbe_formulaire type="don"]' ),
				array( 'title' => 'Proposer un projet', 'slug' => 'proposer-un-projet', 'content' => '[gbe_formulaire type="projet"]' ),
				array( 'title' => 'Accueillir un chercheur', 'slug' => 'accueillir-un-chercheur', 'content' => '[gbe_formulaire type="stagiaire"]' ),
			),
		),
	);
}
