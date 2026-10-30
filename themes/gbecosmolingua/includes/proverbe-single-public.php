<?php
/**
 * Affichage public — fiche proverbe (single).
 *
 * @package GbeCosmoLingua
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL banque de proverbes.
 *
 * @return string
 */
function gbecosmolingua_proverbe_banque_url() {
	return function_exists( 'gbecosmolingua_paremiologie_page_url' )
		? gbecosmolingua_paremiologie_page_url( 'banque-numerique-proverbes' )
		: home_url( '/paremiologie/banque-numerique-proverbes/' );
}

/**
 * Texte original affiché (meta ou titre).
 *
 * @param int $post_id ID proverbe.
 * @return string
 */
function gbecosmolingua_proverbe_original_text( $post_id ) {
	$texte = class_exists( 'GBE_Frontend' ) ? GBE_Frontend::get_meta( $post_id, 'texte_original' ) : '';
	if ( $texte ) {
		return wp_strip_all_tags( (string) $texte );
	}
	return wp_strip_all_tags( get_the_title( $post_id ) );
}

/**
 * Proverbes précédent / suivant.
 *
 * @param int $post_id ID proverbe.
 * @return array{prev: array{url: string, title: string}|null, next: array{url: string, title: string}|null}
 */
function gbecosmolingua_proverbe_adjacent_links( $post_id ) {
	$prev = get_previous_post();
	$next = get_next_post();
	$out  = array(
		'prev' => null,
		'next' => null,
	);

	if ( $prev instanceof WP_Post ) {
		$out['prev'] = array(
			'url'   => get_permalink( $prev ),
			'title' => gbecosmolingua_proverbe_original_text( (int) $prev->ID ),
		);
	}
	if ( $next instanceof WP_Post ) {
		$out['next'] = array(
			'url'   => get_permalink( $next ),
			'title' => gbecosmolingua_proverbe_original_text( (int) $next->ID ),
		);
	}

	return $out;
}

/**
 * HTML fiche proverbe complète.
 *
 * @param WP_Post|null $post Proverbe.
 * @return string
 */
