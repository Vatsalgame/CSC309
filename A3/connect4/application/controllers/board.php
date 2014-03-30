<?php

class Board extends CI_Controller {
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	session_start();
    } 
          
    public function _remap($method, $params = array()) {
	    	// enforce access control to protected functions	
    		
    		if (!isset($_SESSION['user']))
   			redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again
 	    	
	    	return call_user_func_array(array($this, $method), $params);
    }
    
    
    function index() {
		$user = $_SESSION['user'];
    		    	
	    	$this->load->model('user_model');
	    	$this->load->model('invite_model');
	    	$this->load->model('match_model');
	    	
	    	$user = $this->user_model->get($user->login);

	    	$invite = $this->invite_model->get($user->invite_id);
	    	
	    	if ($user->user_status_id == User::WAITING) {
	    		$invite = $this->invite_model->get($user->invite_id);
	    		$otherUser = $this->user_model->getFromId($invite->user2_id);
	    	}
	    	else if ($user->user_status_id == User::PLAYING) {
	    		$match = $this->match_model->get($user->match_id);
	    		if ($match->user1_id == $user->id)
	    			$otherUser = $this->user_model->getFromId($match->user2_id);
	    		else
	    			$otherUser = $this->user_model->getFromId($match->user1_id);

	    		$theArray = array(array(0, 0, 0, 0, 0, 0, 0),
				array(0, 0, 0, 0, 0, 0, 0),
				array(0, 0, 0, 0, 0, 0, 0),
				array(0, 0, 0, 0, 0, 0, 0),
				array(0, 0, 0, 0, 0, 0, 0),
				array(0, 0, 0, 0, 0, 0, 0));

			$inviter = $this->user_model->getFromId($match->user2_id)->login;


			$boardArray = array($theArray, $inviter, -4);

			$jsonBoardArray = json_encode($boardArray);

			$this->match_model->updateBoard($match->id, $jsonBoardArray);
	    	}
	    	
	    	$data['user']=$user;
	    	$data['otherUser']=$otherUser;

	    	
	    	switch($user->user_status_id) {
	    		case User::PLAYING:	
	    			$data['status'] = 'playing';
	    			break;
	    		case User::WAITING:
	    			$data['status'] = 'waiting';
	    			break;
	    	}
	    	
		$this->load->view('match/board',$data);
    }

 	function postMsg() {
 		$this->load->library('form_validation');
 		$this->form_validation->set_rules('msg', 'Message', 'required');
 		
 		if ($this->form_validation->run() == TRUE) {
 			$this->load->model('user_model');
 			$this->load->model('match_model');

 			$user = $_SESSION['user'];
 			 
 			$user = $this->user_model->getExclusive($user->login);
 			if ($user->user_status_id != User::PLAYING) {	
				$errormsg="Not in PLAYING state";
 				goto error;
 			}
 			
 			$match = $this->match_model->get($user->match_id);			
 			
 			$msg = $this->input->post('msg');
 			
 			if ($match->user1_id == $user->id)  {
 				$msg = $match->u1_msg == ''? $msg :  $match->u1_msg . "\n" . $msg;
 				$this->match_model->updateMsgU1($match->id, $msg);
 			}
 			else {
 				$msg = $match->u2_msg == ''? $msg :  $match->u2_msg . "\n" . $msg;
 				$this->match_model->updateMsgU2($match->id, $msg);
 			}
 				
 			echo json_encode(array('status'=>'success'));
 			 
 			return;
 		}
		
 		$errormsg="Missing argument";
 		
		error:
			echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}

 	// Can only call this function if it's your turn
 	// It'll be checked in the view
 	function postBoard() {
		$this->load->model('user_model');
		$this->load->model('match_model');

		$user = $_SESSION['user'];
		 
		$user = $this->user_model->getExclusive($user->login);
		if ($user->user_status_id != User::PLAYING) {	
		$errormsg="Not in PLAYING state";
			goto error;
		}

		$theArray = $this->input->post('array'); // not 'items'

		$username = $this->input->post('username'); // not 'items'

		

		$winner = $this->getWinner($theArray);
		error_log($winner);

		$boardArray = array($theArray, $username, $winner);

		$jsonBoardArray = json_encode($boardArray);

		// $boardArray = json_decode($input, TRUE);
		// error_log($boardArray);
		// error_log('mynigga');
		// return;

		// start transactional mode  
		$this->db->trans_begin();
		
		$match = $this->match_model->get($user->match_id);			
		
		// $this->session->set_userdata('cart', array());
		$this->match_model->updateBoard($match->id, $jsonBoardArray);

		if ($winner == -2) {
			$status = 4;
			$this->user_model->updateStatus($match->user1_id, 2);
			$this->user_model->updateStatus($match->user2_id, 2);
		}
		elseif ($winner == -4) {
			$status = 1;
		}
		elseif ($winner == $match->user1_id) {
			$status = 2;
			$this->user_model->updateStatus($match->user1_id, 2);
			$this->user_model->updateStatus($match->user2_id, 2);
		}
		else {
			$status = 3;
			$this->user_model->updateStatus($match->user1_id, 2);
			$this->user_model->updateStatus($match->user2_id, 2);
		}

		$this->match_model->updateStatus($match->id, $status);

		if ($this->db->trans_status() === FALSE) {
			$errormsg = "Transaction error";
			goto transactionerror;
		}
		
		// if all went well commit changes
		$this->db->trans_commit();
			
		echo json_encode(array('status'=>'success', 'winner'=>$winner));
		 
		return;
 		
		transactionerror:
			$this->db->trans_rollback();

 		$errormsg="Not your turn";
		error:
			echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}
 
	function getMsg() {
 		$this->load->model('user_model');
 		$this->load->model('match_model');
 			
 		$user = $_SESSION['user'];
 		 
 		$user = $this->user_model->get($user->login);
 		if ($user->user_status_id != User::PLAYING) {	
 			$errormsg="Not in PLAYING state";
 			goto error;
 		}
 		// start transactional mode  
 		$this->db->trans_begin();
 			
 		$match = $this->match_model->getExclusive($user->match_id);			
 			
 		if ($match->user1_id == $user->id) {
			$msg = $match->u2_msg;
 			$this->match_model->updateMsgU2($match->id,"");
 		}
 		else {
 			$msg = $match->u1_msg;
 			$this->match_model->updateMsgU1($match->id,"");
 		}

 		if ($this->db->trans_status() === FALSE) {
 			$errormsg = "Transaction error";
 			goto transactionerror;
 		}
 		
 		// if all went well commit changes
 		$this->db->trans_commit();
 		
 		echo json_encode(array('status'=>'success','message'=>$msg));
		return;
		
		transactionerror:
		$this->db->trans_rollback();
		
		error:
		echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}

 	function getBoard() {
 		$this->load->model('user_model');
 		$this->load->model('match_model');
 			
 		$user = $_SESSION['user'];
 		 
 		$user = $this->user_model->get($user->login);
 		// if ($user->user_status_id != User::PLAYING && $user->user_status_id != User::WAITING) {	
 			// $errormsg="Not in PLAYING state";
 			// goto error;
 		// }

 		if ($user->user_status_id == User::WAITING) {	
			$errormsg="Not in PLAYING state";
			goto error;
		}

 		
 			
 		$match = $this->match_model->getExclusive($user->match_id);
 			
 		// $this->session->set_userdata('cart', array());

 		if($match != null) {
 			$jsonBoardArray = $match->board_state;
 			// Check if it's the user's turn
 			// error_log($boardArray);
 			// error_log("yo");
 			$boardArray = json_decode($jsonBoardArray);
 			
 			
 			echo $jsonBoardArray;
	
 			return;
 		}
 				
		error:
		echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}

 	function getWinner($board) {
 		$tie_flag = TRUE;
 		foreach($board as $rowIndex => $row) {
 			foreach($row as $colIndex => $item) {
 				if($item == 0) $tie_flag = FALSE;
 				// down check
 				if($rowIndex <= 2 &&
 					$board[$rowIndex][$colIndex] != 0 &&
 					$board[$rowIndex][$colIndex] == $board[$rowIndex+1][$colIndex] && 
 					$board[$rowIndex+1][$colIndex] == $board[$rowIndex+2][$colIndex] &&
 					$board[$rowIndex+2][$colIndex] == $board[$rowIndex+3][$colIndex]) {
 					return $board[$rowIndex][$colIndex];
 				}
 				// diag right check
 				if($rowIndex <= 2 && $colIndex <= 3 &&
 					$board[$rowIndex][$colIndex] != 0 &&
 					$board[$rowIndex][$colIndex] == $board[$rowIndex+1][$colIndex+1] && 
 					$board[$rowIndex+1][$colIndex+1] == $board[$rowIndex+2][$colIndex+2] &&
 					$board[$rowIndex+2][$colIndex+2] == $board[$rowIndex+3][$colIndex+3]) {
 					return $board[$rowIndex][$colIndex];
 				}
 				// diag left check
 				if($rowIndex <= 2 && $colIndex >= 3 &&
 					$board[$rowIndex][$colIndex] != 0 &&
 					$board[$rowIndex][$colIndex] == $board[$rowIndex+1][$colIndex-1] && 
 					$board[$rowIndex+1][$colIndex-1] == $board[$rowIndex+2][$colIndex-2] &&
 					$board[$rowIndex+2][$colIndex-2] == $board[$rowIndex+3][$colIndex-3]) {
 					return $board[$rowIndex][$colIndex];
 				}
 				// right
 				if($colIndex <= 3 &&
 					$board[$rowIndex][$colIndex] != 0 &&
 					$board[$rowIndex][$colIndex] == $board[$rowIndex][$colIndex+1] && 
 					$board[$rowIndex][$colIndex+1] == $board[$rowIndex][$colIndex+2] &&
 					$board[$rowIndex][$colIndex+2] == $board[$rowIndex][$colIndex+3]) {
 					return $board[$rowIndex][$colIndex];
 				}
 			}
 		}
 		if ($tie_flag){
 			// tie
 			return -2;
 		} 
 		else{
 			// game's on
 			return -4;
 		}
 	}
 	
 }

