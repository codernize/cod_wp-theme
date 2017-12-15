<?php 

   $custom_style = (
                        strtoupper( $value['content__background_color']) == '#FFF' ||
                        strtoupper($value['content__background_color']) == '#FFFFF' ||
                        empty($value['content__background_color'])
                        ) ? 
                            '' : 
                            'background-color:'.$value['content__background_color'].';';
    if (!empty($value['content__custom_css'])) {
        // if white-text in custom css, then make it a class
        $value['content__custom_css'] = str_replace('white-text', '', $value['content__custom_css'] , $has_white_text);
        if ($has_white_text) {
          $class .= " white-text";
        } // end if 
        $custom_css = str_replace(
                            array(
                                "\r\n"  ,
                                "\r"  ,
                                "\n"  ,
                                  ), 
                            ';', 
                            $value['content__custom_css']);
        $custom_style .= $custom_css ;
    }
    if ('' != $custom_style) {
        $custom_style = 'style="'.$custom_style.'"';
    }
    $class .= ' '.$value['content__text_color'] ;
    if ($value['content__hero']) {
        $class .= ' hero';
    } // end if 
?>
<section class="<?php echo $class ?>" <?php echo $custom_style ?> <?php data_interchange($value['content__background_image']); ?>>
        <div class="row">
            <div class="columns">
            <?php echo force_balance_tags(wpautop(do_shortcode($value['content__content']),false)); ?>
            </div> <!-- /.columns -->
        </div> <!-- /.row -->
</section>