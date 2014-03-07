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
		<h2>Edit Product</h2>

		<style>
			input { display: block;}
			
		</style>

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
			
			echo form_submit('submit', 'Save');
			echo form_close();
		?>	
	</div>

      	<script src="<?php echo base_url("js/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>