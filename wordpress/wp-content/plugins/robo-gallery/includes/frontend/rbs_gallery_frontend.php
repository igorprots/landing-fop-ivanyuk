<?php
/*
*      Robo Gallery     
*      Version: 1.0
*      By Robosoft
*
*      Contact: https://robosoft.co/robogallery/ 
*      Created: 2015
*      Licensed under the GPLv2 license - http://opensource.org/licenses/gpl-2.0.php
*
*      Copyright (c) 2014-2019, Robosoft. All rights reserved.
*      Available only in  https://robosoft.co/robogallery/ 
*/

if ( ! defined( 'WPINC' ) ) exit;

function roboGalleryTag($content){
    global $post;
    
    if ( post_password_required() ) return $content;

    $returnCode = '';
    if( get_post_type() == ROBO_GALLERY_TYPE_POST && is_main_query() ){
		$returnCode = do_shortcode("[robo-gallery id={$post->ID}]");
	}
	return $content.$returnCode;
}
add_filter( 'the_content', 'roboGalleryTag');

function robo_gallery_shortcode( $attr ) {
 	$retHTML = '';
	if( isset($attr) && isset($attr['id']) ){
		//$id = $attr['id'];
		$gallery = new roboGallery($attr);
		$retHTML = $gallery->getGallery();
	}	
	return  $retHTML;
}
add_shortcode( 'robo-gallery', 'robo_gallery_shortcode' );