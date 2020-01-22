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

if ( ! defined( 'WPINC' ) ) exit;


class  RoboGalleryLoader extends roboGalleryAbstractExtension{


	public function __construct( roboGalleryCore $galleryCore ){
		$this->name = 'loader';
		parent::__construct( $galleryCore );
	}

	protected function init(){
		$this->galleryCore->addHTML( $this->getHTML(), 'before' );
		$this->galleryCore->addCSS( $this->getCSS(), 'before' );
	}

	public function initJavaScript(){}

	public function getHTML(){
		return 
			'<div id="robo_gallery_loading_'.$this->idPrefix.'" class="'.$this->cssPrefix.'Spinner">'
				.'<div class="'.$this->cssPrefix.'Rect1"></div> '
				.'<div class="'.$this->cssPrefix.'Rect2"></div> '
				.'<div class="'.$this->cssPrefix.'Rect3"></div> '
				.'<div class="'.$this->cssPrefix.'Rect4"></div> '
				.'<div class="'.$this->cssPrefix.'Rect5"></div>'
			.'</div>';
	}
	

	public function getCSS(){
		$css = 		
			'.'.$this->cssPrefix.'Spinner{
				margin: 50px auto;
				width: 50px;
				height: 40px;
				text-align: center;
				font-size: 10px;
			}
			.'.$this->cssPrefix.'Spinner > div{
			  background-color: #333;
			  height: 100%;
			  width: 6px;
			  display: inline-block;
			  -webkit-animation: '.$this->cssPrefix.'-stretchdelay 1.2s infinite ease-in-out;
			  animation: '.$this->cssPrefix.'-stretchdelay 1.2s infinite ease-in-out;
			}
			.'.$this->cssPrefix.'Spinner .'.$this->cssPrefix.'Rect2 {
			  -webkit-animation-delay: -1.1s;
			  animation-delay: -1.1s;
			}
			.'.$this->cssPrefix.'Spinner .'.$this->cssPrefix.'Rect3 {
			  -webkit-animation-delay: -1.0s;
			  animation-delay: -1.0s;
			}
			.'.$this->cssPrefix.'Spinner .'.$this->cssPrefix.'Rect4 {
			  -webkit-animation-delay: -0.9s;
			  animation-delay: -0.9s;
			}
			.'.$this->cssPrefix.'Spinner .'.$this->cssPrefix.'Rect5 {
			  -webkit-animation-delay: -0.8s;
			  animation-delay: -0.8s;
			}
			@-webkit-keyframes '.$this->cssPrefix.'-stretchdelay {
			  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
			  20% { -webkit-transform: scaleY(1.0) }
			}
			@keyframes '.$this->cssPrefix.'-stretchdelay {
			  0%, 40%, 100% { 
			    transform: scaleY(0.4);
			    -webkit-transform: scaleY(0.4);
			  }  20% { 
			    transform: scaleY(1.0);
			    -webkit-transform: scaleY(1.0);
			  }
			}
		';
		return $css;
	}

}