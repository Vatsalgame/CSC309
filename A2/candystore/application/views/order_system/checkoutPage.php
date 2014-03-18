<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | Sign Up</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>

    	<style>
    		.right {
    			text-align: right;
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
			      		echo form_open_multipart('ordercontroller/logIn');

			      		echo " <li class=\"has-form\">
		      					<input type=\"text\" placeholder=\"Username\" name=\"username\" id=\"username\">
			      			</li>";
			     		echo " <li class=\"has-form\">
		      					<input type=\"password\" placeholder=\"Password\" name=\"password\" id=\"password\">
			      			</li>";

			      		echo "<li class=\"has-form\"> " . form_submit('submit', 'Sign In', 'class= "button success"'); "</li>";
			      		// echo " <li class=\"divider\"></li>";
			      		echo "<li class='has-form'>" . anchor('logincontroller/index', 'Sign Up', 'class="button"') . "</li>";
			      		echo form_close();
			      	}

			      ?>
			    </li>
			  </section>
		  </nav>
		</div>
	</div>

	<!-- The data-abide library from Foundation takes care of form validation -->
	<div class="checkout-Form" align="center" data-abide>
		<div class="row">
		<?php
			// echo form_open_multipart("ordercontroller/updateOrderItem");
			if(!$this->session->userdata('loggedIn')) {
				echo "<div data-alert class='alert-box alert'> Kindly log in to checkout</div>";
			}
		?>

		<ul class="pricing-table">
		  <li class="title">Review Your Order</li>
		  <li class="description">Kindly alter/confirm the order</li>
	<!-- 	  <li class="bullet-item">1 Database</li>
		  <li class="bullet-item">5GB Storage</li>
		  <li class="bullet-item">20 Users</li> -->

		  <li class="bullet-item">
			  <ul class="small-block-grid-4 medium-block-grid-4 large-block-grid-4">
			  	<li><h6 style="color: SlateGray"> Candy </h6></li>
			  	<li><h6 style="color: SlateGray"> Quantity </h6></li>
			  	<li><h6 style="color: SlateGray"> Price </h6></li>
			  </ul>
		  </li>

		  <?php
		  	$sum_amt = 0;
		   	$sum_qty = 0;

		   	foreach ($this->session->userdata('cart') as $id => $product) {
		   		$cur_sum_amt = $product['qty'] * $product['price'];
		   		$sum_amt = $sum_amt + $cur_sum_amt;
		  		$sum_qty = $sum_qty + ($product['qty']);

		  		echo "<li class=\"bullet-item\">";
			  		echo "<ul class=\"small-block-grid-4 medium-block-grid-4 large-block-grid-4\">";
			  			echo "<li>" . $product['name'] . "</li>";

			  			echo "<li>
			  				<div class=\"qty\">
			  				<input type=\"text\" class=\"right\" name=\"$id\" id=\"$id\" required pattern=\"[0-9]+\" value=\"" . $product['qty'] . 
			  				"\"/><small class=\"error\"> Quantity must be a number </small>
			  				</div>
			  				</li>";
			  			// echo form_error("$id");

			  			echo "<li>$" . $cur_sum_amt . " @ $" . $product['price'] . " each</li>";
			  			echo "<li>" . anchor("ordercontroller/deleteOrderItem/$id", '&#215;', 'class="button alert"') . " </li>";
			  		echo "</ul>";
		  		echo "</li>";

		  		

		  		// echo "<li>" . $product['name'] . " " . $product['qty'] . " @ $" . $product['price'] . "</li>";
		  		// echo "<br/>";
		  	}

		  	echo "<li class=\"bullet-item\">";
		  	echo "<ul class=\"small-block-grid-4 medium-block-grid-4 large-block-grid-4\">";
		  		echo "<li><h6 style=\"color: SlateGray\"> Total </h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">" . $sum_qty . "</h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">$" . $sum_amt . "</h6></li>";
		  		$this->session->set_userdata('totalSum', $sum_amt);
		  	echo "</ul>";
		  	echo "</li>";

		  	echo "<li class=\"cta-button\">" . anchor("ordercontroller/moveToPayment", 'Buy Now', 'class=button') . "</li>";
		  ?>

		   <!-- <li class="cta-button"><a class="button" href="#">Buy Now</a></li> -->
		</ul>
	<!-- 	<?php
			echo form_submit('submit', 'Update', 'class= "button success"') ;
			echo form_close();
		?> -->
		</div>
	</div>

      	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>