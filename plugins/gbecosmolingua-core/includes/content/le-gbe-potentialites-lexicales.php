<?php
/**
 * Contenu éditorial — potentialités lexicales de Gbe (chapitre 6).
 *
 * Source : H. C. Capo, Les potentialités du Gbe.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * HTML de la page « Potentialités lexicales de Gbe ».
 *
 * @return string
 */
function gbe_le_gbe_potentialites_lexicales_content() {
	ob_start();
	?>
	<div class="gbe-chapter">
		<p class="gbe-source-note"><em><?php esc_html_e( 'Chapitre 6 — Les potentialités du Gbe : ressources internes, emprunts et combinaisons pour l’enrichissement lexical.', 'gbecosmolingua-core' ); ?></em></p>

		<?php
		echo gbe_chapter_stats( gbe_le_gbe_potentialites_stats() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gbe_chapter_nav( gbe_le_gbe_potentialites_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<section id="generalites" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Généralités', 'gbecosmolingua-core' ); ?></h2>
			<p class="gbe-chapter-section__lead"><?php esc_html_e( 'Les travaux de description scientifique sur Gbe ne manquent plus — l’une des conditions préparatoires à la renaissance linguistique est remplie. Il faut aussi montrer que les conditions d’enrichissement du vocabulaire existent.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Gbe est souvent qualifié de langue monosyllabique : la vaste majorité des lexèmes de base sont de forme (C)V ou (C)εV (/c/ = l, y ou w). Malgré cela, le gbe dispose de ressources morphologiques et syntaxiques variées pour étendre son lexique.', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="internes" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Ressources internes', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'La plupart des noms monoléxiques ont la structure VC(c)V ; le V initial est un préfixe nominal (souvent e-, parfois è-, ɛ̀-, ò-, ɔ̀-, i-).', 'gbecosmolingua-core' ); ?></p>
			<h3><?php esc_html_e( '(i) Suffixation', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_potentialites_suffixes() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<h3><?php esc_html_e( '(ii) à (xiv) — Autres procédés internes', 'gbecosmolingua-core' ); ?></h3>
			<?php echo gbe_chapter_list( gbe_le_gbe_ressources_internes() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="externes" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Ressources externes', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Emprunts au portugais, à l’arabe (via yoruba/hausa), à l’akan, au yoruba, à l’allemand, au français et à l’anglais. Distinction entre emprunts graphiques (via documents écrits) et emprunts oraux (s’intègrent à la phonologie gbe).', 'gbecosmolingua-core' ); ?></p>
			<?php echo gbe_chapter_ref_cards( gbe_le_gbe_potentialites_emprunts_cards() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<p><?php esc_html_e( 'Les emprunts oraux intègrent [p], voyelles longues et séquences vocaliques (kaatɔn, pépɑ, pósu, lagáá…). Les emprunts graphiques (mois allemands en Éwé : Yanuar, Februar…) ont été largement remplacés par des créations endogènes (Dzove, Dzodze…).', 'gbecosmolingua-core' ); ?></p>
		</section>

		<section id="combinaisons" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Combinaisons', 'gbecosmolingua-core' ); ?></h2>
			<?php echo gbe_chapter_list( gbe_le_gbe_combinaisons_lexicales() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</section>

		<section id="conclusion" class="gbe-chapter-section">
			<h2><?php esc_html_e( 'Conclusion', 'gbecosmolingua-core' ); ?></h2>
			<p><?php esc_html_e( 'Cette étude confirme que les potentialités créatives du gbe sont réelles. Pazzi (1981:8) montre que, malgré la structure (C)V des verbes, les compositions grammaticales produisent un vocabulaire riche capable d’assimiler de nouveaux concepts.', 'gbecosmolingua-core' ); ?></p>
			<p><?php esc_html_e( 'Les tableaux 18 et 19 (Duthie & Vlaardingerbroek, 1981) recensent des publications et manuels en gbe (religion, fiction, orthographe, agriculture…). La Bible existe en Éwé ; la Loi fondamentale de la R.P. Bénin a été traduite en Fon et en Aja.', 'gbecosmolingua-core' ); ?></p>
			<div class="gbe-chapter-callout">
				<p><?php esc_html_e( 'Avec la standardisation en cours, le gbe peut acquérir souplesse et stabilité ; son emploi dans toutes les sphères de la vie devra être positivement encouragé.', 'gbecosmolingua-core' ); ?></p>
			</div>
		</section>

		<?php
		echo gbe_chapter_footer_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				array(
					'url'   => '/le-gbe/linguistique/travaux-scientifiques-recents/',
					'label' => __( 'Travaux scientifiques', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/lexicologie/',
					'label' => __( 'Lexicologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/le-gbe/linguistique/morphologie/',
					'label' => __( 'Morphologie', 'gbecosmolingua-core' ),
				),
				array(
					'url'   => '/paremiologie/banque-numerique-proverbes/',
					'label' => __( 'Banque de proverbes', 'gbecosmolingua-core' ),
				),
			)
		);
		?>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * @return array<int, array{value: string, label: string}>
 */
function gbe_le_gbe_potentialites_stats() {
	return array(
		array( 'value' => '(C)V', 'label' => __( 'Lexèmes monosyllabiques', 'gbecosmolingua-core' ) ),
		array( 'value' => '14', 'label' => __( 'Procédés internes recensés', 'gbecosmolingua-core' ) ),
		array( 'value' => '770+', 'label' => __( 'Publications gbe (Duthie)', 'gbecosmolingua-core' ) ),
		array( 'value' => '1981', 'label' => __( 'Pazzi — vocabulaire Gen', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return array<int, array{id: string, label: string}>
 */
function gbe_le_gbe_potentialites_nav() {
	return array(
		array( 'id' => 'generalites', 'label' => __( 'Généralités', 'gbecosmolingua-core' ) ),
		array( 'id' => 'internes', 'label' => __( 'Internes', 'gbecosmolingua-core' ) ),
		array( 'id' => 'externes', 'label' => __( 'Externes', 'gbecosmolingua-core' ) ),
		array( 'id' => 'combinaisons', 'label' => __( 'Combinaisons', 'gbecosmolingua-core' ) ),
		array( 'id' => 'conclusion', 'label' => __( 'Conclusion', 'gbecosmolingua-core' ) ),
	);
}

/**
 * @return string[]
 */
function gbe_le_gbe_potentialites_suffixes() {
	return array(
		__( '-tó (ètó « père, propriétaire ») : klisotó « chrétien »', 'gbecosmolingua-core' ),
		__( '-nɔ (ènɔ « mère ») : yepheno « révérend père »', 'gbecosmolingua-core' ),
		__( '-tsú (àtsú « homme ») : gatsú « clou géant »', 'gbecosmolingua-core' ),
		__( '-nú (ènú « chose ») : kúnú « funérailles »', 'gbecosmolingua-core' ),
		__( '-nu (ènu « bouche ») : xonu « seuil »', 'gbecosmolingua-core' ),
		__( '-phé (àphé « maison ») : gaphé « banque commerciale »', 'gbecosmolingua-core' ),
		__( '-gbe (ègbe « jour ») : tenigbe « lundi » (Fon), vhunzángbe « vendredi » (Aja)', 'gbecosmolingua-core' ),
		__( 'Gen et Waci : -ti (àtí « unité de ») et -há (èhá « classe de ») pour les nombres (blatí, alofáhá, akpéhá…)', 'gbecosmolingua-core' ),
	);
}

/**
 * @return array<int, array{tag: string, title: string, body: string}>
 */
function gbe_le_gbe_potentialites_emprunts_cards() {
	return array(
		array(
			'tag'   => 'PT',
			'title' => __( 'Portugais', 'gbecosmolingua-core' ),
			'body'  => __( 'kamisá « chemise », mláto « mulâtre », sklúzu « croix », kaléta « masque », mágó « banc ».', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'AR',
			'title' => __( 'Arabe (via yoruba/hausa)', 'gbecosmolingua-core' ),
			'body'  => __( 'alájí, alája (pèlerinage à La Mecque), imámu « grand prêtre musulman ».', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'AK/YO',
			'title' => __( 'Akan / Yoruba', 'gbecosmolingua-core' ),
			'body'  => __( 'akpatá « véranda », safo « notable » ; légbá « divinité ».', 'gbecosmolingua-core' ),
		),
		array(
			'tag'   => 'FR/EN',
			'title' => __( 'Français / anglais (oraux)', 'gbecosmolingua-core' ),
			'body'  => __( 'bíki « stylo Bic », tóci « torche », kólayiki « école laïque », sukúlu « école », kúku « cuisinier », gíya « vitesse ».', 'gbecosmolingua-core' ),
		),
	);
}

/**
 * Processus internes de formation des noms.
 *
 * @return string[]
 */
function gbe_le_gbe_ressources_internes() {
	return array(
		__( '(ii) Redoublement : dzodzo « chaleur » (dzo « feu »), fafá « fraîcheur » (fa « faire frais »)', 'gbecosmolingua-core' ),
		__( '(iii) Composition par juxtaposition : wónviblì « mai » (wónvi + blì), nukúgo « lunettes » (nukú + go)', 'gbecosmolingua-core' ),
		__( '(iv) Suffixe -í : tógaí « boucle d’oreille », alogaí « bracelet », tokúí « janvier » (Gen/Waci)', 'gbecosmolingua-core' ),
		__( '(v) Nom + adjectif : phégbó « maison mère », núvóin « péché », amekokoi « saint »', 'gbecosmolingua-core' ),
		__( '(vi) Phrases courtes nominalisées : núwuame « poison », tedoxé « mars » (Éwé), kújitó-mókpóna-kúo « guerrier intrépide »', 'gbecosmolingua-core' ),
		__( '(vii) Séries verbales impératives : kpɔjlɔ « bouton », sewlan « dictée », kpɔwaí « exemple », jikói « dictionnaire » (Gen/Waci)', 'gbecosmolingua-core' ),
		__( '(viii) Séries verbales négatives : kanasá, jlómaji « enfant gâté »', 'gbecosmolingua-core' ),
		__( '(ix) Nom (+ ma) + verbe redoublé : núruru « nourriture », kadada « géométrie », núbablá « alliance »', 'gbecosmolingua-core' ),
		__( '(x) Nom (+ ma) + verbe simple : tsitú « bénédiction », séblá « complot », amemasi « irrévérence »', 'gbecosmolingua-core' ),
		__( '(xi) Nom + verbe + nom : amewunú « arme », déphotló « casque », núruhwei « temps de repas »', 'gbecosmolingua-core' ),
		__( '(xii) Nom + verbe + suffixe (-í, -tó, -lá) : gbexolá « voyelle », agomakploi « novembre »', 'gbecosmolingua-core' ),
		__( '(xiii) Nom (sujet) + verbe + -í : hwetló « après-midi », damarui « botte », agbemavo « éternité »', 'gbecosmolingua-core' ),
		__( '(xiv) Onomatopées / symbolisme : kekó/keké « bicyclette », hógugu « motocyclette », kówunka « chaussure à talons »', 'gbecosmolingua-core' ),
	);
}

/**
 * Types de combinaisons lexicales internes/externes.
 *
 * @return string[]
 */
function gbe_le_gbe_combinaisons_lexicales() {
	return array(
		__( '(i) Paraphrase endogène : gasɔ́ « bicyclette » (ga « fer » + sɔ́ « cheval »), dzokokó « motocyclette »', 'gbecosmolingua-core' ),
		__( '(ii) Calque : zimenɔlá « président » (modèle anglais chairman : zi-me + nɔlá)', 'gbecosmolingua-core' ),
		__( '(iii) Hybrides : xɔxáyá « maison louée » (xɔ + xáyá « hire »), cicagán « directeur d’école » (cica + gán)', 'gbecosmolingua-core' ),
		__( '(iv) Archaïsmes réemployés : kele « octobre » (Éwé, Gen, Waci)', 'gbecosmolingua-core' ),
		__( '(v) Extension de sens : katapila « tracteur », biki « stylo Bic », yovótó « ananas » ; yephe « prière » (en Fon, à l’origine « divinité »)', 'gbecosmolingua-core' ),
	);
}