function gbecosmolingua_proverbe_single_html( $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		$post = get_queried_object();
	}
	if ( ! $post instanceof WP_Post || 'proverbe' !== $post->post_type ) {
		return '';
	}

	$post_id  = (int) $post->ID;
	$original = gbecosmolingua_proverbe_original_text( $post_id );
	$langues  = get_the_terms( $post_id, 'langue_gbe' );
	$lang_label = __( 'Proverbe gbe', 'gbecosmolingua' );
	if ( $langues && ! is_wp_error( $langues ) ) {
		$lang_label = $langues[0]->name;
	}

	$get_meta = static function ( $key ) use ( $post_id ) {
		return class_exists( 'GBE_Frontend' ) ? GBE_Frontend::get_meta( $post_id, $key ) : '';
	};

	$translations = array(
		'traduction_fr' => __( 'Français', 'gbecosmolingua' ),
		'traduction_en' => __( 'English', 'gbecosmolingua' ),
		'traduction_es' => __( 'Español', 'gbecosmolingua' ),
		'traduction_ru' => __( 'Русский', 'gbecosmolingua' ),
	);

	$translation_cards = array();
	foreach ( $translations as $key => $label ) {
		$value = trim( (string) $get_meta( $key ) );
		if ( '' !== $value ) {
			$translation_cards[] = array(
				'label' => $label,
				'value' => $value,
				'code'  => str_replace( 'traduction_', '', $key ),
			);
		}
	}

	$transcription = trim( (string) $get_meta( 'transcription' ) );
	$show_transcription = '' !== $transcription && $transcription !== $original;

	$contexte   = trim( (string) $get_meta( 'contexte' ) );
	$commentaire = trim( (string) $get_meta( 'commentaire_culturel' ) );

	$analyses_map = array(
		'analyse_linguistique'   => __( 'Analyse linguistique', 'gbecosmolingua' ),
		'analyse_pragmatique'    => __( 'Analyse pragmatique', 'gbecosmolingua' ),
		'analyse_ethnographique' => __( 'Analyse ethnographique', 'gbecosmolingua' ),
	);
	$analyses = array();
	foreach ( $analyses_map as $key => $label ) {
		$value = trim( (string) $get_meta( $key ) );
		if ( '' !== $value ) {
			$analyses[] = array(
				'label' => $label,
				'value' => $value,
			);
		}
	}

	$adjacent = gbecosmolingua_proverbe_adjacent_links( $post_id );
	$hero_style = function_exists( 'gbecosmolingua_paremiologie_image_style' )
		? gbecosmolingua_paremiologie_image_style( 'hero-proverbes.jpg', '--gbe-proverbe-single-hero-image' )
		: '';

	ob_start();
	?>
	<article class="gbe-proverbe-single">
		<header class="gbe-proverbe-single__hero"<?php echo $hero_style ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?>>
			<div class="gbe-proverbe-single__hero-inner">
				<nav class="gbe-proverbe-single__breadcrumb" aria-label="<?php esc_attr_e( 'Fil d\'Ariane', 'gbecosmolingua' ); ?>">
					<a href="<?php echo esc_url( home_url( '/paremiologie/' ) ); ?>"><?php esc_html_e( 'Paremiologie', 'gbecosmolingua' ); ?></a>
					<span aria-hidden="true">›</span>
					<a href="<?php echo esc_url( gbecosmolingua_proverbe_banque_url() ); ?>"><?php esc_html_e( 'Banque de proverbes', 'gbecosmolingua' ); ?></a>
				</nav>
				<?php if ( $langues && ! is_wp_error( $langues ) ) : ?>
					<p class="gbe-proverbe-single__kicker">
						<?php foreach ( $langues as $term ) : ?>
							<span class="gbe-proverbe-single__lang"><?php echo esc_html( $term->name ); ?></span>
						<?php endforeach; ?>
					</p>
				<?php endif; ?>
				<blockquote class="gbe-proverbe-single__quote" cite="#gbe-proverbe-original">
					<p id="gbe-proverbe-original"><?php echo esc_html( $original ); ?></p>
				</blockquote>
				<p class="gbe-proverbe-single__meta"><?php echo esc_html( $lang_label ); ?> · <?php esc_html_e( 'Lododowo — tradition paremiologique gbe', 'gbecosmolingua' ); ?></p>
			</div>
		</header>

		<div class="gbe-proverbe-single__body">
			<?php if ( ! empty( $translation_cards ) ) : ?>
				<section class="gbe-proverbe-single__section" aria-labelledby="gbe-proverbe-translations-heading">
					<h2 id="gbe-proverbe-translations-heading" class="gbe-proverbe-single__section-title"><?php esc_html_e( 'Traductions', 'gbecosmolingua' ); ?></h2>
					<div class="gbe-proverbe-single__translations">
						<?php foreach ( $translation_cards as $card ) : ?>
							<div class="gbe-proverbe-single__translation gbe-proverbe-single__translation--<?php echo esc_attr( $card['code'] ); ?>">
								<p class="gbe-proverbe-single__translation-label"><?php echo esc_html( $card['label'] ); ?></p>
								<p class="gbe-proverbe-single__translation-text"><?php echo nl2br( esc_html( $card['value'] ) ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( $show_transcription || $contexte || $commentaire ) : ?>
				<h2 class="gbe-proverbe-single__section-title gbe-proverbe-single__section-title--panels"><?php esc_html_e( 'Documentation', 'gbecosmolingua' ); ?></h2>
			<?php endif; ?>
			<div class="gbe-proverbe-single__panels">
				<?php if ( $show_transcription ) : ?>
					<section class="gbe-proverbe-single__panel">
						<h2 class="gbe-proverbe-single__panel-title"><?php esc_html_e( 'Transcription', 'gbecosmolingua' ); ?></h2>
						<p class="gbe-proverbe-single__panel-body"><?php echo nl2br( esc_html( $transcription ) ); ?></p>
					</section>
				<?php endif; ?>

				<?php if ( $contexte ) : ?>
					<section class="gbe-proverbe-single__panel">
						<h2 class="gbe-proverbe-single__panel-title"><?php esc_html_e( 'Contexte d\'emploi', 'gbecosmolingua' ); ?></h2>
						<p class="gbe-proverbe-single__panel-body"><?php echo nl2br( esc_html( $contexte ) ); ?></p>
					</section>
				<?php endif; ?>

				<?php if ( $commentaire ) : ?>
					<section class="gbe-proverbe-single__panel gbe-proverbe-single__panel--accent">
						<h2 class="gbe-proverbe-single__panel-title"><?php esc_html_e( 'Commentaire culturel', 'gbecosmolingua' ); ?></h2>
						<p class="gbe-proverbe-single__panel-body"><?php echo nl2br( esc_html( $commentaire ) ); ?></p>
					</section>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $analyses ) ) : ?>
				<section class="gbe-proverbe-single__section gbe-proverbe-single__section--analyses" aria-labelledby="gbe-proverbe-analyses-heading">
					<h2 id="gbe-proverbe-analyses-heading" class="gbe-proverbe-single__section-title"><?php esc_html_e( 'Analyses', 'gbecosmolingua' ); ?></h2>
					<div class="gbe-proverbe-single__analyses">
						<?php foreach ( $analyses as $analysis ) : ?>
							<div class="gbe-proverbe-single__analysis">
								<h3 class="gbe-proverbe-single__analysis-title"><?php echo esc_html( $analysis['label'] ); ?></h3>
								<p class="gbe-proverbe-single__analysis-body"><?php echo nl2br( esc_html( $analysis['value'] ) ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( empty( $translation_cards ) && ! $show_transcription && ! $contexte && ! $commentaire && empty( $analyses ) ) : ?>
				<p class="gbe-proverbe-single__empty"><?php esc_html_e( 'Les traductions et analyses de ce proverbe seront complétées prochainement dans la banque paremiologique.', 'gbecosmolingua' ); ?></p>
			<?php endif; ?>
		</div>

		<footer class="gbe-proverbe-single__footer">
			<a class="gbe-proverbe-single__back" href="<?php echo esc_url( gbecosmolingua_proverbe_banque_url() ); ?>">
				<?php esc_html_e( '← Retour à la banque de proverbes', 'gbecosmolingua' ); ?>
			</a>
			<?php if ( $adjacent['prev'] || $adjacent['next'] ) : ?>
				<nav class="gbe-proverbe-single__pager" aria-label="<?php esc_attr_e( 'Navigation entre proverbes', 'gbecosmolingua' ); ?>">
					<?php if ( $adjacent['prev'] ) : ?>
						<a class="gbe-proverbe-single__pager-link gbe-proverbe-single__pager-link--prev" href="<?php echo esc_url( $adjacent['prev']['url'] ); ?>">
							<span class="gbe-proverbe-single__pager-kicker"><?php esc_html_e( 'Proverbe précédent', 'gbecosmolingua' ); ?></span>
							<span class="gbe-proverbe-single__pager-title"><?php echo esc_html( wp_trim_words( $adjacent['prev']['title'], 12, '…' ) ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $adjacent['next'] ) : ?>
						<a class="gbe-proverbe-single__pager-link gbe-proverbe-single__pager-link--next" href="<?php echo esc_url( $adjacent['next']['url'] ); ?>">
							<span class="gbe-proverbe-single__pager-kicker"><?php esc_html_e( 'Proverbe suivant', 'gbecosmolingua' ); ?></span>
							<span class="gbe-proverbe-single__pager-title"><?php echo esc_html( wp_trim_words( $adjacent['next']['title'], 12, '…' ) ); ?></span>
						</a>
					<?php endif; ?>
				</nav>
			<?php endif; ?>
		</footer>
	</article>
	<?php
	return (string) ob_get_clean();
}

