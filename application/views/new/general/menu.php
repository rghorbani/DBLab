<div id="nav">
	<ul>
		<li><a id="hm" href="<?=base_url()?>">Home</a></li>
		<?php if (!$is_logged_in) { ?>
		<li><a href="<?=site_url('users/signup')?>">Signup</a></li>
		<?php } ?>
		
		<li>
			<a href="#">Contests</a>
			<div class="submenu">
				<ul>
					<li><a href="<?=site_url("contests")?>">View Contests</a></li>
					<li><a href="<?=site_url("contests/page/1")?>">Past Contests</a></li>
					<?php if ($is_logged_in && $current_user->perm_create_contest) { ?>
					<li><a href="<?=site_url("contests/arrange")?>">Arrange a Contest</a></li>
					<li><a href="<?=site_url("contests/vranklists")?>">Virtual Ranklists</a></li>
					<?php } ?>
				</ul>
			</div>
		</li>

		<li>
			<a href="#">Sections</a>
			<div class="submenu">
				<ul>
					<li><a href="<?=site_url("sections")?>">View Sections</a></li>
					<li><a href="<?=site_url("sections/page/1")?>">Past Sections</a></li>
					<?php if ($is_logged_in && $current_user->perm_create_contest) { ?>
					<li><a href="<?=site_url("sections/arrange")?>">Arrange a Section</a></li>
					<li><a href="<?=site_url("sections/add_existing_problem")?>">Add Problem</a></li>
					<?php } ?>
				</ul>
			</div>
		</li>

		<li><a href="<?=site_url("sections/view/problemset")?>">Problem Set</a></li>
		<?php if ($is_logged_in) { ?>
		<li>
		<a href="#">Runs</a>
			<div class="submenu">
				<ul>
					<li><a href="<?=site_url("runs/user/" . $current_user->id)?>">My Runs</a></li>
					<li><a href="<?=site_url("runs/all")?>">All Runs</a></li>
				</ul>
			</div>
		</li>
		<?php }else { ?>
		<li><a href="<?=site_url("runs/all")?>">Runs</a></li>
		<?php } ?>
		<li><a href="<?=site_url("users/ranklist")?>">Ranklist</a></li>
		<?php if ($is_logged_in && ($current_user->perm_problem_setter || $current_user->perm_moderator)) { ?>
		<li>
			<a href="#">Admin</a>
			<div class="submenu">
				<ul>
					<?php if ($is_logged_in && $current_user->perm_problem_setter) { ?>
						<li><a href="<?=site_url("admin/add_problem")?>">+ New Problem</a></li>
						<li><a href="<?=site_url("admin/add_picture")?>">+ Upload Picture</a></li>
						<li><a href="<?=site_url("admin/manage_sources")?>">+ Manage Sources</a></li>
					<? } ?>
					<?php if ($is_logged_in && $current_user->perm_moderator) { ?>
						<li><a href="<?=site_url("admin/manage_news")?>">+ Manage News</a></li>
					<?php } ?>
				</ul>
			</div>
		</li>
		<?php } ?>
		
		<?php if ($is_logged_in) { ?>
		<li><a href="<?=site_url("users/profile/" . $current_user->id)?>">My Profile</a></li>
		<li><a href="<?=site_url("users/logout")?>">Logout [ <?=$current_user->username?> ]</a></li>
		<?php } ?>
	</ul>
</div>
