<?php

/*

购物车类

分析：
1：无论页面刷新多少次，或者新增多少商品
都要求你查看购物车时，看到的都是同一个结果

即：整站范围内，购物车----是一个全局有效的

解决：把购物车的信息放在数据库，也可以放在session/cookie里面


2：既然全局有效，暗示，购物车的实例只能有一个
不能说开了2个页面，买了2个商品，就形成2个购物车实例，这是不科学的
解决：单例模式


技术选型 ： session + 单例

功能分析：

判断某个商品是否存在
*/

session_start();

class CartTool {

	private static $ins = null;
	private $items = array();


	final protected function __construct() {
	}

	final protected function __clone() {

	}


	// 获取实例
	protected static function getIns() {
		if (!(self::$ins instanceof self)) {
			self::$ins = new self();
		}

		return self::$ins;
	}


	// 把购物车的单例对象放到session里面
	public static function getCart() {
		if (!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof self)) {
			$_SESSION['cart'] = self::getIns();
		}
		return $_SESSION['cart'];
	}

	/*
	添加商品
	param int $id 商品主键
	param string $name 商品名称
	param float $price 商品价格
	param int $num 购物数量
	*/
	public function addItem($id,$name,$price,$num=1){

		if ($this->hasItem($id)) {// 如果商品已经存在，直接加其数量
			$this->increaseNum($id,$num);
			return ;
		}
		$item = array();
		$item['name'] = $name;
		$item['price'] = $price;
		$item['num'] = $num;

		$this->items[$id] = $item;
	}

	/*
	修改购物车中的商品数量
	param int $id 商品主键
	param int $num 某个商品修改后的数量
	*/
	public function modifyNum($id,$num=1){
		if (!$this->hasItem($id)) {
			return false;
		}

		$this->items['id']['num'] = $num;
	}

	/*
	判断某商品是否存在
	*/
	public function hasItem($id){
		return array_key_exists($id, $this->items);
	}

	/*
	商品数量增加1
	*/
	public function increaseNum($id,$num){
		if ($this->hasItem($id)) {
			$this->items['id']['num'] += $num;
		}
	}

	/*
	商品数量减少1
	*/
	public function reduceNum($id,$num=1){
		if ($this->hasItem($id)) {
			$this->items['id']['num'] -= $num;
		}

		// 如果减少到0，则将商品移除购物车
		if ($this->items['num'] < 1) {
			$this->deleteItem($id);
		}
	}

	/*
	删除商品
	*/
	public function deleteItem($id){
		unset($this->items[$id]);
	}

	/*
	查询购物车中商品的种类
	*/
	public function getCount(){
		return count($this->items);
	}

	/*
	查询购物车中商品的个数
	*/
	public function getNum(){
		if ($this->getCount() == 0) {
			return 0;
		}

		$sum = 0;
		foreach ($this->items as $item) {
			$sum += $item['num'];
		}

		return $sum;
	}

	/*
	查询总金额
	*/
	public function getPrice(){
		if ($this->getCount() == 0) {
			return 0;
		}

		$price = 0;
		foreach ($this->items as $item) {
			$price += $item['num'] * $item['price'];
		}

		return $price;
	}

	/*
	返回购物车中的全部商品
	*/
	public function all(){
		return $this->items;
	}

	/*
	清空购物车
	*/
	public function clear(){
		$this->items = array();
	}
}


// $cart = CartTool::getCart();

// if (!isset($_GET['test'])) {
// 	$_GET['test'] = '';
// }

// if ($_GET['test'] == 'addXX') {
// 	$cart->addItem(1,'小米',999.9,1);
// 	echo "add ok";
// }else if ($_GET['test'] == 'addMM') {
// 	$cart->addItem(2,'魅族',12.3,1);
// 	echo "add ok11";
// }else if ($_GET['test'] == 'clear') {
// 	$cart->clear();

// }else if ($_GET['test'] == 'show'){
// 	print_r($cart->all());
// 	echo "共",$cart->getCount(),'种',$cart->getNum(),'个商品<br/>';
// 	echo "共",$cart->getPrice(),'元';
// }else{
// 	print_r($cart);
// }










