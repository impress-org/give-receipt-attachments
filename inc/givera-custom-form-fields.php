<?php
/**
 * Adding the Attachment to the Form Output 
 *
 * @copyright   Copyright (c) 2016, Matt Cromwell
 * @license     http://opensource.org/licenses/gpl-3.0.en.html GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds a Custom "attachmenturl" Tag
 * @description: This function creates a custom Give email template tag
 *
 * @param $payment_id
 */

function givera_attachment_tag( $payment_id ) {

	give_add_email_tag( 'attachmenturl', 'This outputs the url of the attachment for the relevant form', 'givera_attachment_data' );

}

add_action( 'give_add_email_tags', 'givera_attachment_tag' );


// Add URL to Payment Meta
function givera_attachment_paymentmeta($payment_meta) {
  $payment_meta['attachmenturl'] = get_post_meta( get_the_ID(), '_givera_attachment_url', true );

	return $payment_meta;

}

add_filter( 'give_payment_meta', 'givera_attachment_paymentmeta' );


// Adds info to the email tag {attachmenturl}
function givera_attachment_data( $payment_id ) {

	$paymentmeta = give_get_payment_meta( $payment_id );

	$formid = $paymentmeta['form_id'];

	$downloadurl = get_post_meta($formid, '_givera_attachment_url');
	$downloadtext = get_post_meta($formid, '_givera_link_text');
	$getminimum = get_post_meta($formid, '_givera_min_amount');
	$confirmationtitle = get_post_meta($formid, '_givera_confirmation_title');
	
	if (empty($getminimum)) {
		$minimum = '0';
	} else {
		$minimum = $getminimum;
	}
	
	//Normalize these amounts for proper comparison
	$paymentamount = html_entity_decode(give_payment_amount( $payment_id ));
	$donation = preg_replace("/([^0-9\\.])/i", "", $paymentamount);
	
	
	// Otherwise check whether it meets minimum donation requirement
	// then output accordingly.
	if ($downloadurl && ($donation >= $minimum[0]) ) {
		$output = '<a href="';
		$output .= $downloadurl[0];
		$output .= '">';
		$output .= $downloadtext[0];
		$output .= '</a>';
	} else {
		$output = '';
	}

	return $output;
}

add_action('give_payment_receipt_before_table', 'add_attachment_to_donation_receipt');

function add_attachment_to_donation_receipt( $payment ) {
	
	$paymentmeta = give_get_payment_meta( $payment->ID );
	$formid = $paymentmeta['form_id'];
	
	$attachurl = get_post_meta( $formid, '_givera_attachment_url', true );
	$attachtext = get_post_meta( $formid, '_givera_link_text', true );
	$getminimum = get_post_meta( $formid, '_givera_min_amount', true );
	$confirmationtitle = get_post_meta( $formid, '_givera_confirmation_title', true );
	$enabledownload = get_post_meta( $formid, '_givera_enable_receipt', true );

	
	if ( empty($getminimum) ) {
		$minimum = '0';
	} else {
		$minimum = $getminimum;
	}
	
	//Normalize these amounts for proper comparison
	$paymentamount = html_entity_decode( give_payment_amount( $payment->ID ) );
	$donation = preg_replace( "/([^0-9\\.])/i", "", $paymentamount );
	
	// Use for debugging the output
//	echo '<h4>Payment =</h4>';
//	var_dump($paymentamount);
//	echo '<h4>Amount =</h4>';
//	var_dump($donation);
//	echo '<h4>Minimum =</h4>';
//	var_dump($minimum);
//	var_dump($attachurl);
//	var_dump($attachtext);
	
	// Only show the Attachment text and links if
	// 1. There is a attachment url attached to this donation
	// 2. If there's a minimum amount, the donation is equal to or more than that minimum
	if ( $attachurl && ( $donation >= $minimum ) && ( $enabledownload == 'on' ) ) { ?>
		
		<div class="donation-attachment">
			<h3><?php echo $confirmationtitle; ?></h3>
			<p><a href="<?php echo $attachurl; ?>"><?php echo $attachtext; ?></a></p>
		</div>
		
	<?php }

}
