<?php
?>
<script type='text/javascript'>

    jQuery(document).ready(function() {

    	timeout_id = setTimeout(data_check, 100);

    	function data_check(){
    		if(typeof _aeevents_json !== 'undefined'){
    			window.clearTimeout(timeout_id);
				events_array = [];
    			jQuery.each(_aeevents_json, function() {
    				events_array.push({
        				id: this.e_id,
        				title:this.e_name,
        				start: this.e_start,
        				url:this.e_url
        				});
    				});
    			jQuery('#calendar').fullCalendar({
    				editable: false,
    				theme: <?php echo $theme_support;?>,
    			    events: events_array,
    			    eventRender: function(event, element) {
    	                element.append('<span><?php echo AT_EVENT_CAL_DESC;?></span>');
    	                }
	            });
    		}else{
    			timeout_id = setTimeout(data_check, 100);
    		}
    	}
    });

</script>
