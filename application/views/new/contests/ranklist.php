<?php
	$border_width = "3px";
?>
<?php
	if ($contest->finished == FALSE) {
?>
<script type="text/javascript" language="javascript">
	function update_page() {
		window.location.replace(window.location.href);
	}
	jQuery(function () {
		setInterval("update_page()",1000*60);
	});
	
</script>
<?php
	}
?>
<script>
	(function ($) {
		$(function () {
			$("a#toggle_virtual_result").click(function () {
				$(".fake").toggle();
				var rank = 1;
				$(".ranklist_item:visible").each(function () {
					$(this).removeClass("even").removeClass("odd");
					$(this).find("td:first").html("<center>" + (rank++) + "/</center>");
				});
				$(".ranklist_item:visible:odd").addClass("odd");
				$(".ranklist_item:visible:even").addClass("even");
			});
		});
	})(jQuery);
</script>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_STANDING);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="contest_ranklist" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<center><h1>Realtime Standing :: <?=clean4print($contest->label)?></h1></center>
								<?php if ($contest->vranklist!=-1) {?><p id="contest-ranklist-desc"><small><a id="toggle_virtual_result" class="link">toggle virtual ranks</a></small></p><?php }else { ?><br /><?php } ?>
								<table id="contest-ranklist-table" class="list" width="100%">
									<thead>
									<tr style="border-bottom-width:<?=$border_width?>">
										<th scope="col" width="2%" class="title"><center>R</center></th>
										<th scope="col" width="20%" class="title"><center>Name</center></th>
										<th scope="col" width="1%" class="title"><center>Solved</center></th>
										<?php
											for ($i=0;$i<count($problems);$i++) {
										?>
										<th scope="col" class="title" style="border-bottom:<?=$border_width?> <?=$problems[$i]->color?> solid"><center><a href="<?=site_url("contests/problem/" . $contest->id . "/" . $problem_letters[$i])?>"><?=$problem_letters[$i]?></a></center></th>
										<?php
											}
										?>
										<th scope="col" width="1%" class="title"><center>Time&nbsp;</center></th>
									</tr>
									</thead>
									<tbody>
										<?php
											$rank = 1;
											foreach($ranklist as $item) {
												$class = ($rank%2 == 0?"even":"odd");
												$class .= ($item->is_real?" real":" fake");
												$class .= " ranklist_item";
										?>
										<tr class="<?=$class?>">
											<td><center><?=$rank++?>/</center></td>
											<td><?php if ($item->is_real) {?><a href="<?=site_url("users/profile/" . $item->user_id)?>"><?=$item->user_name?></a><?php } else { ?><?=$item->user_name?><?php } ?></td>
											<td><center><?=$item->all_acc?></center></td>
											<?php
												for ($i=0;$i<count($problems);$i++) {
													$letter = $problem_letters[$i];
													print("<td><center>");
													if (!$item->states[$letter]["acc"]) {
														if ($item->states[$letter]["submits"] != 0) {
															print("-" . $item->states[$letter]["submits"]);
														}else {
															print("--");
														}
													}else {
														print($item->states[$letter]["submits"] . " @ " . ceil($item->states[$letter]["acc_time"]/60));
													}
													print("</center></td>");
												}
											?>
											<td><center><?=ceil($item->penalty/60)?></center></td>
										</tr>
									<?php
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>