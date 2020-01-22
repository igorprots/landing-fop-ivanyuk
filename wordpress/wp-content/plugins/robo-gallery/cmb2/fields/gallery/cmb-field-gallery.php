<?php
/*
Plugin Name: CMB Field Type: Gallery
Plugin URI: https://github.com/mustardBees/cmb-field-gallery
Description: Gallery field type for Custom Metaboxes and Fields for WordPress. Thanks to <a href="http://www.purewebsolutions.nl/">Roel Obdam</a> for the hard work <a href="http://goo.gl/RYj2w">figuring out the media library</a>.
Version: 2.0.2
Author: Phil Wylie
Author URI: http://www.philwylie.co.uk/
License: GPLv2+
*/

define( 'ROBO_GALLERY_IMAGES_FIELD_URL', plugin_dir_url( __FILE__ ) );

function robo_gallery_images_field( $field, $meta ) {

	wp_enqueue_script( 'robo-gallery-images-field', ROBO_GALLERY_IMAGES_FIELD_URL . 'js/script.js', array( 'jquery' ), ROBO_GALLERY_VERSION );
	wp_enqueue_style( 'robo-gallery-images-field', ROBO_GALLERY_IMAGES_FIELD_URL . 'css/style.css', array(), '', 'all', ROBO_GALLERY_VERSION );
	
	/* remove extra content from OUR PLUGIN settings section */
	$css_inline = '#wpbody .fs-notice,#wpbody .fs-sticky,#wpbody .fs-has-title,#wpbody .wd-admin-notice,#wpbody .ngg_admin_notice{ display: none !important;}';
	wp_add_inline_style('robo-gallery-images-field', $css_inline);


	if ( empty( $meta ) || $meta == ' ' || $meta == '' || !is_array($meta) ) {
		$meta = ' ';
	} else $meta = implode( ',', $meta );

	echo '<div class="robo-gallery-images-field rbs_block ">';
	echo '	<input type="hidden" class="robo-gallery-images-field-value" id="' . $field->args( 'id' ) . '" name="' . $field->args( 'id' ) . '" value="' . $meta . '" />';
	echo '	<button class="btn btn-info btn-lg "><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> ' . ( $field->args( 'button' ) ? $field->args( 'button' ) : 'Manage gallery' ) . ' </button>';
	echo '</div>';

	$desc = $field->args( 'desc' );
	if ( ! empty( $desc ) ) echo '<p class="cmb2-metabox-description">' . $desc . '</p>';
}
add_filter( 'cmb2_render_robo_gallery_images_field', 'robo_gallery_images_field', 10, 2 );


function robo_gallery_images_field_sanitise( $meta_value, $field ) {
	if ( empty( $meta_value ) ) {
		$meta_value = '';
	} else {
		$meta_value = explode( ',', $meta_value );
	}
	return $meta_value;
}
