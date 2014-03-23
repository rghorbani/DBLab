<script type="text/javascript" language="javascript">
	var T;
	jQuery(function () {
		update_countdown();
		T = setInterval("update_countdown()",998);
	});
</script>

		
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_READY);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					
					<div class="clear"></div>
					<div id="contests_ready" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h1 class="center">Ready to go!</h1>
								<p class="center">Please wait! the contest '<?=clean4print($contest->label)?>' will start at <br /><?=$contest->starttime?></p>
								<h1 class="center" id="countdown"></h1>
								<div id="contest_info_time"><?=$countdown_seconds?></div>
								<? if ($is_logged_in && $current_user->is_valid == FALSE) {?>
									<br /><small class="red">In order to attend this contest, please validate your email address.</small>
								<? } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
