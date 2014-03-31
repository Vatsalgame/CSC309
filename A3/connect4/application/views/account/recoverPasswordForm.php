
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>Connect4 | Password Recovery</title>
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
		<h1><center>Recover Password</center></h1>
		<?php 
			if (isset($errorMsg)) {
				echo "<p>" . $errorMsg . "</p>";
			}

			echo form_open('account/recoverPassword');

			echo form_fieldset('');
				echo form_label('Email'); 
				echo form_error('email');
				echo form_input('email',set_value('email'),"required");
				echo form_submit('submit', 'Recover Password', 'class="button alert"');
			echo form_fieldset_close();

			echo form_close();
		?>
	</div>
</body>

</html>

