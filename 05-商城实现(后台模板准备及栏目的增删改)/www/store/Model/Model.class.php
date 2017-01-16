<?php
/****
模型：处理数据
****/
// defined('ACC')||exit('ACC Denied');
class Model {
	
    protected $table = NULL; // 是model所控制的表
    protected $db = NULL; // 是引入的mysql对象

    public function __construct() {
        $this->db = mysql::getIns();
    }

    public function table($table) {
        $this->table = $table;
    }
}