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

jQuery(function(){
	jQuery('a[href="edit.php?post_type=robo_gallery_table&page=robo-gallery-support"]').click( function(event ){
		event.preventDefault();
		window.open("http://robosoft.co/go.php?product=gallery&task=support"+(robo_gallery_vars.pro=="1"?'&pro=1':''), "_blank");
	});
	jQuery('a[href="edit.php?post_type=robo_gallery_table&page=robo-gallery-demo"]').click( function(event ){
		event.preventDefault();
		window.open("http://robosoft.co/go.php?product=gallery&task=demo", "_blank");
	});
	jQuery('a[href="edit.php?post_type=robo_gallery_table&page=robo-gallery-guides"]').click( function(event ){
		event.preventDefault();
		window.open("http://robosoft.co/go.php?product=gallery&task=guides", "_blank");
	});

	

	/*var roboGalleryShowNewDialog = function(){
		alert("Hi");
	};

	jQuery("li#menu-posts-robo_gallery_table a[href='post-new.php?post_type=robo_gallery_table']").click( function(event ){
		event.preventDefault();
		roboGalleryShowNewDialog();
	});

	jQuery('#wp-admin-bar-new-robo_gallery_table').click( function(event ){
		event.preventDefault();
		roboGalleryShowNewDialog();
	});

	jQuery('body.post-type-robo_gallery_table .wrap a.page-title-action').click( function(event ){
		event.preventDefault();
		roboGalleryShowNewDialog();
	});*/

});