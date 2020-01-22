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

$button_group = new_cmb2_box( array(
    'id' 			=> ROBO_GALLERY_PREFIX . 'button_metabox',
    'title' 		=> '<span class="dashicons dashicons-format-gallery"></span> '.__( 'Menu Options', 'robo-gallery' ),
    'object_types' 	=> array( ROBO_GALLERY_TYPE_POST ),
    'show_names' 	=> false,
    'context' 		=> 'normal',
));

$button_group->add_field( array(
	'name' 			=> __('Images of the Current Gallery', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'menuSelfImages',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(1),
	'type' 			=> 'switch',
	'showhide'		=> 1,
	'bootstrap_style'=> 1,
	'before_row'	=> '
	<div class="rbs_block">
	<br />',
	'after_row' 	=> ' 
	<div class="row">
		<div class="col-sm-10 col-sm-offset-2 ">
			<span class="rbs_desc">
				'.__('This option hide images of the current gallery. Very helpful in the case if you have structure of the root gallery with sub categories and you wish to hide root gallery images and show only images from sub categories.', 'robo-gallery' ).'
				</span>
		</div>
	</div>
	<br/>
	 '
));


$button_group->add_field( array(
	'name' 			=> __('Menu', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'menu',
	'type' 			=> 'switch',
	'level'			=> !ROBO_GALLERY_PRO,
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(1),
	'bootstrap_style'=> 1,
	'showhide'		=> 1,
	'depends' 		=> 	'.rbs_menu_options',
	'before_row'	=> '
	<a id="rbs_menu_options_link"></a>
',
	'after_row'		=> '
	<div class="rbs_menu_options">',
));

$button_group->add_field( array(
	'name' 			=> __('Menu mode', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'menuTag',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(0),
	'type' 			=> 'switch',
	'level'			   => !ROBO_GALLERY_PRO,
	'update'		=> '1.4',
	
	'depends' 		=> 	'.menuTagOptions',

	'onText'		=> __('Tags', 		'robo-gallery' ),
	'offText'		=> __('Categories', 'robo-gallery' ),
	'onStyle'		=> __('primary', 	'robo-gallery' ),
	'offStyle'		=> __('info', 		'robo-gallery' ),
	'bootstrap_style'=> 1,
	'after_row'		=> '
	<div class="menuTagOptions">'
));

$button_group->add_field( array(
	'name'             => __('Tags Ordering', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'menuTagSort',
	'type'             => 'rbsradiobutton',
	'show_option_none' => false,
	'update'		=> '1.5',
	'default'          => '',
	'options'          => array(
		'' 		=> __( 'No ordering' , 		'robo-gallery' ),
		'asc' 	=> __( 'Alphabetical asc' , 'robo-gallery' ),
		'desc' 	=> __( 'Alphabetical desc' ,'robo-gallery' ),
	),
	'after_row'		=> '
	</div>',
));





$button_group->add_field( array(
	'name' 			=> __('Root Label', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'menuRoot',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(1),
	'type' 			=> 'switch',
	'bootstrap_style'=> 1,
	'depends' 		=> 	'.rbs_menu_root_text',
	'showhide'		=> 1,
	'before_row'	=>'
	<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#menu_label" aria-controls="menu_label" role="tab" data-toggle="tab">'.__('Menu Labels', 'robo-gallery' ).'</a></li>
				<li role="presentation"><a href="#menu_render" aria-controls="menu_render" role="tab" data-toggle="tab">'.__('Menu Style', 'robo-gallery' ).'</a></li>
				<li role="presentation"><a href="#menu_search" aria-controls="menu_search" role="tab" data-toggle="tab">'.__('Search', 'robo-gallery' ).'</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="menu_label"><br/>',
	'after_row'		=>'
					<div class="rbs_menu_root_text">',
));

$button_group->add_field( array(
    'name'    => __('Root Label Text','robo-gallery'),
    'default' => __('All', 'robo-gallery' ),
    'id'	  => ROBO_GALLERY_PREFIX .'menuRootLabel',
    'type'    => 'rbstext',
    'after_row'		=> '
					</div>',
));



$button_group->add_field( array(
	'name' 			=> __('Self Label', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'menuSelf',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(1),
	'type' 			=> 'switch',
	'showhide'		=> 1,
	'bootstrap_style'=> 1,
));







$button_group->add_field( array(
	'name'             => __( 'Style', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'buttonFill',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'level'			   => !ROBO_GALLERY_PRO,
	'default'          => 'flat',
	'options'          => array(
		 'normal' 	=> __( 'Normal' , 	'robo-gallery' ),
		 'flat' 	=> __( 'Flat' , 	'robo-gallery' ),
		 '3d'		=> __( '3d' , 		'robo-gallery' ),
		 'border' 	=> __( 'Border' , 	'robo-gallery' ),
	),
	 'before_row'=> 	'
	   			</div>
	        	<div role="tabpanel" class="tab-pane" id="menu_render"><br/>',
	
));

$button_group->add_field( array(
	'name'             => __( 'Color', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'buttonColor',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'level'			   => !ROBO_GALLERY_PRO,
	'default'          => 'blue',
	'options'          => array(
		'gray' 		=> __( 'Gray' , 'robo-gallery' ),
		'blue' 		=> __( 'Blue' , 'robo-gallery' ),
		'green' 	=> __( 'Green' , 'robo-gallery' ),
		'orange' 	=> __( 'Orange' , 'robo-gallery' ),
		'red' 		=> __( 'Red' , 'robo-gallery' ),
		'purple' 	=> __( 'Purple' , 'robo-gallery' ),
	),
));

$button_group->add_field( array(
	'name'             => __( 'Rounds', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'buttonType',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'default'          => 'normal',
	'options'          => array(
		'normal' 	=> __( 'Normal' , 	'robo-gallery' ),
		'rounded' 	=> __( 'Rounded' , 	'robo-gallery' ),
		'pill' 		=> __( 'Pill' , 	'robo-gallery' ),
		'circle' 	=> __( 'Circle ' , 	'robo-gallery' ),
	),
));

$button_group->add_field( array(
	'name'             => __( 'Size', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'buttonSize',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'default'          => 'large',
	'options'          => array(
		'jumbo' 	=> __( 'Jumbo' , 	'robo-gallery' ),
		'large' 	=> __( 'Large' , 	'robo-gallery' ),
		'normal' 	=> __( 'Normal' , 	'robo-gallery' ),
		'small' 	=> __( 'Small' , 	'robo-gallery' ),
		'tiny' 		=> __( 'Tiny ' , 	'robo-gallery' ),
	),
));

$button_group->add_field( array(
	'name'             => __( 'Align', 'robo-gallery' ),
	'id'               => ROBO_GALLERY_PREFIX . 'buttonAlign',
	'type'             => 'rbsselect',
	'show_option_none' => false,
	'default'          => 'left',
	'options'          => array(
		'left' 	=> __( 'Left' , 	'robo-gallery' ),
		'center'=> __( 'Center' , 	'robo-gallery' ),
		'right' => __( 'Right' , 	'robo-gallery' ),
	),
));

$button_group->add_field( array(
	'name' 			=> __( 'Left Padding', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'paddingLeft',
	'type' 			=> 'slider',
	'bootstrap_style'=> 1,
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(5),
	'min'			=> 0,
	'addons'		=> 'px',
	'max'			=> 100,
));

$button_group->add_field( array(
	'name' 			=> __( 'Bottom Padding', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'paddingBottom',
	'type' 			=> 'slider',
	'bootstrap_style'=> 1,
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(10),
	'min'			=> 0,
	'max'			=> 100,
	'addons'		=> 'px',
	'after_row'		=> '
				</div>
				<div role="tabpanel" class="tab-pane" id="menu_search"><br/>'
));	


$button_group->add_field( array(
	'name' 			=> __('Search', 'robo-gallery' ),
	'id' 			=> ROBO_GALLERY_PREFIX . 'searchEnable',
	'default'		=> rbs_gallery_set_checkbox_default_for_new_post(0),
	'type' 			=> 'switch',
	'showhide'		=> 1,
	'bootstrap_style'=> 1,
	
));


$button_group->add_field( array(
    'name'    		=> __( 'Search Color', 'robo-gallery' ),
    'id'   			=> ROBO_GALLERY_PREFIX.'searchColor',
    'type' 			=> 'rbstext',
    'class'			=> 'form-control rbs_color',
    'data-default' 	=> 'rgba(0, 0, 0)',
    'default'  		=> 'rgba(0, 0, 0)',
    'small'			=> 1,
    'level'			=> !ROBO_GALLERY_PRO,
));

$button_group->add_field( array(
    'name'    => __('Search Text','robo-gallery'),
    'default' => __('search', 'robo-gallery' ),
    'id'	  => ROBO_GALLERY_PREFIX .'searchLabel',
    'type'    => 'rbstext',
    'after_row'		=> '
				</div>
			</div>
		</div>
    </div>
</div>'
));