<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.symmetria.hr
 * @since      1.0.0
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/public
 * @author     Dejan Potocic <dpotocic@gmail.com>
 */
class Woo_KigoKasa_Api_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_KigoKasa_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_KigoKasa_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-kigokasa-api-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_KigoKasa_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_KigoKasa_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-kigokasa-api-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * @param $fields
     * @return mixed
     */
    public function add_checkout_vat_fields($fields)
    {
        $fields['shipping']['shipping_vat_number'] = array(
            'label'       => esc_html__('VAT number', 'woo-kigokasa-api'),
            'placeholder' => _x('12345678901', 'placeholder', 'woo-kigokasa-api'),
            'required'    => false,
            'class'       => array('form-row-wide'),
            'clear'       => true,
        );

        $fields['billing']['billing_vat_number'] = array(
            'label'       => esc_html__('VAT number', 'woo-kigokasa-api'),
            'placeholder' => _x('12345678901', 'placeholder', 'woo-kigokasa-api'),
            'required'    => false,
            'class'       => array('form-row-wide'),
            'clear'       => true,
        );

        return $fields;
    }
}
