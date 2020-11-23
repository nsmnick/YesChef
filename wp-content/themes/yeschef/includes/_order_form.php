<?php



//
//
//Order Form Fields Form 5
//
//





//
// Populates order form with available orders, active promotions, additional items, including seasonal items
//


add_filter( 'gform_pre_render_5', 'my_configure_order_form' );
function my_configure_order_form( $form ) {


    // Constants

    $form_field_box_sizes_id = 37;
    $form_field_seasonal_heading_id = 51;
    $form_field_promotion_single_week = 27;
    $form_field_promotion_four_week = 54;
    

    // Available Meals


    // Get next order date so we can get meals for this week
    $next_order_date = get_next_order_date()->format('Y/m/d');

    // Get published meals - which are available this week.
    $args = array(
      'post_type' => 'nsm_meals',
      'post_status' => 'publish',
      'orderby' => 'title',
      'order' => 'asc',
      'posts_per_page' => '99999',
      'taxonomy' => 'nsm_meal_order_date',
      'term' => $next_order_date
    );
   

    
    $the_query = new WP_Query( $args );

    if ( $the_query->found_posts > 0 ) {

      while ( $the_query->have_posts() ) : $the_query->the_post();

        $price =0;
        $supplement_price_label = get_post_meta(get_the_ID(), 'supplement_price', true);
        $supplement_price_value = get_post_meta(get_the_ID(), 'supplement_price_value', true);

        $title = get_the_title();

        if($supplement_price_label !='' && $supplement_price_value != 0)
        {
          $title .= ' ' . $supplement_price_label;
          $price = $supplement_price_value;
        }

     
        $meal_choices_for_2[] = array( 'text' => $title, 'value' => $title, 'price'=>(int)$price * 2 );
        $meal_choices_for_4[] = array( 'text' => $title, 'value' => $title, 'price'=>(int)$price * 4 );


      endwhile; 


      // Update meal fields with available neals    

      foreach( $form['fields'] as &$field ) {    

        // If one of the meal options then set the options to these meals
        if( 38 === $field->id || 40 === $field->id || 41 === $field->id || 42 === $field->id) {      
          $field->choices = $meal_choices_for_2;
        }

         if( 44 === $field->id || 46 === $field->id || 47 === $field->id || 45 === $field->id) {      
          $field->choices = $meal_choices_for_4;
        }

        

      } 
      
    }



    




    // Website promotion Fields

    $promotion_active = get_field('promotion_active','option');
    if($promotion_active)
    {


      $formfieldkey = getKeyFromFieldID($form['fields'], $form_field_box_sizes_id);
      //$boxesformfield = $form['fields'][$formfieldkey];
      //echo print_r($boxesformfield);

      $order_option_text_for_2_people = '1 weekly set box for 2 people';
      $order_option_text_for_2_people_caption = $order_option_text_for_2_people . '<span class="radio-lb">' . get_field('order_option_text_for_2_people','option') . '</span>';
      
      $order_option_text_for_4_people = '1 weekly set box for 4 people';
      $order_option_text_for_4_people_caption = $order_option_text_for_4_people. '<span class="radio-lb">' . get_field('order_option_text_for_4_people','option') . '</span>';

      $price_for_2_people_option = get_field('price_for_2_people_option','option');
      $price_for_4_people_option = get_field('price_for_4_people_option','option');

      // Add promotional offers to box sizes

      if($formfieldkey != 0 && $order_option_text_for_2_people!='' && $order_option_text_for_4_people!='' && $price_for_2_people_option!='' && $price_for_4_people_option!='')
      {
        
        $promotion_choices1 = array( 'text' => $order_option_text_for_2_people_caption, 'value' => $order_option_text_for_2_people, 'price'=>$price_for_2_people_option );
        $promotion_choices2 = array( 'text' => $order_option_text_for_4_people_caption, 'value' => $order_option_text_for_4_people, 'price'=>$price_for_4_people_option );

        $form['fields'][$formfieldkey]->choices[] = $promotion_choices1;
        $form['fields'][$formfieldkey]->choices[] = $promotion_choices2;
      }



    }




    // Add 4 week set box meals
    $general_promotion_active = get_field('general_promotion_active','option');

    if($general_promotion_active)
    {

      $formfieldkey = getKeyFromFieldID($form['fields'], $form_field_box_sizes_id);

      $general_order_order_option_text_for_2_people = '4 weeks of set boxes for 2 people';
      $general_order_order_option_text_for_2_people_caption = $general_order_order_option_text_for_2_people.'<span class="radio-lb">' . get_field('general_order_order_option_text_for_2_people','option') . '</span>';

      $general_order_order_option_text_for_4_people = '4 weeks of set boxes for 4 people';
      $general_order_order_option_text_for_4_people_caption = $general_order_order_option_text_for_4_people. '<span class="radio-lb">' . get_field('general_order_order_option_text_for_4_people','option') . '</span>';

      $general_order_price_for_2_people_option = get_field('general_order_price_for_2_people_option','option');
      $general_order_price_for_4_people_option = get_field('general_order_price_for_4_people_option','option');

      if($formfieldkey != 0 && $general_order_order_option_text_for_2_people!='' && $general_order_order_option_text_for_4_people!='' && $general_order_price_for_2_people_option!='' && $general_order_price_for_4_people_option!='')
      {

        $go_choices1 = array( 'text' => $general_order_order_option_text_for_2_people_caption, 'value' => $general_order_order_option_text_for_2_people, 'price'=>$general_order_price_for_2_people_option );
        $go_choices2 = array( 'text' => $general_order_order_option_text_for_4_people_caption, 'value' => $general_order_order_option_text_for_4_people, 'price'=>$general_order_price_for_4_people_option );

        $form['fields'][$formfieldkey]->choices[] = $go_choices1;
        $form['fields'][$formfieldkey]->choices[] = $go_choices2;

      }



    }


    

    // Populate for promotion messages

    if($promotion_active)
    {
      // Website Promotion Single Week
      $promotion_heading = get_field('order_page_promotion_heading','option');
      $promotion_subheading = get_field('order_page_promotion_sub-heading','option');
      
      $formfieldkey = getKeyFromFieldID($form['fields'], $form_field_promotion_single_week);


      $content = '<div class="promotion">';

      if($promotion_heading)
        $content .= '<h2>'.$promotion_heading.'</h2>';

      if($promotion_subheading)
        $content .= '<p>'.$promotion_subheading.'</p>';

      $content .='</div>';

      $form['fields'][$formfieldkey]->content = $content;


    } else {

        $formfieldkey = getKeyFromFieldID($form['fields'], $form_field_promotion_single_week);
        unset($form['fields'][$formfieldkey]); 
    }


    // TEST AND DO THE SAME FOR GENERAL PROMOTIONS


    if($general_promotion_active) {
    
      // Website promotion - 4 weeks
      $general_order_page_promotion_heading = get_field('general_order_page_promotion_heading','option');
      $general_order_page_promotion_sub_heading = get_field('general_order_page_promotion_sub_heading','option');
      $general_order_page_promotion_content = get_field('general_order_page_promotion_content','option');
        
      $formfieldkey = getKeyFromFieldID($form['fields'], $form_field_promotion_four_week);


      $content = '<div class="promotion">';

      if($general_order_page_promotion_heading)
        $content .= '<h2>'.$general_order_page_promotion_heading.'</h2>';

      if($general_order_page_promotion_sub_heading)
        $content .= '<p>'.$general_order_page_promotion_sub_heading.'</p>';

      if($general_order_page_promotion_content)
        $content .= '<p>'.$general_order_page_promotion_content.'</p>';

      $content .='</div>';


      $form['fields'][$formfieldkey]->content = $content;

    } else {
       
        $formfieldkey = getKeyFromFieldID($form['fields'], $form_field_promotion_four_week);
        unset($form['fields'][$formfieldkey]); 

    }
  



    // Hide additional Items that are not published any longer, we keep the items in the form so that they old data in the data entry section can still be viewed.



    // Get published additional items (Including season and determine whether they should be visible or not)
    

    $show_seasonal_options = get_field('show_seasonal_options','option');
    $seasonal_option_category = get_field('seasonal_option_category','option');
    $seasonal_section_heading = get_field('seasonal_section_heading','option');



    $args = array(
      'post_type' => 'nsm_additional_items',
      'post_status' => 'publish',
      'posts_per_page' => '99999',
      // 'tax_query' => array(
      //     array(
      //         'taxonomy' => 'nsm_additional_items_categories', 
      //         'field'    => 'slug',
      //         'terms'    => 'standard',
      //     ),
      //  ),
       

    );
   
    $query = new WP_Query( $args );
    $additional_items = $query->posts;


    // Check each form field.  If an additionl item field then check to see if it is published
    foreach( $form['fields'] as $k => &$field ) { 

      $form_field_prefix = 'additems_';


      if($form_field_prefix == substr($field['inputName'],0,9))
      {

          $form_field_id = substr($field['inputName'],9);

          $field_found=false;
          $hide_field=false;

          foreach ($additional_items as $additional_item) {
            
            if($form_field_id == $additional_item->ID)
            {

              $field_found=true;  
              $field['label'] = $additional_item->post_title;
              $field['basePrice'] = get_post_meta($additional_item->ID, 'price', true);

              // if additional item a seasonal item or not

              $additional_item_category_slug = '';
              $terms = get_the_terms($additional_item->ID, 'nsm_additional_items_categories');

              if (!is_wp_error( $terms )) {
                $additional_item_category_slug = !empty($terms[0]->slug)? $terms[0]->slug : '';
              }

              // echo $additional_item->post_title;
              // echo ' : '. $additional_item_category_slug;
              // echo '<br/>';

              // if not a standard item

              if($additional_item_category_slug!='' && $additional_item_category_slug != 'standard')
              {

                  if(!$show_seasonal_options)
                  {
                    $hide_field=true;
                  } else {

                    // echo 'HERE:';
                    // echo $additional_item_category_slug  . '<br>';
                    // echo $seasonal_option_category->slug  . '<br>';

                    // if show seasonal items, check it is the correct seasonal category
                    if($additional_item_category_slug != $seasonal_option_category->slug)
                      $hide_field=true;

                  }

              }


            }
            
          }





          // if field is not found in published additional items then unset field from form.
          if(!$field_found){
            unset($form['fields'][$k]); 
          } else {

            // if field was found and puboished but is a seasonal item and seasonal items are not to be shown or it is the 
            // wrong type of seasonal item then hide it.

            if($hide_field)
              unset($form['fields'][$k]); 


          }


      }


      // if Seasonal field label then update it if Seasonal Items are showing

      if($show_seasonal_options)
      {
        
        // echo $field['id'] . '<br>';
        // echo $form_field_seasonal_heading_id . '<br>';

        if($field['id'] == $form_field_seasonal_heading_id)
        {
         if($seasonal_section_heading!='')
         {
            $field['label'] = $seasonal_section_heading;
         }

        }

      } else {
        // Unset seasonal heading.
         if($field['id'] == $form_field_seasonal_heading_id)
          unset($form['fields'][$k]); 
      }




      // If field is a lazypie item then check to see whether is is pubished of not


      $form_field_prefix = 'lazypie_';
      if($form_field_prefix == substr($field['inputName'],0,8))
      {

          $post_id = substr($field['inputName'],8);

          $field_found=false;
          $hide_field=false;

          $status = get_post_status($post_id);
          if($status != 'publish')
          {
            unset($form['fields'][$k]); 
          }

      }




    }



    return $form;
}


