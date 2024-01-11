<?php

// Load Stylesheets
function load_css() {

  wp_register_style(
    'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',
    array(), false, 'all');
  wp_enqueue_style('bootstrap');


  wp_register_style(
    'main', get_template_directory_uri() . '/css/main.css',
    array(), false, 'all');
  wp_enqueue_style('main');


}
add_action('wp_enqueue_scripts', 'load_css');

// Load JavaScript
function load_js() {

  wp_enqueue_script('jquery');

  wp_register_script('bootstrap-scripts', get_template_directory_uri() . '/js/bootstrap.min.js',
  'jquery', false, true);
  wp_enqueue_script('bootstrap-scripts');

}
add_action('wp_enqueue_scripts', 'load_js');


// Theme Options
add_theme_support('menus');
add_theme_support('post-thumbnails');


// Menus
register_nav_menus(

  array(
    'top-menu' => 'Top Menu Location',
    'mobile-menu' => 'Mobile Menu Location',
    'footer-menu' => 'Footer Menu Location',
  )

);


// Custom Image Sizes
add_image_size('blog-large', 800, 400, true);
add_image_size('blog-small', 300, 200, true);

remove_image_size('1536x1536');
remove_image_size('2048x2048');
remove_image_size('medium');
remove_image_size('medium_large');

update_option( 'medium_size_h', 0 );
update_option( 'medium_size_w', 0 );
update_option( 'medium_large_size_w', 0 );
update_option( 'medium_large_size_h', 0 );

function remove_default_image_sizes( $sizes) {
  unset( $sizes['large']); // Added to remove 1024
  unset( $sizes['thumbnail']);
  unset( $sizes['medium']);
  unset( $sizes['medium_large']);
  unset( $sizes['1536x1536']);
  unset( $sizes['2048x2048']);
  return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes', 20);