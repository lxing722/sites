<?php

	include_once 'util/config.php';
	include_once 'util/database.php';
	include_once 'util/function.php';

	$login = $_POST['s_u_login'];
	$password = $_POST['s_u_password'];
	$password_repeat = $_POST['s_u_password_repeat'];
	$nickname = $_POST['s_u_nickname'];
	$phone = $_POST['s_u_phone'];
	$email = $_POST['s_u_email'];
	$addr = $_POST['s_u_addr'];
	$conn = db_link();
	if(!$conn){
		error("server busy now!");
	}
	$sql = "select * from user where login='$login'";
	$res = db_query($conn, $sql);
	$users = db_res_arr($res);
	$user = $users[0];
	if(count($users)!=0){
		header("location:error.php?type=login_exist");
	}
	elseif(empty(trim($login)))
	{
   	header("location:error.php?type=logup");
	}
    else if(empty(trim($password)))
    {
    	header("location:error.php?type=pwdup");
    }
    else if($password!=$password_repeat)
    {
    	header("location:error.php?type=repeat_wrong");
    }
    else if(empty(trim($nickname)))
    {
    	header("location:error.php?type=nickname");
    }
    else
    {
		$sql = "insert into user (login,pswd,email,nickname,phone,address) values ('$login','$password','$email','$nickname','$phone','$addr')";
		$res = db_query($conn, $sql);
		if(!$res){
			die("".db_errno($conn));
		}
		else{
			header("Location:sign_in.html.php");
			exit();
		}
	}
?>
