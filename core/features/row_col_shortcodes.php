<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * add columns shortcode
 */
function cod_columns_shortcode( $atts, $content = "" ) {
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
    
    $content = '<div class="columns ' . implode(' ', $atts   ) . '">' . 
        do_shortcode( ( trim( $content ) )) 
        . '</div>';
    ;
    return $content;
}
add_shortcode( 'col', 'cod_columns_shortcode' );


/**
 * add row shortcode
 */
function cod_row_shortcode( $atts, $content = "" ) {
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
    $content = '<div class="row ' . implode(' ', $atts   ) . '">' . 
        do_shortcode( ( trim( $content ) )) 
        . '</div>';
    ;
    
    return $content;

}
add_shortcode( 'row', 'cod_row_shortcode' );
