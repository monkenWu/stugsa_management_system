<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Home extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('light_datatables');
		$this->load->model("home_model","",TRUE);
		//$this->load->model("home_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		$viewData = $this->viewItem('首頁','home','user');
		$this->load->view("home_view",$viewData);
	
	//$this->load->view("home_view",$data);
	} 

	/**
	 * 取得公告內容
	 */
	public function getNotice(){
		$select=array('key','title','time');
		$order=array('title','time');
		$like=array('title','time');
		$title = '<div style="width:100%;height:100%;" onclick="viewNotice(\'[extra]\')">[extra]</div>';
		$output=array($title,'time');
		$extra=array('key','title');
		$functions = function ($value,$case){
			switch ($case){
		        case 1:
		        	return base64_encode($value);
		        case 2:
		            return $value;
		    }
		};
		$this->light_datatables->ci->db->from('notice');
		$this->light_datatables->set_querycolumn($order,$like);
		$this->light_datatables->order_by('time','DESC');
		$this->light_datatables->set_output($output,$extra,$functions,true);
		echo $this->light_datatables->get_datatable();
	}

	/**
	 * 取得一筆公告
	 */
	public function viewNotice(){
		if(isset($_POST['id'])){
			$id = $this->security->xss_clean(base64_decode($_POST['id']));
			echo $this->home_model->getNotice($id);
		}
	}

}
