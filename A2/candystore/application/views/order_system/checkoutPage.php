<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | Sign Up</title>
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
			      <!-- <li><a href="#">Home/Browse Candies</a></li> -->
			      <?php
			      	echo "<li>" . anchor('candystore/index', 'Home/Browse Candies') . "</li>";
			      ?>
			    </ul>

			    <!-- Right Nav Section -->
			    <ul class="right">
			      <!-- <li><a href="#">Shopping Cart</a></li> -->

			      <li>
			      <?php
			      	// if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
			      	// 	echo "<li> <a href=\"#\"> Welcome, " . $_SESSION['username'] . "</a></li>";
			      	// 	echo "<li class=\"has-form\">" . anchor('candystore/logOut', 'Logout', 'class="button alert"') . "</li>";
			      	// }
			      	if($this->session->userdata('loggedIn')) {
			      		echo "<li> <a href=\"#\"> Welcome, " . $this->session->userdata('username') . "</a></li>";
			      		echo "<li class=\"has-form\">" . anchor('candystore/logOut', 'Logout', 'class="button alert"') . "</li>";
			      	}

			      	else {
			      		echo form_open_multipart('candystore/logIn');

			      		echo " <li class=\"has-form\">
		      					<input type=\"text\" placeholder=\"Username\" name=\"username\" id=\"username\">
			      			</li>";
			     		echo " <li class=\"has-form\">
		      					<input type=\"password\" placeholder=\"Password\" name=\"password\" id=\"password\">
			      			</li>";
			      		
			      		echo "<li class=\"has-form\"> " . form_submit('submit', 'Sign In', 'class= "button success"'); "</li>";
			      		// echo " <li class=\"divider\"></li>";
			      		echo "<li class='has-form'>" . anchor('logincontroller/index', 'Sign Up', 'class="button"') . "</li>";
			      	}

			      ?>
			    </li>
			  </section>
		  </nav>
		</div>
	</div>

	<!-- The data-abide library from Foundation takes care of form validation -->
	<div class="checkout-Form" data-abide>
		
	</div>

      	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>