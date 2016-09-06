<?php
/**
 * @package WordPress
 * @subpackage codernize
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
// load_theme_textdomain( 'codernize', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

require_once 'core/init.php';