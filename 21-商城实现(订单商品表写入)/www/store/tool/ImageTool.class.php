<?php

/*
想操作图片
先把图片的大小，类型信息得到

水印：就是把指定的水印复制到目标上，并加透明效果

缩略图：就是把大图片复制到小尺寸画面上
*/

class ImageTool{

	/*
	imageInfo 分析图片的信息
	return array()
	*/
	public static function imageInfo($image){
		// 判断图片是否存在
		if (!file_exists($image)) {
			return false;
		}

		$info = getimagesize($image);

		if ($info == false) {
			return false;
		}

		// 此时info分析出来，是一个数组
		$img['width'] = $info[0];
		$img['height'] = $info[1];
		$img['ext'] = substr($info['mime'], strpos($info['mime'], '/')+1);

		return $img;

	}


	/*
		加水印功能
		param string $dst 待操作图片
		param string $water 水印小图
		param string $save 不填默认则默认替换原图
	*/
	public static function water($dst,$water,$save=NULL,$postion=2,$alpha=50){

		// 先保证2个图片存在
		if (!file_exists($dst) || !file_exists($water)) {
			return false;
		}


		// 首先保证水印不能比待操作图片还大
		$dInfo = self::imageInfo($dst);
		$wInfo = self::imageInfo($water);


		if ($wInfo['height'] > $dInfo['height'] || $wInfo['width'] > $dInfo['width']) {
			return false;
		}

		// 两张图，读到画布上，如何区分png/jpg，用什么函数
		$dFunc = 'imagecreatefrom' . $dInfo['ext'];
		$wFunc = 'imagecreatefrom' . $wInfo['ext'];
		if (!function_exists($dFunc) || !function_exists($wFunc)) {
			return false;
		}

		// 动态加载函数来创建画布
		$dImage = $dFunc($dst);// 创建待操作的画布
		$wImage = $wFunc($water);// 创建水印画布


		//根据水印位置 计算粘贴的坐标(四个角)
		switch ($postion) {
			case 0:// 左上角
				$posX = 0;
				$posY = 0;
				break;

			case 1:// 右上角
				$posX = $dInfo['width'] - $wInfo['width'];
				$posY = 0;
				break;
			
			case 3:// 左下角
				$posX = 0;
				$posY = $dInfo['height'] - $wInfo['height'];
				break;

			default:
				$posX = $dInfo['width'] - $wInfo['width'];
				$posY = $dInfo['height'] - $wInfo['height'];
				break;
		}


		// 加水印
		imagecopymerge($dImage, $wImage, $posX, $posY, 0, 0, $wInfo['width'], $wInfo['height'], $alpha);

		// 保存
		if (!$save) {
			$save = $dst;
			unlink($dst);// 删除原图
		}

		$createFunc = 'image' . $dInfo['ext'];
		$createFunc($dImage,$save);

		imagedestroy($dImage);
		imagedestroy($wImage);

		return true;
	}


	/*
		thumb 生成缩略图
		等比例缩放，两边留白
	*/
	public static function thumb($dst,$save=NULL,$width=200,$height=200){
		// 首先判断待处理图片是否存在
		$dInfo = self::imageInfo($dst);
		if ($dInfo == false) {
			return false;
		}

		// 计算缩放比例
		$scale = min($width/$dInfo['width'],$height/$dInfo['height']);

		// 创建原始图的画布
		$dFunc = 'imagecreatefrom' . $dInfo['ext'];
		$dImage = $dFunc($dst);

		// 创建缩略画布
		$thumbImage = imagecreatetruecolor($width, $height);

		// 创建白色填充缩略画布
		$white = imagecolorallocate($thumbImage, 255, 255, 255);

		// 填充缩略画布
		imagefill($thumbImage, 0, 0, $white);

		//复制并缩略
		$dWidth = $dInfo['width'] * $scale;
		$dHeight = $dInfo['height'] * $scale;

		$paddingX = (int)($width - $dWidth) * 0.5;
		$paddingY = (int)($height - $dHeight) * 0.5;
		imagecopyresampled($thumbImage, $dImage, $paddingX, $paddingY, 0, 0, $dWidth, $dHeight, $dInfo['width'], $dInfo['height']);

		// 保存图片
		if (!$save) {
			$save= $dst;
			unlink($dst);
		}

		$createFunc = 'image' . $dInfo['ext'];
		$createFunc($thumbImage,$save);

		imagedestroy($dImage);
		imagedestroy($thumbImage);

		return true;


	}
}

// print_r(ImageTool::imageInfo('./head.jpg'));

// echo ImageTool::water('./huo.jpg','./head.jpg','./new1.jpg',0) ? 'ok': 'fail';
// echo ImageTool::water('./huo.jpg','./head.jpg','./new2.jpg',1) ? 'ok': 'fail';
// echo ImageTool::water('./huo.jpg','./head.jpg','./new3.jpg',2) ? 'ok': 'fail';
// echo ImageTool::water('./huo.jpg','./head.jpg','./new4.jpg',3) ? 'ok': 'fail';

// echo ImageTool::thumb('./head.jpg','./head1.jpg',100,100) ? 'ok': 'fail';
// echo ImageTool::thumb('./head.jpg','./head2.jpg',200,200) ? 'ok': 'fail';
// echo ImageTool::thumb('./head.jpg','./head3.jpg',300,300) ? 'ok': 'fail';