add_filter( 'gform_pre_render_5', 'my_populate_orderform_date' );
function my_populate_orderform_date( $form ) {
    
  $form_field_delivery_date = 58;

  $form_field_delivery_date_key = getKeyFromFieldID($form['fields'], $form_field_delivery_date);

    // Delivery Dates

    $first_date = get_next_order_date();
    $next_date = get_next_order_second_date();

    $form['fields'][$form_field_delivery_date_key]->choices[0] = array( 'text' => $first_date->format('l dS F'), 'value' => $first_date->format('Y/m/d') );
    $form['fields'][$form_field_delivery_date_key]->choices[1] = array( 'text' => $next_date->format('l dS F'), 'value' => $next_date->format('Y/m/d') );


  return $form;

}




// Makes sure delivery date can not be changed with the order is saved in the CMS
add_filter( 'gform_get_field_value', 'change_field_value', 10, 3 );
function change_field_value( $value, $entry, $field ){

    if ( $entry['form_id'] == 5 && $field['id'] == 58 ){

        $field->choices[0] = array( 'text' => $entry[58], 'value' => $entry[58]);
    }
    return $value;
}






add_action( 'gform_after_submission_5', 'set_form_cookies2', 10, 2 );
function set_form_cookies2( $entry, $form ) {
  
    setcookie('gf_order_fname', $entry['15'], time() + 1209600, '/' );
    setcookie('gf_order_lname', $entry['91'], time() + 1209600, '/' );
    setcookie('gf_order_email', $entry['16'], time() + 1209600, '/' );
    setcookie('gf_order_phone', $entry['17'], time() + 1209600, '/' );
    setcookie('gf_order_postcode', $entry['18'], time() + 1209600, '/' );
    setcookie('gf_order_address', $entry['25'], time() + 1209600, '/' );
}







