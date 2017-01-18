<?php
/****
模型：处理数据
****/
defined('ACC')||exit('ACC Denied');
class Model {
	
    protected $table = NULL; // 是model所控制的表
    protected $db = NULL; // 是引入的mysql对象

    protected $pk = '';// 主键

    public function __construct() {
        $this->db = mysql::getIns();
    }

    public function table($table) {
        $this->table = $table;
    }

	/*
        根据关系数组,键->表中的列,值-->表中的值,
        add()函数自动插入该行数据
    */
	public function add($data){
		return $this->db->autoExecute($this->table,$data,'insert');
	}	


    /*
        查询全部数据
    */
	public function select($id){
		$sql = 'select * from ' . $this->table;
		return $this->db->getAll($sql);
	}

    /*	查询一个
        parm int $id
        return Array
    */
    public function find($id) {
        $sql = 'select * from ' .  $this->table . ' where ' . $this->pk . '=' . $id;
        return $this->db->getRow($sql);
    }

    /*  修改、更新
        parm array $data
        parm int $id
        return int 影响行数
    */
    public function update($data,$id) {
        $rs = $this->db->autoExecute($this->table,$data,'update',' where ' . $this->pk . '=' . $id);
        if ($rs) {
	        return $this->db->affected_rows();
        }else{
        	return false;
        }

    }

    /*  删除
        parm int $id 主键
        return int 影响的行数
    */ 	
    public function delete($id) {
        $sql = 'delete from ' . $this->table . ' where ' . $this->pk . '=' . $id;
        if ($this->db->query($sql)) {
	        return $this->db->affected_rows();
        }else{
        	return false;
        }
    }

}    