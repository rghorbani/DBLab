<!-- INITIAL -->
<link rel="stylesheet" type="text/css" href="assets/theme_old/MooEditable/MooEditable.css">
<link rel="stylesheet" type="text/css" href="assets/theme_old/MooEditable/MooEditable.Image.css">
<link rel="stylesheet" type="text/css" href="assets/theme_old/MooEditable/MooEditable.Table.css">
<link rel="stylesheet" type="text/css" href="assets/theme_old/MooEditable/MooEditable.Extras.css">
<script type="text/javascript" src="assets/theme_old/MooEditable/mootools.js"></script>
<script type="text/javascript" src="assets/theme_old/MooEditable/Source/MooEditable/MooEditable.js"></script>
<script type="text/javascript" src="assets/theme_old/MooEditable/Source/MooEditable/MooEditable.Image.js"></script>
<script type="text/javascript" src="assets/theme_old/MooEditable/Source/MooEditable/MooEditable.Table.js"></script>
<script type="text/javascript" src="assets/theme_old/MooEditable/Source/MooEditable/MooEditable.Extras.js"></script>
<style type="text/css">
	#statement, #input, #output, #hint {
	width: 868px;
	height: 200px;
	color:#ff0000;
	border: 2px solid #000;
}
</style>
	
<script type="text/javascript">
window.addEvent('domready', function(){
	$('statement').mooEditable({
		actions: 'bold italic | image createlink unlink | justifyleft justifyright justifycenter justifyfull | tableadd tableedit tablerowadd tablerowedit tablerowspan tablerowsplit tablerowdelete tablecoladd tablecoledit tablecolspan tablecolsplit tablecoldelete | toggleview'
	});
	$('input').mooEditable({
		actions: 'bold italic | image createlink unlink | justifyleft justifyright justifycenter justifyfull | tableadd tableedit tablerowadd tablerowedit tablerowspan tablerowsplit tablerowdelete tablecoladd tablecoledit tablecolspan tablecolsplit tablecoldelete | toggleview'
	});
	$('output').mooEditable({
		actions: 'bold italic | image createlink unlink | justifyleft justifyright justifycenter justifyfull | tableadd tableedit tablerowadd tablerowedit tablerowspan tablerowsplit tablerowdelete tablecoladd tablecoledit tablecolspan tablecolsplit tablecoldelete | toggleview'
	});
	$('hint').mooEditable({
		actions: 'bold italic | image createlink unlink | justifyleft justifyright justifycenter justifyfull | tableadd tableedit tablerowadd tablerowedit tablerowspan tablerowsplit tablerowdelete tablecoladd tablecoledit tablecolspan tablecolsplit tablecoldelete | toggleview'
	});
});
</script>
		
		<div class="bar">Admin :: Add Problem</div>
		<div class="container-top"></div>
		<div class="container">
			<?php
				if ($problem_added) {
					echo '<div class="center error">The problem ' . set_value('code') . ' added successfully</div>';
				}
				function sv($n, $set = FALSE) {
					static $problem_added = FALSE;
					if ($set == TRUE) {
						$problem_added = $n;
						return;
					}
					if ($problem_added) return '';
					return set_value($n);
				}
				sv($problem_added, TRUE);
			?>
			<form action="<?=site_url("admin/add_problem")?>" method="post" enctype="multipart/form-data">
				<table class="T" width="100%">
					<tr>
						<td><strong> Problem Code:</strong></td><td><input type="text" size="40" name="code" value="<?=sv('code')?>" />
							<?=form_error('code','<div class="small error">','</div>')?></td>
					</tr>
					<tr>
						<td><strong> Problem Name:</strong></td><td><input type="text" size="40" name="name" value="<?=sv('name')?>" />
							<?=form_error('name','<div class="small error">','</div>')?></td>
					</tr>
					<tr>
						<td><strong> Time limit:</strong></td><td><input type="text" size="40" name="time_limit" value="<?=sv('time_limit')?>" />
							<?=form_error('time_limit','<div class="small error">','</div>')?></td>
					</tr>
					<tr>
						<td><strong> Memory limit:</strong></td><td><input type="text" size="40" name="memory_limit" value="<?=sv('memory_limit')?>" />
							<?=form_error('memory_limit','<div class="small error">','</div>')?></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Problem statement</center></td>
					</tr>
					<tr>
						<td colspan="2" style="background:#ffffff;"><textarea id="statement" name="statement" cols="100" rows="20"><?=sv('statement')?></textarea></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Input</center></td>
					</tr>
					<tr>
						<td colspan="2" style="background:#ffffff;"><textarea id="input" name="input" cols="100" rows="10"><?=sv('input')?></textarea></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Output</center></td>
					</tr>
					<tr>
						<td colspan="2" style="background:#ffffff;"><textarea id="output" name="output" cols="100" rows="10"><?=sv('output')?></textarea></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Test Input</center></td>
					</tr>
					<tr>
						<td colspan="2"><center><textarea name="sample_input" cols="100" rows="15"><?=sv('sample_input')?></textarea></center></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Test Output</center></td>
					</tr>
					<tr>
						<td colspan="2"><center><textarea name="sample_output" cols="100" rows="15"><?=sv('sample_output')?></textarea></center></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Hint</center></td>
					</tr>
					<tr>
						<td colspan="2" style="background:#ffffff;"><textarea id="hint" name="hint" cols="100" rows="10"><?=sv('hint')?></textarea></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Test Data</center></td>
					</tr>
					<tr>
						<td><strong>Input :</strong></td><td><input type="file" size="40" name="input_file" /></td>
					</tr>
					<tr>
						<td><strong>Output :</strong></td><td><input type="file" size="40" name="output_file" /></td>
					</tr>
					<tr>
						<td><strong>SPJ Checker :</strong></td><td><input type="file" size="40" name="checker_file" /></td>
					</tr>
					<tr>
						<td class="title" colspan="2"><center>Visible</center></td>
					</tr>
					<tr>
						<td><strong>Show this problem in the list?</strong></td><td><input type="checkbox" size="40" value='1' name="is_visible" <?=set_checkbox('is_visible', '1')?>/></td>
					</tr>
					<tr>
						<td class="contest"><strong> Source:</strong></td>
						<td>Choose: <select name="source_id">
						<?php foreach ($sources as $source) {?>
							<option value="<?=$source->id?>" <?=set_select('source_id',$source->id)?>>&nbsp;&nbsp;<?=$source->label?>&nbsp;&nbsp;&nbsp;</option>
						<?php } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><center><input type="submit" value=" Add " /></center></td>
					</tr>
				</table>
				
			</form>	

			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>
		