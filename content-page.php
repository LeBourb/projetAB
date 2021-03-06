<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package storefront
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<?php
	/**
	 * Functions hooked in to storefront_page add_action
	 *
	 * @hooked storefront_page_header          - 10
	 * @hooked storefront_page_content         - 20
	 * @hooked storefront_init_structured_data - 30
         * Pas de header storefront pour les pages woocommerce (Account)
	 */
        if(is_pll_wc('myaccount') || is_pll_wc('cart'))
            remove_action('storefront_page', 'storefront_page_header', 10 );
        
	do_action( 'storefront_page' );
	?>
</article><!-- #post-## -->
