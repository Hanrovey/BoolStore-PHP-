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

}