<!DOCTYPE html>
<head>
  	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>CandyStore | HomePage</title>
    	<link rel="stylesheet" href="<?php echo base_url("css/foundation.min.css"); ?>" />
    	<script src="<?php echo base_url("js/vendor/modernizr.js"); ?>"></script>
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
                          <li><a href="#">Home/Browse Candies</a></li>
                        </ul>

                        <!-- Right Nav Section -->
                        <ul class="right">
                          <li><a href="#">Shopping Cart</a></li>
                        </ul>
                      </section>
                  </nav>
                </div>
            </div>
            <div class="signUp-Form">
                <?php
                    if($signUpError != NULL) {
                        echo "<div data-alert class='alert-box alert'>" . $signUpError . "</div>";
                    }
                    foreach($validationErrors as $vError) {
                        echo "<div data-alert class='alert-box alert'>" . $vError . "</div>";
                    }
                ?> 


                <?php 
                    echo form_open_multipart('logincontroller/addNewCustomer');
                    echo form_fieldset('Sign Up');

                    echo "<div class='row'>";
                    echo "<div class='large-6 small-6 columns'>";
                        echo form_label('First Name');
                        echo form_error('firstName');
                        echo form_input('firstName', set_value('firstName'), "required");
                    echo "</div>";

                    echo "<div class='large-6 small-6 columns'>";
                        echo form_label('Last Name');
                        echo form_error('lastName');
                        echo form_input('lastName', set_value('lastName'), "required");
                    echo "</div>";
                    echo "</div>";

                    echo "<div class='row large-12 small-12 columns'>";
                        echo form_label('Login ID');
                        echo form_error('username');
                        echo form_input('username', set_value('username'), "required");
                    echo "</div>";

                    echo "<div class='row large-12 small-12 columns'>";
                        echo form_label('Password');
                        echo form_error('password');
                        echo form_password('password', set_value('password'), "required");
                    echo "</div>";

                    echo "<div class='row large-12 small-12 columns'>";
                        echo form_label('Email');
                        echo form_error('userEmail');
                        echo form_input('userEmail', set_value('userEmail'), "required");
                    echo "</div>";

                    // if(isset($fileerror))
                    //  echo $fileerror;
                    echo "<div class='row'>";
                        echo form_submit('submit', 'Sign Up', 'class= "button radius right large-5 small-4 columns"');
                    echo "</div>";
                    echo form_fieldset_close();
                ?> 
                <?php
                    // echo form_submit('submit', 'SignUp', 'class= "button radius right large-5 small-4 columns"');
                    echo form_close();
                ?>
            </div>


            <script src="<?php echo base_url("js/vendor/jquery.js"); ?>"></script>
            <script src="<?php echo base_url("js/foundation.min.js"); ?>"></script>
            <script>
                $(document).foundation();
            </script>
  </body>