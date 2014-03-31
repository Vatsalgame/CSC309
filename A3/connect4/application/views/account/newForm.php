
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>Connect4 | Create Account</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
    	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
		<style>
			input {
				display: block;
			}
		</style>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script>
			function checkPassword() {
				var p1 = $("#pass1"); 
				var p2 = $("#pass2");
				
				if (p1.val() == p2.val()) {
					p1.get(0).setCustomValidity("");  // All is well, clear error message
					return true;
				}	
				else	 {
					p1.get(0).setCustomValidity("Passwords do not match");
					return false;
				}
			}
		</script>
	</head> 
<body>

	<div class="row">
		<h1><center>New Account</center></h1>
		<?php 
			echo form_open('account/createNew');

			echo form_fieldset('');
				echo form_label('Username'); 
				echo form_error('username');
				echo form_input('username',set_value('username'),"required");
				echo form_label('Password'); 
				echo form_error('password');
				echo form_password('password','',"id='pass1' required");
				echo form_label('Password Confirmation'); 
				echo form_error('passconf');
				echo form_password('passconf','',"id='pass2' required oninput='checkPassword();'");
				echo form_label('First');
				echo form_error('first');
				echo form_input('first',set_value('first'),"required");
				echo form_label('Last');
				echo form_error('last');
				echo form_input('last',set_value('last'),"required");
				echo form_label('Email');
				echo form_error('email');
				echo form_input('email',set_value('email'),"required");

		?>

		<img id="captcha" src="<?=site_url('account/loadCaptcha')?>" alt="CAPTCHA Image" />

		<?php
			// echo form_label('CaptchaCode');
				echo form_error('captchacode');
				echo form_input('captchacode', set_value(''), "required");

				echo form_submit('submit', 'Register', 'class="button"');
			echo form_fieldset_close();

			echo form_close();
		?>
	</div>	
</body>

</html>

