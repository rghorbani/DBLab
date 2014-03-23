<?php
	
?>
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
					
					<div id="vranklist-new" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<form id="vranklist-form" action="<?=site_url("contests/vranklists")?>" method="post">
									<h4>Setup new virtual ranklist</h4>
									<ul>
										<li><label for="pnum_tb">Number of problems:</label>
										<input class="input" size="30" name="pnum" type="text" id="pnum_tb"  value="<?php echo set_value('pnum'); ?>" />
										<input id="submit_new-vrank" type="submit" value="Create" /></li>
										<?=form_error('pnum','<li class="error">','</li>')?>
									</ul>
									
								</form>
							</div>
						</div>
					</div>
					
					<div id="vranklist-list" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<form id="vranklist-form" action="<?=site_url("contests/vranklist")?>" method="post">
									<h4>Virtual ranklist</h4>
									<ul>
									<?php
										foreach($vranklists as $vranklist) {
									?>
										<li><?=$vranklist->label?></li>
									<?php
										}
									?>
									</ul>
								</form>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
