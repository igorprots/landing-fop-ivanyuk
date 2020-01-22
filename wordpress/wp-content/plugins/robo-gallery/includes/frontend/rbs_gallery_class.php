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




require_once ROBO_GALLERY_FRONTEND_EXT_PATH.'core/roboGalleryCore.php';


class roboGallery extends roboGalleryUtils{

 	public $id = 0;
 	public $options_id = 0;
 	public $real_id = 0;

 	public $assetsTypeInclude = 'build';
 	public $isAjaxCall = false;

 	public $returnHtml = '';
 	public $options = array();
 	
 	public $rbsBoxStyle = '';
	public $rbsBoxHoverStyle = '';

	public $rbsOverlayStyle = '';

	public $rbsImageLoadingStyle = '';

	public $rbsLinkIconStyle = '';
	public $rbsLinkIconHoverStyle = '';

	public $rbsZoomIconStyle = '';
	public $rbsZoomIconHoverStyle = '';


	public $rbsTitleStyle = '';
	public $rbsTitleHoverStyle = '';

	public $rbsDescStyle = '';
	public $rbsDescHoverStyle = '';

	public $rbsLightboxStyle = '';
	public $rbsTextLightboxStyle = '';

	public $rbsTitleLightboxStyle = '';

	public $rbsCloseLightboxStyle = '';
	public $rbsArrowLightboxStyle = '';

	public $rbsMainDivStyle = '';

	public $rbsSearchStyle = '';
	public $rbsSearchInputStyle = '';
	public $rbsSearchInputPlaceholderStyle = '';


 	public $javaScript = '';
 	public $javaScriptStyle = '';

 	public $galleryId = '';
 	public $helper = '';

 	public $hover 		= 0;
 	public $linkIcon 	= '';
	public $zoomIcon 	= '';
	public $titleHover 	= '';
	public $descHover 	= '';
	public $templateHover = '';

 	public $selectImages = null;
 	
 	public $orderby = 'categoryD';
 	public $thumbsource = 'medium';

 	public $styleList = array();
 	public $scriptList = array();

 	public $thumbClick = 0;

 	public $touch = 0;
 	
 	public $debug = 0;

 	public $seoContent = '';

 	public $startTime =  0 ;
 	public $endTime =  0 ;

 	public $roboGalleryCore;

 	public $html = '';

 	public $defaultConfig = array();


 	function updateCountView(){
 		if(!$this->id) return ;
 		$count_key = 'gallery_views_count';
		$countView = (int) get_post_meta($this->id, $count_key, true);
		if( !$countView){
		    $countView = 0;
		    delete_post_meta($this->id, $count_key);
		    add_post_meta($this->id, $count_key, '0');
		}
		update_post_meta($this->id, $count_key, ++$countView);
 	}

 	function __construct($attr){

 		$this->startTime = microtime(true);

 		$this->helper 		= new roboGalleryHelper();
 		$this->galleryId 	= 'rbs_gallery_'.uniqid();

 		$this->assetsTypeInclude = get_option( ROBO_GALLERY_PREFIX.'jqueryVersion', 'build' ); 

 		if (defined('DOING_AJAX') && DOING_AJAX) {
			$this->isAjaxCall = true;
			$this->assetsTypeInclude = 'forced';
		}

 		if ( isset($_GET['action']) && $_GET['action'] == 'elementor' ) { // fix for elementor editor 
			$this->assetsTypeInclude = 'forced';
		}
 		
 		if( isset($attr) && isset($attr['id']) ){

			$this->id = $attr['id'];
			
			$options_id = (int) get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'options', true );
			if($options_id){
				$this->real_id = $this->id;
				$this->options_id = $options_id;
				$this->id = $options_id;
			}
			$this->helper->setId( $this->id );

			$this->roboGalleryCore = new roboGalleryCore( $this );
			

 		}

 		$this->debug = get_option( ROBO_GALLERY_PREFIX.'debugEnable', 0 );

