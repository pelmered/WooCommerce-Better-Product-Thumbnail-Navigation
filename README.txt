=== WooCommerce Better Thumbnail Navigation ===
Contributors: pekz0r
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8L2PHLURJMC8Y
Tags: Better, Editing, Movable, Content Editor, WYSIWYG
Requires at least: 3.8.1
Tested up to: 4.6
Stable tag: 0.1.2

Replace fullsize image when thumbnail on single product page in WooCommerce is clicked.

== Description ==

Replace fullsize image when thumbnail on single product page in WooCommerce is clicked. This should also work nicely with the build in lightbox feature in WooCommerce (PrettyPhoto).

What this plugin do:

* When a thumbnail is clicked, the large main image is updated with the large version of the clicked image.
* When the large main image is clicked a lightbox will open where the user can see larger versions of all the images for the product.
* Adds the products main/featured image to the product thumbnails.

= NOTICE =
This plugin is currently dependant on CSS selectors to work and will therefore not work with any theme. It is tested and works with the standard templates from WordPress and a few of the themes from WooThemes(Wootique for example). Contact me if you are expieriencing problems with you theme. The goal is to make this plugin work with most themes with little or no need for custom configuration by the user.

= Development =

All development of this plugin occurs on [GitHub](https://github.com/pelmered/WooCommerce-Better-Product-Thumbnail-Navigation "WooCommerce Better Thumbnail Navigation on GitHub"). Please help me develop this by forking and sending pull requests.

== Installation ==

For integrating this info your theme, see GitHub.

1. Upload plugin folder to the `/wp-content/plugins/` directory of your WordPress installation
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Test how it works on the single product page. 

== Screenshots ==

1. This is how it looks like with the plugin installed and activated. 

== Changelog ==

= 0.1.2 =
* Fix issues with responsive images/srcset in WordPress 4.4
* Improve thumbnail selector to work with more themes

= 0.1.0 =
First public release


