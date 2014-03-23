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
								<p>OK! If you have provided a correct email address, for each user you have, you will receive an email containing your recovery confirmation link. Check your inbox and spam folder please.<br /></p>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>