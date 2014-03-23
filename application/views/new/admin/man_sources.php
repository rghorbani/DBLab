		<h1 id="top-title">Admin :: Manage Sources</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						admin_tabs($is_logged_in, $current_user, TAB_ADMIN_SOURECS);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="add_source" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<?php
									if ($source_added) echo '<div class="center error">Source Added</div>';
								?>
									<form id="add-source-form" action="<?=site_url("admin/manage_sources")?>" method="post">
										<ul class="col1">
											<li><strong>New Souce</strong></li>
											<li><input type="text" size="40" name="label" value="<?=$source_added?"":set_value('label')?>" /></li>
											<?=form_error('label','<li class="error">','</li>')?>
										</ul>
										<input id="add-source-submit" type="submit" value="+ Add" />
									</form>
									
								
								<table class="list" width="100%">
									<thead>
										<tr>
											<th scope="col" width="80%">Label</th>
											<td scope="col" width="10%">Num</th>
											<td scope="col" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
									<? foreach($sources as $source) { ?>
									<tr>
										<td><?=$source->label?></td>
										<td><center><?=$source->num?></center></td>
										<td><center><? if ($source->num == 0) { ?><a href="<?=site_url("admin/delete_source/" . $source->id)?>">Delete</a><? } ?></center></td>
									</tr>
									<? } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
