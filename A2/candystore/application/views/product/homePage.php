<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | HomePage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
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
			      <li><a href="#">Home/Browse Candies</a></li>
			    </ul>

			    <!-- Right Nav Section -->
			    <ul class="right">
			      <li><a href="#">Shopping Cart</a></li>
			      <li class="divider"></li>
			      <li class="has-form">
		      		<input type="text" placeholder="Username">
			      </li>
			      <li class="has-form">
		      		<input type="text" placeholder="Password">
			      </li>
			      <li class="has-form">
		      		<a href="#" class="button success">Sign In</a>
			      </li>
			      <li class="divider"></li>
			      <!-- <li class="has-form">
		      		<a href="#" class="button">Sign Up</a>
			      </li> -->
			      <!-- The first argument of anchor takes the path to the controller function -->
			      <?php
			      	echo "<li class='has-form'>" . anchor('candystore/signUp', 'Sign Up', 'class="button"') . "</li>";
			      ?>
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

      	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>