			<div class="bar">Login</div>
			<div class="container-top"></div>
			<div class="container">
				<div id="login_container">
					<?php
						$err = form_error('username','<div class="center error">','</div>');
						if ($err == "") $err = form_error('password','<div class="center error">','</div>');
						if ($invalid_login) $err = '<div class="center error">Invalid username/password!</div>';
						echo $err;
					?>
					<form id="login_form" action="<?=$BASE?>users/login" method="post">
						<dl><dd><label for="username_tb">Username:</label><input class="input" size="30" name="username" type="text" id="username_tb"  value="<?php echo set_value('username'); ?>" /></dd></dl>
						<dl><dd><label for="password_tb">Password:</label><input class="input" size="30" name="password" type="password" id="password_tb" /></dd></dl>
						<dl><dd><input class="input" type="submit" value="Log me in!" /></dd></dl>
					</form>
				</div>
			</div>
			<div class="container-bot"></div>