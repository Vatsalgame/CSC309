
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>Connect4 | Login</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
    	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>

    	<style>
			input {
				display: block;
			}
		</style>
</head>
<body>  
	<div class="row">
		<h1><center>Login</center></h1>

		<?php 
			if (isset($errorMsg)) {
				echo "<p>" . $errorMsg . "</p>";
			}


			echo form_open('account/login');

			echo form_fieldset('');

				echo form_label('Username'); 
				echo form_error('username');
				echo form_input('username',set_value('username'),"required");
				echo form_label('Password'); 
				echo form_error('password');
				echo form_password('password','',"required");
				
				echo form_submit('submit', 'Login', 'class="button success right"');

				echo form_fieldset_close();
				
				echo anchor('account/newForm','Create Account', 'class="button"');
				echo "     ";
				echo anchor('account/recoverPasswordForm','Recover Password', 'class="button alert"');
			echo form_fieldset_close();
			
			
			echo form_close();
		?>	
	</div>
</body>

</html>

