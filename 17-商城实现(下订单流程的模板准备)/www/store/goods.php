<?php

define('ACC',true);
require('./include/init.php');


$good_id = isset($_GET['good_id'])? $_GET['good_id']+0 :0 ; 

// 先查询这个商品信息
$goods = new GoodsModel();
$g = $goods->find($good_id);

if (empty($g)) {
	header('location: index.php');
	exit();
}

$cat = new CategoryModel();
$tree = $cat->getTree($g['category_id']);

include(__ROOT__ . 'view/front/shangpin.html');