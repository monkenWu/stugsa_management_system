<?php

class Member_management_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    /**
	 * 依序寫入資料
	 * @param 班級名稱,學號資料
	 * @return Boolean
	 */
	function addMember($classData , $memberData){
		$this->db->set('name', $classData[0]['value']);
		$this->db->set('class_key', $classData[1]['value']);
		$this->db->set('system_key', $classData[2]['value']);
		$this->db->insert('department');
		$classID =  $this->db->insert_id();

		$memberArray = json_decode($memberData,true);
		for($i=0;$i<count($memberArray);$i++){
			$this->db->set('d_key', $classID);
			$this->db->set('studentid', $memberArray[$i]['value']);
			$this->db->insert('member');
		}

		return true;
	}

	/**
	 * 確認班級名稱是否重複
	 * @param 班級名稱
	 * @return Boolean
	 */
	function checkDepartment($classData){
		$this->db->select('name');
		$this->db->from('department');
		$this->db->where('name',$classData[0]['value']);
		$this->db->where('class_key',$classData[1]['value']);
		$this->db->where('system_key',$classData[2]['value']);
		$result = $this->db->get();
		if($result->num_rows() == 0){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * 刪除一筆會員
	 * @param 會員主鍵
	 * @return Boolean
	 */
	public function delMember($id){
        $this->db->select('d_key');
        $this->db->from('member');
        $this->db->where('key',$id);
        $d_key = $this->db->get()->row()->d_key;
        $this->db->flush_cache();

        $this->db->select('key');
		$this->db->from('member');
		$this->db->where('d_key',$d_key);
		$result = $this->db->get();
		$this->db->flush_cache();

		$this->db->where('key', $id);
		$returnBoolean = $this->db->delete('member');
		$this->db->flush_cache();

        if($result->num_rows() == 1){
        	$this->db->where('key', $d_key);
			$returnBoolean = $this->db->delete('department');
        }

        return $returnBoolean;
    }

    public function departmentSearch($classValue,$systemValue){
        $this->db->select('key ,name');
        $this->db->from('department');
        $this->db->where('class_Key',$classValue);
        $this->db->where('system_Key',$systemValue);
        $result = $this->db->get()->result();

        $data = array();
        foreach($result as $key => $row){
			array_push($data,array(
				"key" => $row->key,
				"name" => $row->name
			));
        }
        return json_encode($data);
    }

    /**
	 * 依序寫入資料
	 * @param 班級名稱,學號資料
	 * @return Boolean
	 */
	function editMember($classKey , $memberData){

		$memberArray = json_decode($memberData,true);
		for($i=0;$i<count($memberArray);$i++){
			if($this->checkMember($memberArray[$i]['value'])){
				$this->db->set('d_key', $classKey);
				$this->db->set('studentid', $memberArray[$i]['value']);
				$this->db->insert('member');
			}else{
				return $memberArray[$i]['value']."已經存在於資料庫，請確認是否重複新增！";
			}
		}
		return true;
	}

	/**
	 * 依序確認所寫入的資料
	 * @param 班級名稱,學號資料
	 * @return Boolean
	 */
	function checkAddMember($classKey , $memberData){

		$memberArray = json_decode($memberData,true);
		$insertArray = array();
		for($i=0;$i<count($memberArray);$i++){
			if($this->checkMember($memberArray[$i]['value'])){
				$insertArray[$i] = array(
					'd_key' => $classKey,
					'studentid' => $memberArray[$i]['value']
				); 
			}else{
				return $memberArray[$i]['value']."已經存在於資料庫，請確認是否重複新增！";
			}
		}

		for($i=0;$i<count($insertArray);$i++){
			$this->db->insert('member',$insertArray[$i]);
		}

		return true;
	}



    /**
	 * 確認補繳會員是否重複
	 * @param 班級名稱
	 * @return Boolean
	 */
	private function checkMember($studentid){
		$this->db->select('key');
		$this->db->from('member');
		$this->db->where('studentid',$studentid);
		$result = $this->db->get();
		$this->db->flush_cache();
		if($result->num_rows() == 0){
			return true;
		}else{
			return false;
		}
	}

	 /**
	 * 回傳全班資料
	 * @param 班級主鍵
	 * @return Boolean
	 */
	public function getClassAllMember($d_key){
		$this->db->select("*");
    	$this->db->from("member");
        $this->db->where("d_key" , $d_key);
        $query = $this->db->get();
        $returnData = array();
        foreach ($query->result() as $row){
        	$returnData[] = array(
        		"key"      => $row->key,
				"studentid" => $row->studentid
        	);
	   	}
	   	$returnData['length'] = count($returnData);
	   	$returnData['status'] = 1;
        return $returnData;
	}

	/**
	 * 完成確認
	 * @param 班級主鍵
	 * @return Boolean
	 */
	function checkSuccess($d_key){
		$this->db->set('d_key', $d_key);
		$this->db->set('check_time',date('Y-m-d H:i:s'));
		$this->db->insert('member_check');
		$result = $this->db->error();
        if($result['code'] == 1062){
		    $data = array(
		        'check_time'  => date('Y-m-d H:i:s')
			);
	        $this->db->where('d_key', $d_key);
	        return $this->db->update('member_check', $data);
        }else{
        	return true;
        }
		return true;
	}

	/**
	 * 取得修正時間
	 * @param 班級主鍵
	 * @return Boolean
	 */
	function getListHistory($d_key){
		$this->db->select('*');
		$this->db->from('member_check');
		$this->db->where('d_key',$d_key);
		$result = $this->db->get();
		$data = array();
		$data['status'] = 1;
		if($result->num_rows() == 0){
			$data['isTime'] = false;
			return $data;
		}else{
			$data['isTime'] = true;
			$data['time'] = $result->row()->check_time;
			return $data;
		}
	}

}
