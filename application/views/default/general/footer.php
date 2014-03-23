
		</div>
			
	</div>
	<div id="bot"></div>
	<?php
		$this->benchmark->mark('log_footer');
		log_message('error', "Time [ " . $this->benchmark->elapsed_time('total_execution_time_start','log_footer') . " ] - URL: " .current_url() . " @ " . nowDate());
	?>
</body>
</html>
