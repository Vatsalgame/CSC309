<?php
class Customer_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('customer');
		return $query->result('Customer');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('customer',array('id' => $id));
		
		return $query->row(0,'Customer');
	}
	
	function delete($id) {
		return $this->db->delete("customer",array('id' => $id ));
	}
	
	function insert($customer) {
		return $this->db->insert("customer", array('first' => $customer->first,
				                                 	        'last' => $customer->last,
							        'login' => $customer->login,
							        'password' => $customer->password,
							        'email' => $customer->email));
	}

	// To see if a particular customer exists to be able to log em in
	function getLogin($username, $password) {
		$query = $this->db->get_where('customer', array('login' => $username,
								        'password' => $password));
		return $query->row(0, 'Customer');
	}
	
	// This function would never be used by a customer query.
	function update($customer) {
		$this->db->where('id', $customer->id);
		return $this->db->update("customer", array('first' => $customer->first,
				                                 	        'last' => $customer->last,
							        'login' => $customer->login,
							        'password' => $customer->password,
							        'email' => $customer->email));
	}
	
	
}
