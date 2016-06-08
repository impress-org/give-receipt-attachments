<?php

/**
 *		Markup for the Activation  Admin Notice
 *
 **/

?>

<div class="updated give-addon-alert">

	<!-- Your Logo -->
	<img src="<?php echo GIVE_PLUGIN_URL; ?>assets/images/svg/give-icon-full-circle.svg" class="give-logo" />

	<!-- Your Message -->
	<h3><?php echo sprintf( __( 'Thank you for installing the %1$s%2$s%3$s Add-on for Give!', 'give' ), '<span>', 'Receipt Attachments', '</span>' ); ?></h3>

	<a href="<?php
	//The Dismiss Button
	$nag_admin_dismiss_url = 'plugins.php?givera_nag_meta_key=0';
	echo admin_url( $nag_admin_dismiss_url ); ?>" class="dismiss"><span class="dashicons dashicons-dismiss"></span></a>

	<!-- * Now we output a few "actions"
		 * that the user can take from here -->

	<div class="alert-actions">
		
			<a href="https://wordpress.org/support/plugin/give-receipt-attachments" target="_blank">
				<span class="dashicons dashicons-sos"></span><?php _e( 'Get Support', 'givera' ); ?>
			</a>

			<a href="https://www.mattcromwell.com/products/give-receipt-attachments" target="_blank">
				<span class="dashicons dashicons-heart"></span><?php _e( 'Support this Plugin', 'givera' ); ?>
			</a>

			<a href="https://wordpress.org/support/view/plugin-reviews/give" target="_blank">
				<span class="dashicons dashicons-star-filled"></span><?php _e( 'Leave a Review', 'givera' ); ?>
			</a>

		<?php //} ?>

	</div>
</div>