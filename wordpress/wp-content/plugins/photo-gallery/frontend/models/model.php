<?php
class BWGModelSite {
  public function get_theme_row_data($id = 0) {
    global $wpdb;
    if (!$id) {
      $id = $wpdb->get_var('SELECT id FROM ' . $wpdb->prefix . 'bwg_theme WHERE default_theme=1');
    }
    $row = new WD_BWG_Theme($id);
    return $row;
  }

  public function get_gallery_row_data($id = 0, $from = '') {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bwg_gallery WHERE id="%d"', $id));
    if ( $row ) {
      $row->permalink = '';
      if ($from != '') {
        $row->permalink = self::get_custom_post_permalink( array( 'slug' => $row->slug, 'post_type' => 'gallery' ) );
      }
      if ( !empty($row->preview_image) ) {
        $row->preview_image = WDWLibrary::image_url_version($row->preview_image, $row->modified_date);
      }
      if ( !empty($row->random_preview_image) ) {
        $row->random_preview_image = WDWLibrary::image_url_version($row->random_preview_image, $row->modified_date);
      }
    }
    else if ( !$id ) { /* Select all Galleries */
      $row_count = $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'bwg_gallery WHERE published=1');
      if ( !$row_count ) {
        return false;
      }
      else {
        $row = new stdClass();
        $row->id = 0;
        $row->name = '';
      }
    }

