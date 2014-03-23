<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="sharecode,onlinejudge,online,judge,acm,contest,algorithm,online contest,virtual contest,problemset,icpc,regional,world finals" />
	<?php
		if ($title=="ShareCode :: Dashboard") {
	?><meta name="description" content="ShareCode is the Social Network and the Online Judge for the people that interested in algorithms, programing, problem solving, creating, competing and having fun." /><?php } ?>
	<base href="<?=base_url()?>" />
	<title><?=clean4print($title)?></title>
	<link rel="search" type="application/opensearchdescription+xml" href="<?=site_url("assets/opensearch.xml")?>" title="ShareCode" />
	<link rel="stylesheet" href="<?=site_url("assets/theme_new/style.css?" . $STATIC_FILES_VERSION)?>" />
	<link rel="stylesheet" href="<?=site_url("assets/theme_new/boxes.css?" . $STATIC_FILES_VERSION)?>" />
	<link rel="stylesheet" href="<?=site_url("assets/theme_new/tables.css?" . $STATIC_FILES_VERSION)?>" />
	<link rel="stylesheet" href="<?=site_url("assets/custom-scrollbar-plugin/jquery.mCustomScrollbar.css?" . $STATIC_FILES_VERSION)?>" />
	<script type="text/javascript" src="<?=site_url("assets/theme_new/jquery-1.7.2.min.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script>$j = jQuery.noConflict();</script>
	<script type="text/javascript" src="<?=site_url("assets/theme_new/jquery.mailcheck.min.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/theme_new/submenu.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/theme_new/login.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/theme_new/functions.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/theme_new/view_runs.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/theme_new/notifications.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/custom-scrollbar-plugin/jquery-ui-1.8.21.custom.min.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/custom-scrollbar-plugin/jquery.mousewheel.min.js?" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript" src="<?=site_url("assets/custom-scrollbar-plugin/jquery.mCustomScrollbar.min.js?" . $STATIC_FILES_VERSION)?>"></script>
	<?php
	/*
	<script type="text/javascript" src="<?=site_url("assets/theme_new/swfobject.js?9" . $STATIC_FILES_VERSION)?>"></script>
	<script type="text/javascript">
	//swfobject.embedSWF("<?=site_url("assets/nowrouz/sc.swf")?>", "fl", "430", "63", "9.0.0");
	</script>
	*/
	?>
	<link rel="shortcut icon" href="<?=site_url("assets/favicon.ico")?>" type="image/x-icon" />
<?php
	if (DO_MAKE_STATS) {
?>
	
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32735233-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	<?php
		}
	?>

</head>

<body>
	<div id="wrap">
		<div id="top">
			<div id="header">
				<div id="fl"></div>
				<?php
					if ($show_login_box == TRUE && !$is_logged_in) {
				?>
				<div id="top-box">
					<form id="login-form" action="<?=site_url("users/login")?>" method="post">
						<input id="username_box" name="username" value="username" size="13" type="text" /><input id="password_box" name="password" value="password" size="13" type="password" />
						<input name="back_url" value="<?=(substr(current_url(), strlen(site_url())))?>" type="hidden" /><input type="submit" value="Login" />
						<input onclick="getURL('<?=site_url("users/signup")?>')" type="button" id="signup_btn" value="Signup" />
					</form>
				</div>
				<?php
					}
				?>
			</div>
<?php include ("menu.php"); ?>
