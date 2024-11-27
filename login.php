<?php
session_start();

$valid_username = "uzair";
$valid_password = "12345";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {

        $_SESSION['username'] = $username;
        header("Location: page1.php"); 
        exit();
    } else {

        header("Location: webbas.php");
        exit();
    }
}
?>