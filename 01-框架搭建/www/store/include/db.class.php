<?php

/*
file db.class.php
数据库类

目前到底采用什么数据库，不清楚
*/

// 定义抽象类
abstract class db{

	/* 
	链接服务器
	param $host 服务器地址
	param $username 用户名
	param $pwd 密码
	return bool
	*/
	public abstract function connent($host,$username,$pwd);

	/* 
	发送查询
	param $sql 发送sql语句
	return mixed bool/resource
	*/
	public abstract function query($sql);

	/* 
	查询多行数据
	param $sql select型语句
	return  bool/array
	*/
	public abstract function getAll($sql);

	/* 
	查询单行数据
	param $sql select型语句
	return  bool/array
	*/
	public abstract function getRow($sql);

	/* 
	查询单个数据
	param $sql select型语句
	return  bool/array
	*/
	public abstract function getOne($sql);

	/* 
	自动执行insert/update语句
	param $table 表名
	param $data  数据
	param $act   操作
	param $where 条件
	return  bool/array
	*/
	public abstract function autoExecute($table,$data,$act='insert',$where);
}





























