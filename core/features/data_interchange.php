<?php 



add_image_size( 'interchange-small', 640, 99999);
add_image_size( 'interchange-medium', 1024, 9999);

function data_interchange($image = array(), $echo = true) {
    if (empty($image))
        $return = '';
    else if (is_array($image)) { // has sizes . ACF for now
        $sizes = [];
        if (isset($image['sizes'],$image['sizes']['interchange-small']));
            $sizes['interchange-small'] = '['.$image['sizes']['interchange-small'].', small]';
        if (isset($image['sizes'],$image['sizes']['interchange-medium']));
            $sizes['interchange-medium'] = '['.$image['sizes']['interchange-medium'].', medium]';

        $sizes['large'] = '['.$image['url'].', large]';

        $return = 'data-interchange="'.implode(',', $sizes).'"';

    }

    if ($echo) 
        echo $return;
    else return $return ;
   
}