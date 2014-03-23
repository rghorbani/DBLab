<!-- INITIAL -->
<link rel="stylesheet" type="text/css" href="<?=site_url("assets/theme_new/MooEditable/MooEditable.css")?>">
<link rel="stylesheet" type="text/css" href="<?=site_url("assets/theme_new/MooEditable/MooEditable.Image.css")?>">
<link rel="stylesheet" type="text/css" href="<?=site_url("assets/theme_new/MooEditable/MooEditable.Table.css")?>">
<link rel="stylesheet" type="text/css" href="<?=site_url("assets/theme_new/MooEditable/MooEditable.Extras.css")?>">
<script type="text/javascript" src="<?=site_url("assets/theme_new/MooEditable/mootools.js")?>"></script>
<script type="text/javascript" src="<?=site_url("assets/theme_new/MooEditable/Source/MooEditable/MooEditable.js")?>"></script>
<script type="text/javascript" src="<?=site_url("assets/theme_new/MooEditable/Source/MooEditable/MooEditable.Image.js")?>"></script>
<script type="text/javascript" src="<?=site_url("assets/theme_new/MooEditable/Source/MooEditable/MooEditable.Table.js")?>"></script>
<script type="text/javascript" src="<?=site_url("assets/theme_new/MooEditable/Source/MooEditable/MooEditable.Extras.js")?>"></script>
<style type="text/css">
	#statement, #input, #output, #hint {
		width: 99.1%;
		height: 200px;
		color:#ff0000;
		border: 2px #000 solid;
	}
	#sample_output, #sample_input {
		width: 100%;
		border: 1px #888 solid;
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
		

		<h1 id="top-title">Admin :: Add Problem</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						admin_tabs($is_logged_in, $current_user, TAB_ADMIN_ADD_PROBLEM);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="add_problem" class="shadowed">
						<div class="inner-box">
							<div class="content">
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
								
								<form id="add-problem-form" action="<?=site_url("admin/add_problem")?>" method="post" enctype="multipart/form-data">
									<ul class="col1">
										<li><label for="code">Problem Code:</label></li>
										<li><input id="code" type="text" size="40" name="code" value="<?=sv('code')?>" /></li>
										<?=form_error('code','<li class="error">','</li>')?>
										<li><label for="name">Problem Name:</label></li>
										<li><input type="text" size="40" name="name" value="<?=sv('name')?>" /></li>
										<?=form_error('name','<li class="error">','</li>')?>
									</ul>
									
									<ul class="col2">
										<li><label for="time_limit">Time limit:</label></li>
										<li><input id="time_limit" type="text" size="40" name="time_limit" value="<?=sv('time_limit')?>" /></li>
										<?=form_error('time_limit','<li class="error">','</li>')?>
										<li><label for="name">Memory limit:</label></li>
										<li><input id="memory_limit" type="text" size="40" name="memory_limit" value="<?=sv('memory_limit')?>" /></li>
										<?=form_error('memory_limit','<li class="error">','</li>')?>
									</ul>
									<div class="clear"></div>
									<ul id="editors">
										<li><label for="statement">Problem statement</label></li>
										<li class="editor-container"><textarea id="statement" name="statement" cols="100" rows="20"><?=sv('statement')?></textarea></li>
										<li class="sep">&nbsp;</li>
										
										<li><label for="input">Input</label></li>
										<li class="editor-container"><textarea id="input" name="input" cols="100" rows="10"><?=sv('input')?></textarea></li>
										<li class="sep">&nbsp;</li>
										
										<li><label for="output">Output</label></li>
										<li class="editor-container"><textarea id="output" name="output" cols="100" rows="10"><?=sv('output')?></textarea></li>
										<li class="sep">&nbsp;</li>
										
										<li><label for="sample_input">Test Input</label></li>
										<li class="editor-container"><textarea id="sample_input" name="sample_input" cols="100" rows="15"><?=sv('sample_input')?></textarea></li>
										<li class="sep">&nbsp;</li>
										
										<li><label for="sample_input">Test Output</label></li>
										<li class="editor-container"><textarea id="sample_output" name="sample_output" cols="100" rows="15"><?=sv('sample_output')?></textarea></li>
										<li class="sep">&nbsp;</li>
										
										<li><label for="hint">Hint</label></li>
										<li class="editor-container"><textarea id="hint" name="hint" cols="100" rows="10"><?=sv('hint')?></textarea></li>
										<li class="sep">&nbsp;</li>
										
										
									
									</ul>
									
									<ul class="col1">
										<li><label>Test Data</label></li>
										<ul>
											<li><label for="input_file">Input</label></li>
											<li><input type="file" size="40" name="input_file" id="input_file" /></li>
											
											<li><label for="output_file">Output</label></li>
											<li><input type="file" size="40" name="output_file" id="output_file" /></li>
											
											<li><label for="checker_file">Special Checker</label></li>
											<li><input type="file" size="40" name="checker_file" id="checker_file" /></li>
									
										</ul>
									</ul>
									<ul class="col2">
										<li><label for="is_visible">Visibility</label> 
											<input type="checkbox" size="40" value='1' id="is_visible" name="is_visible" <?=set_checkbox('is_visible', '1')?>/></li>
										<li class="sep">&nbsp;</li>
										<li><label for="source_id">Source</label></li>
										
										<li>
											<select id="source_id" name="source_id">
											<?php foreach ($sources as $source) {?>
												<option value="<?=$source->id?>" <?=set_select('source_id',$source->id)?>>&nbsp;&nbsp;<?=$source->label?>&nbsp;&nbsp;&nbsp;</option>
											<?php } ?>
											</select>
										</li>

										<li class="sep">&nbsp;</li>
										<li><label for="section_id">Section</label></li>

										<li>
											<select id="section_id" name="section_id">
											<?php foreach ($sections as $section) {?>
												<option value="<?=$section->id?>" <?=set_select('section_id',$section->id)?>>&nbsp;&nbsp;<?=$section->label?>&nbsp;&nbsp;&nbsp;</option>
											<?php } ?>
											</select>
										</li>
									</ul>
									
								<div class="clear"></div>
									<input id="add-problem-submit" type="submit" value=" Add " />
								</form>
								
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
