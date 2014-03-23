<script>
	(function ($) {
		$(function () {
			$("a#ref_captcha").click(function () {
				$.get("<?=site_url("users/new_captcha")?>", function (data) {
					var hash = data.split("|")[0];
					var img = data.split("|")[1];
					$("img#captcha_img").attr("src", img);
					$("input#captcha_hash").val(hash);
				});
				return false;
			});
		});
	})(jQuery);
</script>

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

					<div id="users-signup" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<form id="signup_form" action="<?=site_url("users/recover")?>" method="post">
									<ul>
										<li><label for="email_tb">Email:</label></li>
										<li><input class="input" size="30" name="email" type="text" id="email_tb" value="<?=set_value('email'); ?>" /></li>
										<?=form_error('email','<li class="error">','</li>')?>
										<li><label for="captcha_tb">Are you human?</label><li>
										<li><img id="captcha_img" src="<?=site_url("captcha/" . $captcha_image)?>" /> &nbsp;<a class="link" id="ref_captcha"><img src="<?=site_url("assets/theme_new/icons/refresh_captcha.jpg")?>" /></a></li>
										<li><input class="input" size="30" name="captcha" type="text" id="captcha_tb" value="" /></li>
										<?=form_error('captcha','<li class="error">','</li>')?>
									</ul>
									<input name="hash" id="captcha_hash" type="hidden" value="<?=$captcha_hash?>" />
									<input id="recover_btn" type="submit" value="Recover my account!" />
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
