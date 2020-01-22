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


abstract class roboGalleryAbstractExtension{

	protected $name = '';

	protected $galleryObj = null;

	public $galleryCore = null;

	public $cssPrefix = '';

	public $idPrefix = '';

	public function __construct( roboGalleryCore $galleryCore ){

		$this->galleryCore = $galleryCore;

		$this->cssPrefix = 'roboGallery'.ucfirst($this->name);
		$this->idPrefix = $this->galleryCore->getIdPrefix();

		$this->elements['html'] = '';
		$this->elements['css'] = '';
		$this->elements['js'] = '';

		/*
		$className = get_called_class();

		$settingsClassName = "{$className}Settings";

		if (class_exists($settingsClassName)) {
			$this->settings = new $settingsClassName($this);
		}

		if ($this->isEnabled()) {
			$this->init();
		}*/
		$this->init();
	}


	public function setGallery( $galleryObj ){
		return $this->galleryObj = $galleryObj;
	}

	public function setCore( roboGalleryCore $galleryCore ){
		if($galleryCore==null) return false;  /* need214 error function */
		return $this->galleryCore = $galleryCore;
	}

	protected function __clone(){}

	protected function init(){}

	public function getName(){
		return $this->name;
	}


/*	public function isEnabled(){
		return $this->settings->get('is_enabled');
	}

	public function getSettings(){
		return $this->settings;
	}*/

	public function getExtensionDir(){
		return 'extensions/' . $this->name . '/';
	}


}