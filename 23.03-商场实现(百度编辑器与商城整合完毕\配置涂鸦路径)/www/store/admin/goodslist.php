<?php

/*
	商品展示列表 view
*/

define('ACC',true);
require('../include/init.php');




/*
实例化GoodsModel
调用select方法
循环显示在view上
*/


$goods = new GoodsModel();
$goodslist = $goods->getGoods();


include(__ROOT__ . 'view/admin/templates/goodslist.html');
