<?php


/**
	栏目的编辑页面 view
**/
define('ACC',true);
require('../include/init.php');

$category_id = $_GET['category_id'] + 0;

$categoryModel = new CategoryModel();
$categoryinfo = $categoryModel->find($category_id);


$categorylist = $categoryModel->select();
$categorylist = $categoryModel->getCategoryTree($categorylist);
print_r($categoryinfo);

include(__ROOT__ . 'view/admin/templates/catedit.html');

