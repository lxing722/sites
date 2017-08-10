<?php
	
	function error($result){
		die($result);
	}
	
	function login_auth(){
		session_start();
		isset($_SESSION['uid']) or error('please sign in!   <a href="sign_in.html.php">sign in</a>');
	}
?>