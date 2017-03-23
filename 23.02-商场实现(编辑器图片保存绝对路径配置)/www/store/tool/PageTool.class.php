<?php

/* 
分页类:

总结：
分页原理的3个变量

总页数		$total
每页条数		$perpage
当前页		$page


分页原理的2个公式

总页数 $count = ceil($total/$perpage);// 相除，向上取整


分页导航的生成
例：
a.php
a.php?category_id=2
a.php?page=1
a.php?category_id=2&page=1

分页导航里
[1] [2] 3 [4] [5]
page导航里，应该根据页码来生成，但同时不能把其它参数搞丢,如category_id

所有，我们要先将地址栏的url获取并保存起来
*/

class PageTool{

	protected $total = 0;
	protected $perpage = 10;
	protected $page = 1;


	public function __construct($total,$page=false,$perpage=false){
		$this->total = $total;

		if ($page) {
			$this->page = $page;
		}

		if ($perpage) {
			$this->perpage = $perpage;
		}
	}


	// 主要函数，创建分页导航
	public function show(){
		$count = ceil($this->total/$this->perpage);// 得到总页数
		$uri = $_SERVER['REQUEST_URI'];

		$parse = parse_url($uri);

		// print_r($parse);exit();

		$param = array();
		if (isset($parse['query'])) {
			parse_str($parse['query'],$param);
		}


		// 不管$param数组中，有没有page，都unset一下，确保没有page单元
		// 即保存除page之外的所有单元
		unset($param['page']);

		// 重新组合url,没有包含page字段的。
		$url = $parse['path'] . '?';
		if (!empty($param)) {
			$param = http_build_query($param);// 参数
			$url = $url . $param . '&';

		}

		// echo $url;return;

		// 下一个关键，就是计算页码导航
		$nav = array();
		$nav[0] = '<span class="page_now">' . $this->page . '</span>';

		// 分别左右一起循环，如果左右循环次数总和<=5,一直循环到5次终止。
		for($left = $this->page-1,$right = $this->page+1 ; ($left>=1||$right<=$count)&&count($nav)<=5 ; ){

			if ($left >= 1) {
				array_unshift($nav, '<a href="' . $url . 'page=' . $left . '">[' . $left . ']</a>');// 头部插入
				$left -= 1;
			}


			if ($right <= $count) {
				array_push($nav, '<a href="' . $url . 'page=' . $right . '">[' . $right . ']</a>');// 尾部插入
				$right += 1;
			}
		}

		// print_r($nav);exit();

		return implode('', $nav);
	}
}

$p = new PageTool(100);
$p->show();











