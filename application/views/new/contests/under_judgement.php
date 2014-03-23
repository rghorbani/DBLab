<script type="text/javascript">
	setTimeout(function() {
		window.location.href = "<?=site_url("contests/my_runs/" . $contest->id)?>";
	}, 3000);
</script>
	
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_SUBMIT);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>

					<div id="problemset_judgequeue" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h3><a href="<?=site_url("contests/my_runs/" . $contest->id)?>">Your solution has been submitted!</a></h3	>
								<p><a href="<?=site_url("contests/my_runs/" . $contest->id)?>">Your source code is now in judge queue.</a></p>
								<p id="info"><a href="<?=site_url("contests/my_runs/" . $contest->id)?>">Click here if your browser is not automatically redirected to the run status page.</a></p>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>