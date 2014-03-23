	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_PROBLEMS);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					
					<div class="clear"></div>
					<div id="contests_view" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h1 class="center" id="countdown">Finished</h1>
								<h2 class="center"><?=clean4print($contest->label)?></h2>
								<p class="center">This contest was finished at<br /><?=ts2date(date2ts($contest->starttime)+$contest->length)?></p>
								<h4><br /><?=$contest->description?><br /></h4>
								<h4>Problems</h4>
								<table id="contest-problem-list" width="100%" class="list">
									<tbody>
								<?php
									foreach ($problems as $problem) {
								?>
									<tr>
										<th style="border-left:7px <?=$problem->color?> solid" scope="row"><a href="<?=site_url("contests/problem/" . $contest->id . "/" . $problem->letter)?>">Problem <?=$problem->letter?></a></th>
										<td><a href="<?=site_url("contests/problem/" . $contest->id . "/" . $problem->letter)?>" class="contest_problem_title"><?=$problem->name?></a></td>
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