 		$this->defaultConfig['border'] = array();
 		$this->defaultConfig['shadow'] = array();
 		$this->defaultConfig['grid'] = array();
 	}

 	function customCSS(){ 	return $this->customAssets('css'); 	}
 	function customJS(){ 	return $this->customAssets('js'); 	}

 	function customAssets( $type = 'css' ) {

 		$customFiles = get_option( ROBO_GALLERY_PREFIX.$type.'Files', '' );
 		if( $customFiles ){
 			if( strpos( $customFiles, ';')!==false ){
 				$customFiles = explode(';', $customFiles);
 			} else if(  strpos( $customFiles, "\n")!==false  ){
 				$customFiles = explode( "\n", $customFiles);
 			} else $customFiles = array( $customFiles );
 		}
 		if( !is_array($customFiles) || !count($customFiles)) $customFiles = array();
 		for ($i = 0; $i < count($customFiles); $i++){
 			$customFiles[$i] = 	site_url( trim( str_replace('\\', '/', $customFiles[$i]) ) );
 			//echo $customFiles[$i].'<br />';
 		}
 		return $customFiles;
 	}

 	function robo_gallery_styles() {

 		$customCssFiles = $this->customCSS();

 		if( $this->assetsTypeInclude =='forced' ){
 			$this->styleList[] = ROBO_GALLERY_URL.'css/gallery.css';
 			if(get_option( ROBO_GALLERY_PREFIX.'fontLoad', 'on' )=='on'){
 				$this->styleList[] = ROBO_GALLERY_URL.'css/gallery.font.css';
 			}
 			$this->styleList[] = $this->styleList + $customCssFiles;	
 		} else {
			wp_enqueue_style( 'robo-gallery-css', 	ROBO_GALLERY_URL.'css/gallery.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
			if(get_option( ROBO_GALLERY_PREFIX.'fontLoad', 'on' )=='on'){
				wp_enqueue_style( 'robo-gallery-font', 		ROBO_GALLERY_URL.'css/gallery.font.css', 	array(), ROBO_GALLERY_VERSION, 'all' );
			}
			for ($i = 0; $i < count($customCssFiles); $i++) {
 				wp_enqueue_style( 'robo-gallery-css-custom-file-'.$i, $customCssFiles[$i], array(), ROBO_GALLERY_VERSION, 'all' );
 			}
		}
	}

	function robo_gallery_scripts() { 

		if( $this->assetsTypeInclude == 'build' ){
			wp_enqueue_script('jquery', false, array(), false, true);
			wp_enqueue_script('robo-gallery', ROBO_GALLERY_URL.'js/robo_gallery.js', array('jquery'), ROBO_GALLERY_VERSION);
		} else if( $this->assetsTypeInclude == 'forced' ) {
			$this->scriptList[] = ROBO_GALLERY_URL.'js/robo_gallery_alt.js';
		} else {
			wp_enqueue_script('robo-gallery', ROBO_GALLERY_URL.'js/robo_gallery_alt.js', array(), ROBO_GALLERY_VERSION);
		}

		$customJsFiles = $this->customJS();
		if( $this->assetsTypeInclude =='forced' ) {
 			$this->scriptList = $this->scriptList + $customJsFiles; // it's correct  :-) trust me
		} else {
			for ($i = 0; $i < count($customJsFiles); $i++) {
 				wp_enqueue_script('robo-gallery-js-custom-file-'.$i, $customJsFiles[$i], array('robo-gallery'), ROBO_GALLERY_VERSION ); 			
 			}
		}
		
		if(	$this->debug){
			wp_enqueue_script( 'robo-gallery-debug',  			ROBO_GALLERY_URL.'includes/extensions/debug/js/script.js', 	array( ), 	ROBO_GALLERY_VERSION );
			wp_enqueue_style( 'robo-gallery-debug',				ROBO_GALLERY_URL.'includes/extensions/debug/css/debug.css', array(), 	ROBO_GALLERY_VERSION, 'all' );
		}
	
	}	

	/*
		$hover - 	0   - hover style
					1  	+ hover style
					2   - mainID
	*/
	public function addJavaScriptStyle($styleValue, $styleName = '', $hover='1'){
		if(isset($this->{$styleValue.'Style'}) && $this->{$styleValue.'Style'} ){
			$this->javaScriptStyle.= ($hover!=2?'#'.$this->galleryId.' ':'').$styleName.'{'.$this->{$styleValue.'Style'}.'}';
		}
		if( $hover==1 && isset($this->{$styleValue.'HoverStyle'}) && $this->{$styleValue.'HoverStyle'} ){
			$this->javaScriptStyle.= '#'.$this->galleryId.' '.$styleName.':hover{'.$this->{$styleValue.'HoverStyle'}.'}';
		}
	}

 	
 	public function addBorder($nameOptions = ''){
 		$borderStyle = '';
 		$border = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.$nameOptions, true );
		if( isset($border['width'])){
			$borderStyle.= (int) $border['width'].'px ';
			if($nameOptions=='border-options'){
				$this->helper->setValue( 'borderSize',  (int) $border['width'] );
			}
		}
		if( isset($border['style'])) $borderStyle.=  $border['style'].' ';
		if( isset($border['color'])) $borderStyle.=  $border['color'].' ';
		if( $borderStyle ) return 'border: '.$borderStyle.';';
			else return '';
 	}


 	public function getGallery( ){
 		if( !$this->id ) return ''; 

 		$cache = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'cache', true );

 		if($cache){
 			$cacheId = $this->real_id ? $this->real_id : $this->id ;
 			$cached_result =  get_transient( 'robo_gallery_cached_id'. $cacheId ); 
 		}

 		//$cached_result = '';

 		if( $this->assetsTypeInclude == 'forced' ){
			$this->robo_gallery_styles();
			$this->robo_gallery_scripts();
		} else {
			add_action( 'get_footer', array($this, 'robo_gallery_styles') );
			add_action( 'get_footer', array($this, 'robo_gallery_scripts') );
		}

		$this->updateCountView();


 		if( $cache && $cached_result ){

 			$debugText = '';

 			if($this->debug){
 				$this->endTime = microtime(true);
				$execution_time = ($this->endTime - $this->startTime);
				$debugText =  '<b>Total Execution Time (cache) </b> '.$execution_time;	
 			}

 			return $debugText.$cached_result;
 		}

 		$this->helper->setValue( 'filterContainer',  	'#'.$this->galleryId.'filter', 'string' );
 		$this->helper->setValue( 'loadingContainer',  	'#robo_gallery_loading_'.$this->galleryId, 'string' );
 		$this->helper->setValue( 'mainContainer',  		'#robo_gallery_main_block_'.$this->galleryId, 'string' );

		
		$sizeType 	= get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'sizeType', true );

		$this->touch 	= get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxSwipe', true );
		if($this->touch){
			$this->helper->setValue( 'touch',  1, 'raw' );
			$this->helper->setValue( 'touchDirection',   get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxSwipeDirection', true ) );
		}

		$lightboxCounterText = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxCounterText', true );

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxCounter', true )){
			$lightboxCounterText="";
		} else {
			$lightboxCounterText = '%curr% '.esc_attr($lightboxCounterText).' %total%';
		}
	
		$this->helper->setValue( 'lightboxOptions',  '{ gallery: { enabled: true, tCounter: "'.$lightboxCounterText.'" } }', 'raw' );	

		$width = 240;  $height = 140;

		$size 		= get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'thumb-size-options', true );
		
		if( !is_array($size) ) $size = array();

		if( count($size) ){
			if( isset($size['width'])  ) 	$width = (int) 	$size['width']; 	else $width = 240;
			if( isset($size['height']) ) 	$height = (int) $size['height']; 	else $height = 140;
		}

		if($this->pro){
			$this->getOrderBy($size);
			$this->getSource($size);
		} else {
			$this->getSourceBase($size);
		}
		
		if($this->pro){ 
			$this->setColumns();
		} else {
			$colums = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'colums', true );
			if( $colums && count($colums)){
				$columns = $this->addWidth($colums, 3);
				if( $columns ){
					$columns .= ', {"columnWidth": "auto" , "columns":2 , "maxWidth": 650}, {"columnWidth": "auto" , "columns":3 , "maxWidth": 960}';
					$this->helper->setValue( 'resolutions',  '[ '.$columns .']', 'raw' );
				}
			}
		}

		if(get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxMobile', true )){
			$this->helper->setValue( 'lightboxOptions',  '{ image: { verticalFit: true }, mainClass: "my-mfp-slide-bottom mfp-img-mobile" }', 'raw' );
		}
		
		if(get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxSourceButton', true )){
			$this->helper->setValue( 'hideSourceImage',  'true', 'raw' );
		}	

		$radius = (int) get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'radius', true );
		$this->rbsBoxStyle .= ' -webkit-border-radius: '.$radius.'px; -moz-border-radius: '.$radius.'px; border-radius: '.$radius.'px;';

		if( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'border', true ) ){
			$this->rbsBoxStyle .= $this->addBorder('border-options');

			if( $this->pro && get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'hover-border', true ) ){
				$this->rbsBoxHoverStyle .= $this->getHoverBorder();
			}
		}

		if( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'shadow', true ) ){
			$this->rbsBoxStyle .=$this->addShadow('shadow-options');
			
			if ( $this->pro && get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'hover-shadow', true ) ){
				$this->rbsBoxHoverStyle .= $this->getHoverShadown();
			}
		}

		$this->thumbClick = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'thumbClick', true );

		
		if($this->options_id){
			$this->id = $this->real_id;
		}
		$this->selectImages = new roboGalleryImages($this->id, $this->options_id);
		if($this->options_id){
			$this->id = $this->options_id;
		}

		$this->selectImages->setSize( $width , $height, $this->thumbsource, $this->orderby );

		if ( $this->pro ) $this->setCCL();

		$this->selectImages->getImages();


		$this->helper->setOption( 'overlayEffect', 'string');
		$this->helper->setOption( 'boxesToLoadStart', 'int');
		$this->helper->setOption( 'boxesToLoad', 'int');
		$this->helper->setOption( 'lazyLoad', 'bool');
		$this->helper->setOption( 'waitUntilThumbLoads', 'bool');
		$this->helper->setOption( 'waitForAllThumbsNoMatterWhat', 'bool');
		$this->helper->setOption( 'deepLinking', 'bool');
		$this->helper->setOption( 'LoadingWord', 'string');
		$this->helper->setOption( 'loadMoreWord', 'string');

		$loadingBgColor = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'loadingBgColor', true );
		if($loadingBgColor) $this->rbsImageLoadingStyle .=  'background-color: '.$loadingBgColor.';';

		$this->helper->setValue( 'loadMoreClass',  $this->getButtonStyle('button') );

		$this->helper->setOption( 'noMoreEntriesWord', 'string');

		$this->helper->setOption( 'horizontalSpaceBetweenBoxes', 'int');
		$this->helper->setOption( 'verticalSpaceBetweenBoxes', 'int');	

		if ( $this->pro ) $this->rbsOverlayStyle .= $this->getOverlayBg();
			else $this->rbsOverlayStyle .= 'background: rgba(7, 7, 7, 0.5);';

		$polaroidOn = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidOn', true );
		if($polaroidOn){
			$polaroidBackground = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidBackground', true );
			$polaroidAlign = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidAlign', true );
			$polaroidStyle = 'text-align:'.$polaroidAlign.'; background: '.$polaroidBackground.';';
		}
		
		$menu = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menu', true );

		$polaroid_template = '';
		$polaroidSource = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'polaroidSource', true );
		switch ($polaroidSource) {
			case 'desc':
					$polaroid_template = '@DESC@';
				break;
			case 'caption':
					$polaroid_template = '@CAPTION@';
				break;
			case 'title':
			default:
					$polaroid_template = '@TITLE@';
				break;
		}

		$hover_template = '';
		$desc_template = '';

		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'hover', true ) ){
			$this->hover = 1;
			if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'noHoverOnMobile', true ) ){
				$this->helper->setValue( 'noHoverOnMobile',  'false' );
			}
		}
		
		if ( $this->pro ) $this->setHoverType();

		$this->linkIcon 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'linkIcon', true ), 'rbsLinkIcon', 1 );
		$this->zoomIcon 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'zoomIcon', true ), 'rbsZoomIcon', 1 , ($this->thumbClick?' rbs-lightbox':'') ); //, ' rbs-lightbox'
		$this->titleHover 	= $this->getTemplateItem( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'showTitle', true ), 'rbsTitle', '@TITLE@' );
		
		if ( $this->pro ) 	$this->setDescHover();

		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocial', true ) ){
			if(get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocialFacebook', true ) ) 
					$this->helper->setValue( 'facebook',  	'true', 'raw' );
			
			if(get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocialTwitter', true ) ) 
				$this->helper->setValue( 'twitter',  	'true', 'raw' );
			
			if(get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocialGoogleplus', true ) ) 
				$this->helper->setValue( 'googleplus',  'true', 'raw' );
			
			if(get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocialPinterest', true ) ) 
				$this->helper->setValue( 'pinterest',  	'true', 'raw' );
			
			if(get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'lightboxSocialVK', true ) ) 
				$this->helper->setValue( 'vk',  	'true', 'raw' );
		}

		if ( $this->pro && method_exists( $this ,'setLightboxBg') ){
			$this->setLightboxBg();
		}
		

		$lightboxColor = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxColor', true );
		if($lightboxColor) $this->rbsTextLightboxStyle .=  'color: '.$lightboxColor.';';

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxTitle', true )){
			$this->helper->setValue( 'hideTitle',  'true' );
		} 
			

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxClose', true )){
			$this->rbsCloseLightboxStyle = 'display:none;';
			$this->addJavaScriptStyle('rbsCloseLightbox','.mfp-container .mfp-close',2);
		}

		if(!get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxArrow', true )){
			$this->rbsArrowLightboxStyle = 'display:none;';
			$this->addJavaScriptStyle('rbsArrowLightbox','.mfp-container .mfp-arrow',2);
		}

		
		if(get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxDescPanel', true )){
			$this->helper->setValue( 'descBox',  'true' );
			$this->helper->setValue( 'descBoxClass',  'rbs_desc_panel_'.get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxDescClass', true ) );
		}
		
		
		$this->addJavaScriptStyle('rbsBox', '.rbs-img-container');
		$this->addJavaScriptStyle('rbsTitle','.rbsTitle',1);
		$this->addJavaScriptStyle('rbsDesc','.rbsDesc',1);
		$this->addJavaScriptStyle('rbsOverlay','.thumbnail-overlay',0);
		$this->addJavaScriptStyle('rbsLinkIcon','.rbsLinkIcon',1);
		$this->addJavaScriptStyle('rbsZoomIcon','.rbsZoomIcon',1);
		$this->addJavaScriptStyle('rbsImageLoading','.image-with-dimensions',0);

		//$this->addJavaScriptStyle('rbsTitleLightbox','body .mfp-title',2);
		$this->addJavaScriptStyle('rbsTextLightbox','body .mfp-title, body .mfp-counter',2);

		$widthSize 		= get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'width-size', true );
		$widthSizeValue = '';
		if( is_array($widthSize) && count($widthSize) ){
			if( isset($widthSize['width'])  ){
				$widthSizeValue = (int) $widthSize['width'];
				if($widthSizeValue){
					if( isset($widthSize['widthType']) && $widthSize['widthType'] ) $widthSizeValue .= 'px';
						else $widthSizeValue .= '%';
				}
			} 	 
		}
		if(!$widthSizeValue) $widthSizeValue = '100%;';

		$this->rbsMainDivStyle = 'width:'.$widthSizeValue.';';

		switch( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'align', true ) ){
			case 'left':  	$this->rbsMainDivStyle .= 'float: left;'; 	break;
			case 'right':  	$this->rbsMainDivStyle .= 'float: right;'; 	break;
			case 'center':  $this->rbsMainDivStyle .= 'margin: 0 auto;'; break;
			case '': default: 
		}

		$paddingCustom = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'paddingCustom', true );
		if( isset($paddingCustom['left']) 	&& $paddingCustom['left'] ) 	$this->rbsMainDivStyle .= 'padding-left:'.	$this->getCorrectSize($paddingCustom['left']).';';
		if( isset($paddingCustom['top']) 	&& $paddingCustom['top'] ) 		$this->rbsMainDivStyle .= 'padding-top:'.	$this->getCorrectSize($paddingCustom['top']).';';
		if( isset($paddingCustom['right']) 	&& $paddingCustom['right'] ) 	$this->rbsMainDivStyle .= 'padding-right:'.	$this->getCorrectSize($paddingCustom['right']).';';
		if( isset($paddingCustom['bottom']) && $paddingCustom['bottom'] ) 	$this->rbsMainDivStyle .= 'padding-bottom:'.$this->getCorrectSize($paddingCustom['bottom']).';';

		$pretext = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'pretext', true );
		$aftertext = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'aftertext', true );

		$customCss = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'cssStyle', true );



		if(count($this->selectImages->imgArray)){

			

			for ($i=0; $i<count($this->selectImages->imgArray); $i++) {
				
				if(!isset($this->selectImages->imgArray[$i]) || !is_array($this->selectImages->imgArray[$i]) ) continue ;

				$img = $this->selectImages->imgArray[$i];

				$descBoxData=''; 

				if( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxDescPanel', true ) && isset($img['data'])){

					switch(get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxDescSource', true )){
						case 'caption': 
							$descBoxData = $img['data']->post_excerpt;
							break;

						case 'desc': 
							$descBoxData = $img['data']->post_content;
							break;

						default:
						case 'title':
							$descBoxData = $img['data']->post_title;
							break;
					}

					if($descBoxData) $descBoxData = ' data-descbox="'.esc_attr($descBoxData).'" ';
				}

				if( isset($img['data']) && isset($img['link'])  ){
					$polaroidDesc =  str_replace( 
						array('@TITLE@','@CAPTION@','@DESC@', '@LINK@'), 
						array( 
							$img['data']->post_title,
							$img['data']->post_excerpt,
							$img['data']->post_content,
							$img['link']
						), 
						$polaroid_template
					);
				} else {
					$polaroidDesc = '';
				}
				if( isset( $img['image'] ) ){
					$link = $img['image'];
				} else $link = '';

				if( $img['link'] && ( !$this->hover || ( $this->hover == 1 && !$this->linkIcon && !$this->zoomIcon  ) )  ){
					$link = $img['link'].'" data-type="'.($img['typelink']?'blank':'').'link';
				} elseif( $img['videolink'] ) {
					$link = $img['videolink'].'" data-type="iframe';
				}

				$lightboxAlt = esc_attr($img['alt']);


				$lightboxText = '';

				switch ( get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'lightboxSource', true ) ) {
					case 'title':
							$lightboxText = $img['data']->post_title;
						break;
					case 'desc':
							$lightboxText = $img['data']->post_content;
						break;
					case 'caption':
							$lightboxText = $img['data']->post_excerpt;
						break;
				}

				$lightboxCaption = '';
				
				$newLine=''; $lineBrake='';
				if($this->debug){ $newLine = "\t"; $lineBrake="\n"; }

				$lightboxText = esc_attr($lightboxText);
				
				if(!$lightboxAlt)  $lightboxAlt = $lightboxText;

				$seo = get_option( ROBO_GALLERY_PREFIX.'seo', '' );
				if( $seo ){
					$this->seoContent .= 	($seo==1 ? '<a href="'.$link.'" alt="'.$lightboxText.'" title="'.$lightboxText.'">' : '')
												.'<img src="'.$img['thumb'].'" title="'.$lightboxText.'" alt="'.$lightboxText.'" >'
											.($seo==1 ? '</a>' : '' );
				}
				
				$tagId = '';
				for ($l=0; $l < count($img['tags']); $l++) { 
					$tagId .= ' tag_id'.array_search($img['tags'][$l], $this->selectImages->tags ).' ';
				}

				$this->returnHtml .= 
					'<div class="rbs-img category'.$img['catid'].' '.$tagId.'" '.( isset($img['col']) && $img['col'] ?' data-columns="'.$img['col'].'" ' :'').'>'.$lineBrake.$newLine
			            .'<div class="rbs-img-image '.(!$this->thumbClick?' rbs-lightbox':'').'" '.$descBoxData.' '.( isset($img['effect']) && $img['effect'] ?' data-overlay-effect="'.$img['effect'].'" ' :'').' >'.$lineBrake.$newLine.$newLine
			                .'<div data-thumbnail="'.$img['thumb'].'" title="'.$lightboxText.'" data-width="'.( $sizeType ? $width : $img['sizeW'] ).'" data-height="'.($sizeType?$height:$img['sizeH']).'" ></div>'.$lineBrake.$newLine.$newLine
							.'<div data-popup="'.$link.'" data-alt="'.$lightboxAlt.'" title="'.$lightboxText.'" '.($lightboxCaption?'data-caption="'.$lightboxCaption.'"':'').'></div>'.$lineBrake.$newLine.$newLine
							.$this->getHover($img).$lineBrake.$newLine
			            .'</div>'.$lineBrake.$newLine
						.($polaroidDesc && $polaroidOn?'<div class="rbs-img-content" '.($polaroidStyle?' style="'.$polaroidStyle.'" ':'').'>'.$polaroidDesc.'</div>':'').$lineBrake
			        .'</div>'.$lineBrake;
			}
		} 

		if($this->seoContent){
			$this->seoContent = '<div style="display:none;">'.$this->seoContent.'</div>';
		}
		if( $this->returnHtml ){
			$this->returnHtml = 
				'<style type="text/css" scoped>'.$this->roboGalleryCore->getCSS().$customCss.'</style>'
				.$this->runEvent('html', 'before')		
				.$this->roboGalleryCore->getHTML()
				.'<div id="robo_gallery_main_block_'.$this->galleryId.'" class="robogallery-gallery-'.($this->real_id ? $this->real_id : $this->id).'" style="'.$this->rbsMainDivStyle.'  display: none;">'
					.($pretext?'<div>'.$pretext.'</div>':'')
					.($menu?$this->getMenu():'').
					'<div id="'.$this->galleryId.'" data-options="'.$this->galleryId.'" style="width:100%;" class="robo_gallery">'
						. $this->returnHtml
					.'</div>'
					.($aftertext?'<div>'.$aftertext.'</div>':'')
				.'</div>'
				.$this->seoContent
				//.$this->getErrorDialog()
				.$this->runEvent('html', 'after')	
				.'<script>'
					.$this->compileJavaScript()
					//.$this->getCheckJsFunction()
				.'</script>';

				if( count($this->scriptList) ){ //&& !defined('ROBO_GALLERY_JS_FILES')
					//define( 'ROBO_GALLERY_JS_FILES', 1);

					for($i=0;$i<count($this->scriptList);$i++){
						$this->returnHtml .= ' <script type="text/javascript" src="'.$this->scriptList[$i].'"></script>';
					}
				}
				if(count($this->styleList)){
					for($i=0;$i<count($this->styleList);$i++){
						$this->returnHtml .= '<link rel="stylesheet" type="text/css" href="'.$this->styleList[$i].'">';
					}
				}
		}  else {
			$checkOptionsSet = $this->options_id ? $this->options_id : $this->id;

			$this->returnHtml = sprintf( 
				'<p><strong>%s</strong><br/>%s<br /><strong>%s</strong></p>',
				__('No Images.', 'robo-gallery'),
				__('Please upload images in images manager section. Click on Manage Images button on the right side of the gallery settings.', 'robo-gallery'),
				get_post_meta( $checkOptionsSet, ROBO_GALLERY_PREFIX.'menuSelfImages', true ) ? 
					'' : 
					__("Please make sure that you didn't enabled option: Images of the Current Gallery. Option should have Show value to show images.", 'robo-gallery')
			);

			return $this->returnHtml;
		}
		
		$debugText = '';

		if( $cache ){
			
			$option_cache = (int) get_option(ROBO_GALLERY_PREFIX.'cache', '12');
			if(!$option_cache) $option_cache = 12;

			set_transient( 'robo_gallery_cached_id'.$cacheId , $this->returnHtml, $option_cache * HOUR_IN_SECONDS );

			if($this->debug){
				$this->endTime = microtime(true);
				$execution_time = ($this->endTime - $this->startTime);
				$debugText =  '<b>Total Execution Time:</b> '.$execution_time;	
			}
		}
		
		return $debugText.$this->returnHtml;
 	}

 	function runEvent( $element, $event ){

 		//return $this->roboGalleryCore->runEvent( $element, $event, $this );

 		/*add_filter( 'robo_gallery_frontend_', 'prefix_time_ago' );

 		do_action( 'robo_gallery_frontend_'.$element.'_'.$event );
*/
 		/*$eventResult = apply_filters(
		    'robo_gallery_frontend_'.$element.'_'.$event,
		    '',
		    array(
		    	'id' => $this->id
		    )
		);
		
		print_r($eventResult);

		return $eventResult;*/
 		/*add_action('prefix_after_settings_page_html',  array($this, 'doEvent'));
 		add_action('prefix_after_settings_page_html', 'myprefix_add_settings');*/
 	}

 /*	function doEvent( 'element', 'event', 'order' ){
 		add_action('prefix_after_settings_page_html',  array($this, 'doEvent'));
 	}*/

 	function getHover( $img ){
			$hoverHTML = '';
			if(!$this->hover) return $hoverHTML;
			if($this->hover == 1){
				$hoverHTML .= $this->titleHover;
				if( $this->linkIcon || $this->zoomIcon ){
					$hoverHTML .= '<div class="rbsIcons">';
					if($this->linkIcon && $img['link']) $hoverHTML .= '<a href="@LINK@" '.($img['typelink']?'target="_blank"':'').' title="@TITLE@">'.$this->linkIcon.'</a>';
					if($this->zoomIcon) $hoverHTML .= $this->zoomIcon;
					$hoverHTML .= '</div>';
				}
				$hoverHTML .= $this->descHover;
			}

			/* robo_gallery check in class */
			if($this->templateHover) $hoverHTML = $this->templateHover; 

			if($hoverHTML){				
				$hoverHTML =  str_replace( 
					array('@TITLE@','@CAPTION@','@DESC@', '@LINK@', '@VIDEOLINK@'), 
					array( 
						$img['data']->post_title,
						$img['data']->post_excerpt,
						$img['data']->post_content,
						$img['link'],
						$img['videolink'],
					), 
					$hoverHTML
				);
			}
			$hoverHTML = '<div class="thumbnail-overlay">'.$hoverHTML.'</div>'; //.( !$this->zoomIcon ?'rbs-lightbox':'')
			return $hoverHTML;
		}

 	function getMenu(){
 		$retHtml = '';
 		$align = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'buttonAlign', true );
 		if($align) $align = ' rbs_gallery_align_'.$align;
 		$retHtml .= '<div class="rbs_gallery_button'.$align.'"  id="'.$this->galleryId.'filter">';
 		
 		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'searchEnable', true ) ){

 			/* Get color search input box */
 			$searchColor = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'searchColor', true );
 			if($searchColor){
 				$this->rbsSearchStyle = ' color:'.$searchColor.';';
 				$this->rbsSearchInputStyle = 'border-color:'.$searchColor.'; color:'.$searchColor.';';
 				$this->rbsSearchInputPlaceholderStyle = 'color:'.$searchColor.';';
 			}

 			$cssPatch = '#'.$this->galleryId.'filter .rbs_search_wrap';
			$this->addJavaScriptStyle('rbsSearch', $cssPatch,2);
			$this->addJavaScriptStyle('rbsSearchInputPlaceholder', $cssPatch.' input.rbs-search::placeholder',2);

			$this->addJavaScriptStyle('rbsSearchInput', $cssPatch.' input.rbs-search',2);

			/* Search gallery item block */
 			$retHtml .= '<div class="rbs_search_wrap"  >';
 				$searchLabel = get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'searchLabel', true );
	 			$retHtml .= '<input type="text" class="rbs-search" placeholder="'.$searchLabel.'" />';
 			$retHtml .= '</div>';

 			/* Setup  gallery */
 			$this->helper->setValue( 'search',  '#'.$this->galleryId.'filter .rbs-search' );
 			$this->helper->setValue( 'searchTarget',  '.rbs-img-image' );
 		}

 		$paddingLeft = (int)get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'paddingLeft', true );
 		$paddingBottom = (int)get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'paddingBottom', true );
 		$style = '';
 		$style .= 'margin-right:'.$paddingLeft.'px;';
 		$style .= 'margin-bottom:'.$paddingBottom.'px;';
 		
 		$class = $this->getButtonStyle('button');

		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menuRoot', true ) ){
			$retHtml .= '<a class="button '.$class.' active" '.($style?'style="'.$style.'"':'').' href="#" data-filter="*">'.get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menuRootLabel', true ).'</a>';
		}

 		if( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.'menuTag', true ) && $this->pro && method_exists( $this ,'getTagsMenu') ){
 			$retHtml .= $this->getTagsMenu($class, $style);
 		} else {
 			for ($i=0; $i < count($this->selectImages->catArray); $i++) { 
	 			$category = $this->selectImages->catArray[$i];
	 			$retHtml .= '<a href="#" '
	 								.' data-filter=".category'.$category['id'].'"'
	 								.' class="button '.$class.'"'
	 								.' '.($style?'style="'.$style.'"':'')
	 							.'>'
	 								.esc_attr($category['title'])
	 							.'</a>';
	 		}	
 		}
 		
 		$retHtml .= '</div>';
 		return $retHtml;
 	}

 	function getButtonStyle($optionName){
 		$class = '';

 		if ( $this->pro ){
 			$class .= $this->getMenuButton($optionName);
 		} else {
			$class .= $this->getMenuButtonBase($optionName);
 		}

 		switch ( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.$optionName.'Type', true ) ) {
 			case 'rounded': $class .= 'button-rounded ';break;
 			case 'pill': 	$class .= 'button-pill '; 	break;
 			case 'circle': 	$class .= 'button-circle '; break;
 			case 'normal': default: 					break;
 		}

 		switch ( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.$optionName.'Size', true ) ) {
 			case 'jumbo': 	$class .= 'button-jumbo '; 	break;
 			case 'large': 	$class .= 'button-large '; 	break;
 			case 'small': 	$class .= 'button-small '; 	break;
 			case 'tiny': 	$class .= 'button-tiny '; 		break;
 			case 'normal': default: 					break;
 		}
 		
 		return $class;
 	}

 	public function	getMenuButtonBase($optionName){
			$class = '';
			switch ( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.$optionName.'Fill', true ) ) {
	 			case 'flat': 	$class .= 'button-flat';	break;
	 			case '3d': 		$class .= 'button-3d'; 		break;
	 			case 'border': 	$class .= 'button-border'; 	break;
	 			case 'normal': default: $class .= 'button'; break;
	 		}

	 		switch ( get_post_meta( $this->id,  ROBO_GALLERY_PREFIX.$optionName.'Color', true ) ) {
	 			case 'red': 	$class .= '-caution '; 	break;
	 			case 'blue': 
	 			default: 		$class .= '-primary '; 	break;
	 		}
	 		return $class;
		}

 	public function getCheckJsFunction(){
 		$jsFunction = '';
 		$jsFunction .= ' 
 			var prefix = window.addEventListener ? "" : "on";
			var eventName = window.addEventListener ? "addEventListener" : "attachEvent";
			window[eventName](prefix + "load", function(event){
				var jObject = window.rbjQuer || window.jQuery ;
				if( (typeof jObject == "undefined") || (jObject == null) || (typeof jObject.fn.collagePlus == "undefined") || (jObject.fn.collagePlus == null) ){
					console.log(" Robo Gallery :: error loading js file ");
					var roboGalleryObj = document.getElementById("robo_gallery_main_block_'.$this->galleryId.'");
					var roboErrorObj = document.getElementById("robo_gallery_error_message_'.$this->galleryId.'");
					roboGalleryObj.parentNode.insertBefore( roboErrorObj, roboGalleryObj);
					roboErrorObj.style.display =  "block";
				}
			}, false);';
 		return $jsFunction;
 	}

 	function getErrorDialog(){
 		$htmlReturn = '';
 		$htmlReturn .= '<div id="robo_gallery_error_message_'.$this->galleryId.'" style="display: none; ">';
 			$htmlReturn .= '<strong>'.__('Robo Gallery :: Loading problems [error 768]', 'robo-gallery').'</strong><br/>'
				.__('Looks like you have some loading problems or conflict of Robo Gallery with some other plugins or theme.', 'robo-gallery')
			  	.__('Please open Settings section on the right side admin menu and use Compatibility Settings / jQuery option. ', 'robo-gallery')
			  	.__('Try to switch jQuery option value to Forced include, save settings try to reload page. ', 'robo-gallery')
			  	.__('If it\'s not gonna help please try Alternative option. User Guide: [ <a href="https://robosoft.co/knowledgebase/2017/11/07/loading-problems-or-conflicts/" target="_blank">Fix conflict solution</a> ] ','robo-gallery')
			 	.'<br/>'
			 	.__('If it\'s not gonna help please <a href="https://robosoft.co/new-ticket" target="_blank">contact our support team</a> and we help you to find solution.', 'robo-gallery');
		$htmlReturn .= '</div>';
		return $htmlReturn;
 	}


 	public function getSourceBase($size){
		if( count($size) && isset($size['source']) && $size['source'] ) 
			$this->thumbsource = $size['source'];
	}
 } 