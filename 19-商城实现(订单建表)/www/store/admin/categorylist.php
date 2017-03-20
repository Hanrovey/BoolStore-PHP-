<?php

/*
	商品分类展示列表 view
*/

define('ACC',true);
require('../include/init.php');



// 调用model
$categoryModel = new CategoryModel();
$categorylist = $categoryModel->select();

$categorylist = $categoryModel->getCategoryTree($categorylist,0);

include(__ROOT__ . 'view/admin/templates/catelist.html');
