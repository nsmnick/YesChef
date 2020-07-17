<?php 

// Custom menus.
function custom_init() {
	register_nav_menu('main-menu', 'Primary Menu');
	register_nav_menu('footer-menu', 'Footer Menu');
}
add_action('init', 'custom_init');
