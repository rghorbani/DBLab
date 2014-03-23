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

		<script type="text/javascript" src="<?=site_url("assets")?>/datepicker/datepicker.js"></script>
		<script type="text/javascript" src="<?=site_url("assets")?>/colorpicker/jquery.modcoder.excolor.js"></script>
		<link rel="stylesheet" href="<?=site_url("assets")?>/datepicker/datepicker.css" />

		
		<div class="bar">Arragnge Contest</div>
		<div class="container-top"></div>
		<div class="container">		
			<form action="<?=site_url("contests/arrange")?>" method="post">
				<table class="T" width="100%">
					<tr>
						<td class="title" colspan="3"><center><strong>Arrange a Contest</strong></center></td></tr>
					<tr>
						<td width="39%">Contest label:</td>
						<td><input class="i" name="label" size="38" value="<?=set_value("label")?>" /><?=form_error('label','<div class="small error">','</div>')?></td>
					</tr>
					<tr >
						<td style="vertical-align:text-top">Contest Starting Date:</td>
						<td><input type="text" name="starttime_date" size="38" class="i display-inline dateformat-Y-ds-m-ds-d range-low-<?=$today_year?><?=$today_month?><?=$today_day?> range-high-1-month statusformat-l-cc-sp-d-sp-F-sp-Y highlight-days-5 fill-grid-no-select" value="<?=set_value("starttime_date", $today_year . "-" . $today_month . "-" . $today_day)?>" /><br /><?=form_error('starttime_date','<div class="small error">','</div>')?></td>
					</tr>
					<tr >
						<td>Contest Starting Time:</td>
						<td><input type="text" name="tH" size="1" value="<?=set_value("tH",$today_hour)?>" class="i"/>:<input type="text" name="tM" size="1" value="<?=set_value("tM",$today_minute)?>" class="i"/>:<input type="text" name="tS" size="1" value="<?=set_value("tS", $today_second)?>" class="i"/>
						<?=form_error('tH','<div class="small error">','</div>')?>
						<?=form_error('tM','<div class="small error">','</div>')?>
						<?=form_error('tS','<div class="small error">','</div>')?>
						</td>
					</tr>
					<tr >
						<td>Contest length:</td>
						<td><input type="text" name="lH" size="1" value="<?=set_value("lH", 5)?>" class="i"/> Houres, <input type="text" name="lM" size="1" value="<?=set_value("lM", 0)?>" class="i"/> Minutes, <input type="text" name="lS" size="1" value="<?=set_value("lS", 0)?>" class="i"/> Sec.
						<?=form_error('lH','<div class="small error">','</div>')?>
						<?=form_error('lM','<div class="small error">','</div>')?>
						<?=form_error('lS','<div class="small error">','</div>')?>
						</td>
					</tr>
					<tr >
						<td>Problems:</td>
						<td>
							<table style="font-family:'Courier New', Courier, monospace;">
								<tr>
									<td>A.<input type="text" name="p1" size="3" value="<?=problem_code(1, 1001)?>" class="i"/>
										  <input readonly="readonly" type="text" name="p1_c" id="p1_c" size="1" value="<?=problem_color(1,"#000000")?>" class="i color_picker_tb"/></td>
									<td>B.<input type="text" name="p2" size="3" value="<?=problem_code(2, 1002)?>" class="i"/>
										  <input type="text" name="p2_c" id="p2_c" size="1" value="<?=problem_color(2,"#000000")?>" class="i color_picker_tb"/></td>
									<td>C.<input type="text" name="p3" size="3" value="<?=problem_code(3, 1003)?>" class="i"/>
										  <input type="text" name="p3_c" id="p3_c" size="1" value="<?=problem_color(3,"#000000")?>" class="i color_picker_tb"/></td>									
								</tr>
								<tr>
									<td>D.<input type="text" name="p4" size="3" value="<?=problem_code(4)?>" class="i"/>
										  <input type="text" name="p4_c" id="p4_c" size="1" value="<?=problem_color(4,"#000000")?>" class="i color_picker_tb"/></td>
									<td>E.<input type="text" name="p5" size="3" value="<?=problem_code(5)?>" class="i"/>
										  <input type="text" name="p5_c" id="p5_c" size="1" value="<?=problem_color(5,"#000000")?>" class="i color_picker_tb"/></td>
									<td>F.<input type="text" name="p6" size="3" value="<?=problem_code(6)?>" class="i"/>
										  <input type="text" name="p6_c" id="p6_c" size="1" value="<?=problem_color(6,"#000000")?>" class="i color_picker_tb"/></td>
								</tr>
								<tr>
									<td>G.<input type="text" name="p7" size="3" value="<?=problem_code(7)?>" class="i"/>
										  <input type="text" name="p7_c" id="p7_c" size="1" value="<?=problem_color(7,"#000000")?>" class="i color_picker_tb"/></td>
									<td>H.<input type="text" name="p8" size="3" value="<?=problem_code(8)?>" class="i"/>
										  <input type="text" name="p8_c" id="p8_c" size="1" value="<?=problem_color(8,"#000000")?>" class="i color_picker_tb"/></td>
									<td>I.<input type="text" name="p9" size="3" value="<?=problem_code(9)?>" class="i"/>
										  <input type="text" name="p9_c" id="p9_c" size="1" value="<?=problem_color(9,"#000000")?>" class="i color_picker_tb"/></td>
								</tr>
								<tr>
									<td>J.<input type="text" name="p10" size="3" value="<?=problem_code(10)?>" class="i"/>
										  <input type="text" name="p10_c" id="p10_c" size="1" value="<?=problem_color(10,"#000000")?>" class="i color_picker_tb"/></td>
									<td>K.<input type="text" name="p11" size="3" value="<?=problem_code(11)?>" class="i"/>
										  <input type="text" name="p11_c" id="p11_c" size="1" value="<?=problem_color(11,"#000000")?>" class="i color_picker_tb"/></td>
									<td>L.<input type="text" name="p12" size="3" value="<?=problem_code(12)?>" class="i"/>
										  <input type="text" name="p12_c" id="p12_c" size="1" value="<?=problem_color(12,"#000000")?>" class="i color_picker_tb"/></td>
								</tr>
								<tr>
									<td>M.<input type="text" name="p13" size="3" value="<?=problem_code(13)?>" class="i"/>
										  <input type="text" name="p13_c" id="p13_c" size="1" value="<?=problem_color(13,"#000000")?>" class="i color_picker_tb"/></td>
									<td>N.<input type="text" name="p14" size="3" value="<?=problem_code(14)?>" class="i"/>
										  <input type="text" name="p14_c" id="p14_c" size="1" value="<?=problem_color(14,"#000000")?>" class="i color_picker_tb"/></td>
									<td>O.<input type="text" name="p15" size="3" value="<?=problem_code(15)?>" class="i"/>
										  <input type="text" name="p15_c" id="p15_c" size="1" value="<?=problem_color(15,"#000000")?>" class="i color_picker_tb"/></td>
								</tr>
								
							</table>
							<?php
								for ($i=1;$i<=15;$i++) {
									echo(form_error("p".$i,'<div class="small error">','</div>'));
								}
							?>
							<?php
								if ($problem_error) {
									echo('<div class="small error">Contests must include at least 3 problems.</div>');
								}
							?>
						</td>
					</tr>
					
				
					<tr>
						<td colspan="3" align="center"><input style="border:none" type="image" src="<?=site_url("assets")?>/images/addContest.png" /></td>
					</tr>    
		
				</table>
			</form>
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>	
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

		