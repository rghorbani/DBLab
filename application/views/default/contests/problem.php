		<div class="bar"><?=clean4print($contest->label)?> :: Problem <?=clean4print($problem->letter)?></div>
			<div class="container-top"></div>
			<div class="container">
				<div style="float:left" id="contest_detail_buttons">
					<a href="<?=site_url("contests/ranklist/" . $contest->id)?>"><div class="btn">Ranklist</div></a>
					<a href="<?=site_url("contests/runs/" . $contest->id)?>"><div class="btn">Contest Runs</div></a>
					<a href="<?=site_url("contests/view/" . $contest->id)?>"><div class="btn">Contest Home</div></a>
				</div>
				<div class="clear"></div>
				<div id="problem_view">
					<div id="problem_name">
						<h1><?=clean4print($problem->letter)?> :: <?=$problem->name?></h1>
						<p>Time Limit: <span class="red"><?=$problem->time_limit?> Second<?=$problem->time_limit!=1?"s":""?></span> &nbsp;&nbsp; Memory Limit: <span class="red"><?=$problem->memory_limit*1024?> KB</span><?php if($problem->special_judge == TRUE) {?><br /><span class="red">Special Judge</span><? } ?></p>

					</div>
					
					<?=$problem->statement?>
					
					
					<?php if ($problem->input != "") { ?>
					<h2>Input</h2>
					<?=$problem->input?>
					<?php } ?>
					
					<?php if ($problem->output != "") { ?>
					<h2>Output</h2>
					<?=$problem->output?>
					<?php } ?>
					
					<?php if ($problem->sample_input != "") { ?>
					<h2>Sample Input</h2>
					<pre><?=$problem->sample_input?></pre>
					<?php } ?>
					
					<?php if ($problem->sample_output != "") { ?>
					<h2>Sample Output</h2>
					<pre><?=$problem->sample_output?></pre>
					<?php } ?>
					
					<br /><br />
					<div id="problem_submit_a">
					<a href="<?=site_url("contests/submit/" . $contest->id . "/" . $problem->letter)?>"><div id="problem_submit">Submit</div></a>
					</div>
				
					<br /><br />
					<?php if($problem->source_id != -1) { ?><hr /><p id="problem_source">Source: <?=$problem->source_label?></p><?php } ?>
					
					<?php if($is_logged_in && $current_user->perm_problem_setter) {?>
					<hr /><p style="text-align:right;"><a href="<?=site_url("admin/edit_problem/" . $problem->code)?>">Edit</a></p>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="container-bot"></div>
