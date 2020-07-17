<?php
/**
 * Plugin Name: nsm Job Feed Importer
 * Plugin URI: https://nsmdigital.com
 * Description: Imports jobs into Wordpress
 * Version: 1.0.0
 * Author: Nick Morley
 * Author URI: https://nsmdigital.com
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
require __DIR__ . '/vendor/autoload.php';

$importers = [
	'docuwareJobsImporter'
];

$exporters = [

];

$gbjf = new nsm\nsmJobsFeed\nsmJobsFeed($importers, $exporters);
add_action('init', array($gbjf, 'init'));

