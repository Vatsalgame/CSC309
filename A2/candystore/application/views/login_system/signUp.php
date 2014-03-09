<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | HomePage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>

    	<style>
    		.centered {
    			text-align: center;
    			display: inline;
    		}
    	</style>
</head>
  <body>
	<div class="main-bar">
		<div class="contain-to-grid sticky">
		  <nav class="top-bar" data-topbar>
			  <ul class="title-area">
			    <!-- <li class="name"> -->
			      <!-- <h1><a href="index">CandyStore</a></h1> -->
			      <?php
			      	echo "<li class='name'><h1>" . anchor('candystore/index', 'CandyStore') . "</li><h1>";
			      ?>
			    <!-- </li> -->
			    <li class="toggle-topbar menu-icon"><a href="#"></a></li>
			  </ul>

			  <section class="top-bar-section">
			    
			    <!-- Left Nav Section -->
			    <ul class="left">
			      <li><a href="#">Home/Browse Candies</a></li>
			    </ul>

			    <!-- Right Nav Section -->
			    <ul class="right">
			      <li><a href="#">Shopping Cart</a></li>
			    </ul>
			  </section>
		  </nav>
		</div>
	</div>

	<!-- The data-abide library from Foundation takes care of form validation -->
	<div class="signUp-Form" data-abide>
		<!-- Will be used if signing up failed for some reason -->
		<?php
			if($signUpError != NULL) {
				echo "<div data-alert class='alert-box alert'>" . $signUpError . "</div>";
			}
			foreach($validationErrors as $vError) {
				echo "<div data-alert class='alert-box alert'>" . $vError . "</div>";
			}
		?> 
		<br/>
		<div class="row">
			<form autocomplete="on" action="addNewCustomer" method="post" accept-charset="utf-8">
			<?php 
				// echo form_open('candystore/addNewCustomer');
				// echo form_fieldset('Sign Up');

				// echo "<div class='row'>";
				// 	echo "<div class='large-6 small-6 columns'>";
				// 	echo form_label('First Name');
				// 	echo form_error('firstName');
				// 	echo form_input('firstName', set_value('firstName'), "required");
				// 	echo "</div>";

				// 	echo "<div class='large-6 small-6 columns'>";
				// 	echo form_label('Last Name');
				// 	echo form_error('lastName');
				// 	echo form_input('lastName', set_value('lastName'), "required");
				// 	echo "</div>";
				// echo "</div>";

				// echo "<div class='row'>";
				// 	echo form_label('Login ID');
				// 	echo form_error('username');
				// 	echo form_input('username', set_value('username'), "required");
				// echo "</div>";

				// echo form_label('Password');
				// echo form_error('password');
				// echo form_input('password', set_value('password'), "required");

				// echo form_label('Email');
				// echo form_error('userEmail');
				// echo form_input('userEmail', set_value('userEmail'), "required");

				// if(isset($fileerror))
				// 	echo $fileerror;

				// echo form_submit('submit', 'Sign Up', 'class= "button radius right large-5 small-4 columns"');
				// echo form_fieldset_close();
				// echo form_close();
			?> 
			    <fieldset>
			    	<legend>Sign Up</legend>
				<div class="row">
					<div class="large-6 small-6 columns">
					        <label> First Name
					        	<input type="text" name="firstName" id="firstName" placeholder="First Name" required pattern="[a-zA-Z]+"/>
					        </label>
					        <small class="error"> A valid first name is required for signing up. </small>
					</div>
					<div class="large-6 small-6 columns">
					        <label> Last Name
					        	<input type="text" name="lastName" id="lastName" placeholder="Last Name" required pattern="[a-zA-Z]+"/>
					        </label>
					        <small class="error"> A valid last name is required for signing up. </small>
					</div>
				</div>
				<div class="row">
					<div class="large-12 small-12 columns">
					    <label> Login ID
						<input type="text" name="username" id="username" placeholder="Username" required pattern="[a-zA-Z]+[0-9a-zA-Z]*"/>
					    </label>
					    <small class="error"> Login ID must start with a character and contain only aplha-numerals </small>
					</div>
				</div>
				<div class="row">
					<div class="large-12 small-12 columns">
					    <label> Password
						<input type="password" name="password" id="password" placeholder="Password" required pattern="[a-zA-Z]+[0-9a-zA-Z]*"/>
					    </label>
					    <small class="error"> A valid password (aplha-numeric) is required for signing up. </small>
					</div>
				</div>
				<div class="row">
					<div class="large-12 small-12 columns">
					    <label> Email
						<input type="email" name="userEmail" id="userEmail" placeholder="email@provider.com" required/>
					    </label>
					    <small class="error"> A valid email is required for signing up. </small>
					</div>
				</div>
				<div class="row">
					<!-- <a href="#" class="button radius right large-5 small-4 columns"> Sign Up </a> -->
					<?php
				      		// echo anchor('loginController/addNewCustomer', 'Sign Up', 'class="button radius right large-5 small-4 columns"');
						echo form_submit('submit', 'Sign Up', 'class= "button radius right large-5 small-4 columns"');
				      	?>
				</div>
			    </fieldset>
			<!-- <?php
				echo form_close();
			?> -->
			</form>
		</div>
	</div>

      	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>