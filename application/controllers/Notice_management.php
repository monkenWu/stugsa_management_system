<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Notice_management extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("notice_management_model","",TRUE);
		$this->load->library('light_datatables');
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 公告管理','notice_management','system');
			$this->load->view("notice_management_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 公告的Datatable
	 */
	public function datatable(){
		$order=array(null,'title','time');
		$like=array('title','time');
		$buttton = '<button type="button" onclick="openNotice(\'[extra]\')" class="btn btn-outline-success functions-btn">查閱</button><button type="button" onclick="editNotice(\'[extra]\')" class="btn btn-outline-info functions-btn">修改</button><button type="button" onclick="delNotice(\'[extra]\')" class="btn btn-outline-danger functions-btn">刪除</button>';
		$output=array($buttton,'title','time');
		$extra=array('key','key','key');
		$functions = function ($value){
			return base64_encode($value);
		};
		$this->light_datatables->ci->db->from('notice');
		$this->light_datatables->set_querycolumn($order,$like);
		$this->light_datatables->order_by('time','DESC');
		$this->light_datatables->set_output($output,$extra,$functions);
		echo $this->light_datatables->get_datatable();
	}

	/**
	 * 上傳圖片
	 */
	public function uploadPicture(){
		$name = md5(rand(0, 200));
        $ext = explode('.',$_FILES['file']['name']);
        $filename = $name.'.'.$ext[1];
        $destination = $this->getUploaadAddr('img','notice').$filename;
        $location =  $_FILES["file"]["tmp_name"];
        move_uploaded_file($location,$destination);
        echo base_url('dist/img/notice/').$filename;
	}

	/**
	 * 新增一筆公告
	 */
	public function addNotice(){
		if(isset($_POST['content']) || isset($_POST['title'])){
			$title = $this->security->xss_clean($_POST['title']);
			if($title=="" || $_POST['content']==""){
				echo 0;
			}else{
				if($this->notice_management_model->addNotice($title,$_POST['content'])){
					echo 1;
				}else{
					echo 2;
				}
			}
		}else{
			echo 2;
		}
	}

	/**
	 * 取得一筆公告
	 */
	public function viewNotice(){
		if(isset($_POST['id'])){
			$id = $this->security->xss_clean(base64_decode($_POST['id']));
			echo $this->notice_management_model->getNotice($id);
		}
	}

	/**
	 * 修改一筆公告
	 */
	public function editNotice(){
		if(isset($_POST['id']) || isset($_POST['content']) || isset($_POST['title'])){
			$title = $this->security->xss_clean($_POST['title']);
			$id = $this->security->xss_clean(base64_decode($_POST['id']));
			if($title=="" || $_POST['content']==""){
				echo 0;
			}else{
				if($this->notice_management_model->editNotice($title,$_POST['content'],$id)){
					echo 1;
				}else{
					echo 2;
				}
			}
		}else{
			echo 2;
		}
	}

	/**
	 * 修改一筆公告
	 */
	public function delNotice(){
		if(isset($_POST['id'])){
			$id = $this->security->xss_clean(base64_decode($_POST['id']));
			if($this->notice_management_model->delNotice($id)){
				echo 1;
			}else{
				echo 0;
			}
		}
	}



	

}
