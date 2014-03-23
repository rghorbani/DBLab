		</div>
<script>
	(function ($) {
		show_caf = function(id) {
			$("#caf_" + id + "_form").slideToggle('slow');
			return false;
		}
		$(function () {
			$(".answer").each( function (index) {
				$(this).click(function () {
					if ($(this).val() == "No Response. Read the problem specification.") $(this).val("");
				});
				
				$(this).blur(function () {
					if ($(this).val() == "") $(this).val("No Response. Read the problem specification.");
				});
			});
		});
	})(jQuery);
</script>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_tabs($contest, $is_logged_in, $current_user, TAB_CONTEST_JCLARS);
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
								<h4>Question: [<?=($clar->pid==-1?("General"):("Problem " . $clar->letter))?>] from [<a href="<?=site_url("users/profile/" . $clar->uid)?>"><?=$clar->name?></a>]</h4>
								<p> &nbsp; <?=($clar->question)?></p>
								<a class="caf_ans" href="#" onclick="return show_caf(<?=$clar->id?>)"><h4>Answer</h4></a>
								<form id="caf_<?=$clar->id?>_form" class="clar_ans_form" action="<?=site_url('contests/clarjudge/' . $contest->id)?>" method="post">
									<ul>
										<li>
											<textarea class="answer" id="caf_<?=$clar->id?>" name="answer" cols="120" rows="4">No Response. Read the problem specification.</textarea>
										</li>
										<li><label style="width:130px" for="caf_<?=$clar->id?>_toall">Send to all teams.</label></li>
										<li><input id="caf_<?=$clar->id?>_toall" type="checkbox" value="1" name="to_all" /></li>
										
										<input class="caf_submit_btn" type="submit" value="Send" />
									</ul>
									<input type="hidden" name="cid" value="<?=$clar->id?>" />
								</form>
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
				</div>
				
			</div>
		</div>
