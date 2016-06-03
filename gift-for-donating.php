<?php
/**
 * Plugin Name: 	GIVE Receipt Attachments 
 * Plugin URI: 		https://www.mattcromwell.com/products/give-receipt-attachments
 * Description: 	Add downloadable files to your Give Email Receipts and/or Confirmation Page.
 * Version: 		1.0
 * Author: 			Matt Cromwell
 * Author URI: 		https://www.mattcromwell.com
 * License:      	GNU General Public License v3 or later
 * License URI:  	http://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:		givera
 *
 */

// Defines Plugin directory for easy reference
define( 'GIVERA_DIR', dirname( __FILE__ ) );
 
function givera_plugin_init() {
	
	// If Give is NOT active
	if ( current_user_can( 'activate_plugins' ) && !class_exists('Give')) {
		
		add_action( 'admin_init', 'my_plugin_deactivate' );
		add_action( 'admin_notices', 'my_plugin_admin_notice' );
		
		// Deactivate GGFD
		function my_plugin_deactivate() {
		  deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		
		// Throw an Alert to tell the Admin why it didn't activate
		function my_plugin_admin_notice() {
		   echo "<div class=\"error\"><p><strong>" . __('"Give Receipt Attachments"</strong> requires the free <a href="https://wordpress.org/plugins/give" target="_blank">Give Donation Plugin</a> to function. Please activate Give before activating this plugin. For now, the plug-in has been <strong>deactivated</strong>.', 'ggfd') . "</p></div>";
		   if ( isset( $_GET['activate'] ) )
				unset( $_GET['activate'] );
		}

     } else {
		
		include_once( GIVERA_DIR . '/inc/givera-metabox.php' );
		include_once( GIVERA_DIR . '/inc/givera-custom-form-fields.php' );
	 }
}

add_action( 'plugins_loaded', 'givera_plugin_init' );