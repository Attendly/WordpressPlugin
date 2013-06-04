<?php
if ( ! class_exists('at_Calendar'))
{
	class at_Calendar{

		var $current_time;
		var $html;

		public function __construct()
		{
			$this->html = '<div id="datepicker" style="font-size:11px"></div>';
		}

		public function render()
		{
			echo $this->html;
			require_once plugin_dir_path(__FILE__).'../at_cal_js_load.php';

		}
	}
}