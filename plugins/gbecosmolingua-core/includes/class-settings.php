<?php
/**
 * Plugin settings for GbeCosmoLingua.
 *
 * @package GbeCosmoLingua_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Manages plugin settings (email, donation URLs).
 */
class GBE_Settings {

	const OPTION_KEY = 'gbe_settings';

	/**
	 * Default settings.
	 *
	 * @return array<string, string>
	 */
	public static function defaults() {
		return array(
			'notification_email' => get_option( 'admin_email' ),
			'donation_url'       => '',
			'donation_info'      => __( 'Votre don soutient la recherche, la documentation et la transmission des patrimoines gbe.', 'gbecosmolingua-core' ),
			'paypal_email'       => '',
		);
	}

	/**
	 * Initialize settings API.
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Register settings.
	 */
	public static function register_settings() {
		register_setting(
			'gbe_settings_group',
			self::OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
				'default'           => self::defaults(),
			)
		);
	}

	/**
	 * Sanitize settings input.
	 *
	 * @param array<string, string> $input Raw input.
	 */
	public static function sanitize( $input ) {
		$output = self::get_all();
		if ( ! is_array( $input ) ) {
			return $output;
		}

		if ( isset( $input['notification_email'] ) ) {
			$output['notification_email'] = sanitize_email( $input['notification_email'] );
		}
		if ( isset( $input['donation_url'] ) ) {
			$output['donation_url'] = esc_url_raw( $input['donation_url'] );
		}
		if ( isset( $input['donation_info'] ) ) {
			$output['donation_info'] = sanitize_textarea_field( $input['donation_info'] );
		}
		if ( isset( $input['paypal_email'] ) ) {
			$output['paypal_email'] = sanitize_email( $input['paypal_email'] );
		}

		return $output;
	}

	/**
	 * Get all settings merged with defaults.
	 *
	 * @return array<string, string>
	 */
	public static function get_all() {
		return wp_parse_args( get_option( self::OPTION_KEY, array() ), self::defaults() );
	}

	/**
	 * Get a single setting.
	 *
	 * @param string $key Setting key.
	 */
	public static function get( $key ) {
		$all = self::get_all();
		return $all[ $key ] ?? '';
	}

	/**
	 * Build donation payment URL with amount.
	 *
	 * @param float $amount Donation amount.
	 */
	public static function get_donation_link( $amount ) {
		$url = self::get( 'donation_url' );
		if ( $url ) {
			return str_replace( '{amount}', (string) $amount, $url );
		}

		$paypal = self::get( 'paypal_email' );
		if ( $paypal ) {
			return add_query_arg(
				array(
					'cmd'   => '_donations',
					'business' => $paypal,
					'amount'   => $amount,
					'currency_code' => 'EUR',
					'item_name' => 'GbeCosmoLingua',
				),
				'https://www.paypal.com/cgi-bin/webscr'
			);
		}

		return '';
	}

	/**
	 * Render settings page fields.
	 */
	public static function render_page() {
		$settings = self::get_all();
		?>
		<form method="post" action="options.php">
			<?php settings_fields( 'gbe_settings_group' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="gbe_notification_email"><?php esc_html_e( 'Email de notification', 'gbecosmolingua-core' ); ?></label></th>
					<td>
						<input type="email" id="gbe_notification_email" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[notification_email]" value="<?php echo esc_attr( $settings['notification_email'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Adresse qui reçoit les soumissions de formulaires.', 'gbecosmolingua-core' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gbe_donation_info"><?php esc_html_e( 'Texte page don', 'gbecosmolingua-core' ); ?></label></th>
					<td>
						<textarea id="gbe_donation_info" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[donation_info]" rows="3" class="large-text"><?php echo esc_textarea( $settings['donation_info'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gbe_donation_url"><?php esc_html_e( 'URL de paiement', 'gbecosmolingua-core' ); ?></label></th>
					<td>
						<input type="url" id="gbe_donation_url" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[donation_url]" value="<?php echo esc_attr( $settings['donation_url'] ); ?>" class="large-text" placeholder="https://paypal.me/gbecosmolingua/{amount}">
						<p class="description"><?php esc_html_e( 'Utilisez {amount} pour insérer le montant choisi.', 'gbecosmolingua-core' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gbe_paypal_email"><?php esc_html_e( 'Email PayPal (alternative)', 'gbecosmolingua-core' ); ?></label></th>
					<td>
						<input type="email" id="gbe_paypal_email" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[paypal_email]" value="<?php echo esc_attr( $settings['paypal_email'] ); ?>" class="regular-text">
						<p class="description"><?php esc_html_e( 'Utilisé si aucune URL de paiement n\'est définie.', 'gbecosmolingua-core' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		<?php
	}
}
