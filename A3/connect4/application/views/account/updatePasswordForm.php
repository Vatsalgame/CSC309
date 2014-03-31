
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>Connect4 | Update Password</title>
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
		<h1><center>Change Password</center></h1>
		<?php 
			if (isset($errorMsg)) {
				echo "<p>" . $errorMsg . "</p>";
			}

			echo form_open('account/updatePassword');

			echo form_fieldset('');
				echo form_label('Current Password'); 
				echo form_error('oldPassword');
				echo form_password('oldPassword',set_value('oldPassword'),"required");
				echo form_label('New Password'); 
				echo form_error('newPassword');
				echo form_password('newPassword','',"id='pass1' required");
				echo form_label('Password Confirmation'); 
				echo form_error('passconf');
				echo form_password('passconf','',"id='pass2' required oninput='checkPassword();'");
				echo form_submit('submit', 'Change Password', 'class="button success"');
			echo form_fieldset_close();

			echo form_close();
		?>	
	</div>
</body>

</html>

