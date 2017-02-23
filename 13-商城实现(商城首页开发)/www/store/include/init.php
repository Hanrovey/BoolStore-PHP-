<?php

/*
file init.php
作用：框架初始化
*/

// 防非法访问
defined('ACC')||exit('ACC Denied');


// 初始化当前的绝对路径
// 换成正斜线是因为 win/linux都支持正斜线，而linux不支持反斜线  
// __ROOT__ :  /Applications/MAMP/htdocs/www/store/
define('__ROOT__', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');
define('DEBUG', true);


// 设置时区，默认是格林尼治时间，修改为
date_default_timezone_set("PRC");

// 设置报错提示
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);


// 初始化 导入相应的类
require(__ROOT__ . 'include/lib_base.php');

// 自动加载
function __autoload($class){

	if (strtolower(substr($class, -5)) == 'model') {// 截取最后五位字符判断是否为model
		require(__ROOT__ . 'Model/' . $class . '.class.php');
echo __ROOT__ . 'Model/' . $class . '.class.php';
	} else if(strtolower(substr($class, -4)) == 'tool'){
		require(__ROOT__ . 'tool/' . $class . '.class.php');
	} else {
		require(__ROOT__ . 'include/' . $class . '.class.php');
	}
}



// require(__ROOT__ . 'include/db.class.php');
// require(__ROOT__ . 'include/conf.class.php');
// require(__ROOT__ . 'include/log.class.php');
// require(__ROOT__ . 'include/mysql.class.php');
// require(__ROOT__ . 'Model/Model.class.php');
// require(__ROOT__ . 'Model/TestModel.class.php');

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
