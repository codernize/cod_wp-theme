<?php 
if (function_exists('_cod_custom_post_types')) {
    add_action('init', 'cod_faq_post_types');
    
} // end if 
function cod_faq_post_types(){
    $testimonial_labels = array(
          'add_new' => '+ Add faq'
        );
    $faq_args = array(
          
          'show_in_nav_menus'  => false ,
          'publicly_queryable' => true , 
          'menu_position' => 32,
          'public' => false,
          // 'capabilities'=>$capabilities,
          'supports' => array('title'),
          'menu_icon' => 'dashicons-lightbulb'
          
        );

    _cod_custom_post_types('faq',false ,false ,$testimonial_labels ,$faq_args  ) ;
}

add_shortcode( 'faq', 'faq_shortcode' );

function faq_shortcode($atts) {
    $attr = shortcode_atts( array(
        'id' => 1,
        
    ), $atts );
    $faq_list = get_field('faq',$attr['id']);
    $return = '';
    

    if ($faq_list) {
        ob_start();
        $half = ceil(count($faq_list) / 2 );
        ?>
        <div class="row faq">
            
        <div data-accordion-group class="faq-list columns medium-6">
        
        <?php
        foreach ($faq_list as $poz => $faq) {
            if ($poz == $half) {
                ?>
                </div>
                <div data-accordion-group class="faq-list faq-list columns medium-6">
                    
                <?php
            }
            ?>
            <div class="accordion" data-accordion>
                <div data-control><?php echo $faq['question']; ?></div>
                <div data-content><?php echo $faq['answer']; ?></div>
            </div>
            <?php
        }
        ?>
        </div>
        </div> <!-- /.row -->
        
        <?php
            

        

        $return = ob_get_clean();
    }
    return $return;
}