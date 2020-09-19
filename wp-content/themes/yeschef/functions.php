<?php

// Define constants.
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT.'/assets/images');



// Frontend styles.
function enqueue_style() {
	wp_enqueue_style('core', THEMEROOT.'/assets/css/styles.min.css?v7', false);
}
add_action('wp_enqueue_scripts', 'enqueue_style');


// Frontend scripts.
function enqueue_scripts() {
	wp_enqueue_script('jquery');

  wp_enqueue_script('custom-script1', 'https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.2.5/polyfill.min.js', array( 'jquery' ), false, true);
	wp_enqueue_script('custom-script', THEMEROOT.'/assets/js/app.bundle.js?v5', array( 'jquery' ), false, true);
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
    , 'menu_title' => 'Theme Settings'
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



add_filter( 'gform_pre_render_1', 'my_populate_promotion' );
function my_populate_promotion( $form ) {

    $promotion_active = get_field('promotion_active','option');
    if($promotion_active)
    {

      $promotion_heading = get_field('order_page_promotion_heading','option');
      $promotion_subheading = get_field('order_page_promotion_sub-heading','option');
      $promotion_button_text = get_field('order_page_select_button_text','option');

      foreach( $form['fields'] as &$field ) {    

      // If one of the meal options then set the options to these meals
        if( 27 === $field->id) {

          $field->content = '<div class="promotion">';

          if($promotion_heading)
            $field->content .= '<h2>'.$promotion_heading.'</h2>';

          if($promotion_subheading)
            $field->content .= '<p>'.$promotion_subheading.'</p>';

          $field->content .='<a href="#" class="button button--dark-blue" onclick="populate_promotional_meals();return false;">'.$promotion_button_text.'</a>';

          $field->content .='</div>';
        }
      }
    }

    return $form;
}


add_filter( 'gform_pre_render_1', 'my_populate_checkbox' );
add_filter( 'gform_admin_pre_render_1', 'my_populate_checkbox' );
function my_populate_checkbox( $form ) {
  
  // Loop through form fields


  // Get published meals - which are available this week.
  $args = array(
    'post_type' => 'nsm_meals',
    'post_status' => 'publish',
    'orderby' => 'title',
    'order' => 'asc',
    'posts_per_page' => '99999',
    'taxonomy' => 'nsm_meal_order_date',
    'term' => '2020/09/29'
  );
 

  $pie_choices[] = array( 'text' => "No thanks, not this week", 'value' => "No thanks, not this week" );

  $the_query = new WP_Query( $args );

  while ( $the_query->have_posts() ) : $the_query->the_post();

    $meal_choices[] = array( 'text' => get_the_title(), 'value' => get_the_title() );

    $pie_option = get_post_meta(get_the_ID(), 'lazy_day_pie_option');
    


    if(isset($pie_option ) && $pie_option[0] == 'Yes') {
      $content = get_the_title() . '  (' . get_post_meta(get_the_ID(), 'lay_day_pie_option_price', true) .')';
      $pie_choices[] = array( 'text' => $content, 'value' => $content );
    }

  endwhile; 




  // Get additional items
  $args = array(
    'post_type' => 'nsm_additional_items',
    'post_status' => 'publish',
    'orderby' => 'title',
    'order' => 'asc',
    'posts_per_page' => '99999'

  );
 
  $the_query = new WP_Query( $args );

  while ( $the_query->have_posts() ) : $the_query->the_post();

    $content = get_the_title() . '  (' . get_post_meta(get_the_ID(), 'price', true) .')';
    $additional_items[] = array( 'text' => $content, 'value' => $content );

  endwhile; 

     


  foreach( $form['fields'] as &$field ) {    


    // If one of the meal options then set the options to these meals
    if( 5 === $field->id || 6 === $field->id || 7 === $field->id || 8 === $field->id) {
      
      $field->choices = $meal_choices;
      
    }

    if( 10 === $field->id || 11 === $field->id) {
      
      $field->choices = $pie_choices;
      
    }

    if( 13 === $field->id) {
      
      $field->choices = $additional_items;
      
    } 



  } 
  
  return $form;

} 




// Order by Date Posted 
add_filter( 'rest_nsm_meals_query', function ( $query_vars, $request ) {

  $query_vars['orderby'] = 'menu_order';
  $query_vars['order'] = 'ASC';

  return $query_vars;
}, 10, 2);





add_filter( 'gform_field_value', 'populate_fields', 10, 3 );
function populate_fields( $value, $field, $name ) {
  
     
  // Populating fields from cookies if they exist for 

    $values = array(
      'order_name' => isset($_COOKIE["gf_order_name"]) ? $_COOKIE["gf_order_name"] : '',
      'order_email' => isset($_COOKIE["gf_order_email"]) ? $_COOKIE["gf_order_email"] : '',
      'order_phone' => isset($_COOKIE["gf_order_phone"]) ? $_COOKIE["gf_order_phone"] : '',
      'order_postcode' => isset($_COOKIE["gf_order_postcode"]) ? $_COOKIE["gf_order_postcode"] : '',
      'order_address' => isset($_COOKIE["gf_order_address"]) ? $_COOKIE["gf_order_address"] : ''
    );
 
    return isset( $values[ $name ] ) ? $values[ $name ] : $value;
}





add_action( 'gform_after_submission_1', 'set_form_cookies', 10, 2 );
function set_form_cookies( $entry, $form ) {
  
    setcookie('gf_order_name', $entry['15'], time() + 1209600, '/' );
    setcookie('gf_order_email', $entry['16'], time() + 1209600, '/' );
    setcookie('gf_order_phone', $entry['17'], time() + 1209600, '/' );
    setcookie('gf_order_postcode', $entry['18'], time() + 1209600, '/' );
    setcookie('gf_order_address', $entry['25'], time() + 1209600, '/' );
}


add_filter( 'gform_confirmation_1', 'custom_confirmation_message', 10, 4 );
function custom_confirmation_message( $confirmation, $form, $entry, $ajax ) {
    
   


    $html = '<p class="heading">Order Number: ' . $entry['id'] . '</p>';

    $html .= '<p class="heading">Box size:</p><p>' . $entry['2'] . '</p>';

    $html .= '<p class="heading">4 meal choices:</p><p>' . $entry['5'] . '</p><p>' . $entry['6'] . '</p><p>' . $entry['7'] . '</p><p>' . $entry['8'] . '</p>';

    if($entry['10'] != 'No thanks, not this week' || $entry['11'] != 'No thanks, not this week')
    { 
      $html .= '<p class="heading">Extra Lazy Day pies</p><p>Pie 1: ' . $entry['10'] . '</p><p>Pie 2: ' . $entry['11'] . '</p>';
    }


   
    
    
      $additional_items = '';
     foreach( $entry as $key => $value ) {
      
        if(substr($key, 0, 3) == '13.')
          if($value!='')
            $additional_items .= '<p>' . $value . '</p>';      
      }

      
      if($additional_items!='')
      {
        $additional_items = '<p class="heading">YesChef Junior Items</p>' . $additional_items;
      }

      $html .= $additional_items;

       $html .= '<p class="heading">Contact Details</p><p>' . $entry['15'] . '</p><p>' . $entry['16'] . '</p><p>' . $entry['17'] . '</p><p>' . $entry['25'] . '</p><p>' . $entry['18'] . '</p><p>' . $entry['26'] . '</p>';


    return str_replace("XXX", $html, $confirmation);
}


add_filter( 'gform_validation_message_1', 'change_message', 10, 2 );
function change_message( $message, $form ) {
    return '<div class="validation_error">There was a problem with your order.  Please review the highlighted fields.</div>';
}




function get_next_order_date()
{
  $date = new DateTime();

    // if date is Friday, Saturday, Sunday, Monday we get next tuesday + 1 otherwise get next tuesday.
    $day = $date->format( 'N' );


    if($day ==1 || $day == 5 || $day == 6 || $day ==7) // MON, FRI PM, SAT, SUN
    {
      // Check if it is friday AM

      if($day == 5)
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


include_once 'includes/_lockdown.php';
include_once 'includes/_custom-login.php';

include_once 'includes/_global-content.php';
include_once 'includes/_meals_report.php';
include_once 'includes/_init-menus.php';
include_once 'includes/_init-sidebars.php';
include_once 'includes/_register-custom-post-types.php';
include_once 'includes/_rest-api-fields.php';
