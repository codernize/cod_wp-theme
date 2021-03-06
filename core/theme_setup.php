<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Add jQuery
 */
function add_jquery_script() {
    

    //////////////////
    // google fonts //
    //////////////////
    /*wp_enqueue_style( 'google-fonts', 
        '//fonts.googleapis.com/css?family=Lato:400,700', 
        array()
    );*/

    /////////////
    // app.css //
    /////////////
    wp_enqueue_style( 'app-css', 
        get_template_directory_uri() . '/css/app.css', 
        array(),
        1
    );  



    ////////////
    // new js //
    ////////////
    $app_js_dep = array( 'jquery' ) ;
    /*wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
    wp_enqueue_script( 'jquery' );*/
    
    ////////////////
    // foundation //
    ////////////////
    /*wp_enqueue_script(
        'foundation', get_template_directory_uri() . '/js/foundation.js',
        array( 'jquery' ),
        5,
        true
    );  
    $app_js_dep[] = 'foundation';
    */

    ////////////
    // app.js //
    ////////////
    /*wp_enqueue_script(
        'app', get_template_directory_uri() . '/js/app.js',
        $app_js_dep ,
        1,
        true
    );*/
}    
add_action('wp_enqueue_scripts', 'add_jquery_script');



/**
 * TypeKit Fonts
 */
function theme_typekit() {
    wp_enqueue_script( 'theme_typekit', '//use.typekit.net/xxxxxxx.js');
}
// add_action( 'wp_enqueue_scripts', 'theme_typekit' );

function theme_typekit_inline() {
  if ( wp_script_is( 'theme_typekit', 'done' ) ) { ?>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php }
}
// add_action( 'wp_head', 'theme_typekit_inline' );

/**
 * This theme uses wp_nav_menus() for the header menu, utility menu and footer menu.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'codernize' ),
	'footer' => __( 'Footer Menu', 'codernize' ),
	'utility' => __( 'Utility Menu', 'codernize' )
) );

/** 
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * This theme uses post thumbnails
 */
add_theme_support( 'post-thumbnails' );

/**
 *	This theme supports editor styles
 */
// add_editor_style(get_bloginfo('template_url') ."/css/editor.css");

// @ https://tomjn.com/2012/09/10/typekit-wp-editor-styles/
// add typekit in wp editor style
function tomjn_mce_external_plugins($plugin_array){
	$plugin_array['typekit']  =  get_template_directory_uri().'/js/typekit.tinymce.js';
    return $plugin_array;
}
// add_filter("mce_external_plugins", "tomjn_mce_external_plugins");




/**
 * This enables post formats. If you use this, make sure to delete any that you aren't going to use.
 */
//add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video', 'gallery', 'chat', 'link', 'quote', 'status' ) );


/**
 * Register widgetized area and update sidebar with default widgets
 */
function handcraftedwp_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar', 'codernize' ),
		'id' => 'sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s" role="complementary">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'init', 'handcraftedwp_widgets_init' );




// Update CSS within in Admin
function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
  wp_enqueue_script(
  	'admin-js', get_template_directory_uri() . '/js/admin.js',
  	array( 'jquery' )
  );
}
add_action('admin_enqueue_scripts', 'admin_style');



/**
 * Remove Contact Form 7 scripts + styles unless we're on the contact page
 * 
 */
// add_action( 'wp_enqueue_scripts', 'ac_remove_cf7_scripts' );

function ac_remove_cf7_scripts() {
    if ( !is_page('contact') ) {
        wp_deregister_style( 'contact-form-7' );
        wp_deregister_script( 'contact-form-7' );
    }
}


// force medium to crop
if(!get_option("medium_crop"))
    add_option("medium_crop", "1");
else
    update_option("medium_crop", "1");