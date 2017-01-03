<?php

/*
所以用户直接访问到的这些页面

都得先加载init.php
*/

require('./include/init.php');

// $conf = conf::getIns();

// 已经能把配置文件的信息，读取到自身的 data属性中存起来
// print_r($conf);

// 读取选项
// echo $conf->host. '<br />';
// echo $conf->user. '<br />';
// echo $conf->pwd. '<br />';



// log::write('22222224444444');

// 查看php版本
// echo PHP_VERSION;

class mysql {
	public function query($sql){
		// xxx查询
		// 记录
		log::write($sql);
	}
}


$mysql = new mysql();

for ($i=0; $i < 20000; $i++) { 
	$sql = '1111select goods_id ,goods_name,goods_price from goods' . mt_rand(1,1000);
	$mysql->query($sql);
}

// log::write('今天就是这样子的 明天是否会比较ok--------');

echo '操作完毕--------------';