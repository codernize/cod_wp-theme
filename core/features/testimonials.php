<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (function_exists('_cod_custom_post_types')) {
    add_image_size( 'testimonial-author', 56, 56,true);
    add_action('init', 'cod_init_testimonials_post_types');
} // endif

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





if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_5a3122355c287',
    'title' => 'Testimonial :: Settings',
    'fields' => array(
        array(
            'key' => 'field_5a312243212b6',
            'label' => 'Ocupation',
            'name' => 'ocupation',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'testimonial',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

endif;