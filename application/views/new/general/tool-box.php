	<div id="tool-box">
		<a class="tb-icon" id="tb-icon-notifications"><div class="badge nos"><span></span></div></a>
		<a class="tb-icon" id="tb-icon-searchbox"></a>
		<a class="tb-icon" id="tb-icon-bugreport"></a>
		
		<div class="tb-box" id="tb-box-notifications">
			<div class="tb-box-content" id="notifications-list">
				<span class="title">Notifications</span>
				<div id="tb-notification-scroll">
					<div class="loading"><img src="<?=site_url("assets/theme_new/images/loading.gif")?>" /><br />please wait</div>
					<ul id="notifications">
				
					</ul>
				<div class="clear"></div>
				</div>
			</div>
			<span class="arrow"></span>
		</div>
		
		
		<div class="tb-box" id="tb-box-searchbox">
			<div class="tb-box-content" id="searchbox">
				<span class="title">Problemset Search</span>
				<form id="tb-searchform" action="<?=site_url("problemset/search")?>" method="post">
					<input class="f" type="text" size="17" name="q" /> <input type="submit" value="Search" />
				</form>
				
			</div>
			<span class="arrow"></span>
		</div>
		
		<div class="tb-box" id="tb-box-bugreport">
			<div class="tb-box-content" id="bugreport">
				<span class="title">Report a bug or suggestion</span>
				<span class="description">If you've seen any bugs around or have any idea that might help us to improve <strong>Share</strong>Code, we can't wait to hear it!</span>
				<form id="tb-bugreport">
					<label>Your message:</label>
					<textarea id="bug-message"></textarea>
					<span class="error" id="error_msg"></span><br />
					<input type="submit" value="Send" />
				</form>
				<div class="loading nos"><img src="<?=site_url("assets/theme_new/images/loading.gif")?>" /><br />please wait</div>
			</div>
			<span class="arrow"></span>
		</div>
		
	</div>