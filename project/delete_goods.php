<?php
	include_once 'util/database.php';
	include_once 'util/function.php';
	session_start();
    $uid = $_SESSION['uid'];
	$gid = $_GET["gid"];
	$conn = db_link();
    if (!$conn) {
        error("busy server");
    }
    $sql = "delete from goods where gid='$gid'"; 
    $res = db_query($conn, $sql);
    if (db_errno($conn) != 0) {
        error("busy server");
    }
    header("Location:userpage.php?uid=$uid&action=my_goods");
?>