<?php
    include_once 'util/config.php';
    include_once 'util/database.php';
    include_once 'util/function.php';
    session_start();
    $gid = $_GET["gid"];
    if(isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
        $nickname = $_SESSION['nickname'];       
    }
    if (!($conn = db_link())) {
        error("busy server!");
    }
    $sql_goods = "SELECT * FROM goods WHERE gid=$gid";
    $res_goods = db_query($conn, $sql_goods);
    $goods = db_res_arr($res_goods);
    $goods = $goods[0];
    $imgs = explode(";", $goods['imgs']);
    $u_id = $goods['uid'];
    $sql_user = "select * from user where uid=$u_id";
    $res_user = db_query($conn, $sql_user);
    if (!($conn = db_link())) {
        error("busy server.");
    }
    $onwer = db_res_arr($res_user);
    $onwer = $onwer[0]
?>
<!DOCTYPE html>
<html>
    <head>
  	    <meta charset="utf-8"/>
  	    <link href="css/index.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="js/goods_detail.js"></script>
        <script>function open_win(){window.open("chat.html.php?chatter=<?= $onwer['uid']?>",'','width=850,height=630');} </script>
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
        <div class="overall">
        	<div class="goods">
                <div class="big">
                    <img class="bigpic" src="<?=$imgs[0] ?>"/>
                </div>
                <?php foreach ($imgs as $img) {?>
                <div class="small">
                    <img src="<?=$img ?>" onclick="change_img(this.src)" />
                </div>    
                <?php
                } ?>
                <div class="message">
                    <dl>
                        <dt>Want to swap:</dt>
                        <dd> <?= $goods['wts']?></dd>
                        <dt>Description:</dt>
                        <dd> <?= $goods['description']?></dd>
                    </dl>  
                </div>
            </div>
            <div class="info">
                <div class="goodsinfo">
                    <ul>
                        <li><span>Goodsinfo</span></li>
                        <li>Product name: <?= $goods['name']?></li>
                        <li>Buying time: <?= $goods['age']?></li>
                        <li>Rate of newness: <?= $goods['status']?></li>
                    </ul>

                </div>
                <div class="userinfo">
                    <ul>
                        <li><span>Onwerinfo</span></li>
                        <li>Onwer name: <?= $onwer['nickname']?></li>
                        <li>Phone: <?= $onwer['phone']?></li>
                        <li>E-mail: <?= $onwer['email']?></li>
                        <li>City of residence: <?= $onwer['address']?></li>
                <?php 
                if(!isset($_SESSION['uid'])){?>
                        <li><a href="error.php?type=no_login"><span>Contact me</span></a></li><?php } else{?>
                <?php if($uid!=$onwer['uid']){?><li><a href="javascript:open_win()"><span>Contact me</span></a></li><?php }}?>
                    </ul>               
                </div>
            </div>
        </div>
    </body>
</html>