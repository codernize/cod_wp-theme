<?php 




add_filter('acf/load_field/name=section_from_another_page_section', 'cod_get_page_section_list');

function cod_get_page_section_list( $field ){
    global $wpdb;
    
    if (isset($_GET['post']) && $_GET['post'] == absint($_GET['post'])) {
        $post_id = $_GET['post'] ;
        $post_type = $wpdb->get_var($wpdb->prepare("SELECT post_type FROM {$wpdb->posts} WHERE ID = %d",$post_id));
        if (!in_array($post_type, ['page','service'])) { // we do need services to do the same thing
            return $field;
        }
    } else {
        return $field;
    }

    global $COD_FIELD_POZ;
    if (!isset($COD_FIELD_POZ)) {
        $COD_FIELD_POZ = 1;
    } else {
        $COD_FIELD_POZ ++ ;
    }

    $sections = get_post_meta($post_id,'sections', true );


    if (!empty($sections)) {
        $current_poz = 1; 
        foreach ($sections as $index => $value) {
            if ($value == 'section_from_another_page') {
                if ($current_poz == $COD_FIELD_POZ) {
                    $this_selected_page_id = get_post_meta($post_id,'sections_'.$index.'_section_from_another_page_page',true);
                    
                    $page_sections = get_post_meta($this_selected_page_id,'sections',true) ;
                    $page_sections = array_diff($page_sections, array('section_from_another_page')) ;
                    $field['choices'] = array();
                    $unique_value = array();

                    foreach ($page_sections as $pgs_key => $pgs_value) {
                        $field_name = isset($global_ACF_field[$pgs_value]) ? $global_ACF_field[$pgs_value] : str_replace(array('_','-'), array(' ',' '), $pgs_value) ;
                        $field_name = ($pgs_key + 1 ) . '. '. ucfirst($field_name);
                        if (in_array($pgs_value,$unique_value)) {
                            $temp_count_values = array_count_values($unique_value);
                            $field_name .= ' ('. ($temp_count_values[$pgs_value] + 1).')' ;
                        }
                        $unique_value[] = $pgs_value ;
                        $field['choices'][$pgs_key.'_'.$pgs_value] = $field_name ;
                    }
                    break ; 
                } else {
                    $current_poz ++ ;
                }
            }
        }
    }
    return $field;
}