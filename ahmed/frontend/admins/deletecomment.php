<?php
session_start();
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$comment_id = $_REQUEST["comment_id"]; 
$user->Delete_comment($comment_id);
header("location:comment.php?msg=done");
?>