		<h1 id="top-title">Admin :: Add Picture</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						admin_tabs($is_logged_in, $current_user, TAB_ADMIN_UPLOADPIC);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div class="clear"></div>
					<div id="add_picture" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<?php
									if ($picture_uploaded != NULL) echo '<div class="center error">Picture Added</div>';
								?>
								<form id="add-pic-form" action="<?=site_url("admin/add_picture")?>" method="post" enctype="multipart/form-data">
									<ul class="col1">
										<li><label for="problem_code">Problem Code</label></li>
										<li><input type="text" size="10" name="problem_code" id="problem_code" value="<?=set_value('problem_code')?>"/></li>
										<?=form_error('problem_code','<li class="error">','</li>')?>
										<li><label for="pic_file">Image to Upload</label></li>
										<li><input type="file" size="20" name="pic_file" id="pic_file" /></li>
									</ul>
									<input id="upload-pic-submit" type="submit" value="Upload" />
									
								</form>
								
								<?php if ($picture_uploaded != NULL) { ?>
									
									<input onfocus="this.select()" type="text" size="75" value="<?=site_url("assets/problem_images") . "/" . $picture_uploaded?>" /></li>
									
								<?php } ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
