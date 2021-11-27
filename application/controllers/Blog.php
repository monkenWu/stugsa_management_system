<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Blog extends Infrastructure {

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
		$viewData = $this->viewItem('BLOG','blog','user');
		$this->load->view("blog_view",$viewData);
	} 

	/**
	 * 文章編號
	 */
	public function article($str = "") {
		$article = $this->security->xss_clean($str);
		$viewData = $this->viewItem('BLOG','blog');
		$data['articleTitle'] = "文章文章文章";
		$data['articleText'] = "內容內容內容";
		$this->load->view("blog_view",$viewData);
	} 



}
