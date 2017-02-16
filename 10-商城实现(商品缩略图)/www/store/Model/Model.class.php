<?php
/****
模型：处理数据
****/
defined('ACC')||exit('ACC Denied');
class Model {
	
    protected $table = NULL; // 是model所控制的表
    protected $db = NULL; // 是引入的mysql对象

    protected $pk = '';// 主键

    protected $fields = array();// 表字段数组
    protected $_auto = array();// 自动填充的字段数组

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

    /*
        自动过滤:
        负责把传来的数组
        清除掉不用的单元
        留下与表的字段对应的单元
        思路:
        循环数组,分别判断其key,是否是表的字段
        自然,要先有表的字段.

        表的字段可以desc表名来分析
        也可以手动写好 
        以tp为例,两者都行.

        先手动写
    */ 
    public function _facade($array = array()){
        $data = array();
        foreach ($array as $key => $value) {
            if (in_array($key, $this->fields)) {// 判断key是否为表字段
                $data[$key] = $value;
            }
        }
        return $data;
    }    


    /*  自动填充
        负责把表中需要的值，而_POST没传过来的字段，赋上值
        比如_POST里面没有add_time这个值，即商品时间
        则自动把time()的时间返回值直接赋值过来
    */  
    public function _autoFill($data){
        foreach ($this->_auto as $value) {
            if (!array_key_exists($value[0], $data)) {
                switch ($value[1]) {
                    case 'value':
                        $data[$value[0]] = $value[2];
                        break;

                    case 'function':
                        $data[$value[0]] = call_user_func($value[2]);
                        break;
                }
            }
        }

        return $data;

    }    

}    