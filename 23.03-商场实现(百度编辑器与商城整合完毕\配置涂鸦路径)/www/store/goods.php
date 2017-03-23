<?php

define('ACC',true);
require('./include/init.php');


$goods_id = isset($_GET['goods_id'])? $_GET['goods_id']+0 :0 ; 

// 先查询这个商品信息
$goods = new GoodsModel();
$g = $goods->find($goods_id);

if (empty($g)) {
	header('location: index.php');
	exit();
}

$cat = new CategoryModel();
$tree = $cat->getTree($g['category_id']);

include(__ROOT__ . 'view/front/shangpin.html');