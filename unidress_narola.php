<?php
/**
 * Plugin Name: Unidress - Narola Infotech
 * Plugin URI: https://www.narolainfotech.com/
 * Description: This is a Plug-in for Unidress Website.
 * Version: 0.0.2
 * Requires PHP: 5.6.20
 * Author: Narola Infotech
 * Author URI: https://www.narolainfotech.com/
 * License: Narola Infotech
 * License URI: https://www.narolainfotech.com/
 * Text Domain: unidress-narola
 * Domain Path: /languages
 */

// If this file is called directly then it will abort execution
if(!defined('WPINC')){ die; }

// Define Unidress plugin directory path
define('UNIDRESS_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

// Define Unidress plugin directory url
define('UNIDRESS_PLUGIN_DRI_URL', plugin_dir_url(__FILE__));

/**
 * function for check WordPsess Version is 5.0 & above.
 * @author KK
 * @param function name
 * @return Error Message at new page and back to wordpress plugin page
 */
register_activation_hook( __FILE__ , 'unidress_narola_plugin_activate' );
function unidress_narola_plugin_activate(){

	// Check WordPsess Version is 5.0 or above or not
	function is_version($operator = '>', $version = '5.0'){
		global $wp_version;
		return version_compare( $wp_version, $version, $operator );
	}

	// Require WordPress Version 5.0 or above
	if( is_version() != 1 ){
		// Custom Error message in WordPress admin style
		wp_die('Sorry, but this plugin requires WordPress Version 5.0 above to be installed and active. <br><a href="'.admin_url('plugins.php').'">&laquo; Return to Plugins List</a>');
	} else {
		// Call installation PHP file for create required tables into database.
		require('unidress_narola_install.php');
	}
}

/**
 * function for Remove Custom Tables & Remove other options values.
 * @author KK
 * @param function name
 * @return NULL
 */
//register_deactivation_hook( __FILE__ , 'remove_data');
register_uninstall_hook( __FILE__ , 'remove_data');
function remove_data(){
	// Call PHP file for remove data related to Narola plugin.
	require('unidress_narola_uninstall.php');
}

// Enqueue CSS & JS into WordPress admin part
add_action('admin_enqueue_scripts', 'unidress_narola_wp_admin_style_scripts_loader');
function unidress_narola_wp_admin_style_scripts_loader(){
	wp_enqueue_style('custom_wp_admin_style', plugin_dir_url(__FILE__).'inc/admin-css.css');
	wp_enqueue_script('custom_wp_admin_script', plugin_dir_url(__FILE__).'inc/admin-js.js', array('jquery'), '', true);
}

// Include WordPress admin part files
include('admin/admin-options.php');

// Enqueue CSS & JS into WordPress front end part
/*
add_action('wp_enqueue_scripts', 'style_scripts_loader');
function style_scripts_loader(){
	wp_enqueue_style('fonts_awesome_style', plugin_dir_url(__FILE__).'inc/css/all.css');
	wp_enqueue_style('custom_style', plugin_dir_url(__FILE__).'inc/front-css.css');
	wp_enqueue_script('jquery_script', plugin_dir_url(__FILE__).'inc/js/jquery.js', array('jquery'), '', false);
}
*/

// Include WordPress front end part files
include('frontend/front-end-option.php');

/**
 * function for display array with formatting and have additional die() option
 * @author KK
 * @param 1) array variable, 2) boolean = true or false
 * @return string with <pre> variable </pre>
if (!function_exists('pr')) {
	function pr($data,$die=false){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		if($die == 'true'){
			die('debug die');
		}
	}
}
*/
?>