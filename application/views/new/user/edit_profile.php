<script>
	function confirm_delete() {
		return confirm("Are you sure you want to delete?");
	}
	(function ($) {
		var SITE = SITE || {};
		SITE.fileInputs = function() {
			var $this = $(this),
			$val = $this.val(),
			valArray = $val.split('\\'),
			newVal = valArray[valArray.length-1],
			$button = $this.siblings('.button'),
			$fakeFile = $this.siblings('.file-holder');
			if(newVal !== '') {
				$button.text('Use: ' + newVal);
				$('#submit_profile_pic').show();
			}
		};

		$(document).ready(function() {
			$('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);
			$('#submit_profile_pic').hide();
		});
		
		$(function () {
			$("#username_f").keyup(function (e) {
				if ($(this).val() != $("#old_username").val()) $("#change_username_cpass").show().next().show();
				else $("#change_username_cpass").hide().next().hide();
			});
			$("#username_f").keyup();
		});
		
	})(jQuery);
</script>
			<h1 id="top-title">Edit Profile</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_profile_tabs($is_logged_in, $current_user, $current_user, TAB_USERPROFILE_EDIT);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="profile_img" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<img src="<?=site_url("assets/user_images/" . $current_user->picture) ?>" /><br />
								<?php
									if ($is_default_picture != TRUE) {
								?>
									<a onclick='return confirm_delete()' href="<?=site_url("users/delete_picture")?>">Delete current picture</a>
								<?php
									}
									if ($image_size_err == TRUE) {
								?>
									<div class="error">Please select a file smaller than 500KB in size.</div>
								<?php
									}
								?>
								<form method="post" action="<?=site_url("users/update_picture")?>" enctype="multipart/form-data">
									<span class="file-wrapper">
										<input type="file" name="photo" id="photo" />
										<span class="button">Choose a New Photo</span>
									</span>
									<br />
									<input type="submit" id="submit_profile_pic" value=" Apply " />
								</form>


								<div class="clear"></div>
							</div>
						</div>
					</div>

					<div class="profile_edit shadowed">
						<div class="inner-box">
							<div class="content">
								<h4>Profile
								<?php
									if ($changed_name == TRUE) {
										echo("<span class='error'><h4>Your profile successfuly updated.</h4></span>");
									}
								?></h4><br />
								<form method="post" action="<?=site_url("users/edit")?>">
									<ul>
										<li><label for="username_f">Username</label></li>
										<? if ($current_user->username_changes < 1) {?>
										<li><input disabled="disabled" type="text" id="username_f" size="40" value="<?=$current_user->username?>" /></li>
										<? } else { ?>
										<li>
											<input type="text" id="username_f" name="username" size="40" value="<?=set_value('username', $current_user->username)?>" />
											<?=form_error('username','<br /><label></label><span class="error">','</span>');?>
											
										</li>
										<li class="nos" id="change_username_cpass"><label for="password_f">Current Password</label></li>
										<li class="nos"><input type="password" id="password_f" name="password" size="40" value="" />
														<input type="hidden" id="old_username" value="<?=$current_user->username?>" /></li>
										<?php if($pass_err) { ?><li><label><label></li><li><span class="error">Please enter your password carefuly!</p></li><?php } ?>
										<li>
											<small class="red">
												You have only one chance to change your username.<br />Leave the above box unchanged if you dont want to change your username.<br /><br />
											</small>
										</li>
										<? } ?>
										<li><label for="display_name">Display name</label></li>
										<li>
											<input type="text" id="display_name" name="display_name" size="40" value="<?=set_value('display_name', htmlspecialchars_decode($current_user->name))?>" />
											<?=form_error('display_name','<br /><label></label><span class="error">','</span>');?>
										</li>
										<li><label for="school">School</label></li>
										<li>
											<input type="text" id="school" name="school" size="40" value="<?=set_value('school', htmlspecialchars_decode($current_user->school))?>" />
											<?=form_error('school','<br /><label></label><span class="error">','</span>');?>
										</li>
									</ul>
									<input type="hidden" name="sectoin" value="name" />
									<input type="submit" value="Apply" />
								</form>
								<div class="clear"></div>
							</div>

						</div>
					</div>
					<div class="profile_edit shadowed">
						<div class="inner-box">
							<div class="content">
								<h4>General Settings
								<?php
									if ($changed_setting == TRUE) {
										echo("<span class='error'><h4>Your settings successfuly updated.</h4></span>");
									}
								?></h4><br />
								<form method="post" action="<?=site_url("users/edit")?>">
									<ul>
										<li><label for="def_com">Default Compiler</label></li>
                                        <li>
											<select name="language" id="def_com" size="1">
                                            <option value="-1" <?=set_select('language',"-1", TRUE)?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												foreach ($langs as $lang) {
											?>
												<option value="<?=$lang->id?>" <?=set_select('language', $lang->id, $current_user->default_compiler == $lang->id)?>>&nbsp; <?=$lang->label?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<? } ?>
											</select>
											
										</li>
										<li><label></label></li>
										<li>
											<label class="wide_160" for="show_compiler">Show it in my profile</label> <input id="show_compiler" type="checkbox" name="show_compiler" value="1" <?php echo set_checkbox("show_compiler", "1", $current_user->show_compiler==TRUE); ?>/>
										</li>
									</ul>
									<input type="hidden" name="sectoin" value="setting" />
									<input type="submit" value="Apply" />
								</form>
								<div class="clear"></div>
							</div>

						</div>
					</div>



					<div class="profile_edit shadowed">
						<div class="inner-box">
							<div class="content">
								<h4>Email Address</h4><br />
								<form method="post" action="<?=site_url("users/update_email")?>">
									<ul>
										<li><label for="email">Email Address</label></li>
										<li>
											<input type="text" id="email" name="email" size="40" value="<?=set_value('email', htmlspecialchars_decode($current_user->email))?>" />
											<?=form_error('email','<br /><label></label><span class="error">','</span>');?>
										</li>
									<li><label></label></li>
									<li>
										<label class="wide_180" for="show_email">Show my email in my profile</label><input id="show_email" type="checkbox" name="show_email" value="1" <?=$current_user->show_email?'checked="checked"':''?> />
									</li>
									</ul>
									<?php
										if ($current_user->is_valid == FALSE) {
									?>
										<ul>
											<li><span class="red">Your email address hasn't been validated yet.<br />In order to validate your email address, please <strong><a href="<?=site_url("users/send_validation_email")?>">click here</a></strong> to send activation email.</span></li>
										</ul>
									<?php
										}
									?>
									
									<input type="submit" value="Change" />
									
								</form>
								<div class="clear"></div>
							</div>

						</div>
					</div>

					<div class="profile_edit shadowed">
						<div class="inner-box">
							<div class="content">
								<h4>Change Password</h4><br />
								<form method="post" action="<?=site_url("users/change_password")?>">
									<ul>
										<li><label for="cpassword">Current password</label></li>
										<li><input type="password" id="cpassword" name="cpassword" size="40" value="" />
										<?=form_error('cpassword','<br /><label></label><span class="error">','</span>');?></li>
									</ul>

									<ul>
										<li><label for="npassword">New password</label></li>
										<li><input type="password" id="npassword" name="npassword" size="40" value="" />
										<?=form_error('npassword','<br /><label></label><span class="error">','</span>');?></li>
										<li><label for="npassword_conf">Confirm password</label></li>
										<li><input type="password" id="npassword_conf" name="npassword_conf" size="40" value="" />
										<?=form_error('npassword_conf','<br /><label></label><span class="error">','</span>');?></li>
									</ul>
									<input type="submit" value="Apply" />
								</form>
								<div class="clear"></div>
							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
