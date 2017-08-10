
<?php
include_once "util/include.php";
login_auth();

$uid = $_SESSION['uid'];

$conn = db_link();
if (!$conn) {
	error("busy server!");
}

$sql = "select DISTINCT sender,receiver from message where sender=1 or receiver=1";
$res = db_query($conn, $sql);
if (!$res) {
	error("busy server2!");
}

$receiver = isset($_GET['chatter']) ? $_GET['chatter'] : 0;

$chattings = db_res_arr($res);
$now_chatting = array("sender" => $uid, "receiver" => $receiver, );

array_unshift($chattings, $now_chatting);

// 获得所有需要读取头像和昵称信息的用户id
foreach ($chattings as $chattings) {
	if ($chattings['sender'] != $uid) {
		$chatters[] = $chattings['sender'];
	} else if ($chattings['receiver'] != $uid) {
		$chatters[] = $chattings['receiver'];
	}
}
$chatters = array_unique($chatters);
$chatters_str = implode(",", $chatters);

$sql = "select uid,nickname,headimg from user where uid in ($chatters_str) ";
$res = db_query($conn, $sql);
$chatters_info = db_res_arr($res);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/chat.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/chat.css"/>
	</head>
	<body>
		<div>
			<div class="main">
				<div ></div>
				<div class="left" id="contacts"><?php
						foreach($chatters_info  as $chatter){
							if($chatter['uid'] == $receiver){
								$receiver_nickname = $chatter['nickname'];
								$receiver_headimg = $chatter['headimg'];
							}
							?><div class="item" onclick="change_chatter(this)" chatterid="<?=$chatter['uid'] ?>"><img class="float_left" src="<?=$chatter['headimg'] ?>"/><span class="alert">0</span><div class="item_content float_left"><h3><?=$chatter['nickname'] ?></h3><p></p></div><div class="clear"></div></div><?php
							}
					?><div class="clear"></div></div>
				<div class="right">
						<div id="receiver_nickname"><span><?=isset($receiver_nickname) ? $receiver_nickname : "please choose someone" ?></span></div>
					<div class="chat_frame" id="chat_box">
					</div>
					<div class="input_box">
						<center>
							<input type="text" name="msg" id="msg" size="30"/>
							<div id="receiver" hidden="hidden"><?=$receiver ?></div>
							<?php
							$sql = "select headimg from user where uid=$uid";
							$res = db_query($conn, $sql);
							$headimg = db_res_arr($res);
							$headimg = $headimg[0]['headimg'];
							?>
							<div id="sender_headimg" hidden="hidden"><?=$headimg ?></div>
							<div id="receiver_headimg" hidden="hidden"><?=$receiver_headimg ?></div>
							<div id="last_time" hidden="hidden"><?=date("Y-m-d H:i:s") ?></div>
							<button id="btn_send_msg" onclick="send_msg()">
							send
							</button>
						</center>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</body>
</html>