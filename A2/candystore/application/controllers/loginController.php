<?php
class LoginController extends CI_Controller {
   
     
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
   	$this->load->model('customer_model');
	// $data = array('success' => "");
	$data['signUpError'] = NULL;
	$data['validationErrors'] = [];
	$this->load->view('login_system/signUp', $data);
	// $this->load->view('login_system/signUpPage.php', $data);
    }
    
    function addNewCustomer()  {
    	// Pre-validation is already performed using a library from Foundation

    	$this->load->model('customer_model');
	$this->load->model('customer');

    	$this->load->library('form_validation');
	$this->form_validation->set_rules('firstName','First Name','required|min_length[2]|max_length[24]|alpha');
	$this->form_validation->set_rules('lastName','Last Name','required|min_length[2]|max_length[24]|alpha');
	$this->form_validation->set_rules('username','Username','required|min_length[2]|max_length[16]|alpha-dash|is_unique[customer.login]');
	$this->form_validation->set_rules('password','Password','required|min_length[2]|max_length[16]|alpha_numeric');
	$this->form_validation->set_rules('userEmail','Email','required|min_length[6]|max_length[45]|valid_email|is_unique[customer.email]');

	if ($this->form_validation->run() == true) {
		$customer = new Customer();
		$customer->first = $this->input->get_post('firstName');
		$customer->last = $this->input->get_post('lastName');
		$customer->login = $this->input->get_post('username');
		$customer->password = $this->input->get_post('password');
		$customer->email = $this->input->get_post('userEmail');

		$this->customer_model->insert($customer);
		//Then we redirect to the index page again
		// redirect('/loginController/index', 'refresh');	
		
		// redirecting indirectly
		$this->load->model('product_model');
		$products = $this->product_model->getAll();
		$data['products']=$products;
		$data['signedUp'] = True;
		$this->load->view('product/homePage.php', $data);
	}
	else {
		$data['signUpError'] = "We're sorry as we couldn't sign you up. Kindly Try again :)";
 		$data['validationErrors'] = array();
 		$this->load->view('login_system/signUp.php', $data);
		// $this->load->view('login_system/signUpPage.php', $data);
	}
    }
}
