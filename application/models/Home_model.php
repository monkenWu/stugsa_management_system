<?php

class Home_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    public function getNotice($id){
    	$this->db->select(array('title','content','time'));
        $this->db->from('notice');
        $this->db->where('key',$id);
        $result = $this->db->get()->row();
        //echo $this->db->last_query();
        $returnJson = array(
                "title" => $result->title,
                "content" => $result->content,
                "year"=>substr($result->time,0, 4),
                "date"=>substr($result->time,8, 2)
            );
        return json_encode($returnJson);
    }


}
