<?php

/***
file goodsaddAction.php  controller
作用 接收cateadd.php表单页面发送来的数据
并调用model,把数据库入库
***/


define('ACC',true);
require('../include/init.php');


// 接数据
print_r($_POST);

/*
$data = array();

$data['goods_name'] = trim($_POST['goods_name']);// 过滤收尾空格等特别字符

// 数据的检验,做一个示例
if($data['goods_name'] == '') {
    echo '商品名不能为空';
    exit;
}

$data['goods_sn'] = trim($_POST['goods_sn']);
$data['category_id'] = $_POST['category_id'] + 0;
$data['shop_price'] = $_POST['shop_price'] + 0;
// $data['market_price'] = $_POST['market_price'];
$data['goods_desc'] = $_POST['goods_desc'];
$data['goods_weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];;
$data['is_best'] = isset($_POST['is_best'])?1:0;
$data['is_new'] = isset($_POST['is_new'])?1:0;
$data['is_hot'] = isset($_POST['is_hot'])?1:0;
$data['is_on_sale'] = isset($_POST['is_on_sale'])?1:0;
$data['goods_brief'] = trim($_POST['goods_brief']);

$data['add_time'] = time();
*/


$_POST['goods_weight'] *= $_POST['weight_unit'];

$data = array();

$goods = new GoodsModel();
$data = $goods->_facade($_POST); // 自动过滤
$data = $goods->_autoFill($data); // 自动填充
print_r($data);


// 上传图片
$uptool = new Uptool();
$ori_img = $uptool->upLoad('ori_img');

if ($ori_img) {
	$data['ori_img'] = $ori_img;
}


/*
	如果$ori_img上传成功，再次生成中等大小缩略图 300*400
	根据原始地址 定 中等图的地址
	例：aa.jpeg --> goods_aa.jpeg
*/
$ori_img = __ROOT__ . $ori_img;// 加上绝对路径
$goods_img = dirname($ori_img) . '/goods_' . basename($ori_img);
if (ImageTool::thumb($ori_img,$goods_img,300,400)) {
	$data['goods_img'] = str_replace(__ROOT__, '', $goods_img);
}


/*
	如果$ori_img上传成功，再次生成浏览时用的缩略图 160*220
	根据原始地址 定 缩略图的地址
	例：aa.jpeg --> thumb_aa.jpeg
*/
$thumb_img = dirname($ori_img) . '/thumb_' . basename($ori_img);
if (ImageTool::thumb($ori_img,$thumb_img,160,220)) {
	$data['thumb_img'] = str_replace(__ROOT__, '', $thumb_img);
}


if($goods->add($data)) {
    echo '商品发布成功';
} else {
    echo '商品发布失败';
}

