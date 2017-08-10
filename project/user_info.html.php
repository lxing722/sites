<?php
include_once 'util/config.php';
include_once 'util/database.php';
include_once 'util/function.php';

session_start();
isset($_SESSION['uid']) or error('please login');
$uid = $_SESSION['uid'];

$conn = db_link();
if (!$conn) {
	error('busy server');
}

$sql = "SELECT * FROM `user` WHERE uid='$uid'";
$res = db_query($conn, $sql);
$user = db_res_arr($res);
$user = $user[0];
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8"/>
		<link href="css/frame_form.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/user_info.js" ></script>
	</head>
	<body>
		<div class="form_style">
			<form enctype="multipart/form-data" class="form_style" action="edit_user_info.php" method="post">
					<label>Head image:</label><div id="headimg"><img src="<?=($user['headimg'] ? $user['headimg'] : $DEFAULT_HEAD_IMG) ?>"/></div><br />
					<label id="new_img" hidden="hidden">New head image:</label><input type="file" name="new_head_img" hidden="hidden" /><br />
					<label>Nickname:</label><input type="text" name="nickname" value="<?=$user['nickname'] ?>" disabled="true" ><br />						
					<label>E-mail:</label><input type="text" name="email" value="<?=$user['email'] ?>" disabled="true"><br />
					<label>Phone:</label><input type="text" name="phone" value="<?=$user['phone'] ?>" disabled="true"><br />
					<label>City of residence:</label><input type="text" name="address" value="<?=$user['address'] ?>" disabled="true"><br />
			<div class="submit"	>	
					<input id="submit"type="submit" value="Submit" hidden="hidden"><br />						
			</div>	
			</form>
			<div class="submit"	>
			<input class="button" type="button" value="Edit" onclick="edit_user_info()">
			</div>	
		</div>
	</body>
</html