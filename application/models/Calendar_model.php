<?php

class Calendar_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    /**
	 * 依照日期取得資料庫內所有事件
	 * @param 社團主鍵,推播類型
	 * @return Array
	 */
	function getAllEvents($start , $end){
		$this->db->from("calendar");
		$where = "(start_time >= '".$start."' AND end_time <= '".$end."' ) OR (start_time >= '".$start."' AND end_time > '".$end."' ) OR (start_time < '".$start."')";
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 取得一筆事件
	 * @param 社團主鍵,推播類型
	 * @return Array
	 */
	function getEvents($key){
		$this->db->from("calendar");
		$this->db->where("key" , $key);
		$query = $this->db->get();
		return $query->row();
	}

}
