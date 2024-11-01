<?php
/*
Plugin Name: Social GoDownload (FREE)
Version: 1.0
Author URI: http://www.gopymes.pe/
Plugin URI: http://blog.gopymes.pe/
Description: This plugin is a Social Download Manager.  For download first you have to share it at least in one social network. The version FREE has the Twitter Button.
Author: Alexander Gonz&aacute;les
*/
?>
<?php
// Insert pluggable.php before calling get_currentuserinfo()
require (ABSPATH . WPINC . '/pluggable.php');
require_once WP_PLUGIN_DIR.'/social-godownload/godownload.class.php';

/*	Class	*/
$godow = new godownload();
global $current_user;
get_currentuserinfo();

/*	Active the plugin	*/
add_action('activate_social-godownload/index.php',array(&$godow,'active'));
add_action('init',array(&$godow,'process')); //Download File
add_action('wp_head', array(&$godow,'add_header'));

/*	Short code	*/
add_shortcode('godow', array(&$godow,'show_godow'));

/*	Can edit at admin panel	*/
$userlevel = (int) substr(get_option('godownload_userlevel'),6);
if ($userlevel  <= $current_user->user_level) add_action('admin_menu', array(&$godow,'add_menu'));

?>