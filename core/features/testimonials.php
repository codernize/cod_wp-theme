<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_image_size( 'testimonial-author', 56, 56,true);

add_action('init', 'cod_init_testimonials_post_types');
function cod_init_testimonials_post_types() {
    // icons https://developer.wordpress.org/resource/dashicons/#lightbulb
    $service_labels = array(
        'menu_name' => __('Testimonials')
        );
    $service_args = array(
            'show_in_nav_menus'  => false ,
            'publicly_queryable' => false , 
            'show_in_admin_bar' => false , 
            'menu_icon' => 'dashicons-format-quote',
            'supports' => array('title','editor','thumbnail')
        );
    _cod_custom_post_types('testimonial',false ,false ,$service_labels ,$service_args  ) ;
}