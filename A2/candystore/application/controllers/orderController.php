 <?php

class OrderController extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	// session_start();
	    	
	    	// $config['upload_path'] = './images/product/';
	    	// $config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    		    	
	    	// $this->load->library('upload', $config);
	    	
    }

   function index() {
	// $data = array('success' => "");
	$this->load->view('order_system/checkoutPage');
    }
}