<?php
/**
 * Page structure and content for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

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
			'content'    => '<p>Face aux défis de la mondialisation et aux risques d\'uniformisation culturelle, GbeCosmoLingua défend la diversité linguistique et culturelle comme une richesse fondamentale de l\'humanité.</p>
<p>Nous croyons que les langues, les traditions orales, les savoirs endogènes et les patrimoines culturels constituent des ressources essentielles pour construire un monde fondé sur le respect, la compréhension mutuelle et le dialogue entre les peuples.</p>
<p><strong>GbeCosmoLingua — Observatoire international des langues, cultures et patrimoines gbe : un pont entre les langues, les cultures et les peuples.</strong></p>',
			'menu_order' => 99,
		),
		array(
			'title'    => 'Le Gbe',
			'slug'     => 'le-gbe',
			'content'  => gbe_intro( 'Le continuum gbe constitue un vaste ensemble linguistique parlé principalement au Togo, au Bénin, au Ghana et au Nigeria. Selon les travaux de Hounkpati B. Capo, les variétés gbe appartiennent à une même unité linguistique présentant une forte intercompréhension et un héritage culturel commun.' ),
			'children' => gbe_get_le_gbe_children(),
		),
		array(
			'title'    => 'Cultures Gbe',
			'slug'     => 'cultures-gbe',
			'content'  => '<blockquote class="gbe-quote"><p>« La culture regroupe tout un ensemble de faits qui sont universels avant d\'être manifestés différemment selon les civilisations et les aires géographico-ethniques. »</p><cite>— Zouogbo (2009 : 28)</cite></blockquote>
<p><strong>Une culture vivante</strong> — Les cultures gbe se réinventent par le dialogue, la création et la transmission intergénérationnelle.</p>',
			'children' => gbe_get_cultures_gbe_children(),
		),
		array(
			'title'    => 'Xótùtù',
			'slug'     => 'xotutu',
			'content'  => gbe_intro( 'Le Xótùtù constitue la mémoire culturelle des peuples gbe. Il rassemble toutes les formes de transmission orale des savoirs, des valeurs, des croyances et des connaissances.' ),
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
					'content'  => gbe_intro( 'Étude des noms de personnes, de lieux, de peuples et de divinités dans les cultures gbe.' ),
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
			'content'  => gbe_intro( 'Axe scientifique majeur de GbeCosmoLingua : sagesse populaire, visions du monde et paremiologie comparée.' ),
			'children' => gbe_get_paremiologie_children(),
		),
		array(
			'title'    => 'Recherche et Innovation',
			'slug'     => 'recherche-et-innovation',
			'content'  => gbe_intro( 'Centre international d\'études gbe : recherche scientifique, innovation et coopération internationale.' ),
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
