 <?php

class LoginController extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    		    	
	    	// $this->load->library('upload', $config);
	    	
    }

   function index() {
	$this->load->model('product_model');
	$products = $this->product_model->getAll();
	$data['products']=$products;
	// $this->load->view('product/list.php',$data);
	$this->load->view('product/homePage.php', $data);
    }
    
    function addNewCustomer()  {
    	// Basic validation is already performed using a library from Foundation
    	
    	$this->load->library('form_validation');
	$this->form_validation->set_rules('firstName','First Name','required|min_length[2]|max_length[24]|alpha');
	$this->form_validation->set_rules('lastName','Last Name','required|min_length[2]|max_length[24]|alpha');
	$this->form_validation->set_rules('username','Username','required|min_length[2]|max_length[16]|alpha-dash|is_unique[customer.login]');
	$this->form_validation->set_rules('password','Password','required|min_length[2]|max_length[16]|alpha_numeric');
	$this->form_validation->set_rules('userEmail','Email','required|min_length[6]|max_length[45]|valid_email|is_unique[customer.email]');

	if ($this->form_validation->run() == true) {
		$this->load->model('customer_model');

		// Initialize a customer object and collect the info from the input fields
		$customer = new Customer();
		$customer->firstName = $this->input->get_post('firstName');
		$customer->lastName = $this->input->get_post('lastName');
		$customer->username = $this->input->get_post('username');
		$customer->password = $this->input->get_post('password');
		$customer->email = $this->input->get_post('userEmail');

		$this->customer_model->insert($customer);
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');	
	}
	else {
		$data['signUpError'] = "We're sorry as we couldn't sign you up. Kindly Try again :)";
 		$data['validationErrors'] = validation_errors();
		$this->load->view('login_system/signUp.php', $data);
	}
    }
}

