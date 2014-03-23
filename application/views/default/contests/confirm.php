		<div class="bar">Contest Creation Confirmation</div>
		<div class="container-top"></div>
		<div class="container">
			
				<div id="contest_confirm">
					<center><h2>Ready to create!</h2></center><br />
					<p>Double check contest properties and click the button to create the contest!</p><br />
					<table width="100%" class="T">
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
						<tr><td><strong><?=$problem->letter?></strong> :: <?=$problem->problem_id?><div class="problem_color_box" style="background-color:<?=$problem->color?>"></div></td></tr>
						<?php
							}
						?>
						<tr><td class="title"><a href="<?=site_url("contests/confirm/" . $contest_id)?>"><img src="<?=site_url("assets")?>/images/confirm_contest.png" /></a></td></tr>
						
					</table>
				</div>
			
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>