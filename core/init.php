<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


// general quick functions
require_once get_template_directory().'/core/cod_functions.php';
require_once get_template_directory().'/core/theme_setup.php';
// require_once get_template_directory().'/core/custom_post_types.php'; // disabled by default
// require_once get_template_directory().'/core/custom_taxonomies.php'; // disabled by default
// ACF
// require_once get_template_directory().'/core/acf.php'; // disabled by default
// customize look and feel of wp .... general
require_once get_template_directory().'/core/customize_look.php';
// skin sent emails
require_once get_template_directory().'/core/skin_email.php';
// secure wp
require_once get_template_directory().'/core/cod_secure_wp.php';



// widgets_init
if (file_exists(get_template_directory() . '/core/widgets')) {
	$files = scandir(get_template_directory().'/core/widgets');
	foreach ($files as $index => $file) {
		if (strlen($file) > 4) {
			if (substr($file, 0 , 1 ) != '_' && strtolower(substr($file, -3)) == 'php') { // is php file and not disabled (starts with _)
				include_once get_template_directory().'/core/widgets/'.$file ;
			}
		}
	}
}