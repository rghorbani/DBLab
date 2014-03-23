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
											<th width="1%" scope="col"></th>
											<th width="45%" scope="col">Section</th>
											<th width="10%" scope="col">Problems</th>
										</tr>
									</thead>
									<tbody>
									<? foreach ($sections as $section) { ?>
									
									<tr id="contest_<?=$section->id?>">
										<td class="icon"></td>
										<td><a class="delete_section" id="delete_<?=$section->url?>" href="<?=site_url("sections/delete/" . $section->url . "?next=" . $CURRENT_PAGE)?>"><img src="<?=site_url("assets/theme_new/icons/run_del.png")?>" /></a></td>
										<th scope="row"><a href="<?=site_url("sections/view/" . $section->url)?>"><?=clean4print($section->label)?></a></td>
										<td><a href="<?=site_url("sections/view/" . $section->url)?>"><?=$section->problem_num?></a></td>
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
