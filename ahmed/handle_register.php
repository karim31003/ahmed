<?php
session_start();
$errors = [];
if (empty($_REQUEST["name"])) $errors["name"] = "Name is required";
if (empty($_REQUEST["email"])) $errors["email"] = "Email is required";
if (empty($_REQUEST["phone"])) {
    $errors["phone"] = "Phone is required";
} else {
    $phone = htmlspecialchars(trim($_REQUEST["phone"]));
    if (strlen($phone) != 11 || !ctype_digit($phone)) {
        $errors["phone"] = "Phone must be exactly 11 digits";
    }
}
if (empty($_REQUEST["pw"]) || empty($_REQUEST["pc"])) {
    $errors["pw"] = "Password and Password confirmation is required";
} else if ($_REQUEST["pw"] != $_REQUEST["pc"]) {
    $errors["pc"] = "Password confirmation must be equal to Password";
}

$name = htmlspecialchars(trim($_REQUEST["name"]));
$email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars($_REQUEST["phone"]);
$password = htmlspecialchars($_REQUEST["pw"]);
$password_confirmation = htmlspecialchars($_REQUEST["pc"]);

echo $name;
echo $email;

if (!empty($_REQUEST["email"]) && !filter_var($email, FILTER_SANITIZE_EMAIL)) $errors["email"] = "Email invalid format please add aa@gmail.com";

if (empty($errors)) {
    require_once('classes.php');
    try {
        $rslt = Subscriber::register($name, $email, md5($password), $phone);
        header("location:index.php?msg=sr");
    } catch (\Throwable $th) {
        header("location:register.php?msg=ar");
    }
} else {
    $_SESSION["errors"] = $errors;
    header("location:register.php");
}
