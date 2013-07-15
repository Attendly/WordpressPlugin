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
				        // console.log("MATCHED");
				        // console.log(date);
				        item_index = index;
				        return true;
			        }else{
		            	return false;
			        }
		        });

		        if (match_json.length) {
		            result = [true, 'highlight', _aeevents_json[item_index].e_name];
		            _aeevents_json[item_index].display_date = date.valueOf();
		        }
		        return result;
		    },
		    onSelect: function(dateText) {
		        var date,
		            s_date = new Date(dateText),
		            i = 0,
		            event = null;

		        while (i < _aeevents_json.length && _aeevents_json) {
			        if(_aeevents_json[i].display_date){
			            var date = _aeevents_json[i].display_date;
						if ( s_date.valueOf() == date){
			                event = _aeevents_json[i];
			            }
			        }
		            i++;
		            date = null;
		        }
		        if (event) {
		            window.location = event.e_url;
		        }
		    }
		});
	}

	var timeout_id = setInterval(data_check,100);
	var call_count = 0;
	var timeout_limit = 70;

	function data_check(){
		if(typeof _aeevents_json !== 'undefined' ||
				call_count >= timeout_limit){
			window.clearInterval(timeout_id);
			if(call_count < timeout_limit){
				at_add_datepicker_events();
			}
		}else{
			// console.log(call_count++);
		}
	}
});
	</script>