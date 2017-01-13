<?php

/*
测试model，讲解model基本概念，以前台登录和后台登录为例子。
*/

/**
* 
*/
class TestModel extends Model{
	
    protected $table = 'test'; // 是model所控制的表

	// 用户注册的方法
	public function register($data){
		return $this->db->autoExecute($this->table,$data,'insert');
	}

	public function select(){
		return $this->db->getAll(' select * from ' . $this->table);
	}
}