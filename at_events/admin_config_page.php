<?php

$user_name = get_option(AT_EVENTS_USERNAME_OPTION);
if (isset($_POST['event_settings']))
{
	check_admin_referer('at_event_settings_save');
	// change settings

	$message = "Updated Settings";
}

if (empty($user_name))
{
	$message = 'Before you can use this plugin, you need to enter your username. If you don\'t have a username, you can <a href="http://attendly.me/register">register for one here</a>';
}
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>Event Display Settings</h2>

<?php if (isset($message)) :?>
<div id="message" class="updated below-h2"><p><?php echo $message?></p></div>
<?php endif;?>

<?php if (isset($error)) :?>
<div id="error" class="updated below-h2"><p><?php echo $message?></p></div>
<?php endif;?>

<?php echo '<p><em>v.'.AT_VERSION.'</em></p>'; ?>

<form name="event_display_settings" method="post" action="options.php">
<input type="hidden" name="event_settings" value="submit" />
<?php settings_fields('at_events-group'); ?>
<h3>Account Settings</h3>
<table class="form-table">
	<tr valign="top">
    <th scope="row">User name</th>
    <td><input type="text" name="<?php echo AT_EVENTS_USERNAME_OPTION; ?>" value="<?php echo $user_name ?>" /></td>
    </tr>
    <tr valign="top">
     <th scope="row">Server</th>
    <td><?php echo AT_EVENT_SCRIPT_HOST; ?></td>
    </tr>
</table>
<?php submit_button(); ?>
</form>

<?php
if ( ! empty($user_name))
{
	$action='nothing';
	$username= get_option(AT_EVENTS_USERNAME_OPTION); // 'bobby3';
	require_once plugin_dir_path(__FILE__).'at_events_js_load.php';
?>
<h3>Event List for <?php echo $user_name;?></h3>
<table class="widefat" id="event-table">
	<thead>
	<tr>
		<th>Event Status</th>
		<th>Event Name</th>
		<th>Tickets Sold</th>
		<th>Time Left</th>
		<th>Shortcode</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th>Event Status</th>
		<th>Event Name</th>
		<th>Tickets Sold</th>
		<th>Time Left</th>
		<th>Shortcode</th>
	</tr>
	</foot>
	<tbody>
	</tbody>
</table>
<style>
.available{ }
.selling_btn{ }
.soldout_btn{ }
</style>
<?php add_thickbox(); ?>
<script>
jQuery(document).ready(function(){
	// set up a spinner to wait for the data to be avaiable
	node = jQuery('<tr id="wait"><td colspan="5"> Waiting for data ...</td></tr>');
	jQuery("#event-table tbody").append(node);

	timeout_id = setTimeout(data_check, 100);

	function data_check(){
		if(typeof _aeevents_json !== 'undefined'){
			window.clearTimeout(timeout_id);
			jQuery("tr#wait").remove();
			jQuery.each(_aeevents_json, function() {
				console.log(this);
				//console.log("\n\n\n\n\n");
				var line = jQuery('<tr></tr>');
				line.append('<td><span class="'+this.ticket_status+'">'+this.ticket_status_text+'</span></td>');
				line.append('<td><a href="'+this.e_url+'?TB_iframe=true&width=600&height=550" class="thickbox">'+this.e_name+'</a></td>');
				line.append('<td>'+this.tp_count+' / '+this.to_total+'</td>');
				line.append('<td>'+this.days_to_go+'</td>');
				line.append('<td>[<?php echo AT_EVENT_SHORTCODE;?> id='+this.e_id+']</td>');
				jQuery("#event-table tbody").append(line);
				});
		}else{
			timeout_id = setTimeout(data_check, 100);
		}
	}
});

</script>
<?php } ?>
<h3>Instructions</h3>
<div class="">
<h4>Adding Events to your site</h4>
<ul>
<li>Add the individual Event Using one of the short codes in the table above</li>
<li>Add all the events to a page or post using the shortcode<pre>[<?php echo AT_EVENT_SHORTCODE; ?>]</pre></li>
<li>Use the Events widget in your theme</li>
<li>Use the Calander shortcode on a page <pre>[<?php echo AT_CALENDAR_SHORTCODE?>]</pre></li>
</ul>
</div>
</div>