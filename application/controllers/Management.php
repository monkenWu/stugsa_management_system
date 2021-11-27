<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Management extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		//$this->load->model("home_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 首頁','management','system');
			$this->load->view("management_view",$viewData);
		}else{
			redirect("home");
		}
	} 

}
