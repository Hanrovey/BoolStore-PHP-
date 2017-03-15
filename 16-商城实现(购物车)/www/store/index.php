<?php

/*
所以用户直接访问到的这些页面

都得先加载init.php
*/

define('ACC',true);
require('./include/init.php');

session_start();


/*
测试目的：
测试框架能否正常运行
能否正常过滤非法字符
能否正常操作数据库
*/
// $mysql = mysql::getIns();
// // var_dump($mysql);

// $t1 = $_GET['t1'];
// $t2 = $_GET['t2'];


// $sql = "insert into test(t1,t2) values('$t1','$t2')";
// // $sql = "select * from boolstoreDB.test";
// // var_dump($mysql->query($sql));
// // echo is_resource($query);


// var_dump($mysql->autoExecute('test',$_GET,'insert'));

// 取出5条新品
$goods = new GoodsModel();
$newlist = $goods->getNew(5);

// print_r($newlist);exit;

// 取出指定栏目的商品
$femal_id = 6;
$femalist = $goods->catGoods($femal_id);
// print_r($goods->catGoods($femal_id));exit();

include(__ROOT__ . 'view/front/index.html');
