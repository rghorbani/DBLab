	
		<div class="bar">Admin</div>
		<div class="container-top"></div>
		<div class="container">
				<?php
					if ($source_added) echo '<div class="center error">Source Added</div>';
				?>
				<table class="T" width="100%">
					<tr>
						<td class="title" colspan="2"><center>Sources</center></td>
					</tr>
					<tr>
						<td width="250px"><strong> Add Source:</strong></td>
						<td>
							<form action="<?=site_url("admin/manage_sources")?>" method="post"><input type="text" size="40" name="label" value="<?=$source_added?"":set_value('label')?>" /> <input type="submit" value="+ Add" /></form>
							<?=form_error('label','<div class="small error">','</div>')?>
						</td>
					</tr>
					<tr>
						<td style="vertical-align:text-top;"><strong> Manage:</strong></td>
						<td style="height:200px; vertical-align:text-top;">
							<div style="height:100%; overflow:auto;">
								<table class="T" width="100%">
									<tr>
										<td width="80%"><strong>Label</strong></td>
										<td width="10%"><strong>Num</strong></td>
										<td width="10%"><strong>Action</strong></td>
									</tr>
									<? foreach($sources as $source) { ?>
									<tr>
										<td><?=$source->label?></td>
										<td><center><?=$source->num?></center></td>
										<td><center><? if ($source->num == 0) { ?><a href="<?=site_url("admin/delete_source/" . $source->id)?>">Delete</a><? } ?></center></td>
									</tr>
									<? } ?>
								</table>
							 </div>
						</td>
					</tr>
					
					
				</table>

			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>