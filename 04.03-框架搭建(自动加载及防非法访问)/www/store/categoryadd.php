<?php

/*
	测试代码
*/

require('./include/init.php');



/*

以往的做法是

接收数据
检验数据

拼接sql，执行

判断返回值



现在的MVC开发方式

接收数据
检验数据

把数据交给model去写入数据库

判断model的返回值
*/

// 接收数据
$data['catename'] = $_POST['catename'];
$data['cateintro'] = $_POST['cateintro'];

// echo $_POST['catename'];
// echo $_POST['cateintro'];

// 用model来处理
$catemodel = new CategoryModel();

if ($catemodel->add($data)) {
	$res = true;
}else{
	$res = false;
}


// 结果展示到view，目前先用echo
echo $res ? '成功': '失败';
