<?php
    error_reporting( E_ALL&~E_NOTICE );
	session_start();
			
	$type = $_GET["type"];
	if ( $type === "logup" ) {
		$message = "The login cannot be empty!";
		$action = "sign_up.html.php";
	} elseif ( $type === "pwdup" ) {
		$message = "The password cannot be empty!";
		$action = "sign_up.html.php";
	} elseif ( $type === "nickname" ) {
		$message = "The nickname cannot be empty!";
		$action = "sign_up.html.php";
	} elseif ( $type === "login" ) {
		$message = "The login cannot be empty!";
		$action = "sign_in.html.php";
	} elseif ( $type === "pwdin" ) {
		$message = "The password cannot be empty!";
		$action = "sign_in.html.php";
	} elseif ( $type === "pwdup" ) {
		$message = "The password cannot be empty!";
		$action = "sign_up.html.php";		
	} else if( $type === "login_exist") {
		$message = "The login has been registered!";
		$action = "sign_up.html.php";
	}else if( $type === "nologin") {
		$message = "Please sign up to continue!";
		$action = "sign_up.html.php";
	}else if( $type === "wrong_pswd") {
		$message = "Your password is incorrect!";
		$action = "sign_in.html.php";
	}
	else if( $type === "name") {
		$message = "The product name cannot be empty!";
		$action = "userpage.php?action=add_goods";
	}
	else if( $type === "status") {
		$message = "The rate of newness cannot be empty!";
		$action = "userpage.php?action=add_goods";
	}
	else if( $type === "wts") {
		$message = "Your want to swap cannot be empty!";
		$action = "userpage.php?action=add_goods";
	}
	else if( $type === "des") {
		$message = "The description cannot be empty!";
		$action = "userpage.php?action=add_goods";
	}
	elseif ( $type === "nickname_edit" ) {
		$message = "The nickname cannot be empty!";
		$action = "userpage.php?action=userinfo";
	}
	elseif ( $type === "no_login" ) {
		$message = "Please sign in to continue!";
		$action = "sign_in.html.php";
	}
	elseif ( $type === "repeat_wrong" ) {
		$message = "Passwords do not match!";
		$action = "sign_up.html.php";
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>eSwap</title>
    <meta charset="utf-8" />
    <link href="css/index.css" type="text/css" rel="stylesheet" />
  </head>
<body>
	
	<div class="topbanner">
        <?php if(!isset($_SESSION['uid'])){?>
            <div class="sign_up"><a href="sign_in.html.php">Sign-in</a></div>
            <div class="sign_in"><a href="sign_up.html.php">Sign-up</a></div>
            <div class="home"><a href="index.php?type=all">Home page</a></div>
        <?php  }?>
        <?php if(isset($_SESSION['uid'])){?>
            <div class="mypage"><a href="index.php?type=all">Home page</a> || <a href="userpage.php?action=my_goods">My page</a> || <a href="log_out.php">Log out</a></div>
            <div class="hello">Hello,<?= $_SESSION['nickname'] ?>!</div>                           
        <?php  }?>
             
            <div class="wel">Welcome to eSwap</div>
                  
        </div>
	
	<div id="content">
		<form method="post" action="<?=$action?>">
			<div id="error">
				<div><?= $message ?></div>
				<input class="button" type="submit" value="OK" />
			</div>
		</form>
	</div>
</body>
</html>