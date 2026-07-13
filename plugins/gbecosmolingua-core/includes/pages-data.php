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
			'children' => array(
				array(
					'title'   => 'Présentation générale',
					'slug'    => 'presentation-generale',
					'content' => gbe_intro( 'Le gbe : une langue, plusieurs variétés. Présentation du continuum linguistique et de sa vitalité contemporaine.' ),
				),
				array(
					'title'   => 'Le continuum gbe',
					'slug'    => 'le-continuum-gbe',
					'content' => '<h3>Variétés principales</h3>' . gbe_outline( array( 'Éwé', 'Gen (Mina)', 'Fon', 'Aja', 'Gun', 'Waci', 'Xwela', 'Xwla', 'Phla-Phera', 'Autres variétés du continuum' ) ) .
						'<h3>Pays et territoires</h3>' . gbe_outline( array( 'Togo', 'Bénin', 'Ghana', 'Nigeria' ) ),
				),
				array(
					'title'   => 'Carte interactive',
					'slug'    => 'carte-interactive',
					'content' => '<p>Explorez la répartition géographique des langues gbe, les zones culturelles, les routes migratoires historiques et les centres patrimoniaux.</p>[gbe_carte_interactive]',
				),
				array(
					'title'   => 'Histoire et migrations',
					'slug'    => 'histoire-et-migrations',
					'content' => '<h3>Les récits fondateurs</h3>' . gbe_outline( array( 'Origines des peuples gbe', 'Notsé dans la mémoire collective', 'Traditions migratoires', 'Mythes et récits d\'origine' ) ) .
						'<h3>Royaumes et formations politiques</h3>' . gbe_outline( array( 'Royaumes précoloniaux', 'Chefferies traditionnelles', 'Organisation sociale et politique' ) ) .
						'<h3>Migrations et échanges</h3>' . gbe_outline( array( 'Relations interethniques', 'Réseaux commerciaux', 'Influences culturelles régionales' ) ),
				),
				array(
					'title'   => 'Peuples du continuum',
					'slug'    => 'peuples-du-continuum',
					'content' => gbe_intro( 'Les peuples gbe partagent une histoire, des traditions et des systèmes de pensée communs, tout en présentant une riche diversité culturelle et linguistique.' ) .
						gbe_outline( array( 'Identités et ethnonymes', 'Organisation sociale', 'Chefferies et royaumes', 'Diaspora gbe', 'Vitalité culturelle contemporaine' ) ),
				),
				array(
					'title'    => 'Les langues',
					'slug'     => 'les-langues',
					'content'  => gbe_intro( 'Documentation des variétés principales du continuum gbe.' ),
					'children' => gbe_get_langue_pages(),
				),
				array(
					'title'    => 'Linguistique',
					'slug'     => 'linguistique',
					'content'  => gbe_intro( 'Ressources linguistiques pour l\'étude scientifique des variétés gbe.' ),
					'children' => gbe_get_linguistique_pages(),
				),
				array(
					'title'   => 'Corpus numériques',
					'slug'    => 'corpus-numeriques',
					'content' => gbe_intro( 'Accédez aux corpus numériques de GbeCosmoLingua : proverbes, archives orales et ressources documentaires.' ) .
						'<p><a href="/paremiologie/banque-numerique-proverbes/">Banque de proverbes</a> · <a href="/xotutu/bibliotheque-numerique-xotutu/">Archives Xótùtù</a> · <a href="/recherche-et-innovation/ressources-documentaires/">Bibliothèque numérique</a></p>',
				),
				array(
					'title'   => 'Bibliothèque',
					'slug'    => 'bibliotheque-linguistique',
					'content' => '<p>Bibliothèque numérique des langues et patrimoines gbe.</p>[gbe_bibliotheque]',
				),
			),
		),
		array(
			'title'    => 'Cultures Gbe',
			'slug'     => 'cultures-gbe',
			'content'  => '<blockquote class="gbe-quote"><p>« La culture regroupe tout un ensemble de faits qui sont universels avant d\'être manifestés différemment selon les civilisations et les aires géographico-ethniques. »</p><cite>— Zouogbo (2009 : 28)</cite></blockquote>
<p><strong>Une culture vivante</strong> — Les cultures gbe se réinventent par le dialogue, la création et la transmission intergénérationnelle.</p>',
			'children' => array(
				array( 'title' => 'Arts', 'slug' => 'arts', 'content' => gbe_outline( array( 'Sculpture', 'Artisanat', 'Tissage', 'Poterie', 'Arts décoratifs' ) ) ),
				array( 'title' => 'Artisanat', 'slug' => 'artisanat', 'content' => gbe_intro( 'Techniques artisanales et savoir-faire traditionnels des peuples gbe.' ) ),
				array( 'title' => 'Architecture', 'slug' => 'architecture', 'content' => gbe_outline( array( 'Architecture vernaculaire', 'Habitat traditionnel', 'Espaces sacrés' ) ) ),
				array( 'title' => 'Musique', 'slug' => 'musique', 'content' => gbe_outline( array( 'Chants traditionnels', 'Musiques rituelles', 'Instruments de musique' ) ) ),
				array( 'title' => 'Danse', 'slug' => 'danse', 'content' => gbe_outline( array( 'Danses cérémonielles', 'Danses festives', 'Danses rituelles' ) ) ),
				array( 'title' => 'Gastronomie', 'slug' => 'gastronomie', 'content' => gbe_outline( array( 'Cuisine traditionnelle', 'Produits du terroir', 'Patrimoine alimentaire' ) ) ),
				array(
					'title'   => 'Savoirs endogènes',
					'slug'    => 'savoirs-endogenes',
					'content' => gbe_outline( array( 'Médecine traditionnelle', 'Pharmacopée', 'Agriculture traditionnelle', 'Gestion de l\'environnement', 'Techniques artisanales' ) ),
				),
				array(
					'title'   => 'Croyances et cosmologies',
					'slug'    => 'croyances-et-cosmologies',
					'content' => gbe_outline( array( 'Vodun', 'Cultes ancestraux', 'Cosmologies africaines', 'Religions et spiritualités', 'Symboles et représentations' ) ),
				),
				array(
					'title'   => 'Fêtes et cérémonies',
					'slug'    => 'fetes-et-ceremonies',
					'content' => gbe_outline( array( 'Naissance', 'Initiation', 'Mariage', 'Funérailles', 'Fêtes communautaires' ) ),
				),
				array(
					'title'   => 'Patrimoines matériels',
					'slug'    => 'patrimoines-materiels',
					'content' => gbe_intro( 'Sites, monuments, objets et témoignages matériels des cultures gbe.' ),
				),
				array(
					'title'   => 'Patrimoines immatériels',
					'slug'    => 'patrimoines-immateriels',
					'content' => gbe_intro( 'Traditions orales, savoir-faire, rituels et expressions vivantes du patrimoine gbe.' ),
				),
			),
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
			'children' => array(
				array( 'title' => 'Corpus éwé', 'slug' => 'corpus-ewe', 'content' => gbe_outline( array( 'Lododowo', 'Dzu lododowo', 'Hake', 'Halo hamelo' ) ) ),
				array( 'title' => 'Corpus Gen/Mina', 'slug' => 'corpus-gen-mina', 'content' => gbe_outline( array( 'Proverbes gen', 'Expressions sentencieuses', 'Traditions sapientielles' ) ) ),
				array( 'title' => 'Corpus fon', 'slug' => 'corpus-fon', 'content' => gbe_outline( array( 'Proverbes fon', 'Formules proverbiales' ) ) ),
				array( 'title' => 'Corpus aja', 'slug' => 'corpus-aja', 'content' => gbe_intro( 'Corpus paremiologique de la variété aja.' ) ),
				array( 'title' => 'Corpus gun', 'slug' => 'corpus-gun', 'content' => gbe_intro( 'Corpus paremiologique de la variété gun.' ) ),
				array(
					'title'   => 'Banque numérique de proverbes',
					'slug'    => 'banque-numerique-proverbes',
					'content' => '<p>Pour chaque proverbe : texte original, transcription, traductions, contexte, commentaire culturel et analyses.</p>[gbe_proverbes_list limit="24"]',
				),
				array( 'title' => 'Comparaisons interculturelles', 'slug' => 'comparaisons-interculturelles', 'content' => gbe_outline( array( 'Gbe – Français', 'Gbe – Espagnol', 'Gbe – Russe', 'Gbe – Anglais' ) ) ),
				array( 'title' => 'Axes de recherche', 'slug' => 'axes-de-recherche', 'content' => gbe_outline( array( 'Paremiologie comparée', 'Cosmovisions', 'Imaginaires culturels', 'Traduction des proverbes', 'Paremacie interculturelle' ) ) ),
			),
		),
		array(
			'title'    => 'Recherche et Innovation',
			'slug'     => 'recherche-et-innovation',
			'content'  => gbe_intro( 'Centre international d\'études gbe : recherche scientifique, innovation et coopération internationale.' ),
			'children' => array(
				array(
					'title'   => 'Domaines de recherche',
					'slug'    => 'domaines-de-recherche',
					'content' => gbe_outline( array( 'Linguistique', 'Anthropologie', 'Ethnolinguistique', 'Paremiologie', 'Onomastique', 'Traduction', 'Interculturalité', 'Humanités numériques' ) ),
				),
				array(
					'title'   => 'Humanités numériques',
					'slug'    => 'humanites-numeriques',
					'content' => gbe_intro( 'Corpus numériques, outils de recherche et méthodes des humanités numériques appliquées aux patrimoines gbe.' ),
				),
				array(
					'title'   => 'Observatoire documentaire',
					'slug'    => 'observatoire-documentaire',
					'content' => gbe_intro( 'Veille scientifique, base documentaire et ressources pour la recherche sur les langues et cultures gbe.' ),
				),
				array(
					'title'   => 'Activités',
					'slug'    => 'activites',
					'content' => '<p>Colloques, conférences, séminaires et publications de GbeCosmoLingua.</p>[gbe_evenements_list limit="24"]',
				),
				array(
					'title'   => 'Ressources documentaires',
					'slug'    => 'ressources-documentaires',
					'content' => '<p>Bibliothèque numérique, corpus linguistiques et archives scientifiques.</p>[gbe_bibliotheque]',
				),
			),
		),
		array(
			'title'    => 'Séjours et Mobilité',
			'slug'     => 'sejours-et-mobilite',
			'content'  => gbe_intro( 'Découvrir les cultures gbe sur le terrain : immersion linguistique, tourisme culturel et mobilité universitaire.' ),
			'children' => array(
				array( 'title' => 'Immersion linguistique', 'slug' => 'immersion-linguistique', 'content' => gbe_outline( array( 'Français', 'Éwé', 'Gen/Mina', 'Fon' ) ) ),
				array( 'title' => 'Tourisme culturel', 'slug' => 'tourisme-culturel', 'content' => gbe_outline( array( 'Circuits patrimoniaux', 'Tourisme communautaire', 'Écotourisme', 'Découverte des terroirs' ) ) ),
				array( 'title' => 'Mobilité universitaire', 'slug' => 'mobilite-universitaire', 'content' => gbe_outline( array( 'Orientation universitaire', 'Réseaux partenaires', 'Programmes de recherche' ) ) ),
				array( 'title' => 'Stages', 'slug' => 'stages', 'content' => gbe_intro( 'Stages de terrain, de recherche et d\'immersion culturelle.' ) ),
				array( 'title' => 'Programmes d\'été', 'slug' => 'programmes-ete', 'content' => gbe_intro( 'Séjours estivaux d\'immersion linguistique et culturelle.' ) ),
				array( 'title' => 'Programmes d\'hiver', 'slug' => 'programmes-hiver', 'content' => gbe_intro( 'Programmes hivernaux d\'échanges et de formation.' ) ),
			),
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
			'children' => array(
				array( 'title' => 'Universités et laboratoires', 'slug' => 'universites-laboratoires', 'content' => gbe_outline( array( 'Universités', 'Laboratoires', 'Centres de recherche' ) ) ),
				array( 'title' => 'UNESCO', 'slug' => 'unesco', 'content' => gbe_intro( 'Coopération avec l\'UNESCO pour la sauvegarde du patrimoine culturel immatériel.' ) ),
				array( 'title' => 'OIF', 'slug' => 'oif', 'content' => gbe_intro( 'Partenariat avec l\'Organisation internationale de la Francophonie.' ) ),
				array( 'title' => 'CEDEAO et Union africaine', 'slug' => 'cedeao-union-africaine', 'content' => gbe_intro( 'Coopération régionale et panafricaine.' ) ),
				array( 'title' => 'Ambassades et centres culturels', 'slug' => 'ambassades-centres-culturels', 'content' => gbe_outline( array( 'Ambassades', 'Centres culturels', 'Instituts' ) ) ),
				array( 'title' => 'Fondations', 'slug' => 'fondations', 'content' => gbe_intro( 'Fondations soutenant la recherche et la culture gbe.' ) ),
				array( 'title' => 'Diaspora gbe', 'slug' => 'diaspora-gbe', 'content' => gbe_intro( 'Réseaux de la diaspora gbe et partenariats communautaires.' ) ),
			),
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
