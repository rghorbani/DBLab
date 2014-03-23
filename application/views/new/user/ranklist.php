<?php
	$border_width = "3px";
?>

		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						// contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_STANDING);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="overall_ranklist_acc" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<center><h2>Top 15 users<h2><h4>sorted by the number of accepts</h4></center><br />
								<table id="overall-accranklist-table" class="list" width="100%">
									<thead>
									<tr style="border-bottom-width:<?=$border_width?>">
										<th scope="col" width="2%" class="title"><center>R</center></td>
										<th scope="col" width="20%" class="title"><center>Name</center></td>
										<th scope="col" width="1%" class="title"><center>Solved</center></td>
									</tr>
									</thead>
									<tbody>
										<?php
											$rank = 0;
											$prev_acc = -1;
											$total_rank = 1;
											$is_in = FALSE;
											foreach($users as $user) {
												if ($prev_acc != $user->acc) {
													$prev_acc = $user->acc;
													$rank = $total_rank;
												}
												$total_rank++;
												if ($is_logged_in && $user->id == $current_user->id) $is_in = TRUE;
										?>
										<tr class="<?=$total_rank%2 == 0?"even":"odd"?>">
											<td><center><?=$rank?>/</center></td>
											<td><a href="<?=site_url("users/profile/" . $user->id)?>"><?=$user->name?></a></td>
											<td><center><?=$user->acc?></center></td>
										</tr>
										<?php
											}
										?>
										<?php
											if (!$is_in && $is_logged_in) {
										?>
										<tr class="sep">
											<td colspan="3"><center> ... </center></td>
										</tr>
										<tr class="even">
											<td><center><?=$current_rank?>/</center></td>
											<td><a href="<?=site_url("users/profile/" . $current_user->id)?>"><?=$current_user->name?></a></td>
											<td><center><?=$current_acc?></center></td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					
					<div id="overall_ranklist_act" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<center><h2>Top 15 users<h2><h4>sorted by their new accepts in last 15 days</h4></center><br />
								<table id="overall-actranklist-table" class="list" width="100%">
									<thead>
									<tr style="border-bottom-width:<?=$border_width?>">
										<th scope="col" width="2%" class="title"><center>R</center></td>
										<th scope="col" width="20%" class="title"><center>Name</center></td>
										<th scope="col" width="1%" class="title"><center>Solved</center></td>
									</tr>
									</thead>
									<tbody>
										<?php
											$rank = 0;
											$prev_acc = -1;
											$total_rank = 1;
											$is_in = FALSE;
											foreach($act_users as $user) {
												if ($prev_acc != $user->acc) {
													$prev_acc = $user->acc;
													$rank = $total_rank;
												}
												$total_rank++;
												if ($is_logged_in && $user->id == $current_user->id) $is_in = TRUE;
										?>
										<tr class="<?=$total_rank%2 == 0?"even":"odd"?>">
											<td><center><?=$rank?>/</center></td>
											<td><a href="<?=site_url("users/profile/" . $user->id)?>"><?=$user->name?></a></td>
											<td><center><?=$user->acc?></center></td>
										</tr>
										<?php
											}
										?>
										<?php
											if (!$is_in && $is_logged_in) {
										?>
										<tr class="sep">
											<td colspan="3"><center> ... </center></td>
										</tr>
										<tr class="even">
											<td><center><?=$current_actrank?>/</center></td>
											<td><a href="<?=site_url("users/profile/" . $current_user->id)?>"><?=$current_user->name?></a></td>
											<td><center><?=$current_actacc?></center></td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					
					
					
					
				</div>
				
			</div>
		</div>