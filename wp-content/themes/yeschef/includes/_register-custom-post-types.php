<?php 

	// Register Custom Post Types

	register_post_type(
	
		'nsm_meals'
		, [
			'labels' => [
				'name' => __( 'Meals' )
				, 'singular_name' => __( 'Meal' )
			]
			, 'public' => true
			, 'has_archive' => false
			, 'show_in_rest' => true
			, 'rewrite' => [
				'slug' => __( 'meals' ),
				'with_front' => false
			]
			, 'supports' => ['title','thumbnail','editor']
			, 'extras' => [
				'auto_excerpt' => false
			]
		]
	);


	register_taxonomy('nsm_meal_skill_level', 'nsm_meals', array(
		'hierarchical' => true
		, 'labels' => array(
			'name' => _x( 'Skill Levels', 'taxonomy general name' )
			, 'singular_name' => _x( 'Skill Level', 'taxonomy singular name' )
			, 'search_items' =>  __( 'Search Skill Levels' )
			, 'popular_items' => __( 'Popular Skill Levels' )
			, 'all_items' => __( 'All Skill Levels' )
			, 'parent_item' => null
			, 'parent_item_colon' => null
			, 'edit_item' => __( 'Edit Skill Level' )
			, 'update_item' => __( 'Update Skill Level' )
			, 'add_new_item' => __( 'Add New Skill Level' )
			, 'new_item_name' => __( 'New Skill Level Name' )
			, 'separate_items_with_commas' => __( 'Separate Skill Levels with commas' )
			, 'add_or_remove_items' => __( 'Add or remove Skill Levels' )
			, 'choose_from_most_used' => __( 'Choose from the most used Skill Levels' )
			, 'menu_name' => __( 'Skill Levels' )
		)
		, 'show_ui' => true
		, 'show_admin_column' => true
		, 'update_count_callback' => '_update_post_term_count'
		, 'query_var' => true
		, 'show_in_rest' => true
	));


	register_taxonomy('nsm_meal_type', 'nsm_meals', array(
		'hierarchical' => true
		, 'labels' => array(
			'name' => _x( 'Meal Types', 'taxonomy general name' )
			, 'singular_name' => _x( 'Meal Type', 'taxonomy singular name' )
			, 'search_items' =>  __( 'Search Meal Types' )
			, 'popular_items' => __( 'Popular Meal Types' )
			, 'all_items' => __( 'All Meal Types' )
			, 'parent_item' => null
			, 'parent_item_colon' => null
			, 'edit_item' => __( 'Edit Meal Type' )
			, 'update_item' => __( 'Update Meal Type' )
			, 'add_new_item' => __( 'Add New Meal Type' )
			, 'new_item_name' => __( 'New Meal Type Name' )
			, 'separate_items_with_commas' => __( 'Separate Meal Types with commas' )
			, 'add_or_remove_items' => __( 'Add or remove Types' )
			, 'choose_from_most_used' => __( 'Choose from the most used Meal Types' )
			, 'menu_name' => __( 'Meal Types' )
		)
		, 'show_ui' => true
		, 'show_admin_column' => true
		, 'update_count_callback' => '_update_post_term_count'
		, 'query_var' => true
		, 'show_in_rest' => true
	));



	register_taxonomy('nsm_meal_food_type', 'nsm_meals', array(
		'hierarchical' => true
		, 'labels' => array(
			'name' => _x( 'Food Type', 'taxonomy general name' )
			, 'singular_name' => _x( 'Calorie', 'taxonomy singular name' )
			, 'search_items' =>  __( 'Search Food Types' )
			, 'popular_items' => __( 'Popular Food Types' )
			, 'all_items' => __( 'All Food Types' )
			, 'parent_item' => null
			, 'parent_item_colon' => null
			, 'edit_item' => __( 'Edit Food Type' )
			, 'update_item' => __( 'Update Food Type' )
			, 'add_new_item' => __( 'Add New Food Type' )
			, 'new_item_name' => __( 'New Type Name' )
			, 'separate_items_with_commas' => __( 'Separate Food Types with commas' )
			, 'add_or_remove_items' => __( 'Add or remove Food Types' )
			, 'choose_from_most_used' => __( 'Choose from the most used Food Types' )
			, 'menu_name' => __( 'Food Types' )
		)
		, 'show_ui' => true
		, 'show_admin_column' => true
		, 'update_count_callback' => '_update_post_term_count'
		, 'query_var' => true
		, 'show_in_rest' => true
	));

	register_taxonomy('nsm_meal_calories', 'nsm_meals', array(
		'hierarchical' => true
		, 'labels' => array(
			'name' => _x( 'Calories', 'taxonomy general name' )
			, 'singular_name' => _x( 'Calorie', 'taxonomy singular name' )
			, 'search_items' =>  __( 'Search Calories' )
			, 'popular_items' => __( 'Popular Calories' )
			, 'all_items' => __( 'All Calories' )
			, 'parent_item' => null
			, 'parent_item_colon' => null
			, 'edit_item' => __( 'Edit Calorie' )
			, 'update_item' => __( 'Update Calorie' )
			, 'add_new_item' => __( 'Add New Calorie' )
			, 'new_item_name' => __( 'New Calorie Name' )
			, 'separate_items_with_commas' => __( 'Separate Calories with commas' )
			, 'add_or_remove_items' => __( 'Add or remove Calories' )
			, 'choose_from_most_used' => __( 'Choose from the most used Calories' )
			, 'menu_name' => __( 'Calories' )
		)
		, 'show_ui' => true
		, 'show_admin_column' => true
		, 'update_count_callback' => '_update_post_term_count'
		, 'query_var' => true
		, 'show_in_rest' => true
	));


	register_taxonomy('nsm_meal_order_date', 'nsm_meals', array(
		'hierarchical' => true
		, 'labels' => array(
			'name' => _x( 'Order Date Available', 'taxonomy general name' )
			, 'singular_name' => _x( 'Order Date', 'taxonomy singular name' )
			, 'search_items' =>  __( 'Search Order Dates' )
			, 'popular_items' => __( 'Popular Order Dates' )
			, 'all_items' => __( 'All Order Dates' )
			, 'parent_item' => null
			, 'parent_item_colon' => null
			, 'edit_item' => __( 'Edit Order Date' )
			, 'update_item' => __( 'Update Order Date' )
			, 'add_new_item' => __( 'Add New Order Date' )
			, 'new_item_name' => __( 'New Type Name' )
			, 'separate_items_with_commas' => __( 'Separate Order Dates with commas' )
			, 'add_or_remove_items' => __( 'Add or remove Order Dates' )
			, 'choose_from_most_used' => __( 'Choose from the most used Order Dates' )
			, 'menu_name' => __( 'Order Dates' )
		)
		, 'show_ui' => true
		, 'show_admin_column' => true
		, 'update_count_callback' => '_update_post_term_count'
		, 'query_var' => true
		, 'show_in_rest' => true
	));





	register_post_type(
		
		'nsm_additional_items'
		, [
			'labels' => [
				'name' => __( 'Additional Items' )
				, 'singular_name' => __( 'Additional Item' )
			]
			, 'public' => true
			, 'has_archive' => false
			, 'show_in_rest' => true
			, 'rewrite' => [
				'slug' => __( 'jobs' ),
				'with_front' => false
			]
			, 'supports' => ['title','thumbnail','editor']
			, 'extras' => [
				'auto_excerpt' => false
			]
		]
	);


	register_taxonomy('nsm_additional_items_categories', 'nsm_additional_items', array(
		'hierarchical' => true
		, 'labels' => array(
			'name' => _x( 'Categories', 'taxonomy general name' )
			, 'singular_name' => _x( 'Category', 'taxonomy singular name' )
			, 'search_items' =>  __( 'Search Categories' )
			, 'popular_items' => __( 'Popular Categories' )
			, 'all_items' => __( 'All Categories' )
			, 'parent_item' => null
			, 'parent_item_colon' => null
			, 'edit_item' => __( 'Edit Category' )
			, 'update_item' => __( 'Update Category' )
			, 'add_new_item' => __( 'Add New Category' )
			, 'new_item_name' => __( 'New Type Name' )
			, 'separate_items_with_commas' => __( 'Separate Categories with commas' )
			, 'add_or_remove_items' => __( 'Add or remove Categories' )
			, 'choose_from_most_used' => __( 'Choose from the most used Categories' )
			, 'menu_name' => __( 'Categories' )
		)
		, 'show_ui' => true
		, 'show_admin_column' => true
		, 'update_count_callback' => '_update_post_term_count'
		, 'query_var' => true
		, 'show_in_rest' => true
	));




	// register_post_type(
	
	// 	'nsm_case_study_post'
	// 	, [
	// 		'labels' => [
	// 			'name' => __( 'Case Studies' )
	// 			, 'singular_name' => __( 'Case Study' )
	// 		]
	// 		, 'public' => true
	// 		, 'has_archive' => false
	// 		, 'show_in_rest' => true
	// 		, 'rewrite' => [
	// 			'slug' => __( 'case-studies' ),
	// 			'with_front' => false
	// 		]
	// 		, 'supports' => ['title','thumbnail','editor','excerpt']
	// 		, 'extras' => [
	// 			'auto_excerpt' => true
	// 		]
	// 	]
	// );


	// register_taxonomy('nsm_cs_categories', 'nsm_case_study_post', array(
	// 	'hierarchical' => true
	// 	, 'labels' => array(
	// 		'name' => _x( 'Categories', 'taxonomy general name' )
	// 		, 'singular_name' => _x( 'Category', 'taxonomy singular name' )
	// 		, 'search_items' =>  __( 'Search Categories' )
	// 		, 'popular_items' => __( 'Popular Categories' )
	// 		, 'all_items' => __( 'All Categories' )
	// 		, 'parent_item' => null
	// 		, 'parent_item_colon' => null
	// 		, 'edit_item' => __( 'Edit Category' )
	// 		, 'update_item' => __( 'Update Category' )
	// 		, 'add_new_item' => __( 'Add New Category' )
	// 		, 'new_item_name' => __( 'New Category Name' )
	// 		, 'separate_items_with_commas' => __( 'Separate locations with commas' )
	// 		, 'add_or_remove_items' => __( 'Add or remove locations' )
	// 		, 'choose_from_most_used' => __( 'Choose from the most used locations' )
	// 		, 'menu_name' => __( 'Categories' )
	// 	)
	// 	, 'show_ui' => true
	// 	, 'show_admin_column' => true
	// 	, 'update_count_callback' => '_update_post_term_count'
	// 	, 'query_var' => true
	// 	, 'show_in_rest' => true
	// ));


	// Helper Functions for accessing terms associated with a post


	function get_custom_post_terms($post_id, $taxonomy, $class)
	{
		$terms = get_the_terms($post_id, $taxonomy);

		$cats='';
		
		if($terms)
		{
			foreach ($terms as $term) {
				$cats .= '<span class="' . $class .'">' . $term->name . '</span>';
			}
		}
		
		return $cats;

	}


	function get_custom_post_terms_simple($post_id, $taxonomy, $class)
	{
		$terms = get_the_terms($post_id, $taxonomy);

		$cats='';
		
		if($terms)
		{
			foreach ($terms as $term) {
				$cats .= $term->name . ', ';
			}
		}
		$cats = rtrim($cats, ', ');
		return $cats;

	}


	function is_available_this_week($post_id) {
		return has_term(get_next_order_date()->format('Y/m/d'), 'nsm_meal_order_date',$post_id);
	}












