<link rel="stylesheet" href="<?=site_url("assets/prism/prism.css")?>">

<?php
	$lang_prism = 'cpp';
	if (strtolower($run->language) == 'java') {
		$lang_prism = 'java';
	}else if (strtolower($run->language) == 'php') {
		$lang_prism = 'php';
	}else if (strtolower($run->language) == 'python') {
		$lang_prism = 'python';
	}
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
?>
			<h1 id="top-title">View Source</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					
					<div id="problemset_runs" class="shadowed">
						<div class="inner-box">
							<div class="content">

								<table id="problem-runs-list-table" width="100%" class="list">
									<thead>
										<tr>
											<th width="7%" scope="col">Problem</th>
											<th width="30%" scope="col">User</th>
											<th width="13%" scope="col">Date</th>
											<th width="6%" scope="col">Lang.</th>
											<th width="9%" scope="col">Memory</th>
											<th width="9%" scope="col">Time</th>
											<th width="9%" scope="col">Code Length</th>
											<th width="16%" scope="col">Result</th>
											<th width="1%" scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<tr class="run_row" id="run_<?=$run->id?>">
											<th class="run" scope="row"><a href="<?= site_url("sections/problem/" . $run->url . "/" . $run->problem_id)?>"><?=$run->problem_id?></a></th>
											<td><center><a href="<?=site_url("users/profile/" . $run->user_id)?>"><?=$run->user_name?></a></center></td>
											<td><center><?=$run->time?></center></td>
											<td><center><?=$run->language?></center></td>
											<td class="run_memory"><center><?=$run->run_memory?>KB</center></td>
											<td class="run_time"><center><?=$run->run_time?>ms</center></td>
											<td><center><?=$run->code_length?><br />characters</center></td>
											<td class="run_result"><input type="hidden" value="<?=$run->result?>" /><center><?=judge_result($run->result, $run->result_label, $run->id, $is_logged_in && ($current_user->id == $run->user_id || $current_user->perm_judge))?></center></td>
											<td><?php if ($is_logged_in && $current_user->id == $run->user_id  && $run->result != 4) {	?>
											<a class="edit_link" id="edit_<?=$run->id?>" href="<?=site_url("sections/submit/" . $run->url . "/" . $run->problem_id . "/" . $run->id)?>"><img src="<?=site_url("assets/theme_new/icons/code_edit.png")?>" /></a>
											<?php } ?></td>
										</tr>
										<tr class="ce"><td colspan="8"><div id="ce_<?= $run->id ?>" class="ce-container"><?= ($is_logged_in && ($current_user->id == $run->user_id || $current_user->perm_judge))?nl2br(htmlspecialchars($run->info)):"" ?></div></td>
										</tr>
									</tbody>
								</table>
								<pre class="line-numbers" data-start="1"><code class="language-<?=$lang_prism?>"><?=htmlspecialchars($run->source)?></code></pre>

							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>

<script src="<?=site_url("assets/prism/prism.js")?>"></script>