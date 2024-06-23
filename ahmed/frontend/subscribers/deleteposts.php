<?php
session_start();
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$post_id = $_REQUEST["id"];
$user->Delete_post($post_id);
header("location:profile.php?msg=dd");
?>