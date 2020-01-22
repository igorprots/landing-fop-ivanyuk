<?php
class BWGModelGalleryBox {
  public function get_comment_rows_data($image_id) {
    global $wpdb;
    $row = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'bwg_image_comment WHERE image_id="%d" AND published=1 ORDER BY `id` DESC', $image_id));
    return $row;
  }

  public function get_image_rows_data($gallery_id, $bwg, $sort_by, $order_by = 'asc', $tag = 0) {
    global $wpdb;

    $bwg_sort_by_temp = WDWLibrary::get('filtersortby', '');
    if ( $bwg_sort_by_temp == '' ) {  /* for thumbnail view */
      $bwg_sort_by_temp = WDWLibrary::get('filtersortby_' . $bwg, ''); /* for other views */
      if ( $bwg_sort_by_temp != '' ) {
        $sort_by = $bwg_sort_by_temp;
      }
    }
    else {
      $sort_by = $bwg_sort_by_temp;
    }

    if ( $sort_by == 'size' || $sort_by == 'resolution' ) {
      $sort_by = ' CAST(image.' . $sort_by . ' AS SIGNED) ';
    }
    elseif ( $sort_by == 'casual' ) {
      $sort_by = 'RAND()';
    }
    elseif (($sort_by != 'alt') && ($sort_by != 'date') && ($sort_by != 'filetype') && ($sort_by != 'filename')) {
      $sort_by = 'image.`order`';
    }
    else {
      $sort_by = 'image.' . $sort_by;
    }

    if (strtolower($order_by) != 'asc') {
      $order_by = 'desc';
    }

    $bwg_random_seed = WDWLibrary::get('bwg_random_seed','');
    $bwg_filter_tag_temp = WDWLibrary::get('filter_tag', 0);
    if ( $bwg_filter_tag_temp == 0 ) {
      $filter_tags = array();
      $bwg_filter_tag_temp = WDWLibrary::get('filter_tag_' . $bwg, 0);
      if ( $bwg_filter_tag_temp != 0 ) {
        $filter_tags = explode(",", $bwg_filter_tag_temp);
      }
    }
    else {
      $filter_tags = explode(",", $bwg_filter_tag_temp);
    }

    $filter_search_name_temp = WDWLibrary::get('filter_search_name', '');
    $filter_search_name = '';
    if ( $filter_search_name_temp == '' ) {  /* for thumbnail view */
      $filter_search_name_temp = WDWLibrary::get('filter_search_name_' . $bwg);
      if ( $filter_search_name_temp != '' ) {
        $filter_search_name = trim($filter_search_name_temp);
      }
    }
    else {
      $filter_search_name = trim($filter_search_name_temp);
    }

    $where = '';
    if ( $filter_search_name !== '' ) {
      $bwg_search_keys = explode(' ', $filter_search_name);
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
    $where .= ($gallery_id ? ' AND image.gallery_id = "' . $gallery_id . '" ' : '') . ($tag ? ' AND tag.tag_id = "' . $tag . '" ' : '');
    $join = $tag ? 'LEFT JOIN ' . $wpdb->prefix . 'bwg_image_tag as tag ON image.id=tag.image_id' : '';

    $join .= ' LEFT JOIN '. $wpdb->prefix .'bwg_gallery as gallery ON image.gallery_id = gallery.id ';
    $where .= ' AND gallery.published = 1 ';

    if ( $filter_tags ) {
      if ( !BWG()->options->tags_filter_and_or ) {
        // To find images which have at least one from tags filtered by.
        $compare_sign = "|";
      }
      else {
        // To find images which have all tags filtered by.
        // For this case there is need to sort tags by ascending to compare with comma.
        sort($filter_tags);
        $compare_sign = ",";
      }
      $join .= ' LEFT JOIN (SELECT GROUP_CONCAT(tag_id order by tag_id SEPARATOR ",") AS tags_combined, image_id FROM  ' . $wpdb->prefix . 'bwg_image_tag' . ($gallery_id ? ' WHERE gallery_id="' . $gallery_id . '"' : '') . ' GROUP BY image_id) AS tags ON image.id=tags.image_id';
      $where .= ' AND CONCAT(",", tags.tags_combined, ",") REGEXP ",(' . implode($compare_sign, $filter_tags) . ')," ';
    }

    $query = 'SELECT image.*, rates.rate FROM ' . $wpdb->prefix . 'bwg_image as image LEFT JOIN (SELECT rate, image_id FROM ' . $wpdb->prefix . 'bwg_image_rate WHERE ip="' . $_SERVER['REMOTE_ADDR'] . '") as rates ON image.id=rates.image_id ' . $join . ' WHERE image.published=1 ' . $where;
    $query .=  ' ORDER BY ' . str_replace('RAND()', 'RAND(' . $bwg_random_seed . ')', $sort_by) . ' ' . $order_by;
    $rows = $wpdb->get_results($query);

    $images = array();
    if ( !empty($rows) ) {
      foreach ( $rows as $row ) {
        $row->alt = esc_html($row->alt);
        $row->pure_image_url = $row->image_url;
        $row->pure_thumb_url = $row->thumb_url;
        if ( strpos($row->filetype, 'EMBED') === FALSE ) {
          $row->image_url = WDWLibrary::image_url_version($row->image_url, $row->modified_date);
          $row->thumb_url = WDWLibrary::image_url_version($row->thumb_url, $row->modified_date);
        }
        $images[] = $row;
      }
    }

    return $images;
  }
  
  public function get_image_pricelists($pricelist_id) {
    $pricelist_data = array();

    return $pricelist_data;
  }

  public function get_image_pricelist($image_id) {
    return FALSE;
  }
}