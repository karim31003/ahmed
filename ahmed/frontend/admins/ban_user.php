<?php

session_start();
require_once("../../classes.php");
$user = unserialize($_SESSION["user"]);
$user->ban_user($_REQUEST["user_id"]);
header("location:home.php?msg=done");

require_once("../../classes.php");
if (empty($user = unserialize($_SESSION["user"]))) {
    header("location:../../index.php?msg=requird_auth");
}