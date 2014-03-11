<?php

class CandyStore extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    		    	
	    	$this->load->library('upload', $config);
	    	
    }

    function index() {
    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;
    		
    		// Would be used to create a pop-up if a customer just signed up
    		$data['signedUp'] = False;
    		// Used for displaying login properly
    		$data['loggedIn'] = False;
    		$data['username'] = NULL;
    		// Used if login fails
    		$data['loginFailed'] = False;

    		// $this->load->view('product/list.php',$data);
    		$this->load->view('product/homePage.php', $data);
    }
    
    function newForm() {
	    	$this->load->view('product/newForm.php');
    }
    
	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}

	function signUp() {
		// $this->load->model('product_model');
		$data['signUpError'] = NULL;
		$data['validationErrors'] = [];
		// $this->load->view('login_system/signUp.php', $data);
		$this->load->view('login_system/signUpPage.php', $data);
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
    	
	function delete($id) {
		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');
	}

	// Function to log in a customer/admin
	function logIn() {
		$this->load->model('customer_model');
		$this->load->model('customer');

		$customer = new Customer();
		$customer->login = $this->input->get_post('username');
		$customer->password = $this->input->get_post('password');

		$loggedIn_customer = $this->customer_model->getLogin($customer->login, $customer->password);
		// Checking if the login was successful
		if($loggedIn_customer) {
			$data['loggedIn'] = True;
			$data['username'] = $loggedIn_customer->first + $loggedIn_customer->last;
			
			$this->load->model('product_model');
    			$products = $this->product_model->getAll();
    			$data['products']=$products;
    			$this->load->view('product/homePage.php', $data);
		}
		else {
			$data['loginFailed'] = True;

			$this->load->model('product_model');
    			$products = $this->product_model->getAll();
    			$data['products']=$products;
    			$this->load->view('product/homePage.php', $data);
		}
	}
}

