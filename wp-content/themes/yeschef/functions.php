<?php

// Define constants.
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT.'/assets/images');



// Frontend styles.
function enqueue_style() {
	wp_enqueue_style('core', THEMEROOT.'/assets/css/styles.min.css?v1', false);
}
add_action('wp_enqueue_scripts', 'enqueue_style');


// Frontend scripts.
function enqueue_scripts() {
	wp_enqueue_script('jquery');
  wp_enqueue_script('custom-script1', 'https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.2.5/polyfill.min.js', array( 'jquery' ), false, true); 
  wp_enqueue_script('custom-script', THEMEROOT.'/assets/js/app.bundle.js?v1', array( 'jquery' ), false, true);
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');



// Gets post cat slug and looks for single-[cat slug].php and applies it
// add_filter('single_template', function($the_template) {

// 	foreach( (array) get_the_category() as $cat ) {
// 		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) {
// 			return TEMPLATEPATH . "/single-{$cat->slug}.php";
// 		}
// 	}
// 	return $the_template;

// });


// Enable thumbnail support for this theme.
add_theme_support('post-thumbnails');

// Add options pages for ACF.
if ( function_exists('acf_add_options_page') ) {

  acf_add_options_page([
    'page_title' => 'Theme Settings'
    , 'menu_title' => 'Promotions'
    , 'menu_slug' => 'theme-general-settings'
    , 'capability'=> 'edit_posts'
    , 'redirect' => true
  ]);

 

}



// Post excerpt settings.
function custom_excerpt_length($length) {
  return 30;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function new_excerpt_more($more) {
  return '&hellip;';
}
add_filter('excerpt_more', 'new_excerpt_more');





function wp1482371_custom_post_type_args( $args, $post_type ) {
  



  if ( $post_type == "post" ) {

  //	echo 'HERE: ' . $post_type;

    $args['rewrite'] = array(
      'slug' => 'blog'
    );
  }

  return $args;
}
add_filter( 'register_post_type_args', 'wp1482371_custom_post_type_args', 20, 2 );







function get_next_order_date()
{

    date_default_timezone_set('Europe/London');
    $date = new DateTime();

    // if date is Friday, Saturday, Sunday, Monday we get next tuesday + 1 otherwise get next tuesday.

    // if date is Sunday PM or Monday we get next tuesday + 1 otherwise get next tuesday.


    $day = $date->format( 'N' );

    // echo'<br/><br/>';
    // $test = $date->format( 'H' );
    // echo "DAY: " . $day . '<br/>';
    // echo "HOUR: " . $test . '<br/>';


    //if($day ==1 || $day == 5 || $day == 6 || $day ==7) // MON, FRI PM, SAT, SUN
    if($day ==1 || $day ==7) // MON, SUN
    {
      // Check if it is SUN AM

      if($day == 7)
      {
        $hour = $date->format( 'H' );


        if($hour >= 12)
          $date->modify('next tuesday +1 week');  
        else
          $date->modify('next tuesday');      
      } else {
        $date->modify('next tuesday +1 week');    
      }

      
    } else {
      $date->modify('next tuesday');  
    }

    return $date;
}



function get_next_order_second_date()
{
  $date = get_next_order_date();
  $date->modify('next thursday');  
  return $date;
}











include_once 'includes/_lockdown.php';
include_once 'includes/_custom-login.php';

include_once 'includes/_global-content.php';

include_once 'includes/_init-menus.php';
include_once 'includes/_init-sidebars.php';
include_once 'includes/_register-custom-post-types.php';
include_once 'includes/_rest-api-fields.php';
include_once 'includes/_meals_report.php';
include_once 'includes/_order_form.php';
