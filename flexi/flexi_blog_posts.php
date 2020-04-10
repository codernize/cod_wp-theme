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
  $class .= ' blog-posts';
  
 ?>
<section id="<?php echo $section_id ?>" class="<?php echo $class ?>" <?php echo $custom_style ?> data-animation-class="<?php echo $animations[$animation_key] ?>" <?php data_interchange($value['background_image']) ?> data-admshownr="<?php echo $key+1 ?>">

    <div class="row">
        <div class="content columns small-12">
            
            <?php 
            ob_start();
            if (empty($value['blog_posts'])){
                $args = array(
                    'post_type' => 'post', // string / array
                    'post_status ' => 'publish', // string / array // publish,pending,draft,future,private,trash,any 
                    'posts_per_page' =>  $value['number_of_posts'], // usually 10
                    
                    
                );    
                // more info https://codex.wordpress.org/Class_Reference/WP_Query    
                $blog_posts = new WP_Query($args);
                if ($blog_posts->have_posts()) {
                    $value['blog_posts'] = $blog_posts->posts;
                }
                wp_reset_query();
            } 
            if (!empty($value['blog_posts'])) {
             ?>
            <section class="posts-container row align-center-middle">
                <?php foreach ($value['blog_posts'] as $i => $post) {
                    ?>
                    <?php get_template_part('loop','single'); ?>
                    
                    <?php
                } ?>
            </section> <!-- /.testimonials-container -->
            
            <?php } 
            $posts_content = ob_get_clean();
            ?>
            <?php 
            if (strpos($value['content'], '%POSTS%') === FALSE) {
                echo $value['content'];
                echo $posts_content ;
            } else {
                echo str_replace('%POSTS%', $posts_content, $value['content']);

            } // end if 
            
            ?>
        </div> <!-- /.content -->
    </div> <!-- /.row -->
</section>