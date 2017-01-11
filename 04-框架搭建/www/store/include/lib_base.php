<?php

/*
基本方法库
*/

// 递归转义数组
function _addslashes($arr){

	foreach ($arr as $key => $value) {
		if (is_string($value)) {
			$arr[$key] = addslashes($value);
		}elseif (is_array($arr)) {// 如果是数组，调用自身，再转
			$arr[$key] = _addslashes($value);
		}
	}

	return $arr;
}