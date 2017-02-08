<?php
/**
 * Plugin Name: 	GIVE Receipt Attachments 
 * Plugin URI: 		https://www.mattcromwell.com/products/give-receipt-attachments
 * Description: 	Add downloadable files to your Give Email Receipts and/or Confirmation Page.
 * Version: 		1.1
 * Author: 			Matt Cromwell
 * Author URI: 		https://www.mattcromwell.com
 * License:      	GNU General Public License v3 or later
 * License URI:  	http://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:		givera
 *
 */


// Defines Plugin directory for easy reference
define( 'GIVERA_DIR', dirname( __FILE__ ) );
define( 'GIVERA_URL', plugin_dir_url( __FILE__ ) );

// Defines Addon Basename
if ( ! defined( 'GIVERA_BASENAME' ) ) {
    define( 'GIVERA_BASENAME', plugin_basename( __FILE__ ) );
}

// Defins Addon Version number for easy reference
if ( ! defined( 'GIVERA_VERSION' ) ) {
    define( 'GIVERA_VERSION', '1.1' );
}

// Checks if GIVE is active. 
// If not, it bails with an Admin notice as to why. 
// If so, it loads the necessary scripts 

function givera_plugin_init() {
	
	// If Give is NOT active
	if ( current_user_can( 'activate_plugins' ) && !class_exists('Give')) {
		
		add_action( 'admin_init', 'givera_deactivate' );
		add_action( 'admin_notices', 'givera_admin_notice' );
		
		// Deactivate GIVERA
		function givera_deactivate() {
		  deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		
		// Throw an Alert to tell the Admin why it didn't activate
		function givera_admin_notice() {
		   echo "<div class=\"error\"><p><strong>" . __('"Give Receipt Attachments"</strong> requires the free <a href="https://wordpress.org/plugins/give" target="_blank">Give Donation Plugin</a> to function. Please activate Give before activating this plugin. For now, the plug-in has been <strong>deactivated</strong>.', 'ggfd') . "</p></div>";
		   if ( isset( $_GET['activate'] ) )
				unset( $_GET['activate'] );
		}

	// If Give IS Active, then we load everything up.
    } else {
		
		// Include/Execute necessary files
        if ( version_compare( GIVE_VERSION, '1.8') < 0 ) {
            include_once( GIVERA_DIR . '/inc/givera-metabox.php' );
        } else {
            include_once( GIVERA_DIR . '/inc/givera-metabox-1-8.php' );
        }

		include_once( GIVERA_DIR . '/inc/givera-custom-form-fields.php' );
		include_once( GIVERA_DIR . '/inc/plugin-activation.php' );

	 }
}

// The initialization function
add_action( 'plugins_loaded', 'givera_plugin_init' );

// Hook to trigger adding the activation data option upon plugin activation only 
register_activation_hook( __FILE__, 'givera_set_review_trigger_date' );

function givera_set_review_trigger_date() {
	
	// Create timestamp for when plugin was activated
	// For use with our delayed Admin Notice reminder

	$triggerreview = mktime(0, 0, 0, date("m")  , date("d")+30, date("Y"));

	if ( !get_option('givera_activation_date')) {
		add_option( 'givera_activation_date', $triggerreview, '', 'yes' ); 
	}
}

// Load the "givera" textdomain

add_action( 'init', 'givera_load_plugin_textdomain' );

function givera_load_plugin_textdomain() {
    $domain = 'givera';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    // wp-content/languages/plugin-name/plugin-name-de_DE.mo
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    // wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
    load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
