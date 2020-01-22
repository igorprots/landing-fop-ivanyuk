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


if(!function_exists('rbs_gallery_topblock')){
	function rbs_gallery_topblock(){

	wp_enqueue_script( 	'robo-gallery-topblock', ROBO_GALLERY_URL.'js/admin/topblock.js', array( 'jquery' ), ROBO_GALLERY_VERSION, true );
	wp_enqueue_style ( 	'robo-gallery-topblock', ROBO_GALLERY_URL.'css/admin/topblock.css', array( ), ROBO_GALLERY_VERSION );
		
	/* style init */
	$blockStyle = 'background-color: #cd4040;padding: 15px 0 0 0;margin-left: -20px;font-family: Myriad Pro ;cursor: pointer;text-align: center;';
	$headerStyle = 'color: white;font-size: 30px;font-weight: bolder;padding: 0 0 15px 0;';
	$textStyle = 'font-weight: bolder;color: white;font-size: 18px;padding: 0 0 15px 15px;';
	$iconStyle = 'font-size: 40px;position: absolute;margin-left: -45px;margin-top: -10px;';

	echo '<div onClick="roboGalleryOpenInformation()" style="'.$blockStyle.'" >
			<div style="'.$headerStyle.'">
				<span class="dashicons dashicons-cart" style="'.$iconStyle.'"></span>'
				.__( 'Get Pro version' , 'robo-gallery' ).'
			</div>
			<div style="'.$textStyle.'">'
				.__( 'with PRO version you get more advanced functionality and even more flexibility in settings' , 'robo-gallery' ).' 
			</div>
		</div>';

		if( 
			defined('ROBO_GALLERY_SPECIAL') && 
			ROBO_GALLERY_SPECIAL && 
			defined('ROBO_GALLERY_EVENT_DATE') && 
			defined('ROBO_GALLERY_EVENT_HOUR') 
		){
			$date_event = strtotime(ROBO_GALLERY_EVENT_DATE);
			$hour_event = ROBO_GALLERY_EVENT_HOUR * 60 * 60;
			if( 
					( time() - $date_event > 0 ) &&  
					( time() - $date_event < $hour_event ) 
			){
				if( ROBO_GALLERY_SPECIAL==1 ){
					echo '<div class="rbsTopBlockFree rbs_getproversionfree_blank">
						<div class="rbsTopSmall"><span class="dashicons dashicons-carrot"></span> '.__( 'Do You wish to get PRO version for FREE ?' , 'robo-gallery' ).' </div>
					</div>';	
				}
				if(ROBO_GALLERY_SPECIAL==2){
					echo '<div class="rbsTopBlockFree rbs_getproversiontrans_blank">
						<div class="rbsTopSmall"><span class="dashicons dashicons-carrot"></span> '.__( 'Do You wish to get PRO version for translate?' , 'robo-gallery' ).' </div>
					</div>';
				}
			}
		}
	}
	if(!ROBO_GALLERY_PRO) add_action( 'in_admin_header', 'rbs_gallery_topblock' );
}
