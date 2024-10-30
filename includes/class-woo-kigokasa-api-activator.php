<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.symmetria.hr
 * @since      1.0.0
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/includes
 * @author     Dejan Potocic <dpotocic@gmail.com>
 */
class Woo_KigoKasa_Api_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
            include_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        if ( ! current_user_can( 'activate_plugins' ) ) {
            // Deactivate the plugin.
            deactivate_plugins( plugin_basename( __FILE__ ) );

            $error_message = esc_html__( 'You do not have proper authorization to activate a plugin!', 'woo-kigokasa-api' );
            die( esc_html( $error_message ) );
        }

        if ( ! class_exists( 'WooCommerce' ) ) {
            // Deactivate the plugin.
            deactivate_plugins( plugin_basename( __FILE__ ) );
            // Throw an error in the WordPress admin console.
            $error_message = esc_html__( 'This plugin requires ', 'woo-kigokasa-api' ) . '<a href="' . esc_url( 'https://wordpress.org/plugins/woocommerce/' ) . '">WooCommerce</a>' . esc_html__( ' plugin to be active!', 'woo-kigokasa-api' );
            die( wp_kses_post( $error_message ) );
        }
	}
}
