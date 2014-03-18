<?php
// starting the session for login functionality
session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

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
	    	$this->load->library('session');
	    	
    }

    function index() {
    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;
    		
    		// Would be used to create a pop-up if a customer just signed up
    		$data['signedUp'] = False;
    		// Used for displaying login properly
    		// $data['loggedIn'] = False;
    		// $data['username'] = NULL;
    		// Used if login fails
    		// $data['loginFailed'] = False;

    		// Setting up session stuff
    		// cart is gonna be a dictionary/hashmap or basically an array in PHP
    		// a 2D array of [product, qty]
    		// if(!isset($_SESSION['cart'])) {
    		// 	$_SESSION['cart'] = array();
    		// }
    		if(!$this->session->userdata('cart')) {
    			$this->session->set_userdata('cart', array());
    		}

		if($this->session->userdata('loggedIn')) {
			if(strcmp($this->session->userdata('username'), 'Admin') == 0)
				$this->load->view('product/homePage_admin.php', $data);
		}
		else {
			$this->load->view('product/homePage.php', $data);
		}

    		// $this->load->view('product/list.php',$data);
    		// $this->load->view('product/homePage.php', $data);
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
		$data['validationErrors'] = array();
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

	// // Function to log in a customer/admin
	function logIn() {
		$this->load->model('customer_model');
		$this->load->model('customer');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if ($this->form_validation->run() == true) {
			$customer = new Customer();
			$customer->login = $this->input->get_post('username');
			$customer->password = $this->input->get_post('password');

			if(strcmp($customer->login, 'admin') == 0 && strcmp($customer->password, 'admin') == 0) {
				$this->session->set_userdata('loggedIn', True);
				$this->session->set_userdata('username', 'Admin');
				$this->session->set_userdata('userId', 0);

				// $this->load->model('product_model');
	   //  			$products = $this->product_model->getAll();
	   //  			$data['products']=$products;
	   //  			$data['signedUp'] = False;

	   //  			$this->load->view('product/homePage_admin.php', $data);
				redirect('candystore/index', 'refresh');

			} 
			else {
				// echo $customer->login;
				// echo $customer->password;
				$loggedIn_customer = $this->customer_model->getLogin($customer->login, $customer->password);
				// $loggedIn = $loggedIn_customer->result();
				// Checking if the login was successful
				if($loggedIn_customer) {
					// $_SESSION['loggedIn'] = True;
					// $_SESSION['username'] = $loggedIn_customer->first;

					$this->session->set_userdata('loggedIn', True);
					$this->session->set_userdata('username', $loggedIn_customer->first);
					$this->session->set_userdata('userId', $loggedIn_customer->id);

					// $data['loggedIn'] = True;
					// $data['username'] = $loggedIn_customer->first;

					// $this->load->model('product_model');
		   //  			$products = $this->product_model->getAll();
		   //  			$data['products']=$products;
		   //  			$data['signedUp'] = False;
		   //  			$this->load->view('product/homePage.php', $data);
					redirect('candystore/index', 'refresh');
				}
				else {
					// $data['loginFailed'] = True;

					// $this->load->model('product_model');
		   //  			$products = $this->product_model->getAll();
		   //  			$data['products']=$products;
		   //  			$data['signedUp'] = False;
		   //  			// $data['loggedIn'] = False;
		   //  			// $data['username'] = NULL;
		   //  			$this->load->view('product/homePage.php', $data);
					redirect('candystore/index', 'refresh');
				}

			}
		}
		else {
			// $this->load->model('product_model');
   //  			$products = $this->product_model->getAll();
   //  			$data['products']=$products;
   //  			$data['signedUp'] = False;
   //  			// $data['loggedIn'] = False;
   //  			// $data['username'] = NULL;
   //  			// $data['loginFailed'] = False;
   //  			$this->load->view('product/homePage.php', $data);	
			redirect('candystore/index', 'refresh');
		}
	}

	// // Function to logout a logged in user
	function logOut() {
		// if(isset($_SESSION['loggedIn'])) {
		// 	unset($_SESSION['loggedIn']);
		// 	unset($_SESSION['username']);
		// }
		// if($this->session->userdata('loggedIn')) {
		// 	$this->session->unset_userdata('loggedIn');
		// 	$this->session->unset_userdata('username');
		// }

		$this->session->sess_destroy();

		// $this->load->model('product_model');
		// $products = $this->product_model->getAll();
		// $data['products']=$products;
		// $data['signedUp'] = False;
		// $this->load->view('product/homePage.php', $data);
		redirect('candystore/index', 'refresh');
	}

	// Function to add items to the cart
	function addItem($id) {
		// if(array_key_exists($id, $_SESSION['cart'])) {
		// 	$_SESSION['cart'][$id]['qty'] = $_SESSION['cart'][$id]['qty'] + 1;
		// }
		if(array_key_exists($id, $this->session->userdata('cart'))) {
			$data = $this->session->userdata('cart');
			$data[$id]['qty'] = $data[$id]['qty'] + 1;
			$this->session->set_userdata('cart', $data);
		}
		else {
			$this->load->model('product_model');
			$product = $this->product_model->get($id);
			// $_SESSION['cart'][$id] = array('name' => $product->name, 'price' => $product->price, 'qty' => 1);
			$data = $this->session->userdata('cart');
			$data[$id] = array('name' => $product->name, 'price' => $product->price, 'qty' => 1);
			$this->session->set_userdata('cart', $data);
		}
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');

	}

	// // Function to remove items from the cart
	function removeItem($id) {
		// The check for existence of key is already performed in the view,
		// but checking just to be safe
		// if(array_key_exists($id, $_SESSION['cart'])) {
		// 	$_SESSION['cart'][$id]['qty'] = $_SESSION['cart'][$id]['qty'] - 1;
		// 	if ($_SESSION['cart'][$id]['qty'] == 0) {
		// 		unset($_SESSION['cart'][$id]);
		// 	} 
		// }
		if(array_key_exists($id, $this->session->userdata('cart'))) {
			$data = $this->session->userdata('cart');
			$data[$id]['qty'] = $data[$id]['qty'] - 1;
			if($data[$id]['qty'] == 0) {
				unset($data[$id]);
			}
			$this->session->set_userdata('cart', $data);
		}

		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');

	}

	// // Function to refresh shopping cart
	// function updateCart() {
	// 	$this->load->model('product_model');
 //    		$products = $this->product_model->getAll();
 //    		$data['products']=$products;

 //    		return $data;
	// }

	// all admin functions
}

