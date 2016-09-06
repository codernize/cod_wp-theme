<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


// login header url
add_filter('login_headerurl', 'cod_login_headerurl') ;
function cod_login_headerurl($url) {
  return site_url().'/';
}

// disable pass reset
add_filter ( 'allow_password_reset', 'disable_password_reset' );
function disable_password_reset() { return false; }

// hide message for login errors
add_filter('login_errors',create_function('$a', "return 'Sorry...and I mean it';"));

cod_remove_comments();
function cod_remove_comments(){

	// Disable support for comments and trackbacks in post types
	function df_disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}
	add_action('admin_init', 'df_disable_comments_post_types_support');

	// Close comments on the front-end
	function df_disable_comments_status() {
		return false;
	}
	add_filter('comments_open', 'df_disable_comments_status', 20, 2);
	add_filter('pings_open', 'df_disable_comments_status', 20, 2);

	// Hide existing comments
	function df_disable_comments_hide_existing_comments($comments) {
		$comments = array();
		return $comments;
	}
	add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

	// Remove comments page in menu
	function df_disable_comments_admin_menu() {
		remove_menu_page('edit-comments.php');
	}
	add_action('admin_menu', 'df_disable_comments_admin_menu');

	// Redirect any user trying to access comments page
	function df_disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url()); exit;
		}
	}
	add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

	// Remove comments metabox from dashboard
	function df_disable_comments_dashboard() {
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	}
	add_action('admin_init', 'df_disable_comments_dashboard');

	// Remove comments links from admin bar
	function df_disable_comments_admin_bar() {
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	}
	add_action('init', 'df_disable_comments_admin_bar');

	// Disable X-Pingback HTTP Header.
	add_filter('wp_headers', function($headers, $wp_query){
	    if(isset($headers['X-Pingback'])){
	        // Drop X-Pingback
	        unset($headers['X-Pingback']);
	    }
	    return $headers;
	}, 11, 2);
	// Disable XMLRPC by hijacking and blocking the option.
	add_filter('pre_option_enable_xmlrpc', function($state){
	    return '0'; // return $state; // To leave XMLRPC intact and drop just Pingback
	});
	// Remove rsd_link from filters (<link rel="EditURI" />).
	add_action('wp', function(){
	    remove_action('wp_head', 'rsd_link');
	}, 9);
	// Hijack pingback_url for get_bloginfo (<link rel="pingback" />).
	add_filter('bloginfo_url', function($output, $property){
	    return ($property == 'pingback_url') ? null : $output;
	}, 11, 2);
	// Just disable pingback.ping functionality while leaving XMLRPC intact?
	add_action('xmlrpc_call', function($method){
	    if($method != 'pingback.ping') return;
	    wp_die(
	        'Pingback functionality is disabled on this Blog.',
	        'Pingback Disabled!',
	        array('response' => 403)
	    );
	});



	// https://codex.wordpress.org/Function_Reference/remove_node
	add_action( 'admin_bar_menu', 'remove_wp_logo_and_comments', 999 );

	function remove_wp_logo_and_comments( $wp_admin_bar ) {
	  $wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_node( 'comments' );
	}
}

