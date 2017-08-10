<?php

	include_once 'util/config.php';

// 数据库连接
function db_link() {
	$conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_database']);
	if ($conn) {
		if (db_init($conn)) {
			return $conn;
		} else {
			return '';
		}
	} else {
		return '';
	}
}

// 初始化，用于设置编码方式
function db_init($conn) {
	$sql = "set names utf8";
	if (mysqli_query($conn, $sql) === TRUE) {
		return true;
	} else {
		return '';
	}
}

// 开始事务
function db_start($conn) {
	$sql = "begin";
	if (mysqli_query($conn, $sql) === TRUE) {
		return true;
	} else {
		return '';
	}

}

// 查询
function db_query($conn, $sql) {
	$res = mysqli_query($conn, $sql);
	if (!$res) {
		return '';
	} else {
		return $res;
	}
}

// 提交事务
function db_commit($conn) {
	$sql = "commit";
	if (mysqli_query($conn, $sql) === TRUE) {
		return true;
	} else {
		return '';
	}
}

// 回滚事务
function db_rollback($conn) {
	$sql = "rollback";
	if (mysqli_query($conn, $sql) === TRUE) {
		return true;
	} else {
		return '';
	}
}

// 将查询结果转换为数组形式
function db_res_arr($res) {
	$ret = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$ret[] = $row;
	}
	return $ret;
}

// 返回错误代码
function db_errno($conn){
	return mysqli_errno($conn);
}
?>