<?php

/*
	登录页面
*/

define('ACC',true);
require('./include/init.php');

if (isset($_POST['act'])) {
	// 用户点击登录按钮
	// 接收用户名/密码，验证

	$u = $_POST['username'];
	$p = $_POST['passwd'];

	// 合法检测
	$user = new UserModel();


	// 核对用户名，密码
	$row = $user->checkUser($u,$p);
	if (empty($row)) {

		$msg = '用户名密码不匹配';
	}else{
		$msg = '登录成功';

		session_start();
		$_SESSION = $row;

		if (isset($_POST['remember'])) {

			echo "成功" . $u;
			setcookie('remuser',$u,time()+14*24*3600);
		}else{
			echo "失败" . $u;
			setcookie('remuser','',0);
		}
	}


	include(__ROOT__ . '/view/front/msg.html');
	exit();


}else{

	$remuser = isset($_COOKIE['remuser'])?$_COOKIE['remuser']:'';

	// 准备登录
	include(__ROOT__ . '/view/front/denglu.html');
}

