<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Contact extends Infrastructure {

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
		$viewData = $this->viewItem('聯絡我們','aboutMulti','user');
		$this->load->view("contact_view",$viewData);
	} 

}
