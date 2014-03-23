<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
<script>
	(function ($) {
		$(function () {
			make_vis = function (url, code) {
				$.post('<?=site_url("sections/make_problem_visible")?>', {url: url, code: code}, function (data) {
					$("#visbtn_"+code).remove();
				});
				return false;
			}
		});
	
	})(jQuery);
</script>
<?php } ?>
		
<?php
	function showPageNumber($url, $i, $c=0, $set=false) {
		static $current = 1;
		if ($set) { $current = $c; return; }
		if ($i != $current) echo '<li><a href="' . site_url("sections/view/" . $url . "/" . $i) . '">' . $i . '</a></li> ';
		else				echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber($url, 0, $current_page, true);
?>
		
			<h1 id="top-title"><?=$section->label?></h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						problemset_tabs($is_logged_in, $current_user, TAB_PSET_PROBLEMS, $url);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div id="paging">
						<span>pages:</span>
							<ul>
								<?php
								$url=$section->url;
								if ($total_pages < 12) {
									for ($i=1;$i<=$total_pages;$i++) showPageNumber($url, $i);
								}else {
									if ($current_page < 6) {
										for ($i=1;$i<7;$i++) showPageNumber($url, $i);
										echo " ... ";
										for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($url, $i);
									}else if ($current_page > $total_pages-6) {
										for ($i=1;$i<3;$i++) showPageNumber($url, $i);
										echo " ... ";
										for ($i=$total_pages-6;$i!=$total_pages+1;$i++) showPageNumber($url, $i);
									}else {
										for ($i=1;$i<4;$i++) showPageNumber($url, $i);
										echo " ... ";
										 showPageNumber($url, $current_page-1);
										 showPageNumber($url, $current_page);
										 showPageNumber($url, $current_page+1);
										echo " ... ";
										for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($url, $i);
									}
								}
								?>
							</ul>	
					</div>
					<div id="problem-search-container">
						<form action="<?=site_url("sections/search/")?>" method="post">
							<input class="f" type="text" size="17" name="q" /> <input type="submit" value="Search" />
						</form>
					</div>
					<div class="clear"></div>

					<div id="problemset_list-container" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<table id="problem-list-table" width="100%" class="list">
									<thead>
										<tr>
											<th width="8%" scope="col">Code</th>
											<th scope="col">Title</th>
											<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
											<th width="1%" scope="col"></td>
											<?php } ?>
											<th width="10%" scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<? foreach($problems as $problem) { ?>
										<tr>
												<th class="<?php if ($is_logged_in && $problem->user_accepted) echo "acc"; else if ($is_logged_in && $problem->user_submitted) echo("submitted"); ?>" scope="row"><a href="<?=site_url("problemset/view/" . $problem->code)?>"><?=$problem->code?></a></th>
												<td><a href="<?=site_url("sections/problem/" . $section->url . "/" . $problem->code)?>"><?=$problem->name?></a></td>
<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
												<td class="controlls"><a href="<?=site_url("admin/edit_problem/" . $section->url . "/" . $problem->code)?>">[edit]</a>
<?php if ($problem->is_visible == FALSE) { ?>
													<a id="visbtn_<?=$problem->code?>" href="#" onclick="return make_vis(<?=$section->url?>, <?=$problem->code?>)">[add]</a>
<?php } ?>
												</td>
<?php } ?>
												<td class="ratio"><a href="<?=site_url("runs/problem/" . $section->url . "/" . $problem->code)?>"><?=$problem->acc_counter?>/<?=$problem->sub_counter?>=<?=$problem->sub_counter==0?0.0:round(($problem->acc_counter/$problem->sub_counter)*100,1)?>%</a></td>
										</tr>
										<? } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>