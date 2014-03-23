<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
<script>
	(function ($) {
		$(function () {
			make_vis = function (code) {
				$.post('<?=site_url("admin/make_visible")?>', {code: code}, function (data) {
					$("#visbtn_"+code).remove();
				});
				return false;
			}
		});
	
	})(jQuery);
</script>
<?php } ?>
		<div class="bar">Problemset :: Search Result</div>
		<div class="container-top"></div>
		<div class="container">
			
			<? foreach($result as $problem) { ?>
			<a href="<?=site_url("problemset/view/" . $problem->code)?>">
				<div class="problem listitem">
					<div class="problem_id"><?=$problem->code?></div>
					<div class="problem_name"><?=$problem->name?></div>
					<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
						<a href="<?=site_url("admin/edit_problem/" . $problem->code)?>"><div class="block edit">Edit</div></a>
						<?php if ($problem->is_visible == FALSE) { ?>
						<a id="visbtn_<?=$problem->code?>" href="#" onclick="return make_vis(<?=$problem->code?>)"><div class="block not_avail">+</div></a>
						<?php } ?>
					<?php } ?>
					<a href="<?=site_url("runs/problem/" . $problem->code)?>"><div class="block info"><?=$problem->acc_counter?>/<?=$problem->sub_counter?>=<?=$problem->sub_counter==0?0.0:round(($problem->acc_counter/$problem->sub_counter)*100,1)?>%</div></a>
					
				</div>
			</a>
			<? } ?>
			<?php
				if (count($result) == 0) {
			?>
			<h2 align="center">Your search did not match any problem.</h2><br />
			<p><strong>Suggestions:</strong><br />

			&nbsp;  Make sure all words are spelled correctly.<br />
			&nbsp; Try different keywords.<br />
			&nbsp; Try more general keywords.<br />
			&nbsp; Try fewer keywords.</p><br />
			<? } ?>
			
		
			<div class="listitem_head">
				<div class="searchbox">
					<form action="<?=site_url("problemset/search")?>" method="post">
						<input class="f" type="text" size="17" name="q" />
						<div id="submit_search"><input type="image" src="assets/theme_old/images/search.gif" /></div>
					</form>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>	
		