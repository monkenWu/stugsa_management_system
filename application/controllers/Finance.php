<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Finance extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("finance_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		$viewData = $this->viewItem('財務徵信','finance','user');
		$this->load->view("finance_view",$viewData);
	} 

	/**
	 * 取得年分
	 */
	public function getYearSelect(){
		$post = $this->xss($_POST);
		$planData = $this->finance_model->getAllYear();
		$returnJson = array();
		foreach($planData as $key => $row)  {
			array_push($returnJson,array(
						"year" => $row->f_year
					));
        }
        echo json_encode($returnJson);
	}

	/**
	 * 取得月分
	 */
	public function getAllMonth(){
		if(isset($_POST['year'])){
			$post = $this->xss($_POST);
			$planData = $this->finance_model->getAllMonth($post['year']);
			$returnJson = array();
			foreach($planData as $key => $row)  {
				if($this->finance_model->checkMonth($row->f_key)){
					array_push($returnJson,array(
							"key"  => $row->f_key,
							"name" => $row->f_month
							));
				}
            }
            echo json_encode($returnJson);
		}
	}

	/**
	 * 取得報表
	 */
	public function getTable(){
		if(isset($_POST['key'])){
			$post = $this->xss($_POST);
			$tableData = $this->finance_model->getAllTable($post['key']);
			$returnJson = array();
			$returnJson['table'] = array();
			foreach($tableData as $key => $row){
				array_push($returnJson['table'],array(
					"item" => $row->fac_name,
					"content" => $row->fa_content,
					"type" => $row->fa_type,
					"money" => $row->fa_money,
					"date"=>$row->fa_date
					));
            }
            echo json_encode($returnJson);
		}
	}

}
