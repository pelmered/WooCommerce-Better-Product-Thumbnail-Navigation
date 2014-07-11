<?php
/*
Plugin Name: WooComemrce Better Thumbnail Navigation
Description: Replace fullsize image when thumbnail on single product page in WooCommerce is clicked. 
Author: Peter Elmered
Version: 1.0.0
Author URI: http://elmered.com/
*/


class WC_Better_Product_Thumbnail_Navigation
{
/*
    private $plugin_slug = 'woocommerce-better-thumbnail-navigation';
    private $plugin_path = null;
    private $plugin_url = null;
    
    private $plugin_options = array();
*/
    /**
     * Instance of this class.
     *
     * @since    0.1.0
     * @var      object
     */
    protected static $instance = null;

    const VERSION = '1.0.0';
    function __construct()
    {
        add_action('init', array($this, 'init'));
    }
    
    function init()
    {
        if(!is_product())
        {
            add_action('wp_footer', 'pe_wcth_print_footer_scrips', 99);
        }
    }
    
    /**
     * Returns a singleton instance
     * 
     * @return Object instance
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    function pe_wcth_print_footer_scrips() {

        $thumbnail_size = get_option('shop_thumbnail_image_size');
        $single_size = get_option('shop_single_image_size');

        //Set image sizes. Must match exactly!
        $product_thumbnail_size = $thumbnail_size['width'].'x'.$thumbnail_size['height'];
        $product_single_image_size = $single_size['width'].'x'.$single_size['height'];

        //Get number of thumbnails per row (columns)
        $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
    ?>
    <script type='text/javascript'>
    jQuery(function($){
        //Optional start
        $('.thumbnails>a').first().clone().prependTo($('.thumbnails')).find('img').attr('src', $('.woocommerce-main-image img').attr('src').replace('-<?php echo $product_single_image_size; ?>','-<?php echo $product_thumbnail_size; ?>'));

        $('.thumbnails>a').each( function( i, el) {

            var $el = $(el);

            $el.removeClass('first last');

            var $mod = i%<?php echo $columns; ?>;
            if($mod === 0)
            {
                $el.addClass('first');
            }
            else if($mod === 2)
            {
                $el.addClass('last');
            }
        });
        $('.thumbnails>a').last().addClass('last');
        //Optional end
        $('.thumbnails>a>img').click(function(e){
            e.stopPropagation();
            $('.woocommerce-main-image img').attr('src', $(this).attr('src').replace('-<?php echo $product_thumbnail_size; ?>','-<?php echo $product_single_image_size; ?>'));
            return false;
        }); 

    });
    </script>
    <?php 
    }

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) 
{
    WC_Better_Thumbnail_Navigation::get_instance();
}
else
{
    if(!function_exists(wcbtn_woocommerce_not_active_notice))
    {
        if(!empty($_GET['wcpf-deactivate-woocommerce-pricefiles']) && $_GET['wcpf-deactivate-woocommerce-pricefiles'] == 1)
        {
            add_action('init', 'wpcf_deactivate_plugin');
            add_action('admin_notices', 'wpcf_deactivate_plugin_notice');
        }
        if(!empty($_GET['wcpf-activate-woocommerce']) && $_GET['wcpf-activate-woocommerce'] == 1)
        {
            add_action('init', 'wpcf_activate_woocommerce');
            add_action('admin_notices', 'wpcf_activate_woocommerce_notice');
        }
        else
        {
            add_action('admin_notices', 'wcpf_woocommerce_not_active_notice');
        }

        function wcpf_woocommerce_not_active_notice()
        {
            ?>
            <div class="updated fade">
                <p><?php 
                printf(__('The Pricefiles plugin requires the plugin %sWooCommerce%s to work. Please install WooCommerce or %sdeactive%s this plugin.', WC_PRICEFILES_PLUGIN_SLUG), 
                    '<a href="http://wordpress.org/plugins/woocommerce/">', '</a>',
                    '<a href="?deactivate-woocommerce-pricefiles=1">', '</a>'
                ); ?></p>
                <?php if( file_exists(dirname(plugin_dir_path( __FILE__ )).'/woocommerce/woocommerce.php') ) : ?>
                <p><?php printf(__('WooCommerce seams to be installed but not activated. %sClick here to activate%s.', WC_PRICEFILES_PLUGIN_SLUG),
                    '<a href="?wcpf-activate-woocommerce=1">','</a>'
                ); ?></p>


                <?php endif; ?>
            </div>
            <?php
        }

        function wpcf_deactivate_plugin()
        {
            deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        function wpcf_deactivate_plugin_notice()
        {
            ?>
            <div class="updated fade">
                <p><?php _e('The Pricefiles plugin was deactivated.', WC_PRICEFILES_PLUGIN_SLUG); ?></p>
            </div>
            <?php
        }
        function wpcf_activate_woocommerce()
        {
            deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        function wpcf_activate_woocommerce_notice()
        {
            ?>
            <div class="updated fade">
                <p><?php _e('WooCommerce was activated.', WC_PRICEFILES_PLUGIN_SLUG); ?></p>
            </div>
            <?php
        }
    }
}