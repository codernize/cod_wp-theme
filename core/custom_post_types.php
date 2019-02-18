<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/*
add_action('init', 'cod_custom_post_types');
function cod_custom_post_types() {
    $book_labels = array(
        
        );
    // icons https://developer.wordpress.org/resource/dashicons/#lightbulb
    $book_args = array(
            'menu_icon' => 'dashicons-editor-quote'
            'publicly_queryable' => true , 
            'show_in_nav_menus'  => false ,
        );
    _cod_custom_post_types('book',false ,false ,$book_labels ,$book_args  ) ;
}

*/




// finish editing

function _cod_custom_post_types( $cptype = false ,  $single = false, $plural=false, $labels = array() , $args= array()) {
    if ($cptype === false) {
        return ;
    } else {
        if ($single === false) {
            $single = ucfirst($cptype);
            $plural = $single .'s';
        }
    }
    $default_labels = array(
      'name' => _x($single, 'post type general name'),
      'singular_name' => _x($single, 'post type singular name'),
      'add_new' => _x('Add New', 'handcraftedwptemplate_robot'),
      'add_new_item' => __('Add New '.$single),
      'edit_item' => __('Edit '.$single),
      'new_item' => __('New '.$single),
      'view_item' => __('View '.$single),
      'search_items' => __('Search '.$plural),
      'not_found' =>  __('No '.$plural.' found'),
      'not_found_in_trash' => __('No '.$plural.' found in Trash'), 
      'parent_item_colon' =>  __('Parent '.$single),
      'all_items' =>  __('All '.$single),
      'archives' =>  __($single . ' Archives'),
      'insert_into_item' =>  __('Insert into '.$single),
      'uploaded_to_this_item' =>  __('Uploaded to this '.$single),
      'featured_image' =>  __('Featured Image'),
      'set_featured_image' => __('Set featured image'),
      'remove_featured_image' => __('Remove featured image'),
      'use_featured_image' => __('Use as featured image'),
      'menu_name' => __($single),
    );
    $labels = wp_parse_args($labels, $default_labels);

    $default_args = array(
      'labels' => $labels,
      'public' => true, // (boolean) (optional) Controls how the type is visible to authors (show_in_nav_menus, show_ui) and readers
      'exclude_from_search' => true,  // (boolean) (importance) Whether to exclude posts with this post type from front end search results.
      'publicly_queryable' => true, // (boolean) (optional) Whether queries can be performed on the front end as part of parse_request(). 
      'show_ui' => true,  // (boolean) (optional) Whether to generate a default UI for managing this post type in the admin.
      'show_in_nav_menus' => true , // (boolean) (optional) Whether post_type is available for selection in navigation menus.
      'show_in_menu' => true, // (boolean or string) (optional) Where to show the post type in the admin menu. show_ui must be true.
      'show_in_admin_bar' => true, // (boolean) (optional) Whether to make this post type available in the WordPress admin bar.
      'menu_position' => 20, // (integer) (optional) The position in the menu order the post type should appear. show_in_menu must be true.
      /* 5 - below Posts
        10 - below Media
        15 - below Links
        20 - below Pages
        25 - below comments
        60 - below first separator
        65 - below Plugins
        70 - below Users
        75 - below Tools
        80 - below Settings
        100 - below second separator*/
      'menu_icon' => true, // (string) (optional) The url to the icon to be used for this menu or the name of the icon from the iconfont  https://developer.wordpress.org/resource/dashicons/#album
      'capability_type' => 'page', // (string or array) (optional) The string to use to build the read, edit, and delete capabilities. 
      // 'taxonomies' => ('category'), // add custom taxonomy
      'query_var' => true,
      'rewrite' => true,
      'hierarchical' => false,
      'has_archive' => false,
      'supports' => array('title','editor','excerpt','revisions','thumbnail','author','custom-fields','comments')
    ); 
    $args = wp_parse_args($args, $default_args);

    register_post_type($cptype ,$args);
}