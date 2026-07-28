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

		$languages = self::get_language_items();
		if ( empty( $languages ) ) {
			return '';
		}

		$use_dropdown = in_array( (string) $atts['dropdown'], array( '1', 'true', 'yes' ), true );
		if ( $use_dropdown ) {
			return self::render_language_switcher_dropdown( $languages );
		}

		return self::render_language_switcher_inline( $languages );
	}

	/**
	 * Collect languages from Polylang or fallback list.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_language_items() {
		if ( function_exists( 'pll_the_languages' ) ) {
			$raw = pll_the_languages(
				array(
					'raw'                    => 1,
					'hide_if_no_translation' => 0,
				)
			);
			if ( is_array( $raw ) && ! empty( $raw ) ) {
				$items = array();
				foreach ( $raw as $lang ) {
					if ( empty( $lang['slug'] ) ) {
						continue;
					}
					$slug = sanitize_key( $lang['slug'] );
					$items[] = array(
						'slug'    => $slug,
						'code'    => strtoupper( $slug ),
						'label'   => self::language_full_name( $slug, ! empty( $lang['name'] ) ? $lang['name'] : '' ),
						'url'     => ! empty( $lang['url'] ) ? $lang['url'] : home_url( '/' ),
						'current' => ! empty( $lang['current_lang'] ),
					);
				}
				if ( ! empty( $items ) ) {
					return $items;
				}
			}
		}

		return self::get_language_items_fallback();
	}

	/**
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_language_items_fallback() {
		$languages = apply_filters(
			'gbe_language_switcher_languages',
			array(
				array(
					'slug' => 'fr',
					'name' => 'FR',
				),
				array(
					'slug' => 'en',
					'name' => 'EN',
				),
				array(
					'slug' => 'es',
					'name' => 'ES',
				),
				array(
					'slug' => 'ru',
					'name' => 'RU',
				),
			)
		);

		$current = 'fr';
		if ( function_exists( 'pll_current_language' ) ) {
			$detected = pll_current_language( 'slug' );
			if ( is_string( $detected ) && '' !== $detected ) {
				$current = $detected;
			}
		}

		$items = array();
		foreach ( $languages as $lang ) {
			if ( empty( $lang['slug'] ) ) {
				continue;
			}
			$slug = sanitize_key( $lang['slug'] );
			$code = ! empty( $lang['name'] ) ? $lang['name'] : strtoupper( $slug );
			$url  = home_url( '/' );
			if ( function_exists( 'pll_home_url' ) ) {
				$maybe = pll_home_url( $slug );
				if ( is_string( $maybe ) && '' !== $maybe ) {
					$url = $maybe;
				}
			}
			$items[] = array(
				'slug'    => $slug,
				'code'    => strtoupper( $slug ),
				'label'   => self::language_full_name( $slug, $code ),
				'url'     => $url,
				'current' => ( $current === $slug ),
			);
		}

		return $items;
	}

	/**
	 * Dropdown with globe icon (header).
	 *
	 * @param array<int, array<string, mixed>> $languages Languages.
	 */
	private static function render_language_switcher_dropdown( $languages ) {
		$current_code = 'FR';
		foreach ( $languages as $lang ) {
			if ( ! empty( $lang['current'] ) ) {
				$current_code = $lang['code'];
				break;
			}
		}

		$items = '';
		foreach ( $languages as $lang ) {
			$li_class = ! empty( $lang['current'] ) ? ' class="lang-item current-lang"' : ' class="lang-item"';
			$items   .= sprintf(
				'<li%s role="option"><a href="%s" hreflang="%s" lang="%s">%s</a></li>',
				$li_class,
				esc_url( $lang['url'] ),
				esc_attr( $lang['slug'] ),
				esc_attr( $lang['slug'] ),
				esc_html( $lang['label'] )
			);
		}

		return sprintf(
			'<nav class="gbe-lang-switcher gbe-lang-switcher--dropdown" aria-label="%1$s">' .
			'<div class="gbe-lang-switcher__wrap">' .
			'<button type="button" class="gbe-lang-switcher__toggle" aria-expanded="false" aria-haspopup="listbox" aria-controls="gbe-lang-menu-%2$s">' .
			'%3$s<span class="gbe-lang-switcher__current">%4$s</span>' .
			'<span class="gbe-lang-switcher__caret" aria-hidden="true"></span>' .
			'</button>' .
			'<ul id="gbe-lang-menu-%2$s" class="gbe-lang-switcher__menu" role="listbox" hidden>%5$s</ul>' .
			'</div></nav>',
			esc_attr__( 'Choisir la langue', 'gbecosmolingua-core' ),
			esc_attr( wp_unique_id( 'gbe-lang-' ) ),
			self::language_switcher_globe_icon(),
			esc_html( $current_code ),
			$items
		);
	}

	/**
	 * Inline list (footer and legacy).
	 *
	 * @param array<int, array<string, mixed>> $languages Languages.
	 */
	private static function render_language_switcher_inline( $languages ) {
		$items = '';
		foreach ( $languages as $lang ) {
			$li_class = ! empty( $lang['current'] ) ? ' class="lang-item current-lang"' : ' class="lang-item"';
			$items   .= sprintf(
				'<li%s><a href="%s" hreflang="%s" lang="%s">%s</a></li>',
				$li_class,
				esc_url( $lang['url'] ),
				esc_attr( $lang['slug'] ),
				esc_attr( $lang['slug'] ),
				esc_html( $lang['code'] )
			);
		}

		return sprintf(
			'<nav class="gbe-lang-switcher" aria-label="%s"><ul>%s</ul></nav>',
			esc_attr__( 'Choisir la langue', 'gbecosmolingua-core' ),
			$items
		);
	}

	/**
	 * Human-readable language name for the dropdown list.
	 *
	 * @param string $slug         Language slug.
	 * @param string $polylang_name Name from Polylang when available.
	 */
	private static function language_full_name( $slug, $polylang_name = '' ) {
		$polylang_name = trim( (string) $polylang_name );
		if ( '' !== $polylang_name && strtoupper( $polylang_name ) !== strtoupper( $slug ) && strlen( $polylang_name ) > 3 ) {
			return $polylang_name;
		}

		$names = array(
			'fr' => 'Français',
			'en' => 'English',
			'es' => 'Español',
			'ru' => 'Русский',
		);

		$slug = sanitize_key( $slug );
		if ( isset( $names[ $slug ] ) ) {
			return $names[ $slug ];
		}

		return strtoupper( $slug );
	}

	/**
	 * Globe icon for the language toggle.
	 */
	private static function language_switcher_globe_icon() {
		return '<span class="gbe-lang-switcher__globe" aria-hidden="true">' .
			'<svg class="gbe-lang-switcher__globe-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">' .
			'<circle cx="12" cy="12" r="10"/>' .
			'<path d="M2 12h20"/>' .
			'<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>' .
			'</svg></span>';
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
