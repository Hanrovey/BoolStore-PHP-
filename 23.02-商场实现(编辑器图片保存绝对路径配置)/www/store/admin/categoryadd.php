<?php

/*
	栏目添加页面  view
*/


define('ACC',true);
require('../include/init.php');

$categoryModel = new CategoryModel();
$categorylist = $categoryModel->select();
$categorylist = $categoryModel->getCategoryTree($categorylist);

include(__ROOT__ . 'view/admin/templates/cateadd.html');