		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						problem_tabs($is_logged_in, $current_user, TAB_PROBLEM_VIEW, $url, $problem);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>

					<div id="problemset_problem-view" class="shadowed">
						<div class="inner-box">
							<div class="content">
							
								<h1><?=$problem->name?></h1>
								<p id="info">Time Limit: <span class="red"><?=$problem->time_limit?> Second<?=$problem->time_limit!=1?"s":""?></span> &nbsp;&nbsp; Memory Limit: <span class="red"><?=$problem->memory_limit*1024?> KB</span><?php if($problem->special_judge == TRUE) {?><br /><span class="red">Special Judge</span><? } ?></p>

								
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
								
								<a id="submit-btn" href="<?=site_url("sections/submit/" . $url . "/" . $problem->code)?>">Submit</a>
								<?php if($problem->source_id != -1) { ?><p id="problem_source">Source: <?=$problem->source_label?></p><?php } ?>
								<?php if($is_logged_in && $current_user->perm_problem_setter) {?>
								<p id="controlls"><a href="<?=site_url("admin/edit_problem/" . $url . "/" . $problem->code)?>">[Edit]</a></p>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>


