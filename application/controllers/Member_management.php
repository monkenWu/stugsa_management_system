<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Member_management extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("member_management_model","",TRUE);
		$this->load->library('light_datatables');
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 會員管理','member_management','system');
			$this->load->view("member_management_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 直接進入頁面
	 */
	public function check() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 會員名單確認','member_management','system');
			$this->load->view("member_management_edit_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 新增會員
	 */
	public function addMember(){
		if(isset($_POST['studentData']) || isset($_POST['classData'])){
			$classData = json_decode($_POST['classData'],true);
			$classData[0]['value'] = $value = $this->security->xss_clean($classData[0]['value']);
			if($this->member_management_model->checkDepartment($classData)){
				echo 0;
			}else{
				$this->member_management_model->addMember($classData ,$_POST['studentData']);
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
		$order=array(null,'department.`name`','system.`name`','class.`name`','member.`studentid`');
		$like=array('department.`name`','system.`name`','class.`name`','member.`studentid`');
		$buttton = '<button type="button" onclick="delMember(\'[extra]\')" class="btn btn-outline-danger functions-btn">刪除</button>';
		$output=array($buttton,'dname','sname','cname','studentid');
		$extra=array('key');
		$functions = function ($value){
			return base64_encode($value);
		};
		//資料庫設定
		$this->light_datatables->ci->db->from('member');
		$this->light_datatables->ci->db->select('member.`key` ,department.`name` as dname ,system.`name` as sname ,class.`name` as cname ,member.studentid');
		$this->light_datatables->ci->db->join('department', 'member.d_key = department.`key`');
		$this->light_datatables->ci->db->join('system', 'department.`system_key` = system.`key`');
		$this->light_datatables->ci->db->join('class', 'department.`class_key` = class.`key`');

		$this->light_datatables->set_querycolumn($order,$like);
		$this->light_datatables->order_by('department.`name`','DESC');
		$this->light_datatables->set_output($output,$extra,$functions);
		echo $this->light_datatables->get_datatable();
	}

	/**
	 * 刪除一筆會員
	 */
	public function delMember(){
		if(isset($_POST['id'])){
			$id = $this->security->xss_clean(base64_decode($_POST['id']));
			if($this->member_management_model->delMember($id)){
				echo 1;
			}else{
				echo 0;
			}
		}
	}

	/**
	 * 刪除一筆會員
	 */
	public function getEditSelect(){

		if(isset($_POST['classValue']) && isset($_POST['systemValue'])){
			echo $this->member_management_model->departmentSearch($_POST['classValue'] , $_POST['systemValue']);
		}
	}

	/**
	 * 新增會員
	 */
	public function editMember(){

		if(isset($_POST['studentData']) || isset($_POST['classKey'])){
			$result = $this->member_management_model->editMember($_POST['classKey'],$_POST['studentData']);
			$returnData = array("status" => 1,"noticeText" => "新增成功！");
			if(gettype($result) == "string"){
				$returnData['status'] = 0;
				$returnData['noticeText'] = $result;
			}
			echo json_encode($returnData);
		}else{
			echo 2;
		}
	}

	/**
	 * 取得全部會員
	 */
	public function getClassAllMember(){
		if(isset($_POST['d_key'])){
			$result = $this->member_management_model->getClassAllMember($_POST['d_key']);
			echo json_encode($result);
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	public function checkSuccess(){
		if(isset($_POST['d_key'])){
			$result = $this->member_management_model->editMember($_POST['d_key'],$_POST['studentData']);
			$returnData = array("status" => 1);
			if(gettype($result) == "string"){
				$returnData['status'] = 0;
				$returnData['noticeText'] = $result;
			}else{
				$result = $this->member_management_model->checkSuccess($_POST['d_key']);
			}
			echo json_encode($returnData);
		}else{
			echo json_encode(array("status" => 2));
		}
	}

	public function getListHistory(){
		if(isset($_POST['d_key'])){
			$result = $this->member_management_model->getListHistory($_POST['d_key']);
			echo json_encode($result);
		}else{
			echo json_encode(array("status" => 2));
		}
	}


	


}
