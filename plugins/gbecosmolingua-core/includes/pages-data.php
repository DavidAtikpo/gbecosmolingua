<?php
/**
 * Page structure and content for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the full page tree for import.
 *
 * @return array<int, array<string, mixed>>
 */
function gbe_get_pages_data() {
	return array(
		array(
			'title'    => 'Notre philosophie',
			'slug'     => 'notre-philosophie',
			'content'  => '<p>Face aux défis de la mondialisation et aux risques d\'uniformisation culturelle, GbeCosmoLingua défend la diversité linguistique et culturelle comme une richesse fondamentale de l\'humanité.</p>
<p>Nous croyons que les langues, les traditions orales, les savoirs endogènes et les patrimoines culturels constituent des ressources essentielles pour construire un monde fondé sur le respect, la compréhension mutuelle et le dialogue entre les peuples.</p>
<p><strong>GbeCosmoLingua — Observatoire international des langues, cultures et patrimoines gbe : un pont entre les langues, les cultures et les peuples.</strong></p>',
			'menu_order' => 99,
		),
		array(
			'title'   => 'Le Gbe',
			'slug'    => 'le-gbe',
			'content' => '<p>Le continuum gbe constitue un vaste ensemble linguistique parlé principalement au Togo, au Bénin, au Ghana et au Nigeria. Selon les travaux de Hounkpati B. Capo, les variétés gbe appartiennent à une même unité linguistique présentant une forte intercompréhension et un héritage culturel commun.</p>',
			'children' => array(
				array(
					'title'   => 'Une langue, plusieurs variétés',
					'slug'    => 'une-langue-plusieurs-varietes',
					'content' => '<p>Le gbe : une langue, plusieurs variétés. Le continuum gbe constitue un vaste ensemble linguistique parlé principalement au Togo, au Bénin, au Ghana et au Nigeria.</p>',
				),
				array(
					'title'   => 'Le continuum gbe',
					'slug'    => 'le-continuum-gbe',
					'content' => '<h3>Variétés principales</h3><ul><li>Éwé</li><li>Gen (Mina)</li><li>Fon</li><li>Aja</li><li>Gun</li><li>Waci</li><li>Xwela</li><li>Xwla</li><li>Phla-Phera</li><li>Autres variétés du continuum</li></ul>
<h3>Pays et territoires</h3><ul><li>Togo</li><li>Bénin</li><li>Ghana</li><li>Nigeria</li></ul>',
				),
				array(
					'title'   => 'Carte interactive',
					'slug'    => 'carte-interactive',
					'content' => '<p>Explorez la répartition géographique des langues gbe, les zones culturelles, les routes migratoires historiques et les centres patrimoniaux.</p>[gbe_carte_interactive]',
				),
				array(
					'title'   => 'Histoire et origine des peuples gbe',
					'slug'    => 'histoire-et-origine',
					'content' => '<h3>Les récits fondateurs</h3><ul><li>Origines des peuples gbe</li><li>Notsé dans la mémoire collective</li><li>Traditions migratoires</li><li>Mythes et récits d\'origine</li></ul>
<h3>Royaumes et formations politiques</h3><ul><li>Royaumes précoloniaux</li><li>Chefferies traditionnelles</li><li>Organisation sociale et politique</li></ul>
<h3>Migrations et échanges</h3><ul><li>Relations interethniques</li><li>Réseaux commerciaux</li><li>Influences culturelles régionales</li></ul>',
				),
				array(
					'title'   => 'Ressources linguistiques',
					'slug'    => 'ressources-linguistiques',
					'content' => '<ul><li>Alphabet et orthographes</li><li>Phonologie</li><li>Morphologie</li><li>Syntaxe</li><li>Lexiques spécialisés</li><li>Corpus audio et vidéo</li><li>Bibliothèque numérique</li></ul>',
				),
			),
		),
		array(
			'title'   => 'Cultures Gbe',
			'slug'    => 'cultures-gbe',
			'content' => '<blockquote class="gbe-quote"><p>« La culture regroupe tout un ensemble de faits qui sont universels avant d\'être manifestés différemment selon les civilisations et les aires géographico-ethniques. »</p><cite>— Zouogbo (2009 : 28)</cite></blockquote>
<blockquote class="gbe-quote"><p>« La culture doit être considérée comme l\'ensemble des traits distinctifs spirituels et matériels, intellectuels et affectifs qui caractérisent une société ou un groupe social. »</p><cite>— Déclaration universelle de l\'UNESCO sur la diversité culturelle (2001)</cite></blockquote>
<p><strong>Une culture vivante</strong> — « Une culture ne peut être qualifiée de vivante que lorsqu\'elle interagit avec les autres, lorsque les individus y créent, mêlent, empruntent et réinventent des significations avec lesquelles ils peuvent s\'identifier. »</p>',
			'children' => array(
				array( 'title' => 'Comprendre la culture', 'slug' => 'comprendre-la-culture', 'content' => '<p>Comprendre la culture gbe dans sa diversité et sa vitalité contemporaine.</p>' ),
				array( 'title' => 'Arts', 'slug' => 'arts', 'content' => '<ul><li>Sculpture</li><li>Artisanat</li><li>Tissage</li><li>Poterie</li><li>Arts décoratifs</li></ul>' ),
				array( 'title' => 'Littérature', 'slug' => 'litterature', 'content' => '<ul><li>Littérature orale</li><li>Littérature écrite</li><li>Traditions narratives</li></ul>' ),
				array( 'title' => 'Musique et danse', 'slug' => 'musique-et-danse', 'content' => '<ul><li>Chants traditionnels</li><li>Musiques rituelles</li><li>Danses cérémonielles</li><li>Instruments de musique</li></ul>' ),
				array( 'title' => 'Gastronomie', 'slug' => 'gastronomie', 'content' => '<ul><li>Cuisine traditionnelle</li><li>Produits du terroir</li><li>Patrimoine alimentaire</li></ul>' ),
				array( 'title' => 'Architecture et habitat', 'slug' => 'architecture-et-habitat', 'content' => '<ul><li>Architecture vernaculaire</li><li>Habitat traditionnel</li></ul>' ),
				array( 'title' => 'Sciences et savoirs endogènes', 'slug' => 'sciences-et-savoirs-endogenes', 'content' => '<ul><li>Pharmacopée</li><li>Agriculture traditionnelle</li><li>Gestion de l\'environnement</li><li>Techniques artisanales</li></ul>' ),
				array( 'title' => 'Spiritualités et croyances', 'slug' => 'spiritualites-et-croyances', 'content' => '<ul><li>Vodun</li><li>Cultes ancestraux</li><li>Cosmologies africaines</li><li>Symboles et représentations</li></ul>' ),
				array( 'title' => 'Fêtes et cérémonies', 'slug' => 'fetes-et-ceremonies', 'content' => '<ul><li>Naissance</li><li>Initiation</li><li>Mariage</li><li>Funérailles</li><li>Fêtes communautaires</li></ul>' ),
			),
		),
		array(
			'title'   => 'Xótùtù',
			'slug'    => 'xotutu',
			'content' => '<p>Le xótùtù constitue la mémoire vivante des peuples gbe. Il rassemble les formes orales de transmission des savoirs, des valeurs, de l\'histoire et des visions du monde.</p>',
			'children' => array(
				array(
					'title'   => 'Genres de la littérature orale éwé',
					'slug'    => 'genres-litterature-orale-ewe',
					'content' => '<h3>Lododowo — Les proverbes éwé</h3><p>Les lododowo constituent l\'expression la plus condensée de la sagesse populaire éwé.</p>
<h3>Dzu lododowo</h3><p>Proverbes liés à la divination, aux savoirs sacrés et à l\'interprétation du destin.</p>
<h3>Hake</h3><p>Proverbes traditionnels à portée morale, éducative ou philosophique.</p>
<h3>Halo hamelo</h3><p>Énoncés sentencieux, proverbes circonstanciels et expressions sapientielles.</p>
<h3>Àlòbalo</h3><p>Énigmes, paraboles et récits à portée didactique.</p>
<h3>Nyàgblɔ̀ɖɛ</h3><p>Dictons et expressions proverbiales.</p>
<h3>Ègli</h3><p>Contes traditionnels et récits initiatiques.</p>
<h3>Àdzò</h3><p>Devinettes et jeux de réflexion.</p>
<h3>Xó</h3><p>Récits claniques, généalogies et mémoires lignagères.</p>
<h3>Èdù</h3><p>Messages divinatoires et paroles rituelles.</p>
<h3>ɖɛ̀wo</h3><p>Prières de libation et invocations ancestrales.</p>
<h3>Hàwo</h3><p>Chants traditionnels, chants rituels et chants communautaires.</p>',
				),
				array(
					'title'   => 'Tambours parlants',
					'slug'    => 'tambours-parlants',
					'content' => '<ul><li>Communication traditionnelle</li><li>Transmission des messages</li><li>Langage tambouriné</li><li>Patrimoine sonore</li></ul>',
				),
				array(
					'title'   => 'Bibliothèque numérique Xótùtù',
					'slug'    => 'bibliotheque-numerique-xotutu',
					'content' => '<p>Archives audio, vidéo, témoignages, manuscrits et corpus numériques de la tradition orale gbe.</p>[gbe_xotutu_list limit="24"]',
				),
			),
		),
		array(
			'title'   => 'Paremiologie',
			'slug'    => 'paremiologie',
			'content' => '<p>Cette rubrique constitue l\'un des axes scientifiques majeurs de GbeCosmoLingua. Sagesse populaire et visions du monde.</p>',
			'children' => array(
				array( 'title' => 'Corpus éwé', 'slug' => 'corpus-ewe', 'content' => '<ul><li>Lododowo</li><li>Dzu lododowo</li><li>Hake</li><li>Halo hamelo</li></ul>' ),
				array( 'title' => 'Corpus Gen/Mina', 'slug' => 'corpus-gen-mina', 'content' => '<ul><li>Proverbes gen</li><li>Expressions sentencieuses</li><li>Traditions sapientielles</li></ul>' ),
				array( 'title' => 'Corpus fon', 'slug' => 'corpus-fon', 'content' => '<ul><li>Proverbes fon</li><li>Formules proverbiales</li></ul>' ),
				array( 'title' => 'Corpus aja', 'slug' => 'corpus-aja', 'content' => '<p>Corpus paremiologique de la variété aja.</p>' ),
				array( 'title' => 'Corpus gun', 'slug' => 'corpus-gun', 'content' => '<p>Corpus paremiologique de la variété gun.</p>' ),
				array(
					'title'   => 'Banque numérique de proverbes',
					'slug'    => 'banque-numerique-proverbes',
					'content' => '<p>Pour chaque proverbe : texte original, transcription, traductions (français, espagnol, anglais, russe), contexte d\'emploi, commentaire culturel, analyses linguistique, pragmatique et ethnographique.</p>[gbe_proverbes_list limit="24"]',
				),
				array(
					'title'   => 'Comparaisons interculturelles',
					'slug'    => 'comparaisons-interculturelles',
					'content' => '<ul><li>Gbe – Français</li><li>Gbe – Espagnol</li><li>Gbe – Russe</li><li>Gbe – Anglais</li></ul>',
				),
				array(
					'title'   => 'Axes de recherche',
					'slug'    => 'axes-de-recherche',
					'content' => '<ul><li>Paremiologie comparée</li><li>Cosmovisions</li><li>Imaginaires culturels</li><li>Archétypes</li><li>Relations intergénérationnelles</li><li>Sagesse populaire</li><li>Traduction des proverbes</li><li>Paremacie</li><li>Paremacie interculturelle</li></ul>',
				),
			),
		),
		array(
			'title'   => 'Recherche et Formation',
			'slug'    => 'recherche-et-formation',
			'content' => '<p>Centre international d\'études gbe.</p>',
			'children' => array(
				array(
					'title'   => 'Domaines de recherche',
					'slug'    => 'domaines-de-recherche',
					'content' => '<ul><li>Linguistique</li><li>Anthropologie</li><li>Ethnolinguistique</li><li>Paremiologie</li><li>Littérature orale</li><li>Traduction</li><li>Interculturalité</li><li>Patrimoine culturel immatériel</li></ul>',
				),
				array(
					'title'   => 'Activités',
					'slug'    => 'activites',
					'content' => '<ul><li>Colloques</li><li>Conférences</li><li>Séminaires</li><li>Ateliers</li><li>Publications</li><li>Projets collaboratifs</li></ul>',
				),
				array(
					'title'   => 'Ressources documentaires',
					'slug'    => 'ressources-documentaires',
					'content' => '<p>Bibliothèque numérique, base documentaire, corpus linguistiques, archives scientifiques et base de données paremiologiques.</p>[gbe_bibliotheque]',
				),
			),
		),
		array(
			'title'   => 'Séjours et Mobilité',
			'slug'    => 'sejours-et-mobilite',
			'content' => '<p>Découvrir les cultures gbe sur le terrain.</p>',
			'children' => array(
				array( 'title' => 'Séjours linguistiques', 'slug' => 'sejours-linguistiques', 'content' => '<ul><li>Français</li><li>Éwé</li><li>Gen/Mina</li></ul>' ),
				array( 'title' => 'Immersion culturelle', 'slug' => 'immersion-culturelle', 'content' => '<ul><li>Familles d\'accueil</li><li>Artisanat</li><li>Cuisine traditionnelle</li><li>Patrimoine oral</li><li>Découverte des terroirs</li></ul>' ),
				array( 'title' => 'Mobilité académique', 'slug' => 'mobilite-academique', 'content' => '<ul><li>Orientation universitaire</li><li>Accompagnement administratif</li><li>Réseaux universitaires partenaires</li><li>Programmes de recherche</li></ul>' ),
				array( 'title' => 'Tourisme culturel responsable', 'slug' => 'tourisme-culturel-responsable', 'content' => '<ul><li>Circuits patrimoniaux</li><li>Tourisme communautaire</li><li>Écotourisme</li><li>Découverte des paysages culturels</li></ul>' ),
			),
		),
		array(
			'title'   => 'Sport et Interculturalité',
			'slug'    => 'sport-et-interculturalite',
			'content' => '<p>Langues, cultures et jeunesse.</p>',
			'children' => array(
				array( 'title' => 'Football et interculturalité', 'slug' => 'football-et-interculturalite', 'content' => '<ul><li>Camps d\'été</li><li>Camps d\'hiver</li><li>Échanges Afrique–Europe</li></ul>' ),
				array( 'title' => 'Partenariats sportifs', 'slug' => 'partenariats-sportifs', 'content' => '<ul><li>Académies</li><li>Centres de formation</li><li>Écoles sportives</li></ul>' ),
				array( 'title' => 'Valeurs', 'slug' => 'valeurs-sport', 'content' => '<ul><li>Respect</li><li>Solidarité</li><li>Leadership</li><li>Diversité culturelle</li></ul>' ),
			),
		),
		array(
			'title'   => 'Partenaires',
			'slug'    => 'partenaires',
			'content' => '<p>Réseau international de coopération.</p>',
			'children' => array(
				array( 'title' => 'Institutions diplomatiques', 'slug' => 'institutions-diplomatiques', 'content' => '<ul><li>Ambassades</li><li>Consulats</li></ul>' ),
				array( 'title' => 'Institutions culturelles', 'slug' => 'institutions-culturelles', 'content' => '<ul><li>Centres culturels</li><li>Musées</li><li>Fondations</li></ul>' ),
				array( 'title' => 'Institutions académiques', 'slug' => 'institutions-academiques', 'content' => '<ul><li>Universités</li><li>Laboratoires</li><li>Centres de recherche</li></ul>' ),
				array( 'title' => 'Organisations internationales', 'slug' => 'organisations-internationales', 'content' => '<ul><li>UNESCO</li><li>Organisation internationale de la Francophonie (OIF)</li><li>Union africaine</li><li>CEDEAO</li></ul>' ),
				array( 'title' => 'Réseaux pédagogiques', 'slug' => 'reseaux-pedagogiques', 'content' => '<ul><li>Écoles</li><li>Instituts de langues</li><li>Organismes de mobilité étudiante</li></ul>' ),
			),
		),
		array(
			'title'   => 'Nous Soutenir',
			'slug'    => 'nous-soutenir',
			'content' => '<p>Rejoignez le projet GbeCosmoLingua.</p>',
			'children' => array(
				array( 'title' => 'Devenir partenaire', 'slug' => 'devenir-partenaire', 'content' => '[gbe_formulaire type="partenaire"]' ),
				array( 'title' => 'Devenir mécène', 'slug' => 'devenir-mecene', 'content' => '[gbe_formulaire type="mecene"]' ),
				array( 'title' => 'Proposer un projet', 'slug' => 'proposer-un-projet', 'content' => '[gbe_formulaire type="projet"]' ),
				array( 'title' => 'Faire un don', 'slug' => 'faire-un-don', 'content' => '[gbe_formulaire type="don"]' ),
				array( 'title' => 'Accueillir un stagiaire ou un chercheur', 'slug' => 'accueillir-un-stagiaire', 'content' => '[gbe_formulaire type="stagiaire"]' ),
			),
		),
	);
}
