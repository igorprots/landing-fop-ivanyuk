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

$size_group = new_cmb2_box( array(
    'id' 			=> ROBO_GALLERY_PREFIX . 'size_metabox',
    'title' 		=> '<span class="dashicons dashicons-welcome-add-page"></span>'.__('Gallery Size Options' , 'robo-gallery' ),
    'object_types' 	=> array( ROBO_GALLERY_TYPE_POST ),
    'cmb_styles' 	=> false,
    'show_names'	=> false,
    'context' 		=> 'normal',
    'priority' 		=> 'high',
));

$size_group->add_field( array(
	'name' 			=> __('Width', 'robo-gallery'),
	'id' 			=> ROBO_GALLERY_PREFIX . 'width-size',
	'type' 			=> 'multisize',
	'default'		=> array( 'width'=> 100, 'widthType'=>''),
	'bootstrap_style'=> 1,
	'before_row' 	=> ' <br />
<div class="rbs_block">'	
));

$size_group->add_field( array(
    'name'    	=> __('Gallery Alignment','robo-gallery'),
    'default' 	=> '',
    'options'	=> array( 
    		'' 		=> __('Disable','robo-gallery'),
    		'left' 		=> __('Left','robo-gallery'),
    		'center'	=> __('Center','robo-gallery'),
    		'right'		=> __('Right','robo-gallery'),
    	),
    'id'	  	=> ROBO_GALLERY_PREFIX .'align',
    'type'    	=> 'rbsradiobutton',
));

$size_group->add_field( array(
	'name' 			=> __('Padding', 'robo-gallery'),
	'id' 			=> ROBO_GALLERY_PREFIX . 'paddingCustom',
	'type' 			=> 'padding',
	'default'		=> array( 'left'=> 0, 'top'=> 0, 'right'=> 0, 'bottom'=> 0),
	'bootstrap_style'=> 1,
	
));

$size_group->add_field( array(
	'name' 			=> __('Thumbs Options', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'thumb-size-options',
	'type' 			=> 'size',
	'level'			=> !ROBO_GALLERY_PRO,
	'before_row' 	=> '
	<div class="rbs_thumb_tabs">
		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#thumb_size_options" aria-controls="thumb_size_options" role="tab" data-toggle="tab">'.__('Thumbs Options', 'robo-gallery' ).'</a></li>
				<li role="presentation"><a href="#thumb_colums_options" aria-controls="thumb_colums_options" role="tab" data-toggle="tab">'.__('Size Options', 'robo-gallery' ).'</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="thumb_size_options"><br/>',
));

$size_group->add_field( array(
	'name' 			=> 	__('Custom Ratio', 'robo-gallery' ),
	'id' 			=> 	ROBO_GALLERY_PREFIX . 'sizeType',
	'type' 			=> 	'switch',
	'depends' 		=> 	'.rbs_size_width, .rbs_size_height',
	'default'		=> 	rbs_gallery_set_checkbox_default_for_new_post(0),
	'bootstrap_style'=> 1,
    'after_row' 	=> '
				</div>',
));

$size_group->add_field( array(
	'name' 			=> __('Colums ', 'robo-gallery'),
	'id' 			=> ROBO_GALLERY_PREFIX . 'colums',
	'type' 			=> 'colums',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(1),
	'bootstrap_style'=> 1,
	'level'			=> !ROBO_GALLERY_PRO,
    'before_row' 	=> '
				<div role="tabpanel" class="tab-pane" id="thumb_colums_options"><br/>',
	'after_row' => '
				</div>
			</div>
		</div>
	</div>
</div>',	
));