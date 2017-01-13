<?php  

/*
file config.inc.php
配置文件
*/
// defined('ACC')||exit('ACC Denied');
$_CFG = array();

$_CFG['host'] = '127.0.0.1:3306';// 装了MySQLWorkbeanch,记得查看真实的主机地址
// $_CFG['host'] = 'localhost';// 默认本地
$_CFG['user'] = 'root';
$_CFG['pwd']  = 'root';
$_CFG['db'] = 'boolstoreDB';
$_CFG['char'] = 'utf8';