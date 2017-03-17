<?php 
    if (empty($value['section_from_another_page_section']))
        return;
    $temp_field = get_field('sections',$value['section_from_another_page_page']) ;
    $poz = substr($value['section_from_another_page_section'], 0 ,strpos($value['section_from_another_page_section'], '_'));
    $field_key = substr($value['section_from_another_page_section'], strpos($value['section_from_another_page_section'], '_')+1);
    $curent_poz = 1; 
    if (is_array($temp_field) && !empty($temp_field)) {
        
        if (isset($temp_field[$poz]) && $field_key  == $temp_field[$poz]['acf_fc_layout']) {
            $value = $temp_field[$poz] ;
              if ($value['acf_fc_layout'] == 'testimonials') {
                  include 'flexi_'.$value['acf_fc_layout'].  '.php'; //flexi_testimonials_slider and flexi_testimonials_list
                 
              } else {
                  include 'flexi_'.$value['acf_fc_layout'].'.php';
                
              }
        }
    }
?>