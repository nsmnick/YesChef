<?php 


// MEALS REPORT



add_action('admin_menu', 'pick_list_report_create');
function pick_list_report_create() {
    $page_title = 'Reports';
    $menu_title = 'Reports';
    $capability = 'edit_posts';
    $menu_slug = 'global_text';
    $function = 'my_meal_picking_list_report';
    $icon_url = '';
    $position = 24;

    if( current_user_can('editor') || current_user_can('administrator') ) {
    	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    }
}


function my_meal_picking_list_report() {

}