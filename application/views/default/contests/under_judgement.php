		<script type="text/javascript">
			setTimeout(function() {
				window.location.href = "<?=site_url("contests/runs/" . $contest->id)?>";
			}, 4000);
		</script>
		<div class="bar">Redirecting ...</div>
		<div class="container-top"></div>
		<div class="container">
			<a href="<?=site_url("contests/runs/" . $contest->id)?>">
				<div id="submit_result">
					<h2>Your solution has been submitted!</h2><br />
					<p>Your source code is now in judge queue.<br />Click here if your browser is not automatically redirected to the run status page.</p>
				</div>
			</a>
			<div class="clear"></div>
		</div>
		<div class="container-bot"></div>