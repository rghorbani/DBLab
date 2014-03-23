		<h1 id="top-title">Arrange Section</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						section_tabs($is_logged_in, $current_user, TAB_SECTION_ARRANGE);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="contests_confirm" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h2 class="center">Ready to create!</h2>
								<p class="center">Double check section properties and click the button to create the contest!</p><br />
								<table id="properties" width="100%">
									<tr><td class="title"><center>Section Title</center></td></tr>
									<tr><td><?=clean4print($label)?></td></tr>
									<tr><td class="title"><center>Section URL</center></td></tr>
									<tr><td><?=clean4print($url)?></td></tr>
									<tr><td class="title"><center>Section Start Time</center></td></tr>
									<tr><td><?=clean4print($starttime)?></td></tr>
									<tr><td class="title"><center>Section Length</center></td></tr>
									<tr><td><?=clean4print($length)?></td></tr>

									<tr><td class="title"><a id="confirm" href="<?=site_url("sections/view/" . $url)?>">Continue</a></td></tr>
									
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
