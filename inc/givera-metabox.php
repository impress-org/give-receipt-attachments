<?php
/**
 * The GIVERA Metabox 
 *
 * @copyright   Copyright (c) 2016, Matt Cromwell
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GiveRA_Form_Data {

    function __construct() {
        $this->id     = 'givera-settings-fields';
        $this->prefix = '_givera_';
        add_filter( 'give_metabox_form_data_settings', array( $this, 'add_givera_setting_tab' ), 999 );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_givera_scripts' ), 999 );
    }

    function add_givera_setting_tab($settings) {

        $settings['givera_options'] = apply_filters('givera_options', array(
            'id' => $this->prefix . 'givera_attachment',
            'title' => esc_html__('Receipt Attachments', 'give'),
            'fields' => apply_filters('givera_metabox_fields', $this->get_fields( "{$this->prefix}givera_attachment" )),
            'icon-html' => file_get_contents(GIVERA_URL . 'assets/givera-icon.svg'),
        ));

        return $settings;
    }

    public function get_fields( $id_prefix = '' ) {

        $prefix = '_givera_';

        return array(
            // Text small.
            array(
                'id'       => $prefix . 'attachment_url',
                'name'     => __( 'Attachment Upload', 'givera' ),
                'type'     => 'mediaupload',
                'desc'     => __( 'Upload your attachment via the WordPress Media Library.', 'givera' ),
                'callback' => array( $this, 'give_upload_field' ),
            ),
            array(
                'id'         => $prefix . 'min_amount',
                'name'       => __( 'Minimum Donation?', 'givera' ),
                'desc'       => __( 'If you want the Attachment available only if the donor donates a minimum amount, enter that here. Otherwise leave blank.', 'givera' ),
                'type'       => 'text_small',
                'data_type'  => 'price',
                'attributes'  => array(
                    'placeholder' => give_format_decimal( '1.00' ),
                    'class'       => 'give-money-field',
                ),
            ),
            array(
                'id'         => $prefix . 'confirmation_title',
                'name'       => __( 'Donation Confirmation Title', 'givera' ),
                'desc'       => __( 'This will appear on the Donation Confirmation page above your attachment download link.', 'givera' ),
                'type'       => 'text-medium',
            ),
            array(
                'id'         => $prefix . 'link_text',
                'name'       => __( 'Attachment Link Text', 'givera' ),
                'desc'       => __( 'This is what the link in your email will say', 'givera' ),
                'type'       => 'text-medium',
            ),
            array(
                'name' => esc_html__( 'Show Download on Receipt Page?', 'give' ),
                'desc'       => __( 'If this is disabled, then make sure the <code>{attachmenturl}</code> email tag is in your donation email receipts, otherwise there will be nowhere for your donors to access their download.', 'givera' ),
                'id'   => $prefix . 'enable_receipt',
                'type' => 'checkbox',
                'callback' => array( $this, 'give_toggle_switch' ),
            ),
        );
    }

    function give_toggle_switch($field) {
        global $thepostid, $post;
        $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
        $field['style']         = isset( $field['style'] ) ? $field['style'] : '';
        $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
        $field['value']         = give_get_field_value( $field, $thepostid );
        $field['cbvalue']       = isset( $field['cbvalue'] ) ? $field['cbvalue'] : 'on';
        $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
        ?>
        <div class="give-field-wrap <?php echo esc_attr( $field['id'] ); ?>_field <?php echo esc_attr( $field['wrapper_class'] ); ?>">
            <p class="toggle-label"><?php echo wp_kses_post( $field['name'] ); ?></p>
            <label for="<?php echo give_get_field_name( $field ); ?>" class="toggler-wrap">
                <input
                    type="checkbox"
                    style="<?php echo esc_attr( $field['style'] ); ?>"
                    name="<?php echo give_get_field_name( $field ); ?>"
                    id="<?php echo esc_attr( $field['id'] ); ?>"
                    value="<?php echo esc_attr( $field['cbvalue'] ); ?>"
                    <?php echo checked( $field['value'], $field['cbvalue'], false ); ?>
                    <?php echo give_get_attribute_str( $field['attributes'] ); ?>
                />
                <div class="toggler"></div>
            </label>

        <?php
        echo give_get_field_description( $field );
        echo '</div>';
    }

    function give_upload_field($field) {
        global $thepostid;

        $field['value'] = give_get_field_value( $field, $thepostid );

        ?>

            <p id="givera-attachment-url" class="give-field-wrap <?php echo esc_attr( $field['id'] ) . '_field'; ?>">
                <label for="<?php echo give_get_field_name( $field ); ?>"><?php echo wp_kses_post( $field['name'] ); ?></label>
                <input type="text" name="<?php echo give_get_field_name( $field ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo $field['value']; ?>" class="give-field give-text givera-attachment-url"> <span class="dashicons dashicons-no remove-attachment"></span><br />
                <input id="givera-attachment-button" type="button" class="button" value="Upload Attachment" />
            </p>

        <?php

    }

    function enqueue_givera_scripts($hook) {

        global $post;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ('give_forms' === $post->post_type) {
                wp_enqueue_style( 'givera-admin-css', GIVERA_URL . 'assets/givera-admin.css', array(), GIVERA_VERSION, 'all' );
                wp_enqueue_script( 'givera-admin-js', GIVERA_URL . 'assets/givera-admin.js', array('jquery','give-admin-scripts'), GIVERA_VERSION );
            }
        }
    }
}

new GiveRA_Form_Data();
