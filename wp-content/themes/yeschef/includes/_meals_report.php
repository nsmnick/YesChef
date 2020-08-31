<?php 


// MEALS REPORT



add_action('admin_menu', 'pick_list_report_create');
function pick_list_report_create() {
    $page_title = 'Reports';
    $menu_title = 'Reports';
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

 if( !current_user_can('editor') && !current_user_can('administrator') ) {  
        wp_die('Unauthorized user');
    }

  if( isset( $_GET['download_meals_report'] ) ) {
      

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=example.csv');
    header('Pragma: no-cache');
      
      render_meals_report($_GET['order_week'],true);
      exit();

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


    $meals = array();
    $additional_items = array();
    $orders = 0;
    foreach ($entries as $key => $entry) {
        # code...
        // echo print_r($entry);
        // echo '<br/><br/>';

        $orders++;
    

        $meal_multiplier = 2;
        if(strpos($entry['2'],'4 people')!=FALSE)
        {
            $meal_multiplier = 4;
        }

        // Four standard meals
        $meals[$entry['5']] = (int) $meals[$entry['5']] + (int) (1 * $meal_multiplier);
        $meals[$entry['6']] = (int) $meals[$entry['6']] + (int) (1 * $meal_multiplier);
        $meals[$entry['7']] = (int) $meals[$entry['7']] + (int) (1 * $meal_multiplier);
        $meals[$entry['8']] = (int) $meals[$entry['8']] + (int) (1 * $meal_multiplier);

        // lazy pies added to normal meals pick list

        if(strpos($entry['10'],'No thanks')!=FALSE)
            $meals[$entry['10']] = (int) $meals[$entry['10']] + (int) (1 * $meal_multiplier);
        
        if(strpos($entry['11'],'No thanks')!=FALSE)
            $meals[$entry['11']] = (int) $meals[$entry['11']] + (int) (1 * $meal_multiplier);


        // Find additional items
        foreach( $entry as $key => $value ) {
      
            if(substr($key, 0, 3) == '13.') {
                if($value!='')
                    $additional_items[$value] = (int) $additional_items[$value] + (int) 1;
            }
        }



    }


    if(!$export) {


        echo '<div class="wrap">';
        echo '<br/><hr/><br/>';

        echo '<div style="background-color: white; padding: 20px;">';

        echo '<h1>Order Week: ' . $order_week . '</h1>';
        echo '<p>Number of orders: #' . $orders . '</p>';

        echo '<a class="button" href="/wp-admin/admin.php?page=meals_report&download_meals_report=true&order_week=' . $_POST['order_week'] . '">Download Report</a><br/>';
        
        echo '<br/><hr/><br/>';

        echo '<h2 style="margin-bottom:5px;">Number of each meal ordered</h2>';
        echo '(Includes Lazy Day additional Pie choices)<br/><br/>';
        
        echo '<ul class="styled-list">';
        foreach( $meals as $meal => $value ) {
            echo '<li>' . $meal . ': <b>' . $value . '</b></li>';
        }

        echo '</ul>';

        echo '<br/>';
        echo '<h2>Number of additional items</h2>';

        echo '<ul class="styled-list">';
        foreach( $additional_items as $item => $value ) {
            echo '<li>' . $item . ': <b>' . $value . '</b></li>';
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
        echo '"Item Ordered","# Ordered",';
        echo "\r\n";
        foreach( $meals as $meal => $value ) {
            echo '"' . $meal . '","' . $value . '",';
            echo "\r\n";
        }

        echo "\r\n";
        echo "\r\n";

        foreach( $additional_items as $item => $value ) {
            echo '"' . $item . '","' . $value . '",';
            echo "\r\n";
        }


    }




}




