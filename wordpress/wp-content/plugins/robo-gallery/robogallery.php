<?php
/*
Plugin Name: Robo Gallery
Plugin URI: https://robosoft.co/wordpress-gallery-plugin
Description: Gallery modes photo gallery, images gallery, video gallery, Polaroid gallery, gallery lighbox, portfolio gallery, responsive gallery
Version: 2.8.28
Author: RoboSoft
Author URI: https://robosoft.co/wordpress-gallery-plugin
License: GPLv3 or later
Text Domain: robo-gallery
Domain Path: /languages
*/

if(!defined('WPINC'))die;

define("ROBO_GALLERY", 1); 
define("ROBO_GALLERY_VERSION", '2.8.28'); 

define("ROBO_GALLERY_OPTIONS", 'rbs_opt_'); 

if( !defined("ROBO_GALLERY_PATH") ) define("ROBO_GALLERY_PATH", plugin_dir_path( __FILE__ ));

define("ROBO_GALLERY_SPECIAL", 0); 
define("ROBO_GALLERY_EVENT_DATE", '2016-12-08'); 
define("ROBO_GALLERY_EVENT_HOUR", 20); 

add_action( 'plugins_loaded', 'rbs_gallery_load_textdomain' );
function rbs_gallery_load_textdomain() {
  load_plugin_textdomain( 'robo-gallery', false, dirname(plugin_basename( __FILE__ )) . '/languages' ); 
}


if(!function_exists('rbs_gallery_pro_check')){
	function rbs_gallery_pro_check(){
		$proPath 	= '';
		$key_dir  	= 'robogallerykey';
		$key_file 	= $key_dir.'.php';
		$proPath = ROBO_GALLERY_PATH.$key_file;
		if( file_exists($proPath) ) return $proPath;
		for($i=-1;$i<6;$i++){ 
			$proPath = WP_PLUGIN_DIR.'/'.$key_dir.($i!=-1?'-'.$i:'').'/'.$key_file;
			if ( file_exists($proPath) ) return $proPath;
		}
		return false;
	}
}

if( $keyResult=rbs_gallery_pro_check() ){
	define("ROBO_GALLERY_PRO", 1);
	define("ROBO_GALLERY_KEY_PATH", $keyResult );
	include_once( ROBO_GALLERY_KEY_PATH );
} else {
	define("ROBO_GALLERY_PRO", 0);
}

define("ROBO_GALLERY_INCLUDES_PATH", 	ROBO_GALLERY_PATH.'includes/');

define("ROBO_GALLERY_FRONTEND_PATH", 	ROBO_GALLERY_INCLUDES_PATH.'frontend/');
define("ROBO_GALLERY_FRONTEND_EXT_PATH",ROBO_GALLERY_FRONTEND_PATH.'extensions/');


define("ROBO_GALLERY_OPTIONS_PATH", 	ROBO_GALLERY_INCLUDES_PATH.'options/');
define("ROBO_GALLERY_EXTENSIONS_PATH", 	ROBO_GALLERY_INCLUDES_PATH.'extensions/');
define("ROBO_GALLERY_CMB_PATH", 		ROBO_GALLERY_PATH.'cmb2/');
define("ROBO_GALLERY_CMB_FILEDS_PATH", 	ROBO_GALLERY_CMB_PATH.'fields/');

define("ROBO_GALLERY_URL", 				plugin_dir_url( __FILE__ ));

define( "ROBO_GALLERY_TYPE_POST",  'robo_gallery_table');


if(!function_exists('rbs_gallery_include')){
	function rbs_gallery_include( $filesForInclude, $path = '' ){
		$filesArray = array();
		if(empty($filesForInclude)) return;
		
		if( !is_array($filesForInclude) ) $filesArray[] = $filesForInclude;
			else $filesArray = $filesForInclude;

		for ($i=0; $i < count($filesArray); $i++) { 
			$item = $filesArray[$i];
			if( file_exists($path.$item) ) require_once $path.$item;
		}
	}
}

function activateRoboGallery() {
	require_once ROBO_GALLERY_INCLUDES_PATH.'rbs_class_activator.php';
	Robo_Gallery_Activator::activate();
}
register_activation_hook( __FILE__, 'activateRoboGallery' );


function deactivateRoboGallery() {
	require_once ROBO_GALLERY_INCLUDES_PATH.'rbs_class_activator.php';
	Robo_Gallery_Activator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivateRoboGallery' );


if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'rbs_gallery_init.php') )  
		require_once ROBO_GALLERY_INCLUDES_PATH.'rbs_gallery_init.php';

/* version 3 */
define("ROBO_GALLERY_APP_PATH", 	ROBO_GALLERY_PATH.'app/');
require_once ROBO_GALLERY_APP_PATH.'app.php';