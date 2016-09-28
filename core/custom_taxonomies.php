<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
add_action('init', 'cod_custom_taxonomies');
function cod_custom_taxonomies() {
    
    $book_labels = array(
        );
    $book_args = array(
          
          'show_in_nav_menus'  => false ,
          'publicly_queryable' => true  
          
          
        );
    _cod_custom_taxonomies('book_year',false ,false ,$book_labels ,$book_args  ) ;
}

*/



// finish editing


function _cod_custom_taxonomies( $taxonomy = false ,  $single = false, $plural=false, $labels = array() , $args= array()) {
    if ($taxonomy === false) {
        return ;
    } else {
        if ($single === false) {
            $single = ucfirst($taxonomy);
            $plural = $single .'s';
        }
    }
    $default_labels = array(
      'name' => _x( $single, 'taxonomy general name' ),
      'singular_name' => _x( $single, 'taxonomy singular name' ),
      'menu_name' => _x('Add '.$single, 'handcraftedwptemplate_robot'),
      'all_items' => __( 'All '.$plural ),
      'edit_item' => __( 'Edit '.$single ),
      'view_item' => __( 'View '.$single ),
      'update_item' => __( 'Update '.$single ),
      'add_new_item' => __( 'Add New '.$single ),
      'new_item_name' =>  __( 'New '.$single.' Name' ),
      'parent_item' => __( 'Parent '.$single ), 
      'parent_item_colon' => __( 'Parent '.$single.':' ),
      'search_items' =>  __( 'Search '.$plural ),
      'popular_items' => __( 'Popular '.$plural ),
      'separate_items_with_commas' => __( 'Separate '.$plural.' with commas' ),
      'add_or_remove_items' => __( 'Add or remove '.$plural ),
      'choose_from_most_used' => __( 'Choose from the most used '.$plural ),
      'not_found' => __( 'No '.$plural.' found.' ),
    );
    $labels = wp_parse_args($labels, $default_labels);

    $default_args = array(
      'labels' => $labels, 
      'public' => true, // (boolean) (optional) If the taxonomy should be publicly queryable.
      'show_ui' => true, // (boolean) (optional) Whether to generate a default UI for managing this taxonomy.
      'show_in_menu' => true, // (boolean) (optional) Where to show the taxonomy in the admin menu. show_ui must be true.
      'show_in_nav_menus' => true, // (boolean) (optional) true makes this taxonomy available for selection in navigation menus.
      'show_tagcloud' => false, // (boolean) (optional) Whether to allow the Tag Cloud widget to use this taxonomy. 
      'show_in_quick_edit' => true, // (boolean) (optional) Whether to show the taxonomy in the quick/bulk edit panel.
      'meta_box_cb' => null , // (callback) (optional) Provide a callback function name for the meta box display.
      /*Note: Defaults to the categories meta box (post_categories_meta_box() in meta-boxes.php) for hierarchical taxonomies and the tags meta box (post_tags_meta_box()) for non-hierarchical taxonomies. No meta box is shown if set to false.*/
      'show_admin_column' => true, // (boolean) (optional) Whether to allow automatic creation of taxonomy columns on associated post-types table
      'description' => '', // (string) (optional) Include a description of the taxonomy.
      'hierarchical' => true, //(boolean) (optional) Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.
      'update_count_callback' => '' , // (string) (optional) A function name that will be called when the count of an associated $object_type, such as post, is updated. 
      'query_var' => false ,// (boolean or string) (optional) False to disable the query_var, set as string to use custom query_var instead of default which is $taxonomy, the taxonomy's "name".
      /*Note: The query_var is used for direct queries through WP_Query like new WP_Query(array('people'=>$person_name)) and URL queries like /?people=$person_name. Setting query_var to false will disable these methods, but you can still fetch posts with an explicit WP_Query taxonomy query like WP_Query(array('taxonomy'=>'people', 'term'=>$person_name)).*/
      'rewrite' => false , // (boolean/array) (optional) Set to false to prevent automatic URL rewriting a.k.a. "pretty permalinks". Pass an $args array to override default URL settings for permalinks as outlined below:
      'capabilities' => array( // (array) (optional) An array of the capabilities for this taxonomy.
              'manage_terms' => 'manage_categories' ,
              'edit_terms' => 'manage_categories' ,
              'delete_terms' => 'manage_categories' ,
              'assign_terms' => 'edit_posts'                   
                              ),
      'sort' => false , //(boolean) (optional) Whether this taxonomy should remember the order in which terms are added to objects.
    ); 
    $args = wp_parse_args($args, $default_args);

    register_taxonomy($taxonomy ,$args);
}