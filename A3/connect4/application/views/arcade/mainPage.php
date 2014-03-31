
<!DOCTYPE html>

<html>
	
	<head>

	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>Connect4 | MainPage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
    	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>
		$(function(){
			$('#availableUsers').everyTime(500,function(){
					$('#availableUsers').load('<?= base_url() ?>arcade/getAvailableUsers');

					$.getJSON('<?= base_url() ?>arcade/getInvitation',function(data, text, jqZHR){
							if (data && data.invited) {
								var user=data.login;
								var time=data.time;
								if(confirm('Play ' + user)) 
									$.getJSON('<?= base_url() ?>arcade/acceptInvitation',function(data, text, jqZHR){
										if (data && data.status == 'success')
											window.location.href = '<?= base_url() ?>board/index'
									});
								else  
									$.post("<?= base_url() ?>arcade/declineInvitation");
							}
						});
				});
			});
	
	</script>
	</head> 
<body>
	<div class="row">
		<h1><center>Connect 4</center></h1>

		<div>
			<div>
				<h4> Hello <?= $user->fullName() ?> </h4>
			</div> 
			<?= anchor('account/logout','Logout', 'class="button alert"') ?>  
			<?= anchor('account/updatePasswordForm','Change Password', 'class="button"') ?>

			<?php 
				if (isset($errmsg)) 
					echo "<p>$errmsg</p>";
			?>
		</div>
	
	<div>
		<h2>Available Users</h2>
		<div id="availableUsers">
		</div>
	</div>

	</div>
</body>

</html>

