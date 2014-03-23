<?php
	function showPageNumber($i, $c=0, $set=false) {
		static $current = 1;
		if ($set) { $current = $c; return; }
		if ($i != $current) echo '<li><a href="' . site_url("contests/page/" . $i) . '">' . $i . '</a></li> ';
		else			    echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber(0, $current_page, true);
	
	
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
	
	var T;
	
	jQuery(function () {
		update_countdown();
		T = setInterval("update_countdown_index()",997);
	});

</script>

		<h1 id="top-title">Contests</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_home_tabs($is_logged_in, $current_user, TAB_CONTEST_HOME_CONTESTS);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					
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
										<td class="status">
											<a href="<?=site_url("contests/view/" . $contest->id)?>">
											<?=contest_status($contest->starttime, $contest->length)?><br /><span id="contest_time_<?=$contest->id?>"></span>
											<span class="contest_info hidden"><?=get_status($contest->starttime, $contest->length)?>|<?=countdown($contest->starttime, $contest->length)?>|<?=$contest->id?></span>
											</a>
										</td>						
									</tr>
								<? } ?>
									</tbody>
								</table>
								<?php
									if ($is_logged_in && $current_user->perm_create_contest) {
								?>
								<a id="arrange-btn" href="<?=site_url("contests/arrange")?>">Arrange Contest</a>
								<?php 
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
