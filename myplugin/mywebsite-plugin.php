<?php
/*
Plugin Name: Site Plugin for Events Task
Description: Site specific code changes for Events Task
*/


// Exit if accessed directly
if(!defined('ABSPATH')){
	exit();
}

$dir = plugin_dir_path(__FILE__);

require_once ($dir. 'wp_events_custom_post_type.php');
require_once ($dir. 'wp_event_fields.php');

//This function add custom JS and CSS for Admin - Events
function mywp_admin_scripts(){
	global $pagenow, $typenow;
	
	if(($pagenow == 'post.php'|| $pagenow == 'post-new.php') && $typenow == 'events'){
		wp_enqueue_style('wp_events_css', plugins_url('css/wp_events_css.css', __FILE__));
		wp_enqueue_script('wp_events_js', plugins_url('js/wp_events_js.js', __FILE__), array('jquery', 'jquery-ui-datepicker'), '20201120', true);
		
		wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
	}
}

add_action('admin_enqueue_scripts', 'mywp_admin_scripts');
?>