//
// Confirmation message on screen for users order
//


add_filter( 'gform_confirmation_5', 'custom_confirmation_message2', 10, 4 );
function custom_confirmation_message2( $confirmation, $form, $entry, $ajax ) {
    




    $box_option = stripPriceFromValue($entry['37']);    
    $delivery_date = DateTime::createFromFormat('Y/m/d', $entry['58']);


   // $html = print_r($entry) . '<br/><br/>';


    $html .= '<p class="heading">Order Number: ' . $entry['id'] . '</p>';
    $html .= '<p class="heading">Delivery Date: ' . $delivery_date->format('l dS F') . '</p>';
    

    if($box_option!='')
    {
      $html .= '<p class="heading">Box Option:</p><p>' . $box_option . '</p>';

      if( $box_option == '1 weekly box for 2 people')
      {
        $html .= '<p class="heading">Meal choices:</p><p>' . stripPriceFromValue($entry['38']) . '</p><p>' . stripPriceFromValue($entry['40']) . '</p><p>' . stripPriceFromValue($entry['41']) . '</p><p>' . stripPriceFromValue($entry['42']) . '</p>';
      }

      if( $box_option == '1 weekly box for 4 people')
      {
        $html .= '<p class="heading">Meal choices:</p><p>' . $entry['44'] . '</p><p>' . $entry['46'] . '</p><p>' . $entry['47'] . '</p><p>' . $entry['45'] . '</p>';
      }
    }


    
    // Loop through all entries.  If they have a . in the key we know they are a product, create an array of product IDs
     
    $product_ids = array();
    foreach( $entry as $key => $value ) {
       
      $pos = strpos($key,'.');

      if($pos!=false)
      {
        $id=substr($key,0,$pos);
        // we have a product field
        if(!in_array($id, $product_ids))
          $product_ids[] = $id;
      }

    }

    
    // Add list if Products
    if(count($product_ids) > 0)
    {
      $html .= '<p class="heading">Additional Items</p>';
    }

    foreach ($product_ids as $key) {
      
      // Check for an order quantity for each item
      if($entry[$key.'.3']!='')
      {
          $html .= $entry[$key.'.3'] . ' x ' . $entry[$key.'.1'] . '<br/>'; 
      }
    }


    $html .= '<p class="heading">Delivery Charge</p>';
    $html .= '<p>'.$entry[34].'</p>';
    

    $html .= '<p class="heading">Order Total</p>';
    $html .= '<p>£ '.number_format($entry[82],2).'</p>';
                 
      
     //  if($additional_items!='')
     //  {
     //    $additional_items = '<p class="heading">Additional Items</p>' . $additional_items;
     //  }

     //  $html .= $additional_items;

       $html .= '<p class="heading">Contact Details</p><p>' . $entry['15'] . ' ' .  $entry['91'] .'</p><p>' . $entry['16'] . '</p><p>' . $entry['17'] . '</p><p>' . $entry['25'] . '</p><p>' . $entry['18'] . '</p><p>' . $entry['26'] . '</p>';


    return str_replace("XXX", $html, $confirmation);
}


