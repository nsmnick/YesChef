<?php

if ((isset($_GET['key']) && $_GET['key'] == '1234') || (isset($argv) && $argv[1] == 'key=1234')) {

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require_once(__DIR__ . '/../../../wp-load.php');
	require_once(__DIR__ . '/vendor/autoload.php');

	$importers = [
		'docuwareJobsImporter',
	];

	$exporters = [

	];

	$gbjf = new nsm\nsmJobsFeed\nsmJobsFeed($importers, $exporters);
	echo "Importing!\n";
	$status = $gbjf->cron();

	echo '<pre>'.print_r($status, true).'</pre>';


}
