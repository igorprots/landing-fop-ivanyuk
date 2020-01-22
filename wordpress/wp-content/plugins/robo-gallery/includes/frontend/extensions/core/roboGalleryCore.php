<?php
/*
*      Robo Gallery     
*      Version: 2.6.6
*      By Robosoft
*
*      Contact: https://robosoft.co/robogallery/ 
*      Created: 2017
*      Licensed under the GPLv2 license - http://opensource.org/licenses/gpl-2.0.php
*
*      Copyright (c) 2014-2019, Robosoft. All rights reserved.
*      Available only in  https://robosoft.co/robogallery/ 
*/


if ( ! defined( 'WPINC' ) )  die;
if ( ! defined( 'WPINC' ) ) exit;

require_once ROBO_GALLERY_FRONTEND_PATH.'roboGalleryAbstractExtension.php';
require_once ROBO_GALLERY_FRONTEND_EXT_PATH.'loader/RoboGalleryLoader.php';

class roboGalleryCore{

	public $galleryObj = null;
	protected $htmlCode = '';
	protected $cssCode = '';
	protected $extensions = array();

	public function __construct( roboGallery $galleryObj ){

		$this->galleryObj = $galleryObj;

		if($galleryObj==null) return false;  /* need214 error function */

		$this->init();
	}

	protected function init(){
		$this->addExtension( new RoboGalleryLoader($this) );
	}


	public function addHTML( $htmlCode, $position = 'after'){

		switch ($position) {
			case 'before':
				$this->htmlCode = $htmlCode . $this->htmlCode;
				break;

			case 'after':
			default:
				$this->htmlCode .= $htmlCode;
				break;
		}
		
	}


	public function addCSS( $cssCode, $position = 'after'){
		
		$cssCode = $this->minData($cssCode);

		switch ($position) {
			case 'before':
				$this->cssCode = $cssCode . $this->cssCode;
				break;

			case 'after':
			default:
				$this->cssCode .= $cssCode;
				break;
		}
		
	}

	private function minData( $value ){
		$value = str_replace( array("\n", "\r", "\t"), '', $value);

		$value = str_replace("  ", ' ', $value);
		$value = str_replace(" {", '{', $value);
		$value = str_replace("{ ", '{', $value);
		$value = str_replace(": ", ':', $value);
		$value = str_replace(", ", ',', $value);

		$value = str_replace("  ", ' ', $value);
		return $value;
	}

	public function getHTML(){
		return $this->htmlCode;
	}

	public function getCSS(){
		return $this->cssCode;
	}

	public function getIdPrefix(){
		return $this->galleryObj->galleryId;
	}

	public function addExtension(roboGalleryAbstractExtension $extension){
		$extensionName = $extension->getName();
		$this->extensions[ $extensionName ] = $extension;
	}

	public function getExtensions(){
		return $this->extensions;
	}

	public function getExtension($name){
		return isset($this->extensions[$name]) ? $this->extensions[$name] : null;
	}

}