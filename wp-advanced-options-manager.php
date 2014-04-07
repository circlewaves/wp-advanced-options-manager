<?php
/**
 * Plugin Name: WP Advanced options manager
 * Plugin URI: http://circlewaves.com/products/freebies/wp-advanced-options-manager
 * Description: Plugin for developers. Plugin allows you to get option values and update it.
 * Version: 1.0
 * Author: Circlewaves
 * Author URI: http://circlewaves.com
 * License: GPL2
 */
 
 /*
 * Useful resources:
 * http://wp.tutsplus.com/tutorials/plugins/creating-client-testimonials-with-custom-post-types/
 * http://wp.smashingmagazine.com/2012/11/08/complete-guide-custom-post-types/
 * http://net.tutsplus.com/tutorials/wordpress/introducing-wordpress-3-custom-taxonomies/
 *
 * http://codex.wordpress.org/Function_Reference/register_post_type
 */

 
/*
* Functions PREFIX: cw_wpaom_
*/
 
$cw_wpaom_plugin_slug='wp-advanced-options-manager'; 
$cw_wpaom_plugin_version='1.0.0'; 
$cw_wpaom_plugin_screen_hook_suffix=null;

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'cw_wpaom_activate'); 
function cw_wpaom_activate(){
// Activation functionality here
} 

/* Runs when plugin is deactivated */
register_deactivation_hook( __FILE__, 'cw_wpaom_deactivate' );
function cw_wpaom_deactivate(){
// Deactivation functionality here
} 

// Load admin style sheet and JavaScript.
add_action( 'admin_enqueue_scripts', 'cw_wpaom_enqueue_admin_styles_and_scripts' );
function cw_wpaom_enqueue_admin_styles_and_scripts() {
	global $cw_wpaom_plugin_screen_hook_suffix;
	// Include styles
	wp_enqueue_style( $cw_wpaom_plugin_slug.'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), $cw_wpaom_plugin_version );
	
	// Include scripts
	if ( ! isset( $cw_wpaom_plugin_screen_hook_suffix ) ) {
		return;
	}
	$screen = get_current_screen();	
	if(( $cw_wpaom_plugin_screen_hook_suffix == $screen->id )) {
		wp_enqueue_script('jquery');
		wp_enqueue_script( $cw_wpaom_plugin_slug.'-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery'), $cw_wpaom_plugin_version);		
	}
}

/* Add admin menu*/
add_action( 'admin_menu', 'cw_wpaom_add_plugin_admin_menu');
function cw_wpaom_add_plugin_admin_menu() {
global $cw_wpaom_plugin_slug;
global $cw_wpaom_plugin_screen_hook_suffix;
	/*
	 * Add a settings page for this plugin to the Settings menu.
	 */
		$cw_wpaom_plugin_screen_hook_suffix=add_options_page(
		__( 'Advanced Options Manager', $cw_wpaom_plugin_slug ),
		__( 'Options Manager', $cw_wpaom_plugin_slug ),
		'manage_options',
		$cw_wpaom_plugin_slug,
		'cw_wpaom_display_plugin_admin_page'
	);
	 
}

/**
 * Render the settings page for this plugin.
 *
 * @since    1.0.0
 */
function cw_wpaom_display_plugin_admin_page() {
global $cw_wpaom_plugin_slug;
	include_once( 'views/admin.php' );
}

?>