    return $row;
  }

  public function get_album_row_data( $id, $from ) {
    global $wpdb;
    if ( $id == 0 ) {
      $row = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'bwg_gallery');
    }
    else {
      $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bwg_album WHERE id="%d"', $id));
    }
    if ( is_object($row) ) {
      if ( $from ) {
        $row->permalink = WDWLibrary::get_custom_post_permalink(array( 'slug' => $row->slug, 'post_type' => 'album' ));
      }
      if ( !empty($row->preview_image) ) {
        $row->preview_image = WDWLibrary::image_url_version($row->preview_image, $row->modified_date);
      }
      if ( !empty($row->random_preview_image) ) {
        $row->random_preview_image = WDWLibrary::image_url_version($row->random_preview_image, $row->modified_date);
      }
    }
    return $row;
  }

  public function get_image_rows_data( $gallery_id, $bwg, $type, $tag_input_name, $tag, $images_per_page, $load_more_image_count, $sort_by, $sort_direction = 'ASC' ) {
    if ( $images_per_page < 0 ) {
      $images_per_page = 0;
    }
    if ( $load_more_image_count < 0 ) {
      $load_more_image_count = 0;
    }
    global $wpdb;
    $gallery_id = (int) $gallery_id;
    $tag = (int) $tag;
    if ( BWG()->options->front_ajax != "1" ) {
      $bwg_search = ((isset($_POST['bwg_search_' . $bwg]) && esc_html($_POST['bwg_search_' . $bwg]) != '') ? trim(esc_html($_POST['bwg_search_' . $bwg])) : '');
    }
    else {
      $get_search = WDWLibrary::get('bwg_search_' . $bwg);
      $get_sort_by = WDWLibrary::get('sort_by_' . $bwg);
      $get_filter_teg = WDWLibrary::get('filter_tag_' . $bwg);
      $bwg_search = ((isset($get_search) && esc_html($get_search) != '') ? trim(esc_html($get_search)) : '');
      $sort_by = ((isset($get_sort_by) && esc_html($get_sort_by) != '') ? trim(esc_html($get_sort_by)) : '');
      $filter_teg = ((isset($get_filter_teg) && esc_html($get_filter_teg) != '') ? trim(esc_html($get_filter_teg)) : '');
      if ( !empty($filter_teg) ) {
        $filter_teg_arr = explode(',', $filter_teg);
        $_REQUEST[$tag_input_name] = $filter_teg_arr;
      }
    }
    $where = '';
    if ( $bwg_search !== '' ) {
      $bwg_search_keys = explode(' ', $bwg_search);
      $alt_search = '(';
      $description_search = '(';
      foreach( $bwg_search_keys as $search_key) {
        $alt_search .= '`image`.`alt` LIKE "%' . trim($search_key) . '%" AND ';
        $description_search .= '`image`.`description` LIKE "%' . trim($search_key) . '%" AND ';
      }
      $alt_search = rtrim($alt_search, 'AND ');
      $alt_search .= ')';
      $description_search = rtrim($description_search, 'AND ');
      $description_search .= ')';
      $where = 'AND (' . $alt_search . ' OR ' . $description_search . ')';
    }
    if ( $sort_by == 'size' || $sort_by == 'resolution' ) {
      $sort_by = ' CAST(image.' . $sort_by . ' AS SIGNED) ';
    }
    elseif ( $sort_by == 'random' || $sort_by == 'RAND()' ) {
      $sort_by = 'RAND()';
    }
    elseif ( ($sort_by != 'alt') && ($sort_by != 'date') && ($sort_by != 'filetype') && ($sort_by != 'RAND()') && ($sort_by != 'filename') ) {
      $sort_by = 'image.`order`';
    }
    else {
      $sort_by = 'image.' . $sort_by;
    }
    $items_in_page = $images_per_page;
    $limit = 0;
    WDWLibrary::bwg_session_start();
    if ( isset($_REQUEST['page_number_' . $bwg]) && $_REQUEST['page_number_' . $bwg] ) {
      if ( $_REQUEST['page_number_' . $bwg] > 1 ) {
        $items_in_page = $load_more_image_count;
      }
      $limit = (((int) $_REQUEST['page_number_' . $bwg] - 2) * $items_in_page) + $images_per_page;
      $bwg_random_seed = isset($_SESSION['bwg_random_seed_' . $bwg]) ? $_SESSION['bwg_random_seed_' . $bwg] : '';
    }
    else {
      $bwg_random_seed = rand();
      $_SESSION['bwg_random_seed_' . $bwg] = $bwg_random_seed;
    }
    $limit_str = '';
    if ( $images_per_page ) {
      $limit_str = 'LIMIT ' . $limit . ',' . $items_in_page;
    }
    $where .= ($gallery_id ? ' AND image.gallery_id = "' . $gallery_id . '" ' : '') . ($tag ? ' AND tag.tag_id = "' . $tag . '" ' : '');
    $join = $tag ? 'LEFT JOIN ' . $wpdb->prefix . 'bwg_image_tag as tag ON image.id=tag.image_id' : '';
    if ( isset($_REQUEST[$tag_input_name]) && $_REQUEST[$tag_input_name] ) {
      if ( !BWG()->options->tags_filter_and_or ) {
        // To find images which have at least one from tags filtered by.
        $compare_sign = "|";
      }
      else {
        // To find images which have all tags filtered by.
        // For this case there is need to sort tags by ascending to compare with comma.
        sort($_REQUEST[$tag_input_name]);
        $compare_sign = ",";
      }
      $join .= ' LEFT JOIN (SELECT GROUP_CONCAT(tag_id order by tag_id SEPARATOR ",") AS tags_combined, image_id FROM  ' . $wpdb->prefix . 'bwg_image_tag' . ($gallery_id ? ' WHERE gallery_id="' . $gallery_id . '"' : '') . ' GROUP BY image_id) AS tags ON image.id=tags.image_id';
      $where .= ' AND CONCAT(",", tags.tags_combined, ",") REGEXP ",(' . implode($compare_sign, $_REQUEST[$tag_input_name]) . ')," ';
    }
    $join .= ' LEFT JOIN '. $wpdb->prefix .'bwg_gallery as gallery ON gallery.id = image.gallery_id';
    $where .= ' AND gallery.published = 1 ';
    $query = 'SELECT image.* FROM ' . $wpdb->prefix . 'bwg_image as image ' . $join . ' WHERE image.published=1 ' . $where . ' ORDER BY ' . str_replace('RAND()', 'RAND(' . $bwg_random_seed . ')', $sort_by) . ' ' . $sort_direction . ', image.id ' . $limit_str;
    $rows = $wpdb->get_results($query);
    $total = $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'bwg_image as image ' . $join . ' WHERE image.published=1 ' . $where);
    $page_nav['total'] = $total;
    $page_nav['limit'] = 1;
    if ( isset($_REQUEST['page_number_' . $bwg]) && $_REQUEST['page_number_' . $bwg] ) {
      $page_nav['limit'] = (int) $_REQUEST['page_number_' . $bwg];
    }
    $images = array();
    $thumb_urls = array();
    if ( !empty($rows) ) {
      foreach ( $rows as $row ) {
        $row->alt = esc_html($row->alt);
        if ( strpos($row->filetype, 'EMBED') === FALSE ) {
          $row->image_url_raw = $row->image_url;
          $row->image_url = WDWLibrary::image_url_version($row->image_url, $row->modified_date);
          $row->thumb_url = WDWLibrary::image_url_version($row->thumb_url, $row->modified_date);
          // To disable Jetpack Photon module.
		      $thumb_urls[] = BWG()->upload_url . $row->thumb_url;
        }
        else {
          // To disable Jetpack Photon module.
          $thumb_urls[] = $row->thumb_url;
        }
        $images[] = $row;
      }
    }
    return array( 'images' => $images, 'page_nav' => $page_nav, 'thumb_urls' => $thumb_urls );
  }

  /**
   * Get images from Gallery Group for XML Sitemap.
   * Selecting only first level Galleries to avoid unnecessarily big data.
   * Inner Gallery Groups data will not be included in sitemap.
  */
  public function get_image_rows_data_from_album($album_id) {
    global $wpdb;
    $where = $album_id ? 'image.gallery_id IN (SELECT alb_gal_id FROM `' . $wpdb->prefix . 'bwg_album_gallery` as albgal WHERE albgal.album_id=' . ((int)$album_id) . ' AND (SELECT gal.published from `' . $wpdb->prefix . 'bwg_gallery` as gal WHERE gal.id=albgal.alb_gal_id))' : '(SELECT gal.published from `' . $wpdb->prefix . 'bwg_gallery` as gal WHERE gal.id=image.gallery_id)=1';
    $query = 'SELECT image.* FROM `' . $wpdb->prefix . 'bwg_image` as image WHERE image.published=1 AND ' . $where;
    return $wpdb->get_results($query);
  }

  public function get_tags_rows_data($gallery_id) {
    global $wpdb;
    $row = $wpdb->get_results('Select t1.* FROM ' . $wpdb->prefix . 'terms AS t1 LEFT JOIN ' . $wpdb->prefix . 'term_taxonomy AS t2 ON t1.term_id = t2.term_id' . ($gallery_id ? ' LEFT JOIN (SELECT DISTINCT tag_id , gallery_id  FROM ' . $wpdb->prefix . 'bwg_image_tag) AS t3 ON t1.term_id=t3.tag_id' : '') . ' WHERE taxonomy="bwg_tag"' . ($gallery_id ? ' AND t3.gallery_id="' . $gallery_id . '"' : '') . ' ORDER BY t1.name  ASC');
    return $row;
  }

  public function get_alb_gals_row( $bwg, $id, $albums_per_page, $sort_by, $order_by, $pagination_type = 0, $from = '' ) {
	if ( $albums_per_page < 0 ) {
      $albums_per_page = 0;
    }
    global $wpdb;
	$order_by = 'ORDER BY `' . ( (!empty($from) && $from === 'widget') ? 'id' : $sort_by ) . '` ' . $order_by;
	if( $sort_by == 'random' || $sort_by == 'RAND()' ) {
	  $order_by = 'ORDER BY RAND()';
	}
	$search_value = !empty($_REQUEST['bwg_search_' . $bwg]) ? trim( esc_html($_REQUEST['bwg_search_' . $bwg]) ) : '';
	$search_where = '';
	if ( !empty($search_value) ) {
      $search_keys = explode(' ', $search_value);
      $alt_search = '(';
      $description_search = '(';
      foreach( $search_keys as $search_key) {
        $alt_search .= '`{{table}}`.`name` LIKE "%' . trim($search_key) . '%" AND ';
        $description_search .= '`{{table}}`.`description` LIKE "%' . trim($search_key) . '%" AND ';
      }
      $alt_search = rtrim($alt_search, 'AND ');
      $alt_search .= ')';
      $description_search = rtrim($description_search, 'AND ');
      $description_search .= ')';
      $search_where = ' AND (' . $alt_search . ' OR ' . $description_search . ')';
    }
	$limit = 0;
    if ( isset( $_REQUEST[ 'page_number_' . $bwg ] ) && $_REQUEST[ 'page_number_' . $bwg ] ) {
      $limit = ((int) $_REQUEST[ 'page_number_' . $bwg ] - 1) * $albums_per_page;
    }
    $limit_str = '';
    if ( $albums_per_page ) {
      $limit_str = 'LIMIT ' . $limit . ',' . $albums_per_page;
    }
    if ( isset( $_REQUEST[ 'action_' . $bwg ] ) && $_REQUEST[ 'action_' . $bwg ] == 'back' && ($pagination_type == 2 || $pagination_type == 3) ) {
      if ( isset( $_REQUEST[ 'page_number_' . $bwg ] ) && $_REQUEST[ 'page_number_' . $bwg ] ) {
        if ( $albums_per_page ) {
          $limit = $albums_per_page * $_REQUEST['page_number_' . $bwg];
          $limit_str = 'LIMIT 0,' . $limit;
        }
      }
    }
    // Select all galleries.
    if ( $id == 0 ) {
	 $query = 'SELECT * FROM `' . $wpdb->prefix . 'bwg_gallery` WHERE `published`=1' . str_replace('{{table}}', $wpdb->prefix . 'bwg_gallery', $search_where);
      $limitation = ' ' . $order_by . ' ' . $limit_str;
      $sql = $query . $limitation;
	  $rows = $wpdb->get_results( $sql );
      $total = $wpdb->get_var('SELECT count(*) FROM `' . $wpdb->prefix . 'bwg_gallery` WHERE `published`=1' . str_replace('{{table}}', $wpdb->prefix . 'bwg_gallery', $search_where) );
    }
    else {
      $query  = '( SELECT t.*, t1.preview_image, t1.random_preview_image, t1.name, t1.description, t1.slug, t1.modified_date FROM `' . $wpdb->prefix . 'bwg_album_gallery` as t';
      $query .= ' LEFT JOIN `' . $wpdb->prefix . 'bwg_album` as t1 ON (t.is_album=1 AND t.alb_gal_id = t1.id)';
      $query .= ' WHERE t.album_id="' . $id . '"';
      $query .= ' AND t1.published=1' . str_replace('{{table}}', 't1', $search_where);
	  $query .= ') ';
	  $query .= ' UNION ';
	  $query .= '( SELECT t.*, t2.preview_image, t2.random_preview_image, t2.name, t2.description, t2.slug, t2.modified_date FROM `' . $wpdb->prefix . 'bwg_album_gallery` as t';
      $query .= ' LEFT JOIN `' . $wpdb->prefix . 'bwg_gallery` as t2 ON (t.is_album=0 AND t.alb_gal_id = t2.id)';
      $query .= ' WHERE t.album_id="' . $id . '"';
      $query .= ' AND t2.published=1' . str_replace('{{table}}', 't2', $search_where);
      $query .= ')';
      $limitation = ' ' . $order_by . ' ' . $limit_str;
      $sql = $query . $limitation;
      $rows = $wpdb->get_results($sql);
      $total = count($wpdb->get_results($query));
    }
    if ( $rows ) {
      foreach ( $rows as $row ) {
        $row->def_type = isset($row->is_album) && $row->is_album ? 'album' : 'gallery';
        if ( $from ) {
          $row->permalink = WDWLibrary::get_custom_post_permalink(array( 'slug' => $row->slug, 'post_type' => $row->def_type ));
        }
        else {
          $row->permalink = '';
        }

        if ( !empty($row->preview_image) ) {
          $row->resolution_thumb = WDWLibrary::get_thumb_size($row->preview_image);
          if ( $row->resolution_thumb == "" ) {
            $row->resolution_thumb = $this->get_album_preview_thumb_dimensions($row->preview_image);
          }

          $row->preview_image = WDWLibrary::image_url_version($row->preview_image, $row->modified_date);
        }
        if ( !empty($row->random_preview_image) ) {
          $row->resolution_thumb = WDWLibrary::get_thumb_size($row->random_preview_image);
          if ( $row->resolution_thumb == "" ) {
            $row->resolution_thumb = $this->get_album_preview_thumb_dimensions($row->random_preview_image);
          }
          $row->random_preview_image = WDWLibrary::image_url_version($row->random_preview_image, $row->modified_date);
        }
        if ( !$row->preview_image ) {
          $row->preview_image = $row->random_preview_image;
        }

        if ( !$row->preview_image ) {
          $row->preview_image = BWG()->plugin_url . '/images/no-image.png';
          $row->preview_path = BWG()->plugin_dir . '/images/no-image.png';
        }
        else {
          $parsed_prev_url = parse_url($row->preview_image, PHP_URL_SCHEME);
          if ( $parsed_prev_url == 'http' || $parsed_prev_url == 'https' ) {
            $row->preview_path = $row->preview_image;
            $row->preview_image = $row->preview_image;
          }
          else {
            $row->preview_path = BWG()->upload_dir . $row->preview_image;
            $row->preview_image = BWG()->upload_url . $row->preview_image;
          }
        }

        $row->description = wpautop($row->description);
      }
    }
    $page_nav[ 'total' ] = $total;
    $page_nav[ 'limit' ] = 1;
    if ( isset( $_REQUEST[ 'page_number_' . $bwg ] ) && $_REQUEST[ 'page_number_' . $bwg ] ) {
      $page_nav[ 'limit' ] = (int) $_REQUEST[ 'page_number_' . $bwg ];
    }

    return array( 'rows' => $rows, 'page_nav' => $page_nav );
  }

  /**
   * Get thumb resolution from bwg_image row.
   *
   * @param  string $thumb_url
   *
   * @return string $resolution
   */
  public function get_album_preview_thumb_dimensions( $thumb_url ) {
    global $wpdb;
    $resolution = $wpdb->get_var('SELECT resolution_thumb FROM ' . $wpdb->prefix . 'bwg_image WHERE thumb_url = "' . $thumb_url . '"');
    return $resolution;
  }
}
