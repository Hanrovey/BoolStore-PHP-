<?php

/*
订单model
*/

defined('ACC')||exit('ACC Denied');
class OIModel extends Model{

	protected $table = 'orderinfo';// 表名
    protected $pk = 'order_id';// 主键

    protected $fields = array('order_id','order_sn','zone','user_id','username','address','zipcode','reciver','email','tel','mobile','building','best_time','add_time','order_amount','pay');
	    
    protected $_auto = array(
                        array('add_time','function','time')
                        );    

    protected $_valid = array(
                            array('reciver',1,'收货人不能为空','require'),
                            array('email',1,'email非法','email'),
                            array('pay',1,'必须先选择支付方式','in','4,5')// 代表在线支付和到付
    );

    // 生成随机订单号
    public function orderSn(){
        $sn = 'OI' . date('Ymd') . mt_rand(10000,99999);
        $sql = 'select count(*) from ' . $this->table . ' where order_sn = ' . "'$sn'";
        return $this->db->getOne($sql) ? $this->orderSn() : $sn; 
    }

    // 删除订单
    public function invoke($order_id){
        $this->delete($order_id);// 先删除订单

        $sql = 'delete from ordergoods where order_id = ' . $order_id;// 再删除订单对应的商品

        return $this->db->query($sql);
    }

}