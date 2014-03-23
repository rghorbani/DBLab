<?php
	function showPageNumber($i, $c=0, $set=false) {
		static $current = 1;
		if ($set) { $current = $c; return; }
		if ($i != $current) echo '<li><a href="' . site_url("sections/page/" . $i) . '">' . $i . '</a></li> ';
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
	function section_status($starttime, $length) {
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

		<h1 id="top-title">Sections</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						section_tabs($is_logged_in, $current_user, TAB_SECTION_HOME_SECTIONS);
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
											<th width="45%" scope="col">Section</th>
											<th width="15%" scope="col">Start time</th>
											<th width="10%" scope="col">Length</th>
											<th width="10%" scope="col">Problems</th>
											<th width="16%" scope="col">Status</th>
											<th width="2%" scope="col"></th>
											<th width="2%" scope="col"></th>
										</tr>
									</thead>
									<tbody>
									<? foreach ($sections as $section) { ?>
									
									<tr id="contest_<?=$section->id?>">
										<td class="icon"></td>
										<th scope="row"><a href="<?=site_url("sections/view/" . $section->id)?>"><?=clean4print($section->label)?></a></td>
										<td><a href="<?=site_url("sections/view/" . $section->id)?>"><?=$section->starttime?></a></td>
										<td><a href="<?=site_url("sections/view/" . $section->id)?>"><?=formatTime($section->length)?></a></td>
										<td><a href="<?=site_url("sections/view/" . $section->id)?>"><?=$section->problem_num?></a></td>
										<td class="status">
											<a href="<?=site_url("sections/view/" . $section->id)?>">
											<?=section_status($section->starttime, $section->length)?><br /><span id="section_time_<?=$section->id?>"></span>
											<span class="contest_info hidden"><?=get_status($section->starttime, $section->length)?>|<?=countdown($section->starttime, $section->length)?>|<?=$section->id?></span>
											</a>
										</td>
										<? if($current_user->perm_create_contest) { ?>
											<td><a class="visibility_link" id="visible_<?=$section->id?>" href="<?=site_url("sections/make_visible/" . $section->id . "?next=" . $CURRENT_PAGE)?>"><img src="<?=site_url("assets/theme_new/icons/run_del.png")?>" /></a></td>
											<td><a class="delete_link" id="delete_<?=$section->id?>" href="<?=site_url("sections/delete/" . $section->id . "?next=" . $CURRENT_PAGE)?>"><img src="<?=site_url("assets/theme_new/icons/run_del.png")?>" /></a></td>
										<? } ?>
									</tr>
									<? } ?>
									</tbody>
								</table>
								<?php
									if ($is_logged_in && $current_user->perm_create_contest) {
								?>
								<a id="arrange-btn" href="<?=site_url("sections/arrange")?>">Arrange Section</a>
								<?php 
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
