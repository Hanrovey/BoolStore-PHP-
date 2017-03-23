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
 
		// print_r($g);

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

} else if ($act == 'tijiao') {

	// 把购物车里的商品详细信息取出来

	$items = $cart->all();

	$items = $goods->getCartGoods($items);

	$total = $cart->getPrice(); //获取购物车中的商品总价格
    $market_total = 0.0;
    foreach($items as $v) {
        $market_total += $v['market_price'] * $v['num'];
    }

    $discount = $market_total - $total;
    $rate = round(100 * $discount/$total,2);

    include(__ROOT__ . 'view/front/tijiao.html');  

}else if ($act == 'done') {
	// print_r($_POST);

	$OI = new OIModel();
	if (!$OI->_validate($_POST)) {// 如果数据检验没通过，报错退出
		$msg = implode(',', $OI->getErr());
	    include(__ROOT__ . 'view/front/msg.html');  
	    exit();
	}

	// 自动过滤
	$data = $OI->_facade($_POST);

	// 自动填充
	$data = $OI->_autoFill($data);

	// 写入总金额
	$total = $data['order_amount'] = $cart->getPrice();

	// 写入用户名，从session读
	$data['user_id'] = isset($_SESSION['user_id']) ?$_SESSION['user_id'] :0 ;
	$data['username'] = isset($_SESSION['username']) ?$_SESSION['username'] : '匿名';

	// 写入订单号
	$order_sn = $data['order_sn'] = $OI->orderSn();



	if (!$OI->add($data)) {
		$msg = '下订单失败';
	    include(__ROOT__ . 'view/front/msg.html');  
	    exit();
	}

	//获取刚刚产生的order_id的值
	$order_id = $OI->insert_id();


	// 获取ordergoods的操作model
	$OG = new OGModel();

	$count = 0;

	/*
	把订单的商品写入数据库
	1个订单里有n个商品，我们循环写入ordergoods表
	*/
	$items = $cart->all();// 返回订单中所有的商品
	foreach ($items as $key => $value) {// 循环写入ordergoods表
		$data = array();

		$data['order_sn'] = $order_sn;
		$data['order_id'] = $order_id;
		$data['goods_id'] = $key;
		$data['goods_name'] = $value['name'];
		$data['goods_number'] = $value['num'];
		$data['shop_price'] = $value['price'];
		$data['subtotal'] = $value['price'] * $value['num'];

		if ($OG->addOG($data)) {
			$count += 1;// 插入一条og成功，因为，1个订单n个商品都插入成功，才算成功。
		}
	}

	if (count($items) !== $count) {// 购物车里面的商品数量没全部入库成功
		// 撤销购物车此订单
		$OI->invoke($order_id);
		$msg = '下订单失败';
	    include(__ROOT__ . 'view/front/msg.html');  
	    exit();
	}


	// 下订单成功，清空购物车
	$cart->clear();	


    /*
    在线支付，目前模拟网银在线支付，具体参考网银支付的开发者手册(http://www.chinabank.com.cn/company/aboutus.jsp)。
    计算在线支付的md5值
    v_amount v_moneytype v_oid  v_mid   v_url     key
     总金额       币种    订单号   商户号	回调地址	  秘钥
    */
    $v_url = 'http://127.0.0.1:8888/www/store/recive.php';
    $md5key = '#(%#WU)(UFGDKJGNDFG';
	$v_mid = '1009001';
    $v_md5info = md5($total . 'CNY' . $order_sn . $v_mid . $v_url . $md5key);
    $v_md5info = strtoupper($v_md5info);// 大写转换



	include(__ROOT__ . 'view/front/order.html');  
}
