add_filter( 'gform_validation_message_5', 'change_message2', 10, 2 );
function change_message2( $message, $form ) {
    return '<div class="validation_error">There was a problem with your order.  Please review the highlighted fields.</div>';
}








// Order by Menu Order
// add_filter( 'rest_nsm_meals_query', function ( $query_vars, $request ) {

//   $query_vars['orderby'] = 'menu_order';
//   $query_vars['order'] = 'ASC';

//   return $query_vars;
// }, 10, 2);





add_filter( 'gform_field_value', 'populate_fields', 10, 3 );
function populate_fields( $value, $field, $name ) {

  // Populating fields from cookies if they exist for 

  $values = array(
    'order_fname' => isset($_COOKIE["gf_order_fname"]) ? $_COOKIE["gf_order_fname"] : '',
    'order_lname' => isset($_COOKIE["gf_order_lname"]) ? $_COOKIE["gf_order_lname"] : '',
    'order_email' => isset($_COOKIE["gf_order_email"]) ? $_COOKIE["gf_order_email"] : '',
    'order_phone' => isset($_COOKIE["gf_order_phone"]) ? $_COOKIE["gf_order_phone"] : '',
    'order_postcode' => isset($_COOKIE["gf_order_postcode"]) ? $_COOKIE["gf_order_postcode"] : '',
    'order_address' => isset($_COOKIE["gf_order_address"]) ? $_COOKIE["gf_order_address"] : ''
  );

  return isset( $values[ $name ] ) ? $values[ $name ] : $value;
}






