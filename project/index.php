<?php
    error_reporting(E_ALL || ~E_NOTICE);
    include_once 'util/config.php';
    include_once 'util/database.php';
    include_once 'util/function.php';
    session_start();  
    if (!isset($_GET['type'])) {
        $type = "all";
    }
    else{
        $type = $_GET["type"];
    }
    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        $nickname = $_SESSION['nickname'];           
    }
    $conn = db_link();
    if (!$conn) {
        error("busy server");
    }
    if($type=="all"){
       $sql = "select * from goods order by createtime DESC"; 
    }
    else{
        $sql = "select * from goods where type='$type' order by createtime DESC";
    }    
    $res = db_query($conn, $sql);
    if (db_errno($conn) != 0) {
        error("busy server.");
    }
    $goods = db_res_arr($res);

    if (isset($_SESSION['uid'])) {
        $sql = "select sender from message where receiver=$uid and readstate=0";
        $res = db_query($conn, $sql);
        if (db_errno($conn) != 0) {
            error("busy server.");
        }
        $msgs = db_res_arr($res);
        $msg_count = count($msgs);
    }


?>
<!DOCTYPE html>
<html>
    <head>
  	    <meta charset="utf-8"/>
  	    <link href="css/index.css" type="text/css" rel="stylesheet" />
        <script>function open_win(){window.open('chat.html.php','','width=850,height=630');} </script>
    </head>
    <body>
        <div class="topbanner">
        <?php if(!isset($_SESSION['uid'])){?>
            <div class="sign_up"><a href="sign_in.html.php">Sign-in</a></div>
            <div class="sign_in"><a href="sign_up.html.php">Sign-up</a></div>
        <?php  }?>
        <?php if(isset($_SESSION['uid'])){?>
            <div class="mypage"><a href="userpage.php?action=my_goods">My page</a> || <a href="log_out.php">Log out</a></div>
            <div class="hello">Hello,<?= $_SESSION['nickname'] ?>!</div>
            <div id="msgs"><a href="javascript:open_win()"><img src="images/index.png"></a>(<?=$msg_count ?>)</div>                           
        <?php  }?>
            <div class="wel">Welcome to eSwap</div>
        

        </div>
        <div class="all">
        	<div class="typelist">
                <ul>
                    <li><a href="index.php?type=all">ALL</a></li><li ><a href="index.php?type=games">GAMES</a></li><li ><a href="index.php?type=books">BOOKS</a></li><li ><a href="index.php?type=digitals">DIGITALS</a></li><li ><a href="index.php?type=clothing">CLOTHING</a></li><li><a href="index.php?type=others">OTHERS</a></li>
                </ul>
            </div>
            <div class="content">
                <?php foreach ($goods as $agoods) {
                    $imgs = explode(';', $agoods['imgs']);
                    $time = substr($agoods['createtime'],0,10)
                ?>
                <div class="tradebox">                               
                    <div class="images" >
                        <a href="goods_detail.php?gid=<?= $agoods['gid'] ?>"><img src="<?=$imgs[0] ?>" style="position:relative;left:-100px;"></a> 
                    </div>
                    <div class="sta">
                        Rate of newness: <?= $agoods['status'] ?>
                    </div>
                    <div class="wts">
                        Want to swap: <?= $agoods['wts'] ?>
                    </div>
                    <div class="date">
                        Create time: <?= $time ?>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </body>
</html>