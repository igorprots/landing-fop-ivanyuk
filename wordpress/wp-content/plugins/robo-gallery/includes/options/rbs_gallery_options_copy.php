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

if( isset($_GET['post']) ) $id = (int) $_GET['post'];

if( !isset($id)  && isset($_POST['post_ID']) ) $id= $_POST['post_ID'];

if( !isset($id) || !$id ) return ;

if( get_option( ROBO_GALLERY_PREFIX.'cloneBlock', 0 ) && !get_post_meta( $id,  ROBO_GALLERY_PREFIX.'options', true ) ){
	return ;
}

$copy_group = new_cmb2_box( array(
    'id' 			=> ROBO_GALLERY_PREFIX . 'copy_metabox',
    'title' 		=> '<span class="dashicons dashicons-admin-settings"></span> '.__( ' Clone Gallery', 'robo-gallery' ),
    'object_types' 	=> array( ROBO_GALLERY_TYPE_POST ),
    'show_names' 	=> false,
    'context' 		=> 'normal',
    'priority' 		=> 'high',
));

$copy_group->add_field(array(
    'name' => __( 'Source Gallery', 'robo-gallery' ),
    'desc' => __( 'When you select here to inherit settings from another gallery you\'ll not be able to edit some of the options. Gallery will copy all settings from selected source.', 'robo-gallery' ),
    'desc2' => __( 'Very useful option for the webmasters who planning to create a lot of galleries. You don\'t have to configure it every time. Just setup styles of the gallery in one place and use the same options for another galleries on your website in another galleries.  Very fast, comfortable, advanced tool to speed up your work flow!', 'robo-gallery' ),
    'id'   => ROBO_GALLERY_PREFIX . 'options', 
    'type' => 'rbsgallery',
	'bootstrap_style'=> 1,
	'default'		=> -1,
    'before_row' 	=> '
<div class="rbs_block"><br/>',
	'after_row'		=> '
</div> ',
));
