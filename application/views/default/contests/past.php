		<div class="bar">Past Contests :: Page #<?=$current_page?></div>
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
				<div class="base contest_title"><center><?=htmlspecialchars($contest->label)?></center></div>
				<div class="base start_time"><center><?=$contest->starttime?></center></div>
				<div class="base length"><center><?=formatTime($contest->length)?></center></div>
				<div class="base problem_num"><center><?=$contest->problem_num?></center></div>
				<div class="base status_title"><center><span class="finished">Finished</span></center></div>
			</div>
			</a>
			<? } ?>
			
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>	
		