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

$polaroid_group = new_cmb2_box( array(
    'id' 			=> ROBO_GALLERY_PREFIX . 'polaroid_metabox',
    'title' 		=> '<span class="dashicons  dashicons-money"></span> '.__( 'Polaroid Style Options', 'robo-gallery' ),
    'object_types' 	=> array( ROBO_GALLERY_TYPE_POST ),
    'show_names' 	=> false,
    'context' 		=> 'normal',
));

$polaroid_group->add_field( array(
	'name' 			=> __('Polaroid Style', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'polaroidOn',
	'type' 			=> 'switch',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(0),
	'depends' 		=> '.rbs_polaroid_block',
	'bootstrap_style'=> 1,
    'before_row' 	=> '
    <a id="rbs_polaroid_options_link"></a>
<div class="rbs_block"><br/>',
	'after_row'		=> '
	<div class="rbs_polaroid_block">',
));
    
$polaroid_group->add_field(array(
	'name'             => __('Source', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'polaroidSource',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'default'          => 'desc',
	'options'          => array(
		'title'		=> __( 'Title' , 'robo-gallery' ),
		'desc'		=> __( 'Desc' , 'robo-gallery' ),
		'caption'	=> __( 'Caption' , 'robo-gallery' )
	),
));

$polaroid_group->add_field( array(
    'name'    		=> __( 'Bg Color', 'robo-gallery' ),
    'id'   			=> ROBO_GALLERY_PREFIX.'polaroidBackground',
    'type' 			=> 'rbstext',
    'class'			=> 'form-control rbs_color',
    'data-default' 	=>  '#ffffff',
	'data-alpha'    => 'true',
    'small'			=> 1,
    'default'  		=> '#ffffff',
));

$polaroid_group->add_field( array(
	'name'             => __('Align', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'polaroidAlign',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'default'          => 'center',
	'options'          => array(
		'left' 		=> __( 'Left' , 	'robo-gallery' ),
		'right' 	=> __( 'Right' , 	'robo-gallery' ),
		'center' 	=> __( 'Center' , 	'robo-gallery' ),
	),
    'after_row'		=> '
    </div>
</div>'
));


	