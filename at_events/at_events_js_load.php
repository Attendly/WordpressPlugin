<?php
?>
<script type="text/javascript">

  var _aename='<?php echo $username;?>';
  var _aeaction='<?php echo $action;?>';

  (function() {
    var ae = document.createElement('script'); ae.type = 'text/javascript'; ae.async = true;
    ae.src = '<?php echo AT_EVENT_SCRIPT_HOST; ?>/js/'+_aeaction+'?u='+_aename+'&t='+(new Date()).getTime()<?php echo $script_params;?>;
    var s0 = document.getElementsByTagName('script')[0]; s0.parentNode.insertBefore(ae, s0);
  })();

</script>