		<link rel="stylesheet" href="<?=site_url("assets/ace/ace.css")?>" type="text/css" media="screen" charset="utf-8">

		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_SUBMIT);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="submit_drop_area" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<center><span class="big">Drag and drop your source file to the box below!</span></center>
							</div>
						</div>
					</div>
					<div id="problemset_submit" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<?=form_error('code','<div class="center error">','</div>')?>
								<form id="submit_form" action="<?=site_url('contests/submit/' . $contest->id)?>" method="post">
									<ul>
										<li>
											<label for="contest">Contest</label>
											<input id="contest" type="text" disabled="disabled" value="<?=clean4print($contest->label)?>" size="40" readonly="readonly" />
										</li>
										<li>
											<label for="problem">Problem </label>
											<select id="problem" name="problem" size="1" class="i">
												<option value="-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												foreach ($problems as $a_problem) {
											?>
												<option value="<?=$a_problem->letter?>" <?=set_select('problem', $a_problem->letter)?>>&nbsp; Problem <?=$a_problem->letter?> | <?=$a_problem->name?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												}
											?>
											</select>
											<?php if ($select_problem_err) echo ('<div class="item-err error">Select the problem!</div>');?>
										</li>

										<li>
											<label for="lang_sel">Lang.</label>
											<select id="lang_sel" name="language" size="1">
												<option value="-1" <?=set_select('language',"-1", $current_user->default_compiler == -1)?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												foreach ($langs as $lang) {
											?>
												<option value="<?=$lang->id?>" <?=set_select('language',$lang->id, $current_user->default_compiler == $lang->id)?>>&nbsp; <?=$lang->label?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<? } ?>
											</select><?=form_error('language','<div class="item-err error">','</div>')?>
										</li>
										<li>
											<label for="source_code">Source Code</label>
											<? $src = isset($run)?$run->source:set_value('source_code'); ?>
											<div id="editor"><?=$src?></div>
											<div style="padding:20px; text-align:center;">press F11 to switch to fullscreen mode</div>
											<textarea style="display:none;" id="source_code" name="source_code" cols="100" rows="20"><?=$src?></textarea>
											<input  type="hidden" name="source" id="source" value="<?=$src?>">
											<?=form_error('source_code','<div class="item-err error">','</div>')?>
										</li>
									<ul>
									<input id="submit_btn" type="submit" value="Submit" />
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
<script src="<?=site_url("assets/ace/ace.js")?>" data-ace-base="<?=site_url("assets/ace")?>" type="text/javascript" charset="utf-8"></script>
<script src="<?=site_url("assets/ace/editor.js")?>" type="text/javascript"></script>