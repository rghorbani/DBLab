<script>
	(function ($) {
		$(function () {
			var domains = ['hotmail.com', 'gmail.com', 'acm.org', 'yahoo.com', 'ece.ut.ac.ir', 'ut.ac.ir'];
			$('input#email_tb').change(function () {
				$(this).mailcheck(domains, {
					suggested: function(element, suggestion) {
						$("#email_sugg").html("Did you mean '<a class='link' onclick='change_email_content(this)'>" + suggestion.full + "</a>'?");
						$("#email_sugg").slideDown();
					},
					empty: function(element) {
						$("#email_sugg").slideUp();
					}
				});
			});
			
			change_email_content = function (t) {
				$("input#email_tb").val($(t).html());
				$("#email_sugg").slideUp();
				return false;
			}
			
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
			<h1 id="top-title">Signup</h1>
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

					<div id="users-signup" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<form id="signup_form" action="<?=site_url("users/signup")?>" method="post">
									<ul>
										<li><label for="username_tb">Username:</label></li>
										<li><input class="input"  name="username" type="text" id="username_tb" value="<?=set_value('username'); ?>" /></li>
										<?=form_error('username','<li class="error">','</li>')?>
										<li><label for="password_tb">Password:</label></li>
										<li><input class="input"  name="password" type="password" id="password_tb" /></li>
										<?=form_error('password','<li class="error">','</li>')?>
										<li><label for="confirm_password_tb">Confirm Password:</label></li>
										<li><input class="input"  name="confirm_password" type="password" id="confirm_password_tb" /></li>
										<?=form_error('confirm_password','<li class="error">','</li>')?>
										<li><label for="email_tb">Email:</label></li>
										<li><input class="input"  name="email" type="text" id="email_tb" value="<?=set_value('email'); ?>" /></li>
										<li id="email_sugg" class="error nos"></li>
										<?=form_error('email','<li class="error">','</li>')?>
										<li><label for="name_tb">Display Name:</label></li>
										<li><input class="input"  name="name" type="text" id="name_tb" value="<?=set_value('name'); ?>" /></li>
										<?=form_error('name','<li class="error">','</li>')?>
										<li><label for="school_tb">School/University</label><li>
										<li><input class="input"  name="school" type="text" id="school_tb" value="<?=set_value('school'); ?>" /></li>
										<li><label for="captcha_tb">Are you human?</label><li>
										<li><img id="captcha_img" src="<?=site_url("captcha/" . $captcha_image)?>" /> &nbsp;<a class="link" id="ref_captcha"><img src="<?=site_url("assets/theme_new/icons/refresh_captcha.jpg")?>" /></a></li>
										<li><input class="input"  name="captcha" type="text" id="captcha_tb" value="" /></li>
										<?=form_error('captcha','<li class="error">','</li>')?>
									</ul>
									<input name="hash" id="captcha_hash" type="hidden" value="<?=$captcha_hash?>" />
									<input id="signup_btn" type="submit" value="Sign me Up!" />
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
