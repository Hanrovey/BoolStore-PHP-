<?php
/****
燕十八 公益PHP讲堂

论  坛: http://www.zixue.it
微  博: http://weibo.com/Yshiba
YY频道: 88354001
****/



define('ACC',true);
require('../include/init.php');



// 调用model
$categoryModel = new CategoryModel();
$categorylist = $categoryModel->select();

$categorylist = $categoryModel->getCategoryTree($categorylist,0);
print_r($categorylist);

include(__ROOT__ . 'view/admin/templates/catelist.html');
