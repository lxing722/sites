<?php

session_start();
session_destroy();
header("Location:index.php?type=all");

?>