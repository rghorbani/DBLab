		<link rel="stylesheet" href="<?=site_url("assets/ace/ace.css")?>" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="<?=site_url("assets/jwerty/jwerty	.css")?>" type="text/css" media="screen" charset="utf-8">

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
								<center><span class="big">Drag and drop your source file to the box below!</span></center>
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
											<? if(isset($run)) { ?>
												<option value="-1" <?=set_select('language',"-1", $current_user->default_compiler == -1)?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<?php
												}
												foreach ($langs as $lang) {
													if(isset($run)) {
											?>
												<option value="<?=$lang->id?>" <?=set_select('language',$lang->id, $run->lang == $lang->id)?>>&nbsp; <?=$lang->label?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<? } else { ?>
												<option value="<?=$lang->id?>" <?=set_select('language',$lang->id, $current_user->default_compiler == $lang->id)?>>&nbsp; <?=$lang->label?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
											<? } } ?>
											</select><?=form_error('language','<div class="item-err error">','</div>')?>
										</li>
										<li>
											<label for="source_code">Source Code</label>
											<? $src = isset($run)?$run->source:set_value('source_code'); ?>
											<div id="editor"><?=$src?></div>
											<div style="padding:20px; text-align:center;">press F11 to switch to fullscreen mode</div>
											<div style="padding:20px; text-align:center;">Use <span>(<b class="key">ctrl</b> + <b class="key" onclick="inc()">+</b> or <b class="key" onclick="dec()">-</b>) to increase or decrease font</span></div>
											<textarea style="display:none;" id="source_code" name="source_code" cols="100" rows="20"><?=$src?></textarea>
											<input  type="hidden" name="source" id="source" value="<?=$src?>">
											<?=form_error('source_code','<div class="item-err error">','</div>')?>
										</li>
									<ul>
									<input type="hidden" name="code" value="<?=$problem->code?>" />
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
		<script href="http://keithcirkel.co.uk/jwerty/jwerty.js" type="text/javascript"></script>
		<script type="text/javascript">
			jwerty.key('ctrl+shift+M/cmd+shift+M', function () {
		        console.log('Increasing font');
		        var size = ++fontSizeG;
		        alert(size);
		        document.getElementById('editor').style.fontSize = size + "px";
		    });
		    function inc() {
		    	var size = ++fontSizeG;
		        document.getElementById('editor').style.fontSize = size + "px";
		    }
		    function dec() {
		    	var size = --fontSizeG;
		        document.getElementById('editor').style.fontSize = size + "px";
		    }
		</script>