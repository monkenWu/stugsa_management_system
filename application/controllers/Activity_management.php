<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Activity_management extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("activity_management_model","",TRUE);
		$this->load->library('light_datatables');
		$this->load->library('email');
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 會員管理','activity_management','system');
			$this->load->view("activity_management_view",$viewData);
		}else{
			redirect("home");
		}
	} 


	/**
	 * 直接進入頁面
	 */
	public function checkin() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 會員管理','activity_management','system');
			$this->load->view("activity_management_checkin_view",$viewData);
		}else{
			redirect("home");
		}
	}

	/**
	 * 直接進入頁面
	 */
	public function result() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 會員管理','activity_management','system');
			$this->load->view("activity_management_result_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 直接進入頁面
	 */
	public function printPage() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 會員管理','activity_management','system');
			$this->load->view("activity_management_print_view",$viewData);
		}else{
			redirect("home");
		}
	} 


	/**
	 * 新增活動
	 */
	public function addActivity(){
		if(isset($_POST['activityData'])){
			$postArr = json_decode($_POST['activityData'],true);
			$activityData = $this->xss(json_decode($_POST['activityData'],true));
			$activityData['feedback'] = $postArr['feedback'];
			if($this->activity_management_model->checkActivity($activityData['name'])){
				echo 0;
			}else{
				$this->activity_management_model->addActivity($activityData);
				echo 1;
			}
		}else{
			echo 2;
		}
	}

	/**
	 * 會員的Datatable
	 */
	public function datatable(){
		$order=array(null,'name',null,'start_time','end_time');
		$like=array('key','name','content','start_time', 'end_time');
		$buttton = '<button type="button" onclick="editActivity(\'[extra]\')" class="btn btn-outline-success functions-btn">編輯</button>　<button type="button" onclick="chartActivity(\'[extra]\')" class="btn btn-outline-primary functions-btn">統計</button>　<button type="button" onclick="delActivity(\'[extra]\')" class="btn btn-outline-danger functions-btn">刪除</button>';
		$a = "[extra]";
		$output=array($buttton ,'name' ,$a ,'start_time' ,'end_time');
		$extra=array('key' , 'key', 'key' ,'feedback');
		$functions = function ($value,$case){
		    switch ($case){
		        case 1:
		        case 2:
		        case 3:
		        	return base64_encode($value);
		        case 4:
		            if($value == ""){
		            	return "無";
		            }else{
		            	return "<a href='{$value}' target='_blank' class='btn btn-outline-info functions-btn'>打開連結</a>";
		            }		           
		    }
		};

		//資料庫設定
		$this->light_datatables->ci->db->from('activity');
		$this->light_datatables->ci->db->select('*');
		$this->light_datatables->set_querycolumn($order,$like);
		$this->light_datatables->order_by('key','DESC');
		$this->light_datatables->set_output($output,$extra,$functions,true);
		echo $this->light_datatables->get_datatable();
	}

	/**
	 * 取得一筆活動資訊
	 */
	public function getOneActivity(){
		if(isset($_POST['key'])){
			echo $this->activity_management_model->getOneActivity(base64_decode($_POST['key']));
		}
	}

	/**
	 * 編輯活動
	 */
	public function editActivity(){
		if(isset($_POST['activityData'])){
			$postData = json_decode($_POST['activityData'],true);
			$activityData = $this->xss($postData);
			//print_r($activityData);
			$activityData['feedback'] = $postData['feedback'];
			if($this->activity_management_model->editActivity($activityData)){
				echo json_encode(array("status" => 1));
			}else{
				echo json_encode(array("status" => 0));
			}
		}else{
			echo  json_encode(array("status" => 2));
		}
	}

	/**
	 * 刪除一筆會員
	 */
	public function delActivity(){
		if(isset($_POST['key'])){
			$id = $this->security->xss_clean(base64_decode($_POST['key']));
			if($this->activity_management_model->delActivity($id)){
				echo json_encode(array("status" => 1));
			}else{
				echo json_encode(array("status" => 0));
			}
		}
	}

	/**
	 * 確認是否有這個會員
	 */
	public function checkValue(){
		if(isset($_POST['number'])){
			$number = $this->security->xss_clean($_POST['number']);
			if($this->activity_management_model->checkValue($number)){
				echo json_encode(array("status" => 1));
			}else{
				echo json_encode(array("status" => 0));
			}
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	/**
	 * 取得會員未參加過的活動
	 */
	public function getMemberNewActivity(){
		if(isset($_POST['number'])){
			$number = $this->security->xss_clean($_POST['number']);
			echo $this->activity_management_model->getMemberNewActivity($number);
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	/**
	 * 取得會員參加過的活動
	 */
	public function getMemberOldActivity(){
		if(isset($_POST['number'])){
			$number = $this->security->xss_clean($_POST['number']);
			echo $this->activity_management_model->getCheckActivity($number);
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	/**
	 * 簽到
	 */
	public function joinActivity(){
		if(isset($_POST['akey']) && isset($_POST['number'])){
			$checkin = $this->xss($_POST);
			$checkArray = array(
				"a_key" => $checkin['akey'],
				"m_key" => $this->activity_management_model->getMemberKey($checkin['number'])
			);
			if($this->activity_management_model->joinActivity($checkArray)){

				$result = json_decode($this->activity_management_model->getOneActivity($checkin['akey']),true);
				if($result['feedback'] != ""){
					$this->email->from('109stugsa@stugsa.com','109級畢聯會');
					$this->email->to('s'.$checkin['number'].'@stu.edu.tw');
					$this->email->subject("【回饋量表】感謝您參與「{$result['name']}」");
					$this->email->message($this->activity_management_model->getEmailText($result['feedback']));
					if($this->email->send()){
						echo json_encode(array("status" => 1));
					}else{
						echo json_encode(array("status" => 3));
					}
				}else{
					echo json_encode(array("status" => 1));
				}
			}else{
				echo json_encode(array("status" => 0));
			}
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	/**
	 * 取消簽到
	 */
	public function delJoinActivity(){
		if(isset($_POST['akey']) && isset($_POST['number'])){
			$checkin = $this->xss($_POST);
			$checkArray = array(
				"a_key" => $checkin['akey'],
				"m_key" => $this->activity_management_model->getMemberKey($checkin['number'])
			);
			if($this->activity_management_model->delJoinActivity($checkArray)){
				echo json_encode(array("status" => 1));
			}else{
				echo json_encode(array("status" => 0));
			}
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	// /**
	//  * 取消簽到
	//  */
	// public function sendMostMail(){

	// 	$allEmail = $this->activity_management_model->getAllMember();
	// 	//print_r($allEmail);

	// 	$count=1;
	// 	$thisArray = array();

	// 	$this->email->from('108stugsa@stuga.tw','108級畢聯會');
	// 	$this->email->subject("【活動通知】5月15、16日「市在畢得」敬邀參加");
	// 	$this->email->message($this->activity_management_model->getMostEmailText());

	// 	for($i=0;$i<count($allEmail);$i++){

	// 		$thisArray[] = $allEmail[$i];

	// 		if($count%80 == 0){
	// 			$this->email->to($thisArray);
	// 			if($this->email->send()){
	// 				echo json_encode(array("status" => "send".$count));
	// 			}else{
	// 				//print_r($thisArray);
	// 				echo json_encode(array("status" => "send".$count."error"));
	// 			}

	// 			$this->email->clear();
	// 			$this->email->from('108stugsa@stuga.tw','108級畢聯會');
	// 			$this->email->subject("【活動通知】5月15、16日「市在畢得」敬邀參加");
	// 			$this->email->message($this->activity_management_model->getMostEmailText());
	// 			$thisArray = array();
	// 		}else if($count == count($allEmail)){
	// 			$this->email->to($thisArray);
	// 			if($this->email->send()){
	// 				echo json_encode(array("status" => "send".$count));
	// 			}else{
	// 				//print_r($thisArray);
	// 				echo json_encode(array("status" => "send".$count."error"));
	// 			}
	// 			$this->email->clear();

	// 		}
	// 		$count++;
	// 	}
	// 	// $this->email->clear();
	// 	// $this->email->from('108stugsa@stuga.tw','108級畢聯會');
	// 	// //$this->email->to('s'.$checkin['number'].'@stu.edu.tw');
	// 	// $this->email->to('s15115127@stu.edu.tw');
	// 	// $this->email->subject("【活動通知】5月14、15日「市在畢得」敬邀參加");
	// 	// $this->email->message($this->activity_management_model->getMostEmailText());
	// 	// if($this->email->send()){
	// 	// 	echo json_encode(array("status" => "success"));
	// 	// }else{
	// 	// 	echo json_encode(array("status" => 3));
	// 	// }
	// }

	/**
	 * 取得會員參加過的活動
	 */
	public function getChartActivity(){
		if(isset($_POST['key'])){
			$key = $this->security->xss_clean(base64_decode($_POST['key']));
			echo $this->activity_management_model->getChartActivity($key);
		}else{
			echo json_encode(array("status" => 2));
		}
	}


    public function resultDatatable(){
    	$order=array(null,'name','start_time','end_time');
		$like=array('key','name','start_time', 'end_time');
		$buttton = '<button type="button" onclick="unJoinActivity(\'[extra]\')" class="btn btn-outline-primary functions-btn">未參加名冊</button>';
		$output=array($buttton ,'name','start_time' ,'end_time');
		$extra=array('key');
		$functions = function ($value){
		    return base64_encode($value);
		};

		//資料庫設定
		$this->light_datatables->ci->db->from('activity');
		$this->light_datatables->ci->db->select('*');
		$this->light_datatables->set_querycolumn($order,$like);
		$this->light_datatables->order_by('key','DESC');
		$this->light_datatables->set_output($output,$extra,$functions);
		echo $this->light_datatables->get_datatable();
    }

    public function getUnJoinMemberList(){
    	if(isset($_POST['a_key'])){
    		//$this->activity_management_model->getUnJoinMemberList(base64_decode($_POST['a_key']));
			echo $this->activity_management_model->getUnJoinMemberList(base64_decode($_POST['a_key']));
		}else{
			echo json_encode(array("status" => 2));
		}
    }
	
}
