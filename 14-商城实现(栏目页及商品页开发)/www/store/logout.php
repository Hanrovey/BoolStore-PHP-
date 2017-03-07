<?php

// 退出页

define('ACC',true);
require('./include/init.php');

session_start();
session_destroy();


$msg = '退出成功';


include(__ROOT__ . '/view/front/msg.html');