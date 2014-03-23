		</div>
		<div id="footer">
	</div>
	
	<? if ($is_logged_in) include ("tool-box.php"); ?>

<div class="nos">
<?php
 if (DO_MAKE_STATS) {
?>
<script language='javascript' type='text/javascript' src='http://www.persianstat.com/service/stat.js'></script>
<script language='javascript' type='text/javascript'>
persianstat(10150946, 0);
</script>
<?php
}
?>
</div>
</body>
</html>

<?php
	/**
	$this->benchmark->mark('log_footer');
	log_message('error', "Time [ " . $this->benchmark->elapsed_time('total_execution_time_start','log_footer') . " ] - URL: " .current_url() . " @ " . nowDate());
	/**/
?>
