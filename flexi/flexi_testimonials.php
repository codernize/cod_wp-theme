<?php 

  $custom_style = (
                       strtoupper( $value['testimonials__background_color']) == '#FFF' ||
                       strtoupper($value['testimonials__background_color']) == '#FFFFF' ||
                       empty($value['testimonials__background_color'])
                       ) ? 
                           '' : 
                           'background-color:'.$value['testimonials__background_color'].';';
   if (!empty($value['testimonials__custom_css'])) {
       $custom_css = str_replace(
                           array(
                               "\r\n"  ,
                               "\r"  ,
                               "\n"  ,
                                 ), 
                           ';', 
                           $value['testimonials__custom_css']);
       $custom_style .= $custom_css ;
   }
   if ('' != $custom_style) {
       $custom_style = 'style="'.$custom_style.'"';
   }
  $class .= ' testimonials';
 ?>
<section class="<?php echo $class ?>" <?php echo $custom_style ?> >
    <div class="row">
        <div class="content columns">
            
            <?php 
            ob_start();
            if (empty($value['testimonials__testimonials'])){
                $args = array(
                    'post_type' => 'testimonial', // string / array
                    'post_status ' => 'publish', // string / array // publish,pending,draft,future,private,trash,any 
                    'posts_per_page' =>  -1, // usually 10
                    
                    
                );    
                // more info https://codex.wordpress.org/Class_Reference/WP_Query    
                $testimonials = new WP_Query($args);
                if ($testimonials->have_posts()) {
                    $value['testimonials__testimonials'] = $testimonials->posts;
                }
                wp_reset_query();
            } 
            if (!empty($value['testimonials__testimonials'])) {
             ?>
            <section class="testimonials-container">
                <?php foreach ($value['testimonials__testimonials'] as $i => $testimonial) {
                    ?>
                <div class="slide">
                   <h3><?php echo $testimonial->post_title ?></h3>
                   <?php 
                     $content =  apply_filters('the_content',$testimonial->post_content);
                     $content =  apply_filters('wpautop',$content);
                     echo $content ;

                      ?>
                   <p class="author"><strong><?php echo get_post_meta($testimonial->ID,'author_name',true) ?></strong> <?php echo get_post_meta($testimonial->ID,'position',true) ?></p> <!-- /.author -->
                </div> <!-- /.slide -->
                    <?php
                } ?>
            </section> <!-- /.testimonials-container -->
            <section class="bx-pager">
                <?php foreach ($value['testimonials__testimonials'] as $i => $testimonial) {
                    ?>
                  <a data-slide-index="<?php echo $i ?>" href="">
                    <?php if (has_post_thumbnail($testimonial->ID)): ?>
                        <?php echo get_the_post_thumbnail($testimonial->ID , 'testimonial-author' )  ?>
                    <?php else: ?>    
                        <img src="<?php bloginfo('template_url'); ?>/images/testim_author_image_1.jpg" />
                    <?php endif ?>
                    </a>
                     <?php
                 } ?>   
                
            </section> <!-- /.bx-pager -->
            <?php } 
            $testimonials_content = ob_get_clean();
            ?>
            <?php 
            if (strpos($value['testimonials__content'], '%THEMES%') === FALSE) {
                echo $value['testimonials__content'];
                echo $testimonials_content ;
            } else {
                echo str_replace('%THEMES%', $testimonials_content, $value['testimonials__content']);

            } // end if 
            
            ?>
        </div> <!-- /.content -->
    </div> <!-- /.row -->
</section>