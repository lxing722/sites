<?php
include_once "util/include.php";

session_start();

isset($_SESSION["uid"]) or error("please login");

$ret = new stdClass();

$conn = db_link();
if (!$conn) {
	$ret -> status = 1;
	echo json_encode($ret);
	exit();
}

$sender = $_SESSION['uid'];
$receiver = $_POST['receiver'];
$content = $_POST['content'];
$time = date("Y-m-d H:i:s");

$sql = "INSERT INTO `message` ( `sender`, `receiver`, `content`, `sendtime`, `readstate`) VALUES ('$sender' , '$receiver' , '$content' , '$time' , '0')";

if (!db_query($conn, $sql)) {
	$ret -> status = 1;
	echo json_encode($ret);
	exit();
}

$ret = new stdClass();
$ret -> status = 0;
$ret -> msgs = array();
$amsg = new stdClass();
$amsg -> sender = $sender;
$amsg -> receiver = $receiver;
$amsg -> content = $content;
$amsg -> sendtime = $time;
$ret -> msgs[] = $amsg;
echo json_encode($ret);
exit();
?>