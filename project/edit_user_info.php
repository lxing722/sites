<?php
// 编辑用户信息
include_once "util/include.php";
login_auth();
if(!($conn = db_link())){
	error("busy server!");
}
$nickname = $_POST['nickname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$addr = $_POST['address'];
if(empty(trim($nickname)))
{
    header("location:error.php?type=nickname_edit");
}
// 修改除头像之外的信息
$sql = "UPDATE user SET nickname='$nickname',email='$email',phone='$phone',address='$addr' WHERE uid='${_SESSION['uid']}'";
if(!db_query($conn, $sql)){
	error("busy server!");
}

// 判断是否有新的头像上传，有则修改
if(!$_FILES['new_head_img']['error']){
	$img = $_FILES['new_head_img'];
	$new_img_path = $IMG_PATH_HEAD.$_SESSION['uid'].'_'.time().'.'.substr($img['type'], strrpos($img['type'], '/')+1);
	if(move_uploaded_file($img['tmp_name'], $new_img_path)){
		// 文件存储成功则修改数据库数据
		$new_img_path_web = $WEB_ROOT.trim($new_img_path,'.');
		$sql = "UPDATE user SET headimg='$new_img_path_web' WHERE uid='${_SESSION['uid']}'";
		if(db_query($conn, $sql)){
			// 数据库数据修改成功则删除之前头像图片
			$headimgs = glob($IMG_PATH_HEAD.$_SESSION['uid'].'_'.'*');
			foreach ($headimgs as $headimg) {
				if($headimg!=$new_img_path){
					unlink($headimg);
				}
			}
			error('succeed! <a href="#" onclick="javascript:history.back()">GoBack</a>');
		}else{
			unlink($new_img_path);
			error("headimg setting failed!");
		}
	}	
}

header("location:userpage.php?action=userinfo");

?>