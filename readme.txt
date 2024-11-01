=== Woocommerce-simple-order-notification ===
Contributors: getJuicy
Donate link: 
Tags: woocommerce, twilio, sms
Requires at least: 3.3
Tested up to: 4.8.2
Stable tag: 4.8.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Woocommerce simple order notification allows you to receive a SMS when a new order is placed on your site. 

== Description ==

Woocommerce simple order notification allows you to receive a SMS when a new order is placed on your site. The plugin hooks into woocommerce and on order calls the twilio SMS service to send you a message with the order details.

You will need a twilio SID and auth token, plus a twilio number to use this plugin.

You can access the plugin options from the admin menu

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the "Simple Order Notification Admin" tab added to the admin menu to configure your number and twilio details

== Frequently asked questions ==

= Can you use this plugin with other SMS providers =

Currently this plugin supports twilio only

= Can you use this plugin with any number =

You can use any number twilio supports SMS for

= Why do I need a twilio account =

The plugin calls the twilio SMS service that is used to send the SMS

= Can I get a SMS on shipping or other order status =

Currently this plugin only supports new orders

= Can I know what is in the order =

Yes if you check product list you will get a SMS with all order details.

== Screenshots ==

1. This screenshot shows the admin options as described in the description. ’assets/AdminOptions.png’

== Changelog ==


= 1.0 =

Initial Stable Release

== Upgrade notice ==


