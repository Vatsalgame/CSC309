<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | HomePage (Admin)</title>
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
			      	echo "<li class='name'><h1>" . anchor('candystore/index', 'CandyStore') . "<h1></li>";
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
			<ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">
			<li> </li>
			<li>
				<!-- <h2>Product Table</h2> -->
			</li>
			<li> </li>
			</ul>

			<ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">
			<li> </li>
			<li>
				<?php 
					echo "<p>" . anchor('candystore/newForm','Add a new Product', 'class="button middle"') . "</p>";
				?>
			</li>
			<li> </li>
			</ul>
		</div>

		<div class="row"> 
			<!-- Code to display candies in a grid format -->
			<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-3">
			 	<?php
			 		foreach($products as $product) {
			 			echo "<li>";

			 			echo "<img src='" . base_url() . "images/product/" . $product->photo_url . "' width='250px'/> <br>";
			 			echo "Name: " . $product->name . "<br>";
			 			echo "Desc: " . $product->description . "<br>";
			 			echo "Price: " . $product->price . "<br>";

			 			echo "<ul class='small-block-grid-2 medium-block-grid-2 large-block-grid-2'>";
			 			echo "<li>" . anchor("candystore/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</li>";
			 			echo "<li>" . anchor("candystore/editForm/$product->id",'Edit') . "</li>";
			 			// echo "<li>" . anchor("candystore/read/$product->id",'View') . "</li>";
			 			echo "</ul>";

			 			echo "</li>";
			 		}
			 	?>
			</ul>
		</div>

		<div class="row">
			<ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">
			<li> </li>
			<li>
				<?php 
					echo "<p>" . anchor('candystore/newForm','Add a new Product', 'class="button middle"') . "</p>";
				?>
			</li>
			<li> </li>
			</ul>
		</div>
	</div>

      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>