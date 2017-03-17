<section class="two-boxes <?php echo $class ?>">
    <div class="row expanded" data-equalizer data-equalizer-on="medium">
        <?php 

        foreach (array('left','right') as $poz) {
            $poz_acf_prefix = 'two_columns__'.$poz.'_';
            $custom_style = (
                                 strtoupper( $value[$poz_acf_prefix.'background_color']) == '#FFF' ||
                                 strtoupper($value[$poz_acf_prefix.'background_color']) == '#FFFFF' ||
                                 empty($value[$poz_acf_prefix.'background_color'])
                                 ) ? 
                                     '' : 
                                     'background-color:'.$value[$poz_acf_prefix.'background_color'].';';
             if (!empty($value[$poz_acf_prefix.'custom_css'])) {
                 $custom_css = str_replace(
                                     array(
                                         "\r\n"  ,
                                         "\r"  ,
                                         "\n"  ,
                                           ), 
                                     ';', 
                                     $value[$poz_acf_prefix.'custom_css']);
                 $custom_style .= $custom_css ;
             }
             if ('' != $custom_style) {
                 $custom_style = 'style="'.$custom_style.'"';
             }
             $poz_class = ' columns medium-6 '.$value[$poz_acf_prefix.'text_color'] ;
            
            ?>
            <div class="<?php echo $poz_class ?>" <?php echo $custom_style ?> data-equalizer-watch>
                <?php echo $value[$poz_acf_prefix.'content'] ?>
            </div> <!-- /.<?php echo $poz_class ?> -->
            
            <?php
        } // end foreach 
         ?>
        
    </div> <!-- /.row-fluid -->
</section>