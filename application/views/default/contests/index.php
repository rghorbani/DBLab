<?php
	function get_status($starttime, $length) {
		$starttime = date2ts($starttime);
		$now = nowTS();
		if ($starttime+$length < $now) return -1;
		if ($starttime > $now) return +1;
		return 0;
	}
	function contest_status($starttime, $length) {
		$status = get_status($starttime, $length);
		switch ($status) {
			case -1:
				return '<span class="finished">Finished</span>';
				break;
			case 0:
				return '<span class="progress">In Progress</span>';
				break;
			case +1:
				return '<span class="ready">Ready</span>';
				break;
		}
		return "";
	}
	function countdown($starttime, $length) {
		$status = get_status($starttime, $length);
		if ($status == -1) return 0;
		$now = nowTS();
		if ($status == +1) return date2ts($starttime)-$now;
		return date2ts($starttime)+$length-$now;
	}
?>
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
			$(".contest_info").each(function (index) {
				var inf = $(this).html();
				var status = inf.split("|")[0];
				var contest_id = inf.split("|")[2];
				if (status == "-1") return;
				var seconds = parseInt(inf.split("|")[1]);
				if (seconds == 0) {
					window.location.replace(window.location.href);
					clearInterval(T);
					return;
				}
				seconds--;
				$("#contest_time_"+contest_id).html(formatTime(seconds));
				$(this).html(status+"|"+seconds+"|"+contest_id);
			});
		})(jQuery);
	}
	jQuery(function () {
		update_countdown();
		T = setInterval("update_countdown()",997);
	});

</script>
		<div class="bar">Contests</div>
		<div class="container-top"></div>
		<div class="container">
			<div class="listitem_head">
				<div class="pages">
					Past Contests' Pages: 
					<?php
						function showPageNumber($i, $c=0, $set=false) {
							static $current = 1;
							if ($set) { $current = $c; return; }
							if ($i != $current) echo '<a href="' . site_url("contests/page/" . $i) . '">[' . $i . ']</a> ';
							else					 echo '<span class="selected">[' . $i . ']</span> ';
						}
						showPageNumber(0, $current_page, true);
						// [1][2][3][4][5] ... [7][8][9]
						
						if ($total_pages < 12) {
							for ($i=1;$i<=$total_pages;$i++) showPageNumber($i);
						}else {
							if ($current_page < 6) {
								for ($i=1;$i<7;$i++) showPageNumber($i);
								echo " ... ";
								for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
							}else if ($current_page > $total_pages-6) {
								for ($i=1;$i<3;$i++) showPageNumber($i);
								echo " ... ";
								for ($i=$total_pages-6;$i!=$total_pages+1;$i++) showPageNumber($i);
							}else {
								for ($i=1;$i<4;$i++) showPageNumber($i);
								echo " ... ";
								 showPageNumber($current_page-1);
								 showPageNumber($current_page);
								 showPageNumber($current_page+1);
								echo " ... ";
								for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
							}
						}
					?>
				</div>
			</div>
			
			<div style="background-color:#999999" class="contest listitem listitem_head">
				<div class="base contest_title"><center>Contest</center></div>
				<div class="base start_time"><center>Start time</center></div>
				<div class="base length"><center>Length</center></div>
				<div class="base problem_num"><center>Problems</center></div>
				<div class="base status_title"><center>Status</center></div>
			</div>
			
			<? foreach ($contests as $contest) { ?>
			<a href="<?=site_url("contests/view/" . $contest->id)?>">
			<div class="contest listitem" id="contest_<?=$contest->id?>">
				<div class="base contest_title"><center><?=clean4print($contest->label)?></center></div>
				<div class="base start_time"><center><?=$contest->starttime?></center></div>
				<div class="base length"><center><?=formatTime($contest->length)?></center></div>
				<div class="base problem_num"><center><?=$contest->problem_num?></center></div>
				<div class="base status<?=get_status($contest->starttime, $contest->length)==-1?"_title":""?>"><center><?=contest_status($contest->starttime, $contest->length)?><br /><span id="contest_time_<?=$contest->id?>"></span></center></div>
				<div class="contest_info hidden"><?=get_status($contest->starttime, $contest->length)?>|<?=countdown($contest->starttime, $contest->length)?>|<?=$contest->id?></div>
			</div>
			</a>
			<? } ?>
			<?php
				if ($is_logged_in && $current_user->perm_create_contest) {
			?>
			<div class="listitem_head listitem_btn"><center><a href="<?=site_url("contests/arrange")?>"><img src="<?=site_url("assets")?>/images/arrange_contest.png" /></a></center></div>
			<?php 
				}
			?>
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>	
		