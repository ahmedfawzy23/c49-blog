<?php
session_start();
require_once "../inc/conn.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));



    $errors = [];
    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        $errors[] = "All inputs are required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email Format Not Valid";
    }




    if (!empty($errors)) {
        $_SESSION['old'] = $_POST;
        $_SESSION['errors'] = $errors;
        header('location: ../register.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, phone)
            VALUES ('$name', '$email', '$hashedPassword', '$phone')";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $_SESSION['success'] = "User Created Successfully";
        header('location: ../Login.php');
        exit();
    } else {
        $_SESSION['errors'] = ['Add User Failed'];
        header('location: ../register.php');
        exit();
    }
} else {
    header('location: ../register.php');
    exit();
}
