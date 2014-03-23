<?php
	for ($i=0;$i<strlen($user->email)/2;$i++) {
		$c = $user->email[$i];
		$user->email[$i] = $user->email[strlen($user->email)-1-$i];
		$user->email[strlen($user->email)-1-$i] = $c;
	}

?>
<script>
	(function ($) {
		$(function () {
			email = $("div#rev_email").html();
			var decoded_email = "";
			for (i=0;i<email.length;i++) {
				decoded_email += email[email.length-1-i];
			}
			$("a#email").html(decoded_email);
			$("a#email").attr("href", "mailto:"+decoded_email);

		});
	})(jQuery);
</script>
			<h1 id="top-title">Profile</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						user_profile_tabs($is_logged_in, $user, $current_user, TAB_USERPROFILE_PROFILE);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>

					<div id="profile_img" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<img src="<?=site_url("assets/user_images/" . $user->picture) ?>" /><br />
								<?php if ($user->show_email) { ?>
								<a id="email">Loading Email</a>
								<div id="rev_email" class="nos"><?=($user->email)?></div>
								<?php } ?>
								
								<div class="clear"></div>
							</div>
						</div>
					</div>

					<div id="profile_name" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h1><?= $user->name ?></h1>
								<h4><?= $user->school ?></h4>
							</div>
						</div>
					</div>

					<div id="profile_rank" class="shadowed">
						<div class="inner-box">
							<div class="content">
								Ranked <span class="red"><strong><?= $user->rank ?></strong></span> among all <span class="red"><strong><?= $total_users ?></strong></span> users.<br />
								Have accepted <span class="red"><strong><?= $user->acc_count ?></strong></span> problems with <span class="red"><strong><?= $user->submit_count ?></strong></span> submits in total with ratio of <span class="red"><strong><?= ($user->submit_count==0?"00.00":round($user->acc_count/$user->submit_count*100, 2)) ?></strong></span>%.<br />
								<?php if ($user->show_compiler && $user->default_compiler != -1 && $default_compiler != NULL) { ?>Uses <span class="red"><strong><?=$default_compiler->name?></strong></span> for default compiler!<br />
								<?php } ?>
							</div>
						</div>
					</div>

					<div id="profile_acc" class="shadowed">
						<div class="inner-box">
							<div class="content">
								Accepted Problems:<br />
								<?php
									foreach($acc_problems as $problem) {
								?>
									<a href="<?=site_url("sections/problem/problemset/" . $problem->code)?>"><?=$problem->code?></a>
								<?php
									}
								?>
								<div class="clear"></div>
							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
