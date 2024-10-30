<?php
if (!current_user_can('activate_plugins')) {
    return;
}

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('woo_kigokasa_api_username');
delete_option('woo_kigokasa_api_password');
delete_option('woo_kigokasa_api_employee_pin');
delete_option('woo_kigokasa_api_shipping_reference');
delete_option('woo_kigokasa_api_email_from_name');
delete_option('woo_kigokasa_api_email_from');


$available_woo_gateways = \WC()->payment_gateways->get_available_payment_gateways();
foreach ($available_woo_gateways as $gateway_woo_sett => $gateway_woo_val) {
    delete_option('woo_kigokasa_api_pos_type-' . esc_attr($gateway_woo_val->id));
    delete_option('woo_kigokasa_api_payment_type-' . esc_attr($gateway_woo_val->id));
    delete_option('woo_kigokasa_api_pdf_payment_type-' . esc_attr($gateway_woo_val->id));
}

add_action('wp_mail_from_name', 'woo_kigokasa_api_revert_default_email_name');
function woo_kigokasa_api_revert_default_email_name($name)
{
    return 'WordPress';
}


