<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class product_page_options_class {
	
	
	function __construct()
	{
		$woo_custom_option_plugin =  1; //get_option( 'woo_custom_option_plugin' );

		if($woo_custom_option_plugin == 1) {
			
			add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'display_product_options' ),30 );
		
		}
		
	}
	
	public function display_product_options($post_id = false)
	{

		global $product;
		
		if ( ! $post_id ) {
			
			global $post;
			
			$post_id = $post->ID;
			
		}
		
		$pro_type = $product->get_type();
		
		if($pro_type === 'simple' || $pro_type === 'variable')
		{
				
			$this->script_add();
		
			$array_options  = (array) get_post_meta( $post_id, '_product_custom_options', true );

			foreach ( $array_options as $options_key => $options ) {
				
				if ( isset($options['name']) && empty( $options['name'] ) ) {
					
					unset( $array_options[ $options_key ] );
					
					continue;
					
				}
			
				if( isset($options['type']) && $options['type'] === 'custom_field' )
				{
					
					woocommerce_get_template( 'custom_fields.php', array( 'options' => $options ), 'custom-options', plugin_dir_path( dirname( __FILE__ ) )  . '/templates/' );
				
				}
				elseif( isset($options['type']) && $options['type'] === 'custom_textarea' )
				{
					
					woocommerce_get_template( 'custom_textareas.php', array( 'options' => $options ), 'custom-options', plugin_dir_path( dirname( __FILE__ ) )  . '/templates/' );
				
				}
			
			}
			
			if ( ! isset( $product ) || $product->get_id() != $post_id ) {
				
				$the_product = get_product( $post_id );
				
			} else {
				
				$the_product = $product;
				
			}

			if ( is_object( $the_product ) ) {
				
				$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
				
				$display_price    = $tax_display_mode == 'incl' ? $the_product->get_price_including_tax() : wc_get_price_excluding_tax($the_product);
			
			} else {
				
				$display_price    = '';
				
			}

			echo '<div id="product-options-total" product-type="' . $the_product->get_type( ) . '" product-price="' . $display_price . '"></div>';
		}
	}
	
	public function script_add()
	{
	
		//wp_enqueue_script( 'custom-options', plugins_url( basename( dirname( dirname( __FILE__ ) ) ) ) . '/assets/js/options.js', array( 'jquery' ) );
		
		$woo_custom_option_optn_total =  1; //get_option( 'woo_custom_option_optn_total' );
		
		$woo_custom_option_fnl_total =  1; //get_option( 'woo_custom_option_fnl_total' );

		/* $params = array(
		//'num_decimals' => absint( get_option( 'woocommerce_price_num_decimals' ) ),
		'currency_symbol'     	 => get_woocommerce_currency_symbol(),
		'show_op'      			 => $woo_custom_option_optn_total,
		'show_ft'      			 => $woo_custom_option_fnl_total,
		'num_decimals' 				=> absint( get_option( 'woocommerce_price_num_decimals' ) ),
		'decimal_separator'  		=> esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ),
		'thousand_separator' 		=> esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) )
		);

		wp_localize_script( 'custom-options', 'woocommerce_custom_options_params', $params ); */
		
		?>
		<script>
		
			var woocommerce_custom_options_params = {
				
				currency_symbol : "<?php echo get_woocommerce_currency_symbol() ?>",
				op_show : "<?php _e('Options Total', 'atelierbourgeons'); ?>",
				ft_show : "<?php _e('Final Total', 'atelierbourgeons'); ?>",
				show_op : "<?php echo 1; ?>",
				show_ft : "<?php echo 1; ?>",
				num_decimals : "<?php echo absint( get_option( 'woocommerce_price_num_decimals' ) ) ?>",
				decimal_separator : "<?php echo esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ) ?>",
				thousand_separator : "<?php echo esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) ) ?>"
				
				
			}
			
		</script>
		<?php
		
		//echo "<script src=".  plugins_url( basename( dirname( dirname( __FILE__ ) ) ) ) . '/assets/js/custom-options.js' ."></script>";
		
	}
	
}

$GLOBALS['product_page_options_class_obj'] = new product_page_options_class();

?>