<?php 



add_image_size( 'interchange-small', 640, 99999);
add_image_size( 'interchange-medium', 1024, 9999);

function data_interchange($image = array(), $echo = true, $max_sizes = array()) {
    $max_sizes = wp_parse_args( $max_sizes, 
                $max_sizes = array(
                               'small' => 640,
                               'medium'=>1024,
                               'large'=>1920)
                );
    $return = '';
    if (empty($image))
        $return = '';
    else if (is_array($image)) { // has sizes . ACF for now
        $sizes = [];
        
        if (isset($image['sizes'],$image['sizes']['interchange-small']) && $image['sizes']['interchange-small-width'] >= $max_sizes['small']) {
            $small_size = $image['sizes']['interchange-small-width'];
            $sizes['small'] = '['.$image['sizes']['interchange-small'].', small]';
        }
        if (isset($image['sizes'],$image['sizes']['interchange-medium']) && $image['sizes']['interchange-medium-width'] <= $max_sizes['medium'])
            $medium_size = $image['sizes']['interchange-medium-width'];
            $sizes['medium'] = '['.$image['sizes']['interchange-medium'].', medium]';

        if (isset($image['sizes'],$image['sizes']['interchange-large']) && $image['sizes']['interchange-large-width'] <= $max_sizes['large']){

            $sizes['large'] = '['.$image['sizes']['interchange-large'].', large]';
            if ($image['width'] > $max_sizes['large']) {
                $sizes['retina'] = '['.$image['url'].', retina]';
            } // end if 
        } else {
            $large_url = $image['url'] ; 
            if (isset($medium_size) && $medium_size >= $max_sizes['large']) {
                $large_url = $image['sizes']['interchange-medium'];
            } // end if 
            if (isset($small_size) && $small_size >= $max_sizes['large']) {
                $large_url = $image['sizes']['interchange-small'];
            } // end if 

            if (!isset($sizes['small'])) {
                $sizes['small'] = '['.$large_url.', small]';

                
            } else {
                $sizes['large'] = '['.$large_url.', large]';
                
            } // end if 
            if (strcmp($large_url, $image['url']) !== 0) {
                $sizes['retina'] = '['.$image['url'].', retina]';
            } // end if 
            
        }


        $return = 'data-interchange="'.implode(',', $sizes).'"';

    }

    if ($echo) 
        echo $return;
    else return $return ;
   
}


function feature_image_to_bg($post_id = false,$echo = true, $sizes = array()){
    if (false == $post_id) {
        global $post;
        $post_id = $post->ID;
    } // end if 
    if (has_post_thumbnail($post_id)) {
        // global $post;
        data_interchange(acf_get_attachment(get_post(get_post_thumbnail_id($post_id ))),$echo,$sizes);
        return true;
    }
    else return false;
}