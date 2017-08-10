<?php
    $login = $_POST["login"];
    $password = $_POST["password"];
    $info = file("2doDB/$login/info.txt");
    if(is_dir("2doDB/$login")&&$password = $info[0])
    {
    	header("location:notes.php?login=$login");
    }
    else { 
    	header("location:home.php");
    }
?>
