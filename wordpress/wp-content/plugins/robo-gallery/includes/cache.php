<?php
/*
*      Robo Gallery By Robosoft
*      Contact: https://robosoft.co/robogallery/ 
*      Copyright (c) 2014-2019, Robosoft. All rights reserved.
*/

if ( ! defined( 'WPINC' ) ) exit;


function robo_gallery_save_gallery( $post_id, $post, $update ) {
	
    $post_type = get_post_type($post_id);

    if ( ROBO_GALLERY_TYPE_POST != $post_type ) return;

    delete_transient( 'robo_gallery_cached_id'. $post_id ) ;
}
add_action( 'save_post', 'robo_gallery_save_gallery', 10, 3 );


function robo_gallery_new_gallery( $post_id, $post, $update ) {

	if( wp_is_post_revision( $post_id ) ) return;

	$post_type = get_post_type($post_id);
    if ( ROBO_GALLERY_TYPE_POST != $post_type ) return;

	/*add_post_meta($post_id, 'robo_gallery_cache', uniqid() );*/

}
add_action( 'wp_insert_post', 'robo_gallery_new_gallery', 10, 3 );

