<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | HomePage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
    	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
</head>
  <body>
	<div class="main-section">
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
			      <li><a href="#" data-dropdown="hover1" data-options="is_hover:true">Shopping Cart</a></li>

				<ul id="hover1" class="large f-dropdown" data-dropdown-content>
				  <li><a href="#">This is a link</a></li>
				  <br/>
				  <li><a href="#">This is another</a></li>
				  <li><a href="#">Yet another</a></li>
				</ul>
			      <li class="divider"></li>

			      <?php
			      	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
			      		echo "<li> <a href=\"#\"> Welcome, " . $_SESSION['username'] . "</a></li>";
			      		echo "<li class=\"has-form\">" . anchor('candystore/logOut', 'Logout', 'class="button alert"') . "</li>";
			      	}

			      	else {
			      		echo form_open_multipart('candystore/logIn');

			      		echo " <li class=\"has-form\">
		      					<input type=\"text\" placeholder=\"Username\" name=\"username\" id=\"username\">
			      			</li>";
		      			// echo form_error('username');
			     		echo " <li class=\"has-form\">
		      					<input type=\"password\" placeholder=\"Password\" name=\"password\" id=\"password\">
			      			</li>";
			      		// echo form_error('password');
			      		// echo " <li class=\"has-form\">" . anchor('candystore/logIn', 'Sign In', 'class="button success"') . "</li>";
			      		// echo "<li class=\"has-form\"> 
			      		// 		<input type=\"submit\" class=\"button success\" value=\"Sign In\"> </li>";
			      		echo "<li class=\"has-form\"> " . form_submit('submit', 'Sign In', 'class= "button success"'); "</li>";
			      		echo " <li class=\"divider\"></li>";
			      		echo "<li class='has-form'>" . anchor('logincontroller/index', 'Sign Up', 'class="button"') . "</li>";
			      	}

			      ?>

			  <!--     <li class="has-form">
		      		<input type="text" placeholder="Username" name="username" id="username">
			      </li>
			      <li class="has-form">
		      		<input type="text" placeholder="Password" name="password" id="password">
			      </li>
			      <li class="has-form">
		      		<a href="#" class="button success">Sign In</a>
			      </li>
			      <li class="divider"></li> -->
			      <!-- <li class="has-form">
		      		<a href="#" class="button">Sign Up</a>
			      </li> -->
			      <!-- The first argument of anchor takes the path to the controller function -->
			<!--       <?php
			      	// echo "<li class='has-form'>" . anchor('logincontroller/index', 'Sign Up', 'class="button"') . "</li>";
			      ?> -->
			    </ul>
			  </section>
		  </nav>
		</div>

		<h2>Product Table</h2>

		<?php 
			echo "<p>" . anchor('candystore/newForm','Add New') . "</p>";
		?>

	<!-- 	<?php 
			echo "<p>" . anchor('candystore/signUp', 'Sign Up') . "</p>";
		?> -->

		<!-- The sign up pop-up -->
		<div id="myModal" class="reveal-modal" data-reveal>
		  <h3>Awesome! You've successfully signed up for CandyStore.</h3>
		  <p class="lead">You're a platinum member now</p>
		  <p>Being a platinum member, you are not only allowed to look at candy, but also buy as much as you want.</p>
		  <div class="closeButton">
		  	<a class="button left" id="signedUpClose"> Gotcha! </a>
		  </div>
		  <a class="close-reveal-modal">&#215;</a>
		</div>

		<?php
			if(defined($signedUp)) {
				if($signedUp) {
					echo "<script> alert(\"Thank you for signing up! \"); </script>";
					// echo "<script> $('#myModal').foundation('reveal', 'open'); </script>";
				}
			}
		?>
		
		<!-- Hidden link to open the model -->
		<a href="#" data-reveal-id="myModal" id="modelLink" data-reveal class="button checking">Click Me For A Modal</a> 

		<!-- Code to display candies in a grid format -->
		<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
		 	<?php
		 		foreach($products as $product) {
		 			echo "<li>";

		 			echo "<img src='" . base_url() . "images/product/" . $product->photo_url . "' width='250px'/> <br>";
		 			echo "Name: " . $product->name . "<br>";
		 			echo "Desc: " . $product->description . "<br>";
		 			echo "Price: " . $product->price . "<br>";

		 			echo "<ul class='small-block-grid-3 medium-block-grid-3 large-block-grid-3'>";
		 			echo "<li>" . anchor("candystore/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</li>";
		 			echo "<li>" . anchor("candystore/editForm/$product->id",'Edit') . "</li>";
		 			echo "<li>" . anchor("candystore/read/$product->id",'View') . "</li>";
		 			echo "</ul>";

		 			echo "</li>";
		 		}
		 	?>
		</ul>
	</div>


	<!-- To close the sign up pop-up -->
	<script>
		// $('#modelLink').click(function() {
			// alert("Hello");
		// 	$('#myModal').foundation('reveal', 'open');
		// });

		// $("a.checking").trigger("click");

		$('#signedUpClose').click(function() {
			$('#myModal').foundation('reveal', 'close');
			// $('#myModal').foundation('reveal', 'open');
		});
	</script>

      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>