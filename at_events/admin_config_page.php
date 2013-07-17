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
	$message = 'Before you can use this plugin, you need to enter your username.
	 If you don\'t have a username, you can
	<a href="http://attendly.me/register">register for one here</a>';
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
    <td><input type="text" name="<?php echo AT_EVENTS_USERNAME_OPTION;
    		 ?>" value="<?php echo $user_name ?>" /></td>
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
	$username= get_option(AT_EVENTS_USERNAME_OPTION);
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
			if (_aeevents_json == false){
				jQuery("tr#wait td").html("There are no current events for this user.");
			}else{
			jQuery("tr#wait").remove();

			jQuery.each(_aeevents_json, function() {
				//console.log(this);
				//console.log("\n\n\n\n\n");
				var line = jQuery('<tr></tr>');
				line.append('<td><span class="'+this.ticket_status+'">'+this.ticket_status_text+'</span></td>');
				line.append('<td><a href="'+this.e_url+'?TB_iframe=true&width=600&height=550" class="thickbox">'+this.e_name+'</a></td>');
				line.append('<td>'+this.tp_count+' / '+this.to_total+'</td>');
				line.append('<td>'+this.days_to_go+'</td>');
				line.append('<td>[<?php echo AT_EVENT_SHORTCODE;?> id='+this.e_id+']</td>');
				jQuery("#event-table tbody").append(line);
				});
			}
		}else{
			timeout_id = setTimeout(data_check, 100);
		}
	}
});

</script>

<h3>Instructions</h3>
<div class="">
<h4>ShortCodes</h4>

<p>Shortcodes (<a href="http://wp.smashingmagazine.com/2012/05/01/wordpress-shortcodes-complete-guide/" target="_blank">more...</a>) let you add fancy content to your Wordpress site without having to bother with tricky programming.<br />
When a shortcode is inserted in a WordPress post or page, it is replaced with some other content.</p>

<p>You can use three kinds of shortcodes to display your events on a Wordpress site.</p>
<ol>
<li> A calendar page<br/>
	Use the shortcode <code>[at_event_calendar]</code> to create a large navigable calendar.
</li>
<li>Purchase tickets<br />
	Use the shortcode <code>[at_event_embed id=2347]</code> to create a box where attendees can purchase tickets to your event. Replace 2347 with your event's id number.<br />
	You can change the height of your box by adding a setting for height (in pixels) like this: <code>[at_event_embed id=2347 height="300px"]</code>
</li>
<li>A list of all your current events<br />

Use the shortcode <code>[at_event_embed]</code> to show a list of all of your current events. <br />

If you just want to list one of your events, add the event's id number like this: <code>[at_event_embed id=2347]</code><br />

This shortcode will show one event ONLY.<br />
 If you want to show more than one event, you need to add a new shortcode for each one, with a div_id, like this:<br />
<code>[at_event id=2347 div_id=item_1] [at_event id=2349 div_id=item_2]</code>
</li>
</ol>


<h4>Widget Support</h4>
<p>There are two widgets supplied with this plugin. If your theme supports widgets (not all of them do), you can use either of these two widgets:</p>
<ol>
<li>Calendar<br />
Shows a small, navigable calendar with your event dates highlighted
</li>
<li>Events List<br />
Shows a list of your event descriptions
</li>
</ol>
<p>
If you're logged in to Wordpress, you'll find these with all of your other widgets under the 'appearance' menu for your site. <br />
You can find more information about setting up widgets here: <a href="http://codex.wordpress.org/WordPress_Widgets">http://codex.wordpress.org/WordPress_Widgets</a>
</p>
<!-- <h4>Short Codes</h4>
<blockquote>"Introduced in WordPress 2.5 is the Shortcode API, a simple set of functions for creating macro codes for use in post content"</blockquote>
<p>This plugin allows three types of shortcodes use the event id</p>
<ol>
	<li>A calander page <pre>[<?php echo AT_CALENDAR_SHORTCODE?>]</pre> creates a large navigatable calander</li>
	<li>A ticket purchase embed directly from the event website <pre>[<?php echo AT_EMBED_SHORTCODE?> id=2347]</pre> where the id is the event id number<br>
		you can optionally set the height, in pixels, of the iframe this creates using <pre>[<?php echo AT_EMBED_SHORTCODE?> id=2347 height="300px"]</pre>
	</li>
	<li>A list of all your current events  <pre>[<?php echo AT_EMBED_SHORTCODE?>]</pre>
	This code can also display a single event if passed the event id <pre>[<?php echo AT_EMBED_SHORTCODE?> id=2347]</pre>
	(IMPORTANT : only one shortcode showing a sinle event can be displayed)<br />
	</li>
	<li>To add more than one shortcode for a single event you <strong>must</strong> set a different div_id attribute in each shortcode.<br />
	For example <pre>[<?php echo AT_EVENT_SHORTCODE; ?> id=2347 div_id=item_1] [<?php echo AT_EVENT_SHORTCODE; ?> id=2347 div_id=item_2]</pre>
</ol>

<h4>Widget Support</h4>
<p>If your theme supports Widgets there are two widgets supplied with this plugin<p>
<p>
<ol>
	<li>A Calander Widget<br />
	This displays a small calander which can be navigated with your event dates highlighted</li>
	<li>An Events List Widget<br />
	Shows a list of your event descriptions</li>
</ol>
-->
</div>
<?php } ?>
</div>