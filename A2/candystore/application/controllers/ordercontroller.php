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
	$this->load->view('order_system/checkoutPage.php');
    }

    function deleteOrderItem($id) {
    	if(array_key_exists($id, $this->session->userdata('cart'))) {
    		$data = $this->session->userdata('cart');
    		// error_log(var_dump($data[$id]));
    		unset($data[$id]);
    		// error_log(var_dump($data[$id]));
    		$this->session->set_userdata('cart', $data);
    	}
    	// $this->load->view('order_system/checkoutPage.php');
    	redirect('ordercontroller/index', 'refresh');
    }

    function deleteOrder($id) {
        $this->load->model('order_model');
        $this->load->model('order');

        if (isset($id)) 
            $this->order_model->delete($id);

        redirect('ordercontroller/loadOrders', 'refresh');
    }

        function deleteAllOrders() {
        $this->load->model('order_model');
        $this->load->model('order');

        $this->order_model->deleteAll();

        redirect('ordercontroller/loadOrders', 'refresh');
    }

  //   function updateOrderItem() {
  //   	// error_log("yo");
  //   	foreach ($this->session->userdata('cart') as $id => $product) {
  //   		$this->load->library('form_validation');
		// $this->form_validation->set_rules("$id", "$id",'required|integer');
  //                         // error_log("$id");
		// if ($this->form_validation->run() == true) {
		// 	$data = $this->session->userdata('cart');
		// 	$qty = $this->input->post("$id");
		// 	error_log("id: " . $id . " - " . $qty);
	 //    		$data[$id]['qty'] = $qty;
	 //    		// error_log(var_dump($data[$id]));
	 //    		$this->session->set_userdata('cart', $data);
		// }
		// else {
		// 	// redirect('ordercontroller/index', 'refresh');
  //                                       $this->load->view('order_system/checkoutPage.php');
		// }
  //   	}

  //   	redirect('ordercontroller/index', 'refresh');
  //   }

    function moveToPayment() {
            if(!$this->session->userdata('loggedIn')) {
                redirect('ordercontroller/index', 'refresh');
            }
            else {
                $this->load->view('order_system/paymentPage.php');
            }
    }

    function checkoutPay() {
        // loading models
        $this->load->model('order_model');
        $this->load->model('order_item_model');
        $this->load->model('order');
        $this->load->model('order_item');

        $date = date('y-m-d');
        // $year = substr($date, 0, 2);
        // $month = substr($date, 3, 2);

        $year = date('y');
        $month = date('m');
        $time = date('H:i:s');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('creditcardnumber','Credit Card Number','required|min_length[16]|max_length[16]|integer');
        $this->form_validation->set_rules('validMonth','Valid Until (Month)','required|min_length[1]|max_length[2]|integer|less_than[12]');
        $this->form_validation->set_rules('validYear','Valid Until (Year)','required|min_length[1]|max_length[2]|integer|greater_than[' . ($year-1) . ']');

        $this->form_validation->set_message('greater_than', '%s is not valid anymore. Kindly use a valid card.');
        $this->form_validation->set_message('integer', 'Kindly check the number again.');

        if ($this->form_validation->run() == true) {
            $order = new Order();
            $order->customer_id = $this->session->userdata('userId');
            $order->order_date = $date;
            $order->order_time = $time;
            $order->total = $this->session->userdata('totalSum');
            $order->creditcard_number = $this->input->get_post('creditcardnumber');
            $order->creditcard_month = $this->input->get_post('validMonth');
            $order->creditcard_year = $this->input->get_post('validYear');

                if($order->creditcard_year == $year) {
                        $this->form_validation->set_rules('validMonth','Valid Until (Month)','required|min_length[1]|max_length[2]|integer|greater_than[' . ($month-1) . ']');
                       if ($this->form_validation->run() == false) {
                            $this->load->view('order_system/paymentPage.php');
                       }
                       else {
                            // get the id of the order just inserted
                            $orderId = $this->order_model->insert($order);

                            foreach ($this->session->userdata('cart') as $id => $product) {
                                $order_item = new Order_Item();
                                $order_item->order_id = $orderId;
                                $order_item->product_id = $id;
                                $order_item->quantity = $product['qty'];

                                $this->order_item_model->insert($order_item);

                                // $this->session->set_userdata('orderId', $orderId);

                                $data['creditcardnumber'] = 'XXXX-XXXX-XXXX-X' . substr(strval($order->creditcard_number), -3);
                                $data['creditcarddetails'] = strval($order->creditcard_month) . '/' . strval($order->creditcard_year);
                                $data['orderDate'] = $order->order_date;
                                $data['orderTime'] = $order->order_time;

                                $this->sendEmail($data);

                                $this->load->view('order_system/confirmationPage', $data);
                            }
                       }
                }
                else {
                    // get the id of the order just inserted
                    $orderId = $this->order_model->insert($order);

                    foreach ($this->session->userdata('cart') as $id => $product) {
                        $order_item = new Order_Item();
                        $order_item->order_id = $orderId;
                        $order_item->product_id = $id;
                        $order_item->quantity = $product['qty'];

                        $this->order_item_model->insert($order_item);

                        // $this->session->set_userdata('orderId', $orderId);

                        $data['creditcardnumber'] = 'XXXX-XXXX-XXXX-X' . substr(strval($order->creditcard_number), -3);
                        $data['creditcarddetails'] = strval($order->creditcard_month) . '/' . strval($order->creditcard_year);
                        $data['orderDate'] = $order->order_date;
                        $data['orderTime'] = $order->order_time;

                        $this->sendEmail($data);

                        $this->load->view('order_system/confirmationPage', $data);
                    }
                }

        }
        else{
            $this->load->view('order_system/paymentPage.php');
        }

        // $timezone = date_default_timezone_get();
        
        // error_log($date);
        // error_log($year);
        // error_log($month);
        // error_log($time);
    }

    function emailReceipt() {
        alert("Hello");
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

                redirect('ordercontroller/index', 'refresh');
            }
            else {
                // $data['loginFailed'] = True;
                redirect('ordercontroller/index', 'refresh');
            }
        }
        else {
            redirect('ordercontroller/index', 'refresh');
        }
    }

    function logOut() {
        // if($this->session->userdata('loggedIn')) {
        //     $this->session->unset_userdata('loggedIn');
        //     $this->session->unset_userdata('username');
        // }
        $this->session->sess_destroy();
        redirect('candystore/index', 'refresh');    
    }

    function goHome() {
        $this->session->unset_userdata('cart');
        redirect('candystore/index', 'refresh');
    }

    function sendEmail($data) {
        $this->load->library('email');

        $this->load->model('customer_model');
        $this->load->model('customer');

        $customer = $this->customer_model->get($this->session->userdata('userId'));

        // error_log($customer->email);


        $this->email->from('admin@candystore.com', 'CS Admin');
        $this->email->to($customer->email); 
        // $this->email->cc('another@another-example.com'); 
        // $this->email->bcc('them@their-example.com'); 

        $this->email->subject('CandyStore: Your Order (placed on ' . $data['orderDate'] .')');

        $message = "Credit Card used: " . $data['creditcardnumber'] . "  
                                Order Details: 
                                ";

        $sum_amt = 0;
        $sum_qty = 0;

        foreach ($this->session->userdata('cart') as $id => $product) {
            $cur_sum_amt = $product['qty'] * $product['price'];
            $sum_amt = $sum_amt + $cur_sum_amt;
            $sum_qty = $sum_qty + ($product['qty']);

            $message = $message . $product['name'] . " - " . $product['qty'] . " ($" . $cur_sum_amt . " @ $" . $product['price'] . " each) 
                                    ";

        }
        $message = $message . "Total: " . $sum_qty . " ($ " . $sum_amt . ")";

        $this->email->message($message);  

        $this->email->send();
    }

    // admin functions
    function loadOrders() {
        $this->load->model('order_model');
        $this->load->model('order');

        $orders = $this->order_model->getAll();
        $data['orders']=$orders;

        $this->load->view('order_system/orders_admin.php', $data);
    }

}

