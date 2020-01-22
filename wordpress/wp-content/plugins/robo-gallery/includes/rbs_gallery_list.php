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


class rbsGalleryListing{

    protected $postType;

    protected $title;

    public $view;

    /*  ==============   */
    public function __construct(  ){ 
    	$this->postType = ROBO_GALLERY_TYPE_POST;

    	$this->view = new rbsGalleryClassView( $this->path.'templates/' );

    	$this->addAjaxHooks();

    	$this->hooks();

    }

    protected function hooks(){
    	add_action( 'init', array($this, 'init') );

    	if( isset($_GET['showproinfo']) && $_GET['showproinfo'] && !ROBO_GALLERY_PRO ){
    		add_action( 'in_admin_header', array($this, 'show_information') );
    	}
    }

    public function init(){

    }

    public function show_information(){
    	wp_enqueue_style("wp-jquery-ui-dialog");
		wp_enqueue_script('jquery-ui-dialog');

		wp_enqueue_script('robo-gallery-info', ROBO_GALLERY_URL.'js/admin/info.js', array( 'jquery' ), ROBO_GALLERY_VERSION, true ); 
		wp_enqueue_style ('robo-gallery-info', ROBO_GALLERY_URL.'css/admin/info.css', array( ), '' );
		
		echo '<div id="rbs_showInformation" '
					.'style="display: none;" '
					.'data-open="1" '
					.'data-title="'.__('Get Robo Gallery Pro version', 'robo-gallery').'" '
					.'data-close="'.__('Close').'" '
					.'data-info="'.__('Get Pro version', 'robo-gallery').'"'
				.'>'
				.__('You can create only 3 galleries. Update to PRO to get unlimited galleries', 'robo-gallery')
			.'</div>';
    }
}


if(!function_exists('rbs_custom_columns')){
	function rbs_custom_columns( $column, $post_id ) {
	    switch ( $column ) {
		case 'rbs_gallery' :
			global $post;
			//$slug = '' ; $slug = $post->post_name;
	        $shortcode = '
			<input readonly="readonly" size="23" value="[robo-gallery id='.$post_id.']" class="robo-gallery-shortcode" type="text" />';
		    echo $shortcode; 
		    break;

		case 'rbs_gallery_views' :
			global $post;
	        $views = (int) get_post_meta( $post->ID, 'gallery_views_count', true);
		    echo $views; 
		    break;
	    }
	}
	add_action( 'manage_'.ROBO_GALLERY_TYPE_POST.'_posts_custom_column' , 'rbs_custom_columns', 10, 2 );
}

if(!function_exists('add_rbs_table_columns')){	
	function add_rbs_table_columns($columns) { 
		return array_merge(
				$columns, 
				array( 
					'rbs_gallery_views' => __('Views','robo-gallery'), 
					'rbs_gallery' => __('Shortcode' ,'robo-gallery') 
				)
		); 
	}
	add_filter('manage_'.ROBO_GALLERY_TYPE_POST.'_posts_columns' , 'add_rbs_table_columns');
}


if(!function_exists('rbs_gallery_robogalleryList')){
	function rbs_gallery_robogalleryList (){
		wp_enqueue_script('robo-gallery-lising-js', ROBO_GALLERY_URL.'js/admin/listing.js', array( 'jquery' ), ROBO_GALLERY_VERSION, true ); 
		wp_enqueue_style ('robo-gallery-lising-css', ROBO_GALLERY_URL.'css/admin/list.css', array( ), ROBO_GALLERY_VERSION );
	}
	add_action( 'in_admin_header', 'rbs_gallery_robogalleryList' );
}