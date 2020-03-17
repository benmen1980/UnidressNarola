<?php
/**
 * Task : UN2-T4
 * function for add 'Budget' columns into User List
 * @author KK
 * @return array
 */
add_filter('manage_users_columns', 'unidress_narola_user_admin_list_function');
function unidress_narola_user_admin_list_function( $columns ) {
	$columns['budget'] = 'Budget';
	return $columns;
}

/**
 * Task : UN2-T4
 * function for add TextBox in 'Budget' columns into User List
 * @author KK
 * @return array
 */
add_action('manage_users_custom_column', 'unidress_narola_show_user_column_content', 10, 3);
function unidress_narola_show_user_column_content($value, $column_name, $user_id) {
	$value = get_user_meta($user_id, 'unidress_budget',true);
	$value = (!empty($value)) ? $value : 0;
	if ( 'budget' == $column_name ) {
		return "<input type='number' class='unidress_budget' value='".$value."' data-id='".$user_id."' />";
	}
	return $value;
}

/**
 * Task : UN2-T9
 * action for add product category list into 'campaign' post type
 * @author KK
 * @return array
 */
add_action( 'init', 'unidress_narola_product_taxonomy' );
function unidress_narola_product_taxonomy() {
	register_taxonomy( 
		'product_cat', array('product','campaign'),
		array(
			'hierarchical' => true
		)
	);
}

/* ----- Admin Part : AJAX Call functions ----- */

/**
 * Task : UN2-T4
 * function for add data of user Budget.
 * @author KK
 * @param POST Data :- user_id(int), budget(int)
 */
add_action('wp_ajax_nopriv_unidress_narola_save_budget_option', 'unidress_narola_save_budget_option');
add_action('wp_ajax_unidress_narola_save_budget_option', 'unidress_narola_save_budget_option');
function unidress_narola_save_budget_option() {
	$user_id = $_POST['user_id'];
	$budget_value = (!empty($_POST['budget_value'])) ? $_POST['budget_value'] : 0;
	echo $user_id.'-'.update_user_meta($user_id,'unidress_budget',$budget_value);
	die();
}
?>