<?php

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



// 调用model 来更改
$categoryModel = new CategoryModel();

if($categoryModel->update($data,$category_id)) {
    echo '修改成功';
} else {
    echo '修改失败';
}