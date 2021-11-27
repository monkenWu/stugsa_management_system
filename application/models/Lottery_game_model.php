<?php

class Lottery_game_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    public function getAllUnJoin($a_key){
    	$oneActivity = $this->getOneActivityJoin($a_key);

    	$this->db->select('member.`key`,member.studentid, department.`name` , class.`name` as c_name , system.`name` as s_name');
		$this->db->from("member");
		$this->db->join("department","department.`key` = member.d_key");
		$this->db->join("class","class.`key` = department.class_key");
		$this->db->join("system","system.`key` = department.system_key");
		$this->db->where_not_in("member.`key`" , $oneActivity);
		$result = $this->db->get();
		$this->db->flush_cache();
		$returnData = array();

		foreach ($result->result() as $row){
			$returnData[] = array(
				"key"=>$row->key,
				"studentid"=>$row->studentid,
				"d_name"=>$row->name,
				"c_name"=>$row->c_name,
				"s_name"=>$row->s_name,
			);
	   	}

	   	return json_encode($returnData);
    }

    public function getOneActivityJoin($a_key){
    	$this->db->select("m_key");
    	$this->db->from("activity_join");
        $this->db->join("activity","activity_join.`a_key` = activity.`key`");
        $this->db->where("activity_join.a_key",$a_key);
        $query = $this->db->get();
        $this->db->flush_cache();
        $returnData = array();
        foreach ($query->result() as $row){
        	$returnData[] = $row->m_key;
	   	}
	   	return $returnData;
    }
}
