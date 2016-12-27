<?php

/*
所以用户直接访问到的这些页面

都得先加载init.php
*/

require('./include/init.php');

$conf = conf::getIns();

// 已经能把配置文件的信息，读取到自身的 data属性中存起来
// print_r($conf);

// 读取选项
echo $conf->host. '<br />';
echo $conf->user. '<br />';
echo $conf->pwd. '<br />';
