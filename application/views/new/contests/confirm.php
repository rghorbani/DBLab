		<h1 id="top-title">Arrange Contest</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_home_tabs($is_logged_in, $current_user, TAB_CONTEST_HOME_ARRANGE);			
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="contests_confirm" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h2 class="center">Ready to create!</h2>
								<p class="center">Double check contest properties and click the button to create the contest!</p><br />
								<table id="properties" width="100%">
									<tr><td class="title"><center>Contest Title</center></td></tr>
									<tr><td><?=clean4print($label)?></td></tr>
									<tr><td class="title"><center>Contest Start Time</center></td></tr>
									<tr><td><?=clean4print($starttime)?></td></tr>
									<tr><td class="title"><center>Contest Length</center></td></tr>
									<tr><td><?=clean4print($length)?></td></tr>
									<tr><td class="title"><center>Contest Problems</center></td></tr>
									<?php
										foreach($problems as $problem) {
									?>
									<tr><td><strong><?=$problem->letter?></strong> :: <?=$problem->problem_id?> - <?=$problem->name?><div class="problem_color_box" style="background-color:<?=$problem->color?>"></div></td></tr>
									<?php
										}
									?>
									<tr><td class="title"><a id="confirm" href="<?=site_url("contests/confirm/" . $contest_id)?>">Confirm</a></td></tr>
									
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
