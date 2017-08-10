<?php
    include_once 'util/database.php';
    include_once 'util/function.php';
    session_start();
    $uid = $_SESSION['uid'];
    $nickname = $_SESSION['nickname'];
    $conn = db_link();
    if (!$conn) {
        error("busy server");
    }
    $sql = "select * from goods where uid='$uid' order by createtime DESC"; 
    $res = db_query($conn, $sql);
    if (db_errno($conn) != 0) {
        error("busy server.");
    }
    $goods = db_res_arr($res);
    $sql = "select * from user where uid='$uid'";
    $res = db_query($conn, $sql);
    $user = db_res_arr($res);
    $user = $user[0];
    if (!isset($_GET['action'])) {
        $action = "my_goods";
    }
    else{
        $action = $_GET["action"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
  	    <meta charset="utf-8"/>
  	    <link href="css/index.css" type="text/css" rel="stylesheet" />
        <link href="css/form.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="js/add_goods.js"></script>
        <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
        <script type="text/javascript" src="js/user_info.js" ></script>
        <script>function open_win(){window.open('chat.html.php','','width=850,height=630');} </script>
    </head>
    <body>
        
        <div class='topbanner'>
            <div class="wel">Welcome <?= $_SESSION['nickname'] ?>!</h1></div>
        </div>

        <div id="all">
        	<div id="typelist1">
                <ul>
                    <li ><a href="userpage.php?action=my_goods">MY GOODS</a></li>
                    <li ><a href="userpage.php?action=add_goods">ADD GOODS</a></li>
                    <li ><a href="userpage.php?action=userinfo">USER INFO</a></li>
                    <li ><a href="userpage.php?action=delete_goods">DELETE GOODS</a></li>
                    <li ><a href="javascript:open_win()">CHAT</a></li>
                    <li ><a href="index.php?type=all">HOME PAGE</a></li>
                    <li ><a href="log_out.php">LOG OUT</a></li>
                </ul>
            </div>
            <div id="content1">
                <?php if($action=="my_goods" or $action=="delete_goods"){
                    foreach ($goods as $agoods) {
                    $imgs = explode(';', $agoods['imgs']);
                    $time = substr($agoods['createtime'],0,10)
                ?>
                <div class="tradebox">                               
                        <div class="images" style="text-align:center;"><a href="goods_detail.php?gid=<?= $agoods['gid'] ?>"><img src="<?=$imgs[0] ?>"/></a></div>
                        <div class="name">
                        Product name: <?= $agoods['name'] ?>
                        </div>
                        <div class="date">
                        Create time: <?= $time ?>
                        </div>
                        <?php if($action=="delete_goods"){?>
                        <div class="delete">
                            <a href="delete_goods.php?gid=<?=$agoods['gid']?>">Delete</a>
                        </div>
                        <?php }?>
                </div>
                <?php }
                }?>
                <?php if($action=="add_goods"){?>
                    <div class="form_style_1">
                        <form enctype="multipart/form-data" class="form_style_1" action="add_goods.php" method="post">
                            <label>Product name:</label><input name="name" type="text" required="required"/><br />
                            <label>Buying time:</label><input name="age" type="text" onFocus="WdatePicker({lang:'en'})" required="required"/><br />
                            <label>Product category:</label><select name="type"><option value="games">Games</option>
                            <option value="books">Books</option>
                            <option value="digitals">Digitals</option>
                            <option value="clothing">Clothing</option>
                            <option value="others">Others</option></select>
                            <label>Rate of newness:</label><input name="status" type="text" required="required"/><br />         
                            <label>Want to swap:</label><input name="wts" type="text" required="required"/><br />
                            <label>Image1:</label><input name="img1" type="file" required="required"/><br />
                            <label>Image2:</label><input name="img2" type="file" /><br />
                            <label>Image3:</label><input name="img3" type="file" /><br />
                            <label>Image4:</label><input name="img4" type="file" /><br />
                            <label>Image5:</label><input name="img5" type="file" /><br /> 
                            <label>Description of it:</label><textarea id="description" name="description" rows="10" cols="55" required="required"></textarea>                  
                        <div class="submit">
                            <input class="button" type="submit" value="Submit" />
                        </div>
                        </form>
                    </div>
                <?php }?>
                <?php if($action=="userinfo"){?>
                    <div class="form_style_1">
                        <form enctype="multipart/form-data" class="form_style" action="edit_user_info.php" method="post">
                        <div id="headimage"><label>Head image:</label><div id="headimg"><img src="<?=($user['headimg'] ? $user['headimg'] : $DEFAULT_HEAD_IMG) ?>"/></div></div><br />
                        <label id="new_img" hidden="hidden">New head image:</label><input type="file" name="new_head_img" hidden="hidden" /><br />
                        <label>Nickname:</label><input type="text" name="nickname" value="<?=$user['nickname'] ?>" required="required" disabled="true" ><br />                      
                        <label>E-mail:</label><input type="text" name="email" value="<?=$user['email'] ?>" required="required" disabled="true"><br />
                        <label>Phone:</label><input type="text" name="phone" value="<?=$user['phone'] ?>" required="required" disabled="true"><br />
                        <label>City of residence:</label><input type="text" name="address" value="<?=$user['address'] ?>" required="required" disabled="true"><br />
                        <div class="submit" >   
                        <input id="submit"type="submit" value="Submit" hidden="hidden"><br />                       
                        </div>  
                        </form>
                        <div class="submit" >
                        <input class="button" type="button" value="Edit" onclick="edit_user_info()">
                        </div>  
                    </div>
                <?php }?>
            </div>
        </div>
    </body>
</html>