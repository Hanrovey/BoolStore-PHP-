<?php

/*
测试model，用于栏目添加。
*/

defined('ACC')||exit('ACC Denied');
class GoodsModel extends Model{

	protected $table = 'goods';
    protected $pk = 'goods_id';
	    
	// 获取商品    
    public function getGoods() {
        $sql = 'select * from goods where is_delete=0';
        return $this->db->getAll($sql);
    }

	// 获取商品    
    public function getTrash() {
        $sql = 'select * from goods where is_delete=1';
        return $this->db->getAll($sql);
    }


    /*
		把商品放入回收站，即is_delete改为1
		param : int $id
		return : bool
    */
    public function trash($id){
    	return $this->update(array('is_delete'=>1),$id);
    }

}