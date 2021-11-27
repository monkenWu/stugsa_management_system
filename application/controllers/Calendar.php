<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Calendar extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("calendar_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		$viewData = $this->viewItem('行事曆','calendar','user');
		$this->load->view("calendar_view",$viewData);
	}

	/**
	 * 取得所有事件
	 */
	public function getAllEvents(){
		$post = $this->xss($_POST);
		if(isset($_POST['start'])){
			$data = array();
			$start = strtotime($post['start']);
			$end = strtotime($post['end']);
			$fetch_data = $this->calendar_model->getAllEvents($start,$end);
			foreach($fetch_data as $key => $row){
				$allday = $row->allday;
				$is_allday = $allday==1?true:false;
				$data[] = array(
					'id' => $row->key,//事件id
					'title' => $row->title,//事件标题
					'start' => date('Y-m-d H:i',$row->start_time),//事件开始时间
					'end' => date('Y-m-d H:i',$row->end_time),//结束时间
					'allDay' => $is_allday, //是否为全天事件
					'color' => $row->color //事件的背景色
				);
				$contentData[$row->key] = array(
					'content' =>$row->content
				);
        	}
        	echo !isset($_POST['content'])?json_encode($data):json_encode($contentData);
		}
	}

	/**
	 * 取得一筆事件
	 */
	public function getEvents(){
		$post = $this->xss($_POST);
		if(isset($_POST['id'])){
			$row = $this->calendar_model->getEvents($post['id']);

			$allday = $row->allday;
			$checkAll = $allday==1?true:false;

			$checkOver = $row->start_time!=$row->end_time?true:false;

			if($row->end_time != $row->start_time){
				if(date('Y-m-d',($row->start_time)) == date('Y-m-d',($row->end_time))){
					$end = date('Y-m-d',($row->end_time));
					$endMin = date('H:i',($row->end_time));
				}else{
					$end = date('Y-m-d',($row->end_time-86400));
					$endMin = date('H:i',($row->end_time-86400));
				}
			}else{
				$end = date('Y-m-d',($row->end_time));
				$endMin = date('H:i',($row->end_time));
			}

			$data = array(
				'title' => $row->title,//事件标题
				'start' => date('Y-m-d',$row->start_time),//事件开始时间
				'startMin' =>date('H:i',$row->start_time),
				'end' => $end,
				'endMin' =>$endMin,
		        'checkAll' => $checkAll,
		        'checkOver' => $checkOver,
		        'content' => nl2br($row->content),
				'color' => $row->color //事件的背景色
			);
        	echo json_encode($data);
		}
	}


}
