<?php

/*
	商品会手札 view
*/

define('ACC',true);
require('../include/init.php');




/*
实例化GoodsModel
*/

if (isset($_GET['act']) && $_GET['act']=='show') {

	$goods = new GoodsModel();
	$goodslist = $goods->getTrash();

	include(__ROOT__ . 'view/admin/templates/goodslist.html');

}else{

	$goods_id = $_GET['goods_id'];
	$goods = new GoodsModel();

	if ($goods->trash($goods_id)) {
		echo "删除成功";
	}else{
		echo "删除失败";
}
}





