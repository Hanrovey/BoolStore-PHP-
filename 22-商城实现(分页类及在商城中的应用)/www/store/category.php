<?php

define('ACC',true);
require('./include/init.php');


$category_id = isset($_GET['category_id']) ? $_GET['category_id']+0 : 0 ;
$page = isset($_GET['page'])? $_GET['page']+0:1;
if ($page < 1) {
	$page = 1;
}


$goods = new GoodsModel();
$total = $goods->catGoodsCount($category_id);

// 每页取2条
$perpage = 2;

if ($page > ceil($total/$perpage)) {//超过最大页时，直接返回第一页
	$page = 1;
}

$offset = ($page-1)*$perpage;

// 取出页码
$pagetool = new PageTool($total,$page,$perpage);
$pagecode = $pagetool->show();

// print_r($pagecode);exit();

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
$goodslist = $goods->catGoods($category_id,$offset,$perpage);


include(__ROOT__ . 'view/front/lanmu.html');
