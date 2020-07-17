<?php 


// GLOBAL CONTENT



add_action('admin_menu', 'global_content_page_create');
function global_content_page_create() {
    $page_title = 'Global Content';
    $menu_title = 'Global Content';
    $capability = 'edit_posts';
    $menu_slug = 'global_text';
    $function = 'my_global_text_edit';
    $icon_url = '';
    $position = 24;

    if( current_user_can('editor') || current_user_can('administrator') ) {
    	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    }
}




function my_global_text_edit() {


	$global_fields['hit_heading'] = array('type'=>'heading', 'label'=>'How it Works Panel', 'value'=>'');
	$global_fields['hit_title'] = array('type'=>'text', 'label'=>'Heading', 'value'=>'');
	
	$global_fields['hit_col1_image'] = array('type'=>'text', 'label'=>'Col1 Image', 'value'=>'');
	$global_fields['hit_col1_heading'] = array('type'=>'text', 'label'=>'Col1 Heading', 'value'=>'');
	$global_fields['hit_col1_content'] = array('type'=>'text', 'label'=>'Col1 Content', 'value'=>'');
	
	$global_fields['hit_col2_image'] = array('type'=>'text', 'label'=>'Col2 Image', 'value'=>'');
	$global_fields['hit_col2_heading'] = array('type'=>'text', 'label'=>'Col2 Heading', 'value'=>'');
	$global_fields['hit_col2_content'] = array('type'=>'text', 'label'=>'Col2 Content', 'value'=>'');
	
	$global_fields['hit_col3_image'] = array('type'=>'text', 'label'=>'Col3 Image', 'value'=>'');
	$global_fields['hit_col3_heading'] = array('type'=>'text', 'label'=>'Col3 Heading', 'value'=>'');
	$global_fields['hit_col3_content'] = array('type'=>'text', 'label'=>'Col3 Content', 'value'=>'');
	
	$global_fields['hit_col4_image'] = array('type'=>'text', 'label'=>'Col4 Image', 'value'=>'');
	$global_fields['hit_col4_heading'] = array('type'=>'text', 'label'=>'Col4 Heading', 'value'=>'');
	$global_fields['hit_col4_content'] = array('type'=>'text', 'label'=>'Col4 Content', 'value'=>'');
	

	$global_fields['hit_button_text'] = array('type'=>'text', 'label'=>'Button Text', 'value'=>'');
	$global_fields['hit_button_link'] = array('type'=>'text', 'label'=>'Button Link', 'value'=>'');

	$global_fields['hit_footer_content'] = array('type'=>'textarea', 'label'=>'Footer Content', 'value'=>'');


	$global_fields['sp_heading'] = array('type'=>'heading', 'label'=>'Simple Pricing Panel', 'value'=>'');
	$global_fields['sp_title'] = array('type'=>'text', 'label'=>'Heading', 'value'=>'');
	
	$global_fields['sp_col1_image'] = array('type'=>'text', 'label'=>'Col1 Image', 'value'=>'');
	$global_fields['sp_col1_content'] = array('type'=>'textarea', 'label'=>'Col1 Content', 'value'=>'');
	$global_fields['sp_col1_price'] = array('type'=>'text', 'label'=>'Col1 Price', 'value'=>'');
	
	$global_fields['sp_col2_image'] = array('type'=>'text', 'label'=>'Col2 Image', 'value'=>'');
	$global_fields['sp_col2_content'] = array('type'=>'textarea', 'label'=>'Col2 Content', 'value'=>'');
	$global_fields['sp_col2_price'] = array('type'=>'text', 'label'=>'Col2 Price', 'value'=>'');
	


	$global_fields['po_heading'] = array('type'=>'heading', 'label'=>'Place Order Panel', 'value'=>'');
	$global_fields['po_title'] = array('type'=>'text', 'label'=>'Heading', 'value'=>'');
	$global_fields['po_intro'] = array('type'=>'textarea', 'label'=>'Intro', 'value'=>'');
	$global_fields['po_button_text'] = array('type'=>'text', 'label'=>'Button Text', 'value'=>'');
	$global_fields['po_button_link'] = array('type'=>'text', 'label'=>'Button Link', 'value'=>'');


	$global_fields['company_details_heading'] = array('type'=>'heading', 'label'=>'Company Details', 'value'=>'');
	$global_fields['company_name'] = array('type'=>'text', 'label'=>'Company Name', 'value'=>'');
	$global_fields['company_address'] = array('type'=>'textarea', 'label'=>'Company Address', 'value'=>'');
	$global_fields['company_call_label'] = array('type'=>'text', 'label'=>'Phone Label', 'value'=>'');
	$global_fields['company_call_number'] = array('type'=>'text', 'label'=>'Phone Number', 'value'=>'');
	$global_fields['company_call_number_link'] = array('type'=>'text', 'label'=>'Phone Number (Link)', 'value'=>'');
	$global_fields['company_email'] = array('type'=>'text', 'label'=>'Email Address', 'value'=>'');
	$global_fields['sm_heading'] = array('type'=>'heading', 'label'=>'Social Media Links', 'value'=>'');
	$global_fields['facebook_link'] = array('type'=>'text', 'label'=>'Facebook', 'value'=>'');
	$global_fields['twitter_link'] = array('type'=>'text', 'label'=>'Twitter', 'value'=>'');
	$global_fields['linkedin_link'] = array('type'=>'text', 'label'=>'LinkedIn', 'value'=>'');
	
	$global_fields['copyright_heading'] = array('type'=>'heading', 'label'=>'Copyright Info', 'value'=>'');
	$global_fields['copyright_message'] = array('type'=>'textarea', 'label'=>'Copyright Message', 'value'=>'');

	$global_fields['site_wide_section_heading'] = array('type'=>'heading', 'label'=>'Site Wide Panel Content', 'value'=>'');
	$global_fields['site_wide_background_image'] = array('type'=>'text', 'label'=>'Background Image', 'value'=>'');
	$global_fields['site_wide_heading'] = array('type'=>'text', 'label'=>'Heading', 'value'=>'');
	$global_fields['site_wide_intro'] = array('type'=>'textarea', 'label'=>'Intro', 'value'=>'');
	$global_fields['site_wide_button_text'] = array('type'=>'text', 'label'=>'Button Text', 'value'=>'');
	$global_fields['site_wide_button_link'] = array('type'=>'text', 'label'=>'Button Link', 'value'=>'');

	$global_fields['static_cta_heading'] = array('type'=>'heading', 'label'=>'CTA info on dynamic pages', 'value'=>'');
	$global_fields['static_cta_title'] = array('type'=>'text', 'label'=>'CTA Title', 'value'=>'');
	$global_fields['static_cta_intro'] = array('type'=>'text', 'label'=>'CTA Intro', 'value'=>'');
	$global_fields['static_cta_button_text'] = array('type'=>'text', 'label'=>'CTA Button Text', 'value'=>'');
	$global_fields['static_cta_button_link'] = array('type'=>'text', 'label'=>'CTA Button Link', 'value'=>'');


	



	if( !current_user_can('editor') && !current_user_can('administrator') ) {  
        wp_die('Unauthorized user');
    }

    //check_admin_referrer( 'wpshout_option_page_footer_action' );

    echo '<h1 style="font-size: 23px;font-weight: 400;margin: 0;padding: 5px 0px 4px;line-height: 29px;">Global Content</h1>';

   
    if ( ! empty( $_POST ) && check_admin_referer( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' ) ) 
    {
    	foreach ($global_fields as $key => $global_field) {
    		if($global_field['type']!='heading')
    			//echo $key . ':' . $_POST[$key] . '<br/>';
    			update_option($key, $_POST[$key] );
    	}

    	
    }
	


	echo '<form method="POST">';


	foreach ($global_fields as $key => $global_field) {
		
		if($global_field['type']!='heading') {
			//echo $key . ':' . stripslashes(get_option($key)) . '<br/>';
    		$global_field['value'] = stripslashes(get_option($key, ''));

    		
    	}

    
		switch($global_field['type'])
		{
			
			case 'heading':

				echo '<h2 style="font-size: 18px;font-weight: 400;margin: 0;padding: 25px 0px 4px;line-height: 29px;">'.$global_field['label'].'</h2>';
    			echo '<hr>';

				break;



			case 'text':

				echo '<p>';
				echo '<label style="display: inline-block; vertical-align:top; width: 200px; margin-bottom: 5px;" for="'.$key.'">'.$global_field['label'].'</label>';
				echo '<input style="width: 90%;" name="'.$key.'" id="'.$key.'" value="'.$global_field['value'].'">';
				echo '</p>';

				break;


			case 'textarea':

				echo '<p>';
				echo '<label style="display: inline-block; vertical-align:top; width: 200px; margin-bottom: 5px;" for="'.$key.'">'.$global_field['label'].'</label>';
				echo '<textarea style="width: 90%;" name="'.$key.'" id="'.$key.'">'.$global_field['value'].'</textarea>';
				echo '</p>';

				break;


		}

    }

	
	wp_nonce_field( 'wpshout_option_page_footer_action', 'wpshout_option_page_footer_action' );

	echo '<p><br/><br/>';
	echo '<input type="submit" value="Save" class="button button-primary button-large">';
	echo '</p>';
	echo '</form>';

}

function get_global_field($fieldname) {
	return stripslashes(get_option($fieldname, ''));
}


function get_global_replace_date_field($fieldname) {

	$globalfield = stripslashes(get_option($fieldname, ''));
	$globalfield = str_replace('%%date%%', Date('Y'), $globalfield);
	return $globalfield;

}




