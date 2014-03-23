<?php
	function showPageNumber($i, $c=0, $set=false) {
		static $current = 1;
		if ($set) { $current = $c; return; }
		if ($i != $current) echo '<li><a href="' . site_url("admin/manage_news/" . $i) . '">' . $i . '</a></li> ';
		else					 echo '<li class="selected">' . $i . '</li> ';
	}
	showPageNumber(0, $current_page, true);
?>
<script>
	jQuery(function () {
		jQuery("a.delete_news_link").click(function (e) {
			if (!confirm("Are you sure? you cant undo this operation!")) e.preventDefault();
		});
	})
</script>
		<h1 id="top-title">Admin :: Manage News</h1>
	</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					<?php
						admin_tabs($is_logged_in, $current_user, TAB_ADMIN_NEWS);
					?>
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div id="paging">
						<span>pages:</span>
						<ul>
							<?php
							if ($total_pages < 12) {
								for ($i=1;$i<=$total_pages;$i++) showPageNumber($i);
							}else {
								if ($current_page < 6) {
									for ($i=1;$i<7;$i++) showPageNumber($i);
									echo " ... ";
									for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
								}else if ($current_page > $total_pages-6) {
									for ($i=1;$i<3;$i++) showPageNumber($i);
									echo " ... ";
									for ($i=$total_pages-6;$i!=$total_pages+1;$i++) showPageNumber($i);
								}else {
									for ($i=1;$i<4;$i++) showPageNumber($i);
									echo " ... ";
									 showPageNumber($current_page-1);
									 showPageNumber($current_page);
									 showPageNumber($current_page+1);
									echo " ... ";
									for ($i=$total_pages-3;$i!=$total_pages+1;$i++) showPageNumber($i);
								}
							}
							?>
						</ul>
					</div>
					<div class="clear"></div>
					<div id="add_source" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<?php
									if ($news_added) echo '<div class="center error">News Added</div>';
								?>
								
								<form id="add-source-form" action="<?=site_url("admin/manage_news")?>" method="post">
									<ul class="col1">
										<li><strong>New News</strong></li>
										<li>
											<label for="priority">Priority</label>
											<select id="priority" name="priority" size="1">
												<option value="1">1</option>
									        	<option value="2">2</option>
									        	<option value="3" selected="selected">3</option>
									        	<option value="4">4</option>
									        	<option value="5">5</option>
											</select>
											<label for="priority">Visibility</label>
											<select id="visible" name="visible" size="1">
									        	<option value="0">0</option>
									        	<option value="1" selected="selected">1</option>
											</select>
										</li>
										</br>
										<li><textarea id="content" name="content" cols="40" rows="5"><?=set_value('content')?></textarea></li>
										<?=form_error('label','<li class="error">','</li>')?>
									</ul>
									<input id="add-source-submit" type="submit" value="+ Add" />
								</form>
								<table id="problem-runs-list-table" class="list" width="100%">
									<thead>
										<tr>
											<th scope="col" width="8%">ID</th>
											<td scope="col" width="8%">Visible</td>
											<td scope="col" width="70%">Content</td>
											<td scope="col" width="12%">Date</td>
											<td scope="col" width="2%"></td>
										</tr>
									</thead>
									<tbody>
									<?php for($i=0;$i<count($news); $i++) { 
										if($i == 0) {
									?>
									<tr  class="run_row" id="news_<?=$news[$i]->id?>">
										<th><center><?=$news[$i]->id?></center></th>
										<td><center><?=$news[$i]->visible?></center></td>
										<td><b style="color: red;"><?=$news[$i]->content?></b></td>
										<td><center><?=$news[$i]->time?></center></td>
										<?php if ($is_logged_in && $current_user->perm_moderator) {	?>
										<td><a class="delete_news_link" id="delete_<?=$news[$i]->id?>" href="<?=site_url("admin/delete_news/" . $news[$i]->id)?>"><img src="<?=site_url("assets/theme_new/icons/run_del.png")?>" /></a></td>
										<? } ?>
									</tr>
									<? } else { ?>
									<tr class="run_row" id="news_<?=$news[$i]->id?>">
										<th><center><?=$news[$i]->id?></center></th>
										<td><center><?=$news[$i]->visible?></center></td>
										<td><?=$news[$i]->content?></td>
										<td><center><?=$news[$i]->time?></center></td>
										<?php if ($is_logged_in && $current_user->perm_moderator) {	?>
										<td><a class="delete_news_link" id="delete_<?=$news[$i]->id?>" href="<?=site_url("admin/delete_news/" . $news[$i]->id)?>"><img src="<?=site_url("assets/theme_new/icons/run_del.png")?>" /></a></td>
										<? } ?>
									</tr>
									<? } } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>