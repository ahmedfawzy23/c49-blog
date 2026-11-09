<?php
session_start();
require_once "../inc/conn.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));



    $errors = [];
    if (empty($email) || empty($password)) {
        $errors[] = "All inputs are required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email Format Not Valid";
    }

    if (!empty($errors)) {
        $_SESSION['old'] = $_POST;
        $_SESSION['errors'] = $errors;
        header('location: ../login.php');
        exit();
    }

    $sql = "SELECT * from users where email = '$email'";
    $result = mysqli_query($conn, $sql);


    $user = mysqli_fetch_assoc($result);

    if (empty($user) || !password_verify($password, $user['password'])) {
        $_SESSION['errors'] = ['wrong email or password'];
        header('location: ../Login.php');
        exit();
    }

    $_SESSION['is_logged_in'] = true;
    $_SESSION['user'] = $user;

    header('location: ../index.php');
    exit();
} else {
    header('location: ../register.php');
    exit();
}
