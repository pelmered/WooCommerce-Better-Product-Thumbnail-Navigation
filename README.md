WooCommerce-Better-Thumbnail-Navigation
==========================

Replace fullsize image when thumbnail on single product page in WooCommerce is clicked.

This is dependant on CSS selectors to work and may not work with any theme. It is tested and works with the standard templates from WooCommerce and a few of the themes from WooThemes(Wootique for example).

Place woocommerce-thumbnail-hack.php in your plugins dir. Activate plugin!

Easy way. You are done!

Integrate into your theme(Edit your theme and do not use this plugin):

In 

    /path-to-your-theme/woocommerce/single-product/product-thumbnails.php

After

    $attachment_ids = $product->get_gallery_attachment_ids();

Add

    array_unshift( $attachment_ids, get_post_thumbnail_id() );
    
Copy the following into one of your script files

```
jQuery('.thumbnails>a').first().clone().prependTo($('.thumbnails')).find('img').attr('src', $('.woocommerce-main-image img').attr('src').replace('-<Single_product_image_size_here>','-<Thumbnail_product_image_size_here>'));

jQuery('.thumbnails>a').each( function( i, el) {

    var $el = jQuery(el);

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
jQuery('.thumbnails>a').last().addClass('last');
```

Change `<Single_product_image_size_here>` and `<Thumbnail_product_image_size_here>` into the image sises of your theme. Should be like thi `widthxheight`, for example `200x200`.

Done!

