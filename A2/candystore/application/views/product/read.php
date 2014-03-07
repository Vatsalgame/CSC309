<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | HomePage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/modernizr.js"); ?>"></script>
</head>
  <body>
	<div class="main-section">
		<h2>Product Entry</h2>
		<?php 
			echo "<p>" . anchor('candystore/index','Back') . "</p>";

			echo "<p> ID = " . $product->id . "</p>";
			echo "<p> NAME = " . $product->name . "</p>";
			echo "<p> Description = " . $product->description . "</p>";
			echo "<p> Price = " . $product->price . "</p>";
			echo "<p><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
				
		?>	
	</div>

      	<script src="<?php echo base_url("js/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>