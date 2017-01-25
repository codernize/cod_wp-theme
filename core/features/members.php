<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (function_exists('_cod_custom_post_types')) {
    add_image_size( 'member', 450, 521,true);
    add_action('init', 'cod_init_members_post_types');
} // endif
   
function cod_init_members_post_types() {
    // icons https://developer.wordpress.org/resource/dashicons/#lightbulb
    $service_labels = array(
        'menu_name' => __('Members')
        );
    $service_args = array(
            'show_in_nav_menus'  => true ,
            'publicly_queryable' => true , 
            'show_in_admin_bar' => true , 
            'menu_icon' => 'dashicons-admin-users' ,
            'supports' => array('title','editor','thumbnail')
        );
    _cod_custom_post_types('member',false ,false ,$service_labels ,$service_args  ) ;
}




