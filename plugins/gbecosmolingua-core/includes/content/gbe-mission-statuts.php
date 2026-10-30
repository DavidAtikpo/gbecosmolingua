<?php
/**
 * Objet et missions de GbeCosmoLingua — Articles 6 et 7 des statuts.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Paragraphes de l'article 6 — Objet.
 *
 * @return array<int, string>
 */
function gbe_mission_statuts_objet_paragraphs() {
	return array(
		__( 'GbeCosmoLingua a pour objet de contribuer à la connaissance, à la sauvegarde, à la transmission, à la promotion et à la valorisation des langues, cultures, patrimoines et savoirs, notamment ceux des peuples et communautés gbe, ainsi qu’au développement du dialogue interculturel et de la coopération scientifique, culturelle et éducative entre les peuples.', 'gbecosmolingua-core' ),
		__( 'L’association a notamment vocation à constituer une plateforme internationale de réflexion, de recherche, de documentation, de transmission et de valorisation des langues, cultures et patrimoines gbe.', 'gbecosmolingua-core' ),
	);
}

/**
 * Missions de l'article 7.
 *
 * @return array<int, string>
 */
function gbe_mission_statuts_missions() {
	return array(
		__( 'Contribuer à la documentation et à la sauvegarde des langues gbe.', 'gbecosmolingua-core' ),
		__( 'Promouvoir l’étude scientifique des langues, cultures, littératures, traditions orales, proverbes, expressions, récits et patrimoines gbe.', 'gbecosmolingua-core' ),
		__( 'Favoriser la transmission intergénérationnelle des savoirs et des patrimoines immatériels.', 'gbecosmolingua-core' ),
		__( 'Soutenir et promouvoir les recherches, études, enquêtes, publications et projets scientifiques portant sur les langues, cultures et patrimoines.', 'gbecosmolingua-core' ),
		__( 'Favoriser les échanges entre chercheurs, universitaires, enseignants, étudiants, artistes, acteurs culturels et communautés.', 'gbecosmolingua-core' ),
		__( 'Promouvoir l’apprentissage et l’enseignement des langues, notamment des langues gbe.', 'gbecosmolingua-core' ),
		__( 'Développer des ressources et plateformes numériques destinées à la documentation, à l’enseignement et à la diffusion des savoirs.', 'gbecosmolingua-core' ),
		__( 'Contribuer à la constitution, à la conservation et à la valorisation de corpus linguistiques, culturels et patrimoniaux.', 'gbecosmolingua-core' ),
		__( 'Organiser des conférences, colloques, séminaires, ateliers, expositions, rencontres et manifestations scientifiques et culturelles.', 'gbecosmolingua-core' ),
		__( 'Favoriser la coopération entre institutions africaines, européennes et internationales.', 'gbecosmolingua-core' ),
		__( 'Développer des programmes d’immersion linguistique et culturelle.', 'gbecosmolingua-core' ),
		__( 'Promouvoir un tourisme culturel et linguistique responsable, durable et respectueux des communautés et des patrimoines.', 'gbecosmolingua-core' ),
		__( 'Contribuer à la mise en valeur des territoires, patrimoines, savoir-faire et expressions culturelles.', 'gbecosmolingua-core' ),
		__( 'Développer des partenariats avec des universités, centres de recherche, institutions publiques, organisations internationales, associations, fondations et autres partenaires.', 'gbecosmolingua-core' ),
		__( 'Soutenir les initiatives de jeunesse et les projets favorisant la transmission, l’innovation et la créativité culturelle.', 'gbecosmolingua-core' ),
		__( 'Mettre les technologies numériques et les outils innovants, y compris l’intelligence artificielle lorsque cela est pertinent et légalement permis, au service de la documentation, de la recherche, de la conservation et de la diffusion des savoirs.', 'gbecosmolingua-core' ),
	);
}

/**
 * Liste HTML des missions.
 *
 * @param array<string, string> $args Options : numbered, class, limit.
 * @return string
 */
