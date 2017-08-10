<?php
     error_reporting( E_ALL&~E_NOTICE );
     $login = $_GET["login"];
     $info = file("2doDB/$login/info.txt");
     $firstname = $info[1];
     $notes = glob("2doDB/$login/notes/*");
     $a = count($notes);
     for($i=1;$i<=$a;$i++)
     {
     	$todo[$i] = file("2doDB/$login/notes/$i");
     }
?>     
<!DOCTYPE html>
<html>
  <head>
    <title>2DO</title>
    <meta charset="utf-8" />
    <link href="css/main.css" type="text/css" rel="stylesheet" />
  </head>
<body>
	
	<a id="logout" href="logout.php">
		<input class="button" type="button" value="Logout" />
	</a>
	
	<div id="top_banner">
		<form method="post" action="add_note.php?login=<?=$login?>">
			<div>
				<span class="left"><?=$firstname?>'s <span id="logo">2DO</span> notes</span>
			</div>
			<div class="right">
				<input class="button right" type="submit" value="Add note" title="add a new note"/>
				<input class="right" type="text" name="note_title" />
				<div>Enter the title of your new note here</div>
			</div>
		</form>
	</div>
	
	<div id="content">
	<?php for($i=1;$i<=$a;$i++) {?>
	<form class="list left" action="perform_action.php?login=<?=$login?>" method="post">	
		<input type="hidden" name="todo_id" value="<?=$i?>" />
		<div class="note_title" title="<?=$todo[$i][1]?>"><?=$todo[$i][0]?><input class="button right" type="submit" name="delete_note" value="X" title="delete this note"/>
		</div>
		        <ul>
					<li><span class="todo"></span></li>
					<?php
		            for($j=2;$j<=count($todo[$i]);$j++){ ?>	
					<li><span class="todo"><?=$todo[$i][$j]?></span></li>
					<?php } ?>
				</ul>	    
		<div>
			<input class ='left text_input' type="text" name="new_todo" />
			<input class ='right button' type="submit" name="add_todo" value="+" title="add a todo"/>
		</div>	
	</form>
	<?php } ?>	
</div>
</body>
</html>