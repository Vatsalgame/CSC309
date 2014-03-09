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
		return $this->db->insert("customer", array('first' => $customer->firstName,
				                                 	        'last' => $customer->lastName,
							        'login' => $customer->username,
							        'password' => $customer->password,
							        'email' => $customer->email));
	}
	
	// This function would never be used. It's here for testing purposes
	function update($customer) {
		$this->db->where('id', $customer->id);
		return $this->db->update("customer", array('firstName' => $customer->firstName,
				                                 	        'lastName' => $customer->lastName,
							        'username' => $customer->username,
							        'password' => $customer->password,
							        'email' => $customer->email));
	}
	
	
}
?>