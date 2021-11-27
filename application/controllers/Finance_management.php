<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Finance_management extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("finance_management_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 月報表撰寫','finance_management','system');
			$this->load->view("finance_management_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 直接進入頁面
	 */
	public function add() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 月報表撰寫','finance_management','system');
			$this->load->view("finance_management_add_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 判斷目前報表狀況
	 */
	public function checkYear(){
		//$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$type = $this->finance_management_model->getType();
			$returnJson = array();
			$returnJson["type"] = $type;
			if($type == 3){
				$content = $this->finance_management_model->getYearContent();
				$returnJson["key"] = $content->f_key;
				$returnJson["year"] = $content->f_year;
				$returnJson["month"] = $content->f_month;
				$returnJson["count"] = $this->finance_management_model->getContent();;
			}else if($type == 4){
				$content = $this->finance_management_model->getYearContent();
				$returnJson["key"] = $content->f_key;
				$returnJson["year"] = $content->f_year;
				$returnJson["month"] = $content->f_month;
				$returnJson["count"] = $this->finance_management_model->getContent();;
			}
            echo json_encode($returnJson);
		}else{
			header("Location: " . base_url());
		}
	}

	/**
	 * 報表開帳
	 */
	public function billing(){
		//$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$type = $this->finance_management_model->getType();
			$returnJson = array();
			if($type == 3){
				$returnJson["type"] = 1;
			}else{
				$this->finance_management_model->billing();
				$returnJson["type"] = 0;
			}
            echo json_encode($returnJson);
		}
	}

	/**
	 * 取得會計項目
	 */
	public function getAllItem(){
		//$post = $this->xss($_POST);
		if($this->getlogin()==1 || $this->getlogin()==4){
			$classData = $this->finance_management_model->getAllItem();
			$returnJson = array();
			foreach($classData as $key => $row)  {
				array_push($returnJson,array(
							"key" => $row->fac_key,
							"name" => $row->fac_name,
							));
            }
            echo json_encode($returnJson);
		}
	}

	/**
	 * 新增會計項目
	 */
	public function addItem(){
		if($this->getlogin()==1){
			echo $this->finance_management_model->addItem();
		}else{
			header("Location: " . base_url());
		}
	}

	/**
	 * 修改會計項目
	 */
	public function editItem(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$this->finance_management_model->editItem($post['key'],$post['name']);
		}else{
			header("Location: " . base_url());
		}
	}

	/**
	 * 移除會計項目
	 */
	public function delItem(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){
			echo $this->finance_management_model->delItem($post['key']);
		}else{
			header("Location: " . base_url());
		}
	}

	/**
	 * 寫入暫存帳目
	 */
	public function temporaryThisFinance(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1 || $this->getlogin()==4){
			$f_key = $this->finance_management_model->getTopFkey();
			$content = json_decode($post['content'], true);
			echo $this->finance_management_model->temporaryFinance($f_key,$content);
		}
	}

	/**
	 * 取得暫存帳目
	 */
	public function getTemporaryContent(){
		if($this->getlogin()==1 ){
			$tableData = $this->finance_management_model->getTemporaryContent();
			$returnJson = array();
			$returnJson['table'] = array();
			foreach($tableData as $key => $row){
				array_push($returnJson['table'],array(
					"item" => $row->fac_name,
					"content" => $row->ft_content,
					"type" => $row->ft_type,
					"money" => $row->ft_money,
					"date"=>$row->ft_date
				));
            }
            
            echo json_encode($returnJson);
		}
	}

	/**
	 * 完成月報表
	 */
	public function addNewFinance(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$f_key = $this->finance_management_model->getTopFkey();
			$content = json_decode($post['content'], true);
			echo $this->finance_management_model->addNewFinance($f_key,$content);
		}
	}

}
