<?php
/**
 * Front End Narola Plug-in short codes
 * WooCommerce Category + Campaign category
 * @author KK
 */
add_shortcode('campaign_category', 'campaign_category_function');
function campaign_category_function(){
	ob_start();
	$taxonomy_list = array();
	$taxonomy = 'product_cat';
	$user_id = get_current_user_id();
	$current_customer = get_user_meta($user_id, 'user_customer', true);
	$campaign_id = get_post_meta($current_customer, 'active_campaign', true);
	$taxonomy_array = get_the_terms( $campaign_id, $taxonomy );
	if(!empty($taxonomy_array)){
		$taxonomy_list = $taxonomy_array;
	} else {
		$arg = array(
			'hide_empty' => true,
			'parent' => 0,
			'orderby' => 'count',
			'order' => 'DESC',
		);
		$taxonomy_list = get_terms( $taxonomy, $arg );
	}
?>
	<div class="widget_product_categories">
		<ul class="product-categories">
		<?php
			foreach ($taxonomy_list as $value) {
				$args2 = array(
					'taxonomy'     => $taxonomy,
					'parent'       => $value->term_id,
					'child_of'     => 0,
					'hierarchical' => true,
					'hide_empty'   => false
	        	);
        		$sub_cats = get_categories( $args2 );
		?>
				<li class="cat-item <?php if($sub_cats) { echo 'cat-parent'; } ?>">
					<a href="<?php echo get_category_link($value->term_id); ?>"><?php echo $value->name; ?></a>
					<?php
						if($sub_cats) {
							foreach ($sub_cats as $sub_category) {
					?>
								<ul class="children">
									<li class="cat-item">
										<a href="<?php echo get_category_link($sub_category->term_id); ?>"><?php echo $sub_category->name; ?></a>
									</li>
								</ul>
					<?php
							}
						}
					?>
				</li>
		<?php
			}
		?>
		</ul>
	</div>
<?php
	return ob_get_clean();
}

/**
 * Add a standard value surcharge to all transactions in cart / checkout
 * @author KK
 */
add_action( 'woocommerce_cart_calculate_fees','wc_add_surcharge' ); 
function wc_add_surcharge() {
	global $woocommerce;
	$user_id = get_current_user_id();
	$current_customer = get_user_meta($user_id, 'user_customer', true);
	$campaign_id = get_post_meta($current_customer, 'active_campaign', true);
	$min_order_value = get_post_meta($campaign_id, 'min_order_value', true) ?: 0;
	$min_order_charge = get_post_meta($campaign_id, 'min_order_charge', true) ?: 0;
	$shipping_price = get_post_meta($campaign_id, 'shipping_price', true) ?: 0;
	$total = $woocommerce->cart->get_totals('total')['cart_contents_total'];
	
	if( $min_order_value > 0 ){
		if( $min_order_charge > 0 && $total < $min_order_charge ) {
			$woocommerce->cart->add_fee( 'Shipping Price', $shipping_price, true, 'standard' );
		}
	}
}

?>