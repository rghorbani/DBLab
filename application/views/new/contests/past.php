<?php
	function showPageNumber($i, $c=0, $set=false) {
		static $current = 1;
		if ($set) { $current = $c; return; }
		if ($i != $current) echo '<li><a href="' . site_url("contests/page/" . $i) . '">' . $i . '</a></li> ';
		else				echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber(0, $current_page, true);
?>
		<h1 id="top-title">Past Contests</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_home_tabs($is_logged_in, $current_user, TAB_CONTEST_HOME_PAST);
					?>
					</ul>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div id="paging">
						<span>pages:</span>
							<ul>
								<?php
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
							</ul>	
					</div>
					<div class="clear"></div>
					<div id="contests_list" class="shadowed">
						<div class="inner-box">
							<div class="content">
							
								<table id="contests-list-table" width="100%" class="list">
									<thead>
										<tr>
											<th width="2%" scope="col"></th>
											<th width="45%" scope="col">Contest</th>
											<th width="15%" scope="col">Start time</th>
											<th width="10%" scope="col">Length</th>
											<th width="10%" scope="col">Problems</th>
											<th width="20%" scope="col">Status</th>
										</tr>
									</thead>
									<tbody>
									<? foreach ($contests as $contest) { ?>
									
									<tr id="contest_<?=$contest->id?>">
										<td class="icon"></td>
										<th scope="row"><a href="<?=site_url("contests/view/" . $contest->id)?>"><?=clean4print($contest->label)?></a></td>
										<td><a href="<?=site_url("contests/view/" . $contest->id)?>"><?=$contest->starttime?></a></td>
										<td><a href="<?=site_url("contests/view/" . $contest->id)?>"><?=formatTime($contest->length)?></a></td>
										<td><a href="<?=site_url("contests/view/" . $contest->id)?>"><?=$contest->problem_num?></a></td>
										<td class="status"><a href="<?=site_url("contests/view/" . $contest->id)?>"> <span class="finished">Finished</span></a></td>						
									</tr>
								<? } ?>
									</tbody>
								</table>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
