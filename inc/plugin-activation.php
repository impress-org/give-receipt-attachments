<?php
/**
 * GiveWP Receipt Attachments
 *
 * @package     Give
 * @copyright   Copyright (c) 2020, Impress.org
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Notice for No Core Activation
 *
 * @since 1.3.3
 */
function givera_inactive_notice() {
    echo '<div class="error"><p>' . __( '<strong>Activation Error:</strong> You must have the <a href="https://givewp.com/" target="_blank">Give</a> plugin installed and activated for the Give Receipt Attachments Add-on to activate.', 'givera' ) . '</p></div>';
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