<?php
	function judge_result($id, $label, $run_id) {						
		if ($id == 4) { // ACCEPTED
			return '<span class="accepted_run">' . $label . '</span>';
		}else if ($id == 0) { // QUEUE
			return '<span class="queue_run">' . $label . '</span>';
		}else if ($id == 11) { // CE
			return '<a href="#" onclick="return show_ce(' . $run_id . ')"><span class="ce_run">' . $label . '</span></a>';
		}else if ($id == 2 || $id == 3 || $id == 12) { // COMPILING
			return '<span class="comp_run">' . $label . '</span>';
		}else if ($id == 5 || $id == 6 || $id == 7 || $id == 8 || $id == 9) { // Wrong & Presend & ...
			return '<span class="wp_run">' . $label . '</span>';
		}else if ($id == 10) { // COMPILING
			return '<span class="re_run">' . $label . '</span>';
		}else {
			return $label;
		}
	}
	
?>
<script>
	function show_ce(run_id) {
		(function ($) {
			$("#ce_" + run_id).slideToggle('slow');
		})(jQuery);
		return false;
	}


</script>
		<div class="bar">My Runs :: Page#<?=$current_page?></div>
		<div class="container-top"></div>
		<div class="container">
			<div class="listitem_head">
				<div class="pages">
					Pages: 
					<?php
						function showPageNumber($i, $c=0, $set=false) {
							static $current = 1;
							if ($set) { $current = $c; return; }
							if ($i != $current) echo '<a href="' . site_url("runs/my/" . $i) . '">[' . $i . ']</a> ';
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
			<div style="background-color:#999999" class="run listitem listitem_head">
				<div class="base problem_id2"><center>Problem</center></div>
				<div class="base date"><center>Date</center></div>
				<div class="base lang"><center>Language</center></div>
				<div class="base run_mem"><center>Run Memory</center></div>
				<div class="base run_time"><center>Run Time</center></div>
				<div class="base code_size"><center>Code Length</center></div>
				<div class="base result"><center>Result</center></div>
			</div>
			<? foreach($runs as $run) { ?>
			<div class="run listitem">
				<div class="base problem_id2"><a href="<?= site_url("problemset/view/" . $run->problem_id)?>"><center><?=$run->problem_id?></center></a></div>
				<div class="base date"><center><?=$run->time?></center></div>
				<div class="base lang"><center><?=$run->lang_label?></center></div>
				<div class="base run_mem"><center><?=$run->run_memory?>KB</center></div>
				<div class="base run_time"><center><?=$run->run_time?>ms</center></div>
				<div class="base code_size_item"><center><?=strlen($run->source)?><br />characters</center></div>
				<div class="base result"><center><?=judge_result($run->result, $run->result_label, $run->id)?></center></div>
				<a href="<?=site_url("runs/source/" . $run->id)?>" class="base sourcecode_icon"></a>
			</div>
			<div class="listitem_ce" id="ce_<?= $run->id ?>"><?= nl2br(htmlspecialchars($run->info)) ?></div>
			<? } ?>
			
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>	
		
