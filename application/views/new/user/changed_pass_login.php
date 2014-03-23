			<h1 id="top-title">Login</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_login_tabs($is_logged_in, $current_user, TAB_USERLOG_LOGIN);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>

					<div id="users-login" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<div class="center error">Password Changed! Login again!</div>
								<form id="login_form" action="<?=site_url("users/login")?>" method="post">
									<ul>
										<li><label for="username_tb">Username:</label></li>
										<li><input class="input" size="30" name="username" type="text" id="username_tb"  value="<?php echo set_value('username'); ?>" /></li>
										<li><label for="password_tb">Password:</label></li>
										<li><input class="input" size="30" name="password" type="password" id="password_tb" /></li>
									</ul>
									<input id="login_btn" type="submit" value="Log me in!" />
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>