add_action('acf/save_post', 'post_published_nsm_meals');
function post_published_nsm_meals($postid)
{

	//global $post;

	$post = get_post($postid);

	//  echo 'here:' . $postid;
	//  echo print_r($post);
	//  die();

	if($post->post_type != 'nsm_meals')
		return;

	if($post->post_status != "publish")
		return;

	  $form_id = 5;
	  $standard_section_label_heading = 9;

	 // $post = get_post($postid);

	  $pie_option = get_post_meta($postid, 'lazy_day_pie_option',true);
	  $supplement_price = get_post_meta($postid, 'lay_day_pie_option_price', true);

	  $form_field_id = 'lazypie_' . $postid;
	  $form_field_name = $post->post_title;


	  // Check to see whether post is a lazy meal and create a form entry for this product
	  if($pie_option == 'Yes')
	  {
	    $form = GFAPI::get_form( $form_id );

	        $field_already_exists= false;
	        $field_updated = false;
	        $section_key = 0;
	        // Check to see whether question exists in form
	        foreach($form['fields'] as $key => &$field)
	        {
	          // echo "<br><br>";
	          //   echo print_r($field);

	            if($form_field_id  == $field['inputName'])
	            {
	                $field_already_exists = true;


	                if($field['label'] != $form_field_name || $field['basePrice'] != $supplement_price)
	                {
	                  $field['label'] = $form_field_name;
	                  $field['basePrice'] = $supplement_price;
	                  $field_updated = true;

	  

	                }
	            }            

	            if($field['id'] == $standard_section_label_heading){
	              $section_key = $key+1;
	            }

	        }   


	        // echo '<br><br>FORM FIELDS<br><br>';
	        // echo print_r($form['fields']);

	       // die(); 

	        if(!$field_already_exists)
	        {
	            // Create a new form field for this item.

	            $new_field_id = $form['nextFieldId'];
	            $properties['type'] = 'product';
	            $properties['id'] = $new_field_id;
	            $properties['label'] = $form_field_name;
	            $properties['inputName'] = $form_field_id;
	            $properties['inputType'] = 'singleproduct';
	            $properties['basePrice'] = $supplement_price;
	            $properties['size'] = 'medium';
	            $properties['visibility'] = 'visible';
	            $properties['isRequired'] = false;

	            $inputs[0]['id'] = $new_field_id . '.1';
	            $inputs[0]['label'] = 'Name';
	            $inputs[0]['name'] = '';

	            $inputs[1]['id'] = $new_field_id . '.2';
	            $inputs[1]['label'] = 'Price';
	            $inputs[1]['name'] = '';

	            $inputs[2]['id'] = $new_field_id . '.3';
	            $inputs[2]['label'] = 'Quantity';
	            $inputs[2]['name'] = '';

	            $properties['inputs'] = $inputs;

	            $newfield = GF_Fields::create( $properties );
	             


	            $form['fields'] = insertValueAtPosition($form['fields'], $newfield, $section_key);
	            GFAPI::update_form( $form );


	        } else {


	            // Note this does not always work as there is a race between call back params, however the form load also sets the values 
	            // so we are double covered.
	            
	            if($field_updated)
	            {
	              GFAPI::update_form( $form );
	              // echo 'HERE';
	              // die();
	            }

	        }

	  }
  
}



