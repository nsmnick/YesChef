<?php

// JOBS


function register_custom_rest_fields() {

	$post_type_fields = [
		'nsm_meals' => [
			'skill_level' => 'nsm_meal_get_skill_level'
			,'food_type' => 'nsm_meal_get_food_type'
			,'meal_type' => 'nsm_meal_get_meal_type'
			,'calories' => 'nsm_meal_get_calories'
			,'featured_image' => 'get_rest_featured_image'
			,'summary' => 'nsm_meal_get_summary'
			,'cook_time' => 'nsm_meal_get_cook_time'
			,'prep_time' => 'nsm_meal_get_prep_time'
			,'available_this_week' => 'nsm_meal_get_available_this_week'
		],
		'nsm_additional_items' => [
			'price' => 'nsm_additionalitem_get_price'
			,'featured_image' => 'get_rest_featured_image_large'
		]

	];

	foreach ($post_type_fields as $post_type => $fields) {
		foreach ($fields as $field_name => $function) {
			register_rest_field(
				$post_type
				, $field_name
				, array(
					'get_callback' => $function
					, 'update_callback' => null
					, 'schema' => null
				)
			);
		}
	}

}
add_action( 'rest_api_init', 'register_custom_rest_fields' );


// function nsm_job_post_get_published_date(  $object, $field_name, $request) {

// 	$date = date_create($object['date']);
// 	return date_format($date,"d M Y");
// }

function nsm_meal_get_skill_level(  $object, $field_name, $request) {
	$terms = get_the_terms($object['id'], 'nsm_meal_skill_level');
	if (!is_wp_error( $terms )) {
		return !empty($terms[0]->name)? $terms[0]->name : '';
	}
	return '';
}

function nsm_meal_get_food_type(  $object, $field_name, $request) {
	$terms = get_the_terms($object['id'], 'nsm_meal_food_type');
	if (!is_wp_error( $terms )) {
		return !empty($terms[0]->name)? $terms[0]->name : '';
	}
	return '';
}

function nsm_meal_get_meal_type(  $object, $field_name, $request) {
		$terms = get_the_terms($object['id'], 'nsm_meal_type');
	if (!is_wp_error( $terms )) {
		return !empty($terms[0]->name)? $terms[0]->name : '';
	}
	return '';
}

function nsm_meal_get_calories(  $object, $field_name, $request) {
		$terms = get_the_terms($object['id'], 'nsm_meal_calories');
	if (!is_wp_error( $terms )) {
		return !empty($terms[0]->name)? $terms[0]->name : '';
	}
	return '';
}

function nsm_meal_get_summary(  $object, $field_name, $request) {
	
	return get_post_meta($object['id'],'summary_information')[0];
}

function nsm_meal_get_prep_time(  $object, $field_name, $request) {
	
	return get_post_meta($object['id'],'prep_time')[0];
}

function nsm_meal_get_cook_time(  $object, $field_name, $request) {
	
	return get_post_meta($object['id'],'cook_time')[0];
}

function nsm_additionalitem_get_price(  $object, $field_name, $request) {
	
	return get_post_meta($object['id'],'price')[0];
}

function nsm_meal_get_available_this_week(  $object, $field_name, $request) {
	return has_term(get_next_order_date()->format('Y/m/d'), 'nsm_meal_order_date',$object['id']);
}



// Order by Date Posted 
add_filter( 'rest_nsm_job_post_query', function ( $query_vars, $request ) {

	// Note: If we wanted to order by value on qs then we could  $orderby = $request->get_param('orderby');
	// $query_vars['orderby'] = 'meta_value';
	// $query_vars['meta_key'] = 'date_posted';
	// $query_vars['order'] = 'DESC';

	$query_vars['orderby'] = 'date';
	$query_vars['order'] = 'DESC';

	return $query_vars;
}, 10, 2);






function get_rest_featured_image_background( $object, $field_name, $request ) {

	return 'url('. get_the_post_thumbnail_url($object['id']).')';
}

function get_rest_featured_image( $object, $field_name, $request ) {

	return get_the_post_thumbnail_url($object['id'],'medium');
}

function get_rest_featured_image_large( $object, $field_name, $request ) {

	return get_the_post_thumbnail_url($object['id']);
}


// function get_rest_news_categories(  $object, $field_name, $request) {
// 	return get_custom_post_terms_simple($object['id'],'category','');
// }

// function get_rest_case_study_categories(  $object, $field_name, $request) {
// 	return get_custom_post_terms_simple($object['id'],'nsm_cs_categories','');
// }






