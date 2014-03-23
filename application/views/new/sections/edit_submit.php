<script>
	dnd_sourcefile("#submit_drop_area", "#source_code", "#lang_sel");
</script>

<link rel="stylesheet" href="<?=site_url("assets/ace/ace.css")?>" type="text/css" media="screen" charset="utf-8">

		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						problem_tabs($is_logged_in, $current_user, TAB_PROBLEM_SUBMIT, $url, $problem);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="submit_drop_area" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<center><span class="big">Drag and drop your source file here!</span></center>
							</div>
						</div>
					</div>
					<div id="problemset_submit" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<?=form_error('code','<div class="center error">','</div>')?>
								<form id="submit_form" action="<?=site_url('sections/submit/' . $url . '/' . $problem->code)?>" method="post">
									<ul>
										<li>
											<label for="problemcode">Problem Code</label>
											<input id="problemcode" type="text" disabled="disabled" value="<?=$problem->code?>" size="40" readonly="readonly" />
										</li>
										<li>
											<label for="problemnale">Problem Name</label>
											<input id="problemnale" type="text" disabled="disabled" value="<?=$problem->name?>" size="40" readonly="readonly" />
										</li>
										<li>
											<label for="lang_sel">Lang.</label>
											<select id="lang_sel" name="language" size="1" onchange="langChange()">
												<option value="-1" <?=set_select('language',"-1", $run->lang == -1)?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												foreach ($langs as $lang) {
											?>
												<option value="<?=$lang->id?>" <?=set_select('language',$lang->id, $run->lang == $lang->id)?>>&nbsp; <?=$lang->label?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<? } ?>
											</select><?=form_error('language','<div class="item-err error">','</div>')?>
										</li>
										<li>
											<label for="font_size">Fontsize</label>
											<select id="fontsize" name="fontsize" size="1" onchange="document.getElementById('editor').style.fontSize = this.value">
												<option value="10px">10px</option>
									        	<option value="11px">11px</option>
									        	<option value="12px" selected="selected">12px</option>
									        	<option value="13px">13px</option>
									        	<option value="14px">14px</option>
									        	<option value="16px">16px</option>
									          	<option value="18px">18px</option>
									          	<option value="20px">20px</option>
									          	<option value="24px">24px</option>
											</select>
										</li>
										<li>
											<label for="source_code">Source Code</label>
											<div id="editor"></div>
											<textarea style="display:none;" id="source_code" name="source_code" cols="100" rows="20" onchange="setEditor()"><?=$run->source?></textarea>
											<div style="padding:20px; text-align:center;">press F11 to switch to fullscreen mode</div>
											<input  type="hidden" id="source" name="source" value="<?=set_value('source_code')?>">
											<?=form_error('source_code','<div class="item-err error">','</div>')?>
										</li>
									<ul>
									<input type="hidden" name="code" value="<?=$problem->code?>" />
									<input id="submit_btn" type="submit" value="Submit" onclick="extractCode()" />
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
<script src="<?=site_url("assets/ace/ace.js")?>" data-ace-base="<?=site_url("assets/ace")?>" type="text/javascript" charset="utf-8"></script>
<script src="<?=site_url("assets/ace/editor.js")?>" type="text/javascript"></script>