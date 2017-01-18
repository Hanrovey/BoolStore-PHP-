<?php

/*
测试model，用于栏目添加。
*/

defined('ACC')||exit('ACC Denied');
class GoodsModel extends Model{

	protected $table = 'goods';
    protected $pk = 'goods_id';
	    
    public function getGoods() {
        $sql = 'select * from goods where is_delete=0';
        return $this->db->getAll($sql);
    }
}