<?php
namespace nsm\nsmJobsFeed;

class nsmJobsFeed
{
	public $gbjf_version = '1.0.0';
	public $importers = [];
	public $exporters = [];

	public function __construct($importer_classes = [], $exporter_classes = [])
	{
		$this->importers = $importer_classes;
		$this->exporters = $exporter_classes;
	}

	public function init()
	{



		// JOBS


		// register_post_type(
		
		// 	'gbjf_job_post'
		// 	, [
		// 		'labels' => [
		// 			'name' => __( 'Jobs' )
		// 			, 'singular_name' => __( 'Job' )
		// 		]
		// 		, 'public' => true
		// 		, 'has_archive' => false
		// 		, 'show_in_rest' => true
		// 		, 'rewrite' => [
		// 			'slug' => __( 'jobs' )
		// 		]
		// 		, 'extras' => [
		// 			'auto_excerpt' => true
		// 		]
		// 	]
		// );


	
		// register_taxonomy('gbjf_locations', 'gbjf_job_post', array(
		// 	'hierarchical' => true
		// 	, 'labels' => array(
		// 		'name' => _x( 'Locations', 'taxonomy general name' )
		// 		, 'singular_name' => _x( 'Location', 'taxonomy singular name' )
		// 		, 'search_items' =>  __( 'Search Locations' )
		// 		, 'popular_items' => __( 'Popular Locations' )
		// 		, 'all_items' => __( 'All Locations' )
		// 		, 'parent_item' => null
		// 		, 'parent_item_colon' => null
		// 		, 'edit_item' => __( 'Edit Location' )
		// 		, 'update_item' => __( 'Update Location' )
		// 		, 'add_new_item' => __( 'Add New Location' )
		// 		, 'new_item_name' => __( 'New Location Name' )
		// 		, 'separate_items_with_commas' => __( 'Separate locations with commas' )
		// 		, 'add_or_remove_items' => __( 'Add or remove locations' )
		// 		, 'choose_from_most_used' => __( 'Choose from the most used locations' )
		// 		, 'menu_name' => __( 'Locations' )
		// 	)
		// 	, 'show_ui' => true
		// 	, 'show_admin_column' => true
		// 	, 'update_count_callback' => '_update_post_term_count'
		// 	, 'query_var' => true
		// 	, 'show_in_rest' => true
		// ));


		// register_taxonomy('gbjf_programmes', 'gbjf_job_post', array(
		// 	'hierarchical' => true
		// 	, 'labels' => array(
		// 		'name' => _x( 'Programmes', 'taxonomy general name' )
		// 		, 'singular_name' => _x( 'Programme', 'taxonomy singular name' )
		// 		, 'search_items' =>  __( 'Search Programmes' )
		// 		, 'popular_items' => __( 'Popular Programmes' )
		// 		, 'all_items' => __( 'All Programmes' )
		// 		, 'parent_item' => null
		// 		, 'parent_item_colon' => null
		// 		, 'edit_item' => __( 'Edit Programme' )
		// 		, 'update_item' => __( 'Update Programme' )
		// 		, 'add_new_item' => __( 'Add New Programme' )
		// 		, 'new_item_name' => __( 'New Programme Name' )
		// 		, 'separate_items_with_commas' => __( 'Separate Programmes with commas' )
		// 		, 'add_or_remove_items' => __( 'Add or remove Programmes' )
		// 		, 'choose_from_most_used' => __( 'Choose from the most used Programmes' )
		// 		, 'menu_name' => __( 'Programmes' )
		// 	)
		// 	, 'show_ui' => true
		// 	, 'show_admin_column' => true
		// 	, 'update_count_callback' => '_update_post_term_count'
		// 	, 'query_var' => true
		// 	, 'show_in_rest' => true
		// ));




		








		//add_action('gbjf_cron', array($this, 'cron'));

		if (is_admin()) {
			register_activation_hook(__FILE__, array($this, 'install'));
			register_deactivation_hook(__FILE__, array($this, 'deactivate'));
			register_uninstall_hook(__FILE__, array('nsm\\nsmJobsFeed', 'uninstall'));

			add_action('plugins_loaded', array($this, 'updateCheck'));
		}

	}

	public function install()
	{
		$installed_ver = get_option( "gbjf_version" );

		if ( $installed_ver != $this->gbjf_version ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			update_option( "gbjf_version", $this->gbjf_version );
		}
		flush_rewrite_rules();

		//wp_schedule_event(time(), 'hourly', 'gbjf_cron');
	}

	public function updateCheck()
	{
		if ( get_site_option( 'gbjf_version' ) != $this->gbjf_version ) {
			$this->install();
		}
	}

	public function deactivate()
	{
		flush_rewrite_rules();
		//wp_clear_scheduled_hook('gbjf_cron');
	}

	static public function uninstall()
	{
		$option_names = array(
			'gbjf_db_version'
		);

		foreach ($option_names as $option_name) {
			delete_option( $option_name );
			delete_site_option( $option_name );
		}
	}

	public function cron()
	{
		$feed_status = [];

		// Find each importer class, instantiate it and run the import.
		foreach ($this->importers as $importer) {
			$importer_classname = 'nsm\\nsmJobsFeed\\Importers\\'.$importer;
			$feed_status[$importer_classname] = (new $importer_classname())->import();
		}

		foreach ($this->exporters as $exporter) {
			$exporter_classname = 'nsm\\nsmJobsFeed\\Exporters\\'.$exporter;
			$feed_status[$exporter_classname] = (new $exporter_classname())->export();
		}

		return $feed_status;
	}

}