<?php

/*
测试model，用于栏目添加。
*/

/**
* 
*/
class CategoryModel extends Model{
	
    protected $table = 'category'; // 是model所控制的表

	// 添加数据
	public function add($data){
		return $this->db->autoExecute($this->table,$data,'insert');
	}
}