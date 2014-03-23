<?php
	$str = uri_string();
	$__home = "";
	$__about = "";
	$__signup = "";
	$__addprob = "";
	$__runs = "";
	$__contests = "";
	$__problemset = "";
	$__news = "";
	$__selected = "id=\"selected\"";
	if ($str == "") {
		$__home = $__selected;
	}else if (substr($str,0,5) == "about") {
		$__about = $__selected;
	}else if (substr($str,0,12) == "users/signup") {
		$__signup = $__selected;
	}else if (substr($str,0,5) == "admin") {
		$__addprob = $__selected;
	}else if (substr($str,0,4) == "runs") {
		$__runs = $__selected;
	}else if (substr($str,0,10) == "problemset") {
		$__problemset = $__selected;
	}else if (substr($str,0,8) == "contests") {
		$__contests = $__selected;
	}else if (substr($str,0,4) == "news") {
		$__news = $__selected;
	}
?>
<script>
	(function ($) {
		$(function(){
			$("#mnu").mouseleave(function () {
				$('.sublink').slideUp(100);
			});
			$('.sublinkitem').each(function (index) {
				$(this).width($(this).parent().parent().prev().width()-25);
			});
			$('.dropmenu').mouseenter(function(){
				$('.sublink').slideUp(100);

				var submenu = $(this).parent().next();
				submenu.css({
					position:'absolute',
					top: $(this).offset().top + $(this).height() + 23 + 'px',
					left: $(this).offset().left + 'px',
					zIndex:1000
				});
				submenu.slideDown(100);
				
				submenu.mouseleave(function(){
					$(this).slideUp(100);
				});
				
			});
		});
	})(jQuery);

</script>
	<a href="<?=base_url()?>"><div class="item" <?=$__home?>>Home</div></a>
	<?php if (!$is_logged_in) {?><a href="<?=site_url("users/signup")?>"><div class="item" <?=$__signup?>>Sign Up</div></a><?php } ?>
<?php /*
	<a href="<?=site_url("about")?>"><div class="dropmenu item"  <?=$__about?>>ShareCode</div></a>
	<div class="sublink">
		<a href="<?=site_url("sharecode/about")?>"><div class="sublinkitem">About</div></a>
		<a href="<?=site_url("sharecode/feedback")?>"><div class="last sublinkitem">Feedback</div></a>
	</div>
*/?>
	<a href="<?=site_url("contests")?>"><div class="item"  <?=$__contests?>>Contests</div></a>
	<a href="<?=site_url("problemset")?>"><div class="item"  <?=$__problemset?>>Problem Set</div></a>
	<?php if ($is_logged_in) {?>
		<a onclick='return false' href="#"><div class="dropmenu item"  <?=$__runs?>>&nbsp; &nbsp; Runs&nbsp; &nbsp; </div></a>
		<div class="sublink">
			<a href="<?=site_url("runs/my")?>"><div class="sublinkitem">My Runs</div></a>
			<a href="<?=site_url("runs/all")?>"><div class="last sublinkitem">All Runs</div></a>
		</div>
	<?php }else { ?>
	<a href="<?=site_url("runs/all")?>"><div class="item"  <?=$__runs?>>Runs</div></a>
	<?php } ?>
	
<?php
	// ADMIN MENUS
	if ($is_logged_in && $current_user->perm_problem_setter == TRUE) {
?>
	<a href="#"><div class="dropmenu item" <?=$__addprob?>>Problem Setter Menu</div></a>
	<div class="sublink">
		<a href="<?=site_url("admin/add_problem")?>"><div class="sublinkitem">+ New Problem</div></a>
		<a href="<?=site_url("admin/add_picture")?>"><div class="sublinkitem">+ Upload Picture</div></a>
		<a href="<?=site_url("admin/manage_sources")?>"><div class="sublinkitem last">Manage Sources</div></a>
	</div>
<? } ?>
	
	<a href="<?=site_url("admin/manage_news")?>"><div class="item"  <?=$__news?>>Manage News</div></a>
	
	<?php if ($is_logged_in) {?><a href="<?=site_url("users/logout")?>"><div class="item">Logout [<?=$current_user->username?>]</div></a><?php } ?>
	

