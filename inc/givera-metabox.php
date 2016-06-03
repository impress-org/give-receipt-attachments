<?php
/**
 * The GIVERA Metabox 
 *
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 
// Because Give already requires CMB2 
// And GIVERA requires Give, there's no need to require CMB2
// We can just jump right into metabox creation with the CMB2 action

add_action( 'cmb2_admin_init', 'givera_metabox' );

function givera_metabox() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_givera_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$givera = new_cmb2_box( array(
		'id'            => $prefix . 'givera_attachment',
		'title'         => __( 'Give Receipt Attachments', 'givera' ),
		'object_types'  => array( 'give_forms'),
		'context'    => 'normal',
		'priority'   => 'core',
	) );
	$givera->add_field( array(
		'name'       => __( 'Upload', 'givera' ),
		'id'         => $prefix . 'attachment_url',
		'type'       => 'file',
		'options' => array(
			'url' => true,
			'add_upload_file_text' => 'Upload Your Attachment File'
		),
	) );
	$givera->add_field( array(
		'name'       => __( 'Minimum Donation?', 'givera' ),
		'desc'       => __( 'If you want the Attachment available only if the donor donates a minimum amount, enter that here. Otherwise leave blank.', 'givera' ),
		'id'         => $prefix . 'min_amount',
		'type'       => 'text_money',
	) );
	$givera->add_field( array(
		'name'       => __( 'Donation Confirmation Title', 'givera' ),
		'desc'       => __( 'This will appear on the Donation Confirmation page above your attachment download link.', 'givera' ),
		'id'         => $prefix . 'confirmation_title',
		'type'       => 'text',
	) );
	$givera->add_field( array(
		'name'       => __( 'Attachment Link Text', 'givera' ),
		'desc'       => __( 'This is what the link in your email will say', 'givera' ),
		'id'         => $prefix . 'link_text',
		'type'       => 'text',
	) );

}
