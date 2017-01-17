<?php

/*
测试model，用于栏目添加。
*/

/**
* 
*/
class CategoryModel extends Model{
	
    protected $table = 'category'; // 是model所控制的表

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
	public function select(){
		$sql = 'select category_id,category_name,parent_id from ' . $this->table;
		return $this->db->getAll($sql);
	}

    /*
        根据主键 取出一行数据
    */ 
    public function find($category_id) {
        $sql = 'select * from category where category_id=' . $category_id;
        return $this->db->getRow($sql);
    }

     /*
        getCategoryTree
        pram: int $id
        return $id栏目的子孙树
    */
    public function getCategoryTree($arr,$id = 0,$lev=0) {
        $tree = array();

        foreach($arr as $v) {
            if($v['parent_id'] == $id) {
                $v['lev'] = $lev;
                $tree[] = $v;

                $tree = array_merge($tree,$this->getCategoryTree($arr,$v['category_id'],$lev+1));
            }
        }

        return $tree;
    }

    /*
        parm : int $id
        return $id栏目下的子栏目
    */
    public function getSon($id){
        $sql = 'select category_id,category_name,parent_id from ' . $this->table . ' where parent_id=' . $id;
        return $this->db->getAll($sql);
    }


    /*
        parm : int $id
        return array $id栏目下的家谱树
    */
    public function getTree($id=0){
        $tree = array();
        $category = $this->select();

        while ($id > 0) {
            foreach ($category as $key => $value) {
                if ($value['category_id'] == $id) {
                    $tree[] = $value;
                    $id = $value['parent_id'];
                    break;
                }
            }
        }
        return $tree;
    }


     /*
        update
        data: int $cat_id
        return $id栏目的子孙树
    */
    public function update($data,$category_id=0) {
        $this->db->autoExecute($this->table,$data,'update',' where category_id=' . $category_id);
        return $this->db->affected_rows();
    }


    /*
     	删除栏目
    */ 	
    public function delete($category_id=0) {
        $sql = 'delete from ' . $this->table . ' where category_id=' . $category_id;
        $this->db->query($sql);
        return $this->db->affected_rows();
    }
}