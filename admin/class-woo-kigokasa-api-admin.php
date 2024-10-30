<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.symmetria.hr
 * @since      1.0.0
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Woo_KigoKasa_Api
 * @subpackage Woo_KigoKasa_Api/admin
 * @author     Dejan Potocic <dpotocic@gmail.com>
 */
class Woo_KigoKasa_Api_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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

        /*wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/woo-kigokasa-api-admin.css',
            array(),
            $this->version,
            'all'
        );*/
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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

        /*wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/woo-kigokasa-api-admin.js',
            array('jquery'),
            $this->version,
            false
        );*/
    }

    /**
     * Change From email field of WP mails
     *
     * @param  string $changeEmail
     * @return string
     */
    public function change_wp_email_from($email)
    {
        $changeEmail = esc_attr(get_option('woo_kigokasa_api_email_from'));
        if (!empty($changeEmail) && $changeEmail !== '') {
            return $changeEmail;
        }

        return $email;
    }

    /**
     * Change From field of WP mails
     *
     * @param  string $fromName
     * @return string
     */
    public function change_wp_email_from_name($fromName)
    {
        $changeFromName = esc_attr(get_option('woo_kigokasa_api_email_from_name'));
        if (!empty($changeFromName) && $changeFromName !== '') {
            return $changeFromName;
        }

        return $fromName;
    }

    /**
     * Add plugin options page
     *
     * @since  1.0.0
     */
    public function add_plugin_options_page()
    {
        add_submenu_page(
            'woocommerce',
            esc_html__('KigoKasa Api', 'woo-kigokasa-api'),
            esc_html__('KigoKasa Api', 'woo_kigokasa_api'),
            'manage_options',
            $this->plugin_name,
            array($this, 'render_admin_options_page')
        );
    }

    /**
     * @param $settings_tabs
     * @return mixed
     */
    public static function add_woocommerce_settings_tab($settings_tabs)
    {
        $settings_tabs['woo_kigokasa_api'] = __('KigoKasa API', 'woo-kigokasa-api');
        return $settings_tabs;
    }

    public static function update_woocommerce_settings()
    {
        woocommerce_update_options(self::get_woocommerce_settings_options());
    }

    public static function add_woocommerce_settings()
    {
        woocommerce_admin_fields(self::get_woocommerce_settings_options());
    }

    public static function get_woocommerce_settings_options()
    {
        __('pos_type_0', 'woo-kigokasa-api');
        __('pos_type_1', 'woo-kigokasa-api');
        __('pos_type_2', 'woo-kigokasa-api');

        /*$paymentFields = [
            'payment_title' => array(
                'name' => __('Payment settings', 'woo-kigokasa-api'),
                'type' => 'title',
                'desc' => '',
            ),
        ];*/
        $paymentFields = [];

        $gateways = WC()->payment_gateways->get_available_payment_gateways();
        foreach ($gateways as $k => $gateway) {
            $paymentFields['start_'.esc_attr($gateway->id)] = array(
                'name' => esc_html($gateway->title),
                'type' => 'title',
            );

            $paymentFields['pos_type-' . esc_attr($gateway->id)] = array(
                'title'   => __('Document type', 'woo-kigokasa-api'),
                'type'    => 'select',
                'name'        => 'pos_type-' . esc_attr($gateway->id),
                'id'          => 'woo_kigokasa_api_pos_type-' . esc_attr($gateway->id),
                'options' => array(
                    '0' => __('Disabled', 'woo-kigokasa-api'),
                    '1' => __('Invoice', 'woo-kigokasa-api'),
                    '2' => __('Offer', 'woo-kigokasa-api'),
                ),
                'default' => '0',
                'css'     => 'width:150px;',
            );

            $paymentFields['payment_type-' . esc_attr($gateway->id)] = array(
                'title'   => __('Payment type', 'woo-kigokasa-api'),
                'name'        => 'payment_type-' . esc_attr($gateway->id),
                'id'          => 'woo_kigokasa_api_payment_type-' . esc_attr($gateway->id),
                'type'    => 'select',
                'options' => array(
                    'T' => __('Transaction account', 'woo-kigokasa-api'),
                    'K' => __('Card', 'woo-kigokasa-api'),
                    'G' => __('Cash', 'woo-kigokasa-api'),
                    'C' => __('Cheque', 'woo-kigokasa-api'),
                    'O' => __('Other', 'woo-kigokasa-api'),
                ),
                'default' => 'T',
                'css'     => 'width:200px;',
            );
            $paymentFields['pdf_payment_type-' . esc_attr($gateway->id)] = array(
                'title'   => __('Send Email with document PDF', 'woo-kigokasa-api'),
                'name'        => 'pdf_payment_type-' . esc_attr($gateway->id),
                'id'          => 'woo_kigokasa_api_pdf_payment_type-' . esc_attr($gateway->id),
                'type'    => 'select',
                'options' => array(
                    '0' => __('No', 'woo-kigokasa-api'),
                    '1' => __('Yes', 'woo-kigokasa-api'),
                ),
                'default' => '0',
                'css'     => 'width:200px;',
            );
            $paymentFields['end_'.esc_attr($gateway->id)] = array(
                'type' => 'sectionend',
            );
        }

        //$paymentFields['payment_section_end'] = array('type' => 'sectionend');

        $form_fields = array(
            'api_account_title'       => array(
                'name' => __('API account', 'woo-kigokasa-api'),
                'type' => 'title',
                'desc' => '',
            ),
            'username'                => array(
                'title'       => __('API Username', 'woo-kigokasa-api'),
                'name'        => 'username',
                'type'        => 'text',
                'id'          => 'woo_kigokasa_api_username',
                'description' => __('Enter API username here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'default'     => 'admin_demo',
                'css'         => 'width:150px;',
            ),
            'password'                => array(
                'title'       => __('API Password', 'woo-kigokasa-api'),
                'type'        => 'text',
                'name'        => 'password',
                'id'          => 'woo_kigokasa_api_password',
                'description' => __('Enter API password here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'default'     => 'admin_demo',
                'css'         => 'width:150px;',
            ),
            'api_account_section_end' => array(
                'type' => 'sectionend',
            ),
        );

        $form_fields += $paymentFields;

        $form_fields += array(
            'api_misc_title'          => array(
                'name' => __('Misc', 'woo-kigokasa-api'),
                'type' => 'title',
                'desc' => '',
            ),
            'pin'                     => array(
                'title'       => __('Employee PIN', 'woo-kigokasa-api'),
                'type'        => 'text',
                'name'        => 'pin',
                'id'          => 'woo_kigokasa_api_pin',
                'description' => __('Enter API employee PIN here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'default'     => '1',
                'css'         => 'width:150px;',
            ),
            'shipping_reference'      => array(
                'title'       => __('Shipping Reference Number', 'woo-kigokasa-api'),
                'type'        => 'text',
                'name'        => 'shipping_reference',
                'id'          => 'woo_kigokasa_api_shipping_reference',
                'placeholder' => __('Enter Shipping Reference Number here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'css'         => 'width:250px;',
            ),
            'api_misc_section_end'    => array(
                'type' => 'sectionend',
            ),
            'email_title_section'       => array(
                'name' => __('E-mail settings', 'woo-kigokasa-api'),
                'type' => 'title',
                'desc' => __('This change is global.', 'woo-kigokasa-api'),
            ),
            'woo_kigokasa_api_email_from_name'                => array(
                'title'       => __('From name', 'woo-kigokasa-api'),
                'name'        => 'from_name',
                'type'        => 'text',
                'id'          => 'woo_kigokasa_api_email_from_name',
                'description' => __('Enter \'From\' Name field here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'default'     => null,
                'css'         => 'width:150px;',
            ),
            'woo_kigokasa_api_email_from'                => array(
                'title'       => __('From e-mail', 'woo-kigokasa-api'),
                'type'        => 'text',
                'name'        => 'password',
                'id'          => 'woo_kigokasa_api_email_from',
                'description' => __('Enter \'From\' E-mail here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'default'     => null,
                'css'         => 'width:150px;',
            ),
            'woo_kigokasa_api_reply_to'                => array(
                'title'       => __('Reply-To E-mail', 'woo-kigokasa-api'),
                'type'        => 'text',
                'name'        => 'reply_to',
                'id'          => 'woo_kigokasa_api_reply_to',
                'description' => __('Enter \'Reply-To\' E-mail here', 'woo-kigokasa-api'),
                'desc_tip'    => true,
                'default'     => null,
                'css'         => 'width:150px;',
            ),
            'email_title_section_end' => array(
                'type' => 'sectionend',
            )
        );

        $order_form_fields = array(
            'api_status_title'       => array(
                'name' => __('Order Statuses', 'woo-kigokasa-api'),
                'type' => 'title',
                'desc' => __('Before any Kigo API call, plugin will check if call has already been made for same order', 'woo-kigokasa-api'),
            ),
            'woo_kigokasa_api_skip_status_order_created'                => array(
                'title'       => __('Skip create Kigo document on Order Status Created', 'woo-kigokasa-api'),
                'name'        => 'skip_status_order_created',
                'type'        => 'select',
                'id'          => 'woo_kigokasa_api_skip_status_order_created',
                'desc_tip'    => true,
                'default'     => 0,
                'options'     => array(
                    '0' => __('No, create Kigo document on Order Created status', 'woo-kigokasa-api'),
                    '1' => __('Yes, skip this order status', 'woo-kigokasa-api'),
                ),
                'css'         => 'width:400px;',
            ),
            'woo_kigokasa_api_skip_status_order_completed'                => array(
                'title'       => __('Skip create Kigo document on Order Status Completed', 'woo-kigokasa-api'),
                'name'        => 'skip_status_order_completed',
                'type'        => 'select',
                'id'          => 'woo_kigokasa_api_skip_status_order_completed',
                'desc_tip'    => true,
                'default'     => 0,
                'options'     => array(
                    '0' => __('No, create Kigo document on Order Completed status', 'woo-kigokasa-api'),
                    '1' => __('Yes, skip skip this order status', 'woo-kigokasa-api'),
                ),
                'css'         => 'width:400px;',
            ),
            'api_status_title_section_end' => array(
                'type' => 'sectionend',
            ),
        );

        $form_fields += $order_form_fields;

        return apply_filters('woo_kigokasa_api', $form_fields);
    }

    /**
     * @param WC_Order $order
     */
    public function display_admin_order_meta($order)
    {
        $shipping_vat = get_post_meta($order->get_id(), '_shipping_vat_number', true);
        $billing_vat  = get_post_meta($order->get_id(), '_billing_vat_number', true);

        if (!empty($shipping_vat)) {
            echo '<p><strong> '
                 . esc_html__('Shipping VAT number', 'woo-kigokasa-api')
                 . '</strong><br />'
                 . esc_html($shipping_vat)
                 . '</p>';
        }

        if (!empty($billing_vat)) {
            echo '<p><strong> '
                 . esc_html__('Billing VAT number', 'woo-kigokasa-api')
                 . '</strong><br />'
                 . esc_html($billing_vat)
                 . '</p>';
        }
    }

    /**
     * @param WC_Order $order
     */
    public function display_admin_order_kigokasa($order)
    {
        $pos_number = get_post_meta($order->get_id(), '_kigokasa_pos_number', true);
        $document_type = get_post_meta($order->get_id(), '_kigokasa_doc_type', true);

        if (!empty($pos_number)) {
            echo '<p class="form-field form-field-wide wc-order-pos-number"><strong> '
                 . esc_html__('KigoKasa document', 'woo-kigokasa-api')
                 . ': </strong>'
                 . (!empty($document_type) ? esc_html($document_type) . ' ' : '')
                 . esc_html($pos_number)
                 . '</p>';
        }
    }
}
