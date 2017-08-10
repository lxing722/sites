<?php
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    if(empty(trim($firstname)))
    {
    	header("location:error.php?type=firstname");
    }
    else if(empty(trim($lastname)))
    {
    	header("location:error.php?type=lastname");
    }
    else if(empty(trim($login))||is_dir("2doDB/$login"))
    {
    	header("location:error.php?type=logup");
    }
    else if(empty(trim($password)))
    {
    	header("location:error.php?type=pwdup");
    }   
    else
	{	
          mkdir("2doDB/$login", 0700);
          $info = fopen("2doDB/$login/info.txt","w");
          fwrite($info,$password."\n");
          fwrite($info,$firstname."\n");
          fwrite($info,$lastname);
          fclose($info);
    } 
    header("location:sign_in_form.php");  
?>
    