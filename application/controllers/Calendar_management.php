<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Calendar_management extends Infrastructure {

	/**
	 * 建構載入需要預先執行的項目
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model("calendar_management_model","",TRUE);
	}

	/**
	 * 直接進入頁面
	 */
	public function index() {
		if($this->getlogin() == 1){
			$viewData = $this->viewItem('系統管理 - 行事曆管理','calendar_management','system');
			$this->load->view("calendar_management_view",$viewData);
		}else{
			redirect("home");
		}
	} 

	/**
	 * 取得所有事件
	 */
	public function getAllEvents(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1 || $this->getlogin()==4){
			$data = array();
			$start = strtotime($post['start']);
			$end = strtotime($post['end']);
			$fetch_data = $this->calendar_management_model->getAllEvents($start,$end);
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
		if($this->getlogin()==1){
			$row = $this->calendar_management_model->getEvents($post['id']);

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
		        'content' => $row->content,
				'color' => $row->color //事件的背景色
			);
        	echo json_encode($data);
		}
	}

	/**
	 * 新增一筆事件
	 */
	public function addEvents(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$title = $post['title'];//事件内容

			$isallday = $post['isallday'];//是否是全天事件

			if(isset($post['isend'])){
				$isend = $post['isend'];//是否有结束时间
			}else{
				$isend = '';
			}

			$startdate = trim($post['startdate']);//开始日期
			$enddate = trim($post['enddate']);//结束日期

			$s_time = $post['starttime'].':00';//开始时间

			if(isset($post['endtime'])){
				$e_time = $post['endtime'].':00';//结束时间
			}else{
				$e_time = '';
			}
		
			$content = $post['content'];

			if($isallday==1 && $isend==1){
				$starttime = strtotime($startdate);
				$endtime = strtotime($enddate);
				//echo $endtime;
				$endtime += 86400 ;
			}elseif($isallday==1 && $isend==""){
				$starttime = strtotime($startdate);
				$endtime = strtotime($startdate);
			}elseif($isallday=="" && $isend==1){
				$starttime = strtotime($startdate.' '.$s_time);
				$endtime = strtotime($enddate.' '.$e_time);
			}else{
				$starttime = strtotime($startdate.' '.$s_time);
				$endtime = strtotime($startdate.' '.$s_time);
			}

			$colors = array();
			$key = array_rand($colors);
			$color = $colors[$key];
			$isallday = $isallday?1:0;

			$this->calendar_management_model->addEvents($title,$starttime,$endtime,$isallday,$content,$color);
		}
	}

	/**
	 * 修改一筆事件
	 */
	public function editEvents(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1 || $this->getlogin()==4){
			$title = $post['title'];//事件内容
			$isallday = $post['isallday'];//是否是全天事件

			if(isset($post['isend'])){
				$isend = $post['isend'];//是否有结束时间
			}else{
				$isend = '';
			}

			$startdate = trim($post['startdate']);//开始日期
			$enddate = trim($post['enddate']);//结束日期

			$s_time = $post['starttime'].':00';//开始时间

			if(isset($post['endtime'])){
				$e_time = $post['endtime'].':00';//结束时间
			}else{
				$e_time = '';
			}
		
			$content = $post['content'];

			if($isallday==1 && $isend==1){
				$starttime = strtotime($startdate);
				$endtime = strtotime($enddate);
				$endtime += 86400 ;
			}elseif($isallday==1 && $isend==""){
				$starttime = strtotime($startdate);
				$endtime = strtotime($startdate);
			}elseif($isallday=="" && $isend==1){
				$starttime = strtotime($startdate.' '.$s_time);
				$endtime = strtotime($enddate.' '.$e_time);
			}else{
				$starttime = strtotime($startdate.' '.$s_time);
				$endtime = strtotime($startdate.' '.$s_time);
			}

			$color = "";
			$isallday = $isallday?1:0;

			$this->calendar_management_model->updateEvents($post['pca_key'],$title,$starttime,$endtime,$isallday,$content,$color);
		}
	}

	/**
	 * 刪除一筆事件
	 */
	public function deleteEvent(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$this->calendar_management_model->deleteEvents($post['editKey']);
		}
	}

	/**
	 * 拖移一筆事件
	 */
	public function dropEvents(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){

			$isallday = $post['isallDay'] == 'true' ? true:  false;//是否是全天事件

			$isend = $post['isend'] == 'true'? true : false ;

			$startdate = trim($post['startdate']);//开始日期
			$s_time = $post['starttime'].':00';//开始时间

			if($isend){
				$enddate = trim($post['enddate']);//结束日期
				$e_time = $post['endtime'].':00';//结束时间
			}else{
				$enddate = trim($post['startdate']);//结束日期
				$e_time = '';
			}
		
			if($isallday && $isend){
				$starttime = strtotime($startdate);
				$endtime = strtotime($enddate);
			}elseif($isallday && !$isend){
				$starttime = strtotime($startdate);
				$endtime = strtotime($startdate.' '.$s_time);
			}elseif(!$isallday && $isend){
				$starttime = strtotime($startdate.' '.$s_time);
				$endtime = strtotime($enddate.' '.$e_time);
			}else{
				$starttime = strtotime($startdate.' '.$s_time);
				$endtime = strtotime($startdate.' '.$s_time);
			}

			echo $this->calendar_management_model->dropEvents($post['id'],$starttime,$endtime);
		}
	}

	/**
	 * 改變事件長度
	 */
	public function resizeEvents(){
		$post = $this->xss($_POST);
		if($this->getlogin()==1){
			$enddate = trim($post['enddate']);
			$e_time = $post['endtime'].':00';
			$endtime = strtotime($enddate.' '.$e_time);
			echo $this->calendar_management_model->resizeEvents($post['id'],$endtime);
		}else{
			header("Location: " . base_url());
		}
	}





}
