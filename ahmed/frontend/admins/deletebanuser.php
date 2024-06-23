<?php

session_start();
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$user->deleteban_user($_REQUEST["user_id"]);
header("location:unban.php?msg=done");