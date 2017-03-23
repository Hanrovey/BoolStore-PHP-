<?php

/*
订单商品model
*/

defined('ACC')||exit('ACC Denied');
class OGModel extends Model{

	protected $table = 'ordergoods';// 表名
    protected $pk = 'og_id';// 主键

    /*
    把订单的商品写入ordergoods表
    */
    public function addOG($data){
        if ($this->add($data)) {
            $sql = 'update goods set goods_number = goods_number - ' . $data['goods_number'] . ' where goods_id = ' . $data['goods_id'];

            return $this->db->query($sql);// 减少库存
        }

        return false;
    }

}