<section class="when-in-view" >
    <div class="row">
        <div class="columns content">
           

           <?php 
           ob_start();
           if ($value['themes__show_category_filter']) {
                $terms = get_terms( array(
                    'taxonomy' => 'cat',
                    'hide_empty' => false,
                ) );
               ?>
               <ul class="demo-cat-filter">
                   <li><a data-filter="*" href="#all" class="active" >All</a></li>
                   <?php if (!empty($terms)): ?>
                       <?php 
                       foreach ($terms as $p => $term) {
                           ?>
                           <li><a data-filter="<?php echo $term->slug ?>" href="#<?php echo $term->slug ?>"><?php echo $term->name ?></a></li>
                           
                           <?php
                       } // end foreach 
                        ?>
                   <?php endif ?>
               </ul> <!-- /.demo-cat-filter -->
               <?php
           } // end if 
           if (empty($value['themes__themes'])){
               $args = array(
                   'post_type' => 'theme', // string / array
                   'post_status ' => 'publish', // string / array // publish,pending,draft,future,private,trash,any 
                   'posts_per_page' =>  -1, // usually 10
                   
                   
               );    
               // more info https://codex.wordpress.org/Class_Reference/WP_Query    
               $themes = new WP_Query($args);
               if ($themes->have_posts()) {
                   $value['themes__themes'] = $themes->posts;
               }
               wp_reset_query();
           } 
           if (!empty($value['themes__themes'])) {
            ?>
            <div class="row <?php echo $value['themes__show_category_filter'] ? 'demo-container' : ''; ?>">
                <?php foreach ($value['themes__themes'] as $poz => $theme): ?>
                <?php 
                $post_terms_arr = wp_get_post_terms($theme->ID,'cat')    ;
                $post_terms = '';
                if (!empty($post_terms_arr)) {
                    $post_terms = implode(' ', wp_list_pluck( $post_terms_arr, 'slug' ));
                } // end if 
                ?>    
                <div class="columns small-6 medium-4" data-category="<?php echo $post_terms ?>">
                    <div class="demo">
                        <p><a href="<?php echo get_permalink($theme->ID) ?>">
                        <?php if (has_post_thumbnail($theme->ID)): ?>
                             <?php echo get_the_post_thumbnail($theme->ID , 'theme-size' )  ?>
                        <?php else: ?>
                            <img src="<?php bloginfo('template_url'); ?>/images/demo_1.jpg" alt="" />    
                        <?php endif ?><?php echo $theme->post_title ?></a></p>

                    </div> <!-- /.demo -->
                </div> <!-- /.columns small-6 medium-4 -->
                    
                <?php endforeach ?>

            </div> <!-- /.row -->
            <?php } 
            $themes_content = ob_get_clean();?>


            <?php 
            if (strpos($value['themes__content'], '%THEMES%') === FALSE) {
                echo $value['themes__content'];
                echo $themes_content ;
            } else {
                echo str_replace('%THEMES%', $themes_content, $value['themes__content']);

            } // end if 
              ?>
        </div> <!-- /.content -->
    </div> <!-- /.row -->
</section>