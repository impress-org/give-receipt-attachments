<?php
/**
 * Plugin Name: 	Receipt Attachments for GiveWP
 * Plugin URI: 		https://go.givewp.com/wprog-receipt-attachments
 * Description: 	Add downloadable files to your Give Email Receipts and/or Confirmation Page.
 * Version: 		1.1.3
 * Author: 		GiveWP
 * Author URI: 		https://givewp.com/
 * License:      	GNU General Public License v3 or later
 * License URI:  	http://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:		givera
 *
 */


// Defines Plugin directory
if ( ! defined( 'GIVERA_DIR' ) ) {
	define( 'GIVERA_DIR', dirname( __FILE__ ) );
}
// Defines plugin directory URL for assets
if ( ! defined( 'GIVERA_URL' ) ) {
	define( 'GIVERA_URL', plugin_dir_url( __FILE__ ) );
}

// Defines Addon Basename
if ( ! defined( 'GIVERA_BASENAME' ) ) {
	define( 'GIVERA_BASENAME', plugin_basename( __FILE__ ) );
}

// Defines the minimum Give version for GIVE_RA to run
if ( ! defined( 'GIVERA_MIN_GIVE_VER' ) ) {
	define( 'GIVERA_MIN_GIVE_VER', '2.13.4' );
}

// Defines Add-on Version number for easy reference
if ( ! defined( 'GIVERA_VERSION' ) ) {
    define( 'GIVERA_VERSION', '1.1.3' );
}

// Checks if GIVE is active and minimum version.
// If not, it bails with an Admin notice as to why. 
// If so, it loads the necessary files and scripts

add_action( 'give_init', 'givera_plugin_init' );

function givera_plugin_init() {

	if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'Give' ) ) {

		add_action( 'admin_notices', 'givera_no_give_admin_notice' );
		add_action( 'admin_init', 'givera_deactivate' );

	} elseif (
		class_exists( 'Give' ) &&
		version_compare( GIVE_VERSION, GIVERA_MIN_GIVE_VER, '<' )
	) {

		add_action( 'admin_notices', 'givera_min_give_admin_notice' );
		add_action( 'admin_init', 'givera_deactivate' );

	} else {

		include_once( GIVERA_DIR . '/inc/givera-metabox.php' );
		include_once( GIVERA_DIR . '/inc/givera-custom-form-fields.php' );
		include_once( GIVERA_DIR . '/inc/plugin-activation.php' );
		add_action( 'init', 'givera_load_plugin_textdomain' );
		// Hook to trigger adding the activation data option upon plugin activation only
		register_activation_hook( __FILE__, 'givera_set_review_trigger_date' );
	}
}

// Throw an Alert to tell the Admin that GIVERA
// didn't activate because GIVE is not active

function givera_no_give_admin_notice() {

	$class   = 'notice notice-error';
	$message = sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> core plugin installed and activated for the Receipt Attachments Add-on to activate.', 'givera' ), 'https://wordpress.org/plugins/give' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );

}

// Throw an Alert to tell the Admin that GIVERA
// didn't activate because you don't have the
// minimum GIVE version number

function givera_min_give_admin_notice() {

	$class   = 'notice notice-error';
	$message = sprintf( __( '<strong>Activation Error:</strong> You must have <a href="%s" target="_blank">Give</a> version %s+ for the Receipt Attachment add-on to activate.', 'give-recurring' ), 'https://givewp.com', GIVERA_MIN_GIVE_VER );
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );

}

// Deactivate GIVERA
function givera_deactivate() {
	deactivate_plugins( GIVERA_BASENAME );
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

function givera_set_review_trigger_date() {
	
	// Create timestamp for when plugin was activated
	// For use with our delayed Admin Notice reminder

	$triggerreview = mktime( 0, 0, 0, date("m")  , date("d")+30, date("Y") );

	if ( ! get_option( 'givera_activation_date' ) ) {
		add_option( 'givera_activation_date', $triggerreview, '', 'yes' ); 
	}
}

// Load the "givera" textdomain
function givera_load_plugin_textdomain() {
    $domain = 'givera';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    // wp-content/languages/plugin-name/plugin-name-de_DE.mo
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    // wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
