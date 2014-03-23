<script type="text/javascript" language="javascript">
	function update_page() {
		window.location.replace(window.location.href);
	}
	jQuery(function () {
		setInterval("update_page()",1000*2*60);
	});

</script>
		<div class="bar">Contest Standing</div>
		<div class="container-top"></div>
		<div class="container">
			
			<div style="float:left" id="contest_detail_buttons">
				<a href="<?=site_url("contests/view/" . $contest->id)?>"><div class="btn">Contest Home</div></a>
				<a href="<?=site_url("contests/runs/" . $contest->id)?>"><div class="btn">Contest Runs</div></a>
			</div>
			<div class="clear"></div>
			<center><h1>Realtime Standing :: <?=clean4print($contest->label)?></h1></center><br />
			
			<table class="ranklist" width="100%">
				<tr>
					<td width="1%" class="title"><center>Ranke</center></td>
					<td width="15%" class="title"><center>Name</center></td>
					<td width="1%" class="title"><center>Solved</center></td>
					<?php
						for ($i=0;$i<count($problems);$i++) {
					?>
					<td class="title" style="border-bottom:1px <?=$problems[$i]->color?> solid"><center><a href="<?=site_url("contests/problem/" . $contest->id . "/" . $problem_letters[$i])?>"><?=$problem_letters[$i]?></a></center></td>
					<?php
						}
					?>
					<td width="1%" class="title"><center>Penalty</center></td>
				</tr>
				
				
				<?php
					$rank = 1;
					foreach($ranklist as $item) {
				?>
				<tr>
					<td><center><?=$rank++?></center></td>
					<td><?=$item->user_name?></td>
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
							print("</td></center>");
						}
					?>
					<td><center><?=ceil($item->penalty/60)?></center></td>
				</tr>
				<?php
					}
				?>
				
			</table>
			
			
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>