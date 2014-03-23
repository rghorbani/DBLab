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
			
				<div id="contest_detail">
					<center><h1 id="countdown"></h1></center><br />
					<p align="center">The contest will be finished at<br /><?=ts2date(date2ts($contest->starttime)+$contest->length)?></p>
					<div id="contest_info_time" class="hidden"><?=$countdown_seconds?></div>
					<h2>Problems</h2><br />
					<?php
						foreach ($problems as $problem) {
					?>
					<a href="<?=site_url("contests/problem/" . $contest->id . "/" . $problem->letter)?>" style="border-left:7px <?=$problem->color?> solid" class="contest_problem_title">Problem <?=$problem->letter?> | <?=$problem->name?></a>
					<?php
						}
					?>
					<br />
					<div id="contest_detail_buttons">
						<div style="float:right" id="problem_submit_a">
							<a href="<?=site_url("contests/submit/" . $contest->id)?>"><div id="problem_submit">Submit</div></a>
						</div>
						<div style="float:left" id="view_ranklist_contest_a">
							<a href="<?=site_url("contests/ranklist/" . $contest->id)?>"><div id="view_ranklist_contest">Ranklist</div></a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>