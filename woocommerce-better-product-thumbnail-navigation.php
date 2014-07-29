<?php
/*
Plugin Name: WooComemrce Better Thumbnail Navigation
Description: Replace fullsize image when thumbnail on single product page in WooCommerce is clicked. 
Author: Peter Elmered
Version: 0.1.1
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
     * @since    0.1.1
     * @var      object
     */
    protected static $instance = null;

    const VERSION = '0.1.1';
    function __construct()
    {
        add_action('init', array($this, 'init'));
    }
    
    function init()
    {
        if(!is_product())
        {
            add_action('wp_footer', array($this, 'print_footer_scrips'), 99);
            
            add_filter('woocommerce_product_gallery_attachment_ids', array($this, 'add_featured_image_to_thumbnails'));
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
    
    function add_featured_image_to_thumbnails($thumbnails_ids)
    {
        //Prepend featured image to thumbnails
        array_unshift($thumbnails_ids, get_post_thumbnail_id());
        return $thumbnails_ids;
    }
    
    function print_footer_scrips() {

        $thumbnail_size = get_option('shop_thumbnail_image_size');
        $single_size = get_option('shop_single_image_size');

        //Set image sizes. Must match exactly!
        $product_thumbnail_size = $thumbnail_size['width'].'x'.$thumbnail_size['height'];
        $product_single_image_size = $single_size['width'].'x'.$single_size['height'];
    ?>
    <script type='text/javascript'>
    jQuery(function($){
        
        //Override prettyPhoto functionality to avoid duplicates
        var photoGalleryImages = [], 
            photoGalleryTitles = [];
        
        $('.woocommerce-main-image>img').click(function(e) {
            e.stopPropagation();
            e.preventDefault();
            $.prettyPhoto.open(photoGalleryImages,photoGalleryTitles);
        });
        
        $('.thumbnails>a').each( function() {
            $this = $(this);
            photoGalleryImages.push($this.attr('href'));
            photoGalleryTitles.push($this.attr('title'));
        });
        
        $('.thumbnails>a>img').click(function(e){
            e.stopPropagation();
            e.preventDefault();
            $this = $(this);
            $('.thumbnails>a>img').removeClass('active');
            $this.addClass('active');
            $src = $this.attr('src');
            $('.woocommerce-main-image').attr('href', $src);
            $('.woocommerce-main-image img').attr('src', $src.replace('-<?php echo $product_thumbnail_size; ?>','-<?php echo $product_single_image_size; ?>'));
        }); 

    });
    </script>
    <?php 
    }

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) 
{
    WC_Better_Product_Thumbnail_Navigation::get_instance();
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

        function wcbptn_woocommerce_not_active_notice()
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

        function wcbptn_deactivate_plugin()
        {
            deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        function wcbptn_deactivate_plugin_notice()
        {
            ?>
            <div class="updated fade">
                <p><?php _e('The Pricefiles plugin was deactivated.', WC_PRICEFILES_PLUGIN_SLUG); ?></p>
            </div>
            <?php
        }
        function wcbptn_activate_woocommerce()
        {
            deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        function wcbptn_activate_woocommerce_notice()
        {
            ?>
            <div class="updated fade">
                <p><?php _e('WooCommerce was activated.', WC_PRICEFILES_PLUGIN_SLUG); ?></p>
            </div>
            <?php
        }
    }
}
