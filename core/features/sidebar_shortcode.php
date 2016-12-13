<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * add columns shortcode
 */
function cod_sidebar_shortcode( $atts, $content = "" ) {

    $atts = (array)$atts;
    array_walk($atts, 'esc_attr') ;
    $content = trim($content);

    // remove first <br />
    if (substr($content, 0,6) == '<br />') {
        $content = substr($content, 6);
    }
    // remove last <br />
    if (substr($content, -6) == '<br />') {
        $content = substr($content,0, -6);
    }
    ob_start();
    dynamic_sidebar('page');
    $sidebar = ob_get_clean();

    $content = '<aside id="sidebar" class="columns ' . implode(' ', $atts   ) . '">' . 
        $sidebar .
        do_shortcode( ( trim( $content ) )) 
        . '</aside>';
    ;
    
    return $content;
}
add_shortcode( 'sidebar', 'cod_sidebar_shortcode' );