function gbe_mission_statuts_missions_list_html( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'numbered' => true,
			'class'    => 'gbe-mission-list gbe-mission-list--statuts',
			'limit'    => 0,
		)
	);

	$missions = gbe_mission_statuts_missions();
	$limit    = (int) $args['limit'];
	if ( $limit > 0 ) {
		$missions = array_slice( $missions, 0, $limit );
	}

	$tag = ! empty( $args['numbered'] ) ? 'ol' : 'ul';

	ob_start();
	printf( '<%1$s class="%2$s">', esc_attr( $tag ), esc_attr( (string) $args['class'] ) );
	foreach ( $missions as $mission ) {
		echo '<li>' . esc_html( $mission ) . '</li>';
	}
	printf( '</%s>', esc_attr( $tag ) );
	return (string) ob_get_clean();
}

/**
 * Grille HTML des missions (page Notre philosophie).
 *
 * @return string
 */
function gbe_mission_statuts_missions_grid_html() {
	$missions = gbe_mission_statuts_missions();

	ob_start();
	?>
	<div class="gbe-philosophie-missions-grid" role="list">
		<?php foreach ( $missions as $index => $mission ) : ?>
			<article class="gbe-philosophie-mission-card" role="listitem">
				<span class="gbe-philosophie-mission-card__num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
				<p class="gbe-philosophie-mission-card__text"><?php echo esc_html( $mission ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Contenu complet page Notre philosophie.
 *
 * @return string
 */
function gbe_philosophie_page_content() {
	$mission_count = count( gbe_mission_statuts_missions() );

	ob_start();
	?>
	<div class="gbe-philosophie-page">
		<nav class="gbe-philosophie-nav" aria-label="<?php esc_attr_e( 'Sections de la page', 'gbecosmolingua-core' ); ?>">
			<a class="gbe-philosophie-nav__link" href="#philosophie"><?php esc_html_e( 'Philosophie', 'gbecosmolingua-core' ); ?></a>
			<a class="gbe-philosophie-nav__link" href="#objet"><?php esc_html_e( 'Objet', 'gbecosmolingua-core' ); ?></a>
			<a class="gbe-philosophie-nav__link" href="#missions"><?php esc_html_e( 'Missions', 'gbecosmolingua-core' ); ?></a>
			<a class="gbe-philosophie-nav__link" href="#fondateurs"><?php esc_html_e( 'Fondateurs', 'gbecosmolingua-core' ); ?></a>
		</nav>

		<section id="philosophie" class="gbe-philosophie-section gbe-philosophie-section--intro">
			<div class="gbe-philosophie-quote">
				<p><?php esc_html_e( 'Face aux défis de la mondialisation et aux risques d’uniformisation culturelle, GbeCosmoLingua défend la diversité linguistique et culturelle comme une richesse fondamentale de l’humanité.', 'gbecosmolingua-core' ); ?></p>
				<p><?php esc_html_e( 'Nous croyons que les langues, les traditions orales, les savoirs endogènes et les patrimoines culturels constituent des ressources essentielles pour construire un monde fondé sur le respect, la compréhension mutuelle et le dialogue entre les peuples.', 'gbecosmolingua-core' ); ?></p>
			</div>
			<p class="gbe-philosophie-tagline"><strong><?php esc_html_e( 'GbeCosmoLingua — Observatoire international des langues, cultures et patrimoines gbe : un pont entre les langues, les cultures et les peuples.', 'gbecosmolingua-core' ); ?></strong></p>
		</section>

		<section id="objet" class="gbe-philosophie-section">
			<header class="gbe-philosophie-section__head">
				<p class="gbe-philosophie-section__kicker"><?php esc_html_e( 'Article 6', 'gbecosmolingua-core' ); ?></p>
				<h2 class="gbe-philosophie-section__title"><?php esc_html_e( 'Notre objet', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-philosophie-section__lead"><?php esc_html_e( 'La finalité statutaire de l’association.', 'gbecosmolingua-core' ); ?></p>
			</header>
			<div class="gbe-philosophie-objet-card">
				<?php foreach ( gbe_mission_statuts_objet_paragraphs() as $paragraph ) : ?>
					<p><?php echo esc_html( $paragraph ); ?></p>
				<?php endforeach; ?>
			</div>
		</section>

		<section id="missions" class="gbe-philosophie-section gbe-philosophie-section--missions">
			<header class="gbe-philosophie-section__head">
				<p class="gbe-philosophie-section__kicker"><?php esc_html_e( 'Article 7', 'gbecosmolingua-core' ); ?></p>
				<h2 class="gbe-philosophie-section__title"><?php esc_html_e( 'Nos missions', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-philosophie-section__lead"><?php esc_html_e( 'Pour réaliser son objet, l’association a notamment pour missions :', 'gbecosmolingua-core' ); ?></p>
			</header>
			<p class="gbe-philosophie-missions-count">
				<span class="gbe-philosophie-missions-count__value"><?php echo esc_html( (string) $mission_count ); ?></span>
				<span class="gbe-philosophie-missions-count__label"><?php esc_html_e( 'missions statutaires', 'gbecosmolingua-core' ); ?></span>
			</p>
			<?php echo gbe_mission_statuts_missions_grid_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<div id="fondateurs" class="gbe-philosophie-section gbe-philosophie-section--fondateurs">
			<header class="gbe-philosophie-section__head gbe-philosophie-section__head--center">
				<p class="gbe-philosophie-section__kicker"><?php esc_html_e( 'Gouvernance', 'gbecosmolingua-core' ); ?></p>
				<h2 class="gbe-philosophie-section__title"><?php esc_html_e( 'Membres fondateurs', 'gbecosmolingua-core' ); ?></h2>
			</header>
			[gbe_membres_fondateurs show_title="0"]
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Section accueil — objet et missions (statuts).
 *
 * @return string
 */
function gbe_home_vision_mission_section_html() {
	ob_start();
	?>
	<div class="wp-block-group alignfull gbe-section gbe-home-vision-wrap">
		<div class="wp-block-group gbe-home-vision">
			<div class="wp-block-group gbe-home-vision__block">
				<h2 class="wp-block-heading gbe-home-vision__title"><?php esc_html_e( 'Notre objet', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-mission-source gbe-mission-source--inline"><em><?php esc_html_e( 'Article 6 — statuts', 'gbecosmolingua-core' ); ?></em></p>
				<?php foreach ( gbe_mission_statuts_objet_paragraphs() as $paragraph ) : ?>
					<p><?php echo esc_html( $paragraph ); ?></p>
				<?php endforeach; ?>
			</div>
			<div class="wp-block-group gbe-home-vision__block gbe-home-vision__block--mission">
				<h2 class="wp-block-heading gbe-home-vision__title"><?php esc_html_e( 'Nos missions', 'gbecosmolingua-core' ); ?></h2>
				<p class="gbe-mission-source gbe-mission-source--inline"><em><?php esc_html_e( 'Article 7 — statuts', 'gbecosmolingua-core' ); ?></em></p>
				<p><?php esc_html_e( 'Pour réaliser son objet, l’association a notamment pour missions :', 'gbecosmolingua-core' ); ?></p>
				<?php
				echo gbe_mission_statuts_missions_list_html( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					array(
						'class'    => 'gbe-mission-list gbe-home-vision__mission-list gbe-mission-list--statuts',
						'numbered' => true,
					)
				);
				?>
				<p class="gbe-home-vision__more">
					<a href="<?php echo esc_url( home_url( '/notre-philosophie/#missions' ) ); ?>"><?php esc_html_e( 'Lire la mission sur la page Notre philosophie →', 'gbecosmolingua-core' ); ?></a>
				</p>
			</div>
		</div>
		<div class="wp-block-group gbe-home-vision-devise">
			<h3 class="wp-block-heading gbe-home-vision-devise__title"><?php esc_html_e( 'Notre devise', 'gbecosmolingua-core' ); ?></h3>
			<p class="gbe-devise"><?php esc_html_e( 'Valoriser nos langues, transmettre nos savoirs, construire des ponts entre les cultures.', 'gbecosmolingua-core' ); ?></p>
		</div>
	</div>
	<?php
	return (string) ob_get_clean();
}
