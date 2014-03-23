			<div class="bar">Login</div>
			<div class="container-top"></div>
			<div class="container">
				<div id="signup_container">
					<form id="signup_form" action="<?=site_url("users/signup")?>" method="post">
						<dl><dd><label for="username_tb">Username:</label><input class="input" size="30" name="username" type="text" id="username_tb" value="<?=set_value('username'); ?>" /></dd></dl>
						<?=form_error('username','<div class="small error">','</div>')?>
						<dl><dd><label for="password_tb">Password:</label><input class="input" size="30" name="password" type="password" id="password_tb" /></dd></dl>
						<?=form_error('password','<div class="small error">','</div>')?>
						<dl><dd><label for="confirm_password_tb">Confirm Password:</label><input class="input" size="30" name="confirm_password" type="password" id="confirm_password_tb" /></dd></dl>
						<?=form_error('confirm_password','<div class="small error">','</div>')?>
						<dl><dd><label for="email_tb">Email:</label><input class="input" size="30" name="email" type="text" id="email_tb" value="<?=set_value('email'); ?>" /></dd></dl>
						<?=form_error('email','<div class="small error">','</div>')?>
						<dl><dd><label for="name_tb">Name:</label><input class="input" size="30" name="name" type="text" id="name_tb" value="<?=set_value('name'); ?>" /></dd></dl>
						<?=form_error('name','<div class="small error">','</div>')?>
						<dl><dd><label for="school_tb">School/University</label><input class="input" size="30" name="school" type="text" id="school_tb" value="<?=set_value('school'); ?>" /></dd></dl>
						<dl><dd><input class="input" type="submit" value="Sign me Up!" /></dd></dl>
					</form>
				</div>
			</div>
			<div class="container-bot"></div>