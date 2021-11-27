<?php

class Finance_management_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    /**
	 * 判斷目前報表狀況
	 */
    function getType(){
		$this->db->from("finance");
		$this->db->where("f_type" , 2);
		$this->db->order_by("f_year", "DESC");
		$this->db->order_by("f_month", "DESC"); 
		$query = $this->db->get();

		//0=初次使用系統
		if($query->num_rows() == 0){
			return 0;
		}

		$orderFc_key = $query->row()->f_key;
		$this->db->from("finance_account");
		$this->db->where("f_key" , $orderFc_key);
		$faQuery = $this->db->get();
		if($faQuery->num_rows() == 0){
			$this->db->from("finance_temporary");
			$this->db->where("f_key" , $orderFc_key);
			$ftQuery = $this->db->get();
			if($ftQuery->num_rows() == 0){
				//3=這個月報表已開帳未撰寫
				return 3;
			}else{
				//4=這個月報表已開帳有暫存未完成
				return 4;
			}
		}

		$orderF_month = $query->row()->f_month;
		if($orderF_month == 12){
			//1=前一年度報表已完成
			return 1;
		}else{
			//2=前一月份報表已完成
			return 2;
		}
	}

	 /**
	 * 取得年份資料
	 */
	function getYearContent(){
		$this->db->from("finance");
		$this->db->where("f_type" , 2);
		$this->db->order_by("f_year", "DESC");
		$this->db->order_by("f_month", "DESC"); 
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 取得內容資料
	 */
	function getContent(){
		$this->db->from("finance");
		$this->db->where("f_type" , 2);
		$this->db->order_by("f_year", "DESC");
		$this->db->order_by("f_month", "DESC"); 
		$query = $this->db->get();
		if($query->num_rows()==1){
			return 0;
		}
		$f_key = $query->row(1)->f_key;
		$this->db->from("finance_account");
		$this->db->where("f_key" , $f_key);
		$query = $this->db->get();

		$count = 0;

		foreach ($query->result() as $row){
			if($row->fa_type == 0){
				$count += $row->fa_money;
			}else{
				$count -= $row->fa_money;
			}
	   	}
	   	return $count;
	}

	/**
	 * 報表開帳
	 */
	function billing(){
		$type = $this->getType();
		if($type == 0){
			$date = new DateTime("now");
			$date->modify("-1911 year");
			$fc_year = ltrim($date->format("Y"),"0");
			$this->db->set('f_type', 2);
			$this->db->set('f_year', $fc_year);
			$this->db->set('f_month', 10);
			$this->db->insert('finance');
		}else if($type == 1){
			$this->db->from("finance");
			$this->db->where("f_type" , 2);
			$this->db->order_by("f_year", "DESC");
			$this->db->order_by("f_month", "DESC"); 
			$query = $this->db->get();
			$f_year = $query->row()->f_year;

			$this->db->set('f_type', 2);
			$this->db->set('f_year', ($f_year+1));
			$this->db->set('f_month', 1);
			$this->db->insert('finance');
		}else if($type == 2){
			$this->db->from("finance");
			$this->db->where("f_type" , 2);
			$this->db->order_by("f_year", "DESC");
			$this->db->order_by("f_month", "DESC"); 
			$query = $this->db->get();
			$f_year = $query->row()->f_year;
			$f_month = $query->row()->f_month;

			$this->db->set('f_type', 2);
			$this->db->set('f_year', $f_year);
			$this->db->set('f_month', ($f_month+1));
			$this->db->insert('finance');
		}
	}

	/**
	 * 取得會計項目
	 */
	function getAllItem(){
		$this->db->from("finance_account_class");
		$query = $this->db->get();
		if($query->num_rows() == 0){
			$this->db->set('fac_name', "請編輯新增會計項目");
			$this->db->insert('finance_account_class');
		}
		$this->db->from("finance_account_class");
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * 新增會計項目
	 */
	function addItem(){
		$this->db->set('fac_name', "請編輯新增的項目");
		$this->db->insert('finance_account_class');
		return $this->db->insert_id();
	}

	/**
	 * 修改會計項目
	 */
	function editItem($fac_key,$fac_name){
		$data = array(
				'fac_name' => $fac_name
            );
		$this->db->where('fac_key', $fac_key);
		$this->db->update('finance_account_class', $data);
	}

	/**
	 * 移除會計項目
	 */
	function delItem($fac_key){
		$this->db->from("finance_account");
		$this->db->where("fac_key" , $fac_key);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return 0;
		}
		$this->db->where('fac_key', $fac_key);
		$this->db->delete('finance_account_class');
		return 1;
	}

	/**
	 * 取得目前月份主鍵
	 */
	function getTopFkey(){
		$this->db->from("finance");
		$this->db->where("f_type" , 2);
		$this->db->order_by("f_year", "DESC");
		$this->db->order_by("f_month", "DESC"); 
		$query = $this->db->get();
		return $query->row()->f_key;
	}

	/**
	 * 新增全新的帳目資料
	 */
	function addNewFinance($f_key,$content){
		$this->db->where('f_key', $f_key);
		$this->db->delete('finance_temporary');

		for($i=0;$i<count($content);$i++){
			$this->db->set('f_key', $f_key);
			$this->db->set('fa_date', $content[$i][0]);
			$this->db->set('fac_key', $content[$i][1]);
			$this->db->set('fa_content', $content[$i][2]);
			$this->db->set('fa_type', $content[$i][3]);
			$this->db->set('fa_money', $content[$i][4]);
			$this->db->insert('finance_account');
		}
	}

	/**
	 * 寫入暫存帳目內容
	 */
	function temporaryFinance($f_key,$content){
		$this->db->where('f_key', $f_key);
		$this->db->delete('finance_temporary');

		for($i=0;$i<count($content);$i++){
			$this->db->set('f_key', $f_key);
			$this->db->set('ft_date', $content[$i][0]);
			$this->db->set('fac_key', $content[$i][1]);
			$this->db->set('ft_content', $content[$i][2]);
			$this->db->set('ft_type', $content[$i][3]);
			$this->db->set('ft_money', $content[$i][4]);
			$this->db->insert('finance_temporary');
		}
	}

	/**
	 * 取得暫存帳目內容
	 */
	function getTemporaryContent(){
		$f_key = $this->getYearContent()->f_key;
		$this->db->from("finance_temporary");
		$this->db->join("finance_account_class","finance_temporary.fac_key = finance_account_class.fac_key","left");
		$this->db->where("f_key" , $f_key);
		$this->db->order_by("ft_key", "ASC");
		$query = $this->db->get();
		return $query->result();
	}

}
