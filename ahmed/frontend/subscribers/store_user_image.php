<?php
session_start();
require_once('../../classes.php');
$user = unserialize($_SESSION["user"]);
    if(!empty($_FILES["image"]["name"])){
        $imagename = "../../image/users/".$_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"],$imagename);
        $user->update_profile_pic($imagename,$user->id);
        $user->image = $imagename;
        $_SESSION["user"] = serialize($user);
        header("location:profile.php?msg=uius");

    }
    else{
        header("location:profile.php?msg=required_image");
    }
?>