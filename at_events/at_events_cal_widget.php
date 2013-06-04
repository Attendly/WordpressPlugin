<?php
/**
 * Adds at_Calendar_Widget widget.
*/
class at_Calendar_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'at_calendar_widget', // Base ID
				'Event Calendar Widget', // Name
				array( 'description' => 'An Event Calendar Widget' ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty($title))
		{
			echo $before_title.$title.$after_title;
		}

		$action='nothing';
		$username= get_option(AT_EVENTS_USERNAME_OPTION);
		$script_params = '+"&tag_id=widget_calendar&var_name=_aecalevent"';
		require plugin_dir_path(__FILE__).'at_events_js_load.php';
		echo '<div id="widget_calendar"></div>';
		require_once plugin_dir_path(__FILE__).'classes/calendar.class.php';
		$cal = new at_Calendar;
		$cal->render();
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['theme'] = $new_instance['theme'];

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if (isset($instance[ 'title' ]))
		{
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<label for="<?php echo $this->get_field_id('theme'); ?>">Theme :</label>
		<select class="widefat" id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>">
		<?php echo $this->get_themes_as_options($instance);?>
		</select>
		</p>
		<?php
	}

	private function get_themes_as_options($instance)
	{
		$out = '<option value="none">NONE</option>';

		$dir = dirname(__FILE__).'/themes';

		if ($handle = opendir($dir)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != '.' && $entry != '..')
				{
					$out .= '<option value="'.$entry.'"';
					if ($entry == $instance['theme'])
					{
						$out .= 'selected="selected" ';
					}
					$out .= '>'.$entry.'</option>';
				}
			}
		closedir($handle);
		}
		return $out;
	}

} // class at_Events_Widget
