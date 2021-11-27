<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Lottery_game extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("lottery_game_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 抽獎活動','lottery_game','system');
			$this->load->view("lottery_game_view",$viewData);
		}else{
			redirect("home");
		}
	}

	public function getAllUnMember(){
		echo $this->lottery_game_model->getAllUnJoin(7);
	}

}
