<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.symmetria.hr
 * @since      1.0.0
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/includes
 * @author     Dejan Potocic <dpotocic@gmail.com>
 */
class Woo_KigoKasa_Api_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-kigokasa-api',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
