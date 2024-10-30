<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.symmetria.hr
 * @since      1.0.0
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/includes
 * @author     Dejan Potocic <dpotocic@gmail.com>
 */
class Woo_KigoKasa_Api {

    /**
     * Plugin name
     *
     * @since 1.0.0
     */
    const PLUGIN_NAME = 'woo-kigokasa-api';

    /**
     * Plugin version
     *
     * @since 1.0.0
     */
    const PLUGIN_VERSION = '1.5.2';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_KigoKasa_Api_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOO_KIGOKASA_API_PLUGIN_NAME_VERSION' ) ) {
			$this->version = WOO_KIGOKASA_API_PLUGIN_NAME_VERSION;
		} else {
			$this->version = self::PLUGIN_VERSION;
		}
		$this->plugin_name = 'woo-kigokasa-api';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_KigoKasa_Api_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_KigoKasa_Api_i18n. Defines internationalization functionality.
	 * - Woo_KigoKasa_Api_Admin. Defines all hooks for the admin area.
	 * - Woo_KigoKasa_Api_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-kigokasa-api-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-kigokasa-api-i18n.php';

        /**
         * The class responsible for API calls.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-kigokasa-api-request.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-kigokasa-api-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-kigokasa-api-public.php';

		$this->loader = new Woo_KigoKasa_Api_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_KigoKasa_Api_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_KigoKasa_Api_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_KigoKasa_Api_Admin($this->get_plugin_name(), $this->get_version());
        $plugin_public = new Woo_KigoKasa_Api_Public($this->get_plugin_name(), $this->get_version());
        $plugin_request = new Woo_KigoKasa_Api_Request();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $this->loader->add_action('woocommerce_email_order_details', $plugin_request, 'send_api_request', 15, 4);
        $this->loader->add_action('woocommerce_order_status_completed', $plugin_request, 'send_api_request_on_completed',30,1);
        $this->loader->add_action('woocommerce_checkout_fields', $plugin_public, 'add_checkout_vat_fields');
        $this->loader->add_action('woocommerce_admin_order_data_after_shipping_address', $plugin_admin, 'display_admin_order_meta');
        $this->loader->add_action('woocommerce_admin_order_data_after_order_details', $plugin_admin, 'display_admin_order_kigokasa');


        $this->loader->add_filter( 'woocommerce_settings_tabs_array',$plugin_admin, 'add_woocommerce_settings_tab', 50 );
        $this->loader->add_action( 'woocommerce_settings_tabs_woo_kigokasa_api', $plugin_admin, 'add_woocommerce_settings' );
        $this->loader->add_action( 'woocommerce_update_options_woo_kigokasa_api', $plugin_admin, 'update_woocommerce_settings' );

        $this->loader->add_filter( 'woocommerce_email_attachments', $plugin_request, 'add_pdf_attachment', 10, 3 );

        $this->loader->add_filter( 'wp_mail_from', $plugin_admin, 'change_wp_email_from');
        $this->loader->add_filter( 'wp_mail_from_name', $plugin_admin, 'change_wp_email_from_name');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_KigoKasa_Api_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_KigoKasa_Api_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
