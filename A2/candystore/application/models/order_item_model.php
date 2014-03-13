<?php
class Order_Item_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order_item');
		return $query->result('Order_Item');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order_item',array('id' => $id));
		
		return $query->row(0,'Order_Item');
	}
	
	function delete($id) {
		return $this->db->delete("order_item",array('id' => $id ));
	}
	
	function insert($order_item) {
		return $this->db->insert("order_item", array('order_id' => $order_item->order_id,
							           'product_id' => $order_item->product_id,
							           'quantity' => $order_item->quantity));
	}
	
	// This function would never be used by a customer query.
	// function update($customer) {
	// 	$this->db->where('id', $customer->id);
	// 	return $this->db->update("customer", array('first' => $customer->first,
	// 			                                 	        'last' => $customer->last,
	// 						        'login' => $customer->login,
	// 						        'password' => $customer->password,
	// 						        'email' => $customer->email));
	// }
	
	
}
