WooCommerce-Thumbnail-Hack
==========================

Replace fullsize image when thumbnail on single product page in WooCommerce is clicked.

Place woocommerce-thumbnail-hack.php in your plugins dir. Activate plugin!

Easy way. You are done!

Better way:

In 

    /path-to-your-theme/woocommerce/single-product/product-thumbnails.php

After

    $attachment_ids = $product->get_gallery_attachment_ids();

Add

    array_unshift( $attachment_ids, get_post_thumbnail_id() );
    
Remove everything between

    //Optional start
    
and

    //Optional end
    
