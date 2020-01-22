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

class roboGalleryImages{
	public $id 			= 0;
	public $cloneId 	= 0;
	public $imgArray	= array();
	public $catArray	= array();
	public $tags		= array();

	public $width 		= 0;
	public $height		= 0;
	public $thumbsource = '';
	public $orderby 	= '';
	public $lazyLoad 	= 1;


	function __construct($id, $cloneId = 0){
 		if( isset($id) && (int) $id ){
			$this->id = (int) $id;
 		}
 		
 		if( isset($cloneId) && (int) $cloneId ){
			$this->cloneId = (int) $cloneId;
 		} else $this->cloneId = $this->id;

 		++$this->lazyLoad;
 	}

 	function setSize( $width , $height, $thumbsource, $orderby ){
 		$this->width 		= $width;
 		$this->height 		= $height;
 		$this->thumbsource 	= $thumbsource;
 		$this->orderby 		= $orderby;
 	}

 	function getImages(){
 		if(!$this->id) return false;
 		++$this->lazyLoad;
		$tempImages = get_post_meta( $this->id, ROBO_GALLERY_PREFIX.'galleryImages', true );

		if( isset($tempImages) && !is_array($tempImages)==1 && trim($tempImages)=='' ) $tempImages = array();
		
		if( isset($tempImages) && is_array($tempImages) && isset($tempImages[0]) && count($tempImages)==1 && trim($tempImages[0])=='' ) $tempImages = array();
		
		if( !get_post_meta( $this->cloneId, ROBO_GALLERY_PREFIX.'menuSelfImages', true ) ){
			$tempImages = array();
		}

		for ($i=0; $i < count($tempImages) ; $i++){
			$this->imgArray[] = array( 'id'=> $tempImages[$i], 'catid'=> $this->id );
		}

		$post = get_post($this->id);

		if( get_post_meta( $this->cloneId, ROBO_GALLERY_PREFIX.'menuSelf', true ) ){
			$this->catArray[] = array( 'id'=>$this->id, 'title'=> $post->post_title, 'name'=>$post->post_name);
		}

		$my_wp_query = new WP_Query();
 		$all_wp_pages = $my_wp_query->query(array(
 				'post_type' => ROBO_GALLERY_TYPE_POST,
 				'orderby'   => array( 'menu_order'=> 'DESC', 'order'=> 'ASC', 'title'=> 'DESC' ),
 				'posts_per_page' => $this->lazyLoad,
 		));

 		//print_r($all_wp_pages);
		$children = get_page_children( $this->id, $all_wp_pages );
		//print_r($children);
		$tempCatArray  = array();
		for($i=0;$i<count($children);$i++){
			$tempImages = get_post_meta( $children[$i]->ID, ROBO_GALLERY_PREFIX.'galleryImages', true );
			if($tempImages && count($tempImages)){
				$post = get_post($children[$i]->ID); 
				$tempCatArray[] = array( 'id'=>$children[$i]->ID,'title'=> $post->post_title, 'name'=>$post->post_name);
				for ($j=0; $j < count($tempImages) ; $j++){
					$this->imgArray[] = array( 'id'=> $tempImages[$j], 'catid'=> $children[$i]->ID );
				}
			}
		}
		$tempCatArray = array_reverse ($tempCatArray);
		$this->catArray = array_merge($this->catArray, $tempCatArray );

		$this->initImagesData();
		$this->initImagesOrder();

 	}


 	private function initImagesOrder( ){
 		switch ( $this->orderby ) {
			case 'random':		shuffle ($this->imgArray);										break;
			case 'titleU':		usort($this->imgArray,array('roboGalleryImages','titleUp') );	break;
			case 'titleD':		usort($this->imgArray,array('roboGalleryImages','titleDown') );	break;
			case 'dateU':		usort($this->imgArray,array('roboGalleryImages','dateUp') );	break;
			case 'dateD':		usort($this->imgArray,array('roboGalleryImages','dateDown') );	break;
			case 'categoryU':	$this->imgArray = array_reverse($this->imgArray);				break;
			case 'categoryD':
			default:
				break;
		}
 	}


