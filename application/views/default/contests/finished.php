		<div class="bar">Contest :: <?=clean4print($contest->label)?></div>
		<div class="container-top"></div>
		<div class="container">
			
				<div id="contest_detail">
					<center><h1 id="countdown">Finished!</h1></center><br />
					<p align="center">This contest was finished at<br /><?=ts2date(date2ts($contest->starttime)+$contest->length)?></p>
					<h2>Problems</h2><br />
					<?php
						foreach ($problems as $problem) {
					?>
					<a href="<?=site_url("contests/problem/" . $contest->id . "/" . $problem->letter)?>" style="border-left:7px <?=$problem->color?> solid" class="contest_problem_title">Problem <?=$problem->letter?> | <?=$problem->name?></a>
					<?php
						}
					?>
					<br />
					<div id="contest_detail_buttons">
						<div id="view_ranklist_contest_a">
							<a href="<?=site_url("contests/ranklist/" . $contest->id)?>"><div id="view_ranklist_contest">Ranklist</div></a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>