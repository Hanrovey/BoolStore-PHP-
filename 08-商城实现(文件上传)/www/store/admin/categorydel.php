<?php

// 栏目的删除页面

/**
思路:
接收category_id

调用model

删除category_id
**/


define('ACC',true);
require('../include/init.php');


$category_id = $_GET['category_id'] + 0;

$categoryModel = new CategoryModel();

if($categoryModel->delete($category_id)) {
    echo '删除成功';
} else {
    echo '删除失败';
}

