			<h1 id="top-title">You're In!</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_login_tabs($is_logged_in, $current_user, TAB_USERLOG_SIGNUP);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>

					<div id="users-signedup" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<p>OK! You have registered successfully! An email containing your validation link sent to your email address. Check your inbox and spam folder please.<br />you can login now! <a href="<?=site_url("users/login")?>"> Click here to login </a></p>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>