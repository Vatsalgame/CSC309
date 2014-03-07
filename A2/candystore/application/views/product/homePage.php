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
		<h2>Product Table</h2>

		<?php 
			echo "<p>" . anchor('candystore/newForm','Add New') . "</p>";
	 	  
			// echo "<table>";
			// echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
			
			// foreach ($products as $product) {
			// 	echo "<tr>";
			// 	echo "<td>" . $product->name . "</td>";
			// 	echo "<td>" . $product->description . "</td>";
			// 	echo "<td>" . $product->price . "</td>";
			// 	echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
					
			// 	echo "<td>" . anchor("candystore/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			// 	echo "<td>" . anchor("candystore/editForm/$product->id",'Edit') . "</td>";
			// 	echo "<td>" . anchor("candystore/read/$product->id",'View') . "</td>";
					
			// 	echo "</tr>";
			// }
			// echo "<table>";
		?>

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