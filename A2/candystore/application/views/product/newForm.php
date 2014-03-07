	

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
		<h2>New Product</h2>

		<style>
			input { display: block;}
			
		</style>

		<?php 
			echo "<p>" . anchor('candystore/index','Back') . "</p>";
			
			echo form_open_multipart('candystore/create');
				
			echo form_label('Name'); 
			echo form_error('name');
			echo form_input('name',set_value('name'),"required");

			echo form_label('Description');
			echo form_error('description');
			echo form_input('description',set_value('description'),"required");
			
			echo form_label('Price');
			echo form_error('price');
			echo form_input('price',set_value('price'),"required");
			
			echo form_label('Photo');
			
			if(isset($fileerror))
				echo $fileerror;	
		?>	
			<input type="file" name="userfile" size="20" />
			
		<?php 	
			
			echo form_submit('submit', 'Create');
			echo form_close();
		?>
	</div>

      	<script src="<?php echo base_url("js/jquery.js"); ?>"></script>
      	<script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
      	<script>
      	 	$(document).foundation();
        	</script>
  </body>