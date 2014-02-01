<?php
/*
Plugin Name: WooComemrce Thumbnail Hack
Description: Replace fullsize image when thumbnail on single product page in WooCommerce is clicked. 
Author: Peter Elmered
Version: 1.0
Author URI: http://elmered.com/
*/


function pe_wcth_print_footer_scrips() {

    if(!is_product())
    {
        return;
    }
    

    //Set image sizes. Must match exactly!
    $product_thumbnail_size = '150x150';
    $product_image_size = '300x300';
    
    //Get number of thumbnails per row (columns)
    $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
?>
<script type='text/javascript'>
jQuery(function($){
    //Optional start
    $('.thumbnails>a').first().clone().prependTo($('.thumbnails')).find('img').attr('src', $('.woocommerce-main-image img').attr('src').replace('-<?php echo $product_image_size; ?>','-<?php echo $product_thumbnail_size; ?>'));
    
    $('.thumbnails>a').each( function( i, el) {
        
        var $el = $(el);
        
        $el.removeClass('first last');
        
        var $mod = i%<?php echo $columns; ?>;
        if($mod == 0)
        {
            $el.addClass('first');
        }
        else if($mod == 2)
        {
            $el.addClass('last');
        }
    });
    $('.thumbnails>a').last().addClass('last');
    //Optional end
    $('.thumbnails>a>img').click(function(e){
        e.stopPropagation();
        $('.woocommerce-main-image img').attr('src', $(this).attr('src').replace('-<?php echo $product_thumbnail_size; ?>','-<?php echo $product_image_size; ?>'));
        return false;
    }); 
 
});
</script>
<?php 
}

add_action('wp_footer', 'pe_wcth_print_footer_scrips', 99);
