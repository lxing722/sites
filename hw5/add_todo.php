<?php
     $login = $_GET["login"];
     $todo_id = $_GET["todo_id"];
     $new_todo = $_GET["new_todo"];
     file_put_contents("2doDB/$login/notes/$todo_id","\n".$new_todo, FILE_APPEND);
     header("Location: notes.php?login=$login");
?>