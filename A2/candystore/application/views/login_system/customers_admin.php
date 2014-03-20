<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | Customers (Admin)</title>
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

			      	echo "<li>" . anchor('ordercontroller/loadOrders', 'Browse Orders') . "</li>";

			      	echo "<li>" . anchor('logincontroller/loadCustomers', 'Browse Customers') . "</li>";
			      ?>
			    </ul>

			    <!-- Right Nav Section -->
			    <ul class="right">
			      <!-- <li><a href="#">Shopping Cart</a></li> -->
			      <li>
			      <?php
			      	if($this->session->userdata('loggedIn')) {
			      		echo "<li> <a href=\"#\"> Welcome, " . $this->session->userdata('username') . "</a></li>";
			      		echo "<li class=\"has-form\">" . anchor('candystore/logOut', 'Logout', 'class="button alert"') . "</li>";
			      	}
			      	// Don't need an else case as only the admin would be redirected to this page (and only after he/she has logged in)

			      ?>
			    </li>
			    </ul>
			  </section>
		  </nav>
		</div>

		<div class="row">
			<!-- Code to display orders in a grid format -->
			<ul class="pricing-table">
			  <li class="title">All Customers</li>
			  <li class="description">Feel free to browse/delete customers</li>

			  <li class="bullet-item">
				  <ul class="small-block-grid-4 medium-block-grid-4 large-block-grid-4">
				  	<li><h6 style="color: SlateGray"> Customer Name </h6></li>
				  	<li><h6 style="color: SlateGray"> Login/Username </h6></li>
				  	<li><h6 style="color: SlateGray"> Email </h6></li>
				  	<li><h6 style="color: SlateGray"> Remove </h6></li>
				  </ul>
			  </li>
			  <?php
			  	foreach($customers as $customer) {
			  		echo "<li class=\"bullet-item\">";

			  		echo "<ul class=\"small-block-grid-4 medium-block-grid-4 large-block-grid-4\">";
			  			echo "<li><h6>" . $customer->first . " " . $customer->last . "</h6></li>";
			  			echo "<li><h6>" . $customer->login . "</h6></li>";
			  			echo "<li><h6>" . $customer->email . "</h6></li>";
			  			echo "<li>" . anchor("logincontroller/deleteCustomer/$customer->id", '&#215;', 'class="button alert"') . " </li>";
			  		echo "</ul>";

			  		echo "</li>";
			  	}


			  ?>

			  <li class="cta-button">
			  	<?php
					echo "<li>" . anchor("logincontroller/deleteAllCustomers", 'Delete all customers', 'class="button alert right"') . " </li>";
			  	?>
			  </li>

			</ul>
		</div>
		
	</div>

      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>