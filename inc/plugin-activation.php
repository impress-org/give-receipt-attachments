<?php
/**
 * Give Addon Boilerplate
 *
 * @package     Give
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Give Display Donors Activation Banner
 *
 * Includes and initializes Give activation banner class.
 *
 * @since 1.0
 */

add_action( 'admin_init', 'givera_activation_banner' );

function givera_activation_banner() {

    // Check for if give plugin activate or not.
    $is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

    //Check to see if Give is activated, if it isn't deactivate and show a banner
    if ( is_admin() && current_user_can( 'activate_plugins' ) && ! $is_give_active ) {

        add_action( 'admin_notices', 'givera_inactive_notice' );

        //Don't let this plugin activate
        deactivate_plugins( GIVERA_BASENAME );

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        return false;

    }

    //Check for activation banner inclusion.
    if ( ! class_exists( 'Give_Addon_Activation_Banner' )
        && file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' ) ) {

        include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';

        //Only runs on admin.
        $args = array(
            'file'              => __FILE__,
            'name'              => esc_html__( 'Boilerplate', 'give-receipt-attachments' ),
            'version'           => GIVERA_VERSION,
            'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons' ),
            'documentation_url' => 'https://givewp.com/documentation/add-ons/boilerplate/',
            'support_url'       => 'https://givewp.com/support/',
            'testing'           => false //Never leave true.
        );

        new Give_Addon_Activation_Banner( $args );

    }

    return false;

}

/**
 * Notice for No Core Activation
 *
 * @since 1.3.3
 */
function givera_inactive_notice() {
    echo '<div class="error"><p>' . __( '<strong>Activation Error:</strong> You must have the <a href="https://givewp.com/" target="_blank">Give</a> plugin installed and activated for the Give Receipt Attachments Add-on to activate.', 'givera' ) . '</p></div>';
}


/**
 * Plugins row action links
 *
 * @since 1.3.3
 *
 * @param array $actions An array of plugin action links.
 *
 * @return array An array of updated action links.
 */

add_filter( 'plugin_action_links_' . GIVERA_BASENAME, 'givera_plugin_action_links' );

function givera_plugin_action_links( $actions ) {
    $new_actions = array(
        'settings' => sprintf(
            '<a href="%1$s">%2$s</a>',
            admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons' ),
            esc_html__( 'Settings', 'give' ) //Keeping "give" textdomain to inherit transaltions from Give
        ),
    );

    return array_merge( $new_actions, $actions );
}

/**
 * Plugin row meta links.
 *
 * @since 1.3.3
 *
 * @param array  $plugin_meta An array of the plugin's metadata.
 * @param string $plugin_file Path to the plugin file, relative to the plugins directory.
 *
 * @return array
 */
add_filter( 'plugin_row_meta', 'givera_plugin_row_meta', 10, 2 );

function givera_plugin_row_meta( $plugin_meta, $plugin_file ) {
    if ( $plugin_file != GIVERA_BASENAME ) {
        return $plugin_meta;
    }

    $new_meta_links = array(
        sprintf(
            '<a href="%1$s" target="_blank">%2$s</a>',
            esc_url( add_query_arg( array(
                    'utm_source'   => 'plugins-page',
                    'utm_medium'   => 'plugin-row',
                    'utm_campaign' => 'admin',
                ), 'https://givewp.com/documentation/add-ons/boilerplate/' )
            ),
            esc_html__( 'Documentation', 'give' ) //Keeping "give" textdomain to inherit transaltions from Give
        ),
        sprintf(
            '<a href="%1$s" target="_blank">%2$s</a>',
            esc_url( add_query_arg( array(
                    'utm_source'   => 'plugins-page',
                    'utm_medium'   => 'plugin-row',
                    'utm_campaign' => 'admin',
                ), 'https://givewp.com/addons/' )
            ),
            esc_html__( 'Add-ons', 'give' ) //Keeping "give" textdomain to inherit transaltions from Give
        ),
    );

    return array_merge( $plugin_meta, $new_meta_links );
}


/*
 *   Delayed Admin Notice for Suggesting a Review/Donation
 */

add_action( 'admin_notices', 'givera_review_notice' );

function givera_review_notice() {

    //Get current user
    global $current_user ;
    $user_id = $current_user->ID;

    $today = mktime( 0, 0, 0, date("m")  , date("d"), date("Y") );

    if ( get_option( 'givera_activation_date') ) {

        $installed = get_option( 'givera_activation_date', false );
    } else {
        $installed = 999999999999999999999;
    }

    //Get the current page to add the notice to
    global $pagenow;

    if ( $installed <= $today ) {

        //Make sure we're on the plugins page.
        if ( $pagenow == 'plugins.php' ) {

            // If the user hasn't already dismissed our alert,
            // Output the activation banner
            $nag_admin_dismiss_url = 'plugins.php?givera_review_dismiss=0';

            if (!get_user_meta($user_id, 'givera_review_dismiss')) {

                ?>
                <div class="notice notice-success">

                    <style>
                        p.review {
                            position: relative;
                            margin-left: 35px;
                        }
                        p.review span.dashicons-heart {
                            color: white;
                            background: #66BB6A;
                            position: absolute;
                            left: -50px;
                            padding: 9px;
                            top: -8px;
                        }

                        p.review strong {
                            color: #66BB6A;
                        }
                        p.review a.dismiss {
                            float: right;
                            text-decoration: none;
                            color: #66BB6A;
                        }
                    </style>
                    <?php
                    // For testing purposes
                    //echo '<p>Today = ' . $today . '</p>';
                    //echo '<p>Installed = ' . $installed . '</p>';
                    ?>

                    <p class="review"><span class="dashicons dashicons-heart"></span><?php echo _e( 'Are you enjoying <strong>Receipt Attachments for Give</strong>? Would you consider either a <a href="https://www.mattcromwell.com/products/give-receipt-attachments" target="_blank">small donation</a> or a <a href="https://wordpress.org/support/view/plugin-reviews/give-receipt-attachments" target="_blank">kind review to help continue development of this plugin?', 'givera' ); ?><a href="<?php echo admin_url( $nag_admin_dismiss_url ); ?>" class="dismiss"><span class="dashicons dashicons-dismiss"></span></a>
                    </p>

                </div>

            <?php }
        }
    }
}

// Function to force the Review Admin Notice to stay dismissed correctly
add_action('admin_init', 'givera_ignore_review_notice');

function givera_ignore_review_notice() {
    if ( isset( $_GET[ 'givera_review_dismiss' ] ) && '0' == $_GET[ 'givera_review_dismiss' ] ) {

        //Get the global user
        global $current_user;
        $user_id = $current_user->ID;

        add_user_meta( $user_id, 'givera_review_dismiss', 'true', true );
    }
}