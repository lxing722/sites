<?php

// 如果有receiver传入，说明是获取和某个用户聊天的所有消息，否则是获取全部的未读消息
include_once 'util/include.php';
session_start();

if (!isset($_SESSION['uid'])) {
	header("Location:login.html.php");
	exit();
}
$uid = $_SESSION['uid'];

$conn = db_link();
if (!$conn) {
	err_exit();
}

// 根据不同情况生成sql语句
if(isset($_POST['receiver'])){
	$chatter = $_POST['receiver'];
	$sql = "select sender,receiver,content,sendtime from message where (sender=$chatter and receiver=$uid) or (sender=$uid and receiver=$chatter)";
}else{
	$sql = "select sender,receiver,content,sendtime from message where receiver=$uid and readstate=0";
}
$res = db_query($conn, $sql);
if (!$res) {
	err_exit();
}

// 如果是获取未读消息列表，需要将未读消息置为已读
if(!isset($_POST['receiver'])){
	$sql = "update message set readstate=1 where receiver=$uid and readstate=0";
	if(!db_query($conn, $sql)){
		err_exit();
	}
}

// 无错误，返回信息，包括状态和信息数组
$ret = new stdClass();
$ret -> status = 0;
$ret->msgs = array();
$msgs = db_res_arr($res);
foreach ($msgs as $msg) {
	$amsg = new stdClass();
	$amsg->sender = $msg['sender'];
	$amsg->receiver = $msg['receiver'];
	$amsg->content = $msg['content'];
	$amsg->sendtime = $msg['sendtime'];
	$ret->msgs[] = $amsg;
}

echo json_encode($ret);
exit();

function err_exit() {
	$ret = new stdClass();
	$ret -> status = 1;
	echo json_encode($ret);
	exit();
}
?>