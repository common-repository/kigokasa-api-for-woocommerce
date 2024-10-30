=== KigoKasa Fiscalization for WooCommerce ===

Contributors**: dpotocic, symmetria, bid
Tags: woocommerce, hrvatska fiskalizacija, croatian fiscalization, fiscalization, fiskalizacija, kigokasa, kigokasa api, shop, payments
Requires at least: 4.4
Requires PHP: 5.6
Tested up to: 6.6.2
Stable tag: 1.5.2
WC requires at least: 3.0.0
WC tested up to: 9.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

This plugin provides integration of KigoKasa service with WooCommerce webshop.

== Description ==

KigoKasa plugin will integrate with your checkout process in WooCommerce webshop, and will send the API request with
the order details to the KigoKasa service, creating invoice/offer with Croatian fiscalization options.

For more information about the KigoKasa API visit <a href="https://trgovina.kigoserver.com/apidoc/index.html">API Doc</a>

More about plugin <a href="https://www.symmetria.hr/kigokasa-api-for-woocommerce/">here</a>.

See in action <a href="https://webshop.symmetria.hr/">WebShop demo</a> and check results on <a href="https://trgovina.kigoserver.com/en">Kigo Service demo</a>.

== Installation ==

= Minimum Requirements =

You’ll need WordPress version 4.4 or higher with WooCommerce 3.0 or higher for plugin to work.

Installing the plugin is easy.

<strong>Installing from WordPress repository</strong>

Be sure you have WooCommerce plugin installed first, otherwise you'll get an error on the plugin activation.

1. From the dashboard of your site, navigate to Plugins --> Add New.
2. In the Search type KigoKasa Api for WooCommerce
3. Click Install Now
4. When it's finished, activate the plugin via the prompt. A message will show confirming activation was successful.

<strong>Uploading the .zip file</strong>

1. From the dashboard of your site, navigate to Plugins --> Add New.
2. Select the Upload option and hit "Choose File."
3. When the popup appears select the kigokasa-api-for-woocommerce.x.x.x.zip file from your desktop. (The 'x.x.x' will change depending on the current version number).
4. Follow the on-screen instructions and wait as the upload completes.
5. When it's finished, activate the plugin via the prompt. A message will show confirming activation was successful.

== Requirements ==

* PHP 5.6 or greater (recommended: PHP 7 or greater)
* WordPress 4.4 or above (because of the built in REST interface)

== Screenshots ==

1.  KigoKasa Api for WooCommerce - Plugin Settings
2.  KigoKasa Api for WooCommerce - E-mail received example
3.  KigoKasa Api for WooCommerce - Admin order details
4.  KigoKasa Api for WooCommerce - Invoice/offer details

==  Changelog ==

= 1.5.2 =
Add support for internal number (now contains order number)

= 1.5.1 =
Bugfix for translations

= 1.5.0 =
Add support for multiple tax rates
Add support for compound taxes
Remove option manually calculate product price option
Remove option for manually adding taxes to product price

= 1.4.1 =
Add rounding to 4 decimals for item price and tax

= 1.4 =
Add support for custom cart fees

= 1.3.3 =
Add option for skipping order statuses
Manually calculate product price from order items no longer generates coupons

= 1.3.2 =
Add country iso code to KigoKasa API request

= 1.3.1 =
Add reply-to email address to KigoKasa API request

= 1.3.0 =
Add option for manually calculated item price from total and quantity directly from order
Add support for WC up to 8.9.x and WP up to 6.5.x
Action on woocommerce_order_status_completed hook now has lower priority to avoid conflicts with other plugins (30)

= 1.2.5 =
Fix customer note on order (now sending customer note to KigoKasa API)

= 1.2.4 =
Add support for product prices without tax (adding taxes on product price before sending them to KigoKasa API)
Add support for WC up to 7.7.x and WP up to 6.2

= 1.2.3 =
Fix no-taxes (zero tax) on coupons

= 1.2.2 =
Fix tax on coupons

= 1.2.1 =
Add support for taxable shipping (now including shipping tax value)

= 1.2.0 =
Add support for woocommerce coupons

= 1.1.1 =
Add support for 'item_name' and 'item_tax' properties on KigoKasa item(s) when item is not found by provided reference
Add support for OIB (VAT number) with letters, so KigoKasa invoice/offer will hide OIB prefix and show only client name

= 1.1.0 =
Add support for WC up to 5.8.x and WP up to 5.8

= 1.0.0 =
Initial version