<?php

/*
所以用户直接访问到的这些页面

都得先加载init.php
*/

require('./include/init.php');



/*
测试目的：
测试框架能否正常运行
能否正常过滤非法字符
能否正常操作数据库
*/
$mysql = mysql::getIns();
// var_dump($mysql);

$t1 = $_GET['t1'];
$t2 = $_GET['t2'];


$sql = "insert into test(t1,t2) values('$t1','$t2')";
// $sql = "select * from boolstoreDB.test";
var_dump($mysql->query($sql));
// echo is_resource($query);


// var_dump($mysql->autoExecute('test',$_GET,'insert'));