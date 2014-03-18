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
			      <li><a href="#" data-dropdown="cart-hover" data-options="is_hover:true">Shopping Cart</a></li>
			      	<div id="cart">
				<ul id="cart-hover" class="medium content f-dropdown" data-dropdown-content>
				  <!-- <li>Item 1</li>
				  <br/>
				  <li>Item 2</li>
				  <br/>
				  <li>Item 3</li> -->
				  <ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">
				  	<li><h6 style="color: SlateGray"> Candy </h6></li>
				  	<li><h6 style="color: SlateGray"> Quantity </h6></li>
				  	<li><h6 style="color: SlateGray"> Price </h6></li>
				  </ul>
				  <!-- <br/> -->
				<?php
				   	$sum_amt = 0;
				   	$sum_qty = 0;
				  	// foreach ($_SESSION['cart'] as $product) {
				   	foreach ($this->session->userdata('cart') as $product) {
				   		$cur_sum_amt = $product['qty'] * $product['price'];
				   		$sum_amt = $sum_amt + $cur_sum_amt;
				  		$sum_qty = $sum_qty + ($product['qty']);

				  		echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
				  			echo "<li>" . $product['name'] . "</li>";
				  			echo "<li>" . $product['qty'] . "</li>";
				  			echo "<li>$" . $cur_sum_amt . " @ $" . $product['price'] . " each</li>";
				  		echo "</ul>";

				  		// echo "<li>" . $product['name'] . " " . $product['qty'] . " @ $" . $product['price'] . "</li>";
				  		// echo "<br/>";
				  	}

				  	echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
				  		echo "<li><h6 style=\"color: SlateGray\"> Total </h6></li>";
				  		echo "<li><h6 style=\"color: SlateGray\">" . $sum_qty . "</h6></li>";
				  		echo "<li><h6 style=\"color: SlateGray\">$" . $sum_amt . "</h6></li>";
				  	echo "</ul>";

				  	// if(!empty($_SESSION['cart'])) {
				  	if($this->session->userdata('cart')) {
				  		echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
				  		echo "<li></li>";
				  		echo "<li></li>";
				  		echo "<li class='has-form'>" . anchor('ordercontroller/index', 'Checkout', 'class="button"') . "</li>";
				  		echo "</ul>";
				  	}
				  ?>
				</ul>
				</div>
			      <li class="divider"></li>
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
		      			// echo form_error('username');
			     		echo " <li class=\"has-form\">
		      					<input type=\"password\" placeholder=\"Password\" name=\"password\" id=\"password\">
			      			</li>";
			      		// echo form_error('password');
			      		// echo " <li class=\"has-form\">" . anchor('candystore/logIn', 'Sign In', 'class="button success"') . "</li>";
			      		// echo "<li class=\"has-form\"> 
			      		// 		<input type=\"submit\" class=\"button success\" value=\"Sign In\"> </li>";
			      		echo "<li class=\"has-form\"> " . form_submit('submit', 'Sign In', 'class= "button success"'); "</li>";
			      		// echo " <li class=\"divider\"></li>";
			      		echo "<li class='has-form'>" . anchor('logincontroller/index', 'Sign Up', 'class="button"') . "</li>";
			      		echo form_close();
			      	}

			      ?>
			    </li>

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
<!-- 
		<?php 
			echo "<p>" . anchor('candystore/newForm','Add New') . "</p>";
		?> -->

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
		<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-3">
		 	<?php
		 		// echo "<div id=\"alterButtons\">";
		 		foreach($products as $product) {
		 			echo "<li>";

		 			echo "<div class=\"row large-6 small-6 columns\">";
		 			echo "<img align\"middle\" src='" . base_url() . "images/product/" . $product->photo_url . "' width='250px' height='150px'/>";
		 			echo "</div>";

		 			echo "<div class=\"row large-6 small-6 columns\">";
		 			echo "Name: " . $product->name . "<br>";
		 			echo "Desc: " . $product->description . "<br>";
		 			echo "Price: $" . $product->price . "<br>";
		 			echo "</div>";

		 			// echo "<div id=\"alterButtons\">";
		 			echo "<ul class='small-block-grid-3 medium-block-grid-3 large-block-grid-3'>";
		 			echo "<li>" . anchor("candystore/addItem/$product->id",'Add to Cart', 'id="addItem" class="tiny button success round"') . "</li>";
		 			// echo "<li><button class=\"addItem small button success round\" value=\"" . $product->id .  "\">Add to Cart</button></li>";

		 			// (Idea) Make this pop-up a modal to view the details
		 			// echo "<li>" . anchor("candystore/read/$product->id",'View') . "</li>";
		 			// if(array_key_exists($product->id, $_SESSION['cart'])) {
		 			if(array_key_exists($product->id, $this->session->userdata('cart'))) {
		 				echo "<li>" . anchor("candystore/removeItem/$product->id",'Remove from Cart', 'id="removeItem" class="tiny button alert round"') . "</li>";
		 				// echo "<li><button class=\"removeItem small button alert round\" value=\"" . $product->id .  "\">Remove from Cart</button></li>";
		 				// echo "<li> Qty: " . $_SESSION['cart'][$product->id]['qty'] . "</li>"; 
		 				$data = $this->session->userdata('cart');
		 				echo "<li> Qty: " . $data[$product->id]['qty'] . "</li>"; 
		 			}
		 			else {
		 				echo "<li></li>";
		 				echo "<li> Qty: 0</li>"; 
		 			}
		 			echo "</ul>";
		 			// echo "</div>";

		 			echo "</li>";
		 		}
		 		// echo "</div>";
		 	?>
		</ul>
	</div>


	<!-- To close the sign up pop-up -->
	<script>
		$('#signedUpClose').click(function() {
			$('#myModal').foundation('reveal', 'close');
			// $('#myModal').foundation('reveal', 'open');
		});
		// $('button.addItem').click(function() {
		// 	// e.preventDefault();
		// 	$.ajax({
		// 	    type: 'post',
		// 	    url: 'candystore/addItem/' + $(this).attr("value"),
		// 	    dataType: 'html',
		// 	    success: function () {
		// 	      // success callback -- replace the div's innerHTML with
		// 	      // the response from the server.
		// 	      // $('#cart').html(html);
		// 	      $('#cart').load('candystore/index #cart');
		// 	      $('#alterButtons').load('candystore/index #alterButtons');
		// 	      // $('#candies').load('candystore/index #candies');
		// 	    }
		// 	  });
		// });
		// $('button.removeItem').click(function() {
		// 	// e.preventDefault();
		// 	$.ajax({
		// 	    type: 'post',
		// 	    url: 'candystore/removeItem/' + $(this).attr("value"),
		// 	    dataType: 'html',
		// 	    success: function () {
		// 	      // success callback -- replace the div's innerHTML with
		// 	      // the response from the server.
		// 	      // $('#cart').html(html);
		// 	      $('#cart').load('candystore/index #cart');
		// 	      // $('#candies').load('candystore/index #candies');
		// 	    }
		// 	  });
		// });
	</script>

	<!-- To update the cart -->

      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>