<?php

/*
file init.php
作用：框架初始化
*/

// 初始化当前的绝对路径
// 换成正斜线是因为 win/linux都支持正斜线，而linux不支持反斜线  
// __ROOT__ :  /Applications/MAMP/htdocs/www/store/
define('__ROOT__', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');
define('DEBUG', true);


// 设置时区，默认是格林尼治时间，修改为
date_default_timezone_set("PRC");


// 初始化 导入相应的类
require(__ROOT__ . 'include/db.class.php');
require(__ROOT__ . 'include/lib_base.php');
require(__ROOT__ . 'include/conf.class.php');
require(__ROOT__ . 'include/log.class.php');
require(__ROOT__ . 'include/mysql.class.php');
require(__ROOT__ . 'Model/TestModel.class.php');

// 过滤参数，用递归的方式过滤 $_GET、 $_POST、 $_COOKIE
$_GET    = _addslashes($_GET);
$_POST   = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);


// 设置报错级别
if (defined('DEBUG')) {
	error_reporting(E_ALL);
}else{
	error_reporting(0);
}

