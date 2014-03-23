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
		<div class="bar">Problemset :: Page#<?=$current_page?></div>
		<div class="container-top"></div>
		<div class="container">
			<div class="listitem_head">
				<div class="pages">
					Pages: 
					<?php
						function showPageNumber($i, $c=0, $set=false) {
							static $current = 1;
							if ($set) { $current = $c; return; }
							if ($i != $current) echo '<a href="' . site_url("problemset/page/" . $i) . '">[' . $i . ']</a> ';
							else					 echo '<span class="selected">[' . $i . ']</span> ';
						}
						showPageNumber(0, $current_page, true);
						// [1][2][3][4][5] ... [7][8][9]
						
						if ($total_pages < 12) {
							for ($i=1;$i<=$total_pages;$i++) showPageNumber($i);
						}else {
							if ($current_page < 6) {
								for ($i=1;$i<7;$i++) showPageNumber($i);
								echo " ... ";
								for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
							}else if ($current_page > $total_pages-6) {
								for ($i=1;$i<3;$i++) showPageNumber($i);
								echo " ... ";
								for ($i=$total_pages-6;$i!=$total_pages+1;$i++) showPageNumber($i);
							}else {
								for ($i=1;$i<4;$i++) showPageNumber($i);
								echo " ... ";
								 showPageNumber($current_page-1);
								 showPageNumber($current_page);
								 showPageNumber($current_page+1);
								echo " ... ";
								for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
							}
						}
					?>
				</div>
			</div>
			
			<? foreach($problems as $problem) { ?>
			<a href="<?=site_url("problemset/view/" . $problem->code)?>">
				<div class="<?php if ($is_logged_in && $problem->user_accepted) echo "acc"; else if ($is_logged_in && $problem->user_submitted) echo("submitted"); else echo("problem"); ?> listitem">
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
		