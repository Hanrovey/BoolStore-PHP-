<?php

/***
file categoryaddAction.php  controller
作用 接收cateadd.php表单页面发送来的数据
并调用model,把数据库入库
***/


define('ACC',true);
require('../include/init.php');


// 第一步,接数据
print_r($_POST);


// 第二步,检验数据
$data = array();
if (empty($_POST['category_name'])) {
	exit('栏目名不能为空');
}

$data['category_name'] = $_POST['category_name'];


// 同理判断category_desc和parent_id是否合法
$data['parent_id'] = $_POST['parent_id'];
$data['category_desc'] = $_POST['category_desc'];


// 第三步，实例化model
// 并调用model的相关方法
$categoryModel = new CategoryModel();
if ($categoryModel->add($data)) {
	echo '栏目添加成功';
	exit;
}else{
	echo '栏目添加失败';
	exit;
}
