<?php
error_reporting(E_ALL ^ E_NOTICE);  //开启错误信息
/*
file  log.class.php
作用 ： 记录信息到日志
*/


/*
思路：
给定内容，写入文件(fopen,fwrite...)
如果文件大于>1M，重新写一份
*/

class Log{

	const LOGFILE = 'firstLog.txt';// 创建一个常量，代表日志文件的名称

	// 写日志
	public static function write($cont){

		// 追加换行符
		$cont .= "\r";
		// 判断是否备份
		$log = self::isBak();// 计算出日志文件的路径

		// 文件操作
		$fh = fopen($log, 'ab');
		fwrite($fh, $cont);
		fclose($fh);
	}


	// 备份日志
	public static function Bak(){

		// 就是把原来的日志文件，改个名，存储起来
		// 改成 年-月-日.bak这种形式
		$log = __ROOT__ . 'data/log/' . self::LOGFILE;
        $bak = __ROOT__ . 'data/log/' . date('Ymd_His') . '_' .mt_rand(10000,99999) . '_bak.txt';

		return rename($log, $bak);
	}


	// 读取并判断日志大小
	public static function isBak(){
		$log = __ROOT__ . 'data/log/' . self::LOGFILE;

		if (!file_exists($log)) {// 如果不存在，则创建该文件
			touch($log);// touch在linux也有此命令，是快速的建立一个文件
			return $log;
		}

		// 要是存在，则判断大小
        // 清除缓存
        clearstatcache(true,$log);
		$size = filesize($log);
		// echo 'filesize' . $size;
		if ($size < 1024 * 1024) {// 小于1M，还可以在写，直接返回。
			return $log;
		}

		// 走到这一行，说明>1M，重新写一份
		if (!self::Bak()) {
			return $log;
		}else{
			touch($log);
			return $log;
		}
	}
}