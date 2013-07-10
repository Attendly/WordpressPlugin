<?php
/*
Plugin Name: Remote Events Display
Plugin URI: http://attendly.com
Description: Display Remote Events with shortcode, widget or function call.
	(Uses remote javascript and requires external account)
Version: 1.2
Author: attendly.com
Author URI: http://attendly.com
License: A "Slug" license name e.g. GPL2
*/

define('AT_EVENTS_PLUGIN', TRUE);
define('AT_EVENT_SHORTCODE', 'at_event');
define('AT_CALENDAR_SHORTCODE', 'at_event_calendar');
define('AT_EMBED_SHORTCODE', 'at_event_embed');
define('AT_EVENT_SCRIPT_HOST', 'https://dev.attendly.ws' );
define('AT_EVENTS_USERNAME_OPTION', 'at_events_username');
define( 'AT_EVENTS_PATH', plugins_url().'/at_events/'); //  );
define( 'AT_EVENT_CAL_DESC', 'View Event');
define( 'AT_VERSION', '1.2');

require_once 'classes/at_events.class.php';

require_once 'at_events_widget.php';
add_action( 'widgets_init', function(){
	register_widget( 'at_Events_Widget' );
});

require_once 'at_events_cal_widget.php';
add_action( 'widgets_init', function(){
	register_widget( 'at_Calendar_Widget' );
});

$my_at_events_plugin = new at_Events_Plugin;
