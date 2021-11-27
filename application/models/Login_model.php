<?php

class Login_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    function checkLogin($id,$pd){
		$this->db->select('memberId');
		$this->db->from('account');
		$this->db->where('memberId',$id);
		$this->db->where('memberPd', sha1($pd));
		$result = $this->db->get();
		if($result->num_rows() ==0){
			return "";
		}else{
			return $result->row()->memberId;
		}
	}

}
