			<h1 id="top-title">Account Recovery</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_login_tabs($is_logged_in, $current_user, TAB_USERLOG_RECOVER);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>

					<div id="users-recovered" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<p>An email containing you new password was sent to your email address, please login with that password and change it from <a href="<?=site_url("users/edit")?>">edit profile</a> page ASAP.</p>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>