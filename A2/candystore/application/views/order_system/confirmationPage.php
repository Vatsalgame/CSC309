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
			      	echo "<li class='name'><h1>" . anchor('ordercontroller/goHome', 'CandyStore') . "</li><h1>";
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
			  </section>
		  </nav>
		</div>
	</div>

	<div class="row">
		<ul class="pricing-table">
		  <li class="title">Your Receipt</li>
		  <li class="description">Kindly print/email the receipt for your record keeping</li>

		  <li class="bullet-item">
			  <ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">
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
			  		echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
			  			echo "<li>" . $product['name'] . "</li>";

			  			echo "<li>" . $product['qty'] . "</li>";
			  			// echo form_error("$id");

			  			echo "<li>$" . $cur_sum_amt . " @ $" . $product['price'] . " each</li>";
			  		echo "</ul>";
		  		echo "</li>";

		  		

		  		// echo "<li>" . $product['name'] . " " . $product['qty'] . " @ $" . $product['price'] . "</li>";
		  		// echo "<br/>";
		  	}

		  	echo "<li class=\"bullet-item\">";
		  	echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
		  		echo "<li><h6 style=\"color: SlateGray\"> Total </h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">" . $sum_qty . "</h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">$" . $sum_amt . "</h6></li>";
		  	echo "</ul>";
		  	echo "</li>";

		  	echo "<li class=\"bullet-item\">";
		  	echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
		  		echo "<li><h6 style=\"color: SlateGray\"> Credit Card Number </h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">" . $creditcardnumber. "</h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\"> Valid </h6></li>";
		  	echo "</ul>";
		  	echo "</li>";

		  	echo "<li class=\"bullet-item\">";
		  	echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
		  		echo "<li><h6 style=\"color: SlateGray\"> Credit Card (Valid Until) </h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">" . $creditcarddetails. "</h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\"> Valid </h6></li>";
		  	echo "</ul>";
		  	echo "</li>";

		  	echo "<li class=\"bullet-item\">";
		  	echo "<ul class=\"small-block-grid-3 medium-block-grid-3 large-block-grid-3\">";
		  		echo "<li><h6 style=\"color: SlateGray\"> Order Date & Time </h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">" . $orderDate . "</h6></li>";
		  		echo "<li><h6 style=\"color: SlateGray\">" . $orderTime . "</h6></li>";
		  	echo "</ul>";
		  	echo "</li>";

		  	echo "<li class=\"cta-button\"> <a href=\"#\" onclick=\"window.print(); return false;\" class=\"button success\"> Print Receipt </a> </li>";
		  ?>

		</ul>
		
	</div>



      	<script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>