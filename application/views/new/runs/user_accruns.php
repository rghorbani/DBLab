<?php
	function judge_result($id, $label, $run_id, $show_ce = FALSE) {						
		if ($id == 4) { // ACCEPTED
			return '<span class="accepted_run">' . $label . '</span>';
		}else if ($id == 0) { // QUEUE
			return '<span class="queue_run">' . $label . '</span>';
		}else if ($id == 11) { // CE
			if ($show_ce) return '<a href="#" onclick="return show_ce(' . $run_id . ')"><span class="ce_run">' . $label . '</span></a>';
			return '<span class="ce_run">' . $label . '</span>';
		}else if ($id == 2 || $id == 3 || $id == 12) { // COMPILING
			return '<span class="comp_run">' . $label . '</span>';
		}else if ($id == 5 || $id == 6 || $id == 7 || $id == 8 || $id == 9) { // Wrong & Presend & ...
			return '<span class="wp_run">' . $label . '</span>';
		}else if ($id == 10) { // Runtime Error
			return '<span class="re_run">' . $label . '</span>';
		}else {
			return $label;
		}
	}
	function showPageNumber($i, $c=0, $id = NULL, $set=false) {
		static $current = 1;
		static $uid = NULL;
		if ($set) { $current = $c; $uid = $id; return; }
		if ($i != $current) echo '<li><a href="' . site_url("runs/acc_user/" . $uid . "/" . $i) . '">' . $i . '</a></li> ';
		else				echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber(0, $current_page, $user->id, true);
?>
<script>
	function show_ce(run_id) {
		(function ($) {
			$("#ce_" + run_id).slideToggle('slow');
		})(jQuery);
		return false;
	}


</script>
			<h1 id="top-title">User Accepted Runs</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_profile_tabs($is_logged_in, $user, $current_user, TAB_USERPROFILE_ACCRUNS);
					?>
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

					<div id="problemset_runs" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<table id="problem-runs-list-table" width="100%" class="list">
									<thead>
										<tr>
											<th width="8%" scope="col">Problem</th>
											<th width="33%" scope="col">User</th>
											<th width="10%" scope="col">Date</th>
											<th width="6%" scope="col">Lang.</th>
											<th width="9%" scope="col">Memory</th>
											<th width="9%" scope="col">Time</th>
											<th width="9%" scope="col">Code Length</th>
											<th width="16%" scope="col">Result</th>
											<?php if ($is_logged_in && $current_user->perm_judge) { ?>
											<th width="1%" scope="col"></th>
											<th width="1%" scope="col"></th>
											<?php } ?>
											<th width="1%" scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<? foreach($runs as $run) { ?>
										<tr class="run_row" id="run_<?=$run->id?>">
											<th class="run" scope="row"><a href="<?= site_url("sections/problem/" . $run->url . "/" . $run->problem_id)?>"><?=$run->problem_id?></a></th>
											<td><center><a href="<?=site_url("users/profile/" . $run->user_id)?>"><?=$run->user_name?></a></center></td>
											<td><center><?=$run->time?></center></td>
											<td><center><?=$run->lang_label?></center></td>
											<td class="run_memory"><center><?=$run->run_memory?>KB</center></td>
											<td class="run_time"><center><?=$run->run_time?>ms</center></td>
											<td><center><?=$run->code_length?><br />characters</center></td>
											<td class="run_result"><input type="hidden" value="<?=$run->result?>" /><center><?=judge_result($run->result, $run->result_label, $run->id, $is_logged_in && ($current_user->id == $run->user_id || $current_user->perm_judge))?></center></td>
											<?php if ($is_logged_in && $current_user->perm_judge) {	?>
											<td><a class="delete_link" id="delete_<?=$run->id?>" href="<?=site_url("judge/delete/" . $run->id . "?next=" . $CURRENT_PAGE)?>"><img src="<?=site_url("assets/theme_new/icons/run_del.png")?>" /></a></td>
											<td><a class="rejudge_link" id="rejudge_<?=$run->id?>" href="<?=site_url("judge/rejudge/" . $run->id . "?next=" . $CURRENT_PAGE)?>"><img src="<?=site_url("assets/theme_new/icons/rejudge.png")?>" /></a></td>
											<?php } ?>
											<td><?php if ($is_logged_in && ($current_user->id == $run->user_id || $current_user->perm_judge)) {	?>
											<a href="<?=site_url("runs/source/" . $run->id)?>"><img src="<?=site_url("assets/theme_new/icons/source_code.png")?>" /></a>
										<?php } ?></td>
										</tr>
										<tr class="ce"><td colspan="8"><div id="ce_<?= $run->id ?>" class="ce-container"><?= ($is_logged_in && ($current_user->id == $run->user_id || $current_user->perm_judge))?nl2br(htmlspecialchars($run->info)):"" ?></div></td>
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