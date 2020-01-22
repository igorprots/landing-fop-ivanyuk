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

wp_enqueue_style ( 	'robosoft-gallery-about', ROBO_GALLERY_URL.'css/admin/about.css', array( ), ROBO_GALLERY_VERSION );

echo '
	<div class="rbs_about_header">
		<img class="rbs_robogallery_logo" src="'.ROBO_GALLERY_URL.'about/robo-gallery.png" alt="Robo Gallery" />
		<img class="rbs_robosoft_logo" src="'.ROBO_GALLERY_URL.'about/robosoft.png" alt="RoboSoft" />
	</div>
	<div class="rbs_about_string1">
		'.__( 'Robo Gallery implemented by RoboSoft Team', 	'robo-gallery' ).'
	</div>
	<div class="rbs_about_string2">
		'.__( 'More details about Robo Gallery you can see on our website', 	'robo-gallery' ).':  
		<a href="https://www.robosoft.co/robogallery/" alt="robosoft.co">robosoft.co</a>
	</div>
	';
if(!ROBO_GALLERY_PRO){
	echo '
	<div class="rbs_about_string3">'.__( 'Robo Gallery Pro Features', 	'robo-gallery' ).':</div>

	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Unlimited amount of the galleries', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('Unlimited amount of images in galleries', 'robo-gallery').'</div>
	</div>
	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Custom hover style for border', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('Custom hover style for shadow', 'robo-gallery').'</div>
	</div>
	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Unlimited multi-categories', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('High quality thumbnails', 'robo-gallery').'</div>
	</div>
	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Gallery widget', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('Random ordering', 'robo-gallery').'</div>
	</div>
	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Gallery menu colors', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('Gallery menu styles', 'robo-gallery').'</div>
	</div>
	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Custom images ordering', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('Customizable hover style', 'robo-gallery').'</div>
	</div>
	<div class="rbs_about_flex">
		<div class="rbs_about_listing col1">- '.__('Custom hover background color', 'robo-gallery').'</div>
		<div class="rbs_about_listing col2">- '.__('Advanced images description settings', 'robo-gallery').'</div>
	</div>
	
	<div class="rbs_about_button">
		<a href="https://robosoft.co/go.php?product=gallery&task=gopro" alt="'.__('Get Pro version', 'robo-gallery').'">
			'.__('Get Pro version', 'robo-gallery').'
		</a>
	</div>
	';
}
echo '<div class="rbs_about_string2">Copyright &copy; 2014 - 2019 RoboSoft '.__('All Rights Reserved', 'robo-gallery').'.</div>
';