<?php

// Define constants.
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT.'/assets/images');



// Frontend styles.
function enqueue_style() {
	wp_enqueue_style('core', THEMEROOT.'/assets/css/styles.min.css?v3', false);
}
add_action('wp_enqueue_scripts', 'enqueue_style');


// Frontend scripts.
function enqueue_scripts() {
	wp_enqueue_script('jquery');

  wp_enqueue_script('custom-script1', 'https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.2.5/polyfill.min.js', array( 'jquery' ), false, true);

	wp_enqueue_script('custom-script', THEMEROOT.'/assets/js/app.bundle.js?v10', array( 'jquery' ), false, true);
  wp_enqueue_script('slider', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', array( 'jquery' ), false, true);
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





function checkRedirect() {
  
  global $wpdb;

  $parts = explode('/', $_SERVER['REQUEST_URI']);

  if (isset($parts[2]) && $parts[1] == 'jobapply') {
    
    $index = $parts[2];

    if (is_numeric($index)) {
      $meta_value = $index;

      $r = $wpdb->get_row("SELECT post_id FROM as_postmeta where meta_key ='job_ref' and meta_value = " . $meta_value . ' limit 1');

      if ($r) {
        wp_redirect(get_permalink($r->post_id));
      }

    }
  }
}
add_action('wp', 'checkRedirect');









function get_backlink($posttype)
{

  switch ($posttype) {
    case 'nsm_case_study_post':
      return '<a href="' . site_url().'/case-studies/">Back to case studies</a>';
      break;
    
    default:
      return '<a href="' . site_url().'/industry-news/">Back to industry news</a>';
      break;
  }

}

function get_more_heading($posttype)
{

  switch ($posttype) {
    case 'nsm_case_study_post':
      return 'Read more case studies';
      break;
    
    default:
      return 'Read more news';
      break;
  }

}



function get_post_default_category($id, $posttype)
{
    
    $category='';
    $taxonomy = '';
  
    switch ($posttype) {
      case 'nsm_case_study_post':
      $taxonomy = 'nsm_cs_categories';
      break;
    
    default:
      $taxonomy = 'category';
      break;
    }

    //echo $posttype;

    $categories = get_the_terms($id,$taxonomy);
    
    if($categories) {
      $category = $categories[0]->name;
    }

    return $category;
}



function get_related_articles($posttype)
{


  global $wpdb;

  // $cat1_cats = (wp_get_post_terms( $postid, 'cat1_cats')); 
  // $cat2_cats = (wp_get_post_terms( $postid, 'cat2_cats'));


  // $tax_query = array();

  // if($cat1_cats){
  //   $params['cat1_cats'] = $cat1_cats[0]->term_taxonomy_id;
  //   $tax_query[] = buildCategoriesSearch('cat1_cats',$params);
  // }

  // if($cat2_cats){
  //   $params['cat2_cats'] = $cat2_cats[0]->term_taxonomy_id;
  //   $tax_query[] = buildCategoriesSearch('cat2_cats',$params);
  // }

    

  $args = array( 'posts_per_page' => 3
      ,'post_status' => 'publish'
      ,'post_type'=>$posttype
//      ,'tax_query' =>$tax_query
      ,'exclude' => array( $postid ) 
      ,'orderby' => 'rand'
      ,'order' => 'asc'
  );

  $posts = get_posts($args);

  return $posts;

}


function add_application_form_question_fields($additional_questions) {


    $additional_questions = unserialize($additional_questions);

    

    foreach ($additional_questions as $question) {
      
        $question_label = $question['question'];   

       

        $question_found = false;

        $form = GFAPI::get_form( 2 );

        // Check to see whether question exists in form
        foreach($form['fields'] as $field)
        {
            if($question_label == $field['label'])
            {
                $question_found = true;
                break;
            }            
        }         

        if(!$question_found) {

            // Create new form field

            $new_field_id = $form['nextFieldId'];
             $properties['type'] = 'radio';
             $properties['id'] = $new_field_id;
             $properties['label'] = $question_label;
             $properties['default_value'] = 'N/A';
             $properties['horizontal'] = true;
             $properties['isRequired'] = true;

             //echo print_r($question['answers']);

             $choices = array();
             foreach ($question['answers'] as $answer) {
                $choices[] = array( 'text' => (string) $answer );
             }

             $properties['choices'] = $choices; //array( array( 'text' => 'choice1', 'value' => 1 ), array( 'text' => 'choice2', 'value' => 1 ));

          
             $field = GF_Fields::create( $properties );
             $form['fields'][] = $field;
        
             GFAPI::update_form( $form );

        }

    }

}


add_filter( 'gform_pre_render_2', 'hide_fields' );
function hide_fields($form) {


  // Global $post;
  // echo print_r($post);

  $additional_questions = unserialize(get_post_meta(get_the_ID(),'questions',true));
 // echo print_r($additional_questions);

  
  foreach( $form['fields'] as $k => &$field )  {
    
    
    if($field['type'] == 'radio')
    {

      $addition_question_found = false;

      foreach ($additional_questions as $question) {
              
        $question_label = $question['question'];   

        //if($field['label'] == $question_label && $question_label!='Do you hold a current SIA licence?')
        if($field['label'] == $question_label)
        {
          $addition_question_found=true;
          break;
        }

      }

      if(!$addition_question_found) {

          // Remove from form if not required.
          //$field['visibility'] = 'administrative';
           // $field['type'] = 'hidden';
           // $field['default_value'] = 'N/A';
          unset($form['fields'][$k]); 
      }

    }

  

  }

  return $form;

}




// This function has to 

add_filter( 'gform_validation_2', 'skip_hidden_fields' );
function skip_hidden_fields($validation_result)
{
  

  $additional_questions = unserialize(get_post_meta(get_the_ID(),'questions',true));



  $form = $validation_result['form'];

  // reset this to true, and set it to false if either a required normal field fails or an additional question that should be asked does not have a value.
  $validation_result['is_valid'] = true;


  foreach( $form['fields'] as &$field ) {


    if ( $field['type'] != 'radio' && $field['failed_validation'] == true) {
      $validation_result['is_valid'] = false;
    }
     
    if ( $field['type'] == 'radio' ) {

      $addition_question_found = false;

        foreach ($additional_questions as $question) {
              
          $question_label = $question['question'];   

//          if($field['label'] == $question_label && $question_label!='Do you hold a current SIA licence?')
          if($field['label'] == $question_label)
          {
          
            //  $data_str = print_r(  $field, true );
            // error_log( $data_str );

            // Question should be on form so check its valid.

            if($field['failed_validation'] == true) {
              $validation_result['is_valid'] = false;
            }

            $addition_question_found=true;
            break;
          }

        }


        // If addiiotnal question is not found in form then we can skip validation on this item as is 
        // acutally hidden on form and does not need checking.
        if(!$addition_question_found) {
          
          
          $field['failed_validation'] = '';
          $field['validation_message'] = '';

          // $data_str = print_r(  $field, true );
          // error_log( $data_str );

          continue;

        }
        
    }

  }

  $validation_result['form'] = $form;
  return $validation_result;

}


// Includes

include_once 'includes/_lockdown.php';
include_once 'includes/_custom-login.php';

include_once 'includes/_global-content.php';
include_once 'includes/_init-menus.php';
include_once 'includes/_init-sidebars.php';
include_once 'includes/_register-custom-post-types.php';
include_once 'includes/_rest-api-fields.php';