/**
 * Shortcode fiche proverbe.
 *
 * @return string
 */
function gbecosmolingua_shortcode_proverbe_single() {
	return gbecosmolingua_proverbe_single_html();
}

/**
 * Évite wpautop() du bloc core/shortcode (HTML déjà structuré).
 *
 * @param string|null $pre_render Sortie anticipée.
 * @param array       $block      Bloc Gutenberg.
 * @return string|null
 */
function gbecosmolingua_pre_render_proverbe_single_shortcode_block( $pre_render, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/shortcode' ) {
		return $pre_render;
	}

	$inner = '';
	if ( ! empty( $block['innerContent'] ) && is_array( $block['innerContent'] ) ) {
		$inner = implode( '', $block['innerContent'] );
	}
	if ( '' === trim( $inner ) && ! empty( $block['innerHTML'] ) ) {
		$inner = (string) $block['innerHTML'];
	}

	$inner = trim( $inner );

	if ( '[gbe_proverbe_single]' === $inner ) {
		return gbecosmolingua_proverbe_single_html();
	}

	if ( str_contains( $inner, 'gbe-proverbe-single' ) ) {
		return $inner;
	}

	return $pre_render;
}
add_filter( 'pre_render_block', 'gbecosmolingua_pre_render_proverbe_single_shortcode_block', 10, 2 );
