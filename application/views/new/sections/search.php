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
			<h1 id="top-title">Search Result</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						problemset_tabs($is_logged_in, $current_user, TAB_PSET_SEARCH);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					
					<div id="problem-search-container">
						<form action="<?=site_url("problemset/search")?>" method="post">
							<input class="f" type="text" size="17" name="q" /> <input type="submit" value="Search" />
						</form>
					</div>
					<div class="clear"></div>
					<?php
						if (count($result) > 0) {
					?>
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
										<? foreach($result as $problem) { ?>
										<tr>
												<th class="<?php if ($is_logged_in && $problem->user_accepted) echo "acc"; else if ($is_logged_in && $problem->user_submitted) echo("submitted"); ?>" scope="row"><a href="<?=site_url("problemset/view/" . $problem->code)?>"><?=$problem->code?></a></th>
												<td><a href="<?=site_url("problemset/view/" . $problem->code)?>"><?=$problem->name?></a></td>
<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
												<td class="controlls"><a href="<?=site_url("admin/edit_problem/" . $problem->code)?>">[edit]</a>
<?php if ($problem->is_visible == FALSE) { ?>
													<a id="visbtn_<?=$problem->code?>" href="#" onclick="return make_vis(<?=$problem->code?>)">[add]</a>
<?php } ?>
												</td>
<?php } ?>
												<td class="ratio"><a href="<?=site_url("runs/problem/" . $problem->code)?>"><?=$problem->acc_counter?>/<?=$problem->sub_counter?>=<?=$problem->sub_counter==0?0.0:round(($problem->acc_counter/$problem->sub_counter)*100,1)?>%</a></td>
										</tr>
										<? } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php 
						}else {
					?>
					<div id="problemset_list-container" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h2 align="center">Your search did not match any problem.</h2><br />
								<p><strong>Suggestions:</strong></p>
								<ul>
									<li>&nbsp;  Make sure all words are spelled correctly.</li>
									<li>&nbsp; Try different keywords.</li>
									<li>&nbsp; Try more general keywords.</li>
									<li>&nbsp; Try fewer keywords.</li>
								</ul>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				
			</div>
		</div>