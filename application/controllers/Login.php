<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Login extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("login_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		
		if($this->getlogin() == 1){
			redirect("management");
		}else{
			$data['token'] = $this->getNewToken();
			$_SESSION['token'] = $data['token'];
			$this->load->view("login_view",$data);
		}
	} 

	/**
	 * 登入
	 * 0=無帳號密碼 1=登入成功 2=傳入值異常 3=請輸入帳號 4=請輸入密碼 5=偽裝請求
	 */
	public function login(){
		$post = $this->xss($_POST);
		//偽裝請求判斷
		if(!isset($post['token'])){
			echo 5;
			exit;
		}
		if($post['token'] != $_SESSION['token']){
			echo 5;
			exit;
		}

		//登入判斷
		if(isset($post['id'])&&isset($post['pd'])){
			if($post['id'] == ""){
				echo 3;
			}else if($post['pd'] == ""){
				echo 4;
			}else{
				$login = $this->login_model->checkLogin($post['id'],$post['pd']);
				if($login == ""){
					echo 0;
				}else{
					$_SESSION['id']=$login;
					echo 1;
				}
			}
		}else{
			echo 2;
		}
	}

	public function logout(){
		session_destroy();
		redirect("home");
	}
}
