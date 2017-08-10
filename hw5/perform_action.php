<?php
    $login = $_GET["login"];
    $todo_id = $_POST["todo_id"];
    $new_todo = $_POST["new_todo"];
	//session_start();
	//include("include/util.php");
	//check();
	//if ( isset($_POST["delete_note"])) {
		//include("delete_note.php");
	//}
	//else {
	      header("Location:add_todo.php?login=$login&todo_id=$todo_id&new_todo=$new_todo");
	//}
	//header("Location: notes.php?login=$login");
?>