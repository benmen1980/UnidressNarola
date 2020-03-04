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
		?>
				<li class="cat-item">
					<a href="<?php echo get_category_link($value->term_id); ?>"><?php echo $value->name; ?></a>
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
 * @author KK
 * AJAX Call Functions.
 */
?>