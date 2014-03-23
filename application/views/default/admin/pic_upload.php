	
		<div class="bar">Admin</div>
		<div class="container-top"></div>
		<div class="container">
				<?php
					if ($picture_uploaded != NULL) echo '<div class="center error">Picture Added</div>';
				?>
				<table class="T" width="100%">
					<tr>
						<td class="title" colspan="2"><center>Upload image</center></td>
					</tr>
					<tr>
						<td width="250px"><strong> Upload:</strong></td>
						<td>
							<form action="<?=site_url("admin/add_picture")?>" method="post" enctype="multipart/form-data">
								Problem Code <input type="text" size="10" name="problem_code" value="<?=set_value('problem_code')?>"/>
								<input type="file" size="20" name="pic_file" /><input type="submit" value="Upload" />
								<?=form_error('problem_code','<br /><div class="small error">','</div>')?>
							</form>
						</td>
					</tr>
					<?php if ($picture_uploaded != NULL) { ?>
					<tr>
						<td style="vertical-align:text-top;"><strong> Information:</strong></td>
						<td>
							Image URL: 
							<input type="text" size="80" value="<?=site_url("assets/problem_images") . "/" . $picture_uploaded?>" />
						</td>
					</tr>
					<?php } ?>
					
				</table>

			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>
