<?php

/*
测试model，讲解model基本概念，以前台登录和后台登录为例子。
*/

/**
* 
*/
class TestModel {
	
	protected $table = 'test';
	protected $db = NULL;

	function __construct(){
		$this->db = mysql::getIns();
	}


	// 用户注册的方法
	public function register($data){
		return $this->db->autoExecute($this->table,$data,'insert');
	}
}