 	private function initImagesData( ){

 		if( !is_array($this->imgArray) ||  count($this->imgArray) == 0  ){
 			$this->imgArray = array();
 			return;
 		}

 		foreach( $this->imgArray as $imgKey => $img) {
			$imgId = $img['id'];

			$thumb =  wp_get_attachment_image_src( $imgId , $this->thumbsource);

			if( !is_array($thumb) || count($thumb) < 1 ){
				unset($this->imgArray[$imgKey]);	
			} else {
				$this->imgArray[$imgKey]['image'] 	= 	wp_get_attachment_url( $imgId );
				$this->imgArray[$imgKey]['thumb'] 	=	( isset($thumb[0]) ) ? $thumb[0] : '';
				$this->imgArray[$imgKey]['sizeW']  	=	( isset($thumb[1]) ) ? $thumb[1] : $this->width; //*($i%2 ? 1.5: 1)
				$this->imgArray[$imgKey]['sizeH']  	= 	( isset($thumb[2]) ) ? $thumb[2] : $this->height;
				$this->imgArray[$imgKey]['data'] 	=	get_post( $imgId );
				$this->imgArray[$imgKey]['link'] 	=	get_post_meta( $imgId, ROBO_GALLERY_PREFIX.'gallery_link', true );
				$this->imgArray[$imgKey]['typelink'] = 	get_post_meta( $imgId, ROBO_GALLERY_PREFIX.'gallery_type_link', true );

				$this->imgArray[$imgKey]['videolink'] = get_post_meta( $imgId, ROBO_GALLERY_PREFIX.'gallery_video_link', true );
				
				$videolink = $this->imgArray[$imgKey]['videolink'];
				
				if( $videolink && strpos($videolink, 'youtu')!==false ){
					$matches =array();	
					preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $videolink, $matches);
					#preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $videolink, $matches);
					if( is_array($matches) && isset($matches[0]) && $matches[0] ){
						$this->imgArray[$imgKey]['videolink']= 'https://youtube.com/v='.$matches[0];
					}
				}
				
				$this->imgArray[$imgKey]['col'] 		=	get_post_meta( $imgId, ROBO_GALLERY_PREFIX.'gallery_col', true );

				/*switch ($i) {
					case 4:
							$this->imgArray[$i]['col'] = 4;
						break;
					case 7:
							$this->imgArray[$i]['col'] = 4;
						break;
				}*/


				//if( !$this->imgArray[$i]['col'] && ( $i % 2 == 0) ) $this->imgArray[$i]['col'] = rand(2,3);
				

				$this->imgArray[$imgKey]['effect'] 	=	get_post_meta( $imgId, ROBO_GALLERY_PREFIX.'gallery_effect', true );
				$this->imgArray[$imgKey]['alt'] 	=	get_post_meta( $imgId, '_wp_attachment_image_alt', true );

				$this->imgArray[$imgKey]['tags'] 	= 	$this->getTags( $imgId );
			}
			
		}
 	}


 	private function getTags( $imageId ){
 		$tagsArray = array();
			
		if( $tags = get_post_meta( $imageId, ROBO_GALLERY_PREFIX.'gallery_tags', true ) ){
			$tags = explode( ',', $tags);
			if(count($tags)){
				for ($j=0; $j < count($tags); $j++) { 
					$clearTag = trim($tags[$j]);
					$tags[$j] = $clearTag ;
					if( array_search($clearTag, $this->tags)===false )  $this->tags[] = $clearTag;
				}
			}
			$tagsArray = $tags;
		}

		return $tagsArray;
 	}


 	/*  ====  */


 	private static function titleUp($item1,$item2){
		return strcasecmp ($item1['data']->post_title, $item2['data']->post_title)*-1;
	}


	private static function titleDown($item1,$item2){
		return strcasecmp ($item1['data']->post_title, $item2['data']->post_title);
	}


	private static function dateUp($item1,$item2){
		if($item1['data']->post_date==$item2['data']->post_date) return 0;
		if($item1['data']->post_date > $item2['data']->post_date) return 1;
			else return -1;
	}


	private static function dateDown($item1,$item2){
		if($item1['data']->post_date==$item2['data']->post_date) return 0;
		if($item1['data']->post_date > $item2['data']->post_date) return -1;
			else return 1;
	}
}