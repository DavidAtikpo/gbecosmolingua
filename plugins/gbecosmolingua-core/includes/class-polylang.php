<?php
/**
 * Polylang integration for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers translatable content and provides a language switcher.
 */
class GBE_Polylang {

	/**
	 * Post types that should be translatable.
	 *
	 * @var array<int, string>
	 */
	private static $post_types = array(
		'page',
		'proverbe',
		'genre_oral',
		'partenaire',
		'evenement',
		'ressource',
	);

	/**
	 * Taxonomies that should be translatable.
	 *
	 * @var array<int, string>
	 */
	private static $taxonomies = array(
		'langue_gbe',
		'genre_xotutu',
		'type_partenaire',
	);

	/**
	 * Initialize hooks.
	 */
	public static function init() {
		add_filter( 'pll_get_post_types', array( __CLASS__, 'register_post_types' ), 10, 2 );
		add_filter( 'pll_get_taxonomies', array( __CLASS__, 'register_taxonomies' ), 10, 2 );
		add_action( 'init', array( __CLASS__, 'register_strings' ), 20 );
		add_shortcode( 'gbe_lang_switcher', array( __CLASS__, 'language_switcher' ) );
		add_action( 'admin_notices', array( __CLASS__, 'polylang_notice' ) );
	}

	/**
	 * Register CPTs with Polylang.
	 *
	 * @param array<string, string> $types     Post types.
	 * @param bool                  $is_settings Settings screen.
	 */
	public static function register_post_types( $types, $is_settings ) {
		if ( $is_settings ) {
			foreach ( self::$post_types as $pt ) {
				$types[ $pt ] = $pt;
			}
		} else {
			foreach ( self::$post_types as $pt ) {
				if ( 'page' !== $pt ) {
					$types[ $pt ] = $pt;
				}
			}
		}
		return $types;
	}

	/**
	 * Register taxonomies with Polylang.
	 *
	 * @param array<string, string> $taxonomies  Taxonomies.
	 * @param bool                  $is_settings Settings screen.
	 */
	public static function register_taxonomies( $taxonomies, $is_settings ) {
		unset( $is_settings );
		foreach ( self::$taxonomies as $tax ) {
			$taxonomies[ $tax ] = $tax;
		}
		return $taxonomies;
	}

	/**
	 * Register theme/plugin strings for translation.
	 */
	public static function register_strings() {
		if ( ! function_exists( 'pll_register_string' ) ) {
			return;
		}

		$strings = array(
			'hero_tagline'    => 'Observatoire international',
			'hero_title'      => 'Bienvenue à GbeCosmoLingua',
			'hero_subtitle'   => 'Un pont entre les langues, les cultures et les peuples du continuum gbe.',
			'site_tagline'    => 'Observatoire international des langues, cultures et patrimoines gbe',
			'form_submit'     => 'Envoyer',
			'form_success'    => 'Votre message a bien été envoyé. Merci pour votre soutien !',
			'donate_title'    => 'Soutenir GbeCosmoLingua',
		);

		foreach ( $strings as $key => $string ) {
			pll_register_string( $key, $string, 'GbeCosmoLingua' );
		}
	}

	/**
	 * Render language switcher.
	 *
	 * @param array<string, string> $atts Shortcode attributes.
	 */
	public static function language_switcher( $atts ) {
		$atts = shortcode_atts(
			array(
				'dropdown' => '0',
				'flags'    => '1',
			),
			$atts,
			'gbe_lang_switcher'
		);

		if ( ! function_exists( 'pll_the_languages' ) ) {
			return '';
		}

		ob_start();
		echo '<nav class="gbe-lang-switcher" aria-label="' . esc_attr__( 'Choisir la langue', 'gbecosmolingua-core' ) . '">';
		pll_the_languages(
			array(
				'dropdown'               => (int) $atts['dropdown'],
				'show_flags'             => (int) $atts['flags'],
				'show_names'             => 1,
				'hide_current'           => 0,
				'display_names_as'       => 'name',
				'echo'                   => 1,
				'hide_if_no_translation' => 0,
			)
		);
		echo '</nav>';
		return ob_get_clean();
	}

	/**
	 * Check if Polylang is active.
	 */
	public static function is_active() {
		return function_exists( 'pll_current_language' );
	}

	/**
	 * Admin notice when Polylang is not installed.
	 */
	public static function polylang_notice() {
		if ( ! current_user_can( 'manage_options' ) || self::is_active() ) {
			return;
		}
		$screen = get_current_screen();
		if ( ! $screen || 'toplevel_page_gbecosmolingua' !== $screen->id ) {
			return;
		}
		?>
		<div class="notice notice-info">
			<p>
				<?php
				echo wp_kses_post(
					sprintf(
						/* translators: %s: plugin name */
						__( '<strong>Multilingue :</strong> installez et activez <a href="%s">Polylang</a> pour activer le français, l\'anglais, l\'espagnol et le russe.', 'gbecosmolingua-core' ),
						esc_url( admin_url( 'plugin-install.php?s=polylang&tab=search&type=term' ) )
					)
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Translate a registered string if Polylang is available.
	 *
	 * @param string $string Default string.
	 * @param string $name   String name.
	 */
	public static function translate( $string, $name ) {
		if ( function_exists( 'pll__' ) ) {
			return pll__( $name );
		}
		return $string;
	}
}
