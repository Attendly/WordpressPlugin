<?php
 // event on calendar http://jsfiddle.net/Zrz9t/1151/
?>
<style>
table.ui-datepicker-calendar tbody td.highlight > a {
    background: url("images/ui-bg_inset-hard_55_ffeb80_1x100.png") repeat-x scroll 50% bottom #FFEB80;
    color: #363636;
    border: 1px solid #FFDE2E;
}
</style>
<script>
jQuery(document).ready(function() {

	function at_add_datepicker_events(){
		jQuery("#datepicker").datepicker({
		    beforeShowDay: function(date) {
			    var item_index = null;
		        var result = [true, '', null];

		        var match_json = jQuery.grep(_aeevents_json, function(event,index) {
			        var s_date = new Date(event.e_start.split(" ").slice(0,1));
			        if ( s_date.getFullYear() == date.getFullYear()
					        && s_date.getMonth() == date.getMonth()
					        && s_date.getDate() == date.getDate() ){
				        console.log("MATCHED");
				        item_index = index;
				        return true;
			        }else{
		            	return false;
			        }
		        });

		        if (match_json.length) {
		            result = [true, 'highlight', _aeevents_json[item_index].e_name];
		        }
		        return result;
		    },
		    onSelect: function(dateText) {
			    //console.log(dateText);
		        var date,
		            selectedDate = new Date(dateText),
		            i = 0,
		            event = null;

		        while (i < events.length && !event) {
		            date = events[i].Date;

		            if (selectedDate.valueOf() === date.valueOf()) {
		                event = events[i];
		            }
		            i++;
		        }
		        if (event) {
		            alert(event.Title);
		        }
		    }
		});
	}

	//timeout_id = window.setTimeout(data_check, 100);
	var timeout_id = setInterval(data_check,100);

	function data_check(){
		if(typeof _aeevents_json !== 'undefined'){
			window.clearInterval(timeout_id);
			at_add_datepicker_events();
		}else{
			console.log("Checking for DAta");
			//timeout_id = window.setTimeout(data_check, 100);
			console.log("__--__--");
		}
	}
});
	</script>