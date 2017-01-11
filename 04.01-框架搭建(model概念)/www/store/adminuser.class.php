<?php

/*
测试代码
*/

require('./include/init.php');

$testModel = new TestModel();

var_dump($testModel->register(array('t1' => 'adminUser', 't2' => 'adminUser')));