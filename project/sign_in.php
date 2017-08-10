<?php
	/*
	 * @author ChengShiheng
	 * 
	 * This program can verify the login&password group
	 * 
	 */

	include_once 'util/database.php';
	include_once 'util/function.php';
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	$conn = db_link();
	if(!$conn){
		error('busy server');
	}
	if(empty(trim($login)))
	{
   		header("location:error.php?type=login");
	}
    else if(empty(trim($password)))
    {
    	header("location:error.php?type=pwdin");
    }
    else
    {		
		$sql = "select pswd,uid,nickname from user where login='$login'";
		$res = db_query($conn, $sql);
		$user = db_res_arr($res);
		if(count($user) == 0){
			header("location:error.php?type=nologin");
		}
		else{				
			if($user[0]['pswd'] != $password){
				header("location:error.php?type=wrong_pswd");
			}
		    else{	
				session_start();	
				$_SESSION['uid'] = $user[0]['uid'];
				$_SESSION['nickname'] = $user[0]['nickname'];	
				header("Location: index.php?type=all");
				exit();
			}
		}
	}
?>

	