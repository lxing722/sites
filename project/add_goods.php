<?php
include_once 'util/config.php';
include_once 'util/database.php';
include_once 'util/function.php';
session_start();
$uid = $_SESSION['uid'];
$name = $_POST['name'];
$age = $_POST['age'];
$type = $_POST['type'];
$wts = $_POST['wts'];
$status = $_POST['status'];
$description = $_POST['description'];
if(empty(trim($name)))
{
   	header("location:error.php?type=name");
}
else if(empty(trim($status)))
{
    header("location:error.php?type=status");
}
else if(empty(trim($wts)))
{
    header("location:error.php?type=wts");
}

// 连接数据库并开始事务
else{
	$conn = db_link();
	if (!$conn) {
		error("busy server!");
	}
	db_start($conn);

// 构建插入语句
	$sql = "INSERT INTO goods (uid,type,wts,name,age,status,description) VALUES ('$uid','$type','$wts','$name','$age','$status','$description')";

// 插入新的数据库记录
	if (!db_query($conn, $sql)) {
		db_rollback($conn);
		error("busy server!");
	}

// 保存上传的图片
	$gid = mysqli_insert_id($conn);
	$i = 0;
	$all_img_path = array();
	if (!is_dir($IMG_PATH_GOODS)) {
		mkdir($IMG_PATH_GOODS, 0777);
	}


	foreach ($_FILES as $img) {
		if (!$img['error']) {
			$img_path = $IMG_PATH_GOODS . $gid . '_' . $i . '.' . substr($img['type'], strrpos($img['type'], '/') + 1);
			if (move_uploaded_file($img['tmp_name'], $img_path)) {
				$all_img_path[] = $WEB_ROOT . ltrim($img_path, '.');
				$i++;
			}
		}
	}

// 将图片路径信息插入记录
	if (count($all_img_path) != 0) {
		$paths = '';
		foreach ($all_img_path as $path) {
			$paths .= $path . ';';
		}
		$paths = trim($paths, ';');
		$sql = "update goods set imgs='$paths' where gid='$gid'";
		db_query($conn, $sql);
	}

// 判断是否成功
	if (db_commit($conn)) {
		header("location:userpage.php?action=my_goods");
	} else {
		error("false!");
	}
}
?>