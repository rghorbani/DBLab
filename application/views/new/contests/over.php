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

					<div id="contest-problem-submit" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h1 class="center">Contest is over!</h1>
								<p class="center">maybe next time :)</p>
								<?php
									if ($problem->is_visible || ($is_logged_in && $current_user->perm_problem_setter)) {
								?>
								<h4 class="center">But you can still submit your solutions!</h4>
								<a id="submit-btn" href="<?=site_url("sections/problem/problemset/" . $problem->code)?>">Submit</a>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
