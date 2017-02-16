<?php

/*
测试model，用于栏目添加。
*/

defined('ACC')||exit('ACC Denied');
class GoodsModel extends Model{

	protected $table = 'goods';// 表名
    protected $pk = 'goods_id';// 主键

    protected $fields = array('goods_id','goods_sn','category_id','brand_id','goods_name','shop_price','market_price','goods_number','click_count','goods_weight','goods_brief','goods_desc','thumb_img','goods_img','ori_img','is_on_sale','is_delete','is_best','is_new','is_hot','add_time','last_update');
	    
    protected $_auto = array(
                        array('is_hot','value',0),
                        array('is_new','value',0),
                        array('is_best','value',0),
                        array('add_time','function','time')
                        );    

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