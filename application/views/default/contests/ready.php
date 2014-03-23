<script type="text/javascript" language="javascript">
	function formatTime(secs){
		var times = new Array(3600, 60, 1);
		var time = '';
		var tmp;
		for(var i = 0; i < times.length; i++){
			tmp = Math.floor(secs / times[i]);
			if(tmp < 1) tmp = '00';
			else if(tmp < 10) tmp = '0' + tmp;
			time += tmp;
			if(i < 2) time += ':';
			secs = secs % times[i];
		}
		return time;
	}
	var T;
	function update_countdown() {
		(function ($) {
			var seconds = parseInt($("#contest_info_time").html());		
			if (seconds == 0) {
				window.location.replace(window.location.href);
				clearInterval(T);
				return;
			}
			seconds--;
			$("#countdown").html(formatTime(seconds));
			$("#contest_info_time").html(seconds);
		})(jQuery);
	}
	jQuery(function () {
		update_countdown();
		T = setInterval("update_countdown()",998);
	});

</script>


		<div class="bar">Contest :: <?=clean4print($contest->label)?></div>
		<div class="container-top"></div>
		<div class="container">
			
				<div id="contest_ready">
					<center><h2>Ready to go!</h2></center><br />
					<p>Please wait! the contest will start at </p><?=$contest->starttime?><br /><br />
					<h1 id="countdown">ds</h1>
				</div>
				<div id="contest_info_time" class="hidden"><?=$countdown_seconds?></div>
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>
		