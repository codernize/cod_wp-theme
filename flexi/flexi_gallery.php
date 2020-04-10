<?php 

  $custom_style = (
                       strtoupper( $value['background_color']) == '#FFF' ||
                       strtoupper($value['background_color']) == '#FFFFF' ||
                       empty($value['background_color'])
                       ) ? 
                           '' : 
                           'background-color:'.$value['background_color'].';';
   if (!empty($value['custom_css'])) {
        // add 'white-text' from custom css to class
        $value['custom_css'] = str_replace('white-text', '', $value['custom_css'] , $has_white_text);
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
                           $value['custom_css']);
       $custom_style .= $custom_css ;
   }
   if ('' != $custom_style) {
       $custom_style = 'style="'.$custom_style.'"';
   }
  $class .= ' gallery';
 ?>
<section id="<?php echo $section_id ?>" class="<?php echo $class ?>" <?php echo $custom_style ?> <?php /*data_interchange($value['background_image']);*/ ?> data-animation-class="<?php echo $animations[$animation_key] ?>" data-admshownr="<?php echo $key+1 ?>">
    
            
            <?php 
            if (!$value['full_width']) {
                ?>
                <div class="row">
                    <div class="columns small-12">
                        
                  
                <?php
            } // end if 
             ?>
            <div class="gallery-container slickSlider" data-featherlight-gallery
      data-featherlight-filter="a.featherlightGallery">
                   
                <?php foreach ($value['gallery'] as $i => $gallery_image) {
                    ?>
                     <div class="slide">
                        <?php
                        if (isset($gallery_image['sizes']['product'])) {
                            $small_attr =  $gallery_image['sizes']['product'];
                            $width = $gallery_image['sizes']['product-width'];
                            $height = $gallery_image['sizes']['product-height'];

                        } else {
                            $small_attr =  $gallery_image['sizes']['medium'];
                            $width = $gallery_image['sizes']['medium-width'];
                            $height = $gallery_image['sizes']['medium-height'];
                        } // end if 
                        

                        ?>
                       <a href="<?php echo $gallery_image['url'] ?>"  class="featherlightGallery" > <img src="<?php echo $small_attr ?>"  alt="<?php echo esc_attr( $gallery_image['alt'] ) ?>" title="<?php echo esc_attr( $gallery_image['title'] ) ?>" width="<?php echo $width ?>" height="<?php echo $height ?>"  /></a>
                     </div> <!-- /.slide -->
                   
                    <?php
                } ?>
                  
                
            </div> 
            
            <?php 

            if (!$value['full_width']) {
                ?>
                
                        
                    </div> <!-- /.columns small-12 -->
                </div> <!-- /.row -->
                <?php
            } // end if 
             ?>
</section>