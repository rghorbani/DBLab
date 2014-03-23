<?php
	
	function showPageNumber($i, $c=0, $user_id=0, $set=false) {
		static $current = 1;
		static $uid = 0;
		if ($set) { $current = $c; $uid=$user_id; return; }
		if ($i != $current) echo '<li><a href="' . site_url("logs/user/" . $uid . "/" . $i) . '">' . $i . '</a></li> ';
		else					 echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber(0, $current_page, $user->id, true);
?>

			<h1 id="top-title">Activities</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_profile_tabs($is_logged_in, $user, $current_user, TAB_USERPROFILE_ACTIVITIES);
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

					<div id="user_logs" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<table id="logs-table" width="100%" class="list">
									<thead>
										<tr>
											<th width="8%" scope="col">User</th>
											<th width="50%" scope="col">Action</th>
											<th width="4%" scope="col">Method</th>
											<th width="6%" scope="col">Date</th>
											<th width="4%" scope="col">IP</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($logs as $log) {
											$action = "";
											if ($log->src != "") {
												$action .= '<a href="' . $log->src . '">' . $log->src . '</a> -> ';
											}
											$action .= '<a href="' . $log->dst . '">' . $log->dst . '</a>';
										?>
											
										<tr>
											<td><center><a href="<?=site_url("users/profile/" . $user->id)?>"><?=$user->name?></a></center></td>
											<td class="action"><center><?=$action?></center></td>
											<td><center><?=$log->method?></center></td>
											<td><center><?=$log->time?></center></td>
											<td><center><?=$log->ip?></center></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>