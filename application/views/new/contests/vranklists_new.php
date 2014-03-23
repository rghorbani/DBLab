<script>
	(function ($) {
		$(function () {
			$("input#vrank_new_team").click(function () {
				id = parseInt($("#teams").val())+1;
				$("#teams").val(id);
				row = '<tr class="' + (id%2==0?'even':'odd') + '"><td><center><input type="text" name="team_name_' + id + '" size="20" onfocus="this.value=\'\'" value="Team name" /></center></td><?php for($i=0;$i<$pnum;$i++) {?><td><center><input type="text" name="team_' + id + '_<?=$problem_letters[$i]?>" size="3" /></center></td><?php } ?></tr>';
				$("#vranklist-table tbody").append(row);
			});
		});
	})(jQuery);
</script>
		<h1 id="top-title">Virtual Ranklists</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						contest_home_tabs($is_logged_in, $current_user, TAB_CONTEST_HOME_VRANKLIST);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					
					<div id="vranklist-add" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<form id="vranklist-form" action="<?=site_url("contests/addvranklists")?>" method="post">
									<table class="list" id="vranklist-table">
										<thead>
											<tr style="border-bottom-width:3px">
												<th scope="col" width="20%" class="title"><center>Name</center></th>
												<?php
													for($i=0;$i<$pnum;$i++) {
												?>
												<th scope="col" class="title" style="border-bottom:3px #000000 solid"><center><?=$problem_letters[$i]?></center></th>
												<?php
													}
												?>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>
									<input id="vrank_new_team" type="button" value="+ New Team" />
									<ul>
										<li><label for="vrlname_tb">Virtual Ranklist Name</label>
										<input class="input" size="30" name="vrlname" type="text" id="vrlname_tb"  value="<?php echo set_value('vrlname'); ?>" /><input id="submit_add-vrank" type="submit" value="Create" /></li>
										<?=form_error('vrlname','<li class="error">','</li>')?>
									</ul>
									<input type="hidden" id="teams" name="teams" value="0" />
									<input type="hidden" id="pnum" name="pnum" value="<?=$pnum?>" />
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
