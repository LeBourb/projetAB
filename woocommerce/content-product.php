<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product /*|| ! $product->is_visible()*/ ) {
?><h1 class="page-title">Not visiblet</h1>		<?php	
    return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}


?>
<li class="product-listed" href="">

	
        
        <div class="itemPhoto <?php global $product;  $num_left = $product->get_stock_quantity(); if( (!is_null($num_left) && $num_left == 0) || $product->get_stock_status() == 'outofstock') { echo "out-of-stock"; } ?> "><a href="<?php echo get_the_permalink()?>"><?php echo woocommerce_get_product_thumbnail('medium');?></a></div>
        <a href="<?php echo get_the_permalink()?>">        
        <h5 class="itemName"><?php echo get_the_title()?></h5>
        
        <?php             
            global $product;
            $attribute = $product->get_attribute("size"); 
            if($attribute != null && $attribute != "")
                echo '<h6 class="itemSize">['. __('Size','atelierbourgeons') . ': ' . $attribute . ']' . '</h6>';
            
            /*$tags =  get_the_terms($product->ID,'product_tag');
            foreach ( $tags as $tag ) {
                if( startsWith($tag->name ,'[' ) && endsWith($tag->name, ']'  ) ) {
                    echo '<div class="itemSize">'. $tag->name .'</div>';
                }
            }*/
        ?>
        <h6 class="itemPrice">
            
            
            <?php 
            
            if( pll_current_language() == 'ja') {
                $product->set_price( EURToJPY( $product->get_price() ) ); 
                if( $product->is_on_sale() ) {
                    $product->set_regular_price( EURToJPY($product->get_regular_price() ) );
                    $product->set_sale_price( EURToJPY($product->get_sale_price() ) );
                }     
            }
            
            ?><span class="price"><?php 
            
            echo $product->get_price_html(); ?></span>
        </h6>
        
        </a>
        
        <?php 
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item' );
	?>

</li>
