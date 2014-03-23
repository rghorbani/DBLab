<?php
	$date = nowDateArray();
	$today_year = $date[0];
	$today_month = $date[1];
	$today_day = $date[2];
	$today_hour = $date[3];
	$today_minute = $date[4];
	$today_second = $date[5];
	
	function problem_code($index, $default = "", $set_err = FALSE, $p = NULL) {
		static $err = FALSE;
		static $problems = FALSE;
		if ($set_err == TRUE) {
			$err = TRUE;
			$problems = $p;
			return "!";
		}
		if ($err) {
			return $problems[$index-1]["code"];
		}else {
			return set_value("p" . $index, $default);
		}
	}
	function problem_color($index, $default = "", $set_err = FALSE, $p = NULL) {
		static $err = FALSE;
		static $problems = FALSE;
		if ($set_err == TRUE) {
			$err = TRUE;
			$problems = $p;
			return "!";
		}
		if ($err) {
			return $problems[$index-1]["color"];
		}else {
			return set_value("p" . $index . "_c", $default);
		}
	}
	if ($problem_error) {
		problem_color(-1,'',TRUE,$valid_problems);
		problem_code(-1,'',TRUE,$valid_problems);
	}
?>

		<script type="text/javascript" src="<?=site_url("assets/theme_new")?>/datepicker/datepicker.js"></script>
		<script type="text/javascript" src="<?=site_url("assets/theme_new")?>/colorpicker/jquery.modcoder.excolor.js"></script>
		<link rel="stylesheet" href="<?=site_url("assets/theme_new")?>/datepicker/datepicker.css" />

		<h1 id="top-title">Arrange Section</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						section_tabs($is_logged_in, $current_user, TAB_SECTION_ARRANGE);			
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="contests_arrange" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<form id="arrange-contest-form" action="<?=site_url("sections/arrange")?>" method="post">
									<table id="arrange-table" width="100%">
										<tr>
											<td>
												<ul>
													<li><label for="label">Section Label:</label></li>
													<li><input id="label" type="text" name="label" size="38" value="<?=set_value("label")?>" /></li>
													<?=form_error('label','<li class="error">','</li>')?>
													<li>&nbsp;</li>
													<li><label for="url">Section URL:</label></li>
													<li><input id="url" type="text" name="url" size="38" value="<?=set_value("url")?>" /></li>
													<?=form_error('url','<li class="error">','</li>')?>
													<li>&nbsp;</li>
													<li>Section Starting Date:</li>
													<?=form_error('starttime_date','<li class="error">','</li>')?>
													<li><input type="text" name="starttime_date" size="38" class="i display-inline dateformat-Y-ds-m-ds-d range-low-<?=$today_year?><?=$today_month?><?=$today_day?> range-high-1-month statusformat-l-cc-sp-d-sp-F-sp-Y highlight-days-5 fill-grid-no-select" value="<?=set_value("starttime_date", $today_year . "-" . $today_month . "-" . $today_day)?>" /></li>									
												</ul>
											</td>
											<td>
													<ul>
														<li>Section Starting Time:
														&nbsp;<input type="text" name="tH" size="1" value="<?=set_value("tH",$today_hour)?>" />:<input type="text" name="tM" size="1" value="<?=set_value("tM",$today_minute)?>" />:<input type="text" name="tS" size="1" value="<?=set_value("tS", $today_second)?>" /></li>
														<?=form_error('tH','<li class="error">','</li>')?>
														<?=form_error('tM','<li class="error">','</li>')?>
														<?=form_error('tS','<li class="error">','</li>')?>
														<li>&nbsp;</li>
														<li>Section length:
														<input type="text" name="lH" size="1" value="<?=set_value("lH", 5)?>" /> Houres, <input type="text" name="lM" size="1" value="<?=set_value("lM", 0)?>" /> Minutes, <input type="text" name="lS" size="1" value="<?=set_value("lS", 0)?>" /> Sec.</li>
														<?=form_error('lH','<li class="error">','</li>')?>
														<?=form_error('lM','<li class="error">','</li>')?>
														<?=form_error('lS','<li class="error">','</li>')?>
														<li>&nbsp;</li>
														<li>
															<label for="description">Description:</label>
														<li>
														</li>
															<textarea id="description" name="description" cols="43" rows="6"><?=set_value("description")?></textarea>
														<li>
														<li>&nbsp;</li>
														<li>
															<label for="visibe">Visibe:</label>
														</li>
														<li>
															<select id="visible" name="visible">
																<option value="1" selected="selected">YES</option>
																<option value="0">NO</option>
															</select>
														</li>
														<li>&nbsp;</li>
														<li>
															<label for="priority">Priority:</label>
														</li>
														<li>
															<select id="priority" name="priority">
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3" selected="selected">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
															</select>
														</li>
														<li>&nbsp;</li>
														<li>
															<input type="submit" id="submit_arrange-contest" value="Create" />	
														</li>
													<ul>
											</td>
									</table>
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript">
	for (var i=1;i<=15;i++) {
		jQuery('#p' + i + '_c').modcoder_excolor({
			hue_bar : 1,
			round_corners : false,
			shadow : false,
			backlight : false
		});
	}
</script>
