<?php

class Activity_management_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    /**
	 * 依序寫入資料
	 * @param 寫入資料集
	 * @return Boolean
	 */
    public function addActivity($dataArray){
		$this->db->set('name', $dataArray['name']);
		$this->db->set('content', $dataArray['content']);
		$this->db->set('feedback', $dataArray['feedback']);
		$this->db->set('start_time', $dataArray['start_time']);
		$this->db->set('end_time', $dataArray['end_time']);
		if($this->db->insert('activity')){
			return true;
		}else{
			return false;
		}
    }

    /**
	 * 確認活動名稱是否重複
	 * @param 活動名稱
	 * @return Boolean
	 */
    public function checkActivity($nameData){
    	$this->db->select('name');
		$this->db->from('activity');
		$this->db->where('name',$nameData);
		$result = $this->db->get();
		if($result->num_rows() == 0){
			return false;
		}else{
			return true;
		}
    }


    /**
	 * 取得一筆活動資訊
	 * @param 活動主鍵
	 * @return Boolean
	 */
    public function getOneActivity($key){
        $this->db->select('*');
        $this->db->from('activity');
        $this->db->where('key',$key);

        if($result = $this->db->get()->row()){
        	$startTime = explode(" ",$result->start_time);
        	$endTime = explode(" ",$result->end_time);
        	$data = array(
	        	"name" => $result->name,
	        	"content" => $result->content,
	        	"feedback" => $result->feedback,
	        	"startDate" => $startTime[0],
	        	"startTime" => $startTime[1],
	        	"endDate" => $endTime[0],
	        	"endTime" => $endTime[1],
	        	"status" => 1
	        );
        }else{
        	$data = array(
	        	"status" => 0
	        );
        }
        return json_encode($data);
    }

    /**
	 * 編輯資料
	 * @param 編輯資料集
	 * @return Boolean
	 */
    public function editActivity($dataArray){
    	$data = $dataArray;
        unset($data['key']);
        $this->db->where('key', base64_decode($dataArray['key']));
        return $this->db->update('activity', $data);
    }

    /**
	 * 刪除資料
	 * @param 編輯資料
	 * @return Boolean
	 */
    public function delActivity($key){
        $this->db->where('key', $key);
        $this->db->delete('activity');
        $result = $this->db->error();
        if($result['code'] == 1451){
        	return false;
        }else{
        	return true;
        }
    }

    /**
	 * 確認是否有這個會員
	 * @param 活動名稱
	 * @return Boolean
	 */
    public function checkValue($number){
    	$this->db->select('*');
		$this->db->from('member');
		$this->db->where('studentid',$number);
		$result = $this->db->get();
		if($result->num_rows() == 0){
			return false;
		}else{
			return true;
		}
    }

     /**
	 * 取得會員未參加的活動
	 * @param 活動名稱
	 * @return Boolean
	 */
	public function getMemberNewActivity($number){

		$notInWhere = json_decode($this->getCheckActivity($number),true);
		$checkData = array();
		for($i=0;$i<count($notInWhere);$i++){
			$checkData[] = $notInWhere[$i]['key'];
		}
	   	$this->db->flush_cache();

    	$this->db->select('activity.`key` , activity.`name`');
		$this->db->from("activity");
		if(count($checkData)>0){
			$this->db->where_not_in("activity.`key`" , $checkData);
		}
		$this->db->order_by("activity.`key`", "ASC");
		$result = $this->db->get();
		$returnData = array();

		foreach ($result->result() as $row){
			$returnData[] = array(
				"key"      => $row->key,
				"name"  => $row->name
			);
	   	}

	   	return json_encode($returnData);
    }

    public function getCheckActivity($number){
    	$this->db->select("activity.`key` ,activity.`name`");
    	$this->db->from("activity");
        $this->db->join("activity_join","activity_join.`a_key` = activity.`key`");
		$this->db->join("member","member.`key` = activity_join.`m_key`");
        $this->db->where("member.studentid" , $number);
        $query = $this->db->get();
        $returnData = array();
        foreach ($query->result() as $row){
        	$returnData[] = array(
        		"key"      => $row->key,
				"name"  => $row->name
        	);
	   	}
        return json_encode($returnData);
    }

	/**
	 * 依序寫入資料
	 * @param 寫入資料集
	 * @return Boolean
	 */
    public function joinActivity($dataArray){
		$this->db->set('a_key', $dataArray['a_key']);
		$this->db->set('m_key', $dataArray['m_key']);
		if($this->db->insert('activity_join')){
			return true;
		}else{
			return false;
		}
    }

    /**
	 * 刪除資料
	 * @param 編輯資料
	 * @return Boolean
	 */
    public function delJoinActivity($dataArray){
        $this->db->where('a_key', $dataArray['a_key']);
        $this->db->where('m_key', $dataArray['m_key']);
        if($this->db->delete('activity_join')){
        	return true;
        }else{
        	//print_r($this->db->error());
        	return false;
        }
    }

	/**
	 * 取得學號主鍵
	 * @param 寫入資料集
	 * @return Boolean
	 */
    public function getMemberKey($number){
    	$this->db->select('*');
		$this->db->from('member');
		$this->db->where('studentid',$number);
		$result = $this->db->get()->row();
		$this->db->flush_cache();
		return $result->key;
    }
    
    public function getEmailText($url){
        $message = "親愛的畢業生您好：\r\n";
        $message .= "　　非常感謝您今日撥空參與本活動，謝謝你與我們在畢業前夕完成一場美麗的夢。當然，在活動中一定還有許多可以改進的方向，我們希望可以聽取各位畢業生的意見。\r\n";
        $message .= "　　為了讓未來的畢業生活動可以更加地順利，還請您幫我們填寫這份調查。不管結果的好壞我們一定都會虛心接受，只為了創造下一次更好的活動品質！\r\n";
        $message .= "　　回饋量表連結：\r\n";
        $message .= "　　$url";
        return $message;
    }

    public function getMostEmailText(){
    	$message = "親愛的畢業生您好：\r\n";
        $message .= "　　畢聯會會員的你，是108級畢業生聯合會主要服務的對象。在畢業前，我們舉辦了一場給予畢業生的市集活動，在活動中可以憑學生證領取50元折價券(前五百名)。\r\n";
        $message .= "　　也能夠參與獎品抽抽樂，現場立刻抽出獎項，將有機會獲得 Switch、掃地機器人、Airpods......等多達三十九個獎項！\r\n";
        $message .= "　　不只是抽獎，所有畢聯會會員的畢業生，都能夠憑學生證在服務台領取免費的畢業禮品「畢聯會束口袋」！期待在活動中與您相見！\r\n";
        $message .= "\r\n活動日期：5/15-5/16\r\n";
        $message .= "活動日時間：11:00-20:00\r\n";
        $message .= "活動地點：二宿前草皮和Fun卡曼旁草皮\r\n";
        $message .= "注意事項：因抽獎涉及全體繳費成員之權益，參與活動領取獎品之畢業生，請攜帶學生證證明身分，或是同等效力之在學證明。\r\n";
        return $message;
    }

    public function getAllMember(){
    	$this->db->select('studentid');
		$this->db->from('member');
		$result = $this->db->get();
		$array = array();
		foreach ($result->result() as $row){
        	$array[]= "s".$row->studentid."@stu.edu.tw";
	   	}
		return $array;
    }

    public function getChartActivity($key){
    	$joinNum = $this->getJoinNum($key);
    	$memberNum = $this->getMemberNum();
    	$result = array(
			"check" => $joinNum,
			"uncheck" => $memberNum-$joinNum,
			"allMember" => $memberNum,
			"rate" => round(((double)$joinNum / (double)$memberNum)*100, 2),
			"status" => 1
    	);
    	return json_encode($result);
    }

    public function getJoinNum($key){
    	$this->db->select('count(activity.`key`) as joinnum');
    	$this->db->from('activity');
    	$this->db->join('activity_join','activity_join.`a_key` = activity.`key`');
    	$this->db->where('activity.key',$key);
    	$result = $this->db->get()->row()->joinnum;
    	// echo $this->db->last_query();
    	$this->db->flush_cache();
    	return $result;
    }

    public function getMemberNum(){
    	$this->db->select('count(member.`key`) as membernum');
    	$this->db->from('member');
    	$result = $this->db->get()->row()->membernum;
    	$this->db->flush_cache();
    	return $result;
    }

    public function getUnJoinMemberList($a_key){
    	$allDepartment = $this->getDepartment();
    	//print_r($allDepartment);
    	$outPutArr = array();
    	$activityName = json_decode($this->getOneActivity($a_key))->name;
    	$this->db->flush_cache();
    	for($i=0;$i<count($allDepartment);$i++){
    		$oneUnJoin = $this->getOneUnJoin($allDepartment[$i]['key'],$a_key);
    		if(count($oneUnJoin)>0){
    			$outPutArr[] = array(
    				"d_name" => $allDepartment[$i]['d_name'],
    				"s_name" => $allDepartment[$i]['s_name'],
    				"c_name" => $allDepartment[$i]['c_name'],
    				"student"=> $oneUnJoin,
    				"length"  => count($oneUnJoin),
    				"a_name" => $activityName
    			);
    		}else{
    			continue;
    		}
    	}
    	return json_encode($outPutArr);
    }

    public function getDepartment(){
    	$this->db->select(" department.`key`,department.`name` as `d_name`,system.`name` as `s_name`,class.`name` as `c_name`");
    	$this->db->from("department");
        $this->db->join("class","class.`key` = department.`class_key`");
		$this->db->join("system","system.`key` = department.`system_key`");
		$this->db->order_by('department.`key`','ASC');
        $query = $this->db->get();
        $this->db->flush_cache();
        $returnData = array();
        foreach ($query->result() as $row){
        	$returnData[] = array(
        		"key"      => $row->key,
				"d_name"  => $row->d_name,
				"s_name"  => $row->s_name,
				"c_name"  => $row->c_name
        	);
	   	}
	   	return $returnData;
    }

    public function getOneUnJoin($d_key,$a_key){
    	$oneActivity = $this->getOneActivityJoin($a_key);

    	$this->db->select('member.`key`,member.`studentid`');
		$this->db->from("member");
		$this->db->where_not_in("member.`key`" , $oneActivity);
		$this->db->where(" member.d_key" , $d_key);
		$result = $this->db->get();
		$this->db->flush_cache();
		$returnData = array();

		foreach ($result->result() as $row){
			$returnData[] = $row->studentid;
	   	}

	   	return $returnData;

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
