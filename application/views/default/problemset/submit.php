		<div class="bar">Submit Solution :: <?=$problem->code?></div>
		<div class="container-top"></div>
		<div class="container">
			<form action="<?=site_url('problemset/submit/' . $problem->code)?>" method="post">
				
				<?=form_error('code','<div class="center error">','</div>')?>
				<table class="T" width="100%">
					<tr><td class="title" colspan="2"><center>Submit your solution</center></td></tr>
					<tr>
						<td><strong>Problem code</strong></td>
						<td><input class="f" type="text" disabled="disabled" value="<?=$problem->code?>" size="40" readonly="readonly" /></td>
					</tr>
					<tr>
						<td><strong>Problem name</strong></td>
						<td><input class="f" type="text" disabled="disabled" value="<?=$problem->name?>" size="40" readonly="readonly" /></td>
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
					<tr><td class="title" colspan="2"><center><input type="hidden" name="code" value="<?=$problem->code?>" /><input type="image" style="border:0px" src="assets/theme_old/images/submit.png" value="Submit" /></td></tr>
					
				</table>
			</form>
	
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>
		