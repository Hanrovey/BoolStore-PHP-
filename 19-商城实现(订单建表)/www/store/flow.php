<?php

define('ACC',true);
require('./include/init.php');


// 设置一个动作参数，判断用户想干嘛，比如下订单/写地址/提交/清空购物车
$act = isset($_GET['act'])?$_GET['act']:'buy';


$cart = CartTool::getCart();// 获取购物车实例
$goods = new GoodsModel();

if ($act == 'buy') {//商品加入购物车
	$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;
	$num = isset($_GET['num'])?$_GET['num']+0:1;

	if ($goods_id) {//存在，把商品加入购物车
		$g = $goods->find($goods_id);
		if (!empty($g)) {// 有此商品
			$cart->addItem($goods_id,$g['goods_name'],$g['shop_price'],$num);
		}
	}
 
		print_r($g);

		$items = $cart->all();

		if (empty($items)) {// 如果购物车为空，返回首页
			header('location: index.php');
			exit();
		}


		// 把购物车里的商品详细信息取出来
		$items = $goods->getCartGoods($items);

		$total = $cart->getPrice(); //获取购物车中的商品总价格
	    $market_total = 0.0;
	    foreach($items as $v) {
	        $market_total += $v['market_price'] * $v['num'];
	    }

	    $discount = $market_total - $total;
	    $rate = round(100 * $discount/$total,2);

		include(__ROOT__ . 'view/front/jiesuan.html');

} else if($act == 'clear') {

    $cart->clear();
    $msg = '购物车已清空';
    include(__ROOT__ . 'view/front/msg.html');  

} else if ($act = 'tijiao') {
	
	// 把购物车里的商品详细信息取出来
	$items = $goods->getCartGoods($items);

	$total = $cart->getPrice(); //获取购物车中的商品总价格
    $market_total = 0.0;
    foreach($items as $v) {
        $market_total += $v['market_price'] * $v['num'];
    }

    $discount = $market_total - $total;
    $rate = round(100 * $discount/$total,2);

    include(__ROOT__ . 'view/front/tijiao.html');  

}
