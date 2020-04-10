<?php 

  $custom_style = (
                       strtoupper( $value['doctors__background_color']) == '#FFF' ||
                       strtoupper($value['doctors__background_color']) == '#FFFFF' ||
                       empty($value['doctors__background_color'])
                       ) ? 
                           '' : 
                           'background-color:'.$value['doctors__background_color'].';';
   if (!empty($value['doctors__custom_css'])) {
        // add 'white-text' from custom css to class
        $value['doctors__custom_css'] = str_replace('white-text', '', $value['doctors__custom_css'] , $has_white_text);
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
                           $value['doctors__custom_css']);
       $custom_style .= $custom_css ;
   }
   if ('' != $custom_style) {
       $custom_style = 'style="'.$custom_style.'"';
   }
  $class .= ' doctors';
 ?>
<section id="<?php echo $section_id ?>" class="<?php echo $class ?>" <?php echo $custom_style ?> <?php data_interchange($value['background_image']); ?> data-animation-class="<?php echo $animations[$animation_key] ?>" data-admshownr="<?php echo $key+1 ?>">
    
            
            <?php 
            ob_start();
            if (empty($value['doctors__doctors'])){
                $args = array(
                    'post_type' => 'doctor', // string / array
                    'post_status ' => 'publish', // string / array // publish,pending,draft,future,private,trash,any 
                    'posts_per_page' =>  -1, // usually 10
                    
                    
                );    
                // more info https://codex.wordpress.org/Class_Reference/WP_Query    
                $doctors = new WP_Query($args);
                if ($doctors->have_posts()) {
                    $value['doctors__doctors'] = $doctors->posts;
                }
                wp_reset_query();
            } 
            if (!empty($value['doctors__doctors'])) {
             ?>
            <div class="doctors-container">
                
                    <div class="row align-center-middle">
                      
                    <?php foreach ($value['doctors__doctors'] as $poz => $doctor) {
                      ?>
                      
                      <article class="columns small-12 medium-6 large-4 single-doctor-container">
                          <aside class="doctor-thumbnail">
                          <?php if (has_post_thumbnail($doctor->ID)): ?>
                            <?php echo get_the_post_thumbnail( $doctor, 'doctor' ); ?>
                          <?php else: ?>
                            <img src="<?php bloginfo('template_url'); ?>/images/dr_peeterson.jpg" alt="" />  
                          <?php endif ?>
                            
                          </aside> <!-- /.doctor-thumbnail -->
                          <main>
                              <h4><?php echo $doctor->post_title ?></h4>
                              <p class="specialization"><?php echo get_post_meta($doctor->ID,'specialization',true) ?></p> <!-- /.specialization -->
                              <?php echo apply_filters('the_content',$doctor->post_content); ?>
                          </main>
                      </article> <!-- /.columns medium-6 -->
                   
                      <?php
                    } // end foreach  ?>
                    </div> <!-- /.row -->
                
            </div> <!-- /.doctors-container -->
            <?php
              } 
            
            $doctors_content = ob_get_clean();
            ?>
            <div class="row">
              <div class="columns">
                
            <?php 
            if (strpos($value['doctors__content'], '%DOCTORS%') === FALSE) {
                echo $value['doctors__content'];
                echo $doctors_content ;
            } else {
                echo str_replace('%DOCTORS%', $doctors_content, $value['doctors__content']);

            } // end if 
            
            ?>
              </div> <!-- /.columns -->
            </div> <!-- /.row -->
</section>