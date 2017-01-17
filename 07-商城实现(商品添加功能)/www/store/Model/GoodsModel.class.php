<?php

/*
测试model，用于栏目添加。
*/

defined('ACC')||exit('ACC Denied');
class GoodsModel extends Model{

	protected $table = 'goods';

    /*
        parm array $data
        return bool
    */
	public function add($data){
		return $this->db->autoExecute($this->table,$data);
	}

}