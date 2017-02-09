<?php


/*
单文件上传类
*/
defined('ACC')||exit('ACC Denied');

/*
上传文件
配置允许的后缀
配置允许的大小
随机生成目录
随机生成文件名

获取文件后缀
判断文件的后缀.

良好的报错的支持

*/
class UpTool {

	protected $allowExt = 'jpg,jpeg,png,bmp,gif';
	protected $maxSize = 1;//1M，M为单位

	protected $errorno = 0;// 错误代码
	protected $error = array(
						0=>'无错误',
						1=>'上传文件超出系统限制',
						2=>'上传文件大小超出网页表单页面',
						3=>'文件只有部分上传',
						4=>'没有文件被上传',
						6=>'找不到临时文件夹',
						7=>'文件写入失败',
						8=>'不予许的文件后缀',
						9=>'文件大小超出类的允许范围',
						10=>'创建目录失败',
						11=>'移动文件失败'
							);

	/*
		上传文件
	*/
	public function upLoad($key){
		if (!isset($_FILES[$key])) {
			return false;
		}

		$f = $_FILES[$key];

        // 检验上传有没有成功
        if($f['error']) {
            $this->errorno = $f['error'];
            return false;
        }


		// 获取后缀
		$ext = $this->getExt($f['name']);
		//检查后缀
		if (!$this->isAllowExt($ext)) {
			$this->errorno = 8;
			return false;
		}


		// 获取大小
		$size = $f['size'];
		// 检查大小
		if (!$this->isAllowSize($size)) {
			$this->errorno = 9;
			return false;
		}


		// 通过

		// 创建目录
		$dir = $this->mk_dir();
		if ($dir == false) {
			$this->errorno = 10;
			return false;
		}

		// 生成随机文件名
		$newname = $this->randName() . '.' . $ext;
		$dir = $dir . '/' . $newname;

		// 移动
		if (!move_uploaded_file($f['tmp_name'], $dir)) {
			$this->errorno = 11;
			return false;
		}

		return str_replace(__ROOT__,'',$dir);
	}

	/*
		param $sring $exts后缀
	*/
	public function setExt($exts){
		$this->allowExt = $exts;
	}


	/*
		param $sring $num 文件大小
	*/
	public function setSize($num){
		$this->maxSize = $num;
	}


	/*
		param $sring $file
		return $string $ext 后缀
	*/
	protected function getExt($file){
        $tmp = explode('.',$file);
        return end($tmp);
	}


	/*
		param string $ext 文件后缀
		return bool

		防止大小写的问题 JPG
	*/
	protected function isAllowExt($ext){
		return in_array(strtolower($ext), explode(',', strtolower($this->allowExt)));
	}


	/*
		检查文件大小
	*/
	protected function isAllowSize($size){
		return $size <= ($this->maxSize * 1024 * 1024);
	}


	/*
		按日期创建目录
	*/
	protected function mk_dir(){
		$dir = __ROOT__ . 'data/image/' . date('Ym/d');

		if (is_dir($dir) || mkdir($dir,0777,true)) {
			return $dir;
		}else{
			return false;
		}
	}


	/*
		生成随机文件名
	*/
	protected function randName($len = 6){
		$str = 'abdhjrkuytrfzlopqiyt8565209874538264';
		return substr(str_shuffle($str), 0,$len);
	}	


	/*
		获取错误
	*/
	public function getError(){
		return $this->error[$this->errorno];
	}




}