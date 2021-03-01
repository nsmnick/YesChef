<?php 


// MEALS REPORT



add_action('admin_menu', 'pick_list_report_create');
function pick_list_report_create() {
    $page_title = 'Reports';
    $menu_title = 'Report (Old)';
    $capability = 'edit_posts';
    $menu_slug = 'meals_report';
    $function = 'my_meal_picking_list_report';
    $icon_url = '';
    $position = 25;

    if( current_user_can('editor') || current_user_can('administrator') ) {
    	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    }
}


function check_download_file(){

 if( current_user_can('editor') || current_user_can('administrator') ) {  
     

      if( isset( $_GET['download_meals_report'] ) ) {
          

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=example.csv');
        header('Pragma: no-cache');
          
          render_meals_report($_GET['order_week'],true);
          exit();

      }

      if( isset( $_GET['download_meals_report_v5'] ) ) {
          

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=example.csv');
        header('Pragma: no-cache');
          
          render_meals_report_v5($_GET['order_week'],true);
          exit();

      }

    }


}
add_action('admin_init','check_download_file');




function my_meal_picking_list_report() {
    
    if( !current_user_can('editor') && !current_user_can('administrator') ) {  
        wp_die('Unauthorized user');
    }

  

    echo '<div class="wrap">';
    echo '<h1 style="font-size: 23px;font-weight: 400;margin: 0;padding: 5px 0px 4px;line-height: 29px;">Order Picking List Report</h1>';
    echo '<hr/>';
    
    $form_id = '1';

    $search_criteria['status'] = 'active';
    //$search_criteria['field_filters'][] = array( 'key' => 'id', 'value' => 108 );

    // First Date
    $paging = array( 'offset' => 0, 'page_size' => 1 );
    $sorting = array( 'key' => 19, 'direction' => 'ASC', 'is_numeric' => false );
    $entries = GFAPI::get_entries( $form_id, $search_criteria,  $sorting, $paging );
//    echo $entries[0]['id'] . ': ' . $entries[0]['19'] . '<br/>';

    $start_date = new DateTime($entries[0]['19']);
    // Last Date
    $paging = array( 'offset' => 0, 'page_size' => 1 );
    $sorting = array( 'key' => 19, 'direction' => 'DESC', 'is_numeric' => false );
    $entries = GFAPI::get_entries( $form_id, $search_criteria,  $sorting, $paging );
   // echo $entries[0]['id'] . ': ' . $entries[0]['19'] . '<br/>';

    $end_date = new DateTime($entries[0]['19']);

    // echo $start_date->format('Y/m/d');
    // echo $end_date->format('Y/m/d');

    $options='';
    while($end_date != $start_date) {
        $options .= '<option>' . $end_date->format('Y/m/d') . '</option>';
        $end_date->modify('- 1 week');  
    }

    $options .= '<option>' . $end_date->format('Y/m/d') . '</option>';

  



     echo '<br/><form method="post" action="">';

        echo '<label>Select Week: </label>';
        echo '<select name="order_week" id="order_week">';        
            echo $options;
        echo '</select>&nbsp;';

        echo '<input type="submit" value="Submit" class="button">';

        wp_nonce_field( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' );

        
        echo '</form>';

    echo '</div>';

    if ( ! empty( $_POST ) && check_admin_referer( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' ) ) 
    {

        render_meals_report($_POST['order_week']);

       // download_url('/wp-admin/admin.php?page=meals_report');

       
    }



 

}



function render_meals_report($order_week, $export=false) {
    

    $search_criteria['status'] = 'active';
    $search_criteria['field_filters'][] = array( 'key' => '19', 'value' => $order_week );

    // First Date
    $paging = array( 'offset' => 0, 'page_size' => 999999999 );
    $sorting = array( 'key' => 'id', 'direction' => 'ASC', 'is_numeric' => true );
    $entries = GFAPI::get_entries( $form_id, $search_criteria,  $sorting, $paging );


    $order_details = array();
    $meals2 = array();
    $meals4 = array();
    $additional_items = array();
    $orders = 0;
    $orders2 = 0;
    $orders4 = 0;

    $excluded_orders = 0;
    foreach ($entries as $key => $entry) {
        # code...
        

        
        // echo print_r($entry);
        // echo '<br/><br/>';
        // First check to see if order should be included in report

        if($entry['21'] == 'Yes') 
        {

            // echo print_r($entry);
            // echo '<br/><br/>';


            $orders++;

            
            $order_details[$orders]['id'] = $entry['id'];
            $order_details[$orders]['date'] = $entry['date_created'];
            $order_details[$orders]['fname'] = $entry['15'];
            $order_details[$orders]['lname'] = $entry['91'];

            if(strpos($entry['2'],'4 people')!=FALSE)
                $order_details[$orders]['people'] = '4 People';
            else 
                $order_details[$orders]['people'] = '2 People';

            $order_details[$orders]['meal1'] = $entry['5'];
            $order_details[$orders]['meal2'] = $entry['6'];
            $order_details[$orders]['meal3'] = $entry['7'];
            $order_details[$orders]['meal4'] = $entry['8'];
            $order_details[$orders]['lazy1'] = $entry['10'];
            $order_details[$orders]['lazy2'] = $entry['11'];
                


            // echo $entry['2'];
            // echo strpos($entry['2'],'4 people');

            $meal_multiplier = 2;
            if(strpos($entry['2'],'4 people')!==FALSE)
            {
                $meal_multiplier = 4;
                $orders4++;

                // Four standard meals
                $meals4[$entry['5']] = (int) $meals4[$entry['5']] + 4;
                $meals4[$entry['6']] = (int) $meals4[$entry['6']] + 4;
                $meals4[$entry['7']] = (int) $meals4[$entry['7']] + 4;
                $meals4[$entry['8']] = (int) $meals4[$entry['8']] + 4;


                if(strpos($entry['10'],'No thanks')===FALSE)
                {
                    $meal = strip_amount($entry['10']);
                    $meals4[$meal] = (int) $meals4[$meal] + 4;
                }
            
                if(strpos($entry['11'],'No thanks')===FALSE)
                {
                    $meal = strip_amount($entry['11']);
                    $meals4[$meal] = (int) $meals4[$meal] + 4;
                }


                
            } else {
               $meal_multiplier = 2;
                $orders2++;

                 // Four standard meals
                $meals2[$entry['5']] = (int) $meals2[$entry['5']] + 2;
                $meals2[$entry['6']] = (int) $meals2[$entry['6']] + 2;
                $meals2[$entry['7']] = (int) $meals2[$entry['7']] + 2;
                $meals2[$entry['8']] = (int) $meals2[$entry['8']] + 2;

                // echo 'lazy1:' . $entry['10'] . '<br/>';
                // echo 'res1:' . strpos($entry['10'],'No thanks');

                if(strpos($entry['10'],'No thanks')===FALSE)
                {
                    $meal = strip_amount($entry['10']);
                    $meals2[$meal] = (int) $meals2[$meal] + 2;
      //              echo 'lazy1 count:' . $meals2[$meal] . '<br/>';
                }
                


                if(strpos($entry['11'],'No thanks')===FALSE)
                {
                    $meal = strip_amount($entry['11']);
                    $meals2[$meal] = (int) $meals2[$meal] + 2;
        //            echo 'lazy2 count:' . $meals2[$meal] . '<br/>';
                }

            }

            
          
            // Find additional items
            foreach( $entry as $key => $value ) {
          
                if(substr($key, 0, 3) == '13.') {
                    if($value!='')
                        $additional_items[$value] = (int) $additional_items[$value] + (int) 1;
                }
            }

        } else {
            $excluded_orders++;
        }

    }


    if(!$export) {


        echo '<div class="wrap">';
        echo '<br/><hr/><br/>';

        echo '<div style="background-color: white; padding: 20px;">';

        echo '<h1>Order Week: ' . $order_week . '</h1>';
        echo '<p>Number of orders: #' . $orders . '<br/>';
        echo 'Boxes for 2 people: #' . $orders2 . '<br/>';
        echo 'Boxes for 4 people: #' . $orders4 . '<br/>';
        echo 'Number of excluded orders: #' . $excluded_orders . '</p>';

        echo '<a class="button" href="/wp-admin/admin.php?page=meals_report&download_meals_report=true&order_week=' . $_POST['order_week'] . '">Download Report</a><br/>';
        
        echo '<br/><hr/><br/>';

        echo '<h2 style="margin-bottom:5px;">Number of each meal ordered for 2 people</h2>';
        echo '(Includes Lazy Day additional Pie choices)<br/>';
        
        echo '<ul class="styled-list">';
        foreach( $meals2 as $meal => $value ) {
            echo '<li>' . $meal . ': <b>' . $value . '</b></li>';
        }

        echo '</ul><br/>';


        
        echo '<h2 style="margin-bottom:5px;">Number of each meal ordered for 4 people</h2>';
        echo '(Includes Lazy Day additional Pie choices)<br/>';
        
        echo '<ul class="styled-list">';
        foreach( $meals4 as $meal => $value ) {
            echo '<li>' . $meal . ': <b>' . $value . '</b></li>';
        }

        echo '</ul><br/>';


        
        echo '<h2>Number of additional items</h2>';

        echo '<ul class="styled-list">';
        foreach( $additional_items as $item => $value ) {
            echo '<li>' . $item . ': <b>' . $value . '</b></li>';
        }
        echo '</ul>';


        echo '<br/>';
        echo '<h2>Order Details</h2>';

        

        echo '<ul class="styled-list">';
        foreach( $order_details as $order) {

            echo '<li><b>Order #: </b>' . $order['id'] . ' | <b>Date: </b>' . $order['date'] . ' | <b>First Name:</b> '. ' | <b>Last Name:</b> ' . $order['name'] . ' | <b># People:</b> ' . $order['people'] . ' | <b>Meal1:</b> ' . $order['meal1'] .' | <b>Meal2:</b> ' . $order['meal2'] .' | <b>Meal3:</b> ' . $order['meal3'] .' | <b>Meal4:</b> ' . $order['meal4'] .' | <b>Lazy1:</b> ' . $order['lazy1'] .' | <b>Lazy2:</b> ' . $order['lazy2'] .'</li>'; 
        }
        echo '</ul>';

      
        echo '<br/>';

        echo '</div>';
        echo '</div>';

    } else {


        echo '"Order Week: ' . $order_week . '",';
        echo "\r\n";
        echo 'Boxes for 2 people: #' . $orders2 . ',';
        echo "\r\n";
        echo 'Boxes for 4 people: #' . $orders4 . ',';
        echo "\r\n";
        echo '"Number of excluded orders: #' . $excluded_orders . '",';
        echo "\r\n";
        echo "\r\n";

        echo '"Number of each meal ordered for 2 people","# Ordered",';
        echo "\r\n";
        foreach( $meals2 as $meal => $value ) {
            echo '"' . $meal . '","' . $value . '",';
            echo "\r\n";
        }

        echo "\r\n";
        echo "\r\n";


        echo '"Number of each meal ordered for 4 people","# Ordered",';
        echo "\r\n";
        foreach( $meals4 as $meal => $value ) {
            echo '"' . $meal . '","' . $value . '",';
            echo "\r\n";
        }

        echo "\r\n";
        echo "\r\n";

        echo '"Additional Items","# Ordered",';
        echo "\r\n";

        foreach( $additional_items as $item => $value ) {
            echo '"' . $item . '","' . $value . '",';
            echo "\r\n";
        }



        echo "\r\n";
        echo "\r\n";

        echo '"Order Details"';
        echo "\r\n";

        echo '"Order #","Date","Name","# People","Meal1","Meal2","Meal3","Meal4","Lazy1","Lazy2",';
        echo "\r\n";

        foreach( $order_details as $order) {

            echo '"'.$order['id'].'","'.$order['date'].'","'.$order['fname'].'","'.$order['lname'].'","'.$order['people'].'","'.$order['meal1'].'","'.$order['meal2'].'","'.$order['meal3'].'","'.$order['meal4'].'","'.$order['lazy1'].'","'.$order['lazy2'].'",';

            echo "\r\n";
        }


    }




}


function strip_amount($meal) {

    //echo 'meal1:' . $meal . ':' . strpos($meal,'(£') . '<br>';

    if(strpos($meal,'(£') > 0)
    {
        $meal = substr($meal, 0, (strpos($meal,'(£'))-2);
      //  echo 'meal2:' . $meal . '<br>';
    }

    return $meal;


}




// V5 Report


add_action('admin_menu', 'pick_list_report_create_v5');
function pick_list_report_create_v5() {
    $page_title = 'Reports';
    $menu_title = 'Report (New)';
    $capability = 'edit_posts';
    $menu_slug = 'meals_report_v5';
    $function = 'my_meal_picking_list_report_v5';
    $icon_url = '';
    $position = 25;

    if( current_user_can('editor') || current_user_can('administrator') ) {
        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    }
}



function my_meal_picking_list_report_v5() {
    
    

    if( !current_user_can('editor') && !current_user_can('administrator') ) {  
        wp_die('Unauthorized user');
    }



    echo '<div class="wrap">';
    echo '<h1 style="font-size: 23px;font-weight: 400;margin: 0;padding: 5px 0px 4px;line-height: 29px;">Order Picking List Report</h1>';
    echo '<hr/>';
    

    
    $form_id = '5';
    $delivery_date_field_id = '58';

    $search_criteria['status'] = 'active';


    $validation_message = '';
    // Check submitted date
    if ( ! empty( $_POST ) && check_admin_referer( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' ) ) 
    {        

        $order_date = $_POST['order_week'];

        if(!verifyDate($order_date)) 
        {
            $validation_message = 'Please enter a valid date';
        }

    }



    if ( empty( $_POST ) || $validation_message!='' )
    {
        
        if(isset($order_date))
            $display_date = $order_date;
        else
            $display_date = get_next_order_date()->format('Y/m/d');

        echo '<br/><form method="post" action="">';

        echo '<label>Enter Order Date: </label>';
    
        echo '<input type="text"  name="order_week" value="'.$display_date.'">';
        echo '<input type="submit" value="Submit" class="button">';
        echo '<p><small>Date Format: YYYY/MM/DD</small></p>';

        if($validation_message!='')
            echo '<p><b>' . $validation_message . '</b></p>';

        wp_nonce_field( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' );

        
        echo '</form>';


    } else {


        if ( ! empty( $_POST ) && check_admin_referer( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' ) ) 
        {

            render_meals_report_v5($order_date);

           // download_url('/wp-admin/admin.php?page=meals_report');

           
        }
    }


    echo '</div>';  // Wrap
 

}




function render_meals_report_v5($order_week, $export=false) {
    

    $form_id = 5;
    $delivery_date_field_id = 58;
    $box_options_field_id = 58;
    $coupon_field_id = 32;


    // Key IDs
    $include_in_report_field_id = '88';

    $search_criteria['status'] = 'active';
    $search_criteria['field_filters'][] = array( 'key' => $delivery_date_field_id, 'value' => $order_week );

    // First Date
    $paging = array( 'offset' => 0, 'page_size' => 999999999 );
    $sorting = array( 'key' => 'id', 'direction' => 'ASC', 'is_numeric' => true );
    $entries = GFAPI::get_entries( $form_id, $search_criteria,  $sorting, $paging );


    // Setup arrays to store data.

    $order_details = array();
    $meals2 = array();
    $meals4 = array();
    $box_options = array();
    $additional_items = array();
    $orders = 0;
    $coupons = 0;

    $excluded_orders = 0;


    foreach ($entries as $key => $entry) {
    
        // First check to see if order should be included in report

        if($entry[$include_in_report_field_id] == 'Yes') 
        {

            // echo print_r($entry);
            // echo '<br/><br/>';


            $orders++;


            $box_option_value = stripPriceFromValue($entry['37']);

            if($box_option_value=='')
                $box_option_value = 'Lazy Day Range Only';

            if($entry[$coupon_field_id] != '') 
            {
                $coupons++;
            }


            // Data for listing at end   

            $order_details[$orders]['id'] = $entry['id'];
            $order_details[$orders]['date'] = $entry['date_created'];
            $order_details[$orders]['fname'] = $entry['15'];
            $order_details[$orders]['lname'] = $entry['91'];
            $order_details[$orders]['box_option'] = $box_option_value;
            $order_details[$orders]['email'] = $entry['16'];
            $order_details[$orders]['phone'] = $entry['17'];
            $order_details[$orders]['address'] = $entry['25'];
            $order_details[$orders]['postcode'] = $entry['18'];
            $order_details[$orders]['delivery_charge'] = $entry['34'];
            $order_details[$orders]['total_order'] = number_format($entry[82],2);
            $order_details[$orders]['coupon'] =  $entry['32'];

            $order_details[$orders]['paymentstatus'] =  $entry['payment_status'];
            $order_details[$orders]['paymentdate'] =  $entry['payment_date'];
            $order_details[$orders]['paymentamount'] =  $entry['payment_amount'];
            $order_details[$orders]['paymentmethod'] =  $entry['payment_method'];
            $order_details[$orders]['paymenttransID'] =  $entry['transaction_id'];


            $meal_1_2 = stripPriceFromValue($entry['38']);
            $meal_2_2 = stripPriceFromValue($entry['40']);
            $meal_3_2 = stripPriceFromValue($entry['41']);
            $meal_4_2 = stripPriceFromValue($entry['42']);

            $meal_1_4 = stripPriceFromValue($entry['44']);
            $meal_2_4 = stripPriceFromValue($entry['46']);
            $meal_3_4 = stripPriceFromValue($entry['47']);
            $meal_4_4 = stripPriceFromValue($entry['45']);

            if($box_option_value == '1 weekly box for 2 people')
            {
                $order_details[$orders]['meal1'] = $meal_1_2;
                $order_details[$orders]['meal2'] = $meal_2_2;
                $order_details[$orders]['meal3'] = $meal_3_2;
                $order_details[$orders]['meal4'] = $meal_4_2;
            }

            if($box_option_value == '1 weekly box for 4 people')
            {
                $order_details[$orders]['meal1'] = $meal_1_4;
                $order_details[$orders]['meal2'] = $meal_2_4;
                $order_details[$orders]['meal3'] = $meal_3_4;
                $order_details[$orders]['meal4'] = $meal_4_4;

            }


            // Keep a count of each box_options Type

            $box_options[$box_option_value] = (int) $box_options[$box_option_value] + 1;


            // Calculate the actual number of meals for 2 people and for 4 people
            
            if($box_option_value == '1 weekly box for 2 people')
            {

                // Four standard meals
                $meals2[$meal_1_2] = (int) $meals2[$meal_1_2] + 2;
                $meals2[$meal_2_2] = (int) $meals2[$meal_2_2] + 2;
                $meals2[$meal_3_2] = (int) $meals2[$meal_3_2] + 2;
                $meals2[$meal_4_2] = (int) $meals2[$meal_4_2] + 2;

            } 
            
            if($box_option_value == '1 weekly box for 4 people')
            {

                $meals4[$meal_1_4] = (int) $meals4[$meal_1_4] + 4;
                $meals4[$meal_2_4] = (int) $meals4[$meal_2_4] + 4;
                $meals4[$meal_3_4] = (int) $meals4[$meal_3_4] + 4;
                $meals4[$meal_4_4] = (int) $meals4[$meal_4_4] + 4;

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
              
                foreach ($product_ids as $key) {
                  
                  // Check for an order quantity for each item
                  if($entry[$key.'.3']!='')
                  {
                      $qty = (int) $entry[$key.'.3'];
                      $item = $entry[$key.'.1'];
                      $additional_items[$item] = (int) $additional_items[$item] + ((int) 1 * (int)$qty);
                  }
                }
            }


        } else 
        {
            $excluded_orders++;
        }

    }


    if(!$export) {


        echo '<div class="wrap">';
        echo '<br/><hr/><br/>';

        echo '<div style="background-color: white; padding: 20px;">';

        echo '<h1>Order Week: ' . $order_week . '</h1>';
        echo '<p>Number of orders: #' . $orders . '<br/>';

        foreach ($box_options as $key => $boxoption) {
            
            echo $key . ': #' . $boxoption . '<br/>';    

        }
        echo '</p>';

        echo '<p>Number of orders: #' . $orders . '<br/>';
        echo 'Number of coupons used: #' . $coupons . '<br/>';
        echo 'Number of excluded orders: #' . $excluded_orders . '</p>';

        echo '<a class="button" href="/wp-admin/admin.php?page=meals_report&download_meals_report_v5=true&order_week=' . $order_week . '">Download Report</a><br/>';
        
        echo '<br/><hr/><br/>';

        echo '<h2 style="margin-bottom:5px;">Number of each meal ordered for 2 people (1 week only)</h2>';
        
        echo '<ul class="styled-list">';
        foreach( $meals2 as $meal => $value ) {
            echo '<li>' . $meal . ': <b>' . $value . '</b></li>';
        }

        echo '</ul><br/>';


        
        echo '<h2 style="margin-bottom:5px;">Number of each meal ordered for 4 people (1 week only)</h2>';
        
        echo '<ul class="styled-list">';
        foreach( $meals4 as $meal => $value ) {
            echo '<li>' . $meal . ': <b>' . $value . '</b></li>';
        }

        echo '</ul><br/>';


        
        echo '<h2>Number of additional items</h2>';

        echo '<ul class="styled-list">';
        foreach( $additional_items as $item => $value ) {
            echo '<li>' . $item . ': <b>' . $value . '</b></li>';
        }
        echo '</ul>';


        echo '<br/>';
        echo '<h2>Order Details</h2>';

        

        echo '<ul class="styled-list">';
        foreach( $order_details as $order) {

            echo '<li><b>Order #: </b>' 
                    . $order['id'] 
                    . ' | <b>Date: </b>' . $order['date'] 
                    . ' | <b>First Name:</b> ' . $order['fname'] 
                    . ' | <b>Last Name:</b> ' . $order['lname'] 
                    . ' | <b>Box Option:</b> ' . $order['box_option'] ;

                    if($order['box_option'] == '1 weekly box for 2 people' || $order['box_option'] == '1 weekly box for 4 people' )
                    {
                        echo ' | <b>Meal1:</b> ' . $order['meal1']
                        . ' | <b>Meal2:</b> ' . $order['meal2']
                        . ' | <b>Meal3:</b> ' . $order['meal3']
                        . ' | <b>Meal4:</b> ' . $order['meal4'];
                    }

                    echo ' | <b>Coupon Used: </b>' . $order['coupon']; 
                    echo ' | <b>Order Value: </b>' . $order['total_order'];  
                    echo ' | <b>Payment Status: </b>' . $order['paymentstatus'];  
                    echo '</li>'; 
        }
        echo '</ul>';

      
        echo '<br/>';

        echo '</div>';
        echo '</div>';

    } else {


        echo '"Order Week: ' . $order_week . '",';
        echo "\r\n";

        echo '"Number of orders: #' . $orders . '",';
        echo "\r\n";
        echo "\r\n";


        foreach ($box_options as $key => $boxoption) {
            
            echo '"' . $key . ': #' . $boxoption . '",';
            echo "\r\n";

        }
        echo "\r\n";
        
        echo '"Number of coupons used: #' . $coupons . '",';
        echo "\r\n";

        echo '"Number of excluded orders: #' . $excluded_orders . '",';
        echo "\r\n";
        echo "\r\n";


        echo '"Number of each meal ordered for 2 people (1 week only)","# Ordered",';
        echo "\r\n";
        foreach( $meals2 as $meal => $value ) {
            echo '"' . $meal . '","' . $value . '",';
            echo "\r\n";
        }

        echo "\r\n";
        echo "\r\n";


        echo '"Number of each meal ordered for 4 people (1 week only)","# Ordered",';
        echo "\r\n";
        foreach( $meals4 as $meal => $value ) {
            echo '"' . $meal . '","' . $value . '",';
            echo "\r\n";
        }

        echo "\r\n";
        echo "\r\n";

        echo '"Additional Items","# Ordered",';
        echo "\r\n";

        foreach( $additional_items as $item => $value ) {
            echo '"' . $item . '","' . $value . '",';
            echo "\r\n";
        }



        echo "\r\n";
        echo "\r\n";

        echo '"Order Details"';
        echo "\r\n";

        echo '"Order #","Date","First Name","Last Name","Box Option","Meal1","Meal2","Meal3","Meal4","Delivery Charge","Order Total","Coupon","Email","Phone","Address","Postcode","Payment Status","Payment Amount","Payment Method","Trans ID"';


        echo "\r\n";

        foreach( $order_details as $order) {

            echo '"'.$order['id'].'","'.$order['date'].'","'.$order['fname'].'","'.$order['lname'].'","'.$order['box_option'].'","'.$order['meal1'].'","'.$order['meal2'].'","'.$order['meal3'].'","'.$order['meal4'].'","'.$order['delivery_charge'].'","'.$order['total_order'].'","'.$order['coupon'].'","'.$order['email'].'","'.$order['phone'].'","'.$order['address'].'","'.$order['postcode'].'","'.$order['paymentstatus'].'","'.$order['paymentamount'].'","'.$order['paymentmethod'].'","'.$order['paymenttransID'].'",';

            echo "\r\n";
        }


    }




}



function verifyDate($date, $strict = true)
{
    $dateTime = DateTime::createFromFormat('Y/m/d', $date);
    if ($strict) {
        $errors = DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            return false;
        }
    }
    return $dateTime !== false;
}




