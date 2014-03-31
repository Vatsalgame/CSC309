
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
		<style>
			input {
				display: block;
			}
		</style>

	</head> 
<body>
	<div class="row">  
		<h1><center>Password Recovery<center></h1>
	
		<p>Please check your email for your new password.
		</p>
	
	
	
		<?php 
			if (isset($errorMsg)) {
				echo "<p>" . $errorMsg . "</p>";
			}

			echo "<p>" . anchor('account/index','Login', 'class="button"') . "</p>";
		?>
	</div>	
</body>

</html>

