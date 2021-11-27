<?php

class Finance_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    function getAllYear (){
        $this->db->from("finance");
        $this->db->where("f_type" , 2);
        $this->db->order_by("f_year", "DESC");
        $this->db->group_by("f_year"); 
        $query = $this->db->get();
        return $query->result();
    }

    function getAllMonth ($f_year){
        $this->db->from("finance");
        $this->db->where("f_year" , $f_year);
        $this->db->where("f_type" , 2);
        $this->db->order_by("f_month", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    function checkMonth($f_key){
        $this->db->from("finance_account");
        $this->db->where("f_key" , $f_key);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function getAllTable($f_key){
        $this->db->from("finance_account");
        $this->db->join("finance_account_class","finance_account.fac_key = finance_account_class.fac_key","left");
        $this->db->where("f_key" , $f_key);
		$this->db->order_by("fa_key", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

}
