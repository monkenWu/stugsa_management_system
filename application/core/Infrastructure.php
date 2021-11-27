<?php
date_default_timezone_set("Asia/Taipei");
class Infrastructure extends CI_Controller {
	//使用者menu內容
	private $menu = array('',
				array('key'   => 'home',       'name' => '首頁',     'multi' => false),
				array('key'   => 'calendar',   'name' => '行事曆',   'multi' => false),
				//array('key'   => 'blog',       'name' => 'BLOG',     'multi' => false),
				array('key'   => 'finance',    'name' => '財務徵信',  'multi' => false),
				array('key'   => 'aboutMulti', 'name' => '關於本會',  'multi' => true ,
					  'child' =>  array(array('key' => 'about',   'name' => '本會職能','href'=>true),
					  					array('key' => 'https://www.facebook.com/pg/109STUGSA', 'name' => '聯絡我們' ,'href'=>true))));
	//登入狀態按鈕
	private $menuLogin = array('key'   => 'login','name' => '登入系統', 'multi' => false);
	private $menuSystem = array('key'   => 'management','name' => '進入系統', 'multi' => false);
	private $menuLogout = array('key'   => 'login/logout','name' => '登出', 'multi' => false);

	//管理員MENU內容
	private $systemMenu =  array('',
				array('key'   => 'management',       'name' => '首頁'),
				array('key'   => 'notice_management',   'name' => '公告管理'),
				array('key' => 'calendar_management', 'name' => '行事曆管理'),
				array('key'   => 'finance_management',    'name' => '月報表管理'),
				array('key' => 'member_management', 'name' => '會員管理'),
				array('key' => 'activity_management', 'name' => '活動管理'),
				array('key' => 'lottery_game', 'name' => '抽獎活動')
				//,array('key'   => 'blog_management',   'name' => 'blog管理')
			);

	//0=未登入 1=已登入
	private $login = 0;

	//檔案上傳位置
	//private $uploadAddr = 'C:\xampp\htdocs\stuga\dist\\';
	private $uploadAddr = '/home/acigndrcgj90/public_html/dist/';
	// private $uploadAddr = '/var/www/html/stugsa/dist/';
	public function __construct(){
		parent::__construct();
		session_start();
		header("X-Frame-Options: DENY");
		// if(!((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on')||(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])&&$_SERVER['HTTP_X_FORWARDED_PROTO']=='https'))){
		// 	Header("HTTP/1.1 301 Moved Permanently");
		// 	if(preg_match("/www/i", $_SERVER['SERVER_NAME'])){
		// 	header('Location: https://stuga.tw'.$_SERVER['REQUEST_URI']);
		// 	}else{
		// 	header('Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		// 	}
		// 	exit();
		// }else{
		// 	if(preg_match("/www/i", $_SERVER['SERVER_NAME'])){
		// 	Header("HTTP/1.1 301 Moved Permanently");
		// 	header('Location: https://stuga.tw'.$_SERVER['REQUEST_URI']);
		// 	exit();
		// 	}
		// }
		if(isset($_SESSION['id'])){
			$this->login = 1;
			array_push($this->menu, $this->menuSystem);
			array_push($this->menu, $this->menuLogout);
		}else{
			$this->login = 0;
			array_push($this->menu, $this->menuLogin);
		}

	}

	public function getlogin(){
		return $this->login;
	}

	/**
	 * 替傳入陣列消毒，回傳消毒完成的結果
	 * @param  array
	 * @return array
	 */
	public function xss(array $array){

		foreach ($array as &$value){
			if(is_array($value)){
				$value = $this->xss($value);
			}else{
				$value = $this->security->xss_clean($value);
			}
		}
		
		return $array;
	}

	/**
	 * 回傳View初始化內容
	 * @param  String
	 * @return array
	 */
	public function viewItem($title,$key,$type){
		$data['title'] = $title;
		$data['menu'] = $this->getMenu($key,$type);
		return $data;
	}

	/**
	 * 回傳menu內容
	 * @param  String
	 * @return array
	 */
	public function getMenu($key,$type){
		if($type == "user"){
			$this->menu[0] = $key;
			return $this->menu;
		}else if ($type == "system"){
			$this->systemMenu[0] = $key;
			return $this->systemMenu;
		}
		
	}

	/**
	 * 回傳隨機加密字串
	 * @return String
	 */
	public function getNewToken(){
        $key = '';
        $word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($word);
        for ($i = 0; $i < 20; $i++) {
            $key .= $word[rand() % $len];
        }
        return base64_encode($key);
    }

    /**
	 * 回傳圖片位置
	 * @param  String
	 * @return String
	 */
	public function getUploaadAddr($type,$item){
        //return $this->uploadAddr.$type.'\\'.$item.'\\';
        return $this->uploadAddr.$type.'/'.$item.'/';
    }

}

?>