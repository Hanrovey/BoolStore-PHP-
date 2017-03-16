<?php

define('ACC',true);
require('./include/init.php');


$category_id = isset($_GET['category_id']) ? $_GET['category_id']+0 : 0 ;

$category = new CategoryModel();
$cat = $category->find($category_id);

if (empty($category)) {
	header('location: index.php');
	exit();
}


// 取出树状导航
$cats = $category->select();// 获取所有的栏目
$sort = $category->getCategoryTree($cats,0,1);


// 取出面包屑导航
$nav = $category->getTree($category_id);


//取出栏目下的商品
$goods = new GoodsModel();
$goodslist = $goods->catGoods($category_id);


include(__ROOT__ . 'view/front/lanmu.html');
