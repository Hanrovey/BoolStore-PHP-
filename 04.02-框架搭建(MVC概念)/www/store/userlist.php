<?php

require('./include/init.php');

$test = new TestModel();
$list = $test->select();

// print_r($list);

require(__ROOT__ . 'view/userlist.html');
