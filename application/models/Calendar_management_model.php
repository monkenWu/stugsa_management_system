<?php

class Calendar_management_model extends CI_Model{

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

	/**
	 * 新增一筆事件
	 */
	function addEvents($title , $start_time , $end_time , $allday , $content , $color){
		$this->db->set('title', $title);
		$this->db->set('start_time', $start_time);
		$this->db->set('end_time', $end_time);
		$this->db->set('allday', $allday);
		$this->db->set('content', $content);
		$this->db->set('color', $color);
		$this->db->insert('calendar');
	}

	/**
	 * 修改一筆事件
	 */
	function updateEvents($key , $title , $start_time , $end_time , $allday , $content , $color){
		$data = array(
               'title' => $title,
               'start_time' => $start_time,
               'end_time' => $end_time,
               'allday' => $allday,
               'content' => $content,
               'color' => $color,
            );
		$this->db->where('key', $key);
		$this->db->update('calendar', $data);
	}

	/**
	 * 刪除一筆事件
	 */
	function deleteEvents($key){
		$this->db->where('key', $key);
		$this->db->delete('calendar');
	}

	/**
	 * 拖拉一筆事件
	 */
	function dropEvents($key , $start_time , $end_time ){
		$data = array(
               'start_time' => $start_time,
               'end_time' => $end_time
                );
		$this->db->where('key', $key);
		return $this->db->update('calendar', $data);;
	}

	/**
	 * 改變事件長度
	 */
	function resizeEvents($key , $end_time){
		$data = array(
               'end_time' => $end_time
        );
		$this->db->where('key', $key);
		return $this->db->update('calendar', $data);
	}


}
