<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=clean4print($title)?></title>
<base href="<?=base_url()?>" />
<link rel="stylesheet" type="text/css" href="assets/theme_old/style.css" />
<script type="text/javascript" src="assets/theme_old/jquery-1.6.2.min.js"></script>
<script> jQuery.noConflict(); </script>
<? if ($show_login_box == TRUE && !$is_logged_in) { ?>
<script type="text/javascript">
	(function ($) {
		$(function () {
			$("#username_box").focus(function () {
				if ($(this).val() == "username") {
					$(this).val("");
					$("#password_box").val("");
				}
			});
			$("#username_box").blur(function () {
				if ($("#username_box").val() == "") {
					$("#username_box").val("username");
					$("#password_box").val("password");
				}
			});
		});
	})(jQuery);
</script>
<? } ?>
</head>

<body>
	<div id="wrap">
		<div id="top">
			<div id="header"></div>

			<div id="mnu">
				<?php include ("menu.php"); ?>
				<?php
					if ($show_login_box == TRUE && !$is_logged_in) {
				?>
				<!-- LOGIN BOX -->
				<div id="loginbox">
					<form action="<?=$BASE?>users/login" method="post">
						<input id="username_box" class="input" type="text" name="username" size="10" value="username" />
						<input id="password_box" class="input" type="password" name="password" size="10" value="password" />
						<input id="loginbox_submit" class="input" type="submit" value="&nbsp; Login &nbsp;" />
					</form>
				</div>
				<!-- /LOGIN BOX -->
				<?php
					}
				?>
			</div>
			
		</div>
			
		<div id="content">		