<?php
function scripts_and_styles_method() {

  $templateuri = get_template_directory_uri() . '/js/';

  // library.js is to bundle plugins. my.js is your scripts. enqueue more files as needed
  $jslib = $templateuri . 'library.js';
  wp_enqueue_script( 'jslib', $jslib,'','',true);

  $myscripts = WP_DEBUG ? $templateuri . "main.js" : $templateuri . "main.min.js";
  wp_register_script( 'myscripts', $myscripts );

  $is_admin = current_user_can('administrator') ? 1 : 0;
  $jsVars = array(
  	'siteUrl' => home_url(),
  	'themeUrl' => get_template_directory_uri(),
  	'isAdmin' => $is_admin,
  );

  wp_localize_script( 'myscripts', 'WP', $jsVars );
  wp_enqueue_script( 'myscripts', $myscripts,'','',true);

  // enqueue stylesheet here. file does not exist until stylus file is processed
  wp_enqueue_style( 'site', get_stylesheet_directory_uri() . '/css/site.css' );

  // dashicons for admin
  if(is_admin()){
    wp_enqueue_style( 'dashicons' );
  }

}
add_action('wp_enqueue_scripts', 'scripts_and_styles_method');

if( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}


if( function_exists( 'add_image_size' ) ) {
  //add_image_size( 'admin-thumb', 150, 150, false );
  //add_image_size( 'opengraph', 1200, 630, true );

  add_image_size( 'medium_large', 600, 9999, false );
}


// Register Nav Menus
/*
register_nav_menus( array(
	'menu_location' => 'Location Name',
) );
*/

// update_option image sizes
add_filter( 'pre_update_option_thumbnail_size_w', 'Ouli_theme_filter_thumbnail_size_w' );
function Ouli_theme_filter_thumbnail_size_w( $newvalue ) {
  return 180;
}
add_filter( 'pre_update_option_thumbnail_size_h', 'Ouli_theme_filter_thumbnail_size_h' );
function Ouli_theme_filter_thumbnail_size_h( $newvalue ) {
  return 9999;
}
add_filter( 'pre_update_option_thumbnail_crop', 'Ouli_theme_filter_thumbnail_crop' );
function Ouli_theme_filter_thumbnail_crop( $newvalue ) {
  return 0;
}
add_filter( 'pre_update_option_medium_size_w', 'Ouli_theme_filter_medium_size_w' );
function Ouli_theme_filter_medium_size_w( $newvalue ) {
  return 300;
}
add_filter( 'pre_update_option_medium_size_h', 'Ouli_theme_filter_medium_size_h' );
function Ouli_theme_filter_medium_size_h( $newvalue ) {
  return 9999;
}
add_filter( 'pre_update_option_medium_large_size_w', 'Ouli_theme_filter_medium_large_size_w' );
function Ouli_theme_filter_medium_large_size_w( $newvalue ) {
  return 600;
}
add_filter( 'pre_update_option_medium_large_size_h', 'Ouli_theme_filter_medium_large_size_h' );
function Ouli_theme_filter_medium_large_size_h( $newvalue ) {
  return 9999;
}
add_filter( 'pre_update_option_large_size_w', 'Ouli_theme_filter_large_size_w' );
function Ouli_theme_filter_large_size_w( $newvalue ) {
  return 900;
}
add_filter( 'pre_update_option_large_size_h', 'Ouli_theme_filter_large_size_h' );
function Ouli_theme_filter_large_size_h( $newvalue ) {
  return 9999;
}

get_template_part( 'lib/gallery' );
get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );
get_template_part( 'lib/theme-options' );

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {
  // Add CMB2 plugin
  if( ! class_exists( 'cmb2_bootstrap_202' ) )
    require_once 'lib/CMB2/init.php';
}

// Remove WP Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Disable that freaking admin bar
add_filter('show_admin_bar', '__return_false');

// Turn off version in meta
function no_generator() { return ''; }
add_filter( 'the_generator', 'no_generator' );

// Show thumbnails in admin lists
add_filter('manage_posts_columns', 'new_add_post_thumbnail_column');
function new_add_post_thumbnail_column($cols){
  $cols['new_post_thumb'] = __('Thumbnail');
  return $cols;
}
add_action('manage_posts_custom_column', 'new_display_post_thumbnail_column', 5, 2);
function new_display_post_thumbnail_column($col, $id){
  switch($col){
    case 'new_post_thumb':
    if( function_exists('the_post_thumbnail') ) {
      echo the_post_thumbnail( 'thumbnail' );
      }
    else
    echo 'Not supported in theme';
    break;
  }
}

// remove automatic <a> links from images in blog
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

// Clean site desc. after theme activation
function clean_site_blog_info() {
  $old  = get_option('blogdescription');
  if ( $old == 'Just another WordPress site' || $old == 'Otro sitio realizado con WordPress' ) {
    update_option( 'blogdescription', '' );
  }
}
add_action( 'after_setup_theme', 'clean_site_blog_info' );

// custom login logo
/*
function custom_login_logo() {
  echo '<style type="text/css">h1 a { background-image:url(' . get_bloginfo( 'template_directory' ) . '/images/login-logo.png) !important; background-size:300px auto !important; width:300px !important; }</style>';
}
add_action( 'login_head', 'custom_login_logo' );
*/

// UTILITY FUNCTIONS

// to replace file_get_contents
function url_get_contents($Url) {
  if (!function_exists('curl_init')){
      die('CURL is not installed!');
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $Url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

// get ID of page by slug
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if($page) {
		return $page->ID;
	} else {
		return null;
	}
}
// is_single for custom post type
function is_single_type($type, $post) {
  if (get_post_type($post->ID) === $type) {
    return true;
  } else {
    return false;
  }
}

// print var in <pre> tags
function pr($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

// Debug page and template request
function debug_page_request() {
  global $wp, $template;
  define("D4P_EOL", "\r\n");
  echo '<!-- Request: ';
  echo empty($wp->request) ? "None" : esc_html($wp->request);
  echo ' -->'.D4P_EOL;
  echo '<!-- Matched Rewrite Rule: ';
  echo empty($wp->matched_rule) ? None : esc_html($wp->matched_rule);
  echo ' -->'.D4P_EOL;
  echo '<!-- Matched Rewrite Query: ';
  echo empty($wp->matched_query) ? "None" : esc_html($wp->matched_query);
  echo ' -->'.D4P_EOL;
  echo '<!-- Loaded Template: ';
  echo basename($template);
  echo ' -->'.D4P_EOL;
}

function get_random_image_size() {
  $sizes = (array) get_intermediate_image_sizes();
  return $sizes[array_rand( $sizes )];
}

function RemoveAddMediaButtons(){
  remove_action( 'media_buttons', 'media_buttons' );
}
add_action('admin_head', 'RemoveAddMediaButtons');

?>
