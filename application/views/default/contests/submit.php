		<div class="bar">Submit Solution :: <?=clean4print($contest->label)?></div>
		<div class="container-top"></div>
		<div class="container">
			<div style="float:left" id="contest_detail_buttons">
				<a href="<?=site_url("contests/ranklist/" . $contest->id)?>"><div class="btn">Ranklist</div></a>
				<a href="<?=site_url("contests/runs/" . $contest->id)?>"><div class="btn">Contest Runs</div></a>
				<a href="<?=site_url("contests/view/" . $contest->id)?>"><div class="btn">Contest Home</div></a>
			</div>
			<div class="clear"></div>
			<form action="<?=site_url('contests/submit/' . $contest->id)?>" method="post">
				
				<?=form_error('code','<div class="center error">','</div>')?>
				<table class="T" width="100%">
					<tr><td class="title" colspan="2"><center>Submit your solution</center></td></tr>
					<tr>
						<td><strong>Contest</strong></td>
						<td><input class="f" type="text" disabled="disabled" value="<?=clean4print($contest->label)?>" size="40" readonly="readonly" /></td>
					</tr>
					<tr>
						<td><strong>Problem</strong></td>
						<td>
							<select name="problem" size="1" class="i">
							<?php
								foreach ($problems as $a_problem) {
							?>
								<option value="<?=$a_problem->letter?>" <?=set_select('problem', $a_problem->letter, $problem->letter == $a_problem->letter)?>>&nbsp; Problem <?=$a_problem->letter?> | <?=$a_problem->name?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
							<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td class="code"><strong>Code lang.</strong></td>
						<td>
							<select name="language" size="1" class="i">
							<?php
								foreach ($langs as $lang) {
							?>
								<option value="<?=$lang->id?>" <?=set_select('language',$lang->id)?>>&nbsp; <?=$lang->label?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
							<? } ?>
							</select>
							<?=form_error('language','<div class="small error">','</div>')?>
						</td>
					</tr>
					<tr><td class="title" colspan="2"><center>Put your code here!</center></td></tr>
					<tr><td colspan="2"><center><textarea class="f" name="source_code" cols="76" rows="20"><?=set_value('source_code')?></textarea><br /><?=form_error('source_code','<div class="small error">','</div>')?></center></td></tr>
					<tr><td class="title" colspan="2"><center><input type="image" style="border:0px" src="assets/theme_old/images/submit.png" value="Submit" /></td></tr>
					
				</table>
			</form>
	
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>
		