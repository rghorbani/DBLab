		</div>

<?php
	if ($contest->finished == FALSE) {
?>
<script type="text/javascript" language="javascript">
	function update_page() {
		window.location.replace(window.location.href);
	}
	jQuery(function () {
		setInterval("update_page()",1000*60);
	});

</script>

<?php
	}
?>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_CLARS);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<?php
						foreach($clars as $clar) {
					?>
					<div class="shadowed problemset_clar">
						<div class="inner-box">
							<div class="content">
								
								<h4>Question: [<?=($clar->pid==-1?("General"):("Problem " . $clar->letter))?>]</h4>
								<p> &nbsp; <?=($clar->question)?></p>
								<?php if ($clar->answer == "") { ?>
								<strong>Clarification pending.</strong>
								<?php } else { ?>
								<h4>Judge answer:</h4>
								<p><span class="red"> &nbsp; <?=($clar->answer)?></span></p>
								<?php } ?>
								
							</div>
						</div>
					</div>
					<?php
						}
					?>
					<?php
						if (count($clars) == 0) {
					?>
					<div class="shadowed problemset_noclar">
						<div class="inner-box">
							<div class="content">
								<span class="big">There is no clarifications<? if ($contest->finished == FALSE) echo(" yet"); ?>!</span>
							</div>
						</div>
					</div>
					<? } ?>
					<?php
						if ($contest->finished == FALSE && $is_logged_in) {
					?>
					<div id="clarification" class="shadowed">
						<div class="inner-box">
							<div class="content">
								
								
								<?=form_error('code','<div class="center error">','</div>')?>
								<form id="submit_form" action="<?=site_url('contests/clarifications/' . $contest->id)?>" method="post">
									<ul>
										<li>
											<label for="contest">Contest</label>
											<input id="contest" type="text" disabled="disabled" value="<?=clean4print($contest->label)?>" size="40" readonly="readonly" />
										</li>
										<li>
											<label for="problem">Clarification for </label>
											<select id="problem" name="problem" size="1" class="i">
												<option value="-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
												<option value="-2">&nbsp;&nbsp;General&nbsp;&nbsp;&nbsp;&nbsp;</option>
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
											<label for="question">Question</label>
											<textarea id="question" name="question" cols="100" rows="10"><?=set_value('question')?></textarea>
											<?=form_error('question','<div class="item-err error">','</div>')?>
										</li>
									<ul>
									<input id="submit_btn" type="submit" value="Ask" />
								</form>
								
							</div>
						</div>
					</div>
					<?php
						}
					?>
					
				</div>
				
			</div>
		</div>
