<?php

/**
	栏目的编辑页面 Controller
**/

define('ACC',true);
require('../include/init.php');


// 接POST
// 判断合法性,同学们自己做.


$data = array();
if(empty($_POST['category_name'])) {
    exit('栏目名不能为空');
}
$data['category_name'] = $_POST['category_name'];
$data['parent_id'] = $_POST['parent_id'];
$data['category_desc'] = $_POST['category_desc'];

$category_id = $_POST['category_id'] + 0;



/*
一个栏目A，不能修改成为A的子孙栏目的子栏目

思考：如果B是A的子栏目，A不能修改成为B的子栏目
反之，B是A的后代，则A是B的祖先


因此，我们为A设定一个新的父栏目时，设为M
我们可以先查M的家谱树  M的家谱树里如果有A

则子孙差辈了
*/


// 调用model来修改
$categoryModel = new CategoryModel();

// 查找新父栏目的家谱树
$tree = $categoryModel->getTree($data['parent_id']);

$flag = true;
foreach ($tree as $key => $value) {
	if ($value['category_id'] == $category_id) {
		flag = false;
		break;
	}
}

if (!flag) {
	echo '父栏目选取错误';
	exit;
}


if($categoryModel->update($data,$category_id)) {
    echo '修改成功';
} else {
    echo '修改失败';
}