//add_action( 'publish_nsm_additional_items', 'post_published_nsm_additional_items', 100, 2 );
add_action('acf/save_post', 'post_published_nsm_additional_items');
function post_published_nsm_additional_items($postid)
{

	$post = get_post($postid);

	if($post->post_type != 'nsm_additional_items')
		return;

	if($post->post_status != "publish")
		return;

  $form_id = 5;
  $standard_section_label_heading = 12;
  $standard_seasonal_section_label_heading = 51;

  $supplement_price = get_post_meta($postid, 'price', true);

  $form_field_id = 'additems_' . $postid;
  $form_field_name = $post->post_title;

  // Get the location so we know what section to add it on the form.
  $category ='';
  $terms = get_the_terms($postid, 'nsm_additional_items_categories');
  if (!is_wp_error( $terms )) {
    $category = !empty($terms[0]->slug)? $terms[0]->slug : '';
  }


  // Determine the position of where to enter this field on the form.

  $section_label_field_id = $standard_section_label_heading;   // Standard Additional Items label
  if($category!='' && $category != 'standard')
  {
    $section_label_field_id = $standard_seasonal_section_label_heading;   // Standard Seasonal Additional Items label
  }

  // Check to see whether post is a lazy meal and create a form entry for this product
  
  $form = GFAPI::get_form( $form_id );

  $field_already_exists= false;
  $section_key = 0;
  $field_updated = false;
  // Check to see whether question exists in form
  foreach($form['fields'] as $key => &$field)
  {
    // echo "<br><br>";
    //   echo print_r($field);

      

      if($form_field_id  == $field['inputName'])
      {
          $field_already_exists = true;
          // Update Form Field details with latest price and title name


          

          if($field['label'] != $form_field_name || $field['basePrice'] != $supplement_price)
          {
            $field['label'] = $form_field_name;
            $field['basePrice'] = $supplement_price;
            $field_updated = true;
          }

      }            

      if($field['id'] == $section_label_field_id){
        $section_key = $key+1;
      }

  }   


  // echo '<br><br>FORM FIELDS<br><br>';
  // echo print_r($form['fields']);

 // die(); 

  if(!$field_already_exists)
  {
      // Create a new form field for this item.

      $new_field_id = $form['nextFieldId'];
      $properties['type'] = 'product';
      $properties['id'] = $new_field_id;
      $properties['label'] = $form_field_name;
      $properties['inputName'] = $form_field_id;
      $properties['inputType'] = 'singleproduct';
      $properties['basePrice'] = $supplement_price;
      $properties['size'] = 'medium';
      $properties['visibility'] = 'visible';
      $properties['isRequired'] = false;

      $inputs[0]['id'] = $new_field_id . '.1';
      $inputs[0]['label'] = 'Name';
      $inputs[0]['name'] = '';

      $inputs[1]['id'] = $new_field_id . '.2';
      $inputs[1]['label'] = 'Price';
      $inputs[1]['name'] = '';

      $inputs[2]['id'] = $new_field_id . '.3';
      $inputs[2]['label'] = 'Quantity';
      $inputs[2]['name'] = '';

      $properties['inputs'] = $inputs;

      $newfield = GF_Fields::create( $properties );
       


      $form['fields'] = insertValueAtPosition($form['fields'], $newfield, $section_key);
      GFAPI::update_form( $form );


  } else {


      // Note this does not always work as there is a race between call back params, however the form load also sets the values 
      // so we are double covered.
      
     if($field_updated)
       GFAPI::update_form( $form );

  }

    
  
}




function insertValueAtPosition($formfields, $newField, $position) {
   
    $templist = array();
    $inserted = 0;
    
    foreach ($formfields as $key => $field) {
 
      if($key==$position)
      {
          $templist[] = $newField;
          $templist[] = $field;
          $inserted = 1;    
      }
      else
      {
        $templist[] = $field;
      }

    }

    // echo 'FORM FIELDS';
    // echo print_r($formfields);

    // echo '<br/><br/><br/>';

    // echo 'TEMPLIST';
    // echo print_r($templist);
    // die();

    return $templist;
}


function getKeyFromFieldID($fields, $fieldID)
{
    $formfieldkey = 0;
    foreach( $fields as $key => $field ) {  
      if($field->id == $fieldID)
      {
        $formfieldkey=$key;
        break;
      }
    }

    return $formfieldkey;
}


function stripPriceFromValue($value, $divider='|')
{
    
    $pos = strpos($value, $divider);
    if($pos==false)
      return $value;
    else
    {
      return substr($value, 0, $pos);
    }
}







//
//
// LEGACY: Order Form 1
//
//





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

  $next_order_date = get_next_order_date()->format('Y/m/d');

  // Get published meals - which are available this week.
  $args = array(
    'post_type' => 'nsm_meals',
    'post_status' => 'publish',
    'orderby' => 'title',
    'order' => 'asc',
    'posts_per_page' => '99999',
    'taxonomy' => 'nsm_meal_order_date',
    'term' => $next_order_date
  );
 

  $pie_choices[] = array( 'text' => "No thanks, not this week", 'value' => "No thanks, not this week" );

  $the_query = new WP_Query( $args );

  while ( $the_query->have_posts() ) : $the_query->the_post();

    $supplement_price = get_post_meta(get_the_ID(), 'supplement_price', true);
    $title = get_the_title();
    if($supplement_price)
      $title .= ' ' . $supplement_price;


    $meal_choices[] = array( 'text' => $title, 'value' => get_the_title() );

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






