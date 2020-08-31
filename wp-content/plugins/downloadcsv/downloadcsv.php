<?php
/*
Plugin Name: Download CSV
Author: Mike Schinkel
Author URI: http://mikeschinkel.com
 */
if (!class_exists('DownloadCSV')) {
  class DownloadCSV {
    static function on_load() {
      add_action('plugins_loaded',array(__CLASS__,'plugins_loaded'));
      add_action('admin_menu',array(__CLASS__,'admin_menu'));
      register_activation_hook(__FILE__,array(__CLASS__,'activate'));
    }
    static function activate() {
      $role = get_role('administrator');
      $role->add_cap('download_csv');
    }
    static function admin_menu() {
      add_submenu_page('tools.php',    // Parent Menu
        'Download CSV',                // Page Title
        'Download CSV',                // Menu Option Label
        'download_csv',                // Capability
        'tools.php?download=data.csv');// Option URL relative to /wp-admin/
    }
    static function plugins_loaded() {
      global $pagenow;
      if ($pagenow=='tools.php' && 
          current_user_can('download_csv') && 
          isset($_GET['download'])  && 
          $_GET['download']=='data.csv') {
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=data.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo 'data';
        exit();
      }
    }
  }
  DownloadCSV::on_load();
}