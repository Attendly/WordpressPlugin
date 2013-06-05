<?php
if ( ! class_exists("at_Events_Plugin"))
{
	class at_Events_Plugin {

		public function __construct()
		{
			add_action('init', array (__CLASS__, 'init'), 0);
			add_action('wp_head', array(__CLASS__, 'wp_head'));
			add_action('admin_init', array (__CLASS__, 'admin_init'));
			add_action('admin_menu', array (__CLASS__, 'admin_menu'));

			add_shortcode(AT_EVENT_SHORTCODE, array(__CLASS__, 'event_shortcode'));
			add_shortcode(AT_CALENDAR_SHORTCODE, array(__CLASS__, 'calendar_shortcode'));

			//	add_filter ( 'the_content', array(__CLASS__, 'filterContent') );

		}

		public function init()
		{
			// calendar shortcode
			wp_enqueue_script('jquery');
			wp_register_script('fullcalendar',
					AT_EVENTS_PATH.'js/fullcalendar.min.js',
					'jquery');
			wp_register_script('fullcalander-ui',
					AT_EVENTS_PATH.'js/jquery-ui-1.10.2.custom.min.js',
					'jquery');
			wp_enqueue_script('fullcalendar');
			wp_enqueue_script('fullcalendar-ui');

			wp_enqueue_style('fullcalendar',
					AT_EVENTS_PATH.'css/fullcalendar.css');

			// widget calendar
			$widget_options = get_option("widget_at_calendar_widget");
			if (is_array($widget_options))
			{
				wp_enqueue_script('jquery-ui-datepicker');
				foreach ($widget_options as $k=>$v)
				{
					if (isset($v['theme']) && $v['theme'] != 'none')
					{
						wp_enqueue_style('jquery-style',
								AT_EVENTS_PATH.'themes/'.$v['theme'].'/jquery-ui.min.css');
					}
				}
			}


		}

		public function wp_head()
		{
			echo '<!-- Power to the people -->'."\n";
		}

		public function add_event_javscript($action='display')
		{
			$username = get_option(AT_EVENTS_USERNAME_OPTION);// 'bobby3';
			require_once plugin_dir_path(__FILE__).'../at_events_js_load.php';
		}

		public function admin_init()
		{
			register_setting( 'at_events-group', AT_EVENTS_USERNAME_OPTION );

		}

		public function admin_menu()
		{

			add_options_page('Events', 'Events', 'manage_options', 'events',
					array (__CLASS__, 'admin_options_page'));
		}

		/**
		 * Admin page option
		 *
		 * Note: while in this function we are not in the scope of this
		 * object instance
		 */
		public function admin_options_page()
		{
			require plugin_dir_path(__FILE__).'../admin_config_page.php';
		}

		public function calendar_shortcode($attr)
		{
			extract(shortcode_atts(array(
					'id' => false,
					'action' => 'display',
					'div_id' => 'eventholder',
					'theme_support' => 'false'
			), $atts));
			$username = get_option(AT_EVENTS_USERNAME_OPTION);
			$action='nothing';
			ob_start();
			require_once plugin_dir_path(__FILE__).'../at_events_js_load.php';
			require_once plugin_dir_path(__FILE__).'../at_events_js_calendar_view.php';
			$content = ob_get_contents();
			ob_end_clean();
			return $content.'<div id="calendar"></div>';

		}

		public function event_shortcode($atts)
		{
			extract(shortcode_atts(array(
					'id' => false,
					'action' => 'display',
					'div_id' => 'eventholder'
			), $atts));

			$username = get_option(AT_EVENTS_USERNAME_OPTION);
			$script_params = '';

			if ($div_id != 'eventholder')
			{
				$script_params .= '+"&tag_id='.$div_id.'"';
			}

			if ($id)
			{
				$script_params .= '+"&e_id='.$id.'"';
			}

			ob_start();
			require plugin_dir_path(__FILE__).'../at_events_js_load.php';
			$content = ob_get_contents();
			ob_end_clean();
			return $content.'<div id="'.$div_id.'"></div>';
		}
	}
}