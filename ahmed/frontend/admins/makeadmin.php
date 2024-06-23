<?php

session_start();
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$user->make_admin($_REQUEST["user_id"]);
header("location:home.php?msg=done");