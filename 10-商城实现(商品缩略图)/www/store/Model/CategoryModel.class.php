<?php

/*
测试model，用于栏目添加。
*/

defined('ACC')||exit('ACC Denied');
class CategoryModel extends Model{
	
    protected $table = 'category'; // 是model所控制的表
    protected $pk = 'category_id'; // 主键

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
}