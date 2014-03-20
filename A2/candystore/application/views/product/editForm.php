<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | Edit Product</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/modernizr.js"); ?>"></script>
</head>
  <body>
	<div class="main-section">

		<style>
			input { display: block;}
			
		</style>

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
			<h2>Edit Product</h2>
		</div>

		<div class="row">
			<?php 
				echo "<p>" . anchor('candystore/index','Back') . "</p>";
				
				echo form_open("candystore/update/$product->id");
				
				echo form_label('Name'); 
				echo form_error('name');
				echo form_input('name',$product->name,"required");

				echo form_label('Description');
				echo form_error('description');
				echo form_input('description',$product->description,"required");
				
				echo form_label('Price');
				echo form_error('price');
				echo form_input('price',$product->price,"required");
				
				echo form_submit('submit', 'Save', 'class="button success right"');
				echo form_close();
			?>
		</div>	
	</div>

      	<script src="<?php echo base_url("js/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>