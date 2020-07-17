<?php

// Disable front end wp admin menu.
add_filter('show_admin_bar', '__return_false');


// Prevent user enumeration
if (!is_admin() && isset($_SERVER['REQUEST_URI'])) {
	if (preg_match('/(wp-comments-post)/', $_SERVER['REQUEST_URI']) === 0 && !empty($_REQUEST['author'])) {
		openlog('wordpress('.$_SERVER['HTTP_HOST'].')', LOG_NDELAY|LOG_PID,LOG_AUTH);
		syslog(LOG_INFO, "Attempted user enumeration from {$_SERVER['REMOTE_ADDR']}");
		closelog();
		wp_die('Forbidden');
	}
}


// remove version from scripts and styles
function shapeSpace_remove_version_scripts_styles($src) {
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);




function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
}
add_action('init', 'removeHeadLinks');


add_filter('the_generator', '__return_empty_string');
add_filter( 'xmlrpc_enabled', '__return_false' );

